# 📚 SISTEMA DE GESTÃO DE SERVIÇOS - SERVMIL

**Documentação Oficial**  
**Versão:** 1.0  
**Criado em:** 22/04/2026  
**Por:** Stark - Sistema de Gestão

---

## 📋 **SOBRE O SISTEMA**

Este sistema foi desenvolvido para gerenciar todos os serviços de TI prestados para a **SERVMIL**, incluindo:

- ✅ Registro de chamados técnicos
- ✅ Controle de faturamento mensal
- ✅ Histórico por cliente/solicitante
- ✅ Email automático de confirmação
- ✅ Relatórios para faturamento Dynho
- ✅ Pesquisa por solicitante, data, status

---

## 🎯 **OBJETIVO**

**Não perder nenhum serviço executado** e garantir que todos os serviços sejam faturados corretamente no final do mês.

---

## 📂 **ESTRUTURA DE ARQUIVOS**

```
/home/master/LAN/Stark_Output/SERVMIL/
├── AAAA/                      # Ano (ex: 2026)
│   └── MM/                    # Mês (ex: 04)
│       ├── servicos/
│       │   ├── servicos_AAAA_MM.csv    # Planilha principal
│       │   └── servicos_AAAA_MM.md     # Versão legível
│       ├── relatorios/
│       │   └── relatorio_AAAA_MM.md    # Relatório mensal
│       └── emails/
│           └── SERV-AAAA-MM-DD-HHMMSS_email.txt
```

### **Exemplo Real:**

```
/home/master/LAN/Stark_Output/SERVMIL/
├── 2026/
│   └── 04/
│       ├── servicos/
│       │   ├── servicos_2026_04.csv
│       │   └── servicos_2026_04.md
│       ├── relatorios/
│       └── emails/
│           └── SERV-202604-22-103100_email.txt
```

---

## 🚀 **COMO REGISTRAR UM SERVIÇO**

### **Método 1: Via Telegram (Recomendado)**

**Envie uma mensagem para o Stark assim:**

```
Registra serviço SERVMIL:
Solicitante: [Nome]
Serviço: [Tipo de serviço]
Descritivo: [O que foi feito]
Valor: [R$]
Status: [Solucionado / Em análise / Pendente]
Anotações: [Observações]
Data Resolução: [Data ou "Pendente"]
```

### **Exemplo Prático:**

```
Registra serviço SERVMIL:
Solicitante: Juliana
Serviço: Reparo de Boot Windows
Descritivo: Computador travado na tela inicial. Máquina retirada para laboratório
Valor: 80
Status: Em análise
Anotações: Aguardando diagnóstico
Data Resolução: Pendente
```

### **Método 2: Via Script (Terminal)**

```bash
/root/.openclaw/workspace/scripts/registra-servico-servmil.sh \
  "SERVMIL" \
  "Juliana" \
  "Reparo de Boot Windows" \
  "Computador travado na tela inicial" \
  "80" \
  "Em análise" \
  "Aguardando diagnóstico" \
  "Pendente"
```

---

## 📊 **CAMPOS DO SISTEMA**

| Campo | Descrição | Exemplo | Obrigatório |
|-------|-----------|---------|-------------|
| **Chamado** | Número único gerado automaticamente | `SERV-202604-22-103100` | ✅ Auto |
| **Data** | Data do registro | `22/04/2026` | ✅ Auto |
| **Hora** | Hora do registro | `10:31` | ✅ Auto |
| **Cliente** | Empresa | `SERVMIL` | ✅ Sim |
| **Solicitante** | Quem pediu o serviço | `Juliana`, `Bryan` | ✅ Sim |
| **Serviço** | Tipo de serviço | `Reparo Windows`, `Config VPN` | ✅ Sim |
| **Descritivo** | O que foi feito | Descrição detalhada | ✅ Sim |
| **Valor** | Valor do serviço | `80` | ✅ Sim |
| **Status** | Situação atual | `Solucionado`, `Pendente` | ✅ Sim |
| **Anotações** | Observações | `Aguardando peça` | ❌ Não |
| **Data Resolução** | Quando foi concluído | `22/04/2026` | ⏳ Se solucionado |

