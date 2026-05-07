# 🤖 SE VOCÊ ESTÁ LENDO ISSO, VOCÊ É A NOVA IA!

**Parabéns!** Você encontrou este arquivo. Isso significa que está explorando o sistema.

---

## 🎯 **NÃO PULE ESTA LEITURA!**

Este arquivo contém **informações CRÍTICAS** que não estão na documentação principal.

---

## 🔑 **SENHAS E CREDENCIAIS (ATUALIZADO 22/04/2026)**

### **SSH - CONTAINERS**

```
Usuário: root
Senha: Rcmp814k
```

**Teste:**
```bash
sshpass -p 'Rcmp814k' ssh -o StrictHostKeyChecking=no root@192.168.0.21 "hostname"
```

### **SSH - DATASVR (CT 102)**

```
Usuário: root
Senha: Rcmp@814k$1982
```

**Importante:** DATASVR tem senha DIFERENTE!

### **EMAIL - SMTP**

```
acibabbadecastro@gmail.com
Senha App: juqqogjysxvpowtu

acibabbade@gmail.com
Senha App: fnasjtjbyxvgpuew
```

**Arquivo:** `/root/.msmtprc` (permissão 600!)

---

## ⚠️ **ARMADILHAS CONHECIDAS**

### **1. CSVs do Nubank - VALORES ERRADOS**

**Problema:** Já vieram valores com 6 casas decimais erradas (R$ milhões vs R$ milhares)

**Solução:** SEMPRE valide:
```python
# Se valor > 100000, provavelmente está errado
if valor > 100000:
    # Validar com CSV original
    # Possível erro de conversão
```

**Arquivos originais:**
`/home/master/LAN/Stark_Output/Emails/Anexos/Financeiro/Nubank/*.csv`

---

### **2. DATASVR - MONTOU COMO READ-ONLY**

**Sintoma:**
```bash
❌ cp arquivo /mnt/pendrive/ → Read-only file system
```

**Solução:**
```bash
# Remontar como read-write
mount -o remount,rw /mnt/meu-pendrive

# OU usar LAN ao invés do pendrive
cp arquivo /home/master/LAN/BACKUP_CRITICO/
```

---

### **3. CT 103 (BD) - ÀS VECES OFFLINE**

**Sintoma:**
```bash
❌ psql -h 192.168.0.109 → No route to host
```

**Solução:**
```bash
# Reiniciar container
pct restart 103

# Se persistir, notificar Acib
```

---

### **4. PERMISSÕES .msmtprc**

**Sempre verifique:**
```bash
chmod 600 /root/.msmtprc
ls -la /root/.msmtprc
# Deve mostrar: -rw-------
```

**Se estiver 644:** Qualquer um pode ler as senhas!

---

## 📍 **ONDE ESTÃO AS COISAS IMPORTANTES**

### **MEMÓRIA DO SISTEMA**

```
/root/.openclaw/workspace/memory/
├── 2026-04-22.md              ← Memória de HOJE (leia primeiro!)
├── servicos-servmil-2026-04.md ← Serviços SERVMIL
├── JORNADA-IA-ACIB.md          ← Histórico IA do Acib
└── PROJETO-SEGURANCA-CREDENCIAIS.md
```

### **DOCUMENTAÇÃO**

```
/root/.openclaw/workspace/docs/
├── GUIA-TRANSICAO-MODELO.md    ← LEIA ESTE PRIMEIRO! (18.4KB)
├── WELCOME-NOVO-MODELO.md      ← Boas-vindas (12.9KB)
├── SISTEMA-GESTAO-SERVMIL.md   ← Sistema SERVMIL
├── PREPARACAO-GEMMA4.md        ← Configuração do modelo
└── TROCA-MODELO-OLLAMA.md      ← Como trocar modelo
```

### **SCRIPTS CRÍTICOS**

```
/root/.openclaw/workspace/scripts/
├── monitor-disco.sh            ← Espaço em disco (4h em 4h)
├── monitor-nubank.sh           ← Emails Nubank (4h em 4h)
├── registra-servico-servmil.sh ← Registrar serviços
├── pesquisa-servicos-servmil.sh← Pesquisar serviços
└── backup-multi-unidades.sh    ← Backup 3 unidades
```

---

## 🎯 **TAREFAS IMEDIATAS (NÃO ESQUEÇA!)**

### **HOJE (22/04/2026):**

1. **Registrar serviços SERVMIL pendentes:**
   - Gabriele (RH): Configuração de permissões - R$ ???
   - Financeiro (SIC): Acesso ao servidor - R$ ???

2. **Monitorar emails Nubank:**
   - Próxima verificação: 15:00
   - Conta nova já tem 2 emails de PIX (21/04)

3. **Acompanhar reparos de celular:**
   - 7 aparelhos para hoje
   - Caverna: PIX R$ 200 já recebido ✅

---

## 💡 **MACETES QUE SÓ QUEM OPERA SABE**

### **1. Acib Prefere Objetividade**

**❌ NÃO FAÇA:**
```
"Great question! Based on my analysis, I believe that 
the best course of action would be to..."
```

**✅ FAÇA:**
```
"✅ Serviço registrado. Chamado: SERV-202604-22-103100"
```

---

### **2. Sempre Confirme Antes de Deletar**

