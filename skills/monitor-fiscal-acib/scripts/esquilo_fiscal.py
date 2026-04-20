#!/usr/bin/env python3
"""
🐿️ ESQUILO FISCAL - Agente de Apoio
Especialista em processamento de dados financeiros e fiscais
"""

import json
import csv
import os
from datetime import datetime, date
from decimal import Decimal

class EsquiloFiscal:
    """
    Esquilo especializado em:
    1. Processar transações financeiras
    2. Gerar IDs únicos anti-duplicação
    3. Calcular projeções de limites
    4. Emitir alertas fiscais
    5. Gerar relatórios em CSV/JSON
    """
    
    def __init__(self):
        self.data_dir = '/home/master/LAN/RELATORIOS/fiscal'
        self.config_file = f'{self.data_dir}/config_fiscal.json'
        self.transacoes_file = f'{self.data_dir}/transacoes_2026.csv'
        self.ensure_dirs()
        self.load_config()
    
    def ensure_dirs(self):
        os.makedirs(self.data_dir, exist_ok=True)
    
    def load_config(self):
        """Carrega ou cria configuração padrão"""
        if os.path.exists(self.config_file):
            with open(self.config_file, 'r') as f:
                self.config = json.load(f)
        else:
            self.config = {
                'versao': '1.0',
                'ano_base': 2026,
                'contas': {
                    'PJ65': {'nome': 'PJ65 - ABBADE Informática', 'tipo': 'MEI', 'limite': 81000.00, 'documento': '65.384.056/0001-32'},
                    'PJ20': {'nome': 'PJ20 - Segunda PJ', 'tipo': 'MEI', 'limite': 81000.00, 'documento': '20.153.208/0001-58'},
                    'PF': {'nome': 'PF - Acib Abbade', 'tipo': 'PF', 'limite': 28559.70, 'documento': '307.572.858-64'},
                    'ESPOSA': {'nome': 'Conta Esposa - Reserva', 'tipo': 'RESERVA', 'limite': None, 'documento': None}
                },
                'sequencias': {}
            }
            self.save_config()
    
    def save_config(self):
        with open(self.config_file, 'w') as f:
            json.dump(self.config, f, indent=2)
    
    def gerar_id_transacao(self, conta, data_str, tipo):
        """
        Gera ID único no formato: {TIPO}-{CONTA}-{MES}-{ANO}-{SEQUENCIA}
        Exemplo: E-65-04-2026-0001
        """
        data = datetime.strptime(data_str, '%Y-%m-%d')
        mes = data.month
        ano = data.year
        
        # Chave para sequência
        chave = f"{conta}-{ano}-{mes:02d}"
        
        # Buscar próxima sequência
        if chave not in self.config['sequencias']:
            self.config['sequencias'][chave] = 0
        
        self.config['sequencias'][chave] += 1
        sequencia = self.config['sequencias'][chave]
        
        # Salvar config
        self.save_config()
        
        # Gerar ID
        transacao_id = f"{tipo}-{conta}-{mes:02d}-{ano}-{sequencia:04d}"
        return transacao_id
    
    def inserir_transacao(self, conta, data, tipo, valor, descricao=''):
        """
        Insere nova transação garantindo ID único
        """
        # Verificar se já existe transação similar (anti-duplicação)
        if self.transacao_existe(conta, data, valor, descricao):
            print(f"⚠️ Transação duplicada detectada: {conta} {data} R$ {valor}")
            return None
        
        # Gerar ID único
        transacao_id = self.gerar_id_transacao(conta, data, tipo)
        
        # Informações da conta
        info_conta = self.config['contas'][conta]
        
        # Preparar dados
        data_dt = datetime.strptime(data, '%Y-%m-%d')
        
        transacao = {
            'transacao_id': transacao_id,
            'conta': conta,
            'tipo_conta': info_conta['tipo'],
            'documento': info_conta['documento'],
            'data': data,
            'mes': data_dt.month,
            'ano': data_dt.year,
            'tipo_mov': tipo,  # E ou S
            'valor': float(valor),
            'descricao': descricao,
            'origem': 'Manual',
            'timestamp': datetime.now().isoformat()
        }
        
        # Salvar em CSV
        self._salvar_csv(transacao)
        
        print(f"✅ Transação inserida: {transacao_id}")
        return transacao_id
    
    def transacao_existe(self, conta, data, valor, descricao):
        """Verifica se transação similar já existe"""
        if not os.path.exists(self.transacoes_file):
            return False
        
        with open(self.transacoes_file, 'r') as f:
            reader = csv.DictReader(f)
            for row in reader:
                if (row['conta'] == conta and 
                    row['data'] == data and 
                    abs(float(row['valor']) - float(valor)) < 0.01):
                    return True
        return False
    
    def _salvar_csv(self, transacao):
        """Salva transação no arquivo CSV"""
        file_exists = os.path.exists(self.transacoes_file)
        
        with open(self.transacoes_file, 'a', newline='') as f:
            fieldnames = ['transacao_id', 'conta', 'tipo_conta', 'documento', 'data', 
                         'mes', 'ano', 'tipo_mov', 'valor', 'descricao', 'origem', 'timestamp']
            writer = csv.DictWriter(f, fieldnames=fieldnames)
            
            if not file_exists:
                writer.writeheader()
            
            writer.writerow(transacao)
    
    def calcular_totais(self):
        """Calcula totais por conta"""
        totais = {}
        
        for conta in self.config['contas']:
            totais[conta] = {
                'entradas': 0.0,
                'saidas': 0.0,
                'transacoes': 0
            }
        
        if not os.path.exists(self.transacoes_file):
            return totais
        
        with open(self.transacoes_file, 'r') as f:
            reader = csv.DictReader(f)
            for row in reader:
                conta = row['conta']
                valor = float(row['valor'])
                tipo = row['tipo_mov']
                
                if conta in totais:
                    if tipo == 'E':
                        totais[conta]['entradas'] += valor
                    else:
                        totais[conta]['saidas'] += valor
                    totais[conta]['transacoes'] += 1
        
        return totais
    
    def verificar_limites(self):
        """Verifica limites fiscais e emite alertas"""
        totais = self.calcular_totais()
        alertas = []
        
        # MEI (soma PJ65 + PJ20)
        mei_entradas = totais.get('PJ65', {}).get('entradas', 0) + totais.get('PJ20', {}).get('entradas', 0)
        limite_mei = 81000.00
        percentual_mei = (mei_entradas / limite_mei) * 100
        
        # PF
        pf_entradas = totais.get('PF', {}).get('entradas', 0)
        limite_pf = 28559.70
        percentual_pf = (pf_entradas / limite_pf) * 100 if limite_pf > 0 else 0
        
        # Calcular médias mensais restantes
        meses_restantes = 8.5  # Abril metade até Dezembro
        
        resultado = {
            'data_relatorio': datetime.now().isoformat(),
            'mei': {
                'entradas': mei_entradas,
                'limite': limite_mei,
                'percentual': round(percentual_mei, 1),
                'restante': limite_mei - mei_entradas,
                'media_mensal_sugerida': round((limite_mei - mei_entradas) / meses_restantes, 2),
                'status': self._classificar_status(percentual_mei),
                'alerta': self._gerar_mensagem_alerta(percentual_mei, 'MEI')
            },
            'pf': {
                'entradas': pf_entradas,
                'limite': limite_pf,
                'percentual': round(percentual_pf, 1),
                'restante': limite_pf - pf_entradas,
                'media_mensal_sugerida': round((limite_pf - pf_entradas) / meses_restantes, 2),
                'status': self._classificar_status(percentual_pf),
                'alerta': self._gerar_mensagem_alerta(percentual_pf, 'PF')
            },
            'recomendacao': self._recomendar_conta(percentual_mei, percentual_pf)
        }
        
        return resultado
    
    def _classificar_status(self, percentual):
        if percentual >= 95:
            return 'EMERGENCIA'
        elif percentual >= 85:
            return 'CRITICO'
        elif percentual >= 70:
            return 'ATENCAO'
        else:
            return 'NORMAL'
    
    def _gerar_mensagem_alerta(self, percentual, tipo):
        if percentual >= 95:
            return f'🔴 URGENTE: {tipo} esgotado! Use Esposa ou PF'
        elif percentual >= 85:
            return f'🟠 CRÍTICO: {tipo} próximo do limite. Migre vendas grandes.'
        elif percentual >= 70:
            return f'🟡 ATENÇÃO: {tipo} em 70%. Comece a planejar migração.'
        else:
            return f'🟢 NORMAL: {tipo} tranquilo.'
    
    def _recomendar_conta(self, pct_mei, pct_pf):
        if pct_mei >= 95:
            return {'conta': 'ESPOSA', 'motivo': 'MEI esgotado'}
        elif pct_mei >= 85:
            return {'conta': 'PF', 'motivo': 'MEI crítico, usar PF'}
        elif pct_mei >= 70:
            return {'conta': 'PF', 'motivo': 'MEI em atenção, preferir PF'}
        else:
            return {'conta': 'PJ65', 'motivo': 'MEI tranquilo'}
    
    def gerar_dashboard(self):
        """Gera dashboard completo"""
        totais = self.calcular_totais()
        limites = self.verificar_limites()
        
        print("=" * 80)
        print("🐿️  ESQUILO FISCAL - DASHBOARD")
        print(f"Atualizado: {datetime.now().strftime('%d/%m/%Y %H:%M')}")
        print("=" * 80)
        
        print("\n📊 TOTAIS POR CONTA:")
        print("-" * 80)
        for conta, dados in totais.items():
            if dados['transacoes'] > 0:
                print(f"{conta:8s} | Entradas: R$ {dados['entradas']:>12,.2f} | "
                      f"Saídas: R$ {dados['saidas']:>12,.2f} | "
                      f"Trans: {dados['transacoes']:>3d}")
        
        print("\n" + "=" * 80)
        print("MEI (PJ65 + PJ20)")
        print("=" * 80)
        mei = limites['mei']
        print(f"Entradas:     R$ {mei['entradas']:>12,.2f}")
        print(f"Limite:       R$ {mei['limite']:>12,.2f}")
        print(f"Percentual:   {mei['percentual']:>12.1f}%")
        print(f"Restante:     R$ {mei['restante']:>12,.2f}")
        print(f"Status:       {mei['status']:>12s}")
        print(f"Média/Mês:    R$ {mei['media_mensal_sugerida']:>12,.2f}")
        
        print("\n" + "=" * 80)
        print("PF (Isenção IRPF)")
        print("=" * 80)
        pf = limites['pf']
        print(f"Entradas:     R$ {pf['entradas']:>12,.2f}")
        print(f"Limite:       R$ {pf['limite']:>12,.2f}")
        print(f"Percentual:   {pf['percentual']:>12.1f}%")
        print(f"Restante:     R$ {pf['restante']:>12,.2f}")
        print(f"Status:       {pf['status']:>12s}")
        print(f"Média/Mês:    R$ {pf['media_mensal_sugerida']:>12,.2f}")
        
        print("\n" + "=" * 80)
        print("RECOMENDAÇÃO")
        print("=" * 80)
        rec = limites['recomendacao']
        print(f"✅ Use: {rec['conta']}")
        print(f"📋 Motivo: {rec['motivo']}")
        
        print("\n" + "=" * 80)
        
        # Salvar relatório JSON
        relatorio_file = f"{self.data_dir}/relatorio_{datetime.now().strftime('%Y%m%d_%H%M%S')}.json"
        with open(relatorio_file, 'w') as f:
            json.dump({
                'totais': totais,
                'limites': limites,
                'config': self.config
            }, f, indent=2, default=str)
        
        print(f"\n📁 Relatório salvo: {relatorio_file}")
        
        return limites

