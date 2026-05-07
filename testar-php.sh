#!/bin/bash
echo "🧪 Testando salvar-inscricao.php..."
echo ""

# Teste 1: POST válido
echo "Teste 1: Inscrição válida"
curl -s -X POST \
  -d "nome=Teste Silva&email=teste@email.com&whatsapp=12999998888" \
  http://localhost/salvar-inscricao.php
echo ""
echo ""

# Teste 2: Email inválido
echo "Teste 2: Email inválido"
curl -s -X POST \
  -d "nome=Teste&email=invalido&whatsapp=12999998888" \
  http://localhost/salvar-inscricao.php
echo ""
echo ""

# Teste 3: Duplicado
echo "Teste 3: Email duplicado"
curl -s -X POST \
  -d "nome=Teste Silva&email=teste@email.com&whatsapp=12999999999" \
  http://localhost/salvar-inscricao.php
echo ""
echo ""

# Verifica JSON
echo "📁 Conteúdo do newsletter.json:"
cat /root/.openclaw/workspace/data/newsletter.json | head -20
