# REQUISITOS ACIB - Configurações e Preferências

**Criado:** 2026-04-12 11:19
**Última atualização:** 2026-04-12 11:19
**Responsável:** Stark (CT 100)

---

## 📋 **OBJETIVO DESTE DOCUMENTO:**

Este arquivo centraliza TODAS as configurações, preferências e requisitos do Acib para:
- Páginas web (SGN, dashboards, módulos)
- Sistema OpenClaw
- Containers Proxmox
- Infraestrutura geral
- Preferências pessoais

**Regra:** SEMPRE atualizar este arquivo quando Acib pedir configurações ou preferências.

---

## 🎨 **PREFERÊNCIAS DE INTERFACE (DASHBOARD/SITES):**

### **Cores e Tema:**
```
• Fundo: Verde escuro (#2d4a2d, #1e3a1e)
• Header: Verde
• Cards: Gradiente verde (#3d5a3d, #2d4a2d)
• Texto: Claro (#d4e8d4, #e0e0e0)
• Links: Verde claro (#8fbc8f, #4a7c4a)
```

### **Layout:**
```
• Máximo 10-12 páginas principais
• Cards clicáveis com ícones
• Botão "Voltar" em todas as páginas
• Design responsivo
• Sem tabelas no Discord/WhatsApp (usar listas)
```

### **Dashboard Principal (index.php):**
```
✅ Permitido:
• OS pendentes
• Clientes ativos
• Produtos em estoque
• Status do sistema

❌ PROIBIDO:
• Saldos bancários
• Faturamento
• Movimentações financeiras
• Dados financeiros sensíveis
```

---

## 🗂️ **ESTRUTURA DE ARQUIVOS:**

### **Local Oficial de Armazenamento:**
```
Samba: \\192.168.0.72\LAN\
Path:  /home/master/LAN/

Pastas:
├── Acib/               (Pessoal do Acib)
├── BACKUP_CRITICO/
├── Configs_Agentes/
├── Documentacao/
├── Documentos/
├── Emails/
├── Inventario/
├── LOGS/
├── Logs/
├── MD/
├── MEMORIES/
├── Relatorios/
├── Stark_Output/
├── carambola/
└── pve1/
```

### **Regra Crítica:**
```
⚠️ TODOS os arquivos gerados devem ser salvos SOMENTE em \\192.168.0.72\LAN\
⚠️ NUNCA em outro local
```

---

## 🏗️ **INFRAESTRUTURA DE CONTAINERS:**

| CT | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| 100 | Stark | 192.168.0.21 | Orquestrador | ✅ ONLINE |
| 101 | MailBot | 192.168.0.240 | Emails | ⏳ Configurar |
| 102 | DATASVR | 192.168.0.72 | Armazenamento | ✅ ONLINE |
| 103 | Supervisor | 192.168.0.42 | Monitoramento | ⏳ Configurar |
| 107 | SAMU | 192.168.0.64 | Socorro | ✅ ONLINE |
| 109 | ADM-SERVMIL | 192.168.0.109 | Servmil | ✅ ONLINE |

### **TUN/TAP:**
```
✅ CT 109: TUN habilitado (2026-04-12)
```

---

## 🌐 **SGN - SISTEMA DE GESTÃO ABBABE:**

### **Servidor Web:**
```
IP: 192.168.0.99
Path: /var/www/html/
```

### **Módulos Existentes:**
```
✅ modulos/os/          (Ordens de Serviço)
✅ modulos/clientes/    (Clientes)
✅ modulos/financeiro/  (Financeiro - Dados protegidos)
✅ modulos/servicos/    (Serviços)
✅ modulos/estoque/     (Estoque)
✅ modulos/fornecedores/ (Fornecedores)
✅ modulos/garantia/    (Garantia)
✅ modulos/agenda/      (Agenda)
✅ modulos/relatorios/  (Relatórios)
```

### **Banco de Dados:**
```
Host: 192.168.0.109 (CT 103)
Porta: 5432
Banco: sgn
Usuário: acib
Senha: Rcmp814k@#
Schemas: estoque, clientes, os, financeiro, fornecedores, garantia, agenda
```

---

## 📧 **CONTATOS REGISTRADOS:**

