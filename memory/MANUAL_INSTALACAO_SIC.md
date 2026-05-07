# 📋 MANUAL DE INSTALAÇÃO - SIC / SICNET
## Passo a Passo Completo para Instalação/Reinstalação do Sistema ERP

**Documento criado:** 24/04/2026  
**Sistema:** SICNET (também conhecido como SIC) - ERP SERVMIL  
**Local:** SERVMIL (Serve 1000)  
**Responsável técnico:** Acib ABBADE  
**Documentação:** Stark (CT 100)

---

## 📌 PRÉ-REQUISITOS

- Acesso à internet
- Usuário cadastrado no sistema
- Permissões de administrador no computador

---

## 🔐 CREDENCIAL PARA INSTALAÇÃO

| Usuário | Senha | Função |
|---------|-------|--------|
| **saulo** | **234234** | Usuário para abrir/iniciar instalação |

---

## 📋 PASSO A PASSO DA INSTALAÇÃO

### **PASSO 1: Abrir com Usuário Cadastrado**

**Ação:** Iniciar sessão com usuário previamente cadastrado no sistema

**Credenciais:**
- Usuário: `saulo`
- Senha: `234234`

**Observação:** Este usuário deve ter permissões adequadas para instalação de software

---

### **PASSO 2: Abrir Configurações - Rede**

**Ação:** Acessar as configurações de rede do sistema

**Caminho:** Configurações → Rede

**Observação:** Etapa necessária para configuração de conectividade com o servidor

---

### **PASSO 3: Criar Usuário e Senha para o Banco de Dados**

**Ação:** Criar credenciais de acesso ao banco de dados do sistema

**Instruções:**
1. Acessar configurações do banco de dados
2. Criar novo usuário
3. Definir senha segura (mínimo 8 caracteres, maiúscula, minúscula, número)
4. Anotar credenciais para uso futuro

**Dados já configurados na SERVMIL:**
- Usuário BD: `servmil`
- Senha BD: `Rcmp814k`

**Observação:** Manter estas credenciais em local seguro

---

### **PASSO 4: Reiniciar o Servidor**

**Ação:** Reiniciar o computador/servidor para aplicar as configurações

**Instruções:**
1. Salvar todos os trabalhos abertos
2. Fechar todos os programas
3. Executar reinicialização:
   ```cmd
   shutdown /r /t 0
   ```
   Ou via menu Iniciar → Reiniciar

4. Aguardar o sistema reiniciar completamente (2-3 minutos)

**Observação:** A reinicialização é necessária para que as configurações de rede e banco de dados sejam aplicadas corretamente

---

### **PASSO 5: Configurar Terminais/Clientes**

**Ação:** Nos computadores terminais, tentar abrir o sistema SIC

**Procedimento:**
1. Abrir o software SIC no terminal/cliente
2. O sistema apresentará erro por não encontrar o servidor antigo
3. Aparecerá mensagem perguntando se deseja conectar novamente
4. **Responder: NÃO**

**Motivo:** O sistema precisa ser reconfigurado para apontar para o novo servidor (SIC recém-instalado)

**Próximo passo:** Será necessário configurar o endereço/IP do novo servidor

**Observação:** Este passo deve ser realizado em todos os terminais que acessam o sistema

---

### **PASSO 6: Informar Dados de Acesso do Novo Servidor**

**Ação:** Após responder "NÃO" na etapa anterior, informar os dados do novo servidor

**Procedimento:**
1. O sistema perguntará se deseja informar os dados de acesso do novo servidor
2. Responder: **SIM**
3. Informar os dados de conexão do novo servidor SIC:
   - IP/Hostname do servidor
   - Porta de conexão (se aplicável)
   - Credenciais de acesso ao banco de dados

**Dados do novo servidor SERVMIL:**
- **IP Servidor:** `192.168.1.101` (local) ou `172.28.87.134` (ZeroTier)
- **Usuário BD:** `servmil`
- **Senha BD:** `Rcmp814k`

**Observação:** Certificar-se de que o servidor está online e acessível na rede antes de configurar os terminais

---

### **PASSO 7: Configurar Endereço do Servidor, Porta e Banco de Dados**

**Ação:** Na tela de configuração, informar os dados de conexão do novo servidor

**Tela que será aberta:**
- Endereço do servidor
- Porta gerada
- Banco de dados (não alterar)
- Usuário e senha

**Dados a informar:**
| Campo | Valor | Observação |
|-------|-------|------------|
| **Endereço do servidor** | `192.168.1.101` ou `172.28.87.134` | IP do servidor SIC |
| **Porta** | *(gerada automaticamente)* | Verificar arquivo gerado na área de trabalho |
| **Banco de dados** | *(não alterar)* | Manter como está |
| **Usuário BD** | `servmil` | Usuário criado no Passo 3 |
| **Senha BD** | `Rcmp814k` | Senha definida no Passo 3 |

**Fonte das informações:**
- Verificar arquivo "Configurações do Servidor" gerado na área de trabalho do servidor
- Credenciais: Passo 3 deste manual

**Após preencher:** Confirmar e testar conexão

---

## 🌐 INFORMAÇÕES DE INFRAESTRUTURA

### Conexão de Rede
| Dispositivo | Porta Switch | Observação |
|-------------|--------------|------------|
| **Servidor SIC** | **Porta 43** | Conexão física ao switch da rede SERVMIL |

---

## ✅ MANUAL COMPLETO

*Aguardando próximos passos...*

---

**Versão:** 1.0 (Em desenvolvimento)  
**Responsável:** Acib ABBADE  
**Documentação:** Stark (CT 100)
