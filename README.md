# SGN - Sistema de Gerenciamento de Negócios

<div align="center">

**Sistema de Gerenciamento de Negócios**

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-blue.svg)](https://postgresql.org)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

</div>

---

## 🎯 Visão Geral

O **SGN** é um sistema ERP para pequenas empresas prestadoras de serviços técnicos.

## ✨ Funcionalidades

### 💰 Módulo Financeiro
- Gerenciamento de múltiplas contas bancárias
- Extratos com filtros avançados
- **Monitor MEI** - Alerta ao atingir limite mensal
- Categorização automática

### 🔧 Módulo de Serviços
- Agendamento de atendimentos
- Controle de pendentes
- Timer/cronômetro para serviços em execução

### 👥 Cadastros
- Clientes (PF/PJ)
- Fornecedores com busca por CNPJ
- Importação de extratos

### 📊 Processador de Extratos
- Códigos únicos: `{TIPO}-{ID}-{DIREÇÃO}-{SEQUÊNCIA}`
  - Exemplo: `PJ-01-IN-0001`, `PF-03-OUT-0001`
- Geração de SQL para PostgreSQL
- Separação por conta bancária

### 📧 Bot de Email
- Verificação automática
- Detecta oportunidades de licitação/prefeitura

---

## 🚀 Instalação

### Requisitos
- PHP 7.4+
- PostgreSQL 15+
- Apache 2.4+
- Python 3.8+

### Configuração

1. Clone o repositório:
```bash
git clone https://github.com/SEU_USUARIO/sgn.git
cd sgn
```

2. Configure o banco de dados em `includes/config.php`:
```php
$host = 'SEU_IP_POSTGRESQL';
$port = '5432';
$dbname = 'financas';
$username = 'SEU_USUARIO';
$password = 'SUA_SENHA';
```

3. Configure scripts Python em `scripts/processar_extratos_v2.py`:
```python
CONTAS_CONFIG = {
    'NUMERO_CONTA_1': {
        'id': 1,
        'tipo': 'PJ',
        'nome': 'Conta PJ',
        'documento': 'XX.XXX.XXX/0001-XX'
    },
}
```

4. Configure o bot de email em `scripts/monitor_email.py`:
```python
CONFIG = {
    'email': 'SEU_EMAIL@gmail.com',
    'password': 'SENHA_APP_GMAIL',
}
```

5. Ajuste permissões:
```bash
chown -R www-data:www-data /var/www/html/
chmod 755 /var/www/html/scripts/
```

6. Configure cron:
```bash
crontab -e
# Adicione: */5 * * * * /usr/bin/python3 /var/www/html/scripts/monitor_email.py
```

---

## 🏗️ Arquitetura

```
┌──────────────┐     HTTP      ┌──────────────┐
│ Navegador    │ ─────────────▶│ Apache + PHP │
└──────────────┘               └──────┬───────┘
                                     │ PDO
                                     ▼
                           ┌─────────────────┐
                           │ PostgreSQL      │
                           └─────────────────┘
```

---

## 📋 Estrutura de Diretórios

```
sgn/
├── index.php              # Login
├── dashboard.php          # Painel principal
├── includes/
│   ├── config.php        # Configuração BD
│   └── auth.php          # Autenticação
├── modulos/
│   ├── servicos/         # Agendados, pendentes, execução
│   ├── financeiro/       # Resumo, contas, extratos, MEI
│   ├── clientes/         # Cadastro, importação, fornecedores
│   └── config/           # Alertas de email
└── scripts/
    ├── monitor_email.py           # Bot email
    ├── processar_extratos_v2.py   # Processador
    └── extrator_movimentacoes_contas.py  # Separador por conta
```

---

## 🔐 Segurança

- ⚠️ **Nunca commite senhas ou dados reais!**
- Use `config.php.example` e `processar_extratos_v2.py.example`
- Configure `.gitignore` para ignorar arquivos com dados
- Mantenha backups seguros fora do repositório

---

## 🤝 Desenvolvimento

Desenvolvido por **[Seu Nome]** para **[Sua Empresa]**.

### Licença
MIT License - Veja LICENSE para detalhes.

---

<div align="center">
Desenvolvido com ❤️
</div>