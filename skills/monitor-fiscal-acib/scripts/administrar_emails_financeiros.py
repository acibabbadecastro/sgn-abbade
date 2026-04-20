#!/usr/bin/env python3
"""
Administrador Financeiro Automático
Verifica emails, classifica, extrai dados e toma decisões
"""

import os
import json
import re
import base64
import csv
import io
from datetime import datetime, timedelta
from collections import defaultdict
import pickle

# Configuração
CONFIG_FILE = '/root/.openclaw/config/admin_financeiro_config.json'
LOG_FILE = '/root/.openclaw/logs/admin_financeiro.log'
EXTRACTS_DIR = '/root/.openclaw/media/inbound'
DATA_DIR = '/home/master/LAN/RELATORIOS/financeiro'

# Categorias de Email
CATEGORIAS = {
    'COBRANCA': ['cobrança', 'boleto', 'vencimento', 'pagamento pendente', 'fatura', 'vencendo'],
    'PAGAMENTO_RECEBIDO': ['pagamento confirmado', 'recebido', 'transferencia recebida', 'pix recebido'],
    'PAGAMENTO_EFETUADO': ['pagamento efetuado', 'transferencia enviada', 'pix enviado', 'debito'],
    'EXTRATO': ['extrato', 'saldo', 'movimentacao', 'transacoes'],
    'NOTIFICACAO_SISTEMA': ['alerta', 'notificacao', 'seguranca', 'acesso'],
    'OFERTA': ['promocao', 'desconto', 'oferta', 'cashback'],
    'IRRELEVANTE': ['newsletter', 'marketing', 'spam']
}

# Prioridades
PRIORIDADES = {
    'ALTA': ['COBRANCA_VENCIDA', 'PAGAMENTO_RECEBIDO_ALTO', 'LIMITE_FISCAL'],
    'MEDIA': ['COBRANCA_PROXIMA', 'EXTRATO_MENSAL', 'PAGAMENTO_RECEBIDO'],
    'BAIXA': ['OFERTA', 'NOTIFICACAO_SISTEMA', 'IRRELEVANTE']
}

