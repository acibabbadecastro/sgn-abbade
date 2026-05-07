# 📋 DOCUMENTAÇÃO DE HANDOVER - SITE AMIGOS DE 4 PATAS
## Guia Completo para Novo Desenvolvedor/Designer

**Data:** 29/04/2026  
**Responsável saindo:** Stark (AI Assistant)  
**Responsável entrando:** [A definir]  
**Projeto:** Amigos de 4 Patas - Extensão II UNOPAR

---

## 🎯 OBJETIVO DESTA DOCUMENTAÇÃO

Este documento contém TUDO que um novo desenvolvedor, designer ou IA precisa saber para assumir, manter e evoluir o site Amigos de 4 Patas.

**Premissa:** Se você está lendo isso, é porque assumiu o projeto. Boa sorte! 🤞

---

## 🌐 VISÃO GERAL DO PROJETO

| Campo | Informação |
|-------|------------|
| **Nome** | Amigos de 4 Patas - Parque Meia Lua |
| **URL Produção** | https://amigos4patas.com.br |
| **Contexto** | Projeto de Extensão II - UNOPAR |
| **Objetivo** | Centralizar informações sobre bem-estar animal no bairro |
| **ODS** | 11 (Cidades), 3 (Saúde), 15 (Vida Terrestre) |
| **Público** | Moradores de Parque Meia Lua, protetores, adotantes |
| **Status** | ✅ Em produção, mas precisa de atualizações |

---

## 🖥️ INFRAESTRUTURA TÉCNICA

### Servidor/Container
```yaml
Container Proxmox:
  CT_ID: 107
  Nome: 4pets
  IP: 192.168.0.200
  OS: Ubuntu 25.04 LTS
  Usuário: root
  Senha: Rcmp814k@#$
  
Acesso SSH:
  Comando: ssh root@192.168.0.200
  Senha: Rcmp814k@#$
  
Acesso Proxmox (console web):
  URL: https://192.168.0.192:8006
  Navegar até: CT 107 → Console
```

### Stack Tecnológico
| Componente | Versão | Função | Como reiniciar |
|------------|--------|--------|----------------|
| **Nginx** | 1.26.3 | Servidor web | `systemctl restart nginx` |
| **PostgreSQL** | 17.7 | Banco de dados | `systemctl restart postgresql` |
| **PHP** | 8.x | Backend/API | Reinicia com Nginx |
| **Certbot** | 2.11.0 | SSL/HTTPS | `certbot renew` |
| **Cloudflared** | Latest | Tunnel seguro | `systemctl restart cloudflared` |

### Estrutura de Arquivos no Servidor
```
/var/www/amigos4patas/
├── 📄 index.html              # Página inicial (HERO + contadores + features)
├── 📄 perdidos.html           # Lista de animais perdidos
├── 📄 avistados.html          # Avistamentos de animais
├── 📄 adocao.html             # Animais para adoção
├── 📄 sobre.html              # Página "Quem Somos" (PRECISA ATUALIZAR!)
├── 📄 apoiadores.html         # Parceiros do projeto
├── 📄 admin.php               # Painel administrativo (login)
├── 📄 notificacoes.html       # Sistema de alertas
├── 📄 relatorio-admin.php     # Dashboard (❌ QUEBRADO - 404)
├── 📁 backend/                # APIs PHP
│   ├── salvar-cadastro.php     # POST: cadastra animal
│   ├── salvar-inscricao.php    # POST: newsletter
│   └── get-notifications.php   # GET: notificações
├── 📁 assets/                 # CSS, JS, imagens
│   ├── css/
│   ├── js/
│   │   ├── analytics.js         # Estatísticas de acesso
│   │   ├── estatisticas.js     # Contadores visuais
│   │   ├── newsletter.js        # Formulário newsletter
│   │   ├── compartilhar.js      # Botões social
│   │   └── patinhas.js          # Decoração/efeitos
│   └── images/
└── 📁 admin/                  # Área administrativa
    └── index.html             # Dashboard admin
```

---

## 📝 PÁGINAS EXISTENTES E STATUS

