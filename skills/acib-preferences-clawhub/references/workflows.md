# 📋 WORKFLOWS - Padrões de Trabalho Acib ABBADE

**Última atualização:** 27/04/2026

---

## 🔄 DEPLOY DE SITE

### **Workflow Padrão (27/04/2026)**

```
1. BACKUP versão atual
   └── Salvar em: /root/backups-projeto/
   └── Copiar para ARCA (DATASVR)

2. PREPARAR nova versão
   └── Revisar código
   └── Testar localmente (se possível)
   └── Verificar dependências

3. TESTAR (quando aplicável)
   └── Validar HTML/CSS/JS
   └── Verificar responsividade
   └── Testar funcionalidades

4. DEPLOY no servidor
   └── Copiar arquivo(s)
   └── Verificar permissões
   └── Confirmar cópia

5. VERIFICAR online
   └── Acessar URL
   └── Verificar visual
   └── Testar interações

6. DOCUMENTAR
   └── Registrar alterações
   └── Atualizar documentação
   └── Backup na ARCA
```

**Regra crítica:** NUNCA deploy sem backup anterior!

---

## 🖥️ CRIAÇÃO DE CONTAINER (CT)

### **Workflow Padrão**

```
1. DEFINIR especificações
   ├── CT ID (próximo disponível)
   ├── Nome descritivo
   ├── Recursos (CPU, RAM, disco)
   ├── IP fixo (192.168.0.x/24)
   └── Sistema operacional

2. CRIAR no Proxmox
   └── pct create ...
   └── Configurar rede
   └── Definir senha root

3. CONFIGURAR acesso
   └── SSH com senha (inicial)
   └── Copiar chave SSH pública
   └── Desabilitar senha (opcional)

4. INSTALAR stack
   └── apt update && upgrade
   └── Instalar dependências
   └── Configurar serviços

5. DOCUMENTAR
   └── Adicionar ao HEARTBEAT.md
   └── Criar arquivo de memória
   └── Registrar credenciais (separado!)
```

---

## 📝 DOCUMENTAÇÃO

### **Workflow Automático (27/04/2026)**

```
1. IDENTIFICAR nova informação
   └── Preferência, decisão, alteração

2. CLASSIFICAR por categoria
   └── Perfil, técnicas, workflows, etc.

3. REGISTRAR imediatamente
   └── Arquivo correto em references/
   └── Formato padronizado

4. FAZER BACKUP na ARCA
   └── Sincronizar com DATASVR
   └── Verificar integridade

5. APLICAR em futuras interações
   └── Usar preferências aprendidas
   └── Confirmar quando necessário
```

**Regra crítica:** SEMPRE documentar alterações significativas!

---

## 🔐 SEGURANÇA

### **Workflow de Credenciais**

```
1. GERAR credencial segura
   └── Senha forte (16+ caracteres)
   └── Ou chave SSH (ed25519)

2. DISTRIBUIR com cuidado
   └── NUNCA em texto claro público
   └── Usar canais seguros

3. ARMAZENAR
   └── Arquivo separado (ACCESSO_*.md)
   └── Permissões restritas (600)
   └── Backup criptografado (ideal)

4. ROTACIONAR periodicamente
   └── A cada 90 dias (recomendado)
   └── Após incidente de segurança
```

---

## 🎓 FACULDADE/TRABALHOS ACADÊMICOS

### **Workflow de Projeto**

```
1. VERIFICAR prazo
   └── Calcular dias até entrega
   └── Definir marcos intermediários

2. ORGANIZAR materiais
   └── Criar pasta específica
   └── Coletar referências
   └── Estabelecer template

3. DESENVOLVER
   └── Seguir requisitos à risca
   └── Documentar processo
   └── Revisar periodicamente

4. ENTREGAR
   └── Verificar formato exigido
   └── Confirmar envio
   └── Guardar comprovante
```

---

## 📦 BACKUP

### **Workflow Padrão (27/04/2026)**

```
1. ANTES de alteração significativa
   └── Identificar arquivos críticos
   └── Criar backup local
   └── Copiar para ARCA

2. PERIODICAMENTE (automático)
   └── A cada 4 horas (memórias)
   └── Diariamente (projetos ativos)
   └── Semanalmente (sistema completo)

3. VERIFICAÇÃO
   └── Confirmar integridade
   └── Testar restauração (mensal)
```

---

## 🚨 RESPOSTA A INCIDENTES

### **Workflow de Recuperação**

```
1. IDENTIFICAR problema
   └── Logs, mensagens de erro
   └── Impacto e urgência

2. ISOLAR
   ├── Crítico: Parar serviço
   ├── Médio: Limitar acesso
   └── Baixo: Monitorar

3. RECUPERAR
   └── Usar backup mais recente
   └── Aplicar correção
   └── Testar funcionamento

4. DOCUMENTAR
   └── Causa raiz
   └── Solução aplicada
   └── Prevenção futura

5. COMUNICAR
   └── Informar Acib
   └── Registrar em memória
```

---

## 📊 MONITORAMENTO

### **Workflow de Heartbeat**

```
1. VERIFICAR containers
   └── Todos online?
   └── Recursos OK?

2. VERIFICAR serviços críticos
   └── Gateway
   └── Banco de dados
   └── Sites principais

3. ATUALIZAR memórias
   └── Sincronizar com ARCA
   └── Verificar integridade

4. NOTIFICAR (se necessário)
   └── Apenas falhas críticas
   └── Silêncio se tudo OK
```

---

## ✅ CHECKLISTS RÁPIDOS

### **Antes de Deploy:**
- [ ] Backup criado
- [ ] Versão testada
- [ ] Documentação atualizada
- [ ] Rollback planejado

### **Após Deploy:**
- [ ] Site funcionando online
- [ ] Testes básicos OK
- [ ] Documentação finalizada
- [ ] Backup na ARCA

### **Novo Projeto:**
- [ ] Estrutura criada
- [ ] CT configurado (se necessário)
- [ ] Documentação inicial
- [ ] Backup configurado

---

## 💡 PADRÕES APRENDIDOS

### **27/04/2026 - Deploy Site 4Pets:**
- Sempre backup antes de alterar
- Verificar cores e design
- Testar online após deploy
- Documentar todas as mudanças

### **27/04/2026 - Segurança Admin:**
- Proteger áreas administrativas
- Usar senhas fortes
- Session management
- Logout automático

---

*Atualizado em: 27/04/2026*
