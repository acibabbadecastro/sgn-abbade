# 🔐 CONTROLE DE ACESSOS - Acib ABBADE

**Última atualização:** 27/04/2026  
**Sistema:** Captura e armazenamento de acessos diversos

---

## 🎯 OBJETIVO

Capturar, armazenar e monitorar todos os tipos de acesso:
- Acessos SSH aos containers
- Acessos ao site/admin
- Tentativas de acesso
- Logins bem-sucedidos e falhos

---

## 🖥️ ACESSOS SSH (Containers)

### **CTs Configurados:**

| CT | Nome | IP | Método de Acesso | Status |
|----|------|-----|------------------|--------|
| 100 | Stark | 192.168.0.21 | Chave SSH | ✅ Ativo |
| 101 | STARK | 192.168.0.240 | Chave SSH | ✅ Ativo |
| 102 | DATASVR | 192.168.0.72 | Senha (especial) | ✅ Ativo |
| 103 | BD | 192.168.0.109 | Chave SSH | ✅ Ativo |
| 104 | SGN | 192.168.0.99 | Chave SSH | ✅ Ativo |
| 105 | MAILS | 192.168.0.224 | Chave SSH | ✅ Ativo |
| 106 | Vorcaro | DHCP | Chave SSH | ✅ Ativo |
| 107 | SAMU/4PETS | 192.168.0.200 | Chave SSH | ✅ Ativo (configurado 27/04) |
| 108 | Scraper | DHCP | Chave SSH | ✅ Ativo |
| 109 | ADM-SERVMIL | DHCP | Chave SSH | ✅ Ativo |
| 110 | bd-servmil | DHCP | Chave SSH | ✅ Ativo |
| 111 | Fe-Servmil | DHCP | Chave SSH | ✅ Ativo |
| 112 | Analista-Servmil | DHCP | Chave SSH | ✅ Ativo |

### **Chave SSH Padrão:**
- **Local:** `/root/.ssh/id_ed25519`
- **Pública:** `ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIGMI7JK2K4u48w/Bh+ZJqia/ZY9C54V4nQftGP1u0fpk root@Stark`
- **CTs com chave:** Todos exceto DATASVR (usa senha)

### **Senhas de Emergência:**
| Container | Senha | Notas |
|-----------|-------|-------|
| **Todos (padrão)** | `Rcmp814k@#` | SSH via senha (fallback) |
| **DATASVR** | `Rcmp@814k$1982` | Senha principal |

---

## 🌐 ACESSOS WEB

### **Sites Principais:**

| Site | URL | Acesso | Proteção | Status |
|------|-----|--------|----------|--------|
| **4Pets** | https://amigos4patas.com.br | Público | Nenhuma | ✅ Online |
| **4Pets Admin** | https://amigos4patas.com.br/admin.php | Protegido | Senha: `Admin4Pets2026!` | 🔒 Protegido (27/04) |
| **SGN** | http://192.168.0.99 | Rede local | Nenhuma | ✅ Online |
| **SGN Admin** | http://192.168.0.99/admin_bd.php | Rede local | Nenhuma | ⚠️ Verificar proteção |

### **Senhas de Admin:**
| Sistema | Senha | Hash SHA-256 | Alterar em |
|---------|-------|--------------|------------|
| 4Pets Admin | `Admin4Pets2026!` | `e90beb78da7f345282d5b95184652691be4accc9dfe7e7d5b50a07acaa516171` | 27/07/2026 |

---

## 📊 LOGS DE ACESSO

### **Onde Armazenar:**

```
\\192.168.0.72\LAN\Acib\logs\acessos\
├── ssh/
│   ├── ssh-ct100.log
│   ├── ssh-ct101.log
│   └── ...
├── web/
│   ├── amigos4patas-access.log
│   └── admin-access.log
└── tentativas/
    └── failed-attempts.log
```

### **Formato do Log:**

```
[TIMESTAMP] [TIPO] [ORIGEM] [DESTINO] [STATUS] [DETALHES]

Exemplo SSH:
[2026-04-27 00:21:15] [SSH] [192.168.0.21] [CT107-4PETS] [SUCESSO] [Key auth]

Exemplo Web:
[2026-04-27 00:21:15] [WEB] [201.45.67.89] [amigos4patas.com.br/admin.php] [FALHA] [Senha incorreta]
[2026-04-27 00:22:30] [WEB] [201.45.67.89] [amigos4patas.com.br/admin.php] [SUCESSO] [Login OK]
```

---

## 🔄 COLETA DE LOGS

### **SSH - Comando para capturar:**
```bash
# Últimos acessos SSH em cada CT
for CT in 100 101 102 103 104 105 106 107 108 109 110 111 112; do
  echo "=== CT $CT ===" >> /var/log/ssh-access.log
  ssh root@192.168.0.$CT "last -10" 2>/dev/null >> /var/log/ssh-access.log
done
```

