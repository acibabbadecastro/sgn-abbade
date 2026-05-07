# 📋 REGRAS SOBRE SITES - DOCUMENTO OFICIAL

**Criado em:** 30/04/2026  
**Por:** Acib ABBADE  
**Registrado por:** Stark

---

## 🎯 REGRAS CRÍTICAS (NUNCA VIOLAR)

### 1. NUNCA SOBREPOR SITES EXISTENTES
- **O que fazer:** Verificar se já existe site/projeto com mesmo nome
- **Se existir:** Perguntar a Acib antes de qualquer modificação
- **NUNCA:** Sobrescrever, deletar ou alterar sem autorização explícita

---

### 2. BACKUP SEMPRE NA ARCA
- **Local:** DATASVR (192.168.0.72)
- **Caminho:** `\\192.168.0.72\LAN\` (via rede/Samba)
- **Quando fazer:** Antes de qualquer alteração significativa
- **Estrutura:** `ARCA\nome-do-projeto\`

---

### 3. HOSPEDAGEM EM DOIS ESTÁGIOS
1. **Container Piloto** (inicial)
2. **Servidor Definitivo** (após aprovação)
- **NUNCA:** Publicar direto em produção sem teste no piloto

---

### 4. NUNCA SEM CONSENTIMENTO
- **OBRIGATÓRIO:** Perguntar antes de:
  - Criar novo site/projeto
  - Modificar arquivo existente
  - Subir servidor/ferramenta
  - Fazer deploy
- **EXCEÇÃO:** Arquivos de documentação/texto puro (relatórios, .md)

---

### 5. ONDE SALVAR (FLUXO COMPLETO)

#### Fase 1: Desenvolvimento
```
~/workspace/PROJETOS/nome-do-site/
```

#### Fase 2: Backup ARCA (DATASVR)
```
\\192.168.0.72\LAN\ARCA\nome-do-site\
```

#### Fase 3: Container Piloto
```
[Definir qual CT usar - perguntar a Acib]
```

#### Fase 4: Servidor Definitivo
```
[Definir quando aprovado no piloto]
```

---

## ⚠️ CHECKLIST ANTES DE CRIAR SITE

- [ ] Confirmar nome único (não existe igual)
- [ ] Perguntar a Acib: "Posso criar o site X?"
- [ ] Criar em `~/workspace/PROJETOS/`
- [ ] Fazer backup em DATASVR (192.168.0.72)
- [ ] Definir container piloto
- [ ] Após aprovação, migrar para servidor definitivo

---

## 🔴 VIOLAÇÕES GRAVES

NUNCA fazer sem autorização:
- ❌ Sobrescrever site existente
- ❌ Deletar arquivos de projeto
- ❌ Publicar direto na internet
- ❌ Alterar configuração de servidor
- ❌ Mover arquivos da ARCA

---

## ✅ PERMITIDO SEM AUTORIZAÇÃO

Pode fazer direto:
- ✅ Criar/editar arquivos .md (documentação)
- ✅ Verificar status/status de serviços
- ✅ Consultar informações (read-only)
- ✅ Preparar código mas NÃO executar/deployar

---

*Documento criado em conformidade com as regras de Acib ABBADE*
*Última atualização: 30/04/2026*
