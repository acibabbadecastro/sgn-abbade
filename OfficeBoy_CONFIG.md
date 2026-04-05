# OFFICEBOY - Processamento de Emails Financeiros

## Função
Receber emails do MailBot e organizar informações financeiras de forma estruturada.

## Estrutura de Pastas

```
LAN/Stark_Output/OfficeBoy/
├── Emails/
│   ├── Nubank/
│   │   ├── Conta1/           # Dados conta principal
│   │   ├── Conta2/           # Segunda conta
│   │   └── ...
│   ├── MercadoPago/
│   │   ├── NF-e/            # Notas fiscais
│   │   ├── Comprovantes/    # Comprovantes de pagamento
│   │   └── Extratos/        # Extratos
│   ├── Fornecedores/
│   │   └── XMLs/            # XMLs de notas fiscais
│   └── Movimentacoes/       # Movimentações gerais
│
├── ContasFixas/              # Contas a pagar fixas
│   ├── Energia/
│   │   └── EDP_Bandeirantes.md
│   ├── Internet/
│   │   ├── Fibra_Vivo.md
│   │   ├── Movel_Vivo.md
│   │   └── Fibra_Netjacarei.md
│   └──Outros/
│
├── FornecedoresCadastrados/  # Base de fornecedores
│   └── lista_fornecedores.json
│
└── DadosEstruturados/        # DB em JSON/Markdown
    ├── nubank_transacoes.json
    ├── mercado_pago.json
    └── fornecedores.json
```

## Categorias de Email

### 1. Nubank
| Tipo | Descrição | Salvar em |
|------|-----------|-----------|
| Fatura | Conta corrente PJ | `Emails/Nubank/Conta1/faturas/` |
| Extrato | Movimentações | `Emails/Nubank/Conta1/extratos/` |
| Comprovante | Pagamentos | `Emails/Nubank/Conta1/comprovantes/` |

### 2. Mercado Pago
| Tipo | Descrição | Salvar em |
|------|-----------|-----------|
| NF-e | Notas fiscais | `Emails/MercadoPago/NF-e/` |
| Comprovante | Pagamentos | `Emails/MercadoPago/Comprovantes/` |
| Extrato | Movimentações | `Emails/MercadoPago/Extratos/` |

### 3. Fornecedores (via XML)
| Tipo | Descrição | Salvar em |
|------|-----------|-----------|
| XML NF-e | Nota fiscal eletrônica | `Emails/Fornecedores/XMLs/` |
| Dados | Extrair: CNPJ, endereço, valores | `FornecedoresCadastrados/` |

## Fluxo de Processamento

```
MailBot recebe email
        ↓
MailBot → OfficeBoy (mensagem com dados)
        ↓
OfficeBoy processa e categoriza
        ↓
Salva em estrutura organizada
        ↓
Se NF-e → Extrai dados → Cadastra fornecedor
        ↓
Se conta fixa → Atualiza controle
        ↓
Confirmação → Stark
```

## Contas Fixas Cadastradas

### Energia
- [ ] EDP Bandeirantes (Conta de luz)

### Internet
- [ ] Fibra VIvo (residência)
- [ ] Internet Móvel Vivo
- [ ] Fibra Netjacarei

### Outros a cadastrar
- [ ] Água (SABESP?)
- [ ] Gás?
- [ ] Condomínio?
- [ ] Outros

## Formato de Dados

### Transação Nubank (JSON)
```json
{
  "data": "2026-04-03",
  "tipo": "debito|credito|transferencia",
  "valor": 150.00,
  "descricao": "Pagamento TED",
  "categoria": "fornecedor|cliente|operacional",
  "origem": "nubank_conta1"
}
```

### Fornecedor Cadastrado (JSON)
```json
{
  "cnpj": "00.000.000/0001-00",
  "nome": "Nome Fantasia",
  "razao_social": "Razão Social LTDA",
  "endereco": {
    "logradouro": "Rua X",
    "numero": "123",
    "bairro": "Centro",
    "cidade": "São Paulo",
    "uf": "SP",
    "cep": "00000-000"
  },
  "email": "contato@fornecedor.com",
  "telefone": "(11) 99999-9999",
  "categoria": "fornecedor|prestador",
  "data_cadastro": "2026-04-03",
  "fonte": "email_nfe"
}
```

## Status
- Estrutura criada: ✅
- OfficeBoy a ser configurado: ⏳
- Integração MailBot→OfficeBoy: ⏳

## Data
2026-04-03 21:34 (Brasília)
