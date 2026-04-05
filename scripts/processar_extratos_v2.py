#!/usr/bin/env python3
"""
SGN - Processador de Extratos Bancários com Códigos Únicos
Template de configuração - COPIE e preencha com seus dados
"""

import os
import csv
import json
import hashlib
from datetime import datetime

# ⚠️ CONFIGURAÇÃO: Preencha com seus dados
CONTAS_CONFIG = {
    # Número da conta: {tipo, id, nome, documento}
    'SUA_CONTA_1': {
        'id': 1,
        'tipo': 'PJ',
        'nome': 'Conta PJ Principal',
        'documento': 'XX.XXX.XXX/0001-XX'
    },
    'SUA_CONTA_2': {
        'id': 2,
        'tipo': 'PJ',
        'nome': 'Conta PJ Secundária', 
        'documento': 'XX.XXX.XXX/0001-XX'
    },
    'SUA_CONTA_3': {
        'id': 3,
        'tipo': 'PF',
        'nome': 'Conta Pessoal',
        'documento': 'XXX.XXX.XXX-XX'
    },
}

# Diretório de extratos
PASTA_EXTRATOS = '/caminho/para/seus/extratos'

class ProcessadorExtratos:
    def __init__(self):
        self.sequencias = {}
        
    def gerar_codigo(self, conta_info, direcao):
        """Gera código: TIPO-ID-DIRECAO-SEQUENCIA (ex: PJ-01-IN-0001)"""
        prefixo = f"{conta_info['tipo']}-{conta_info['id']:02d}"
        chave = f"{prefixo}_{direcao}"
        
        if chave not in self.sequencias:
            self.sequencias[chave] = 0
        self.sequencias[chave] += 1
        
        return f"{prefixo}-{direcao}-{self.sequencias[chave]:04d}"
    
    def processar_csv(self, caminho_arquivo):
        """Processa arquivo CSV do banco"""
        movimentacoes = []
        
        try:
            with open(caminho_arquivo, 'r', encoding='utf-8') as f:
                leitor = csv.DictReader(f)
                for linha in leitor:
                    # Extrair dados
                    data = linha.get('Data', '')
                    valor_str = linha.get('Valor', '0').replace('.', '').replace(',', '.')
                    try:
                        valor = float(valor_str)
                    except:
                        valor = 0.0
                    
                    descricao = linha.get('Descrição', linha.get('Descriçao', ''))
                    
                    # Determinar direção
                    direcao = 'IN' if valor > 0 else 'OUT'
                    valor_abs = abs(valor)
                    
                    # AQUI: Identificar qual conta pelo nome do arquivo
                    # Exemplo: if 'conta1' in caminho: conta = CONTAS_CONFIG['SUA_CONTA_1']
                    
                    mov = {
                        'data': data,
                        'valor': valor_abs,
                        'direcao': direcao,
                        'descricao': descricao,
                    }
                    movimentacoes.append(mov)
                    
        except Exception as e:
            print(f"Erro ao processar {caminho_arquivo}: {e}")
        
        return movimentacoes

if __name__ == '__main__':
    print("🚀 SGN - Processador de Extratos")
    print("=" * 60)
    print("⚠️  IMPORTANTE: Configure seus dados antes de usar!")
    print("   1. Edite CONTAS_CONFIG com seus dados")
    print("   2. Defina PASTA_EXTRATOS")
    print("   3. Implemente identificação de conta")
    print("=" * 60)
    print("\nFormato de código gerado:")
    print("   PJ-01-IN-0001  (Entrada Conta PJ 1)")
    print("   PJ-01-OUT-0001 (Saída Conta PJ 1)")
    print("   PF-03-IN-0001  (Entrada Conta PF 3)")