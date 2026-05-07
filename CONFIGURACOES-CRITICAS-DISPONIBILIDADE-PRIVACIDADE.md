# 🔒🛡️ CONFIGURAÇÕES CRÍTICAS - DISPONIBILIDADE E PRIVACIDADE

**Documento criado:** 04/05/2026  
**Solicitante:** Acib ABBADE  
**Objetivo:** Garantir privacidade total e disponibilidade máxima dos sistemas

---

## 📋 ÍNDICE

1. [Visão Geral](#visão-geral)
2. [Privacidade - Status Atual](#privacidade---status-atual)
3. [Disponibilidade - Status Atual](#disponibilidade---status-atual)
4. [Configurações Essenciais (FAZER AGORA)](#configurações-essenciais-fazer-agora)
5. [Configurações Recomendadas (ESSA SEMANA)](#configurações-recomendadas-essa-semana)
6. [Configurações Avançadas (OPCIONAL)](#configurações-avançadas-opcional)
7. [Procedimentos de Emergência](#procedimentos-de-emergência)
8. [Checklist de Validação](#checklist-de-validação)

---

## VISÃO GERAL

### Os 3 Pilares da Segurança (CID)

| Pilar | Descrição | Status |
|-------|-----------|--------|
| **Confidencialidade** | Só quem deve acessa | ✅ **Excelente** |
| **Integridade** | Dados não são alterados | ✅ **Bom** |
| **Disponibilidade** | Funciona quando precisa | ⚠️ **Pode melhorar** |

### Filosofia

> **"Privacidade não é sobre ter algo a esconder. É sobre ter algo a proteger."**

> **"Dados locais, processamento local, controle total."**

---

## PRIVACIDADE - STATUS ATUAL

### ✅ O QUE JÁ ESTÁ CONFIGURADO

| Dado/Sistema | Localização | Acesso | Status |
|--------------|-------------|--------|--------|
| **Emails Nubank** | `/home/master/LAN/Emails/` | Local apenas | ✅ Seguro |
| **Extratos CSV** | DATASVR (192.168.0.72) | Rede local | ✅ Seguro |
| **Memórias/Perfil** | `~/.openclaw/workspace/` | Local apenas | ✅ Seguro |
| **LLM (Ollama)** | CT 100 (192.168.0.21) | Local apenas | ✅ Seguro |
| **Site 4Pets** | CT 107 (192.168.0.200) | Público (leitura) | ✅ Seguro |
| **Backups** | Pendrive + DATASVR | Físico + local | ✅ Seguro |

### 🛡️ ARQUITETURA DE PRIVACIDADE

```
┌─────────────────────────────────────────────────┐
│           SUA REDE LOCAL (192.168.0.0/24)       │
│                                                 │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐        │
│  │  CT 100 │  │  CT 102 │  │  CT 107 │        │
│  │  Stark  │  │ DATASVR │  │  4Pets  │        │
│  │  Ollama │  │  Dados  │  │   Site  │        │
│  └────┬────┘  └────┬────┘  └────┬────┘        │
│       │           │           │                │
│       └───────────┴───────────┘                │
│                   │                            │
│           [REDE ISOLADA]                       │
│                   │                            │
│            ══════════  ← FIREWALL              │
│                   │                            │
│              [INTERNET]                        │
│         (Só sai se você quiser)                │
└─────────────────────────────────────────────────┘
```

### ✅ VANTAGENS DO SETUP ATUAL

- ✅ **Nenhum dado sai da rede local** sem autorização
- ✅ **LLM roda localmente** (Ollama no CT 100)
- ✅ **Backups físicos** (pendrive + DATASVR)
- ✅ **Sem dependência de cloud** para processamento
- ✅ **Controle total** de quem acessa o quê

---

## DISPONIBILIDADE - STATUS ATUAL

### ⚠️ PONTOS DE ATENÇÃO

#### 1. Single Point of Failure (SPOF)

```
Proxmox PVE1 (192.168.0.192)
       ↓
   Se cair → TUDO para
```

**Riscos:**
- ⚡ Falta de energia
- 🔥 Superaquecimento
- 💾 Falha de disco
- 🌐 Falha de rede
- 🌳 Tempestade (fibra óptica)

#### 2. Containers Parados

| Container | Serviço | Status | Risco |
|-----------|---------|--------|-------|
| CT 100 | Stark | ✅ RUNNING | Baixo |
| CT 101 | STARK2 | ⏳ STOPPED | Médio |
| CT 102 | DATASVR | ✅ RUNNING | Baixo |
| CT 103 | BD (PostgreSQL) | ⏳ STOPPED | **Alto** |
| CT 104 | SGN | ✅ RUNNING | Baixo |
| CT 105 | MAILS | ⏳ STOPPED | **Alto** |
| CT 106 | Vorcaro | ⏳ STOPPED | Médio |
| CT 107 | 4Pets | ✅ RUNNING | Baixo |
| CT 108+ | Outros | ⏳ STOPPED | Variável |

**6+ containers críticos parados.** Se precisar, leva tempo pra subir.

#### 3. Dependência de Internet

| Cenário | Impacto | Mitigação |
|---------|---------|-----------|
| **Fibra cai** | Sem acesso remoto | ✅ Rede local funciona |
| **Energia cai** | Tudo offline (sem UPS) | ⚠️ Comprar UPS |
| **Fibra + Energia** | Tudo offline | ⚠️ UPS + 4G backup |

---

## CONFIGURAÇÕES ESSENCIAIS (FAZER AGORA)

### 1. Auto-Start dos Containers Críticos

**Objetivo:** Containers sobem automaticamente se Proxmox reiniciar

**Comandos:**
```bash
# Containers essenciais (sempre rodando)
pct set 100 -onboot 1    # Stark (Orquestrador)
pct set 102 -onboot 1    # DATASVR (Dados)
pct set 103 -onboot 1    # BD (PostgreSQL)
pct set 105 -onboot 1    # MAILS (Emails)
pct set 107 -onboot 1    # 4Pets (Site)

# Verificar configuração
pct config 100 | grep onboot
```

**Status esperado:** `onboot: 1`

---

### 2. Subir Containers Críticos Parados

**Comandos:**
```bash
# Subir containers essenciais
pct start 103    # PostgreSQL
pct start 105    # MAILS

# Verificar status
pct list
```

**Status esperado:** `status: running`

---

### 3. Configurar Health Check do Supervisor (CT 103)

**Objetivo:** Monitorar todos os containers e auto-recuperar

**Script base:** `/root/.openclaw/workspace/scripts/monitor-containers.sh`

```bash
#!/bin/bash
# Monitora containers e tenta recuperar se cair

CONTAINERS="100 102 103 105 107"

for ct in $CONTAINERS; do
    status=$(pct status $ct 2>/dev/null)
    if [ "$status" != "status: running" ]; then
        echo "[$(date)] CT $ct caiu! Tentando recuperar..." >> /var/log/container-monitor.log
        pct start $ct
        echo "[$(date)] CT $ct recuperado" >> /var/log/container-monitor.log
    fi
done
```

**Cron job (a cada 5 min):**
```bash
# Adicionar ao crontab
*/5 * * * * /root/.openclaw/workspace/scripts/monitor-containers.sh
```

---

### 4. Testar Acesso Local (Sem Internet)

**Objetivo:** Garantir que tudo funciona offline

**Passo a passo:**

1. **Desconectar internet** (temporariamente)
   ```bash
   # No Proxmox ou roteador, desative WAN
   ```

2. **Testar acesso local** (do seu computador/celular no WiFi)
   ```
   Stark:        http://192.168.0.21:18789
   Proxmox:      https://192.168.0.192:8006
   Site 4Pets:   http://192.168.0.200
   DATASVR:      \\192.168.0.72\LAN\
   ```

3. **Verificar serviços**
   ```bash
   # No Proxmox
   pct list
   # Todos devem estar "running"
   ```

4. **Reconectar internet**

**Resultado esperado:** Todos os serviços acessíveis localmente

---

### 5. Configurar DNS Local para Emergência

**Objetivo:** Acessar serviços por nome (não só IP)

**Arquivo:** `/etc/hosts` (em cada máquina da rede local)

```bash
# Adicionar no /etc/hosts
192.168.0.192   pve1 proxmox
192.168.0.21    stark stark.local
192.168.0.72    datasvr lan
192.168.0.200   4pets amigos4patas.local
192.168.0.109   banco postgres
192.168.0.224   mails mailbot
```

**Acesso por nome:**
```
http://stark.local:18789
http://amigos4patas.local
https://proxmox:8006
```

---

## CONFIGURAÇÕES RECOMENDADAS (ESSA SEMANA)

### 1. Comprar e Configurar UPS (No-break)

**Objetivo:** Proteger contra queda de energia

**Especificações mínimas:**
- **Potência:** 600-1000 VA
- **Tempo:** 30min-2h (depende do load)
- **Interface:** USB (pra comunicar com Proxmox)

**Modelos sugeridos:**
- APC Back-UPS 600VA (~R$ 400)
- Nobreak TS Shara 800VA (~R$ 500)
- SMS Station III 800VA (~R$ 600)

**Configuração no Proxmox:**

1. **Instalar NUT (Network UPS Tools)**
   ```bash
   apt update
   apt install nut nut-client nut-server
   ```

2. **Configurar shutdown automático**
   ```bash
   # /etc/nut/ups.conf
   [myups]
   driver = usbhid-ups
   port = auto
   desc = "Meu Nobreak"
   ```

3. **Configurar desligamento graceful**
   ```bash
   # /etc/nut/upsd.conf
   LISTEN 0.0.0.0 3493
   ```

4. **Testar**
   ```bash
   # Simular queda de energia
   upsdrvctl shutdown
   ```

---

### 2. Roteador 4G com Failover Automático

**Objetivo:** Internet de backup se fibra cair

**Opção A: Roteador Dual-WAN + Modem 4G USB**

| Item | Modelo | Custo |
|------|--------|-------|
| Roteador | TP-Link ER605 | ~R$ 400 |
| Modem 4G | TP-Link TL-MR100 | ~R$ 150 |
| **Total** | | **~R$ 550** |

**Opção B: Roteador 4G Integrado**

| Item | Modelo | Custo |
|------|--------|-------|
| Roteador | Intelbras 4G LTE | ~R$ 700 |
| **Total** | | **~R$ 700** |

**Configuração:**

1. **Conectar fibra na WAN1**
2. **Conectar 4G na WAN2 (ou USB)**
3. **Configurar failover:**
   - Prioridade: WAN1 (fibra)
   - Backup: WAN2 (4G)
   - Check interval: 30 segundos
   - Fail threshold: 3 falhas

4. **Plano de dados:** ~R$ 50-100/mês

**Teste:**
```bash
# Desconectar fibra
# Aguardar 30-60 segundos
# Verificar se internet voltou (no 4G)
ping 8.8.8.8
```

---

### 3. Configurar Alertas de Falha

**Objetivo:** Ser avisado se algo cair

**Opção A: Alerta por SMS (Android Gateway)**

```bash
# Script: /root/.openclaw/workspace/scripts/alerta-sms.sh
#!/bin/bash
MENSAGEM="$1"
# Envia SMS via Android Gateway
curl -X POST http://192.168.0.XX:XXXX/send \
  -d "phone=SEU_NUMERO&message=$MENSAGEM"
```

**Gatilhos:**
- Internet caiu
- Container caiu
- UPS em bateria
- Disco cheio (>90%)

**Opção B: Alerta por Telegram (se tiver 4G)**

```bash
# Stark te manda mensagem no Telegram
# Se fibra cair → Roteador muda pra 4G → Stark avisa
```

---

### 4. Backup 3-2-1

**Objetivo:** 3 cópias, 2 mídias, 1 fora do local

**Sua configuração atual:**
- ✅ Cópia 1: Disco do Proxmox
- ✅ Cópia 2: DATASVR (/home/master/LAN/)
- ✅ Cópia 3: Pendrive (/mnt/meu-pendrive/)
- ⚠️ Fora do local: **Falta!**

**Sugestões:**
1. **Pendrive na casa de alguém de confiança**
2. **Nuvem criptografada** (Backblaze, pCloud Crypto)
3. **Segundo DATASVR** em outro local

**Script de rotação:**
```bash
#!/bin/bash
# /root/.openclaw/workspace/scripts/backup-rotacao.sh

# Backup semanal pro pendrive
rsync -av /home/master/LAN/ /mnt/meu-pendrive/Backup_Semanal/

# Log
echo "[$(date)] Backup completado" >> /var/log/backup.log
```

---

## CONFIGURAÇÕES AVANÇADAS (OPCIONAL)

### 1. Cluster Proxmox HA (High Availability)

**Objetivo:** Se um servidor cair, outro assume

**Requisitos:**
- 2+ servidores Proxmox
- Storage compartilhado (Ceph, NFS, iSCSI)
- Rede dedicada pra cluster

**Custo estimado:** R$ 2.000-4.000 (segundo servidor)

**Arquitetura:**
```
┌─────────────┐         ┌─────────────┐
│   PVE1      │◄───────►│   PVE2      │
│ 192.168.0.192│  Cluster │ 192.168.0.X │
│             │         │             │
│  CTs 100-107│         │  CTs espelho│
└─────────────┘         └─────────────┘
       │                       │
       └───────────┬───────────┘
                   │
           Storage Compartilhado
              (Ceph/NFS)
```

**Benefício:** 
- Se PVE1 cair, CTs sobem no PVE2
- Downtime: 30-60 segundos
- Automático

---

### 2. VPS de Backup para Site 4Pets

**Objetivo:** Site sempre no ar, mesmo se cair em casa

**Opções:**

| Provider | Plano | Custo |
|----------|-------|-------|
| DigitalOcean | Basic | US$ 6/mês |
| Linode | Nanode | US$ 5/mês |
| Hetzner | CPX11 | € 5/mês |
| Oracle Cloud | Free | **Grátis** |

**Configuração:**

1. **Deploy do site na VPS**
   ```bash
   # Copiar arquivos
   scp -r /var/www/amigos4patas/ user@vps:/var/www/
   ```

2. **DNS com failover**
   ```
   amigos4patas.com.br
   ├── A: 192.168.0.200 (prioridade 1)
   └── A: IP_VPS (prioridade 2, se #1 cair)
   ```

3. **Sincronização contínua**
   ```bash
   # rsync a cada hora
   0 * * * * rsync -av /var/www/amigos4patas/ user@vps:/var/www/
   ```

---

### 3. Criptografia de Disco (DATASVR)

**Objetivo:** Dados ilegíveis se roubarem o disco

**Ferramenta:** LUKS (Linux Unified Key Setup)

**Configuração:**

1. **Criptografar partição**
   ```bash
   cryptsetup luksFormat /dev/sdX
   cryptsetup open /dev/sdX dados_cripto
   ```

2. **Montar com senha**
   ```bash
   mount /dev/mapper/dados_cripto /mnt/dados
   ```

3. **Automatizar (com cuidado)**
   - Chave em arquivo seguro
   - Ou digitar senha no boot

**Atenção:** 
- ✅ Protege contra roubo físico
- ⚠️ Se perder senha/chave → dados perdidos
- ⚠️ Backup da chave é crítico

---

### 4. VPN para Acesso Remoto Seguro

**Objetivo:** Acessar de fora sem expor portas

**Ferramenta:** WireGuard (moderno, rápido, seguro)

**Configuração:**

1. **Instalar no Proxmox**
   ```bash
   apt install wireguard
   ```

2. **Gerar chaves**
   ```bash
   wg genkey | tee privatekey | wg pubkey > publickey
   ```

3. **Configurar servidor**
   ```ini
   # /etc/wireguard/wg0.conf
   [Interface]
   Address = 10.0.0.1/24
   ListenPort = 51820
   PrivateKey = <sua_chave_privada>

   [Peer]
   # Seu celular/notebook
   PublicKey = <chave_publica_cliente>
   AllowedIPs = 10.0.0.2/32
   ```

4. **Configurar cliente** (celular/notebook)
   ```ini
   [Interface]
   Address = 10.0.0.2/24
   PrivateKey = <chave_privada_cliente>

   [Peer]
   PublicKey = <chave_publica_servidor>
   Endpoint = seu_ip_externo:51820
   AllowedIPs = 192.168.0.0/24
   ```

5. **Acesso:**
   - Conecta VPN no celular
   - Acessa como se estivesse em casa
   - `http://192.168.0.21:18789` (de qualquer lugar)

**Vantagens:**
- ✅ Seguro (criptografia forte)
- ✅ Rápido (menos overhead que OpenVPN)
- ✅ Grátis

---

## PROCEDIMENTOS DE EMERGÊNCIA

### 🚨 CENÁRIO 1: Caiu a Internet (Fibra)

**Sintomas:**
- Telegram não recebe/envia
- SSH externo não conecta
- Ping em 8.8.8.8 falha

**O que fazer:**

1. **Verificar se é só internet**
   ```bash
   # No Proxmox
   ping 8.8.8.8
   # Se falhar → Internet caiu
   ```

2. **Acessar localmente**
   ```
   Conectar no WiFi de casa
   Acessar: http://192.168.0.21:18789 (Stark)
   Acessar: https://192.168.0.192:8006 (Proxmox)
   ```

3. **Se tiver 4G backup:**
   - Aguardar 30-60 segundos
   - Roteador deve mudar automático
   - Testar: `ping 8.8.8.8`

4. **Se não tiver 4G:**
   - Trabalhar localmente normal
   - Contatar provedor
   - Aguardar conserto

5. **Documentar:**
   ```bash
   echo "[$(date)] Internet caiu - Inicio: $(date)" >> /var/log/internet-falhas.log
   ```

---

### 🚨 CENÁRIO 2: Caiu Energia (Sem UPS)

**Sintomas:**
- Tudo desligou de repente
- Proxmox offline
- Containers offline

**O que fazer:**

1. **Quando energia voltar:**
   - Ligar Proxmox
   - Aguardar boot completo (2-3 min)

2. **Verificar containers:**
   ```bash
   pct list
   # Se onboot=1, devem estar rodando
   ```

3. **Subir manualmente se necessário:**
   ```bash
   pct start 100
   pct start 102
   pct start 103
   pct start 105
   pct start 107
   ```

4. **Verificar integridade dos dados:**
   ```bash
   # No DATASVR
   ls -la /home/master/LAN/
   # Verificar se arquivos estão íntegros
   ```

5. **Prevenir próxima vez:**
   - **COMPRAR URGENTE:** UPS

---

### 🚨 CENÁRIO 3: Caiu Energia (Com UPS)

**Sintomas:**
- Energia caiu
- UPS apitando
- Proxmox ainda rodando

**O que fazer:**

1. **Verificar tempo de bateria:**
   ```bash
   upsc myups
   # Ver: battery.charge, ups.time.left
   ```

2. **Se bateria < 30% e energia não voltou:**
   ```bash
   # Desligamento graceful
   shutdown -h now
   ```

3. **Quando energia voltar:**
   - Proxmox liga sozinho (se config UPS)
   - Containers sobem (se onboot=1)

4. **Verificar logs:**
   ```bash
   cat /var/log/syslog | grep -i "power\|ups"
   ```

---

### 🚨 CENÁRIO 4: Container Caiu

**Sintomas:**
- Serviço não responde
- `pct status <CT>` mostra "stopped"

**O que fazer:**

1. **Tentar subir:**
   ```bash
   pct start <CT_ID>
   ```

2. **Verificar logs:**
   ```bash
   pct enter <CT_ID> -- journalctl -xe
   ```

3. **Se falhar de novo:**
   - Verificar recursos (RAM, disco)
   - Verificar dependências
   - Restaurar backup se necessário

4. **Notificar:**
   ```bash
   echo "[$(date)] CT <ID> caiu e foi recuperado" >> /var/log/container-falhas.log
   ```

---

### 🚨 CENÁRIO 5: Disco Cheio

**Sintomas:**
- Alerta de disco cheio (>90%)
- Serviços lentos ou falhando

**O que fazer:**

1. **Verificar uso:**
   ```bash
   df -h
   ```

2. **Limpar temporários:**
   ```bash
   apt clean
   journalctl --vacuum-time=7d
   rm -rf /tmp/*
   ```

3. **Verificar logs grandes:**
   ```bash
   du -sh /var/log/*
   # Se algum > 1GB, rotacionar/limpar
   ```

4. **Expandir se necessário:**
   - Adicionar disco
   - Ou migrar dados pro DATASVR

---

## CHECKLIST DE VALIDAÇÃO

### ✅ Configurações Essenciais (Fazer Hoje)

- [ ] Auto-start configurado (CTs 100, 102, 103, 105, 107)
- [ ] Containers críticos rodando
- [ ] Health check do Supervisor ativo
- [ ] Teste de acesso local (sem internet) realizado
- [ ] DNS local configurado (/etc/hosts)

### ✅ Configurações Recomendadas (Essa Semana)

- [ ] UPS comprado e instalado
- [ ] NUT configurado no Proxmox
- [ ] Roteador 4G com failover configurado
- [ ] Alertas de falha (SMS/Telegram) ativos
- [ ] Backup 3-2-1 implementado

### ✅ Configurações Avançadas (Opcional)

- [ ] Cluster Proxmox HA planejado
- [ ] VPS de backup para site 4Pets
- [ ] Criptografia LUKS no DATASVR
- [ ] VPN WireGuard configurada

### ✅ Testes Periódicos (Mensal)

- [ ] Testar failover de internet
- [ ] Testar desligamento graceful (UPS)
- [ ] Testar restore de backup
- [ ] Verificar logs de falhas
- [ ] Atualizar documentação

---

## CONTATOS DE EMERGÊNCIA

| Serviço | Telefone | Site |
|---------|----------|------|
| **Provedor Internet** | (12) XXXX-XXXX | www.provedor.com.br |
| **Suporte UPS** | 0800 XXX-XXXX | www.ups.com.br |
| **Acib (Responsável)** | (12) 9XXXX-XXXX | Telegram: @Acib_Abbade |

---

## HISTÓRICO DE ALTERAÇÕES

| Data | Alteração | Responsável |
|------|-----------|-------------|
| 04/05/2026 | Criação do documento | Stark |
| | | |

---

## NOTAS FINAIS

> **"Privacidade você já tem. Disponibilidade a gente constrói."**

**Próximos passos imediatos:**
1. Executar configurações essenciais (hoje)
2. Planejar compras da semana (UPS, 4G)
3. Agendar testes mensais

**Dúvidas?** Consultar este documento ou acionar Stark.

---

*Documento gerado automaticamente por Stark em 04/05/2026*  
*Manter atualizado após cada mudança na infraestrutura*