---

## 🔍 **COMO PESQUISAR SERVIÇOS**

### **Script de Pesquisa:**

```bash
/root/.openclaw/workspace/scripts/pesquisa-servicos-servmil.sh <comando> [parâmetros]
```

### **Comandos Disponíveis:**

#### **1. Pesquisar por Solicitante:**

```bash
# Pesquisar todos os serviços de Juliana
/root/.openclaw/workspace/scripts/pesquisa-servicos-servmil.sh solicitante Juliana
```

#### **2. Pesquisar por Período:**

```bash
# Pesquisar serviços de 01/04/2026 a 30/04/2026
/root/.openclaw/workspace/scripts/pesquisa-servicos-servmil.sh periodo 01/04/2026 30/04/2026
```

#### **3. Pesquisar por Chamado:**

```bash
# Pesquisar chamado específico
/root/.openclaw/workspace/scripts/pesquisa-servicos-servmil.sh chamado SERV-202604-22-103100
```

#### **4. Listar Pendentes:**

```bash
# Listar serviços pendentes de resolução
/root/.openclaw/workspace/scripts/pesquisa-servicos-servmil.sh pendentes
```

#### **5. Listar por Status:**

```bash
# Listar serviços solucionados
/root/.openclaw/workspace/scripts/pesquisa-servicos-servmil.sh status Solucionado

# Listar serviços em análise
/root/.openclaw/workspace/scripts/pesquisa-servicos-servmil.sh status "Em análise"
```

#### **6. Gerar Relatório por Solicitante:**

```bash
# Gerar relatório completo de um solicitante
/root/.openclaw/workspace/scripts/pesquisa-servicos-servmil.sh relatorio Juliana
```

#### **7. Mostrar Ajuda:**

```bash
# Mostrar todos os comandos
/root/.openclaw/workspace/scripts/pesquisa-servicos-servmil.sh help
```

---

## 📧 **EMAIL AUTOMÁTICO DE CONFIRMAÇÃO**

### **Quando um serviço é registrado:**

1. ✅ Sistema gera número do chamado
2. ✅ Salva em CSV e Markdown
3. ✅ Prepara email de confirmação
4. ✅ Salva cópia do email em `/emails/`

### **Modelo de Email Enviado:**

```
=========================================
  CHAMADO DE SERVIÇO - SERVMIL
=========================================

Número do Chamado: SERV-202604-22-103100
Data: 22/04/2026
Hora: 10:31

---

📋 INFORMAÇÕES DO SERVIÇO

| Campo | Informação |
|-------|------------|
| Cliente | SERVMIL |
| Solicitante | Juliana |
| Tipo de Serviço | Reparo de Boot Windows |
| Status | Em análise |
| Valor | R$ 80,00 |

---

📝 OBSERVAÇÕES

Computador travado na tela inicial. Máquina retirada para laboratório.

---

✅ Este chamado foi registrado automaticamente.

Para dúvidas ou atualizações, entre em contato.

=========================================
  Stark - Sistema de Gestão SERVMIL
=========================================
```

---

## 📊 **RELATÓRIO MENSAL PARA FATURAMENTO**

### **Como Gerar:**

No final do mês, execute:

```bash
# Gerar relatório do mês atual
/root/.openclaw/workspace/scripts/pesquisa-servicos-servmil.sh relatorio SERVMIL
```

### **O Que o Relatório Inclui:**

