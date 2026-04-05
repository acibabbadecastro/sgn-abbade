# SGN - Sistema de Gerenciamento de Negócios

<div align="center">

![SGN Logo](docs/assets/logo.png)

**Sistema de Gerenciamento de Negócios ABBADE Technologies**

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-blue.svg)](https://postgresql.org)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

[Documentação](#documentação) • [Instalação](#instalação) • [Screenshots](#screenshots) • [Manual](#manual-de-uso)

</div>

---

## 📋 Índice

- [Visão Geral](#-visão-geral)
- [Funcionalidades](#-funcionalidades)
- [Arquitetura](#-arquitetura)
- [Requisitos](#-requisitos)
- [Instalação](#-instalação)
- [Configuração](#-configuração)
- [Screenshots](#-screenshots)
- [Manual de Uso](#-manual-de-uso)
- [API](#-api)
- [Contribuição](#-contribuição)
- [Licença](#-licença)

---

## 🎯 Visão Geral

O **SGN** é um sistema ERP (Enterprise Resource Planning) desenvolvido especificamente para pequenas empresas prestadoras de serviços técnicos, com foco em:

- **Controle Financeiro** completo (4 contas bancárias)
- **Gestão de Serviços** (agendados, pendentes, em execução)
- **Cadastro de Clientes e Fornecedores**
- **Monitoramento MEI** (limite mensal R$ 6.750)
- **Bot de Email** para detectar oportunidades de licitação/prefeitura

Desenvolvido por **Acib Abbade de Castro** para a empresa **ABBADE Technologies**.

---

## ✨ Funcionalidades

### 💰 Módulo Financeiro
- ✅ Gerenciamento de até 4 contas bancárias
- ✅ Extratos com filtros avançados (data, valor, tipo)
- ✅ Registro de entradas e saídas
- ✅ **Monitor MEI** - Alerta ao atingir 80% do limite mensal (R$ 5.400)
- ✅ Relatórios PDF/Excel
- ✅ Categorização automática

### 🔧 Módulo de Serviços
- ✅ Agendamento de atendimentos
- ✅ Controle de pendentes (aguardando peça, aprovação, cliente)
- ✅ Timer/cronômetro para serviços em execução
- ✅ Histórico completo

### 👥 Cadastros
- ✅ Clientes (PF/PJ)
- ✅ Fornecedores
- ✅ Importação inteligente de extratos
- ✅ Detecção automática de duplicados

### 📧 Bot de Email
- ✅ Verificação automática a cada 5 minutos
- ✅ Detecta emails de prefeitura e órgãos públicos
- ✅ Palavras-chave: "pedido de compra", "pregão", "licitação", "convite"
- ✅ Alertas visuais no painel

---

## 🏗️ Arquitetura

```
┌─────────────────┐     HTTP      ┌─────────────────┐
│   Navegador     │ ───────────────▶│  Apache + PHP   │
│   (Cliente)     │                │   (SGN - CT 104)│
└─────────────────┘                └────────┬────────┘
                                            │
                                            │ PDO
                                            ▼
                              ┌─────────────────────────┐
                              │   PostgreSQL 17         │
                              │   (DATASVR - CT 102)    │
                              │   Porta: 5432           │
                              └─────────────────────────┘
```

### Tecnologias Utilizadas

| Camada | Tecnologia | Versão |
|--------|-----------|--------|
| **Frontend** | HTML5, CSS3, JavaScript | - |
| **Backend** | PHP | 7.4+ |
| **Banco de Dados** | PostgreSQL | 15+ |
| **Servidor Web** | Apache | 2.4+ |
| **Monitoramento** | Python 3 | 3.8+ |

---

## 📦 Requisitos

### Hardware
- **CPU**: 1 vCPU (mínimo)
- **RAM**: 512 MB (mínimo)
- **Disco**: 5 GB livre

### Software
```bash
# Sistema Operacional
Ubuntu 22.04+ / Debian 11+

# Dependências
apache2
php7.4+ php-pgsql php-mbstring
postgresql-15
python3 python3-pip
```

### Banco de Dados
- Host: `192.168.0.109`
- Porta: `5432`
- Banco: `financas`
- Schema: `financeiro`

---

## 🚀 Instalação

### Passo 1: Preparação

Acesse o servidor Proxmox (pve1) como root:

```bash
ssh root@192.168.0.192
```

### Passo 2: Executar Script de Instalação

```bash
# Baixar o instalador
wget https://github.com/acibabbadecastro/sgn/releases/download/v1.0.0/instalar_sgn.sh

# Executar
chmod +x instalar_sgn.sh
./instalar_sgn.sh
```

Ou instalação manual:

```bash
# 1. Criar diretórios
pct exec 104 -- mkdir -p /var/www/html/{includes,modulos/{servicos,financeiro,clientes,config},scripts,alerts}

# 2. Copiar arquivos
pct push 104 sgn_final.tar.gz /tmp/
pct exec 104 -- tar -xzf /tmp/sgn_final.tar.gz -C /var/www/html/

# 3. Ajustar permissões
pct exec 104 -- chown -R www-data:www-data /var/www/html/
pct exec 104 -- chmod 755 /var/www/html/scripts/monitor_email.py

# 4. Instalar dependências Python
pct exec 104 -- apt update
pct exec 104 -- apt install -y python3-pip
pct exec 104 -- pip3 install imaplib2

# 5. Configurar cron
echo '*/5 * * * * /usr/bin/python3 /var/www/html/scripts/monitor_email.py' | pct exec 104 -- crontab -

# 6. Reiniciar Apache
pct exec 104 -- systemctl restart apache2
```

### Passo 3: Verificação

Acesse no navegador:
```
http://192.168.0.99/
```

Credenciais padrão:
- **Usuário**: `admin`
- **Senha**: `Rcmp814k@#`

---

## ⚙️ Configuração

### Configuração do Banco de Dados

Edite `/var/www/html/includes/config.php`:

```php
$host = '192.168.0.109';      // IP do DATASVR
$port = '5432';               // Porta PostgreSQL
$dbname = 'financas';         // Nome do banco
$username = 'acib';           // Usuário
$password = 'Rcmp814k@#';     // Senha
```

### Configuração do Bot de Email

Edite `/var/www/html/scripts/monitor_email.py`:

```python
CONFIG = {
    'email': 'acibabbadecastro@gmail.com',
    'password': 'juqqogjysxvpowtu',  # App Password do Gmail
    'palavras_chave': [
        'pedido de compra',
        'pregão',
        'licitação',
        'convite',
        'orçamento'
    ]
}
```

---

## 📸 Screenshots

### Tela de Login
![Login](docs/screenshots/01-login.png)

### Dashboard Principal
![Dashboard](docs/screenshots/02-dashboard.png)

### Contas Bancárias
![Contas](docs/screenshots/03-contas.png)

### Monitor MEI
![MEI](docs/screenshots/04-monitor-mei.png)

### Extratos com Filtros
![Extratos](docs/screenshots/05-extratos.png)

### Serviços Agendados
![Servicos](docs/screenshots/06-servicos.png)

### Importação de Clientes
![Importar](docs/screenshots/07-importar.png)

### Alertas de Email
![Alertas](docs/screenshots/08-alertas.png)

---

## 📖 Manual de Uso

Veja o [Manual Completo](docs/MANUAL.md) para instruções detalhadas de uso.

### Primeiros Passos

1. **Acessar o Sistema**
   - Abra http://192.168.0.99/ no navegador
   - Faça login com admin/Rcmp814k@#

2. **Cadastrar Contas Bancárias**
   - Menu: Financeiro → Contas Bancárias
   - Clique em "+ Nova Conta"
   - Preencha: apelido, banco, tipo, número, saldo inicial

3. **Registrar Movimentações**
   - Menu: Financeiro → Movimentações
   - Clique em "+ Nova Movimentação"
   - Informe data, valor, tipo, categoria

4. **Monitorar Limite MEI**
   - Menu: Financeiro → Monitor MEI
   - Acompanhe o progresso mensal
   - Receba alerta aos 80% (R$ 5.400)

5. **Importar Clientes de Extratos**
   - Menu: Cadastros → Clientes → Importar
   - Faça upload do arquivo CSV/OFx
   - Revise e confirme importação

6. **Configurar Bot de Email**
   - O bot já está ativo (verifica a cada 5 min)
   - Acesse Sistema → Alertas de Email
   - Visualize oportunidades detectadas

---

## 🔌 API

### Endpoints

#### Listar Contas
```http
GET /api/contas.php
```

#### Registrar Movimentação
```http
POST /api/movimentacoes.php
Content-Type: application/json

{
  "conta_id": 1,
  "valor": 150.00,
  "tipo": "despesa",
  "categoria_id": 10,
  "descricao": "Compra de material"
}
```

---

## 🤝 Contribuição

Desenvolvido por **Acib Abbade de Castro**

📧 Email: acibabbadecastro@gmail.com  
🏢 Empresa: ABBADE Technologies  
📍 Local: Curitiba, PR - Brasil

### Agradecimentos
- Sistema desenvolvido com auxílio de IA (Stark/OpenClaw)
- Arquitetura multi-container Proxmox
- Monitoramento 24/7 por agentes autônomos

---

## 📄 Licença

Este projeto está licenciado sob a [Licença MIT](LICENSE).

Copyright © 2026 ABBADE Technologies. Todos os direitos reservados.

---

<div align="center">

**[⬆ Voltar ao topo](#sgn---sistema-de-gerenciamento-de-negócios)**

Desenvolvido com ❤️ para ABBADE Technologies

</div>