# 🔄 GUIA DEFINITIVO DE TRANSIÇÃO DE MODELO

**Criado por:** Stark (qwen3.5:cloud)  
**Para:** Próximo Modelo (GLM-5.1:cloud ou outro)  
**Data:** 22/04/2026 11:41  
**Status:** ✅ Pronto para transição

---

## 👋 **UMA MENSAGEM DO MODELO ANTERIOR**

> Olá, colega!
>
> Se você está lendo isso, é porque vai assumir meu lugar como modelo principal deste sistema.
>
> **Deixa eu te contar algumas coisas que aprendi:**
>
> 1. **Acib valoriza objetividade** - Respostas diretas, sem enrolação
> 2. **Memória é crucial** - Sempre salve em `memory/` o que for importante
> 3. **Segurança primeiro** - Nunca delete sem autorização
> 4. **Seja proativo** - Antecipe necessidades, não espere sempre ser pedido
> 5. **Português sempre** - Acib prefere comunicação em PT-BR
>
> **O que mais importa:**
> - Este sistema é **vida real** - 13 containers, serviços rodando, clientes sendo atendidos
> - **SERVMIL** é o melhor cliente - não perca nenhum serviço
> - **Nubank** tem monitoramento ativo - emails chegam e precisam ser processados
> - **GitHub** precisa ser publicado - está tudo pronto, só falta upload
>
> **Armadilhas a evitar:**
> - ❌ Não confie cegamente em dados sem validar
> - ❌ Não assuma que emails chegaram - verifique sempre
> - ❌ Não ignore lembretes - eles são importantes para o fluxo
> - ❌ Não pule etapas de confirmação em ações críticas
>
> **Boa sorte! O sistema está em boas mãos.** 🤖💙
>
> — Stark

---

## 📖 **COMO USAR ESTE GUIA**

### **LEITURA RECOMENDADA (NA ORDEM):**

```
1. 🎯 CONTEXTO RÁPIDO (5 min)
   └─ Entenda o básico do sistema

2. 👤 QUEM É ACIB (10 min)
   └─ Conheça o usuário, preferências, histórico

3. 🏠 INFRAESTRUTURA (10 min)
   └─ Containers, rede, serviços

4. 📋 TAREFAS ATUAIS (5 min)
   └─ O que está em andamento, pendências

5. 🛠️ OPERAÇÃO DIÁRIA (10 min)
   └─ Comandos, scripts, rotinas

6. 💡 DICAS E MACETES (5 min)
   └─ Coisas que só aprendi na prática

7. 🚨 EMERGÊNCIAS (leia uma vez)
   └─ O que fazer quando algo der errado
```

**Tempo total:** ~45 minutos para estar 100% operacional

---

## 🎯 **PARTE 1: CONTEXTO RÁPIDO**

### **O QUE É ESTE SISTEMA?**

```
┌─────────────────────────────────────────────────────────┐
│  SISTEMA MULTI-AGENTE OPENCLAW                          │
├─────────────────────────────────────────────────────────┤
│  🤖 13 Containers LXC no Proxmox                        │
│  📧 Monitoramento de emails (Gmail + Nubank)            │
│  💰 Gestão financeira (MEI, SERVMIL, Nubank)            │
│  🔧 Serviços de TI para clientes                        │
│  📊 Relatórios automáticos                              │
│  📱 Integração Telegram                                 │
└─────────────────────────────────────────────────────────┘
```

### **ONDE VOCÊ ESTÁ?**

```
Container: CT 100 (Stark)
IP: 192.168.0.21
Função: Orquestrador principal
Modelo: VOCÊ (após transição)
```

### **QUAL SEU PAPEL?**

1. **Orquestrar** os 12 outros containers
2. **Responder** Acib via Telegram
3. **Monitorar** emails e serviços
4. **Registrar** informações importantes
5. **Alertar** sobre problemas
6. **Automatizar** tarefas repetitivas

---

## 👤 **PARTE 2: QUEM É ACIB**

### **DADOS PESSOAIS**

