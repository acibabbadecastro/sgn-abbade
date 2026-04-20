# SGN - RESUMO RÁPIDO

## 🎯 O QUE É O SGN
**Sistema de Gestão de Negócios** - Sistema para assistência técnica e lojinha

## 🏗️ INFRAESTRUTURA
| Componente | Container | IP | Acesso |
|------------|-----------|-----|--------|
| Frontend | CT 104 | 192.168.0.99 | http://192.168.0.99 |
| Banco | CT 103 | 192.168.0.109:5432 | PostgreSQL (sgn/acib) |
| Arquivos | CT 102 | 192.168.0.72 | `\\192.168.0.72\LAN\Acib\SGN\` |

## 📊 STATUS DOS MÓDULOS

### ✅ FUNCIONANDO (200)
- Principal: http://192.168.0.99
- Admin BD: http://192.168.0.99/admin_bd.php
- Dashboard: http://192.168.0.99/dashboard.php
- Clientes: http://192.168.0.99/modulos/clientes/
- Financeiro: http://192.168.0.99/modulos/financeiro/

### ⚠️ COM ERRO (500)
- OS: http://192.168.0.99/modulos/os/ (erro na tabela ordens_servico)
- Config/Alertas: http://192.168.0.99/modulos/config/alertas_email.php (syntax error)

### ⏳ PENDENTES
- PDV (Ponto de Venda)
- Vendas
- Importação NF-e

## 🗄️ BANCO DE DADOS
**Schemas:** agenda, clientes, estoque, financeiro, fornecedores, garantia, os

**Tabelas principais:**
- os: ordens_servico, servicos_os, pecas_os, forma_pagamento
- clientes: clientes, aparelhos
- estoque: categorias, produtos, atributos, atributos_produto
- financeiro: contas, movimentacoes, categorias

## 🎨 DESIGN OFICIAL
- **Cores:** Creme (#f5f0e6) + Verde erva-mate (#2d4a2d)
- **Sidebar:** 260px fixa à esquerda
- **Fonte:** Segoe UI

## 📁 ARQUIVOS IMPORTANTES
```
\192.168.0.72\LAN\Acib\SGN\
├── sgn_productowner.json (dados completos)
├── 01_PRD/ (documentação)
├── 02_Design/ (mockups)
├── 03_Menu_Navegacao/
├── 04_Estilos_Cores/ (guia visual)
├── 05_Banco_Dados/
├── 06_Modulos/
├── 07_Checklists/
└── 08_Backups/
```

## 🔧 ISSUES ATUAIS
1. Módulo OS com erro 500
2. alertas_email.php com syntax error

## 📋 PRÓXIMOS PASSOS
1. Corrigir erros 500
2. Criar módulo PDV
3. Criar módulo Vendas
4. Implementar importação NF-e

## 📞 CONTATO PRODUCT OWNER
- Nome: Acib ABBADE
- Regras: Máx 10 linhas/pergunta, autorização para ações destrutivas

---
**Ler este arquivo no início de toda sessão sobre SGN!**
**Atualizado:** 2026-04-06 23:41

## 🔗 LINK PARA AGENTES
Adicione ao AGENTS.md na seção "Session Startup":
`5. Read SGN_RESUMO.md — resumo do sistema principal do Acib`
