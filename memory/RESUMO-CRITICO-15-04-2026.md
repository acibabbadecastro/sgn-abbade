# 📋 RESUMO CRÍTICO - 15/04/2026 (10:56)

## 🏢 CLIENTE Nº 1 - SAULO (SERVMIL)

### Serviços Executados (Abril/2026):
| Data | Para | Serviço | Valor | Status |
|------|------|---------|-------|--------|
| 13/04 | Bryan | Notebook Dell | R$ 1.450,00 | ✅ Executado |
| 15/04 | Bryan | Mouse sem fio recarregável | R$ 40,00 | ✅ Entregue |
| 15/04 | Daniela | VPN remota | R$ 80,00 | ✅ Feito |

**Total a receber: R$ 1.570,00**
**Data pagamento: SEXTA-FEIRA 18/04/2026**

---

## 💰 FLUXO DE CAIXA REAL

### Entradas Recebidas (Caixa):
| Data | Descrição | Valor |
|------|-----------|-------|
| 13/04 | Notebook SERVMIL (Bryan) | R$ 1.450,00 |
| 14/04 | Troca bateria iPhone 12 | R$ 320,00 |

**Subtotal Entradas: R$ 1.770,00**

### Saídas:
| Data | Descrição | Valor |
|------|-----------|-------|
| 14/04 | SSDs Kingston (2x) | R$ 400,00 |
| 14/04 | Pagamento Marcos (filho) | R$ 250,00 |
| 14/04 | Boleto Shopee | R$ 97,00 |

**Subtotal Saídas: R$ 747,00**

### Saldo Atual: R$ 1.023,00 ✅

---

## ⏳ CONTAS A RECEBER

| Cliente | Valor | Previsão |
|---------|-------|----------|
| Saulo (SERVMIL) | R$ 1.570,00 | Sexta 18/04 |

**Total Esperado (pós recebimento): R$ 2.593,00**

---

## 🚨 MONITORAMENTO FISCAL

### Regra de Identificação:
- "Saulo" = Dono SERVMIL
- "Saulinho" = Dono SERVMIL
- "Empresa do Saulo" = SERVMIL

### Contas PJ (CNPJ) - LIMITE MEI:
- PJ65 (Nubank) - Conta para MEI
- PJ20 (Nubank) - Conta para MEI
- **Limite Anual: R$ 81.000,00**

### Contas PF (CPF) - LIMITE IRPF:
- Nubank PF - NÃO CONTA MEI
- MercadoPago - NÃO CONTA MEI
- **Limite Isenção: R$ 28.559,70/ano (2026)**

---

## 📅 AGENDA CRÍTICA

### Sexta-feira 18/04:
- ⏰ Receber pagamento Saulo (R$ 1.570,00)
- ⏰ Verificar se entrou no caixa

### Hoje (15/04):
- ✅ VPN Daniela (feito)
- ✅ Mouse Bryan (entregue)
- 🎓 Live Faculdade 19:15 (Red Team)

---

## 🤖 INFRAESTRUTURA - CT 105 (MAILS/OFFICEBOY)

### Correção de Nomenclatura:
- **Container ID:** CT 105
- **Nome correto:** MAILS (antigo OfficeBoy)
- **Função:** Processamento de emails e automação
- **Status:** ✅ RUNNING (confirmado 15/04/2026 14:00)

### Configuração:
| Campo | Valor |
|-------|-------|
| **IP** | 192.168.0.224 (DHCP) |
| **Gateway OpenClaw** | Porta 18789 |
| **Scripts** | /root/mails_processor_arca.py |
| **Email processado** | acibabbadecastro@gmail.com |
| **Senha App** | juqqogjysxvpowtu |

### Scripts Disponíveis:
- `mails_processor_arca.py` - Processamento com ARCA
- `mails_processor.py` - Processamento básico
- `mails_processor_v2.py` - Classificação inteligente

### Acesso Direto (via PVE1):
```bash
# Verificar status
pct exec 105 -- ps aux | grep python

# Executar processamento manual
pct exec 105 -- python3 /root/mails_processor_arca.py

# Verificar arquivos processados
pct exec 105 -- ls -la /root/emails_financeiros/
```

### Último Processamento:
- **Data:** 15/04/2026 14:00
- **Emails encontrados:** 12
- **Não lidos:** 7
- **Extratos identificados:** Email ID 106 (Nubank PJ20)

---

**Registrado em:** 15/04/2026 10:56 / Atualizado 14:00
**Próxima revisão:** Sexta 18/04

---

## 🔔 CONFIGURAÇÃO DE LEMBRETES (CORRIGIDO 15/04 14:31)

### Frequência Correta:
- **Lembretes automáticos:** A cada **3 horas** (não a cada 30 minutos)
- **Ou:** Quando solicitado explicitamente pelo Acib
- **NUNCA:** A cada 30 minutos

### Histórico do Erro:
- ❌ Configuração anterior: Lembretes disparando a cada 30 min (10:30, 11:00, 11:30...)
- ✅ Configuração correta: A cada 3h ou sob demanda
- **Ação:** Corrigir cron/agendamento para refletir a frequência correta

---
