# 🐾 Amigos de 4 Patas - Documentação de Integração

**Data de Atualização:** 2026-05-02  
**Status:** ✅ COMPLETO  
**Projeto:** Extensão II - UNOPAR - Análise e Desenvolvimento de Sistemas

---

## 📋 Visão Geral

Site comunitário para gestão de animais perdidos, avistados e para adoção no Bairro Parque Meia Lua, Jacareí/SP.

### Páginas Implementadas

| Página | Arquivo | Newsletter | Compartilhamento | Status |
|--------|---------|------------|------------------|--------|
| **Início** | `amigos4patas-index-novo.html` | ✅ | ✅ | Completo |
| **Perdidos** | `amigos4patas-perdidos.html` | ✅ | ✅ | Completo |
| **Avistados** | `amigos4patas-avistados.html` | ✅ | ✅ | Completo |
| **Adoção** | `amigos4patas-adocao.html` | ✅ | ✅ | Completo |

---

## 🔧 Módulos JavaScript

### 1. Newsletter Module (`amigos4patas-newsletter.js`)

**Funcionalidades:**
- Captura de inscrições via formulário (nome, email, WhatsApp)
- Validação de dados (email válido, WhatsApp com 11 dígitos)
- Envio assíncrono para `salvar-inscricao.php`
- Modo offline: salva no localStorage se backend indisponível
- Notificações toast com feedback visual

**API Global:**
```javascript
window.Amigos4Patas.Newsletter.subscribe(data)
```

**Configuração:**
```javascript
CONFIG = {
    endpoint: 'salvar-inscricao.php',
    toastDuration: 3000
}
```

### 2. Compartilhamento Module (`amigos4patas-compartilhar.js`)

**Redes Sociais Suportadas:**
- 📘 Facebook (compartilhar com URL e texto)
- 💬 WhatsApp (mensagem formatada com link)
- 🐦 Twitter/X (com hashtags automáticas)
- 🔗 Copiar Link (clipboard API)

**Funcionalidades:**
- Compartilhamento genérico da página
- Compartilhamento de animais específicos (por nome)
- Geração automática de texto formatado para animais
- Rastreamento de compartilhamentos no localStorage
- Eventos personalizados para analytics

**API Global:**
```javascript
window.Amigos4Patas.Compartilhar = {
    facebook(url, texto),
    whatsapp(url, texto),
    twitter(url, texto),
    copiar(url),
    animal(animal, rede),
    registrar(rede)
}
```

**Estatísticas Salvas:**
```javascript
localStorage.a4p_compartilhamentos = {
    "facebook": { total: 15, datas: { "2026-05-02": 3 } },
    "whatsapp": { total: 28, datas: { "2026-05-02": 5 } },
    "twitter": { total: 7, datas: { "2026-05-02": 1 } },
    "copiar": { total: 12, datas: { "2026-05-02": 2 } }
}
```

---

## 🗄️ Backend PHP

### `salvar-inscricao.php`

**Endpoint:** `POST /salvar-inscricao.php`

**Parâmetros:**
| Campo | Tipo | Obrigatório | Validação |
|-------|------|-------------|-----------|
| `nome` | string | ✅ Sim | Não vazio |
| `email` | string | ❌ (um dos dois) | FILTER_VALIDATE_EMAIL |
| `whatsapp` | string | ❌ (um dos dois) | 11 dígitos numéricos |

**Respostas:**
```json
// Sucesso
{ "success": true, "message": "Cadastro realizado com sucesso!" }

// Erro
{ "success": false, "message": "Este email já está cadastrado" }
```

**Armazenamento:**
- Arquivo: `data/newsletter.json`
- Formato: JSON array com objetos de inscrição
- Campos salvos: id, nome, email, whatsapp, data, ip, origem

**Estrutura do JSON:**
```json
[
  {
    "id": "a4p_67890abcdef",
    "nome": "Maria Silva",
    "email": "maria@email.com",
    "whatsapp": "12999998888",
    "data": "2026-05-02 10:30:00",
    "ip": "192.168.0.100",
    "origem": "https://amigos4patas.com.br/index.html"
  }
]
```

