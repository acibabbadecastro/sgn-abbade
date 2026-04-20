# Regras de Desenvolvimento Web - SGN

## 🎯 PRINCÍPIO: PÁGINAS VIVAS, NÃO MORTAS

### ✅ SEMPRE:
- **ATUALIZAR** páginas existentes
- **MODIFICAR** funcionalidades nas páginas atuais
- **MANTER** o sistema enxuto
- **CONSOLIDAR** funções relacionadas na mesma página

### ❌ NUNCA:
- **CRIAR** nova página sem necessidade extrema
- **DUPLICAR** funcionalidades em páginas diferentes
- **ABANDONAR** páginas após criar (páginas mortas)
- **FRAGMENTAR** o sistema em muitas páginas

---

## 📋 FLUXO DE DESENVOLVIMENTO

### Antes de Criar Nova Página:

1. **EXISTE página similar?**
   - Se SIM → ATUALIZAR essa página
   - Se NÃO → Prosseguir para passo 2

2. **É possível integrar na página principal?**
   - Se SIM → Adicionar como seção/modal no index.php
   - Se NÃO → Prosseguir para passo 3

3. **É módulo completamente novo?**
   - Se SIM → Criar página única e bem documentada
   - Se NÃO → Reavaliar necessidade

---

## 🏗️ ARQUITETURA PREFERIDA

### Dashboard Único (index.php):
```
• Visão geral do sistema
• Links para todos os módulos
• Stats em tempo real
• Ações rápidas
• NOTIFICAÇÕES de pendências
```

### Páginas de Módulo (uma por função principal):
```
• nova_os.php → Criar OS + cadastro de cliente
• os_lista.php → Listar/gerenciar OS
• clientes.php → Listar/cadastrar clientes
• estoque.php → Gerenciar estoque
• financeiro.php → Lançamentos financeiros
• fornecedores.php → Cadastro de fornecedores
• garantia.php → Controle de garantias
• agenda.php → Compromissos
• relatorios.php → Relatórios gerenciais
• admin_bd.php → Admin banco de dados
```

### Máximo: 10-12 páginas principais
### Mínimo: Cada página com função clara e ativa

---

## 🔄 MANUTENÇÃO

### Mensalmente:
- [ ] Revisar todas as páginas
- [ ] Identificar páginas não utilizadas
- [ ] Consolidar ou remover páginas mortas
- [ ] Atualizar documentação

### A cada nova funcionalidade:
- [ ] Verificar se página similar existe
- [ ] Preferir atualização à criação
- [ ] Documentar mudanças
- [ ] Testar fluxo completo

---

## 📊 MÉTRICAS DE QUALIDADE

| Métrica | Ideal | Alerta | Crítico |
|---------|-------|--------|---------|
| Páginas ativas | 8-12 | 13-20 | >20 |
| Páginas mortas | 0 | 1-2 | >3 |
| Páginas atualizadas (30 dias) | >80% | 50-80% | <50% |
| Funcionalidades por página | 1-3 | 4-5 | >5 |

---

## 💡 EXEMPLOS

### ✅ CORRETO:

**Situação:** Precisa adicionar campo "WhatsApp" no cadastro de cliente

**Ação:** Atualizar `clientes.php`
```php
// Adicionar campo WhatsApp no formulário existente
// Atualizar INSERT/UPDATE para incluir WhatsApp
// Atualizar listagem para mostrar WhatsApp
```

### ❌ ERRADO:

**Situação:** Precisa adicionar campo "WhatsApp" no cadastro de cliente

**Ação:** Criar `clientes_whatsapp.php`
```
❌ Página nova para uma função que deveria existir na original
❌ Duplica funcionalidade
❌ Cria confusão
❌ Vira página morta eventualmente
```

---

## 🎯 CASO ESPECÍFICO: NOVA OS COM CADASTRO DE CLIENTE

### ✅ SOLUÇÃO CORRETA:

**Arquivo:** `nova_os.php` (ÚNICO arquivo)

**Fluxo:**
```
1. Usuário clica "Nova OS"
2. Formulário mostra:
   - Seção DADOS DO CLIENTE (nome, tel, email, CPF/CNPJ)
   - Seção DADOS DO EQUIPAMENTO (marca, modelo, série)
   - Seção DEFEITO RELATADO
   - Seção PEÇAS NECESSÁRIAS
   - Seção MÃO DE OBRA
   - Seção VALOR TOTAL
3. Se cliente já existe → Buscar por telefone/nome
4. Se cliente novo → Cadastrar automaticamente ao salvar OS
5. Salvar TUDO em uma transação única
```

**Vantagens:**
- ✅ Uma página só
- ✅ Fluxo contínuo
- ✅ Não precisa navegar entre páginas
- ✅ Cliente cadastrado automaticamente
- ✅ OS vinculada ao cliente automaticamente

### ❌ SOLUÇÃO ERRADA:

**Arquivos:** `novo_cliente.php` + `nova_os.php` + `vincular_cliente_os.php`

**Fluxo:**
```
1. Usuário clica "Novo Cliente" → novo_cliente.php
2. Preenche dados → Salva
3. Volta pra home
4. Clica "Nova OS" → nova_os.php
5. Precisa buscar cliente criado
6. Vincula cliente à OS
```

**Problemas:**
- ❌ 3 páginas para uma função
- ❌ Fluxo fragmentado
- ❌ Mais cliques
- ❌ Mais chance de erro
- ❌ Páginas tendem a ficar mortas
```

---

## 📝 HISTÓRICO DE MUDANÇAS

| Data | Mudança | Responsável |
|------|---------|-------------|
| 2026-04-10 | Criada regra de "não criar páginas mortas" | Stark AI |

---

**Esta regra tem PRIORIDADE MÁXIMA em todo desenvolvimento web do SGN.**
