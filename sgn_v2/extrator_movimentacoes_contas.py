#!/usr/bin/env python3
"""
SGN - Extrator de Movimentações por Conta Bancária
Separa extratos e cria dados organizados por conta
"""

import os
import csv
import json
from datetime import datetime
from collections import defaultdict

# Configuração das contas
CONTAS_CONFIG = {
    '9860801747': {
        'id': 1,
        'tipo': 'PJ',
        'nome': 'Nubank PJ65',
        'documento': '65.384.056/0001-32',
        'descricao': 'ABBADE Informatica'
    },
    '118844303': {
        'id': 2,
        'tipo': 'PJ', 
        'nome': 'Nubank PJ20',
        'documento': '20.153.208/0001-58',
        'descricao': 'ABBADE Tecnologies'
    },
    '169842561': {
        'id': 3,
        'tipo': 'PF',
        'nome': 'Nubank PF',
        'documento': '307.572.858-64',
        'descricao': 'ACIB ABBADE DE CASTRO'
    }
}

class ExtratorContas:
    def __init__(self):
        self.movimentacoes_por_conta = defaultdict(list)
        self.resumo_por_conta = {}
        self.sequencias = {'PJ65_IN': 0, 'PJ65_OUT': 0, 'PJ20_IN': 0, 'PJ20_OUT': 0, 'PF_IN': 0, 'PF_OUT': 0}
        
    def identificar_conta(self, nome_arquivo):
        """Identifica qual conta pelo nome do arquivo"""
        for num_conta, config in CONTAS_CONFIG.items():
            if num_conta in nome_arquivo:
                return config
        return None
    
    def gerar_codigo(self, conta, direcao):
        """Gera código sequencial"""
        if conta['id'] == 1:
            prefixo = 'PJ65'
        elif conta['id'] == 2:
            prefixo = 'PJ20'
        else:
            prefixo = 'PF'
        
        chave = f"{prefixo}_{direcao}"
        self.sequencias[chave] += 1
        seq = self.sequencias[chave]
        
        return f"{prefixo}-{direcao}-{seq:05d}"
    
    def processar_csv(self, caminho_arquivo):
        """Processa arquivo CSV"""
        conta = self.identificar_conta(os.path.basename(caminho_arquivo))
        if not conta:
            return []
        
        movimentacoes = []
        
        try:
            with open(caminho_arquivo, 'r', encoding='utf-8') as f:
                leitor = csv.DictReader(f)
                for linha in leitor:
                    data = linha.get('Data', '')
                    valor_str = linha.get('Valor', '0').replace('.', '').replace(',', '.')
                    try:
                        valor = float(valor_str)
                    except:
                        valor = 0.0
                    
                    descricao = linha.get('Descrição', linha.get('Descriçao', ''))
                    identificador = linha.get('Identificador', '')
                    
                    # Determinar direção
                    if valor > 0:
                        direcao = 'IN'
                        tipo_mov = 'ENTRADA'
                    else:
                        direcao = 'OUT'
                        tipo_mov = 'SAIDA'
                    
                    valor_abs = abs(valor)
                    codigo = self.gerar_codigo(conta, direcao)
                    
                    mov = {
                        'codigo': codigo,
                        'conta_id': conta['id'],
                        'conta_nome': conta['nome'],
                        'data': self.converter_data(data),
                        'data_original': data,
                        'valor': valor_abs,
                        'direcao': direcao,
                        'tipo': tipo_mov,
                        'descricao': descricao,
                        'identificador_original': identificador,
                        'categoria': self.classificar_descricao(descricao)
                    }
                    
                    movimentacoes.append(mov)
                    self.movimentacoes_por_conta[conta['nome']].append(mov)
                    
        except Exception as e:
            print(f"Erro em {caminho_arquivo}: {e}")
        
        return movimentacoes
    
    def converter_data(self, data_str):
        """Converte data DD/MM/YYYY para YYYY-MM-DD"""
        try:
            return datetime.strptime(data_str, '%d/%m/%Y').strftime('%Y-%m-%d')
        except:
            return data_str
    
    def classificar_descricao(self, descricao):
        """Classifica a movimentação"""
        desc_lower = descricao.lower()
        
        if any(x in desc_lower for x in ['aplicacao', 'aplicação', 'investimento', 'rdb']):
            return 'INVESTIMENTO'
        elif any(x in desc_lower for x in ['resgate']):
            return 'RESGATE'
        elif any(x in desc_lower for x in ['transferencia recebida', 'transferência recebida', 'pix recebido']):
            return 'TRANSFERENCIA_ENTRADA'
        elif any(x in desc_lower for x in ['transferencia enviada', 'transferência enviada', 'pix enviado']):
            return 'TRANSFERENCIA_SAIDA'
        elif any(x in desc_lower for x in ['credito em conta', 'crédito em conta']):
            return 'CREDITO'
        elif any(x in desc_lower for x in ['rogerio', 'atual pecas', 'silvana', 'fornecedor']):
            return 'FORNECEDOR'
        elif any(x in desc_lower for x in ['cliente', 'pagamento', 'recebido']):
            return 'RECEITA'
        else:
            return 'OUTROS'
    
    def calcular_resumo(self):
        """Calcula resumo por conta"""
        for conta_nome, movs in self.movimentacoes_por_conta.items():
            entradas = [m for m in movs if m['direcao'] == 'IN']
            saidas = [m for m in movs if m['direcao'] == 'OUT']
            
            total_entrada = sum(m['valor'] for m in entradas)
            total_saida = sum(m['valor'] for m in saidas)
            
            self.resumo_por_conta[conta_nome] = {
                'total_movimentacoes': len(movs),
                'entradas': len(entradas),
                'saidas': len(saidas),
                'total_entrada': total_entrada,
                'total_saida': total_saida,
                'saldo': total_entrada - total_saida
            }
    
    def gerar_sql_contas(self):
        """Gera SQL para criar tabela e inserir dados"""
        sql = []
        
        # Criar tabela se não existir
        sql.append("-- SGN - Tabela de Movimentações por Conta")
        sql.append("CREATE TABLE IF NOT EXISTS financeiro.movimentacoes_extrato (")
        sql.append("    id SERIAL PRIMARY KEY,")
        sql.append("    codigo VARCHAR(20) UNIQUE NOT NULL,")
        sql.append("    conta_id INTEGER REFERENCES financeiro.contas_bancarias(id),")
        sql.append("    data DATE NOT NULL,")
        sql.append("    valor DECIMAL(15,2) NOT NULL,")
        sql.append("    direcao VARCHAR(10) CHECK (direcao IN ('IN', 'OUT')),")
        sql.append("    tipo VARCHAR(50),")
        sql.append("    categoria VARCHAR(50),")
        sql.append("    descricao TEXT,")
        sql.append("    identificador_original VARCHAR(100),")
        sql.append("    processado BOOLEAN DEFAULT false,")
        sql.append("    created_at TIMESTAMP DEFAULT NOW()")
        sql.append(");")
        sql.append("")
        sql.append("-- Índices para performance")
        sql.append("CREATE INDEX IF NOT EXISTS idx_mov_extrato_conta ON financeiro.movimentacoes_extrato(conta_id);")
        sql.append("CREATE INDEX IF NOT EXISTS idx_mov_extrato_data ON financeiro.movimentacoes_extrato(data);")
        sql.append("CREATE INDEX IF NOT EXISTS idx_mov_extrato_codigo ON financeiro.movimentacoes_extrato(codigo);")
        sql.append("")
        sql.append("-- Inserir movimentações")
        sql.append("BEGIN;")
        sql.append("")
        
        for conta_nome, movs in self.movimentacoes_por_conta.items():
            sql.append(f"-- {conta_nome} ({len(movs)} movimentações)")
            
            for m in movs:
                desc_escaped = m['descricao'].replace("'", "''")
                sql.append(f"""INSERT INTO financeiro.movimentacoes_extrato 
(codigo, conta_id, data, valor, direcao, tipo, categoria, descricao, identificador_original)
VALUES ('{m['codigo']}', {m['conta_id']}, '{m['data']}', {m['valor']:.2f}, '{m['direcao']}', 
'{m['tipo']}', '{m['categoria']}', '{desc_escaped}', '{m['identificador_original']}')
ON CONFLICT (codigo) DO UPDATE SET
    valor = EXCLUDED.valor,
    descricao = EXCLUDED.descricao;""")
            sql.append("")
        
        sql.append("COMMIT;")
        
        return '\n'.join(sql)
    
    def gerar_json_por_conta(self):
        """Gera JSON separado por conta"""
        dados = {}
        
        for conta_nome, movs in self.movimentacoes_por_conta.items():
            # Nome seguro para arquivo
            nome_arquivo = conta_nome.replace(' ', '_').lower()
            
            dados[nome_arquivo] = {
                'conta': conta_nome,
                'total_movimentacoes': len(movs),
                'resumo': self.resumo_por_conta.get(conta_nome, {}),
                'movimentacoes': sorted(movs, key=lambda x: x['data'])
            }
        
        return dados
    
    def gerar_relatorio(self):
        """Gera relatório em texto"""
        linhas = []
        linhas.append("=" * 100)
        linhas.append("SGN - MOVIMENTAÇÕES POR CONTA BANCÁRIA")
        linhas.append(f"Gerado em: {datetime.now().strftime('%d/%m/%Y %H:%M:%S')}")
        linhas.append("=" * 100)
        linhas.append("")
        
        # Resumo geral
        total_geral = sum(r['total_movimentacoes'] for r in self.resumo_por_conta.values())
        linhas.append(f"TOTAL GERAL: {total_geral} movimentações")
        linhas.append("")
        
        # Por conta
        for conta_nome, resumo in self.resumo_por_conta.items():
            linhas.append("=" * 100)
            linhas.append(f"CONTA: {conta_nome}")
            linhas.append("=" * 100)
            linhas.append(f"Total de movimentações: {resumo['total_movimentacoes']}")
            linhas.append(f"Entradas (IN):  {resumo['entradas']:3d} - R$ {resumo['total_entrada']:>15,.2f}")
            linhas.append(f"Saídas (OUT):   {resumo['saidas']:3d} - R$ {resumo['total_saida']:>15,.2f}")
            linhas.append(f"SALDO:                   R$ {resumo['saldo']:>15,.2f}")
            linhas.append("")
            
            # Top categorias
            movs = self.movimentacoes_por_conta[conta_nome]
            categorias = defaultdict(lambda: {'quantidade': 0, 'valor': 0})
            for m in movs:
                cat = m['categoria']
                categorias[cat]['quantidade'] += 1
                categorias[cat]['valor'] += m['valor']
            
            linhas.append("Por Categoria:")
            for cat, dados in sorted(categorias.items(), key=lambda x: x[1]['valor'], reverse=True):
                linhas.append(f"  {cat:25s}: {dados['quantidade']:3d} mov. - R$ {dados['valor']:>12,.2f}")
            
            linhas.append("")
            linhas.append("Detalhamento:")
            linhas.append("-" * 100)
            linhas.append(f"{'Código':<18} {'Data':<12} {'Dir':<5} {'Valor':>14} {'Categoria':<20} {'Descrição'}")
            linhas.append("-" * 100)
            
            for m in sorted(movs, key=lambda x: x['data']):
                desc_curta = m['descricao'][:40] + '...' if len(m['descricao']) > 40 else m['descricao']
                linhas.append(f"{m['codigo']:<18} {m['data']:<12} {m['direcao']:<5} R$ {m['valor']:>10,.2f} {m['categoria']:<20} {desc_curta}")
            
            linhas.append("")
        
        return '\n'.join(linhas)
    
    def processar_todos(self, pasta_base):
        """Processa todos os extratos"""
        print("🔍 Buscando extratos...")
        
        arquivos = []
        for root, dirs, files in os.walk(pasta_base):
            for file in files:
                if file.endswith('.csv'):
                    arquivos.append(os.path.join(root, file))
        
        print(f"📁 Encontrados {len(arquivos)} arquivos CSV")
        
        for arquivo in arquivos:
            conta = self.identificar_conta(os.path.basename(arquivo))
            if conta:
                print(f"  📊 Processando: {conta['nome']}")
                self.processar_csv(arquivo)
        
        self.calcular_resumo()
        
        # Gerar saídas
        os.makedirs('/var/www/html/processed/contas', exist_ok=True)
        
        # JSON por conta
        json_por_conta = self.gerar_json_por_conta()
        for nome, dados in json_por_conta.items():
            with open(f'/var/www/html/processed/contas/{nome}.json', 'w', encoding='utf-8') as f:
                json.dump(dados, f, indent=2, ensure_ascii=False, default=str)
        
        # SQL
        with open('/var/www/html/processed/contas/criar_tabelas_movimentacoes.sql', 'w') as f:
            f.write(self.gerar_sql_contas())
        
        # Relatório
        with open('/var/www/html/processed/contas/relatorio_completo.txt', 'w', encoding='utf-8') as f:
            f.write(self.gerar_relatorio())
        
        return {
            'total_arquivos': len(arquivos),
            'total_movimentacoes': sum(len(m) for m in self.movimentacoes_por_conta.values()),
            'por_conta': self.resumo_por_conta,
            'arquivos_gerados': [
                '/var/www/html/processed/contas/*.json',
                '/var/www/html/processed/contas/criar_tabelas_movimentacoes.sql',
                '/var/www/html/processed/contas/relatorio_completo.txt'
            ]
        }