if __name__ == '__main__':
    esquilo = EsquiloFiscal()
    
    # Teste: Inserir algumas transações de exemplo
    print("🐿️  ESQUILO FISCAL - Teste de Funcionamento\n")
    
    # Verificar se já existe dados
    totais = esquilo.calcular_totais()
    
    if totais.get('PJ65', {}).get('entradas', 0) == 0:
        print("Inserindo transações de exemplo...")
        esquilo.inserir_transacao('PJ65', '2026-02-15', 'E', 210.00, 'Entrada Fevereiro')
        esquilo.inserir_transacao('PJ65', '2026-03-05', 'E', 14708.67, 'Entrada Março')
        esquilo.inserir_transacao('PJ65', '2026-04-10', 'E', 4495.68, 'Entrada Abril')
        esquilo.inserir_transacao('PJ20', '2026-01-20', 'E', 13375.46, 'Entrada Janeiro')
        esquilo.inserir_transacao('PJ20', '2026-02-18', 'E', 9377.86, 'Entrada Fevereiro')
        esquilo.inserir_transacao('PJ20', '2026-03-25', 'E', 506.29, 'Entrada Março')
        esquilo.inserir_transacao('PF', '2026-01-15', 'E', 4268.24, 'Entrada Janeiro')
    
    # Gerar dashboard
    print("\n")
    esquilo.gerar_dashboard()
