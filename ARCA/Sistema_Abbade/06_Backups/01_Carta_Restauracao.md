# 📜 CARTA PARA RESTAURAÇÃO DO SISTEMA ABBADE

**Documento:** 01_Carta_Restauracao.md  
**Data:** 09/04/2026 13:36  
**Autor:** Stark (CT 100)  
**Versão:** 1.0  
**Prioridade:** 🔥 CRÍTICA

---

## 👤 SE VOCÊ ESTÁ LENDO ISSO...

**O sistema caiu e você precisa restaurar.**

Respire fundo. Este documento foi criado para guiar **qualquer pessoa** (técnico, IA, ou o próprio Acib) a restaurar o Sistema Abbade completo.

**Não se preocupe. É mais simples do que parece.**

---

## 📋 O QUE É O SISTEMA ABBADE

```
Sistema de gestão para:
• Assistência técnica (celulares, notebooks, computadores)
• Lojinha de peças e acessórios
• Venda de notebooks
• Controle financeiro (Nubank PJ/PF)
• Ordens de Serviço (OS)
• Clientes e fornecedores
• Garantias
• Agenda de compromissos
• Estoque
• Loja Virtual (em desenvolvimento)
```

**Proprietário:** Acib ABBADE  
**Telegram:** @Acib_Abbade (1866226415)  
**Empresa:** ABBADE Informática  
**CNPJ:** 65.384.056/0001-32

---

## 🚨 PASSO 1: IDENTIFICAR O BACKUP

### **ONDE PROCURAR:**

```
Local Principal: /mnt/data/ARCA/BACKUP_CRITICO/
Local Secundário: /mnt/meu-pendrive/Stark_Backup/
```

### **COMO SÃO OS ARQUIVOS:**

```
abbade_YYYYMMDD_HHMMSS.sql.gz
Exemplo: abbade_20260409_020000.sql.gz
```

### **QUAL USAR:**

1. **Liste os backups:**
```bash
ls -lh /mnt/data/ARCA/BACKUP_CRITICO/*.sql.gz
```

2. **Escolha o mais recente:**
```bash
# Ordenar por data (mais recente primeiro)
ls -lt /mnt/data/ARCA/BACKUP_CRITICO/*.sql.gz | head -5
```

3. **Verifique o tamanho (deve ser > 1KB):**
```bash
ls -lh /mnt/data/ARCA/BACKUP_CRITICO/abbade_20260409_020000.sql.gz
```

---

## 🛠️ PASSO 2: VERIFICAR INFRAESTRUTURA

### **CONTAINERS NECESSÁRIOS (8):**

| CT | Nome | IP | Função |
|----|------|-----|--------|
| 100 | Stark | 192.168.0.192 | Interface Telegram |
| 101 | STARK TUI | 192.168.0.240 | Backup |
| 102 | DATASVR | 192.168.0.72 | Armazenamento |
| 103 | Supervisor | 192.168.0.42 | **PostgreSQL** |
| 104 | Vorcaro | 192.168.0.172 | **Web Server** |
| 105 | OfficeBoy | 192.168.0.117 | Automação |
| 106 | SAMU | 192.168.0.64 | Emergências |
| 107 | Scraper | 192.168.0.?? | Web scraping |

### **COMO VERIFICAR:**

```bash
# No Proxmox (pve1)
for ct in 100 101 102 103 104 105 106 107; do
    echo "=== CT $ct ==="
    pct status $ct
done
```

### **SE ALGUM ESTIVER OFFLINE:**

```bash
# Iniciar container
pct start <CT>

# Aguardar inicialização
sleep 10

# Verificar se subiu
pct status <CT>
```

---

## 🗄️ PASSO 3: RESTAURAR BANCO DE DADOS

### **PRÉ-REQUISITOS:**

- CT 103 (Supervisor) ONLINE
- PostgreSQL rodando no CT 103
- Arquivo de backup identificado

### **RESTAURAR:**

```bash
# 1. Copiar backup para local temporário
cp /mnt/data/ARCA/BACKUP_CRITICO/abbade_20260409_020000.sql.gz /tmp/

# 2. Descomprimir
cd /tmp
gunzip abbade_20260409_020000.sql.gz

# 3. Restaurar no PostgreSQL
# Conectar no CT 103 primeiro
ssh root@192.168.0.42

# Executar restore
psql -h 192.168.0.109 -U acib -d financas < /tmp/abbade_20260409_020000.sql

# Senha do banco: Rcmp814k@#
```

### **VERIFICAR RESTORE:**

