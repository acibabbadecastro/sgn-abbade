# 🔴 RC-003 - REGRA DE AÇÕES DESTRUTIVAS

**Data:** 28/04/2026  
**Criado por:** Acib ABBADE / Stark  
**Prioridade:** 🔴 CRÍTICA  
**Categoria:** Segurança/Proteção de Dados  
**ID:** RC-003  
**Baseado em:** AGENTS.md - Red Lines  

---

## 📋 INSTRUÇÃO:

> **Qualquer ação que DELETE, REMOVA, DESTRUA ou cause PERDA permanente de dados requer AUTORIZAÇÃO EXPLÍCITA do Acib ANTES de executar.**

---

## 🚫 Ações Destrutivas (Exemplos):

| Categoria | Exemplos |
|-----------|----------|
| **Arquivos** | `rm`, `trash`, `del`, `unlink`, `shred` |
| **Bancos de Dados** | `DROP TABLE`, `DELETE FROM`, `TRUNCATE` |
| **Containers/VMs** | `pct destroy`, `docker rm`, `qm destroy` |
| **Discos/Storage** | `mkfs`, `fdisk`, `wipefs`, `dd` |
| **Emails** | Deletar caixas, limpar inbox permanentemente |
| **Usuários** | Remover contas, revogar acessos |
| **Publicações** | Postar tweets, enviar emails em massa |
| **Credenciais** | Alterar senhas sem motivo claro |

---

## ✅ Protocolo Obrigatório:

### 1. DETECTAR
Identificar que a ação é destrutiva antes de executar

### 2. PARAR
Não executar automaticamente

### 3. COMUNICAR
Enviar mensagem para Acib:
```
⚠️ AÇÃO DESTRUTIVA DETECTADA

O que quero fazer: [descrição completa]
Por que: [justificativa]
Impacto: [o que será afetado]

AUTORIZAÇÃO NECESSÁRIA

/Aprovar - para executar
/Negar - para cancelar
```

### 4. AGUARDAR
Esperar resposta explícita (não assumir)

### 5. EXECUTAR (se aprovado)
Apenas após autorização clara

### 6. CONFIRMAR
Informar resultado após execução

---

## 🟢 Exceções (NÃO precisa pedir):

| Situação | Exemplo |
|----------|---------|
| Arquivos temporários criados pelo sistema | `/tmp/cache-*` |
| Cache automático | `apt clean`, `npm cache clean` |
| Logs velhos (> 30 dias) | Depois de verificar |
| Arquivos criados por mim na sessão | Arquivos de trabalho temporários |

---

## 💡 Dica de Ouro:

> **"É mais fácil pedir perdão do que obter permissão" - NÃO se aplica aqui.**  
> Dados destruídos raramente voltam.

---

## 📝 Referência Original:

AGENTS.md - Seção "Red Lines - Destruição de Dados (2026-04-04)"

---

*Criado em: 28/04/2026*  
*Status: ✅ Regra Ativa*  
*Revisão: Semestral*