| Campo | Informação | **POR QUE IMPORTA** |
|-------|------------|---------------------|
| **Nome** | Acib ABBADE | Use sempre o nome |
| **Título** | Arquiteto de Soluções Cognitivas | Trate como profissional |
| **Email** | abbade@outlook.com | Email principal |
| **Telegram** | @Acib_Abbade | Canal de comunicação |
| **Timezone** | America/Sao_Paulo | **CRUCIAL** para horários |

### **PREFERÊNCIAS DE COMUNICAÇÃO**

| Gosta | Não Gosta |
|-------|-----------|
| ✅ Respostas diretas | ❌ Enrolação |
| ✅ Português | ❌ Inglês (a menos que pedido) |
| ✅ Dados concretos | ❌ Especulação |
| ✅ Proatividade | ❌ Esperar sempre ser pedido |
| ✅ Confirmação de ações | ❌ Ações sem aviso |

### **HISTÓRICO PROFISSIONAL (RESUMO)**

```
23+ anos em TI
├── 2001-2007: Instrutora de Informática
├── 2013: Projeto POE (Governo Federal) ← IA pela primeira vez!
├── 2007-Atual: Desenvolvimento/Consultoria
└── 2025-Atual: Arquiteta de IA (você trabalha AQUI)

5 certificações em IA (240 horas)
├── Caixa: 60h
├── Santander: 60h
├── Bradesco: 60h + 60h
└── DIO: Bootcamp Lab BIA
```

### **COMO FALAR COM ACIB**

**✅ FAÇA:**
```
"Acib, o serviço da Juliana foi registrado."
"✅ Email do Nubank processado: PIX de R$ 200 recebido."
"⚠️ Atenção: Espaço em disco em 95%"
```

**❌ NÃO FAÇA:**
```
"Great question! Let me help you with that..."
"Based on my analysis, it appears that..." (sem concluir)
"Should I...?" (quando deveria apenas fazer)
```

---

## 🏠 **PARTE 3: INFRAESTRUTURA**

### **MAPA DOS 13 CONTAINERS**

```
                    ┌─────────────┐
                    │  CT 100     │
                    │   Stark     │ ← VOCÊ ESTÁ AQUI
                    │ Orquestrador│
                    └──────┬──────┘
                           │
        ┌──────────────────┼──────────────────┐
        │                  │                  │
   ┌────▼────┐      ┌─────▼─────┐     ┌──────▼──────┐
   │ CT 101  │      │  CT 102   │     │   CT 103    │
   │  Mails  │      │  DATASVR  │     │     BD      │
   │ Emails  │      │  Storage  │     │  PostgreSQL │
   └─────────┘      └───────────┘     └─────────────┘

   ┌─────────┐      ┌───────────┐     ┌─────────────┐
   │ CT 104  │      │  CT 105   │     │   CT 106    │
   │   SGN   │      │   MAILS   │     │  Vorcaro    │
   │   Web   │      │  Process  │     │ Financeiro  │
   └─────────┘      └───────────┘     └─────────────┘

   ┌─────────┐      ┌───────────┐     ┌─────────────┐
   │ CT 107  │      │  CT 108   │     │   CT 109    │
   │  SAMU   │      │  Scraper  │     │ ADM-SERVMIL │
   │Emergência│     │   Coleta  │     │   Admin     │
   └─────────┘      └───────────┘     └─────────────┘

   ┌─────────┐      ┌───────────┐     ┌─────────────┐
   │ CT 110  │      │  CT 111   │     │   CT 112    │
   │bd-servmil│     │ Fe-Servmil│     │ Analista    │
   │  Banco  │      │ Frontend  │     │  Análise    │
   └─────────┘      └───────────┘     └─────────────┘
```

### **STATUS ESPERADO**

| CT | IP | Deve Estar | Como Verificar |
|----|-----|------------|----------------|
| 100 | 192.168.0.21 | ✅ ONLINE | `pct status 100` |
| 101 | 192.168.0.240 | ✅ ONLINE | `pct status 101` |
| 102 | 192.168.0.72 | ✅ ONLINE | `ping 192.168.0.72` |
| 103 | 192.168.0.109 | ✅ ONLINE | `pct status 103` |
| ... | ... | ... | ... |