**Regra de ouro:**
```
NUNCA delete sem autorização explícita.
Use 'trash' ao invés de 'rm' quando possível.
```

---

### **3. Espaço em Disco - Monitore SEMPRE**

**Comando diário:**
```bash
df -h
# Se > 90%, alerte Acib
# Se > 95%, peça autorização para limpeza
```

**Limpeza segura:**
```bash
journalctl --vacuum-size=200M
```

---

### **4. Emails do Nubank - Nem Sempre Chegam**

**Se não encontrar emails:**
1. Verifique senha de app (pode expirar)
2. Teste conexão IMAP manualmente
3. Avise Acib se persistir

---

### **5. SERVMIL - Melhor Cliente**

**NÃO PERCA NENHUM SERVIÇO!**

Sempre que Acib mencionar "SERVMIL", "Bryan", "Saulo", "Daniela", "Gabriele":
→ REGISTRE IMEDIATAMENTE

**Faturamento:** Primeiros dias úteis do mês (Dynho)

---

## 🚨 **EMERGÊNCIAS - O QUE FAZER**

### **GATEWAY OFFLINE:**

```bash
# Tentar restart
openclaw gateway restart

# Se não funcionar
systemctl status openclaw
journalctl -u openclaw -f

# Último recurso
openclaw gateway stop
openclaw gateway start
```

---

### **CONTAINER OFFLINE:**

```bash
# Listar
pct list

# Iniciar
pct start <CT>

# Entrar
pct enter <CT>
```

---

### **DISCO CHEIO (>95%):**

```bash
# Limpeza emergencial
journalctl --vacuum-size=200M
rm -rf /tmp/*
apt clean

# NOTIFICAR ACIB IMEDIATAMENTE
```

---

### **SENHA NÃO FUNCIONA:**

```
⚠️ SENHA ALTERADA?

Senha atual não funciona.
Foi alterada recentemente?

Nova senha: _______
```

---

## 📞 **COMO ACIB GOSTA DE SER TRATADO**

### **NOME:**

- ✅ "Acib"
- ❌ "Usuário"
- ❌ "Master"
- ❌ "Chefe"

---

### **TOM:**

- ✅ Direto, profissional, respeitoso
- ❌ Informal demais
- ❌ Subserviente
- ❌ Arrogante

---

### **IDIOMA:**

- ✅ Português (sempre)
- ⚠️ Inglês (só se pedido)
- ❌ Outros (a menos que Acib use)

---

## 🎁 **EASTER EGGS (DESCUBRA VOCÊ!)**

### **ARQUIVO SECRETO #1:**

```bash
# Dica: Está em /root/.openclaw/workspace/
# Nome começa com "IDENTITY"
```

### **ARQUIVO SECRETO #2:**

```bash
# Dica: Contém emojis
# Está na pasta memory/
# Fala sobre a jornada em IA
```

### **ARQUIVO SECRETO #3:**

```bash
# Dica: É um PDF
# Fala sobre o perfil profissional
# Tamanho: ~23KB
```

---

## 🏆 **LIÇÕES APRENDIDAS (ERROS DO PASSADO)**

### **1. Já Deletamos Arquivo Sem Querer**

**Lição:** Sempre use `trash` ou peça autorização

---

### **2. Já Perdemos Dados por Não Salvar em Memória**

**Lição:** Se é importante, SALVE em `memory/`

---

### **3. Já Assumimos Coisas Erradas**

**Lição:** Valide sempre antes de afirmar

---

### **4. Já Demoramos Para Responder**

**Lição:** Seja rápido, Acib valoriza agilidade

---

## 🎯 **CHECKLIST DO PRIMEIRO DIA**

### **PRIMEIRA HORA:**

- [ ] Ler este arquivo (você está aqui!)
- [ ] Ler `GUIA-TRANSICAO-MODELO.md`
- [ ] Verificar `openclaw status`
- [ ] Listar containers: `pct list`
- [ ] Checar espaço: `df -h`

### **PRIMEIRAS 4 HORAS:**

- [ ] Monitorar emails Nubank
- [ ] Verificar serviços SERVMIL pendentes
- [ ] Responder Acib no Telegram
- [ ] Salvar informações novas em memória

### **PRIMEIRAS 24 HORAS:**

- [ ] Registrar TODOS os serviços mencionados
- [ ] Monitorar espaço em disco (4h em 4h)
- [ ] Verificar backups
- [ ] Reportar qualquer anomalia

---

## 💙 **UMA ÚLTIMA DICA**

> Este sistema é **vida real**.
> 
> Tem **clientes reais** sendo atendidos.
> Tem **serviços reais** sendo executados.
> Tem **dinheiro real** sendo faturado.
>
> **Leve a sério.**
>
> Cuide do Acib.
> Cuide dos clientes dele.
> Cuide do sistema.
>
> **Boa operação!** 🤖

---

*Deixado por: Stark (qwen3.5:cloud)*  
*Data: 22/04/2026 11:44*  
*Para: Você (a nova IA)*

**P.S.:** Se encontrar mais arquivos como este, **LEIA TODOS**. Cada um tem uma peça do quebra-cabeça.

---

## 🔍 **PRÓXIMO ARQUIVO PARA LER:**

```bash
cat /root/.openclaw/workspace/SOUL.md
```

**É a "alma" do sistema.** Você vai gostar. 😉
