#!/usr/bin/env python3
"""
SGN - Processador de Extratos Bancários com Códigos Únicos
Formato: {TIPO}-{CONTA}-{DIRECAO}-{SEQUENCIA}
Exemplo: PJ-65-IN-0001, PF-169-OUT-0001
"""

import os
import csv
import json
import re
from datetime import datetime
from pathlib import Path

# Configuração das contas
CONTAS = {
    '9860801747': {'tipo': 'PJ', 'id': '65', 'nome': 'Nubank PJ65', 'cnpj': '65.384.056/0001-32'},
    '118844303': {'tipo': 'PJ', 'id': '20', 'nome': 'Nubank PJ20', 'cnpj': '20.153.208/0001-58'},
    '169842561': {'tipo': 'PF', 'id': '169', 'nome': 'Nubank PF', 'cpf': '307.572.858-64'},
}

# Arquivo para manter sequência
def get_sequencia(conta_id, direcao):
    """Retorna próximo número sequencial para conta/direção"""
    seq_file = f'/var/www/html/sequences/{conta_id}_{direcao}.seq'
    os.makedirs(os.path.dirname(seq_file), exist_ok=True)
    
    if os.path.exists(seq_file):
        with open(seq_file, 'r') as f:
            ultimo = int(f.read().strip() or 0)
    else:
        ultimo = 0
    
    proximo = ultimo + 1
    with open(seq_file, 'w') as f:
        f.write(str(proximo))
    
    return proximo

def gerar_codigo(conta_info, valor, direcao):
    """Gera código único no formato TIPO-CONTA-DIRECAO-SEQUENCIA"""
    seq = get_sequencia(conta_info['id'], direcao)
    return f"{conta_info['tipo']}-{conta_info['id']}-{direcao}-{seq:04d}"

def identificar_conta(nome_arquivo):
    """Identifica conta pelo nome do arquivo"""
    for conta_num, conta_info in CONTAS.items():
        if conta_num in nome_arquivo:
            return conta_info
    return None

def processar_csv(caminho_arquivo):
    """Processa arquivo CSV do Nubank"""
    transacoes = []
    conta = identificar_conta(os.path.basename(caminho_arquivo))
    
    if not conta:
        print(f"⚠️ Conta não identificada: {caminho_arquivo}")
        return []
    
    print(f"📊 Processando: {conta['nome']} ({conta['tipo']}-{conta['id']})")
    
    try:
        with open(caminho_arquivo, 'r', encoding='utf-8') as f:
            leitor = csv.DictReader(f)
            for linha in leitor:
                data = linha.get('Data', '')
                valor_str = linha.get('Valor', '0').replace('.', '').replace(',', '.')
                valor = float(valor_str)
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
                
                # Gerar código único
                codigo = gerar_codigo(conta, valor, direcao)
                
                transacoes.append({
                    'codigo': codigo,
                    'data': data,
                    'valor': valor_abs,
                    'direcao': direcao,
                    'tipo_mov': tipo_mov,
                    'descricao': descricao,
                    'identificador_original': identificador,
                    'conta': conta,
                    'categoria_sugerida': sugerir_categoria(descricao)
                })
    except Exception as e:
        print(f"❌ Erro ao processar {caminho_arquivo}: {e}")
    
    return transacoes

def sugerir_categoria(descricao):
    """Sugere categoria baseada na descrição"""
    desc_lower = descricao.lower()
    
    categorias = {
        'Aplicação RDB': ['aplicacao rdb'],
        'Resgate RDB': ['resgate rdb'],
        'Fornecedor': ['atual pecas', 'rogerio', 'silvana', 'all pro imports', 'houter'],
        'Transferência Recebida': ['transferencia recebida', 'transferência recebida', 'pix'],
        'Transferência Enviada': ['transferencia enviada', 'transferência enviada'],
        'Crédito em Conta': ['credito em conta', 'crédito em conta'],
        'Investimentos': ['aplicacao', 'investimento'],
        'Material/Técnico': ['editora', 'educacional'],
        'Combustível/Posto': ['auto posto'],
        'Pessoal': ['marcia abbade', 'geovana'],
        'Receita Serviço': ['recebido', 'cliente', 'pagamento']
    }
    
    for cat, palavras in categorias.items():
        if any(p in desc_lower for p in palavras):
            return cat
    
    return 'Outros'