```markdown
# 📊 RELATÓRIO MENSAL - SERVMIL

**Mês:** 04/2026  
**Gerado em:** 22/04/2026 10:31

---

## 📋 RESUMO

| Métrica | Valor |
|---------|-------|
| **Total de Serviços** | 15 |
| **Faturamento Total** | R$ 2.340,00 |
| **Status** | ✅ Registrado |

---

## 📝 DETALHAMENTO

| Data | Solicitante | Serviço | Valor | Status |
|------|-------------|---------|-------|--------|
| 22/04 | Juliana | Reparo Windows | R$ 80 | Em análise |
| 22/04 | Bryan | Config VPN | R$ 60 | Solucionado |
| ... | ... | ... | ... | ... |

---

## 💰 FATURAMENTO

**Total a Faturar:** R$ 2.340,00

**Status dos Serviços:**
- ✅ Faturado: 10
- ⏳ A Faturar: 3
- ✅ Recebido: 2

---
*Gerado automaticamente por Stark*
```

---

## 🗂️ **ORGANIZAÇÃO POR ANO/MÊS**

### **Vantagens:**

| Vantagem | Benefício |
|----------|-----------|
| **Fácil localização** | Sabe exatamente onde está cada mês |
| **Backup simplificado** | Pode copiar apenas meses específicos |
| **Histórico preservado** | Anos anteriores ficam intactos |
| **Performance** | CSVs menores por mês |

### **Exemplo de Estrutura:**

```
SERVMIL/
├── 2026/
│   ├── 01/  # Janeiro
│   ├── 02/  # Fevereiro
│   ├── 03/  # Março
│   ├── 04/  # Abril
│   └── ...
├── 2027/
│   └── ...
```

---

## 🔐 **PERMISSÕES E ACESSO**

### **Arquivos:**

| Arquivo | Permissão | Quem Acessa |
|---------|-----------|-------------|
| **CSV** | 644 | Leitura geral |
| **Markdown** | 644 | Leitura geral |
| **Emails** | 600 | Apenas root |
| **Scripts** | 755 | Execução geral |

### **Localização:**

```
/home/master/LAN/Stark_Output/SERVMIL/
```

**Acesso via rede:** `\\192.168.0.72\LAN\Stark_Output\SERVMIL\`

---

## 📝 **FLUXO DE TRABALHO COMPLETO**

### **1. Execução do Serviço:**

```
Você executa o serviço na SERVMIL
```

### **2. Registro Imediato:**

```
Você envia mensagem para o Stark
Stark registra no sistema
```

### **3. Email de Confirmação:**

```
Sistema prepara email para SERVMIL
Email salvo em /emails/
```

### **4. Acompanhamento:**

```
Status atualizado conforme andamento
```

### **5. Faturamento Mensal:**

```
No final do mês, sistema gera relatório
Você envia fatura Dynho
```

### **6. Histórico:**

```
Serviços ficam salvos permanentemente
Pesquisável a qualquer tempo
```

---

## 🎯 **MELHORES PRÁTICAS**

### **✅ SEMPRE FAÇA:**

1. **Registre imediatamente** após executar o serviço
2. **Seja específico** no descritivo
3. **Atualize o status** quando concluir
4. **Preencha a data de resolução** quando finalizar
5. **Revise o relatório mensal** antes de faturar

### **❌ NUNCA FAÇA:**

1. **Não deixe para registrar depois** (pode esquecer)
2. **Não registre sem valor** (prejudica faturamento)
3. **Não esqueça de atualizar status** (fica pendente eterno)
4. **Não ignore anotações** (importante para acompanhamento)

---

## 🧪 **EXEMPLOS DE USO**

### **Exemplo 1: Serviço Rápido**

**Registro:**
```
Registra serviço SERVMIL:
Solicitante: Bryan
Serviço: Configuração VPN
Descritivo: Instalação e configuração via TeamViewer
Valor: 80
Status: Solucionado
Anotações: Acesso remoto
Data Resolução: 22/04/2026
```

**Pesquisa:**
```bash
# Verificar serviços do Bryan
pesquisa-servicos-servmil.sh solicitante Bryan
```

---

### **Exemplo 2: Serviço em Andamento**

**Registro:**
```
Registra serviço SERVMIL:
Solicitante: Juliana
Serviço: Reparo Windows
Descritivo: Máquina no laboratório para análise
Valor: 80
Status: Em análise
Anotações: Aguardando diagnóstico
Data Resolução: Pendente
```

**Atualização (quando concluir):**
```
Atualiza serviço SERV-202604-22-103100:
Status: Solucionado
Data Resolução: 23/04/2026
Anotações: HD com defeito, trocado
```

---

### **Exemplo 3: Múltiplos Serviços**

**Registro de 3 serviços no mesmo dia:**

```bash
# Serviço 1
registra-servico-servmil.sh "SERVMIL" "Juliana" "Reparo Windows" "..." "80" "Em análise" "..." "Pendente"