| Página | Arquivo | Status | Observações |
|--------|---------|--------|-------------|
| Home | index.html | ✅ Funcionando | QR Code, contadores, newsletter |
| Perdidos | perdidos.html | ✅ Funcionando | Lista de animais perdidos |
| Avistados | avistados.html | ✅ Funcionando | Registro de avistamentos |
| Adoção | adocao.html | ✅ Funcionando | Pets disponíveis |
| Sobre | sobre.html | ⚠️ PRECISA ATUALIZAR | Texto genérico, precisa de sensibilização |
| Apoiadores | apoiadores.html | ✅ Funcionando | Lista de parceiros |
| Admin | admin.php | ✅ Funcionando | Login administrativo |
| Dashboard | relatorio-admin.php | ❌ QUEBRADO | Dá erro 404 - precisa verificar |

---

## 🔧 COMO FAZER ALTERAÇÕES (PASSO A PASSO)

### Opção 1: Acesso Direto ao Container (Recomendado)

```bash
# 1. Acessar o container via SSH
ssh root@192.168.0.200
# Senha: Rcmp814k@#$

# 2. Ir para pasta do site
cd /var/www/amigos4patas

# 3. Fazer BACKUP antes de editar (SEMPRE!)
cp sobre.html sobre.html.backup-2026-04-29

# 4. Editar arquivo (usar nano ou vim)
nano sobre.html

# 5. Salvar (Ctrl+O, Enter, Ctrl+X no nano)

# 6. Verificar se Nginx está OK
nginx -t

# 7. Reiniciar Nginx se necessário
systemctl restart nginx

# 8. Testar no navegador
# Abrir: https://amigos4patas.com.br/sobre.html
```

### Opção 2: Copiar Arquivos Locais para o Servidor

```bash
# No seu computador local, usar SCP ou rsync
# Exemplo:
scp sobre.html root@192.168.0.200:/var/www/amigos4patas/

# Ou via Proxmox GUI:
# - Acessar CT 107
# - Usar file manager ou console
```

---

## 🎨 GUIA DE ESTILO E DESIGN

### Cores Utilizadas
```css
/* Paleta Principal (do index.html) */
--primary-gradient: linear-gradient(135deg, #FF6B9D, #C44569, #F8B500);
--hero-bg: gradiente rosa/laranja/amarelo
--stats-bg: gradiente rosa/roxo/azul
--newsletter-bg: #fff9f9 (rosa claro)
--footer-bg: gradiente azul
--text-primary: #2c3e50
--text-secondary: #5a6c7d
--white: #ffffff
```

### Tipografia
```css
Fonte: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
H1 Hero: 3.2rem + letter-spacing
H2: 2.0rem
H3 Cards: 1.6rem / 800 weight
Body: 1rem
```

### Componentes Visuais
- **Cards:** border-radius: 25px, padding: 40px, sombra suave
- **Botões:** gradiente, border-radius: 50px, hover com elevação
- **QR Code:** Centralizado na hero section
- **Contadores:** Números grandes (3.5rem), cores vibrantes

---

## 🚨 ALTERAÇÕES PENDENTES (PRIORIDADE MÁXIMA)

### 1. ATUALIZAR PÁGINA "SOBRE" (sobre.html)
**Motivo:** Texto atual é genérico. Precisa sensibilizar avaliadores da faculdade.

**O que inserir:**
- História do problema de abandono no bairro
- Mapeamento de protetores independentes
- Ações de campo realizadas
- Conexão com Projeto de Extensão UNOPAR
- Menção às ODS (11, 3, 15)

**Texto pronto em:**
`/root/.openclaw/workspace/TEXTO-SITE-SOBRE-PROJETO.md`

**Como fazer:**
1. Ler o arquivo acima
2. Copiar conteúdo
3. Substituir conteúdo de sobre.html
4. Manter estrutura HTML/CSS
5. Salvar e testar

### 2. CORRIGIR PÁGINA QUEBRADA (relatorio-admin.php)
**Problema:** Erro 404

**Possíveis causas:**
- Arquivo não existe
- Permissão incorreta
- Erro de sintaxe PHP

**Como diagnosticar:**
```bash
cd /var/www/amigos4patas
ls -la relatorio-admin.php

# Se não existir, verificar se tem em outro lugar:
find /var/www -name "*relatorio*" -type f

# Verificar logs de erro do Nginx:
tail -f /var/log/nginx/error.log
```

### 3. ATUALIZAR CONTADORES (index.html)
**Problema:** Mostram "0" em tudo

**Solução:**
- Opção A: Conectar a API real que retorna dados do banco
- Opção B: Alterar texto para convite à participação

