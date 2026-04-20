# PROTOCOLO DE PERSISTÊNCIA DE MEMÓRIA - STARK

## Objetivo
Garantir que NENHUMA informação crítica seja perdida entre sessões.

## Regra de Ouro
**Toda conversa que envolva:**
- Decisões de projeto
- Dados de clientes/fornecedores
- Configurações técnicas
- Requisitos de sistema
- Valores/financeiro

**DEVE ser:**
1. ✅ Resumida no final da sessão
2. ✅ Salva em arquivo DATASVR imediatamente
3. ✅ Gerado PRD se for projeto
4. ✅ Atualizado MEMORY.md

## Checklist de Persistência (OBRIGATÓRIO)

### A cada 30 minutos de conversa:
- [ ] Resumo salvo em `memory/YYYY-MM-DD.md`
- [ ] Dados críticos em `MEMORY.md`
- [ ] Backup no DATASVR: `/home/master/LAN/MEMORIES/`

### Ao final de cada sessão:
- [ ] Gerar resumo executivo
- [ ] Salvar no DATASVR
- [ ] Se projeto: criar/atualizar PRD
- [ ] Registrar decisões tomadas

### Antes de qualior restart/recovery:
- [ ] Flush de todas as memórias
- [ ] Commit de alterações
- [ ] Verificar integridade dos arquivos

## Estrutura de Arquivos

```
DATASVR (192.168.0.72)
├── LAN/
│   ├── MEMORIES/
│   │   ├── STATUS_STARK.md (a cada 60 min)
│   │   ├── PROJETOS/ (PRDs ativos)
│   │   ├── DECISOES/ (registro de decisões)
│   │   └── BACKUP_SESSOES/ (logs completos)
│   ├── Documentos/Contratos/
│   └── Acib/ (pasta pessoal)
```

## PRD - Product Requirements Document

### Quando criar:
- Novo projeto iniciado
- Mudança de escopo
- Nova funcionalidade major

### Template PRD:
1. Objetivo
2. Escopo
3. Requisitos funcionais
4. Requisitos técnicos
5. Decisões tomadas
6. Próximos passos
7. Data da última atualização

## Alerta de Risco

⚠️ **SE não houver atualização de memória em +60 min:**
- Gerar alerta automático
- Forçar checkpoint
- Notificar supervisor

## Responsabilidade
Stark DEVE garantir persistência. Falha = prejuízo ao Acib.

---
Criado: 2026-04-06
Versão: 1.0
