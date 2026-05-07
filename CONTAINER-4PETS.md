# 🐾 CONTAINER 4PETS - SERVIDOR DO SITE

**Data:** 30/04/2026  
**Atualizado por:** Stark (CT 100)

---

## 📊 INFORMAÇÕES DO CONTAINER:

| Campo | Valor |
|-------|-------|
| **CT ID** | 107 |
| **Nome** | 4pets |
| **Hostname** | 4pets |
| **IP** | 192.168.0.200/24 |
| **Gateway** | 192.168.0.1 |
| **Status** | ✅ RUNNING |
| **Bridge** | vmbr0 |
| **MAC** | BC:24:11:41:BC:69 |

---

## 🌐 SERVIDOR WEB:

| Info | Valor |
|------|-------|
| **Software** | nginx/1.26.3 (Ubuntu) |
| **Path** | `/var/www/amigos4patas/` |
| **Proprietário** | www-data |
| **Porta** | 80 (HTTP) |

---

## 📁 ESTRUTURA DE ARQUIVOS:

```
/var/www/amigos4patas/
├── index.html                 (Página inicial)
├── sobre.html                 (Página Sobre)
├── perdidos.html              (Animais Perdidos)
├── avistados.html             (Avistamentos)
├── adocao.html                (Adoção)
├── castracao.html             (Castração)
├── utilidade-publica.html     (Utilidade Pública)
├── doacoes.html               (Doações)
├── diy.html                   (Faça Você Mesmo)
├── servicos.html              (Serviços)
├── denunci.html               (Denúncias)
├── quero-ajudar.html          (Quero Ajudar)
├── pontos-alimentacao.html    (Pontos de Alimentação)
├── alimentadores-pvc.html     (Alimentadores PVC)
├── como-construir.html        (Como Construir)
├── faca-parte.html            (Faça Parte)
├── cadastrar.html             (Cadastro)
├── cadastrar-perdido.html     (Cadastrar Perdido)
├── cadastrar-avistamento.html (Cadastrar Avistamento)
├── cadastrar-adocao.html      (Cadastrar Adoção)
├── cadastrar-alimentador.html (Cadastrar Alimentador)
├── cadastro-contribuicao.html (Contribuição)
├── solicitar-ajuda.html       (Solicitar Ajuda)
├── notificacoes.html          (Notificações)
├── apoiadores.html            (Apoiadores)
├── buscar.html                (Busca)
├── exemplo-formulario.html    (Exemplo)
├── admin.php                  (Admin)
├── relatorio-admin.php        (Relatórios)
├── salvar-cadastro.php        (Backend Cadastro)
├── salvar-inscricao.php       (Backend Inscrição)
├── get-notifications.php      (API Notificações)
├── save-notifications.php     (API Save)
├── ongs.json                  (Lista ONGs)
├── DEPLOY-30-04-2026.md       (Log do Deploy)
├── PRD-DOCUMENTACAO-COMPLETA.md
├── backend/                   (Backend)
├── static/                    (CSS, JS, Imagens)
├── templates/                 (Templates vazios)
├── scripts/                   (Scripts)
├── docs/                      (Documentação)
├── data/                      (Dados)
└── uploads/                   (Uploads de usuários)
```

---

## 🔧 ACESSO SSH:

```bash
# Do CT 100 (Stark)
ssh root@192.168.0.200

# Com senha
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.200

# Do Proxmox (PVE1)
pct exec 107 -- /bin/bash
```

---

## 📝 DEPLOY REALIZADO (30/04/2026):

### Arquivos Atualizados:
1. ✅ `index.html` - Slogan + Seção "Nossa Missão"
2. ✅ `sobre.html` - Banner slogan + ODS atualizados
3. ✅ `castracao.html` - Dados mutirão Jacareí
4. ✅ `utilidade-publica.html` - Menu principal
5. ✅ `doacoes.html` - Pontos de coleta
6. ✅ `diy.html` - Tutoriais + Vídeo comedouro
7. ✅ `servicos.html` - Clínicas e emergência

### Slogan Adicionado:
```
🤝 Comunidade Unida, 🏙️ Cidade Sustentável, 🐾 Vida Protegida
```

### ODS Atualizados:
- **ODS 11** - Cidades Sustentáveis (PRINCIPAL)
- **ODS 15** - Vida Terrestre
- **ODS 17** - Parcerias

---

## 🚀 COMANDO DEPLOY RÁPIDO:

```bash
# Do CT 100 (Stark)
cd /root/.openclaw/workspace

# Copiar index
scp amigos4patas-index-novo.html root@192.168.0.200:/var/www/amigos4patas/index.html

# Copiar sobre
scp novo-sobre.html root@192.168.0.200:/var/www/amigos4patas/sobre.html

# Copiar páginas novas
scp castracao.html utilidade-publica.html doacoes.html diy.html servicos.html root@192.168.0.200:/var/www/amigos4patas/

echo "✅ Deploy concluído!"
```

---

## 📊 STATUS DO SITE:

| Métrica | Valor |
|---------|-------|
| **URL** | https://amigos4patas.com.br |
| **IP Local** | 192.168.0.200 |
| **CDN** | Cloudflare |
| **Status** | ✅ ONLINE |
| **Uptime** | 4+ horas (30/04/2026) |

---

## 🎯 PRÓXIMAS ATUALIZAÇÕES:

- [ ] Adicionar novas cores (paleta Natureza)
- [ ] Testar formulário de newsletter
- [ ] Backup automático diário
- [ ] Monitoramento de uptime

---

**Última atualização:** 30/04/2026 13:40  
**Próxima revisão:** 07/05/2026
