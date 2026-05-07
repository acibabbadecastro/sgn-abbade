# 📋 CHECK-ATUALIZACOES - STARK

**Frequência:** 1x por dia (conforme REGRA CRÍTICA RC-001)  
**Horário:** Definido por Acib  
**Local ARCA:** `\\192.168.0.72\LAN\Acib\REGRAS_STARK\checklists\`

---

## 🔴 PROCEDIMENTO OBRIGATÓRIO

### 1. Verificar Atualizações Disponíveis

```bash
# Comando sugerido (se disponível)
openclaw update --check
# ou
npm outdated -g openclaw
# ou verificar releases no GitHub
```

### 2. Se Houver Atualização:

**⛔ NÃO INSTALAR AUTOMATICAMENTE**

**✅ FAZER:**
- [ ] Registrar versão atual
- [ ] Registrar versão nova disponível
- [ ] Ler changelog/Release Notes
- [ ] Identificar mudanças críticas
- [ ] Preparar mensagem para Acib

### 3. Mensagem para Acib (Modelo)

```
🔔 ATUALIZAÇÃO OPENCLAW DISPONÍVEL

Versão atual: X.X.X
Versão nova: Y.Y.Y

📋 Principais mudanças:
- [Item 1 do changelog]
- [Item 2 do changelog]
- [Item 3 do changelog]

⚠️ Impacto potencial: [Baixo/Médio/Alto]

⏰ Estimativa de instalação: [X minutos]
🔄 Requer restart: [Sim/Não]

❓ Posso instalar? Responda:
✅ Sim - instalar agora
⏳ Depois - me lembre em [tempo]
❌ Não - ignorar esta versão
```

### 4. Aguardar Resposta

- **Se "Sim":**
  - [ ] Criar backup pré-instalação
  - [ ] Executar instalação
  - [ ] Verificar se funcionou
  - [ ] Documentar no histórico

- **Se "Depois":**
  - [ ] Criar lembrete/cron
  - [ ] Registrar para próximo check

- **Se "Não":**
  - [ ] Registrar versão ignorada
  - [ ] Verificar novamente amanhã

---

## 🚫 PROIBIDO (Conforme RC-001)

| Proibição | Razão |
|-----------|-------|
| Instalar sem permissão | Pode quebrar sistema |
| Usar `--yes` ou auto-approve | Perde controle |
| Instalar durante trabalho crítico | Risco de interrupção |
| Ignorar backup pré-update | Sem recovery |

---

## 📊 Log de Atualizações

| Data | Versão Anterior | Nova | Autorizado por | Status |
|------|-----------------|------|----------------|--------|
| [ ] | - | - | - | - |

---

*Criado em: 28/04/2026*  
*Regra base: RC-001*  
*Próximo check: [Definir horário com Acib]*