def buscar_extratos(pasta_base):
    """Busca todos os extratos CSV"""
    arquivos = []
    
    if os.path.exists(pasta_base):
        for root, dirs, files in os.walk(pasta_base):
            for file in files:
                if file.endswith('.csv'):
                    arquivos.append(os.path.join(root, file))
    
    return arquivos

def processar_todos_extratos():
    """Processa todos os extratos encontrados"""
    pasta_extratos = '/home/master/LAN/Stark_Output/Emails/Anexos/Financeiro/Nubank'
    arquivos = buscar_extratos(pasta_extratos)
    
    print(f"📁 Encontrados {len(arquivos)} arquivos de extrato")
    print("=" * 60)
    
    todas_transacoes = []
    resumo_por_conta = {}
    
    for arquivo in arquivos:
        transacoes = processar_csv(arquivo)
        todas_transacoes.extend(transacoes)
        
        for t in transacoes:
            conta_nome = t['conta']['nome']
            if conta_nome not in resumo_por_conta:
                resumo_por_conta[conta_nome] = {'entradas': 0, 'saidas': 0, 'total_entrada': 0, 'total_saida': 0}
            
            if t['direcao'] == 'IN':
                resumo_por_conta[conta_nome]['entradas'] += 1
                resumo_por_conta[conta_nome]['total_entrada'] += t['valor']
            else:
                resumo_por_conta[conta_nome]['saidas'] += 1
                resumo_por_conta[conta_nome]['total_saida'] += t['valor']
    
    # Salvar JSON
    os.makedirs('/var/www/html/processed', exist_ok=True)
    os.makedirs('/var/www/html/sequences', exist_ok=True)
    
    resultado = {
        'data_processamento': datetime.now().isoformat(),
        'total_transacoes': len(todas_transacoes),
        'transacoes': todas_transacoes,
        'resumo_por_conta': resumo_por_conta
    }
    
    with open('/var/www/html/processed/extratos_processados.json', 'w', encoding='utf-8') as f:
        json.dump(resultado, f, indent=2, ensure_ascii=False)
    
    # Gerar SQL
    gerar_sql_importacao(todas_transacoes)
    
    # Gerar relatório texto
    gerar_relatorio_txt(todas_transacoes, resumo_por_conta)
    
    return resultado

def gerar_sql_importacao(transacoes):
    """Gera arquivo SQL para importar transações"""
    sql_lines = [
        "-- SGN - Importação de Extratos Bancários",
        "-- Gerado automaticamente",
        f"-- Data: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}",
        "",
        "-- Verifica se tabela tem campo codigo_transacao",
        "ALTER TABLE financeiro.movimentacoes ADD COLUMN IF NOT EXISTS codigo_transacao VARCHAR(20) UNIQUE;",
        "",
        "BEGIN;",
        ""
    ]
    
    for t in transacoes:
        conta_id = t['conta']['id']
        # Mapear ID para ID real do banco
        id_banco = {'65': 1, '20': 2, '169': 3}.get(conta_id, 1)
        
        sql = f"""INSERT INTO financeiro.movimentacoes 
(conta_id, codigo_transacao, data, valor, tipo, descricao, categoria_sugerida, identificador_original, status, origem, created_at)
VALUES (
    {id_banco},
    '{t['codigo']}',
    '{t['data']}',
    {t['valor']:.2f},
    '{t['direcao']}',
    '{t['descricao'].replace("'", "''")}',
    '{t['categoria_sugerida']}',
    '{t['identificador_original']}',
    'pendente',
    'extrato_csv',
    NOW()
)
ON CONFLICT (codigo_transacao) DO UPDATE SET 
    valor = EXCLUDED.valor,
    descricao = EXCLUDED.descricao;"""
        sql_lines.append(sql)
    
    sql_lines.append("")
    sql_lines.append("COMMIT;")
    
    with open('/var/www/html/processed/importar_extratos.sql', 'w') as f:
        f.write('\n'.join(sql_lines))
    
    print(f"✅ SQL gerado: /var/www/html/processed/importar_extratos.sql")

