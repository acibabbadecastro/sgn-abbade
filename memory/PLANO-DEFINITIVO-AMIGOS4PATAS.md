# 🎯 PLANO DEFINITIVO - AMIGOS 4 PATAS
## Infraestrutura: CT no Proxmox PVE1 + Domínio

**Data:** 26/04/2026  
**Decisão final:** Usar CT no Proxmox existente  
**Status:** Aguardando criação do CT

---

## ✅ POR QUE ESSA É A MELHOR OPÇÃO

### **Você já tem tudo:**
- ✅ **Proxmox PVE1** (192.168.0.192) rodando 24h
- ✅ **Nobreak** (proteção contra queda de luz)
- ✅ **Infraestrutura** estabilizada
- ✅ **Backups automáticos** (snapshots LXC)
- ✅ **Conhecimento** (você gerencia Proxmox!)

### **Custo ZERO de energia:**
- Servidor já está ligado 24/7
- CT adicional consome pouquíssimo (2-4GB RAM)
- Sem custo extra de infraestrutura

### **Facilidade de gestão:**
- Cria CT em 5 minutos
- Snapshot antes de qualquer mudança
- Se der problema: restaura em 2 minutos
- Backup automático junto com os outros CTs

---

## 📋 PLANO DE IMPLEMENTAÇÃO

### FASE 1: CRIAR CT NO PROXMOX (Você faz ou eu guio)

**Especificações do CT:**
```
CT 200 (ou próximo disponível)
├── Nome: Amigos4Patas-Web
├── SO: Ubuntu 22.04 LTS
├── CPU: 2 cores
├── RAM: 4 GB
├── Disco: 50 GB (pasta /var/www)
├── Rede: Bridge (vmbr0) - IP estático 192.168.0.200
└── Privilegiado: Não (mais seguro)
```

**Comando rápido (se quiser via CLI):**
```bash
pct create 200 local:vztmpl/ubuntu-22.04-standard_22.04-1_amd64.tar.zst \
  --hostname amigos4patas-web \
  --cores 2 \
  --memory 4096 \
  --swap 512 \
  --rootfs local-lvm:50 \
  --net0 name=eth0,bridge=vmbr0,ip=192.168.0.200/24,gw=192.168.0.1 \
  --unprivileged 1 \
  --features nesting=1,keyctl=1

pct start 200
```

---

### FASE 2: CONFIGURAR ROTEADOR (Port Forwarding)

**No roteador da internet (192.168.0.1):**
```
Redirecionamento de Portas:
├─ Porta externa 80 → 192.168.0.200:80
├─ Porta externa 443 → 192.168.0.200:443
└─ Porta externa 22 → 192.168.0.200:22 (opcional)
```

**Verificar se funcionou:**
```bash
curl http://SEU-IP-EXTERNO
# Deve aparecer "Welcome to nginx!"
```

---

### FASE 3: COMPRAR DOMÍNIO

**Registrador recomendado:** Registro.br (oficial)

**Domínio sugerido:**
- `amigos4patasparquemeialua.com.br`
- `amigos4patas.org.br`
- `4patasparquemeialua.com.br`

**Custo:** R$ 40/ano

**Configuração DNS:**
```
Tipo A:
┌────────────────────────────────────────┐
│ @    → 201.XX.XX.XX (seu IP externo)  │
│ www  → 201.XX.XX.XX (seu IP externo)  │
└────────────────────────────────────────┘
```

---

### FASE 4: CONFIGURAR DDNS (IP dinâmico)

**Problema:** IP da internet muda!
**Solução:** DuckDNS (gratuito)

**Passos:**
1. Cadastrar em https://www.duckdns.org
2. Escolher nome: `amigos4patas`
3. Obter token
4. Instalar no CT 200 (script automático)

**Script de atualização:**
```bash
# Rodar a cada 5 minutos via cron
curl "https://www.duckdns.org/update?domains=amigos4patas&token=SEU_TOKEN&ip="
```

**Domínio temporário:** `amigos4patas.duckdns.org`

---

### FASE 5: INSTALAR STACK (Eu faço via SSH)

**Após CT criado, me envie:**
- IP: 192.168.0.200
- Usuário: root
- Senha: [senha definida na criação do CT]

**Eu instalarei:**
```
✅ Ubuntu 22.04 LTS (já vem no template)
✅ Nginx (web server)
✅ PostgreSQL (banco de dados)
✅ Python 3 + Flask (backend)
✅ Certbot + SSL (HTTPS gratuito)
✅ Upload de fotos configurado
✅ Site Amigos 4 Patas completo
```

