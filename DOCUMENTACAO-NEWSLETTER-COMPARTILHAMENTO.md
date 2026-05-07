# 📧 Documentação: Newsletter e Compartilhamento - Amigos de 4 Patas

## Resumo
Sistema de newsletter com formulário em todas as páginas e botões de compartilhamento em redes sociais (Facebook, WhatsApp, Twitter) para o projeto Amigos de 4 Patas.

---

## 📁 Arquivos Criados/Modificados

### 1. Arquivos JavaScript

#### `amigos4patas-newsletter.js`
- **Função:** Gerencia inscrições na newsletter
- **Recursos:**
  - Validação de email e WhatsApp
  - Envio assíncrono para `salvar-inscricao.php`
  - Modo offline (salva no localStorage)
  - Notificações toast
  - Prevenção de duplicados

#### `amigos4patas-compartilhar.js`
- **Função:** Gerencia compartilhamento em redes sociais
- **Redes Suportadas:**
  - Facebook (share dialog)
  - WhatsApp (wa.me)
  - Twitter/X (intent/tweet)
  - Copiar link (clipboard API)

### 2. Arquivos PHP

#### `salvar-inscricao.php`
- **Função:** Recebe e salva inscrições da newsletter
- **Armazenamento:** `data/newsletter.json`
- **Validações:** Email válido, WhatsApp 11 dígitos, sem duplicados
- **Resposta:** JSON com status da operação

### 3. Arquivos HTML Atualizados

| Arquivo | Newsletter | Compartilhamento |
|---------|------------|------------------|
| `amigos4patas-index-novo.html` | ✅ Seção + Footer | ✅ Facebook, WhatsApp, Twitter, Copiar |
| `amigos4patas-perdidos.html` | ✅ Footer | ✅ Cards individuais |
| `amigos4patas-avistados.html` | ✅ Footer | ✅ Cards individuais |
| `amigos4patas-adocao.html` | ✅ Footer | ✅ Cards individuais |
| `amigos4patas-perdidos-template.html` | ✅ Seção + Footer | ✅ Seção completa |

---

## 🔧 Como Usar

### Inserir Formulário Newsletter
```html
<form class="newsletter-form" id="form-newsletter">
    <input type="text" name="nome" placeholder="Seu nome" required>
    <input type="email" name="email" placeholder="Seu e-mail" required>
    <input type="tel" name="whatsapp" placeholder="WhatsApp (opcional)" pattern="[0-9]{11}">
    <button type="submit">Cadastrar</button>
</form>
```

### Inserir Botões de Compartilhamento
```html
<!-- Botões individuais -->
<button class="share-btn share-fb" data-share="facebook"><i class="fab fa-facebook-f"></i></button>
<button class="share-btn share-wa" data-share="whatsapp"><i class="fab fa-whatsapp"></i></button>
<button class="share-btn share-tw" data-share="twitter"><i class="fab fa-twitter"></i></button>
<button class="share-btn share-link" data-share="copy"><i class="fas fa-link"></i></button>
```

### Scripts Necessários
```html
<script src="amigos4patas-newsletter.js"></script>
<script src="amigos4patas-compartilhar.js"></script>
```

---

## 📊 API JavaScript Global

### Newsletter
```javascript
window.Amigos4Patas.Newsletter.subscribe({
    nome: 'João',
    email: 'joao@email.com',
    whatsapp: '12999999999'
});
```

### Compartilhamento
```javascript
// Compartilhar página atual
window.Amigos4Patas.Compartilhar.facebook();
window.Amigos4Patas.Compartilhar.whatsapp();
window.Amigos4Patas.Compartilhar.twitter();
window.Amigos4Patas.Compartilhar.copiar();

// Compartilhar animal específico
window.Amigos4Patas.Compartilhar.animal({
    tipo: 'perdido',
    nome: 'Rex',
    local: 'Parque Meia Lua',
    data: '2024-01-15',
    contato: '12 99999-9999'
}, 'whatsapp');
```

---

## 🗂️ Estrutura de Dados

### Arquivo `data/newsletter.json`
```json
[
    {
        "id": "a4p_abc123",
        "nome": "João Silva",
        "email": "joao@email.com",
        "whatsapp": "12999999999",
        "data": "2024-01-15 14:30:00",
        "ip": "192.168.1.1",
        "origem": "https://amigos4patas.com.br/"
    }
]
```

---

## 🔒 Segurança

- Validação de entrada (email, whatsapp)
- Sanitização de dados
- Prevenção de duplicados
- Headers CORS configurados
- Diretório `data/` protegido (deve ser fora do web root em produção)

---

## 📝 Checklist de Testes

- [ ] Formulário newsletter em todas as páginas
- [ ] Validação de campos obrigatórios
- [ ] Mensagem de sucesso após inscrição
- [ ] Prevenção de duplicados
- [ ] Botões Facebook funcionando
- [ ] Botões WhatsApp funcionando
- [ ] Botões Twitter funcionando
- [ ] Copiar link funcionando
- [ ] Toast notifications aparecendo
- [ ] Modo offline funcionando (localStorage)
- [ ] Responsividade mobile
- [ ] PHP salvando corretamente no JSON

---

## 🚀 Deploy

1. Copiar todos os arquivos para o servidor
2. Verificar permissões do diretório `data/` (755)
3. Criar diretório `data/` se não existir
4. Testar formulário em todas as páginas
5. Verificar console do navegador por erros JS

---

## 📞 Suporte

**Projeto:** Amigos de 4 Patas - Parque Meia Lua  
**Instituição:** UNOPAR - Análise e Desenvolvimento de Sistemas  
**Ano:** 2026  
**Autor:** Acib ABBADE

---

*Última atualização: 2026-04-28 - Integração completa finalizada*
