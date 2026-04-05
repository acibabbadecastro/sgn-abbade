# APRENDIZADOS - Lições Aprendidas

**Data:** 2026-04-03
**Atualizado:** 2026-04-03

---

## 1. Shell Compatibility (Debian/Ubuntu Dash)

### Problema:
Script de instalação do OpenClaw falhou com erro: `Syntax error: "(" unexpected`

### Causa:
Debian/Ubuntu usa `dash` como shell padrão (`/bin/sh`), não `bash`. Scripts com syntax bash (como `[[`, `(())`, etc.) falham no dash.

### Prevenção:
- Usar `bash /script.sh` em vez de `./script.sh`
- Ou verificar qual shell o script requer antes de executar
- Em scripts, sempre especificar `#!/bin/bash` se usar features bash

### Solução:
```bash
bash /tmp/install.sh  # Invocar bash explicitamente
```

---

## 2. Curl Não Instalado

### Problema:
`curl: command not found` ao tentar instalar OpenClaw

### Causa:
Minimal installations don't include curl by default

### Prevenção:
- Instalar curl antes: `apt-get install -y curl wget`
- Ou verificar dependências antes de rodar scripts

### Solução:
```bash
apt-get update && apt-get install -y curl wget
```

---

## 3. Gateway OpenClaw Não Inicia (unset mode)

### Problema:
Gateway fechar imediatamente com erro: `Gateway start blocked: set gateway.mode=local`

### Causa:
OpenClaw exige configuração explícita do gateway.mode antes de iniciar

### Prevenção:
- Sempre configurar após instalação: `openclaw config set gateway.mode local`
- Verificar documentação antes de primeiro uso

### Solução:
```bash
openclaw config set gateway.mode local
systemctl --user enable openclaw-gateway
systemctl --user start openclaw-gateway
```

---

## 4. SSH Key Não no Proxmox

### Problema:
`Permission denied (publickey)` ao tentar acessar pve1

### Causa:
Minha chave SSH pública não estava em `/root/.ssh/authorized_keys` do pve1

### Prevenção:
- Adicionar chave SSH antes de precisar acessar
- Manter lista de máquinas e chaves documentadas

### Solução:
```bash
# No pve1, adicionar:
echo 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIGMI7JK2K4u48w/Bh+ZJqia/ZY9C54V4nQftGP1u0fpk root@Stark' >> /root/.ssh/authorized_keys
```

---

## 5. HD com Filesystem ZFS

### Problema:
`mount: unknown filesystem type 'zfs_member'`

### Causa:
HD externo veio com ZFS de outra instalação. Linux padrão não monta ZFS sem suporte.

### Prevenção:
- Verificar filesystem antes de montar: `blkid /dev/sdX`
- Perguntar se há dados importantes antes de formatar

### Solução:
```bash
# Destruir ZFS
wipefs -a /dev/sdb3
# Criar partição
sfdisk /dev/sdb3 << 'EOF'
, +465.3G, L,
EOF
# Formatar
mkfs.ext4 -F /dev/sdb3
# Montar
mount /dev/sdb3 /mnt/sdb
```

---

## 6. Proxmox Sem Parted

### Problema:
`parted: command not found` no pve1

### Causa:
Proxmox minimal não instala parted por padrão

### Prevenção:
- Usar `fdisk` ou `sfdisk` que são mais universais
- Ou instalar parted: `apt-get install parted`

### Solução:
```bash
# Usar sfdisk (mais fácil para scripts)
sfdisk --wipe=always /dev/sdb3 << 'EOF'
, +465.3G, L,
EOF
```

---

## 7. Lock em dpkg (processo apt bloqueando)

### Problema:
`Could not get lock /var/lib/dpkg/lock-frontend` ao tentar instalar

### Causa:
Outro processo apt/dpkg estava rodando (provavelmente o instalador anterior)

### Prevenção:
- Verificar processos antes: `ps aux | grep apt`
- Esperar conclusão ou matar processo antigo

### Solução:
```bash
# Esperar e tentar novamente
sleep 30
# Ou matar processo
kill <PID>
# Ou esperar lock liberar
```

---

## 8. Aprovação de Comando no OpenClaw

### Problema:
Comando de instalação via pipe requer aprovação: `Content piped directly to shell interpreter`

### Causa:
OpenClaw bloqueia comandos que piping remote content diretamente pro shell (segurança)

### Prevenção:
- Solicitar aprovação antes ou configurar allow-always para hosts confiáveis
- Usar `--allow-unconfigured` ou configurar política

### Solução:
```bash
# Aprovar pelo ID
/approve <id> allow-once
# Ou para automação completa:
/approve <id> allow-always
```

---

## 9. Bind Mount para CT (mp0)

### Problema:
Como compartilhar pasta do host (HD de 500GB) com CT?

### Causa:
CTs são isolados, precisam de bind mount configurado no Proxmox

### Prevenção:
- Planejar storage antes de criar CT
- Configurar bind mount na criação do CT

### Solução:
```bash
# No pve1:
pct set <vmid> -mp0 /mnt/sdb,mp=/mnt/data
pct restart <vmid>
```

---

## 10. Autenticação SSH sem senha (Key-based)

### Problema:
Precisava acessar múltiplos CTs com senha → inseguro e inconveniente

### Causa:
Cada CT precisa ter minha chave pública autorizada

### Prevenção:
- Adicionar chave SSH em todo novo CT imediatamente
- Documentar IPs e chaves

### Solução:
```bash
# Adicionar chave no destino:
echo 'ssh-ed25519 AAAAC3...' >> /root/.ssh/authorized_keys
```

---

## Lições Gerais

### Antes de Instalar Software:
1. Verificar dependências (`curl`, `wget`, etc)
2. Verificar espaço em disco
3. Verificar shell disponível
4. Ter plano de rollback

### Antes de Acessar via SSH:
1. Garantir chave SSH adicionada
2. Verificar IP correto
3. Ter credenciais de backup

### Antes de Formatar/Montar Discos:
1. Perguntar se há dados importantes
2. Verificar filesystem atual
3. Confirmar ponto de montagem
4. Documentar no fstab se for mount permanente

### Segurança:
1. Nunca destruir dados sem confirmação
2. Manter backups de credenciais
3. Documentar mudanças de configuração

---

## Comandos Úteis para Diagnóstico

```bash
# Verificar shell
echo $SHELL
ls -la /bin/sh

# Verificar disco e partições
lsblk
fdisk -l /dev/sdX
blkid /dev/sdX

# Verificar processos
ps aux | grep apt
pgrep -a <processo>

# Verificar network
ip addr show
netstat -tlnp

# Verificar serviço
systemctl status <service>
journalctl -u <service>
```

---

*Documento atualizado: 2026-04-03*
*Stark - AI Assistant*

---

## 11. Stark Ficou Offline e SAMU Não Detectou (2026-04-03)

### Problema:
Stark ficou offline e Acib teve que intervir manualmente para restartar.

### Causa:
SAMU não conseguiu detectar ou corrigir a falha.

### O que aconteceu:
- Stark parou de responder
- SAMU não enviou email de alerta
- Acib teve que executar `openclaw launch` manualmente

### Prevenção:
- Verificar se SAMU está rodando corretamente
- Testar o sistema de alerta
- Adicionar mais pontos de verificação

### Ação tomada:
- Acib executou `openclaw launch --model ollama/minimax-m2.7:cloud`
- Stark voltou ao normal

### Lições:
1. Preciso verificar se o SAMU está funcionando
2. Preciso de método alternativo de restart (talvez Supervisor)
3. Testar o sistema de alertas regularmente

