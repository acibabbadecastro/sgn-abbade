# SISTEMA FINANCEIRO - Especificações Completas

**Data de criação:** 2026-04-02
**Última atualização:** 2026-04-02
**Status:** Em desenvolvimento

---

## Fluxo de Dados

```
📧 Email bancário
    ↓
📧 MailBot (CT 101) - recebe e filtra
    ↓
💰 FinanceiroBot (CT 3) - classifica e registra
    ↓
💾 DataBot (CT 5) - armazena e compartilha
    ↓
📤 Compartilhado com todos os agentes da equipe
```

---

## Estrutura de Pastas (DataBot - CT 5)

```
/mnt/data/
├── financeiros/           # Dados financeiros
│   ├── contas/          # Cadastro de contas bancárias
│   ├── transacoes/     # Registros de transações
│   ├── despesas_fixas/ # Despesas recorrentes
│   ├── cartoes/        # Cartões de crédito
│   └── fornecedores/   # Cadastro de fornecedores
├── documentos/          # Todos os documentos
│   ├── contratos/       # Contratos e acordos
│   ├── faturas/        # Faturas de cartão, concessionárias
│   └── recibos/        # Recibos de pagamento
├── emails/             # Emails classificados
│   ├── bancario/       # Emails do banco
│   ├── indesejados/    # Spam, promocionais
│   └── importantes/    # Emails importantes
├── backups/            # Backups de segurança
└── logs/               # Logs do sistema
```

---

## Classificação de Transações

| Campo | Descrição |
|-------|-----------|
| **Tipo** | PIX, Débito, Crédito, Dinheiro |
| **Conta** | Número da conta bancária |
| **Código** | Código da movimentação |
| **Data/Hora** | Data e hora da transação |
| **Descrição** | Descrição da transação |
| **Valor** | Montante (positivo para entrada, negativo para saída) |
| **Categoria** | Alimentação, Transporte, Saúde, Educação, etc. |

---

## Dados a Cadastrar

### 1. Contas Bancárias
- Banco (nome)
- Agência
- Número da conta
- Tipo (corrente/poupança)
- Email de extrato

### 2. Despesas Fixas
- Nome do serviço
- Empresa fornecedora
- Valor mensal
- Data de vencimento
- Código de barras (se aplicável)

### 3. Cartões de Crédito
- Bandeira (Visa, Mastercard, etc.)
- Últimos 4 dígitos
- Limite de crédito
- Dia de fechamento
- Dia de vencimento

### 4. Fornecedores
- Nome/Razão Social
- CNPJ
- Telefone
- Email
- Endereço
- Serviços/Produtos fornecidos

### 5. Despesas Comuns
- Categoria (alimentação, transporte, saúde, educação, lazer, etc.)
- Descrição
- Valor médio
- Frequência

---

## Integração com Email

O MailBot é responsável por:
1. Receber emails do banco
2. Filtrar por remetente/assunto
3. Extrair dados de transações (se possível)
4. Encaminhar para FinanceiroBot
5. Baixar e classificar anexos para DataBot

---

## Regras de Compartilhamento

- Todos os agentes podem LER dados financeiros
- Apenas FinanceiroBot pode ESCREVER/MODIFICAR
- DataBot gerencia permissões de acesso
- Log de todas as operações mantido

---

## APIs e Integrações Bancárias

### Nubank (Prioridade)
- **Objetivo:** Explorar API do Nubank para integração direta
- **Recursos possíveis:**
  - Extrato em tempo real
  - Categorização automática de gastos
  - Informações de cartão de crédito
  - Pix transfers e recibos
- **Documentação:** https://developers.nubank.com.br
- **Status:** A RESEARCHAR
- **Email associado:** acibabbadecastro@gmail.com

### Outras APIs a Considerar
- Open Banking (Banco Central)
- APIs de outros bancos tradicionais
- Plataformas de agregação (Organizze, Guiabolso)

---

## Emails Cadastrados

| Email | Finalidade | Status |
|-------|------------|--------|
| acibabbadecastro@gmail.com | Principal, financeiro | ✅ Cadastrado |
| infoacib@gmail.com | Secundário, informativo | ✅ Cadastrado |

---

## Status de Implementação

| Componente | Status |
|------------|--------|
| MailBot (CT 101) | ✅ Configurado |
| FinanceiroBot (CT 3) | ⏳ A criar |
| DataBot (CT 5) | ⏳ A criar |
| Estrutura de pastas | ⏳ A criar |
| Integração emails | ⏳ A configurar |
| Cadastro de dados | ⏳ Aguardando informações |

---

## Contato do Dono

- **Nome:** Acib ABBADE
- **Telegram:** @Acib_Abbade (ID: 1866226415)
- **Emails conhecidos:** acibabbadecastro@gmail.com, infoacib@gmail.com

---

*Documento atualizado em: 2026-04-02*