**Segurança:**
- Validação de email com `filter_var()`
- Sanitização de WhatsApp (remove não-dígitos)
- Verificação de duplicados (email e WhatsApp)
- CORS habilitado para requisições cross-origin

---

## 📁 Estrutura de Arquivos

```
/root/.openclaw/workspace/
├── amigos4patas-index-novo.html      # Página principal
├── amigos4patas-perdidos.html        # Animais perdidos
├── amigos4patas-avistados.html       # Animais avistados
├── amigos4patas-adocao.html          # Adoção
├── amigos4patas-newsletter.js        # Módulo newsletter
├── amigos4patas-compartilhar.js      # Módulo compartilhamento
├── salvar-inscricao.php              # Backend de inscrições
├── data/
│   └── newsletter.json               # Inscrições salvas (auto-criado)
└── AMIGOS4PATAS-INTEGRACAO.md        # Esta documentação
```

---

## 🧪 Testes Realizados

### ✅ Checklist de Validação

- [x] Formulários de newsletter presentes em todas as páginas
- [x] Scripts JS carregados corretamente
- [x] Botões de compartilhamento em cards de animais
- [x] Botões de compartilhamento no footer (avistados, adoção)
- [x] Botão copiar link adicionado a todos os cards
- [x] Diretório `data/` criado para armazenamento
- [x] PHP valida email e WhatsApp corretamente
- [x] PHP previne duplicatas
- [x] Modo offline funcional (localStorage)
- [x] Toast notifications com cores corretas
- [x] Animações CSS (slideIn/slideOut) implementadas

### 📊 Testes de Integração

**Newsletter:**
```bash
# Teste de inscrição válida
curl -X POST http://localhost/salvar-inscricao.php \
  -d "nome=Teste&email=teste@email.com&whatsapp=12999998888"

# Esperado: {"success":true,"message":"Cadastro realizado com sucesso!"}
```

**Compartilhamento:**
- Facebook: Abre popup 600x400 com URL codificada
- WhatsApp: Abre wa.me com texto pré-preenchido
- Twitter: Abre intent/tweet com hashtags
- Copiar: Usa Clipboard API com fallback document.execCommand

---

## 🎨 Elementos de UI

### Classes CSS de Compartilhamento

```css
/* Botões nos cards */
.share-buttons { display: flex; gap: 0.5rem; }
.share-btn { width: 40px; height: 40px; border-radius: 50%; }
.share-fb { background: #1877f2; }
.share-wa { background: #25d366; }
.share-tw { background: #1da1f2; }
.share-link { background: #2d3436; }

/* Botões no footer */
.share-buttons-mini { display: flex; gap: 10px; }
.share-btn-mini { width: 40px; height: 40px; border-radius: 50%; }

/* Toast notifications */
.toast-notification, .toast-share {
    position: fixed;
    bottom: 30px;
    right: 30px;
    padding: 15px 30px;
    border-radius: 10px;
    z-index: 10000;
}
```

### Data Attributes para Animais Específicos

```html
<button class="share-btn share-fb" 
        data-share="facebook" 
        data-animal="Thor">
    <i class="fab fa-facebook-f"></i>
</button>
```

---

## 🚀 Próximos Passos (Sugestões)

1. **Analytics Dashboard** - Criar página para visualizar estatísticas de compartilhamentos
2. **Exportação de Inscrições** - Gerar CSV/Excel para download
3. **Envio de Emails** - Integrar com SMTP para newsletter real
4. **Moderação de Cadastros** - Painel admin para aprovar animais
5. **Upload de Fotos** - Implementar envio de imagens nos formulários
6. **PWA** - Adicionar manifest.json e service worker

---

## 📞 Contato do Projeto

**Desenvolvedor:** Acib ABBADE  
**Instituição:** UNOPAR - Análise e Desenvolvimento de Sistemas  
**Comunidade:** Bairro Parque Meia Lua, Jacareí/SP

---

*Documentação gerada automaticamente em 2026-05-02 às 05:00 BRT*
