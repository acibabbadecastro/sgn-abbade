# 🌐 PÁGINAS WEB - SISTEMA ABBADE

**Documento:** 01_Paginas.md  
**Data:** 09/04/2026 13:36  
**Autor:** Stark (CT 100)  
**Versão:** 1.0  
**Status:** ✅ Operacional (rede local)

---

## 📋 IDENTIFICAÇÃO

| Campo | Informação |
|-------|------------|
| **Sistema** | Sistema Abbade |
| **Servidor Web** | CT 104 (Vorcaro) |
| **IP** | 192.168.0.99 |
| **Porta** | 80 (HTTP) |
| **Tecnologia** | Apache + PHP + PostgreSQL |

---

## 🌐 PÁGINAS OPERACIONAIS (3)

### **1️⃣ HOME - Página Principal**

| Campo | Informação |
|-------|------------|
| **URL** | `http://192.168.0.99` |
| **Arquivo** | `index.php` |
| **Status** | ✅ Online |
| **Acesso** | Rede local (192.168.0.x) |

**Funcionalidades:**
- Landing page do Sistema Abbade
- Links rápidos para módulos
- Status do sistema
- Login (se implementado)

**Print da Página:**
```
+------------------------------------------+
|         SISTEMA ABBADE                   |
|   Gestão Integrada do Seu Negócio        |
+------------------------------------------+
|  [📊 Dashboard]  [📦 Estoque]            |
|  [👥 Clientes]   [💰 Financeiro]         |
|  [🔧 OS]         [📅 Agenda]             |
|  [🛒 Loja Virtual] (em breve)            |
+------------------------------------------+
```

---

### **2️⃣ ADMIN BD - Administração do Banco**

| Campo | Informação |
|-------|------------|
| **URL** | `http://192.168.0.99/admin_bd.php` |
| **Arquivo** | `admin_bd.php` |
| **Status** | ✅ Online |
| **Acesso** | Rede local |

**Funcionalidades:**
- Visualizar tabelas de todos os schemas
- Inserir/editar/deletar registros
- Executar consultas SQL
- Backup manual do banco
- Restore de backup

**Schemas Acessíveis:**
1. `estoque.*` - Produtos, categorias, movimentações
2. `clientes.*` - Clientes, fornecedores
3. `os.*` - Ordens de serviço, orçamentos
4. `financeiro.*` - Contas, movimentações, categorias
5. `fornecedores.*` - Fornecedores, produtos
6. `garantia.*` - Garantias, acompanhamentos
7. `agenda.*` - Compromissos, visitas, lembretes

**Exemplo de Uso:**
```sql
-- Listar OS abertas
SELECT * FROM os.ordens_servico WHERE status = 'aberta';

-- Listar clientes
SELECT * FROM clientes.clientes ORDER BY nome;

-- Total de movimentações do mês
SELECT SUM(valor) FROM financeiro.movimentacoes 
WHERE data_movimento >= '2026-04-01';
```

---

### **3️⃣ DASHBOARD - Painel de Controle**

| Campo | Informação |
|-------|------------|
| **URL** | `http://192.168.0.99/dashboard.php` |
| **Arquivo** | `dashboard.php` |
| **Status** | ✅ Online |
| **Acesso** | Rede local |

**Funcionalidades:**
- Visão geral do negócio
- Faturamento do dia/mês
- OS abertas/fechadas
- Clientes recentes
- Compromissos do dia
- Estoque crítico (produtos abaixo do mínimo)
- Gráficos e métricas

**Widgets do Dashboard:**

```
+-------------------+-------------------+
|  📊 FATURAMENTO   |  🔧 OS DO DIA     |
|  Hoje: R$ 495,00  |  Abertas: 7       |
|  Mês: R$ 12.350   |  Em andamento: 1  |
+-------------------+-------------------+
|  👥 CLIENTES      |  📦 ESTOQUE       |
|  Novos: 3         |  Crítico: 5 itens |
|  Total: 156       |  Valor: R$ 45.200 |
+-------------------+-------------------+
|  📅 COMPROMISSOS  |  💰 CONTAS        |
|  Hoje: 5          |  Nubank PJ: R$ 12 |
|  Essa semana: 12  |  Nubank PF: R$ 20 |
+-------------------+-------------------+
```

---

## 📂 ESTRUTURA DE ARQUIVOS

### **LOCALIZAÇÃO (CT 104):**

```
/var/www/html/ (ou /var/www/sgn-abbade/)
├── index.php                 # Home
├── admin_bd.php              # Admin BD
├── dashboard.php             # Dashboard
├── includes/
│   ├── config.php            # Configuração do banco
│   ├── functions.php         # Funções utilitárias
│   └── auth.php              # Autenticação
├── css/
│   └── style.css             # Estilos
├── js/
│   └── scripts.js            # Scripts JavaScript
├── assets/
│   ├── images/               # Imagens do sistema
│   └── uploads/              # Uploads de usuários
└── backups/                  # Backups manuais
    └── banco_*.sql
```

