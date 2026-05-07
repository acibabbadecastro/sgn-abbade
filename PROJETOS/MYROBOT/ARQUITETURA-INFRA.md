# 🏗️ MYROBOT - ARQUITETURA DE INFRAESTRUTURA LOCAL

**Data:** 28/04/2026  
**Projeto:** MYROBOT  
**Tipo:** Infraestrutura Local (Proxmox PVE)  
**Prioridade:** 🔴 MÁXIMA

---

## 🔄 MUDANÇA DE PLANEJAMENTO (28/04/2026 10:50)

### ❌ Antes (Planejado):
- Hospedagem externa (GitHub Pages/Netlify/Vercel)
- Apenas frontend estático
- Sem backend próprio

### ✅ Agora (Novo Plano):
- **Infraestrutura local no Proxmox PVE**
- Múltiplos containers especializados
- Stack completo: Web + Segurança + Dados
- Controle total da infraestrutura

---

## 🏗️ ARQUITETURA PROPOSTA

### Container Principal - Web Server
```
CT [NOVO] - MYROBOT-WEB
├── IP: 192.168.0.[X] (a definir)
├── Função: Servidor Web (Nginx/Apache)
├── Stack: HTML/CSS/JS + Backend (opcional)
├── Portas: 80, 443
└── Status: ⏳ A criar hoje
```

### Containers Auxiliares

| CT | Nome | Função | IP | Status |
|----|------|--------|-----|--------|
| [NOVO] | MYROBOT-SEC | Agente de Segurança | 192.168.0.[X] | ⏳ A criar |
| [NOVO] | MYROBOT-DATA | Coletor de Dados | 192.168.0.[X] | ⏳ A criar |
| [NOVO] | MYROBOT-DB | Banco de dados | 192.168.0.[X] | ⏳ Opcional |
| [NOVO] | MYROBOT-API | API/Backend | 192.168.0.[X] | ⏳ Opcional |

---

## 📋 PLANEJAMENTO DE IMPLEMENTAÇÃO

### Fase 1 - Infraestrutura (Hoje - 28/04)

#### 1.1 Criar CT MYROBOT-WEB
```bash
# No PVE1 (192.168.0.192)
pct create [ID] \
  --hostname myrobot-web \
  --memory 2048 \
  --cores 2 \
  --net0 name=eth0,bridge=vmbr0,ip=dhcp \
  --ostemplate debian-12-standard
```

**Especificações sugeridas:**
- **CT ID:** Próximo disponível (CT 113? Verificar)
- **OS:** Debian 12 / Ubuntu 22.04 LTS
- **RAM:** 2GB (pode aumentar depois)
- **Cores:** 2 vCPU
- **Storage:** 20GB SSD
- **IP:** DHCP ou fixo (192.168.0.XXX)

#### 1.2 Instalar Stack Web
```bash
# Dentro do CT
apt update && apt upgrade -y
apt install -y nginx
apt install -y nodejs npm  # Se precisar de build
```

#### 1.3 Configurar Nginx
```nginx
server {
    listen 80;
    server_name myrobot.local 192.168.0.XXX;
    root /var/www/myrobot;
    index index.html;
}
```

### Fase 2 - Containers Auxiliares (29-30/04)

#### CT: MYROBOT-SEC (Segurança)
- Monitoramento de acessos
- Firewall/IDS
- Logs de segurança
- Alertas de intrusão

#### CT: MYROBOT-DATA (Coletor)
- Coleta de métricas do site
- Analytics local
- Dados de visitantes
- Relatórios

#### CT: MYROBOT-DB (Opcional)
- PostgreSQL ou MariaDB
- Dados dinâmicos
- Formulários de contato
- Newsletter

#### CT: MYROBOT-API (Opcional)
- Backend em Python/Node.js
- API REST
- Integrações

### Fase 3 - Desenvolvimento (01-04/05)
- Criar site no CT principal
- Configurar comunicação entre CTs
- Testar stack completo
- Integrar com containers auxiliares

### Fase 4 - Deploy Local (05/05)
- Publicar no IP local
- Configurar DNS local (se necessário)
- Testar acesso interno
- Documentar acesso

---

## 🔧 CONFIGURAÇÃO DE REDE

### Opção 1: IPs DHCP (Mais simples)
- Cada CT pega IP automaticamente
- Registrar IPs após criação
- Acessar via IP:Porta

### Opção 2: IPs Fixos (Recomendado)
```
CT 113 - MYROBOT-WEB:    192.168.0.113
CT 114 - MYROBOT-SEC:    192.168.0.114
CT 115 - MYROBOT-DATA:   192.168.0.115
CT 116 - MYROBOT-DB:     192.168.0.116
CT 117 - MYROBOT-API:    192.168.0.117
```

---

## 📦 CHECKLIST DE CRIAÇÃO (Hoje)

### Preparação:
- [ ] Verificar CTs disponíveis (próximo ID livre)
- [ ] Verificar espaço em disco no PVE
- [ ] Verificar templates disponíveis

### Criação CT MYROBOT-WEB:
- [ ] Criar container via CLI ou Web
- [ ] Configurar rede (DHCP ou IP fixo)
- [ ] Instalar sistema base
- [ ] Atualizar pacotes
- [ ] Instalar Nginx
- [ ] Configurar site básico
- [ ] Testar acesso
- [ ] Documentar IP e acesso

### Segurança:
- [ ] Configurar firewall (ufw)
- [ ] Desabilitar root login SSH
- [ ] Criar usuário deploy
- [ ] Configurar SSH keys

---

## 🔄 INTEGRAÇÃO COM OUTROS CTs

### Container Segurança pode:
- Monitorar logs do MYROBOT-WEB
- Analisar tráfego de rede
- Alertar sobre acessos suspeitos

### Container Dados pode:
- Coletar estatísticas de visitas
- Processar formulários
- Gerar relatórios

### Container DB pode:
- Armazenar dados de leads
- Newsletter subscribers
- Conteúdo dinâmico

---

## 🚀 PRÓXIMOS PASSOS IMEDIATOS

### 1. Agora (Hoje):
```bash
# Verificar próximo CT disponível
ssh root@192.168.0.192 "pct list"

# Ver espaço em disco
ssh root@192.168.0.192 "df -h"

# Criar CT MYROBOT-WEB
[comandos de criação]
```

### 2. Após criação:
- Instalar Nginx
- Configurar site placeholder
- Testar acesso via IP
- Documentar no HEARTBEAT.md

### 3. Acompanhamento:
- Configurar containers auxiliares
- Desenvolver site real
- Integrar stack completo

---

## 📝 NOTAS

**Vantagens da infraestrutura local:**
- ✅ Controle total
- ✅ Dados não saem da rede
- ✅ Escalabilidade (adicionar CTs)
- ✅ Independência de serviços externos
- ✅ Aprendizado/DevOps

**Desvantagens:**
- ⚠️ Requer manutenção própria
- ⚠️ Backup é responsabilidade sua
- ⚠️ Acesso externo requer configuração (NAT/VPN)

---

*Arquitetura definida em: 28/04/2026 10:50*  
*Status: ⏳ Aguardando criação dos CTs*  
*Próxima ação: Criar CT MYROBOT-WEB hoje*