```bash
# Conectar no banco
psql -h 192.168.0.109 -p 5432 -U acib -d financas

# Executar consultas de teste
SELECT COUNT(*) FROM clientes.clientes;
SELECT COUNT(*) FROM os.ordens_servico;
SELECT COUNT(*) FROM financeiro.movimentacoes;

# Esperado: números > 0
```

### **SE O BANCO NÃO EXISTIR:**

```bash
# Criar banco
createdb -h 192.168.0.109 -U acib financas

# Ou recriar schemas
psql -h 192.168.0.109 -U acib -d financas

# Dentro do psql:
CREATE SCHEMA IF NOT EXISTS estoque;
CREATE SCHEMA IF NOT EXISTS clientes;
CREATE SCHEMA IF NOT EXISTS os;
CREATE SCHEMA IF NOT EXISTS financeiro;
CREATE SCHEMA IF NOT EXISTS fornecedores;
CREATE SCHEMA IF NOT EXISTS garantia;
CREATE SCHEMA IF NOT EXISTS agenda;
```

---

## 🌐 PASSO 4: VERIFICAR WEB SERVER

### **PRÉ-REQUISITOS:**

- CT 104 (Vorcaro) ONLINE
- Apache rodando

### **VERIFICAR:**

```bash
# Conectar no CT 104
ssh root@192.168.0.172

# Verificar Apache
systemctl status apache2

# Se não estiver rodando:
systemctl start apache2
systemctl enable apache2
```

### **TESTAR PÁGINAS:**

```bash
# Do CT 100 ou qualquer máquina na rede
curl http://192.168.0.99
curl http://192.168.0.99/admin_bd.php
curl http://192.168.0.99/dashboard.php
```

**Esperado:** HTML das páginas (não erro 404 ou 500)

---

## 🤖 PASSO 5: VERIFICAR OPENCLAW

### **PRÉ-REQUISITOS:**

- CT 100 (Stark) ONLINE
- OpenClaw Gateway rodando

### **VERIFICAR:**

```bash
# Conectar no CT 100
ssh root@192.168.0.192

# Verificar OpenClaw
systemctl status openclaw

# Se não estiver rodando:
systemctl start openclaw
systemctl enable openclaw
```

### **TESTAR BOT TELEGRAM:**

```
Enviar mensagem para @acibclawd_bot
Esperado: Resposta do Stark
```

---

## 📁 PASSO 6: VERIFICAR ARQUIVOS

### **MEMÓRIAS:**

```bash
# Verificar se existem
ls -la /mnt/data/LAN/MEMORIES/

# Deve ter:
# - Compromissos/
# - Clientes/
# - memory/YYYY-MM-DD.md
```

### **DOCUMENTAÇÃO:**

```bash
# Verificar documentação do Sistema Abbade
ls -la /mnt/data/ARCA/Sistema_Abbade/

# Deve ter 10 pastas (00_Geral a 09_Manuales)
```

---

## ✅ PASSO 7: TESTES FINAIS

### **CHECKLIST:**