class AdministradorFinanceiro:
    def __init__(self):
        self.totais = defaultdict(float)
        self.cobrancas_pendentes = []
        self.pagamentos_recebidos = []
        self.pagamentos_efetuados = []
        self.extratos = []
        self.alertas = []
        
    def log(self, msg):
        timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        log_msg = f"[{timestamp}] {msg}"
        print(log_msg)
        with open(LOG_FILE, 'a') as f:
            f.write(log_msg + '\n')
    
    def classificar_email(self, subject, body, sender):
        """Classifica email baseado em conteúdo"""
        texto = f"{subject} {body} {sender}".lower()
        
        for categoria, keywords in CATEGORIAS.items():
            if any(kw in texto for kw in keywords):
                return categoria
        
        return 'OUTROS'
    
    def extrair_valor(self, texto):
        """Extrai valores monetários do texto"""
        # Padrões: R$ 1.234,56 | R$1234.56 | 1234,56
        padroes = [
            r'R\$\s*([\d\.]+,\d{2})',
            r'R\$\s*([\d,]+\.\d{2})',
            r'R\$\s*(\d+\.?\d*)',
            r'valor(?:\s*de)?\s*R?\$?\s*([\d\.]+,\d{2})'
        ]
        
        for padrao in padroes:
            matches = re.findall(padrao, texto, re.IGNORECASE)
            if matches:
                # Pegar o maior valor (geralmente o total)
                valores = []
                for m in matches:
                    try:
                        v = m.replace('.', '').replace(',', '.')
                        valores.append(float(v))
                    except:
                        continue
                if valores:
                    return max(valores)
        
        return None
    
    def extrair_data(self, texto):
        """Extrai datas do texto"""
        # Padrões: DD/MM/AAAA | DD-MM-AAAA | D de Mês de AAAA
        padroes = [
            r'(\d{1,2})[/\-](\d{1,2})[/\-](\d{4})',
            r'(\d{1,2})\s+de\s+(\w+)\s+de\s+(\d{4})'
        ]
        
        for padrao in padroes:
            match = re.search(padrao, texto)
            if match:
                try:
                    if len(match.groups()) == 3:
                        dia, mes, ano = match.groups()
                        if mes.isdigit():
                            return f"{ano}-{mes.zfill(2)}-{dia.zfill(2)}"
                        else:
                            # Converter nome do mês
                            meses = {
                                'janeiro': '01', 'fevereiro': '02', 'março': '03', 'abril': '04',
                                'maio': '05', 'junho': '06', 'julho': '07', 'agosto': '08',
                                'setembro': '09', 'outubro': '10', 'novembro': '11', 'dezembro': '12'
                            }
                            mes_num = meses.get(mes.lower(), '01')
                            return f"{ano}-{mes_num}-{dia.zfill(2)}"
                except:
                    continue
        
        return None
    
    def identificar_conta_nubank(self, filename, content):
        """Identifica qual conta Nubank (PJ65, PJ20, PF)"""
        texto = f"{filename} {str(content)}".upper()
        
        # Identificadores específicos
        if any(x in texto for x in ['65.384.056', '986080174', 'PJ65', 'ABBADE INFORMATICA']):
            return 'PJ65'
        elif any(x in texto for x in ['20.153.208', '118844303', 'PJ20']):
            return 'PJ20'
        elif any(x in texto for x in ['16984256', '307.572', 'PF', 'ACIB ABBADE']):
            return 'PF'
        
        return 'DESCONHECIDO'
    
    def processar_extrato_csv(self, csv_data, conta):
        """Processa extrato CSV e extrai transações"""
        transacoes = []
        
        try:
            csv_str = csv_data.decode('utf-8-sig')
            delimiter = ';' if conta != 'PF' else ','
            reader = csv.DictReader(io.StringIO(csv_str), delimiter=delimiter)
            
            for row in reader:
                try:
                    data = row.get('Data', '')
                    descricao = row.get('Descrição', '')
                    valor_str = row.get('Valor', '0').replace(',', '.')
                    valor = float(valor_str)
                    
                    transacao = {
                        'data': data,
                        'descricao': descricao,
                        'valor': valor,
                        'tipo': 'ENTRADA' if valor > 0 else 'SAIDA',
                        'conta': conta
                    }
                    
                    transacoes.append(transacao)
                    
                    # Acumular totais
                    if conta in ['PJ65', 'PJ20']:
                        if valor > 0:
                            self.totais['MEI_ENTRADAS'] += valor
                        else:
                            self.totais['MEI_SAIDAS'] += abs(valor)
                    elif conta == 'PF':
                        if valor > 0:
                            self.totais['PF_ENTRADAS'] += valor
                        else:
                            self.totais['PF_SAIDAS'] += abs(valor)
                            
                except Exception as e:
                    continue
                    
        except Exception as e:
            self.log(f"Erro ao processar CSV: {e}")
        
        return transacoes
    
    def verificar_limites_fiscais(self):
        """Verifica se está próximo dos limites fiscais"""
        alertas = []
        
        # Limite MEI
        mei_total = self.totais['MEI_ENTRADAS']
        limite_mei = 81000.00
        percentual_mei = (mei_total / limite_mei) * 100
        
        if percentual_mei >= 95:
            alertas.append({
                'nivel': '🔴 EMERGÊNCIA',
                'tipo': 'MEI_LIMITE',
                'mensagem': f'MEI atingiu {percentual_mei:.1f}% do limite! MIGRAR PARA ESPOSA/PF!',
                'percentual': percentual_mei,
                'restante': limite_mei - mei_total
            })
        elif percentual_mei >= 85:
            alertas.append({
                'nivel': '🟠 CRÍTICO',
                'tipo': 'MEI_LIMITE',
                'mensagem': f'MEI em {percentual_mei:.1f}% do limite. Começar migração.',
                'percentual': percentual_mei
            })
        elif percentual_mei >= 70:
            alertas.append({
                'nivel': '🟡 ATENÇÃO',
                'tipo': 'MEI_LIMITE',
                'mensagem': f'MEI em {percentual_mei:.1f}%. Planejar migração.',
                'percentual': percentual_mei
            })
        
        # Limite IRPF
        pf_total = self.totais['PF_ENTRADAS']
        limite_irpf = 28559.70
        percentual_irpf = (pf_total / limite_irpf) * 100
        
        if percentual_irpf >= 95:
            alertas.append({
                'nivel': '🔴 EMERGÊNCIA',
                'tipo': 'IRPF_LIMITE',
                'mensagem': f'PF atingiu {percentual_irpf:.1f}% do limite de isenção!',
                'percentual': percentual_irpf
            })
        
        self.alertas = alertas
        return alertas
    
    def sugerir_conta_recebimento(self, valor):
        """Sugere qual conta usar para receber pagamento"""
        mei_total = self.totais['MEI_ENTRADAS']
        limite_mei = 81000.00
        percentual_mei = (mei_total / limite_mei) * 100
        
        pf_total = self.totais['PF_ENTRADAS']
        limite_irpf = 28559.70
        percentual_irpf = (pf_total / limite_irpf) * 100
        
        # Lógica de decisão
        if percentual_mei >= 95:
            return {
                'conta': 'ESPOSA (URGENTE)',
                'motivo': 'MEI esgotado',
                'prioridade': 'ALTA'
            }
        elif percentual_mei >= 85:
            if valor > 1000:
                return {
                    'conta': 'PF',
                    'motivo': 'MEI crítico, valor alto vai para PF',
                    'prioridade': 'ALTA'
                }
            else:
                return {
                    'conta': 'PJ65/PJ20',
                    'motivo': 'Valor pequeno, ainda aceitável no MEI',
                    'prioridade': 'MEDIA'
                }
        elif percentual_mei >= 70:
            return {
                'conta': 'PF (preferencial)',
                'motivo': 'MEI em atenção, migrar gradualmente',
                'prioridade': 'MEDIA'
            }
        else:
            return {
                'conta': 'PJ65 (preferencial)',
                'motivo': 'MEI tranquilo',
                'prioridade': 'NORMAL'
            }
    
    def gerar_relatorio(self):
        """Gera relatório completo"""
        relatorio = {
            'timestamp': datetime.now().isoformat(),
            'resumo': {
                'mei_entradas': self.totais['MEI_ENTRADAS'],
                'mei_saidas': self.totais['MEI_SAIDAS'],
                'pf_entradas': self.totais['PF_ENTRADAS'],
                'pf_saidas': self.totais['PF_SAIDAS']
            },
            'limites': {
                'mei_percentual': (self.totais['MEI_ENTRADAS'] / 81000.00) * 100,
                'irpf_percentual': (self.totais['PF_ENTRADAS'] / 28559.70) * 100
            },
            'cobrancas_pendentes': self.cobrancas_pendentes,
            'pagamentos_recebidos': self.pagamentos_recebidos[-10:],  # últimos 10
            'pagamentos_efetuados': self.pagamentos_efetuados[-10:],
            'alertas': self.alertas,
            'recomendacao': self.sugerir_conta_recebimento(1000)
        }
        
        # Salvar relatório
        os.makedirs(DATA_DIR, exist_ok=True)
        report_file = f"{DATA_DIR}/relatorio_{datetime.now().strftime('%Y%m%d_%H%M%S')}.json"
        
        with open(report_file, 'w') as f:
            json.dump(relatorio, f, indent=2, default=str)
        
        self.log(f"✅ Relatório salvo: {report_file}")
        return relatorio
    
    def executar_rotina_completa(self):
        """Executa rotina completa de verificação"""
        self.log("="*60)
        self.log("ADMINISTRADOR FINANCEIRO - ROTINA COMPLETA")
        self.log("="*60)
        
        # 1. Verificar emails (simulado - integrar com Gmail API)
        self.log("\n📧 [1/4] Verificando emails...")
        # Aqui integraria com Gmail API para buscar emails novos
        
        # 2. Processar extratos existentes
        self.log("\n📊 [2/4] Processando extratos...")
        for arquivo in os.listdir(EXTRACTS_DIR):
            if arquivo.endswith('.csv'):
                conta = self.identificar_conta_nubank(arquivo, '')
                if conta != 'DESCONHECIDO':
                    with open(os.path.join(EXTRACTS_DIR, arquivo), 'rb') as f:
                        csv_data = f.read()
                    transacoes = self.processar_extrato_csv(csv_data, conta)
                    self.log(f"  ✅ {conta}: {len(transacoes)} transações processadas")
        
        # 3. Verificar limites
        self.log("\n🚨 [3/4] Verificando limites fiscais...")
        alertas = self.verificar_limites_fiscais()
        
        if alertas:
            for alerta in alertas:
                self.log(f"  {alerta['nivel']}: {alerta['mensagem']}")
        else:
            self.log("  🟢 Todos os limites normais")
        
        # 4. Gerar recomendações
        self.log("\n💡 [4/4] Gerando recomendações...")
        recomendacao = self.sugerir_conta_recebimento(1000)
        self.log(f"  Conta sugerida: {recomendacao['conta']}")
        self.log(f"  Motivo: {recomendacao['motivo']}")
        
        # 5. Gerar relatório
        relatorio = self.gerar_relatorio()
        
        self.log("\n" + "="*60)
        self.log("ROTINA CONCLUÍDA")
        self.log("="*60)
        
        return relatorio

if __name__ == '__main__':
    admin = AdministradorFinanceiro()
    resultado = admin.executar_rotina_completa()
    print("\n" + json.dumps(resultado, indent=2, default=str))
