#!/usr/bin/env python3
"""
SGN - Extrator de Movimentações por Conta Bancária
Template de configuração - COPIE e preencha com seus dados
"""

import os
import csv
import json
from datetime import datetime
from collections import defaultdict

# ⚠️ CONFIGURAÇÃO: Preencha com seus dados
CONTAS_CONFIG = {
    # Número da conta: {id, tipo, nome, documento}
    'NUMERO_CONTA_1': {
        'id': 1,
        'tipo': 'PJ',
        'nome': 'Conta PJ Principal',
        'documento': 'XX.XXX.XXX/0001-XX'
    },
    'NUMERO_CONTA_2': {
        'id': 2,
        'tipo': 'PJ',
        'nome': 'Conta PJ Secundária',
        'documento': 'XX.XXX.XXX/0001-XX'
    },
    'NUMERO_CONTA_3': {
        'id': 3,
        'tipo': 'PF',
        'nome': 'Conta Pessoal',
        'documento': 'XXX.XXX.XXX-XX'
    },
}

class ExtratorContas:
    def __init__(self):
        self.movimentacoes_por_conta = defaultdict(list)
        self.sequencias = {}
        
    def gerar_codigo(self, conta, direcao):
        """Gera código sequencial"""
        prefixo = f"{conta['tipo']}-{conta['id']:02d}"
        chave = f"{prefixo}_{direcao}"
        
        if chave not in self.sequencias:
            self.sequencias[chave] = 0
        self.sequencias[chave] += 1
        
        return f"{prefixo}-{direcao}-{self.sequencias[chave]:04d}"

if __name__ == '__main__':
    print("🚀 SGN - Extrator por Contas")
    print("=" * 60)
    print("⚠️  IMPORTANTE: Configure antes de usar!")
    print("   1. Edite CONTAS_CONFIG com seus dados")
    print("   2. Defina o caminho dos extratos")
    print("   3. Implemente identificação automática de conta")
    print("=" * 60)