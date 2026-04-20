# PREFERÊNCIAS DO ACIB - Regras de Segurança e UI

**Criado:** 2026-04-10 10:00  
**Última atualização:** 2026-04-10 10:00

---

## 🔐 REGRAS DE SEGURANÇA

### Regra #1: DADOS FINANCEIROS NUNCA NA PÁGINA PRINCIPAL

```
❌ PROIBIDO: Expor informações financeiras na primeira página (dashboard/index)
❌ PROIBIDO: Mostrar saldos, faturamento, movimentações no index.php
❌ PROIBIDO: Qualquer dado sensível exposto publicamente

✅ OBRIGATÓRIO: Todos os dados financeiros DEVEM estar na sessão "Financeiro"
✅ OBRIGATÓRIO: Sessão Financeiro deve ter filtros e controles de acesso
✅ PERMITIDO: Apenas métricas operacionais no dashboard (OS pendentes, clientes cadastrados, etc)
```

### Razão:
```
O dashboard/index pode ser acessado por qualquer pessoa.
Dados financeiros são SENSÍVEIS e devem ser protegidos.
Acesso restrito ao módulo específico "Financeiro".
```

---

## 🎨 PREFERÊNCIAS DE UI/UX

### Dashboard (index.php):
```
• Cor de fundo: Verde escuro (#2d4a2d) - já está bom
• Estilo: Gradiente escuro, profissional
• Módulos: Grid responsivo
• Ações rápidas: Botões de destaque
```

### Navegação:
```
• Módulos organizados por função
• Ações rápidas visíveis
• Aviso de segurança visível
```

---

## 📋 FLUXO DE DESENVOLVIMENTO WEB

### Antes de criar qualquer página:
```
1. Verificar se já existe página similar → ATUALIZAR, não criar nova
2. Proteger dados sensíveis → Financeiro só no módulo apropriado
3. Manter sistema enxuto → Máximo 10-12 páginas principais
```

### Regras de segurança para desenvolvimento:
```
✅ Proteger dados financeiros
✅ Proteger dados pessoais de clientes
✅ Proteger senhas e credenciais
✅ Usar HTTPS em produção (quando disponível)
✅ Implementar controle de acesso por sessão
```

---

## 📁 ARQUIVOS RELACIONADOS

| Arquivo | Descrição |
|---------|-----------|
| `00_Regras_Desenvolvimento.md` | Regras gerais de desenvolvimento web |
| `index.php` | Dashboard principal (sem dados financeiros) |
| `financeiro.php` | Módulo de dados financeiros (protegido) |

---

## 📝 HISTÓRICO

| Data | Mudança | Responsável |
|------|---------|-------------|
| 2026-04-10 10:00 | Criação das preferências de segurança | Stark AI |

---

**Documento de preferências e regras de segurança do Acib.**
**Esta regra é CRÍTICA e deve ser seguida em TODO desenvolvimento web.**