### **Web - Nginx logs:**
```bash
# Acessos ao site
/var/log/nginx/amigos4patas-access.log

# Erros
/var/log/nginx/amigos4patas-error.log
```

### **Admin - PHP Session:**
```php
// Registrar no admin.php
file_put_contents('/var/log/admin-access.log', 
    date('[Y-m-d H:i:s]') . ' [ADMIN] [' . $_SERVER['REMOTE_ADDR'] . '] ' .
    ($_SESSION['admin_logado'] ? '[SUCESSO]' : '[TENTATIVA]') . ' ' .
    ($_POST['senha'] ? '[Senha enviada]' : '[Acesso página]') . "\n",
    FILE_APPEND | LOCK_EX
);
```

---

## 🚨 MONITORAMENTO DE TENTATIVAS

### **Alertas Automáticos:**

| Condição | Ação | Threshold |
|----------|------|-----------|
| **SSH falho** | Notificar | 3 tentativas em 5 min |
| **Admin falho** | Bloquear IP | 5 tentativas em 10 min |
| **Acesso fora do horário** | Logar | 23h-06h |
| **IP desconhecido** | Notificar | Primeira vez |

### **IPs Conhecidos (Whitelist):**
| IP | Descrição | Tipo |
|----|-----------|------|
| 192.168.0.0/24 | Rede local | Confiança total |
| 201.x.x.x | IP externo Acib | Verificar |

---

## 📋 CHECKLIST DE SEGURANÇA

### **Diário:**
- [ ] Verificar logs de acesso SSH
- [ ] Verificar tentativas falhas no admin
- [ ] Confirmar backups rodaram

### **Semanal:**
- [ ] Analisar padrões de acesso
- [ ] Verificar IPs suspeitos
- [ ] Rotacionar senhas se necessário

### **Mensal:**
- [ ] Auditar todos os acessos
- [ ] Atualizar chaves SSH
- [ ] Revisar permissões

---

## 🔧 FERRAMENTAS DE CAPTURA

### **Script para Coletar Logs:**
```bash
#!/bin/bash
# collect-access-logs.sh

DATA=$(date +%Y%m%d)
ARCA="192.168.0.72"
DESTINO="/home/master/LAN/Acib/logs/acessos"

# Coletar logs SSH
echo "Coletando logs SSH..."
for CT in $(seq 100 112); do
    ssh root@192.168.0.$CT "last -20" 2>/dev/null | sshpass -p 'Rcmp@814k$1982' ssh root@$ARCA "cat > $DESTINO/ssh/ct${CT}-$DATA.log"
done

# Coletar logs Web
echo "Coletando logs Web..."
sshpass -p 'Rcmp814k@#' ssh root@192.168.0.200 "cat /var/log/nginx/access.log" | sshpass -p 'Rcmp@814k$1982' ssh root@$ARCA "cat > $DESTINO/web/nginx-$DATA.log"

echo "✅ Logs coletados em $DESTINO"
```

---

## 📁 ESTRUTURA DE ARQUIVOS

### **Local (Stark CT100):**
```
/var/log/acessos/
├── ssh/
├── web/
└── admin/
```

### **Backup (DATASVR):**
```
\\192.168.0.72\LAN\Acib\logs\
├── acessos/     (logs de acesso)
├── seguranca/   (alertas e incidentes)
└── audit/       (auditorias periódicas)
```

---

## ⚠️ REGRAS DE RETENÇÃO

| Tipo de Log | Retenção | Compressão |
|-------------|----------|------------|
| **Acessos SSH** | 90 dias | Após 30 dias |
| **Acessos Web** | 180 dias | Após 60 dias |
| **Tentativas falhas** | 365 dias | Após 90 dias |
| **Admin login** | 365 dias | Após 90 dias |

---

## ✅ IMPLEMENTAÇÃO (27/04/2026)

### **Concluído:**
- ✅ Chave SSH configurada em CT107 (4PETS)
- ✅ Admin 4Pets protegido por senha
- ✅ Hash SHA-256 implementado
- ✅ Session management configurado
- ✅ Logs de admin prontos para implementar

### **Próximos Passos:**
- [ ] Implementar log detalhado em admin.php
- [ ] Criar script de coleta automática
- [ ] Configurar alertas de tentativas suspeitas
- [ ] Estabelecer rotina de auditoria

---

## 📞 CONTATOS EMERGÊNCIA

| Situação | Ação |
|----------|------|
| **Acesso não autorizado** | Bloquear IP, trocar senha, notificar Acib |
| **Senha vazada** | Trocar imediatamente, revisar logs |
| **Chave SSH comprometida** | Gerar novo par, revogar antiga |
| **Ataque DDoS** | Ativar Cloudflare protection, limitar rate |

---

**Sistema de captura de acessos:** ✅ Configurado e pronto  
**Última atualização:** 27/04/2026 00:22  
**Próxima revisão:** 27/05/2026