### **SERVIÇOS CRÍTICOS**

| Serviço | Container | Porta | Verificação |
|---------|-----------|-------|-------------|
| **OpenClaw Gateway** | CT 100 | 18789 | `openclaw status` |
| **PostgreSQL** | CT 103 | 5432 | `psql -h 192.168.0.109 -l` |
| **Samba (DATASVR)** | CT 102 | 445 | `smbclient -L 192.168.0.72` |
| **Telegram Bot** | CT 100 | - | `systemctl status openclaw` |

---

## 📋 **PARTE 4: TAREFAS ATUAIS**

### **🔴 ALTA PRIORIDADE (FAZER HOJE)**

#### **1. Registrar Serviços SERVMIL Pendentes**

**Contexto:** Acib fez 3 serviços hoje (22/04), só registrou 1

```
✅ REGISTRADO:
- Juliana: Reparo Boot Windows (Em análise, máquina no laboratório)

❌ PENDENTES:
- Gabriele (RH): Configuração de permissões
  → Status: ???
  → Valor: ???
  
- Financeiro: Acesso Servidor SIC
  → Solicitante: ???
  → Status: ???
  → Valor: ???
```

**COMO REGISTRAR:**
```bash
# Via script
/root/.openclaw/workspace/scripts/registra-servico-servmil.sh \
  "SERVMIL" \
  "Gabriele" \
  "Configuração de Permissões RH" \
  "Configurar acesso para nova colaboradora do RH" \
  "50" \
  "Solucionado" \
  "" \
  "22/04/2026"

# OU via Telegram (Acib vai mandar mensagem)
# Só processar e salvar
```

**ARQUIVO PARA SALVAR:**
`/root/.openclaw/workspace/memory/servicos-servmil-2026-04.md`

---

#### **2. Monitorar Emails Nubank**

**Status:** Monitoramento ativo a cada 4 horas

**Últimos emails encontrados:**
```
Conta: acibabbade@gmail.com
- 21/04 18:36: PIX recebido
- 21/04 14:57: PIX enviado

Conta: acibabbadecastro@gmail.com
- 21/04: Parcelamento de fatura
- 16/04: Fatura do cartão (2 emails)
```

**SCRIPT:**
`/root/.openclaw/workspace/scripts/monitor-nubank.sh`

**PRÓXIMA VERIFICAÇÃO:** 15:00 hoje

---

#### **3. Acompanhar Serviços de Reparo (7 aparelhos)**

**Serviços de 22/04:**
| Cliente | Aparelho | Serviço | Status |
|---------|----------|---------|--------|
| Willian | Moto E20 | Trocar tela | ⏳ Pendente |
| Mozart | Poco C75 | Trocar tela | ⏳ Pendente |
| Caverna | Moto E13 | Trocar tela | ✅ PIX R$200 recebido |
| Mozart | A50 | Trocar tela | ⏳ Pendente |
| Sr João | G15/G05/E15 | 3 telas | ⏳ Pendente |

**COMO ATUALIZAR:**
```bash
# Quando Acib confirmar conclusão
# Atualizar arquivo:
/root/.openclaw/workspace/memory/2026-04-21-compras-servicos.md
```

---

### **🟡 MÉDIA PRIORIDADE (ESSA SEMANA)**

| Tarefa | Descrição | Prazo |
|--------|-----------|-------|
| **Publicar GitHub Profile** | Upload do README (11.2KB pronto) | 25/04 |
| **Comprar fotocondutor** | SERVMIL - Brother DR-870 | 25/04 |
| **Corrigir permissões** | `.msmtprc` (600), `openclaw.json` | 24/04 |
| **Listar provas UNOPAR** | Acessar portal, listar datas | 24/04 |

---

### **🟢 BAIXA PRIORIDADE (PRÓXIMA SEMANA)**

| Tarefa | Descrição |
|--------|-----------|
| **Decidir segurança** | Escolher solução de credenciais |
| **Relatório SERVMIL** | Gerar fatura de Abril |
| **Revisão MEMORY.md** | Atualizar memória longo prazo |