**Arquivo:** `assets/js/estatisticas.js`

---

## 🗄️ BANCO DE DADOS

### Conexão PostgreSQL
```bash
# Acessar banco
sudo -u postgres psql

# Ou
psql -U postgres -d amigos4patas

# Listar tabelas
\dt

# Estrutura esperada:
- animais_perdidos
- animais_avistados
- animais_adocao
- newsletter_inscricoes
- denuncias
```

### Backup do Banco
```bash
# Criar backup
pg_dump -U postgres amigos4patas > backup-banco-2026-04-29.sql

# Restaurar
psql -U postgres amigos4patas < backup-banco-2026-04-29.sql
```

---

## 🔄 FLUXO DE TRABALHO RECOMENDADO

### Para cada alteração:
1. ✅ **FAZER BACKUP** do arquivo original
2. ✅ **EDITAR** em ambiente de teste (se possível)
3. ✅ **VALIDAR** HTML/CSS (usar validator.w3.org)
4. ✅ **TESTAR** localmente
5. ✅ **DEPLOY** para produção
6. ✅ **VERIFICAR** se está online
7. ✅ **DOCUMENTAR** o que foi alterado

### Template de registro de alteração:
```
Data: 29/04/2026
Alteração: Atualizado sobre.html
Motivo: Inserir texto de sensibilização para faculdade
Autor: [Seu nome]
Testado: ✅ Sim / ❌ Não
```

---

## 📂 ONDE ESTÃO OS ARQUIVOS DE REFERÊNCIA

### Na ARCA (DATASVR)
```
\\192.168.0.72\LAN\Acib\projetos\4pets\
├── 📁 argumentacao/           # Argumentos para faculdade
├── 📁 comunicacao/            # Emails, mensagens
├── 📁 documentacao/           # Relatórios, textos
│   ├── RELATORIO-EXTENSAO-II-v2026-04-29.md
│   └── TEXTO-SITE-SOBRE-PROJETO.md  ← TEXTO NOVO PARA PÁGINA SOBRE
├── 📁 backup/                 # Cópia de segurança
└── 📄 README.md               # Índice do projeto
```

### No Workspace Local
```
/root/.openclaw/workspace/
├── TEXTO-SITE-SOBRE-PROJETO.md
├── ARGUMENTOS-ACEITACAO-PROJETO-4PATAS.md
└── [outros arquivos...]
```

---

## 🔐 SEGURANÇA E BOAS PRÁTICAS

### NUNCA faça:
- ❌ Editar diretamente em produção sem backup
- ❌ Compartilhar senhas em texto plano
- ❌ Deixar arquivos de backup (.bak, .old) no servidor
- ❌ Alterar permissões de arquivos sem motivo

### SEMPRE faça:
- ✅ Backup antes de alterar
- ✅ Testar em navegador diferente
- ✅ Verificar versão mobile (responsivo)
- ✅ Documentar alterações

---

## 📞 CONTATO E SUPORTE

| Recurso | Informação |
|---------|------------|
| **Responsável projeto** | Acib Abbade |
| **Email Acib** | abbade@outlook.com |
| **Telegram** | @Acib_Abbade |
| **Container** | CT 107 (192.168.0.200) |
| **Proxmox** | https://192.168.0.192:8006 |

---

## ✅ CHECKLIST DE HANDOVER

- [x] Documentação técnica completa
- [x] Acesso ao servidor configurado
- [x] Backup realizado
- [x] Alterações pendentes mapeadas
- [ ] Novo responsável treinado
- [ ] Teste de acesso realizado
- [ ] Senhas entregues (se aplicável)

---

## 🎯 PRÓXIMAS AÇÕES SUGERIDAS

1. **IMEDIATA:** Atualizar sobre.html com texto de sensibilização
2. **URGENTE:** Corrigir relatorio-admin.php (404)
3. **IMPORTANTE:** Atualizar contadores (tirar os "0")
4. **DESEJÁVEL:** Revisar responsividade mobile
5. **FUTURO:** Adicionar funcionalidades novas

---

*Documentação criada em: 29/04/2026*  
*Por: Stark*  
*Para: Próximo desenvolvedor/designer/IA*

**LEMBRETE:** Se você está assumindo este projeto, leia TODO este documento antes de fazer qualquer alteração. O sucesso do projeto depende da continuidade correta.