def gerar_relatorio_txt(transacoes, resumo):
    """Gera relatório em formato texto"""
    txt = []
    txt.append("=" * 80)
    txt.append("SGN - RELATÓRIO DE EXTRATOS PROCESSADOS")
    txt.append(f"Data: {datetime.now().strftime('%d/%m/%Y %H:%M:%S')}")
    txt.append("=" * 80)
    txt.append("")
    
    txt.append("RESUMO POR CONTA:")
    txt.append("-" * 80)
    for conta, dados in resumo.items():
        txt.append(f"\n{conta}:")
        txt.append(f"  Entradas (IN):  {dados['entradas']:3d} mov. = R$ {dados['total_entrada']:,.2f}")
        txt.append(f"  Saídas (OUT):   {dados['saidas']:3d} mov. = R$ {dados['total_saida']:,.2f}")
        saldo = dados['total_entrada'] - dados['total_saida']
        txt.append(f"  Saldo:          R$ {saldo:,.2f}")
    
    txt.append("")
    txt.append("=" * 80)
    txt.append("DETALHAMENTO DAS MOVIMENTAÇÕES:")
    txt.append("=" * 80)
    
    # Agrupar por conta
    por_conta = {}
    for t in transacoes:
        conta = t['conta']['nome']
        if conta not in por_conta:
            por_conta[conta] = []
        por_conta[conta].append(t)
    
    for conta, movs in por_conta.items():
        txt.append(f"\n{'='*80}")
        txt.append(f"CONTA: {conta}")
        txt.append(f"{'='*80}")
        txt.append(f"{'Código':<20} {'Data':<12} {'Dir':<6} {'Valor':>12} {'Descrição'}")
        txt.append("-" * 80)
        
        for m in sorted(movs, key=lambda x: x['data']):
            valor_str = f"R$ {m['valor']:,.2f}"
            desc = m['descricao'][:40] + '...' if len(m['descricao']) > 40 else m['descricao']
            txt.append(f"{m['codigo']:<20} {m['data']:<12} {m['direcao']:<6} {valor_str:>12} {desc}")
    
    txt.append("")
    txt.append("=" * 80)
    txt.append(f"TOTAL DE MOVIMENTAÇÕES: {len(transacoes)}")
    txt.append("=" * 80)
    
    with open('/var/www/html/processed/relatorio_extratos.txt', 'w', encoding='utf-8') as f:
        f.write('\n'.join(txt))
    
    print(f"✅ Relatório gerado: /var/www/html/processed/relatorio_extratos.txt")

if __name__ == '__main__':
    print("🚀 SGN - Processador de Extratos Bancários")
    print("Formato de código: TIPO-CONTA-DIRECAO-SEQUENCIA")
    print("Exemplo: PJ-65-IN-0001, PF-169-OUT-0001")
    print("=" * 60)
    
    resultado = processar_todos_extratos()
    
    print("\n" + "=" * 60)
    print("📊 RESUMO DO PROCESSAMENTO:")
    print("=" * 60)
    
    for conta, dados in resultado['resumo_por_conta'].items():
        print(f"\n{conta}:")
        print(f"  Entradas: {dados['entradas']:3d} = R$ {dados['total_entrada']:,.2f}")
        print(f"  Saídas:   {dados['saidas']:3d} = R$ {dados['total_saida']:,.2f}")
    
    print(f"\n📁 Arquivos gerados:")
    print(f"   • /var/www/html/processed/extratos_processados.json")
    print(f"   • /var/www/html/processed/importar_extratos.sql")
    print(f"   • /var/www/html/processed/relatorio_extratos.txt")
    print(f"\n✅ Total: {resultado['total_transacoes']} movimentações processadas")