**Tempo estimado:** 2-3 horas

---

### FASE 6: DEPLOY DO SITE

**Funcionalidades implementadas:**
- [ ] Página inicial com QR Code
- [ ] Formulário de cadastro (com upload de fotos)
- [ ] Página de confirmação pós-cadastro
- [ ] Página de busca com filtros (bairro, data, mês, status)
- [ ] Página de detalhes do animal
- [ ] Integração WhatsApp
- [ ] SSL/HTTPS (seguro)
- [ ] Responsivo (mobile)

---

## 💾 BACKUP E SEGURANÇA

### Backup automático (Proxmox):
```bash
# Snapshot diário (agendado no PVE)
vzdump 200 --compress zstd --storage local --mode snapshot

# Ou via cron no Proxmox:
0 3 * * * /usr/bin/vzdump 200 --quiet 1 --storage local --mode snapshot
```

### Snapshot antes de mudanças:
```bash
pct snapshot 200 "antes-atualizacao-$(date +%Y%m%d)"
```

### Se der problema:
```bash
pct restore 200 /var/lib/vz/dump/vzdump-lxc-200-[data].tar.zst
# OU
pct rollback 200 [nome-snapshot]
```

---

## 🚀 ESCALABILIDADE FUTURA

### Se o projeto crescer muito:

**Opção 1 - Upgrade no Proxmox:**
- Aumentar RAM do CT (8GB, 16GB...)
- Aumentar disco (100GB, 200GB...)
- Adicionar CPU
- **Custo:** ZERO (só hardware que já tem)

**Opção 2 - Migrar pra nuvem:**
```
FASE 1: Exportar CT (tar.gz)
FASE 2: Importar na nuvem (AWS, GCP, Azure)
FASE 3: Ajustar configurações
FASE 4: Site no ar com mais poder!
```

**Opção 3 - Híbrido:**
- Manter site no Proxmox
- Usar CDN (Cloudflare) pra acelerar
- Usar S3 (AWS) pra armazenar fotos

---

## 📊 COMPARATIVO FINAL

| Aspecto | Proxmox (CT) | VPS Hostinger | Em casa (PC) |
|---------|--------------|---------------|--------------|
| **Custo anual** | **R$ 40** ✅ | R$ 396 | R$ 40 |
| **Setup** | Médio | Fácil | Médio |
| **Backup** | ✅ Automático | Manual/Simples | Manual |
| **Estabilidade** | ✅ Alta | ✅ Alta | Média |
| **Escalabilidade** | ✅ Fácil | Fácil | Limitado |
| **Você controla** | ✅ Total | Parcial | Total |
| **Depende sua luz/net** | ✅ Não (nobreak) | Não | Sim |
| **Experiência** | ✅ Aprende + | Menos | Aprende + |

---

## ✅ CHECKLIST DE IMPLEMENTAÇÃO

### ETAPA 1 - Preparação (Você faz):
- [ ] Criar CT 200 no Proxmox
- [ ] Configurar IP 192.168.0.200
- [ ] Abrir portas 80/443/22 no roteador
- [ ] Comprar domínio (Registro.br)
- [ ] Cadastrar DuckDNS (opcional, mas recomendado)

### ETAPA 2 - Instalação (Eu faço):
- [ ] Acessar CT via SSH
- [ ] Atualizar sistema
- [ ] Instalar Nginx
- [ ] Instalar PostgreSQL
- [ ] Instalar Python/Flask
- [ ] Configurar SSL (Certbot)
- [ ] Criar banco de dados
- [ ] Configurar upload de fotos

### ETAPA 3 - Desenvolvimento (Nós fazemos):
- [ ] Criar estrutura do site
- [ ] Formulário de cadastro
- [ ] Sistema de busca com filtros
- [ ] Página de detalhes
- [ ] Integração WhatsApp
- [ ] Testes

### ETAPA 4 - Deploy (Eu faço):
- [ ] Subir aplicação
- [ ] Configurar domínio
- [ ] Testar tudo
- [ ] Documentar

---

## 🎯 PRÓXIMO PASSO

**Me responda:**

1. **Quer criar o CT agora?** (eu te guio passo a passo)

2. **Já quer comprar o domínio?** (eu te digo o passo a passo do Registro.br)

3. **Prefere que eu aguarde** e você me chama quando tiver o CT pronto?

4. **Quer focar em outra coisa primeiro?** (portfólios da faculdade, BIOS do notebook...)

**Sua escolha:** _____ ?

---

*Plano registrado em: 26/04/2026*  
*Por: Stark - Assistente de Acib ABBADE*  
*Status: Aguardando ação do usuário*