- [ ] CT 103 ONLINE e PostgreSQL respondendo
- [ ] Banco `financas` restaurado
- [ ] Tabelas com dados (COUNT > 0)
- [ ] CT 104 ONLINE e Apache respondendo
- [ ] Páginas web carregando (http://192.168.0.99)
- [ ] CT 100 ONLINE e OpenClaw respondendo
- [ ] Bot Telegram respondendo (@acibclawd_bot)
- [ ] Arquivos de memória existentes
- [ ] Documentação na ARCA

### **TESTES PRÁTICOS:**

```bash
# 1. Testar banco
psql -h 192.168.0.109 -U acib -d financas -c "SELECT COUNT(*) FROM clientes.clientes;"

# 2. Testar web
curl -s http://192.168.0.99 | head -20

# 3. Testar OpenClaw
curl http://192.168.0.192:18789/status
```

---

## 🆘 CONTATOS DE EMERGÊNCIA

| Nome | Função | Contato |
|------|--------|---------|
| **Acib ABBADE** | Owner | Telegram: @Acib_Abbade (1866226415) |
| **Stark** | AI Assistant | Telegram: @acibclawd_bot |
| **Anderson** | Servmil (Cliente Nº 1) | A definir |

---

## 📊 DADOS CRÍTICOS (PARA CONSULTA)

### **SENHAS:**

| Sistema | Usuário | Senha |
|---------|---------|-------|
| **PostgreSQL** | acib | Rcmp814k@# |
| **SSH CT 100-107** | root | Rcmp814k@# (ou Rcmp@814k$1982 p/ CT 102) |
| **Samba** | master/nobody | (acesso livre na rede) |

### **ENDEREÇOS:**

| Serviço | Endereço |
|---------|----------|
| **PostgreSQL** | 192.168.0.109:5432 |
| **Web Server** | http://192.168.0.99 |
| **OpenClaw** | http://192.168.0.192:18789 |
| **Samba** | \\192.168.0.72\LAN\ |
| **GitHub** | https://github.com/acibabbadecastro/sgn-abbade |

---

## 🔄 FLUXO DE FALHA (DIAGNÓSTICO RÁPIDO)

```
Sistema não responde?
│
├─ Web não carrega?
│  └─ CT 104 OFFLINE? → pct start 104
│  └─ Apache parado? → systemctl start apache2
│
├─ Banco não conecta?
│  └─ CT 103 OFFLINE? → pct start 103
│  └─ PostgreSQL parado? → systemctl start postgresql
│
├─ Telegram não responde?
│  └─ CT 100 OFFLINE? → pct start 100
│  └─ OpenClaw parado? → systemctl start openclaw
│
└─ Arquivos sumiram?
   └─ DATASVR OFFLINE? → pct start 102
   └─ Verificar /mnt/data/
```

---

## 📝 APÓS RESTAURAÇÃO

### **CRIAR NOVO BACKUP:**

```bash
# Backup imediato após restore
pg_dump -h 192.168.0.109 -U acib -d financas | gzip > /mnt/data/ARCA/BACKUP_CRITICO/abbade_$(date +%Y%m%d_%H%M%S).sql.gz
```

### **CONFIGURAR BACKUP AUTOMÁTICO:**

```bash
# Criar script
cat > /home/master/scripts/backup_abbade.sh << 'EOF'
#!/bin/bash
DATA=$(date +%Y%m%d_%H%M%S)
DESTINO="/mnt/data/ARCA/BACKUP_CRITICO"

mkdir -p $DESTINO

pg_dump -h 192.168.0.109 -U acib -d financas | gzip > $DESTINO/abbade_$DATA.sql.gz

# Manter últimos 7 dias
find $DESTINO -name "abbade_*.sql.gz" -mtime +7 -delete

echo "Backup criado: abbade_$DATA.sql.gz"
EOF

chmod +x /home/master/scripts/backup_abbade.sh

# Agendar no cron (diário, 02:00)
crontab -e
# Adicionar: 0 2 * * * /home/master/scripts/backup_abbade.sh
```

---

## 💬 MENSAGEM PARA ACIB

**Após restaurar, enviar:**

```
✅ SISTEMA RESTAURADO COM SUCESSO!

📊 Status:
- Banco de dados: ✅ Online
- Web server: ✅ Online
- OpenClaw: ✅ Online
- Backup: ✅ Criado

📋 Ações tomadas:
1. [ ] Containers iniciados
2. [ ] Banco restaurado
3. [ ] Web verificada
4. [ ] OpenClaw verificado
5. [ ] Novo backup criado

⏰ Horário: [inserir horário]
👤 Responsável: [seu nome]
```

---

## 📞 PRECISA DE AJUDA?

**Se algo der errado:**

1. **Verifique os logs:**
```bash
# PostgreSQL
tail -100 /var/log/postgresql/postgresql-*.log

# Apache
tail -100 /var/log/apache2/error.log

# OpenClaw
journalctl -u openclaw -n 100
```

2. **Contate o Acib:**
```
Telegram: @Acib_Abbade (1866226415)
```

3. **Contate o Stark:**
```
Telegram: @acibclawd_bot
```

---

## 🎯 RESUMO RÁPIDO (PARA IMPRIMIR)

```
╔══════════════════════════════════════════════════════╗
║     RESTAURAÇÃO SISTEMA ABBADE - RESUMO RÁPIDO      ║
╠══════════════════════════════════════════════════════╣
║ 1. Backup: /mnt/data/ARCA/BACKUP_CRITICO/           ║
║ 2. Iniciar CTs: pct start 100-107                   ║
║ 3. Restaurar: gunzip backup.sql.gz                  ║
║              psql -h 192.168.0.109 -U acib < backup  ║
║ 4. Testar Web: curl http://192.168.0.99             ║
║ 5. Testar Bot: @acibclawd_bot                       ║
║ 6. Novo Backup: pg_dump | gzip > backup.sql.gz      ║
╚══════════════════════════════════════════════════════╝

Senhas:
- Banco: acib / Rcmp814k@#
- SSH: root / Rcmp814k@#

Contatos:
- Acib: @Acib_Abbade (1866226415)
- Stark: @acibclawd_bot
```

---

**Documento criado para:** Qualquer pessoa que precisar restaurar o Sistema Abbade  
**Data:** 09/04/2026  
**Versão:** 1.0  
**Próxima revisão:** 16/04/2026

**Boa sorte! Você consegue! 🚀**