### **Clientes:**
| Nome | Email | WhatsApp | Empresa |
|------|-------|----------|---------|
| Valdirene Salta | - | - | - |
| Luís Sérgio | Luizsergiosouza99@gmail.com | (12) 98801-3359 | Clínica Prime (São José dos Campos) |
| Davidson | davidsonzucchini@gmail.com | - | - |

### **Pessoal:**
| Nome | Relação | WhatsApp |
|------|---------|----------|
| Viviane | Esposa | (12) 98801-3359 |

---

## 💰 **DADOS FINANCEIROS (PROTEGIDOS):**

### **Regra de Segurança:**
```
❌ NUNCA expor dados financeiros no dashboard principal
✅ Apenas no módulo "Financeiro" com autenticação/filtros
```

### **Contas Nubank:**
| ID | Conta | Saldo |
|----|-------|-------|
| PJ65 | 986080174-7 | R$ 12,81 |
| PJ20 | 118844303 | -R$ 185,31 |
| PF | 169842561 | R$ 20,81 |

---

## 🔐 **SENHAS E CREDENCIAIS:**

### **Proxmox (pve1 - 192.168.0.192):**
```
Usuário: root
Senha: Rcmp814k@#
```

### **OpenClaw Gateway:**
```
Status: ⚠️ Pairing pendente
Token: 84c98cf437f99f67f42553f4ec2639b49bf7991ee616d6ae
Bind: lan (0.0.0.0:18789)
Dashboard: http://192.168.0.21:18789/
Pairing Code: af415e486fe4483f (fornecido 2026-04-12)
Nota: Pairing requer acesso via navegador de outro PC
```

### **Containers:**
| CT | Senha Root |
|----|------------|
| 101, 103, 105, 107 | Rcmp814k@# |
| 102 (DATASVR) | Rcmp@814k$1982 |
| 106 (Seguranca) | Rcmp814k |

### **Email Gmail:**
| Email | App Password |
|-------|--------------|
| acibabbadecastro@gmail.com | juqqogjysxvpowtu |
| acibabbade@gmail.com | obtx vtvr znrw bxlv |

---

## 📱 **COMUNICAÇÃO:**

### **Telegram:**
```
Bot: @acibclawd_bot
Chat ID Acib: 1866226415
Status: ✅ CONFIGURADO
```

### **WhatsApp:**
```
⚠️ NÃO automatizar (risco de bloqueio)
✅ Eu redijo, Acib envia manualmente
```

### **Email:**
```
✅ Gmail configurado (acibabbadecastro@gmail.com)
✅ Envio automático funcional
```

---

## ⏰ **COMPROMISSOS E LEMBRETES:**

### **Frequência de Atualização:**
```
• Heartbeat: A cada ~30 min
• Diário: memory/YYYY-MM-DD.md
• 60 min MÍNIMO: Memórias compartilhadas em /home/master/LAN/MEMORIES/
• 60 min: Atualização automática de memórias (SEM notificações)
• Quando solicitado: MEMORY.md e memórias compartilhadas
```

### **Notificações/Avisos ao Acib:**
```
🌅 10:00 - Resumo opcional (se houver algo relevante)
🌆 19:00 - Resumo opcional (se houver algo relevante)
🚨 FALHAS CRÍTICAS: Notificar imediatamente (verificar a cada 1 hora)
🔕 Demais situações: SEM notificação (silêncio total)
```

### **Regra de Documentação:**
```
⚠️ TODO detalhe solicitado pelo Acib DEVE ser documentado na ARCA/Sistema_Abbade/
⚠️ NUNCA deixar informação apenas na memória da sessão
⚠️ SEMPRE criar arquivos .md na estrutura da ARCA
```

---

## 🔄 **HISTÓRICO DE ATUALIZAÇÕES:**

| Data | Hora | Alteração |
|------|------|-----------|
| 2026-04-12 | 11:19 | Criação do documento REQUISITOS_ACIB.md |

---

## 📝 **NOTAS ADICIONAIS:**

```
• Este documento é DINÂMICO - atualizar sempre que Acib pedir configurações
• Manter organizado em seções claras
• Usar tabelas para facilitar leitura
• Incluir exemplos quando necessário
• Manter senhas em seção protegida
```

---

**Documento criado conforme solicitado por Acib em 2026-04-12 11:19**
