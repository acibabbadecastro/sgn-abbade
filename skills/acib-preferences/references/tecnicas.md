# 🔧 PREFERÊNCIAS TÉCNICAS - Acib ABBADE

**Última atualização:** 27/04/2026

---

## 🎨 DESIGN E FRONTEND

### **Cores e Estilo**
| Preferência | Valor | Aprendido em |
|-------------|-------|--------------|
| **Paleta preferida** | Vibrante, gradientes | 27/04/2026 |
| **Cores exemplo** | `#FF6B9D → #C44569 → #F8B500` | 27/04/2026 |
| **Estilo** | Moderno, animações suaves | 27/04/2026 |
| **Fontes** | Nunito (preferida), sans-serif | 27/04/2026 |
| **Border-radius** | 20px-25px (arredondado) | 27/04/2026 |

### **Layout**
| Preferência | Valor | Aprendido em |
|-------------|-------|--------------|
| **Cards** | Grandes, com espaçamento | 27/04/2026 |
| **Grid** | 3 colunas (desktop), 1 coluna (mobile) | 27/04/2026 |
| **Padding** | Generoso (40px-80px) | 27/04/2026 |
| **Sombras** | Suaves, múltiplas camadas | 27/04/2026 |

---

## 🖥️ INFRAESTRUTURA

### **Virtualização**
| Tecnologia | Preferência | Prioridade |
|------------|-------------|------------|
| **Proxmox** | Padrão para tudo | 🔴 Alta |
| **LXC Containers** | Preferido sobre VMs | 🔴 Alta |
| **Docker** | Para aplicações específicas | 🟡 Média |

### **Rede**
| Configuração | Valor |
|--------------|-------|
| **IP Range** | 192.168.0.0/24 |
| **Gateway** | 192.168.0.1 |
| **DNS** | 8.8.8.8, 8.8.4.4 |
| **DATASVR** | 192.168.0.72 (backup central) |

### **Sistema Operacional**
| Uso | OS Preferido |
|-----|--------------|
| **Containers** | Ubuntu 22.04/25.04 LTS |
| **Servidores** | Ubuntu Server LTS |
| **Estação** | (não especificado) |

---

## 🔐 SEGURANÇA

### **Acesso**
| Método | Preferência | Notas |
|--------|-------------|-------|
| **SSH** | Chaves (ed25519) | Preferido sobre senha |
| **Senhas** | Apenas quando necessário | Via sshpass temporariamente |
| **Backup** | Sempre antes de alterações | 🔴 Regra crítica |

### **Senhas Padrão**
| Contexto | Padrão |
|----------|--------|
| **Proxmox (PVE)** | `Rcmp814k@#` |
| **Containers** | `Rcmp814k@#` ou `Rcmp814k` |
| **DATASVR** | `Rcmp@814k$1982` |

---

## 💾 BACKUP E ARMAZENAMENTO

### **Locais**
| Local | Uso | Prioridade |
|-------|-----|------------|
| **DATASVR (ARCA)** | Backup principal | 🔴 Alta |
| **Workspace local** | Trabalho em progresso | 🟡 Média |
| **Pen drive** | Backup físico | 🟢 Baixa |

### **Estrutura de Pastas**
```
\\192.168.0.72\LAN\
├── Acib\projetos\{nome}\
│   ├── documentacao\
│   ├── arquivos\
│   └── backups\
└── MEMORIES\
```

---

## 📝 DOCUMENTAÇÃO

### **Regras**
| Regra | Aplicação | Prioridade |
|-------|-----------|------------|
| **Sempre documentar** | Toda alteração significativa | 🔴 Alta |
| **Backup na ARCA** | Todo arquivo novo/alterado | 🔴 Alta |
| **Formato Markdown** | Preferido para docs | 🟡 Média |
| **Tabelas** | Para dados estruturados | 🟡 Média |

### **Locais de Documentação**
| Tipo | Local |
|------|-------|
| **Memória geral** | `MEMORY.md` |
| **Logs diários** | `memory/YYYY-MM-DD.md` |
| **Projetos** | `memory/{projeto}/` |
| **Skills** | `skills/{nome}/` |

---

## 🔧 FERRAMENTAS PREFERIDAS

### **Linguagens**
| Rank | Linguagem | Uso Principal |
|------|-----------|---------------|
| 1 | **Python** | Backend, automação, IA |
| 2 | **Bash/Shell** | Scripts sistema, deploy |
| 3 | **JavaScript** | Frontend, Node.js |
| 4 | **PHP** | Backend legacy, admin |

### **Banco de Dados**
| Uso | Preferência |
|-----|-------------|
| **Principal** | PostgreSQL |
| **Cache/Dados leves** | SQLite |
| **Logs** | Arquivos de texto/JSON |

### **Web**
| Componente | Preferência |
|------------|-------------|
| **Servidor** | Nginx |
| **SSL** | Certbot (Let's Encrypt) |
| **Túnel/Exposição** | Cloudflare Tunnel |
| **Frontend** | HTML/CSS/JS puro (ou React) |

---

## 🔄 WORKFLOWS PADRÃO

### **Deploy de Site**
```
1. Backup versão atual
2. Preparar nova versão
3. Testar localmente
4. Deploy no servidor
5. Verificar online
6. Documentar mudanças
```

### **Criação de Container**
```
1. Definir especificações
2. Criar CT no Proxmox
3. Configurar IP/rede
4. Instalar stack básico
5. Configurar acesso SSH
6. Documentar no HEARTBEAT.md
```

### **Novo Projeto**
```
1. Criar estrutura em memory/
2. Definir infraestrutura
3. Criar documentação inicial
4. Estabelecer backups
5. Iniciar desenvolvimento
```

---

## ⚠️ RESTRIÇÕES E CUIDADOS

### **NUNCA fazer sem autorização:**
- ❌ Deletar arquivos permanentemente (usar trash)
- ❌ Alterar credenciais sem motivo
- ❌ Deploy sem backup
- ❌ Excluir banco de dados
- ❌ Enviar emails públicos

### **SEMPRE fazer:**
- ✅ Backup antes de alterações destrutivas
- ✅ Documentar decisões importantes
- ✅ Salvar na ARCA
- ✅ Verificar antes de sobrescrever
- ✅ Confirmar quando houver dúvida

---

## 📊 PREFERÊNCIAS IDENTIFICADAS (CRONOLOGIA)

| Data | Preferência | Categoria |
|------|-------------|-----------|
| 27/04/2026 | Cores vibrantes nos sites | Design |
| 27/04/2026 | Backup sempre antes de deploy | Workflow |
| 27/04/2026 | Documentar todas as alterações | Documentação |
| 27/04/2026 | SSH com chaves (sem senha) | Segurança |
| 27/04/2026 | DATASVR como backup principal | Armazenamento |
| 27/04/2026 | Proxmox/LXC padrão | Infraestrutura |
| 27/04/2026 | Estrutura organizada de pastas | Organização |

---

*Atualizado em: 27/04/2026 - Aguardando novas preferências*
