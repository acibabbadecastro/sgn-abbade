#!/usr/bin/env python3
"""
SGN - Processador de Extratos Bancários
Busca extratos em /home/master/LAN, processa e gera códigos únicos
"""

import os
import csv
import json
import hashlib
from datetime import datetime
from pathlib import Path

# Configuração
CONFIG = {
    'pastas_extratos': [
        '/home/master/LAN/Stark_Output/Emails/Anexos/Financeiro',
        '/mnt/data/LAN/Emails/Anexos/Financeiro',
    ],
    'extensoes': ['.csv', '.ofx', '.xlsx'],
    'output_dir': '/var/www/html/processed',
    'codigo_prefixo': 'TRX'
}

def gerar_codigo(data, valor, descricao, conta):
    """Gera código único para transação"""
    # Hash único baseado nos dados
    texto = f"{data}|{valor}|{descricao}|{conta}|{datetime.now().timestamp()}"
    hash_short = hashlib.md5(texto.encode()).hexdigest()[:8].upper()
    return f"{CONFIG['codigo_prefixo']}-{hash_short}"

def identificar_conta(nome_arquivo):
    """Identifica conta bancária pelo nome do arquivo"""
    # Padrões: NU_9860801747, NU_118844303, NU_169842561
    if '9860801747' in nome_arquivo:
        return {'id': 1, 'apelido': 'Nubank PJ65', 'tipo': 'PJ', 'cnpj': '65.384.056/0001-32'}
    elif '118844303' in nome_arquivo:
        return {'id': 2, 'apelido': 'Nubank PJ20', 'tipo': 'PJ', 'cnpj': '20.153.208/0001-58'}
    elif '169842561' in nome_arquivo:
        return {'id': 3, 'apelido': 'Nubank PF', 'tipo': 'PF', 'cpf': '307.572.858-64'}
    return None

def processar_csv(caminho_arquivo):
    """Processa arquivo CSV do Nubank"""
    transacoes = []
    conta = identificar_conta(os.path.basename(caminho_arquivo))
    
    if not conta:
        return []
    
    try:
        with open(caminho_arquivo, 'r', encoding='utf-8') as f:
            leitor = csv.DictReader(f)
            for linha in leitor:
                data = linha.get('Data', '')
                valor = float(linha.get('Valor', '0').replace(',', '.'))
                descricao = linha.get('Descrição', linha.get('Descriçao', ''))
                identificador = linha.get('Identificador', '')
                
                # Determinar tipo
                tipo = 'receita' if valor > 0 else 'despesa'
                valor_abs = abs(valor)
                
                # Gerar código único
                codigo = gerar_codigo(data, valor, descricao, conta['apelido'])
                
                transacoes.append({
                    'codigo': codigo,
                    'data': data,
                    'valor': valor_abs,
                    'tipo': tipo,
                    'descricao': descricao,
                    'identificador': identificador,
                    'conta': conta,
                    'categoria_sugerida': sugerir_categoria(descricao)
                })
    except Exception as e:
        print(f"Erro ao processar {caminho_arquivo}: {e}")
    
    return transacoes

def sugerir_categoria(descricao):
    """Sugere categoria baseada na descrição"""
    desc_lower = descricao.lower()
    
    categorias = {
        'salario': ['salario', 'pagamento'],
        'fornecedor': ['atual pecas', 'rogerio', 'silvana', 'all pro imports'],
        'transporte': ['uber', '99', 'taxi', 'combustivel'],
        'alimentacao': ['restaurante', 'mercado', 'ifood', 'rappi'],
        'servicos': ['internet', 'telefone', 'luz', 'agua'],
        'impostos': ['imposto', 'taxa', 'darf', 'gps'],
        'investimentos': ['aplicacao', 'investimento', 'rdb']
    }
    
    for cat, palavras in categorias.items():
        if any(p in desc_lower for p in palavras):
            return cat
    
    return 'outros'

def buscar_extratos():
    """Busca todos os extratos nas pastas configuradas"""
    arquivos = []
    
    for pasta in CONFIG['pastas_extratos']:
        if os.path.exists(pasta):
            for root, dirs, files in os.walk(pasta):
                for file in files:
                    if any(file.endswith(ext) for ext in CONFIG['extensoes']):
                        arquivos.append(os.path.join(root, file))
    
    return arquivos

def processar_todos_extratos():
    """Processa todos os extratos encontrados"""
    arquivos = buscar_extratos()
    todas_transacoes = []
    
    print(f"📁 Encontrados {len(arquivos)} arquivos de extrato")
    
    for arquivo in arquivos:
        print(f"🔄 Processando: {os.path.basename(arquivo)}")
        
        if arquivo.endswith('.csv'):
            transacoes = processar_csv(arquivo)
            todas_transacoes.extend(transacoes)
    
    # Agrupar por conta
    por_conta = {}
    for t in todas_transacoes:
        conta_nome = t['conta']['apelido']
        if conta_nome not in por_conta:
            por_conta[conta_nome] = []
        por_conta[conta_nome].append(t)
    
    # Salvar resultado
    os.makedirs(CONFIG['output_dir'], exist_ok=True)
    
    resultado = {
        'data_processamento': datetime.now().isoformat(),
        'total_transacoes': len(todas_transacoes),
        'por_conta': por_conta
    }
    
    with open(f"{CONFIG['output_dir']}/extratos_processados.json", 'w') as f:
        json.dump(resultado, f, indent=2, ensure_ascii=False)
    
    # Gerar SQL para importação
    gerar_sql_importacao(todas_transacoes)
    
    return resultado

def gerar_sql_importacao(transacoes):
    """Gera arquivo SQL para importar transações"""
    sql_lines = ["-- SGN - Importação de Extratos", "-- Gerado automaticamente", ""]
    
    for t in transacoes:
        sql = f"""
INSERT INTO financeiro.movimentacoes 
(codigo_transacao, conta_id, data, valor, tipo, descricao, origem, status, created_at)
VALUES (
    '{t['codigo']}',
    {t['conta']['id']},
    '{t['data']}',
    {t['valor']},
    '{t['tipo']}',
    '{t['descricao'].replace("'", "''")}',
    'extrato_csv',
    'pendente',
    NOW()
)
ON CONFLICT (codigo_transacao) DO NOTHING;
"""
        sql_lines.append(sql)
    
    with open(f"{CONFIG['output_dir']}/importar_extratos.sql", 'w') as f:
        f.write('\n'.join(sql_lines))
    
    print(f"✅ SQL gerado: {CONFIG['output_dir']}/importar_extratos.sql")

if __name__ == '__main__':
    print("🚀 SGN - Processador de Extratos Bancários")
    print("=" * 50)
    
    resultado = processar_todos_extratos()
    
    print("\n📊 Resumo:")
    print(f"   Total de transações: {resultado['total_transacoes']}")
    for conta, trans in resultado['por_conta'].items():
        print(f"   {conta}: {len(trans)} transações")
    
    print(f"\n📁 Arquivos gerados em: {CONFIG['output_dir']}/")
    print("   - extratos_processados.json")
    print("   - importar_extratos.sql")