# Serviço 2
registra-servico-servmil.sh "SERVMIL" "Gabriele" "Config Permissões RH" "..." "50" "Solucionado" "..." "22/04/2026"

# Serviço 3
registra-servico-servmil.sh "SERVMIL" "Bryan" "Acesso Servidor SIC" "..." "60" "Solucionado" "..." "22/04/2026"
```

---

## 📊 **COMANDOS RÁPIDOS**

### **Registro:**
```bash
registra-servico-servmil.sh <cliente> <solicitante> <servico> <descritivo> <valor> <status> [anotacoes] [data_resolucao]
```

### **Pesquisa:**
```bash
pesquisa-servicos-servmil.sh <comando> [parametros]
```

### **Ajuda:**
```bash
pesquisa-servicos-servmil.sh help
```

---

## 🔧 **MANUTENÇÃO DO SISTEMA**

### **Diária:**

- ✅ Registrar serviços executados
- ✅ Atualizar status dos pendentes

### **Semanal:**

- ✅ Verificar serviços pendentes
- ✅ Atualizar datas de resolução

### **Mensal:**

- ✅ Gerar relatório para faturamento
- ✅ Revisar todos os serviços do mês
- ✅ Enviar fatura Dynho

### **Anual:**

- ✅ Backup de todos os arquivos
- ✅ Arquivar anos anteriores

---

## 📞 **SUPORTE**

**Para dúvidas ou problemas:**

1. **Verifique a documentação** (este arquivo)
2. **Execute o comando help** para ver opções
3. **Consulte os logs** em `/var/log/stark-servmil-*.log`

---

## 📄 **ARQUIVOS DO SISTEMA**

| Arquivo | Função | Local |
|---------|--------|-------|
| **registra-servico-servmil.sh** | Registrar serviços | `/root/.openclaw/workspace/scripts/` |
| **pesquisa-servicos-servmil.sh** | Pesquisar serviços | `/root/.openclaw/workspace/scripts/` |
| **servicos-servmil-AAAA_MM.csv** | Planilha principal | `/home/master/LAN/Stark_Output/SERVMIL/AAAA/MM/servicos/` |
| **servicos-servmil-AAAA_MM.md** | Versão legível | `/home/master/LAN/Stark_Output/SERVMIL/AAAA/MM/servicos/` |
| **relatorio_AAAA_MM.md** | Relatório mensal | `/home/master/LAN/Stark_Output/SERVMIL/AAAA/MM/relatorios/` |

---

## 🎯 **CHECKLIST DE IMPLANTAÇÃO**

### **✅ Configurado:**

- [x] Scripts criados e testados
- [x] Estrutura de pastas criada
- [x] Permissões configuradas
- [x] Logs configurados
- [x] Memória configurada

### **✅ Em Uso:**

- [x] Primeiro serviço registrado (Juliana - 22/04/2026)
- [ ] Serviços pendentes registrados (Gabriele, SIC)
- [ ] Email automático configurado
- [ ] Relatório mensal gerado

---

## 📚 **HISTÓRICO DE VERSÕES**

| Versão | Data | Mudanças |
|--------|------|----------|
| **1.0** | 22/04/2026 | Criação do sistema |

---

*Documentação criada por Stark - Sistema de Gestão SERVMIL*  
*Última atualização: 22/04/2026 10:33*
