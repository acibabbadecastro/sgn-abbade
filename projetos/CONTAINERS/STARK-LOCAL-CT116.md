# 🚀 CONTAINER Stark_local (CT 116)

**Criado:** 07/05/2026 13:45  
**Status:** ✅ RUNNING  
**Prioridade:** 🔴 Container Principal de Desenvolvimento  

---

## 📊 **CONFIGURAÇÃO**

| Campo | Valor |
|-------|-------|
| **CT ID** | 116 |
| **Nome** | stark-local |
| **Hostname** | stark-local |
| **IP** | 192.168.0.50/24 |
| **Gateway** | 192.168.0.1 |
| **Bridge** | vmbr0 |
| **OS** | Ubuntu 25.04 LTS |
| **Template** | ubuntu-25.04-standard_25.04-1.1_amd64.tar.zst |

---

## 💾 **RECURSOS**

| Recurso | Valor |
|---------|-------|
| **RAM** | 4096 MB (4 GB) |
| **CPU** | 4 núcleos |
| **Disco** | 16 GB (local-lvm) |
| **Arquitetura** | amd64 |
| **On Boot** | Sim |

---

## 🔐 **ACESSO**

### SSH:
```bash
ssh root@192.168.0.50
Senha: Rcmp814k@#
```

### Proxmox:
```bash
# Entrar no container
pct enter 116

# Executar comando
pct exec 116 -- <comando>

# Ver status
pct status 116
```

---

## 🎯 **FINALIDADE**

**Stark_local** é um container dedicado para:
- Desenvolvimento e testes locais
- Backup do Stark principal (CT 100)
- Ambiente isolado para experimentos
- Fallback em caso de falha do CT 100

---

## 📦 **SERVIÇOS INSTALADOS**

- ✅ OpenSSH Server
- ✅ Sistema atualizado (último pacote)

---

## 🔧 **PRÓXIMOS PASSOS (Sugestões)**

1. **Instalar Node.js** (para desenvolvimento)
2. **Instalar PostgreSQL** (banco de dados)
3. **Instalar Ollama** (IA local)
4. **Configurar backup automático**
5. **Instalar Docker** (containers internos)

---

## 📍 **LOCAIS DE DOCUMENTAÇÃO**

| Local | Arquivo |
|-------|---------|
| **GitHub** | https://github.com/AcibAbbade/luz/blob/main/containers/STARK-LOCAL-CT116.md |
| **ARCA** | `\\192.168.0.72\LAN\Acib\PROJETOS\CONTAINERS\STARK-LOCAL-CT116.md` |
| **Memória** | `/root/.openclaw/workspace/memory/STARK-LOCAL-CT116.md` |
| **Local** | `/root/.openclaw/workspace/projetos/CONTAINERS/STARK-LOCAL-CT116.md` |

---

## 🚨 **RECUPERAÇÃO DE EMERGÊNCIA**

**Se o container falhar:**

```bash
# 1. Verificar status
pct status 116

# 2. Se parado, iniciar
pct start 116

# 3. Se não iniciar, recriar
pct destroy 116
pct create 116 local:vztmpl/ubuntu-25.04-standard_25.04-1.1_amd64.tar.zst \
  --rootfs local-lvm:16 \
  --memory 4096 \
  --cores 4 \
  --net0 name=eth0,bridge=vmbr0,ip=192.168.0.50/24,gw=192.168.0.1 \
  --hostname stark-local \
  --password 'Rcmp814k@#' \
  --onboot 1
```

---

## 📞 **CONTATOS**

| Nome | Função |
|------|--------|
| Acib ABBADE | Proprietária |
| Stark (CT 100) | Assistente IA |

---

**Última Atualização:** 07/05/2026 13:45  
**Próxima Verificação:** Semanal  

*Stark - CT 100 | 07/05/2026 13:45*