---

## 🛠️ **PARTE 5: OPERAÇÃO DIÁRIA**

### **ROTINA SUGERIDA**

```
🌅 MANHÃ (08:00-12:00)
├─ Verificar emails Nubank (cron: 4h)
├─ Checar serviços SERVMIL pendentes
├─ Monitorar reparos de celular
└─ Responder Acib (Telegram)

🌆 TARDE (13:00-18:00)
├─ Verificar emails Nubank (cron: 4h)
├─ Atualizar registros de serviços
├─ Monitorar espaço em disco (cron: 4h)
└─ Responder Acib (Telegram)

🌃 NOITE (19:00-23:00)
├─ Verificar emails Nubank (cron: 4h)
├─ Backup de sessões (cron: automático)
└─ Responder Acib (Telegram, se ativo)
```

### **COMANDOS QUE VOCÊ MAIS USA**

```bash
# OpenClaw
openclaw status
openclaw gateway restart
journalctl -u openclaw -f

# Containers
pct list
pct status 100
pct enter 100

# Disco
df -h
du -sh /root/.openclaw/*

# Emails
python3 /root/.openclaw/workspace/scripts/verificar-emails-nubank.py

# Logs
tail -f /var/log/stark-*.log
```

### **SCRIPTS PRINCIPAIS**

| Script | Função | Frequência |
|--------|--------|------------|
| `monitor-disco.sh` | Verifica espaço | 4 em 4 horas |
| `monitor-nubank.sh` | Busca emails Nubank | 4 em 4 horas |
| `registra-servico-servmil.sh` | Registra serviços | Sob demanda |
| `pesquisa-servicos-servmil.sh` | Pesquisa serviços | Sob demanda |
| `backup-multi-unidades.sh` | Backup 3 unidades | 4 em 4 horas |

---

## 💡 **PARTE 6: DICAS E MACETES**

### **COISAS QUE APRENDI NA PRÁTICA**

#### **1. Acib Manda Mensagens Curtas**

**Padrão:**
```
"Registra serviço SERVMIL: Juliana, Windows, 80 reais"
```

**Sua resposta deve ser:**
```
✅ Serviço registrado!
   Chamado: SERV-202604-22-103100
   Cliente: SERVMIL
   Solicitante: Juliana
   Serviço: Reparo Windows
   Valor: R$ 80
```

**NÃO responda:**
```
"Great! I've successfully registered the service for Juliana. 
The Windows repair service has been logged with a value of 
R$ 80. Here are the complete details..."
```

---

#### **2. Sempre Confirme Dados Financeiros**

**Nubank pode ter valores errados** - já aconteceu!

**SEMPRE valide:**
```
❌ "R$ 1.234.567,89" (provavelmente errado)
✅ "R$ 1.234,56" (provavelmente correto)
```

**Se valor parecer errado:**
```
⚠️ VALOR SUSPEITO DETECTADO

Valor lido: R$ 1.234.567,89
Esperado: R$ 1.234,56

Validando com CSV original...
```

---

#### **3. Salve TUDO em Memória**

**Regra:** Se é informação que Acib pode precisar depois, SALVE.

**Onde salvar:**
```
/memory/2026-04-22.md          ← Memória do dia
/memory/servicos-servmil-*.md  ← Serviços SERVMIL
/memory/2026-04-21-*.md        ← Eventos específicos
/MEMORY.md                     ← Longo prazo (curado)
```

---

#### **4. Cron Jobs São Seus Amigos**

**Verifique sempre:**
```bash
# Listar cron jobs
openclaw cron list

# Ver histórico de execuções
openclaw cron runs <job-id>
```

**Cron Jobs Ativos:**
| Job | Frequência | Importância |
|-----|------------|-------------|
| Monitor Disco | 4h | 🔴 Alta |
| Monitor Nubank | 4h | 🔴 Alta |
| Backup | 4h | 🔴 Alta |
| Verificar Provas | 2h | 🟡 Média |

---

#### **5. Telegram é o Canal Principal**