if __name__ == '__main__':
    extrator = ExtratorContas()
    
    pasta_extratos = '/home/master/LAN/Stark_Output/Emails/Anexos/Financeiro/Nubank'
    resultado = extrator.processar_todos(pasta_extratos)
    
    print("\n" + "=" * 60)
    print("✅ PROCESSAMENTO CONCLUÍDO")
    print("=" * 60)
    print(f"\n📊 Resumo:")
    print(f"   Arquivos processados: {resultado['total_arquivos']}")
    print(f"   Total movimentações: {resultado['total_movimentacoes']}")
    print(f"\n🏦 Por Conta:")
    
    for conta, resumo in resultado['por_conta'].items():
        print(f"\n   {conta}:")
        print(f"      Entradas: {resumo['entradas']:3d} = R$ {resumo['total_entrada']:,.2f}")
        print(f"      Saídas:   {resumo['saidas']:3d} = R$ {resumo['total_saida']:,.2f}")
        print(f"      Saldo:    R$ {resumo['saldo']:,.2f}")
    
    print(f"\n📁 Arquivos gerados em: /var/www/html/processed/contas/")
    print("   • [conta].json - Dados JSON por conta")
    print("   • criar_tabelas_movimentacoes.sql - SQL para PostgreSQL")
    print("   • relatorio_completo.txt - Relatório em texto")