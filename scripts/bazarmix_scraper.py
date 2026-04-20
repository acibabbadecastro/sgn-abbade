#!/usr/bin/env python3
"""
Bazar Mix Scraper - Consulta de Preços
Autor: Stark (CT 100)
Data: 09/04/2026

Este script acessa o site da Bazar Mix e extrai preços de peças.
"""

import json
import os
from datetime import datetime
from pathlib import Path

# Configurações
SITE_URL = "http://pedidos.lojabazarmix.com.br/"
OUTPUT_DIR = "/mnt/data/ARCA/CT108_Scraper/sites/bazarmix_catalogo"
PREÇOS_FILE = "/mnt/data/LAN/Preços_BazarMix.json"

class BazarMixScraper:
    def __init__(self):
        self.session = None
        self.produtos = []
        
    def login(self, email, senha):
        """Faz login no site da Bazar Mix"""
        print(f"🔐 Fazendo login com: {email}")
        # Implementação com requests/selenium
        pass
        
    def buscar_produto(self, termo):
        """Busca produto por nome/modelo"""
        print(f"🔍 Buscando: {termo}")
        # Implementação da busca
        pass
        
    def extrair_preco(self, url_produto):
        """Extrai preço de uma página de produto"""
        print(f"💰 Extraindo preço de: {url_produto}")
        # Implementação da extração
        pass
        
    def salvar_preços(self, dados):
        """Salva preços em JSON local"""
        dados['atualizado_em'] = datetime.now().strftime("%Y-%m-%d %H:%M")
        
        with open(PREÇOS_FILE, 'w', encoding='utf-8') as f:
            json.dump(dados, f, indent=2, ensure_ascii=False)
            
        print(f"✅ Preços salvos em: {PREÇOS_FILE}")
        
    def carregar_preços(self):
        """Carrega preços do arquivo local"""
        if os.path.exists(PREÇOS_FILE):
            with open(PREÇOS_FILE, 'r', encoding='utf-8') as f:
                return json.load(f)
        return {}
        
    def consultar(self, produto):
        """Consulta preço de um produto"""
        dados = self.carregar_preços()
        
        if produto.lower() in dados.get('telas', {}):
            return dados['telas'][produto.lower()]
            
        return None


def main():
    scraper = BazarMixScraper()
    
    # Menu simples
    print("🛒 Bazar Mix - Consulta de Preços")
    print("=" * 40)
    print("1. Atualizar preços (requer login)")
    print("2. Consultar preço")
    print("3. Listar todos os preços")
    print("4. Sair")
    
    opcao = input("\nEscolha: ")
    
    if opcao == "1":
        email = input("Email: ")
        senha = input("Senha: ")
        scraper.login(email, senha)
        # scraper.atualizar_tudo()
    elif opcao == "2":
        produto = input("Produto: ")
        preco = scraper.consultar(produto)
        if preco:
            print(f"💰 Preço: R$ {preco}")
        else:
            print("❌ Produto não encontrado")
    elif opcao == "3":
        dados = scraper.carregar_preços()
        print(json.dumps(dados, indent=2, ensure_ascii=False))
    elif opcao == "4":
        print("👋 Saindo...")
        return


if __name__ == "__main__":
    main()