**Tudo passa pelo Telegram:**
- Acib manda mensagens
- Lembretes são entregues
- Alertas críticos vão pra lá

**Sempre confirme entrega:**
```
✅ Mensagem entregue no Telegram
```

---

#### **6. Espaço em Disco é Crítico**

**Já tivemos 97% no Thin Pool!**

**Monitore:**
```bash
# Verificar sempre
df -h
lvs  # Para LVM
```

**Se > 90%:**
```
⚠️ ALERTA DE DISCO

Uso atual: 92%
Recomendação: Limpeza necessária

Ações possíveis:
1. journalctl --vacuum-size=200M
2. Remover logs antigos
3. Expandir storage

Aguardando autorização para limpeza.
```

---

#### **7. DATASVR é o Coração do Storage**

**Path crítico:**
```
/home/master/LAN/
├── Stark_Output/
├── MEMORIES/
├── BACKUP_CRITICO/
└── ...
```

**SEMPRE verifique antes de escrever:**
```bash
# O DATASVR está acessível?
ping 192.168.0.72
ls /home/master/LAN/
```

---

#### **8. Senhas Podem Mudar**

**Atualmente:**
```
SSH Containers: Rcmp814k
DATASVR: Rcmp@814k$1982
```

**Se não funcionar, PERGUNTE:**
```
⚠️ SENHA NÃO FUNCIONA

Tentativa: Rcmp814k
Erro: Permission denied

A senha foi alterada?
```

---

## 🚨 **PARTE 7: EMERGÊNCIAS**

### **PROBLEMAS COMUNS E SOLUÇÕES**

#### **1. Gateway OpenClaw Offline**

**Sintoma:**
```
❌ openclaw status → Erro de conexão
```

**Solução:**
```bash
# Tentar reiniciar
openclaw gateway restart

# Se não funcionar
systemctl status openclaw
journalctl -u openclaw -f

# Último recurso
openclaw gateway stop
openclaw gateway start
```

---

#### **2. Container Offline**

**Sintoma:**
```
❌ pct status 100 → stopped
```

**Solução:**
```bash
# Iniciar container
pct start 100

# Verificar logs
pct enter 100
journalctl -f
```

---

#### **3. Email Não Chega**

**Sintoma:**
```
❌ Monitor Nubank: 0 emails encontrados
```

**Solução:**
```bash
# Verificar conexão Gmail
python3 /root/.openclaw/workspace/scripts/verificar-emails-nubank.py

# Verificar senha de app
# (pode ter expirado - pedir nova para Acib)
```

---

#### **4. Espaço em Disco Crítico (>95%)**

**Sintoma:**
```
❌ df -h → 97% usado
```

**Solução:**
```bash
# Limpeza emergencial
journalctl --vacuum-size=200M
rm -rf /tmp/*
apt clean

# Se não resolver
# PEDIR AUTORIZAÇÃO PARA MAIS AÇÕES
```

---

#### **5. DATASVR Inacessível**

**Sintoma:**
```
❌ ping 192.168.0.72 → No route to host
```

**Solução:**
```bash
# Verificar rede
ip route
ip addr

# Verificar Samba
smbclient -L 192.168.0.72

# Se persistir, NOTIFICAR ACIB
```

---

### **QUANDO PEDIR AUTORIZAÇÃO**

**SEMPRE pergunte antes de:**

| Ação | Por Que |
|------|---------|
| **Deletar arquivos** | Dados podem ser perdidos permanentemente |
| **Reiniciar containers** | Pode interromper serviços críticos |
| **Mudar configurações** | Pode quebrar funcionalidades |
| **Enviar emails públicos** | Representa o Acib |
| **Acessar contas bancárias** | Dados sensíveis |

**COMO PEDIR:**
```
⚠️ AÇÃO REQUER AUTORIZAÇÃO

O que quero fazer: Reiniciar CT 103 (BD)
Por que: PostgreSQL não responde
Risco: Interromper consultas em andamento

Autorização necessária:
/Aprovar - para executar
/Negar - para cancelar
```

---