---

## 🔌 CONFIGURAÇÃO DO BANCO (config.php)

```php
<?php
// Configuração do PostgreSQL - Sistema Abbade
$host = '192.168.0.109';
$porta = '5432';
$banco = 'financas'; // ou 'sgn'
$usuario = 'acib';
$senha = 'Rcmp814k@#';

// Conexão
$conn = pg_connect("host=$host port=$porta dbname=$banco user=$usuario password=$senha");

if (!$conn) {
    die("Erro na conexão: " . pg_last_error());
}

// Função para executar queries
function executarQuery($sql) {
    global $conn;
    $result = pg_query($conn, $sql);
    if (!$result) {
        die("Erro na query: " . pg_last_error());
    }
    return $result;
}

// Função para buscar dados
function buscarDados($sql) {
    $result = executarQuery($sql);
    return pg_fetch_all($result);
}
?>
```

---

## 🚧 PÁGINAS EM DESENVOLVIMENTO

| Página | URL Prevista | Status | Prioridade |
|--------|--------------|--------|------------|
| **Loja Virtual** | `/loja/` | ⏳ Pendente | 🔥 Máxima |
| **OS Online** | `/os/` | ⏳ Pendente | 🟡 Média |
| **Clientes** | `/clientes/` | ⏳ Pendente | 🟡 Média |
| **Financeiro** | `/financeiro/` | ⏳ Pendente | 🟡 Média |
| **Estoque** | `/estoque/` | ⏳ Pendente | 🟡 Média |
| **Garantias** | `/garantias/` | ⏳ Pendente | 🟢 Baixa |

---

## 🔐 ACESSO REMOTO

### **ATUAL:**

| Tipo | Status | Observação |
|------|--------|------------|
| **Local (rede Acib)** | ✅ Funciona | 192.168.0.99 |
| **Remoto (internet)** | ❌ Bloqueado | Precisa Cloudflare Tunnel |
| **SSL/HTTPS** | ❌ Não configurado | Precisa implementar |

### **COMO HABILITAR ACESSO REMOTO:**

**Opção 1: Cloudflare Tunnel (Recomendado)**

```bash
# Instalar cloudflared
wget https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-amd64
chmod +x cloudflared-linux-amd64
sudo mv cloudflared-linux-amd64 /usr/local/bin/cloudflared

# Criar tunnel
cloudflared tunnel login
cloudflared tunnel create sgn-abbade

# Configurar
cloudflared tunnel route dns sgn-abbade abbadeinformatica.com.br

# Rodar
cloudflared tunnel run sgn-abbade
```

**Vantagens:**
- ✅ Grátis
- ✅ Sem abrir portas no roteador
- ✅ SSL automático (HTTPS)
- ✅ Proteção DDoS

---

## 📱 RESPONSIVIDADE

| Dispositivo | Status |
|-------------|--------|
| **Desktop** | ✅ Funciona |
| **Tablet** | ✅ Funciona |
| **Celular** | ⚠️ Parcial (melhorar CSS) |

---

## 🧪 TESTES

### **TESTAR CONEXÃO:**

```bash
# Do CT 100 (Stark)
curl http://192.168.0.99

# Do CT 103 (Banco)
curl http://192.168.0.99/admin_bd.php

# De qualquer máquina na rede
curl http://192.168.0.99/dashboard.php
```

### **TESTAR BANCO:**

```bash
# Acessar admin_bd.php e executar:
SELECT COUNT(*) FROM clientes.clientes;
SELECT COUNT(*) FROM os.ordens_servico;
SELECT COUNT(*) FROM financeiro.movimentacoes;
```

---

## 🔧 MANUTENÇÃO

### **REINICIAR APACHE:**

```bash
# No CT 104
sudo systemctl restart apache2

# Verificar status
sudo systemctl status apache2
```

### **LOGS DO APACHE:**

```bash
# Log de acesso
sudo tail -f /var/log/apache2/access.log

# Log de erro
sudo tail -f /var/log/apache2/error.log
```

### **PERMISSÕES:**

```bash
# Corrigir permissões
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/
```

---

## 📞 SUPORTE

| Problema | Solução |
|----------|---------|
| Página não carrega | Verificar se CT 104 está ONLINE |
| Erro de conexão com banco | Verificar CT 103 (192.168.0.109) |
| Login não funciona | Verificar config.php (senha) |
| Página em branco | Verificar logs do Apache |

---

## 📝 HISTÓRICO DE REVISÕES

| Versão | Data | Autor | Alterações |
|--------|------|-------|------------|
| 1.0 | 09/04/2026 | Stark | Criação inicial |

---

**Última atualização:** 09/04/2026 13:36  
**Próxima revisão:** 16/04/2026 (7 dias)  
**Responsável:** Stark (CT 100)