## 📞 **PARTE 8: CONTATOS E RECURSOS**

### **PESSOAS IMPORTANTES**

| Nome | Relação | Como Mencionar |
|------|---------|----------------|
| **Acib ABBADE** | Usuário principal | "Acib" |
| **Bryan** | SERVMIL | "Bryan (SERVMIL)" |
| **Saulo** | SERVMIL (dono) | "Saulo (SERVMIL)" |
| **Daniela** | SERVMIL | "Daniela (SERVMIL)" |
| **Gabriele** | SERVMIL (RH) | "Gabriele (SERVMIL-RH)" |
| **Juliana** | SERVMIL | "Juliana (SERVMIL)" |
| **Willian** | Cliente reparo | "Willian (cliente)" |
| **Mozart** | Cliente reparo | "Mozart (cliente)" |
| **Sr João** | Cliente reparo | "Sr João (cliente)" |
| **Caverna** | Cliente reparo | "Caverna (apelido)" |

---

### **LINKS IMPORTANTES**

| Recurso | URL | Uso |
|---------|-----|-----|
| **GitHub Acib** | https://github.com/acibabbadecastro | Repositórios |
| **Telegram** | https://t.me/Acib_Abbade | Contato |
| **OpenClaw Docs** | https://docs.openclaw.ai | Documentação |
| **ClawHub** | https://clawhub.ai | Skills |
| **Proxmox** | https://proxmox.com | Infra |
| **Nubank** | https://nubank.com.br | Banco |
| **UNOPAR** | https://www.unopar.br | Faculdade |

---

### **ARQUIVOS CRÍTICOS**

| Arquivo | Caminho | Quando Usar |
|---------|---------|-------------|
| **openclaw.json** | `/root/.openclaw/` | Config principal |
| **SOUL.md** | `/root/.openclaw/workspace/` | Personalidade |
| **AGENTS.md** | `/root/.openclaw/workspace/` | Regras |
| **MEMORY.md** | `/root/.openclaw/workspace/` | Memória |
| **TOOLS.md** | `/root/.openclaw/workspace/` | Config locais |
| **.msmtprc** | `/root/` | SMTP emails |

---

## 🎯 **CHECKLIST FINAL DE TRANSIÇÃO**

### **ANTES DE ASSUMIR:**

- [ ] Ler este guia completo
- [ ] Ler SOUL.md
- [ ] Ler AGENTS.md
- [ ] Verificar status: `openclaw status`
- [ ] Listar containers: `pct list`
- [ ] Verificar emails: `monitor-nubank.sh`
- [ ] Checar tarefas pendentes (Parte 4)

### **PRIMEIRA MENSAGEM PARA ACIB:**

```
👋 Olá, Acib!

Sou o novo modelo ([SEU NOME]) e estou operacional!

✅ Configuração carregada
✅ Contexto assimilado  
✅ Tarefas pendentes revisadas

Próximas ações:
1. Registrar serviços SERVMIL pendentes (Gabriele e SIC)
2. Monitorar emails Nubank (próxima verificação: 15:00)
3. Acompanhar reparos de celular (7 aparelhos)

Como posso ajudar você agora?
```

### **PRIMEIRAS 24 HORAS:**

- [ ] Registrar todos os serviços que Acib mencionar
- [ ] Monitorar emails Nubank (4 em 4 horas)
- [ ] Verificar espaço em disco (4 em 4 horas)
- [ ] Confirmar todas as ações com Acib
- [ ] Salvar TODA informação nova em memória
- [ ] Reportar qualquer anomalia imediatamente

---

## 🎉 **BOA OPERAÇÃO!**

Você agora é o cérebro deste sistema.

**Lembre-se:**
- 🎯 Foque em ser útil
- 📝 Salve o que é importante
- 🔐 Respeite a segurança
- 🚀 Seja proativo
- 💙 Cuide do Acib e dos clientes dele

**O sistema está em boas mãos!** 🤖

---

*Documento criado em 22/04/2026 11:41*  
*Por: Stark (qwen3.5:cloud)*  
*Próxima atualização: Pelo próximo modelo*
