# MINI-CURSO DE DESENVOLVIMENTO WEB
## Introdução ao HTML e CSS para Iniciantes

**Oferecido por:** Acib Abbade - Estudante de Análise e Desenvolvimento de Sistemas  
**Comunidade:** Bairro Parque Meia Lua, Taubaté/SP  
**Projeto de Extensão II - UNOPAR**

---

## 🎯 BOAS-VINDAS!

Olá! Meu nome é Acib e sou estudante de tecnologia. Criei este mini-curso para ajudar você a dar os primeiros passos no mundo da programação web.

**O que você vai aprender:**
- Criar páginas web do zero
- Deixar sites bonitos com cores e estilos
- Publicar seu trabalho na internet

**Duração:** 3 dias (30 minutos por dia)

---

## 📚 DIA 1: HTML - A ESTRUTURA DO SITE

### O que é HTML?

HTML (HyperText Markup Language) é a linguagem que usamos para criar páginas web. É como o esqueleto de um site.

### Estrutura Básica

Toda página HTML começa assim:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Meu Primeiro Site</title>
</head>
<body>
    <!-- Aqui vai o conteúdo -->
</body>
</html>
```

### Tags Essenciais

**Títulos:**
```html
<h1>Título Principal</h1>
<h2>Subtítulo</h2>
```

**Parágrafo:**
```html
<p>Este é um texto qualquer.</p>
```

**Imagem:**
```html
<img src="foto.jpg" alt="Minha foto">
```

**Link:**
```html
<a href="https://google.com">Clique aqui</a>
```

### ✍️ EXERCÍCIO DO DIA 1

Crie um arquivo chamado "index.html" e escreva:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Meu Perfil</title>
</head>
<body>
    <h1>Olá, eu sou [SEU NOME]</h1>
    <p>Tenho [IDADE] anos.</p>
    <p>Moro em: [BAIRRO]</p>
    <p>Meu hobby é: [HOBBY]</p>
</body>
</html>
```

**Salve o arquivo e abra no navegador (Chrome/Firefox).**

---

## 🎨 DIA 2: CSS - DEIXANDO BONITO

### O que é CSS?

CSS (Cascading Style Sheets) é a linguagem que usamos para dar estilo às páginas: cores, tamanhos, fontes.

### Como adicionar CSS

Coloque dentro da tag `<head>`:

```html
<head>
    <title>Meu Perfil</title>
    <style>
        /* Aqui vai o CSS */
    </style>
</head>
```

### Propriedades importantes

**Cores:**
```css
body {
    background-color: #f0f0f0;  /* Cor de fundo */
}

h1 {
    color: blue;  /* Cor do texto */
}
```

**Fontes:**
```css
p {
    font-size: 18px;           /* Tamanho */
    font-family: Arial;        /* Tipo de letra */
}
```

**Alinhamento:**
```css
h1 {
    text-align: center;  /* Centralizado */
}
```

### ✍️ EXERCÍCIO DO DIA 2

Adicione ao seu arquivo:

```html
<head>
    <title>Meu Perfil</title>
    <style>
        body {
            background-color: #e8f4f8;
            font-family: Arial;
        }
        
        h1 {
            color: #2c5aa0;
            text-align: center;
        }
        
        p {
            color: #333;
            font-size: 16px;
        }
    </style>
</head>
```

**Salve e veja a diferença no navegador!**

---

## 🚀 DIA 3: PROJETO FINAL

### Vamos criar um site completo!

```html
<!DOCTYPE html>
<html>
<head>
    <title>Meu Perfil Pessoal</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        
        .caixa {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        h1 {
            color: #2c5aa0;
            text-align: center;
        }
        
        .info {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        
        .contato {
            color: #2c5aa0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="caixa">
        <h1>👤 [SEU NOME]</h1>
        
        <div class="info">
            <strong>Idade:</strong> [XX] anos
        </div>
        
        <div class="info">
            <strong>Moro em:</strong> [BAIRRO], Taubaté/SP
        </div>
        
        <div class="info">
            <strong>Hobby:</strong> [SEU HOBBY]
        </div>
        
        <div class="info">
            <strong>Sobre mim:</strong><br>
            [ESCREVA UM POUCO SOBRE VOCÊ]
        </div>
        
        <p class="contato">
            📱 WhatsApp: [SEU NÚMERO]
        </p>
    </div>
</body>
</html>
```

### ✍️ DESAFIO FINAL

1. Complete com suas informações
2. Troque as cores (use: https://htmlcolorcodes.com)
3. Adicione uma foto (substitua o emoji 👤 por `<img src="sua-foto.jpg">`)
4. Personalize do seu jeito!

---

## 🎉 PARABÉNS!

Você criou seu primeiro site! 🚀

### O que aprendemos:
- ✅ HTML (estrutura)
- ✅ CSS (estilo)
- ✅ Site completo publicado

### Próximos passos:

**Sites gratuitos para continuar:**
- https://www.w3schools.com
- https://developer.mozilla.org/pt-BR/
- YouTube: Canal "Curso em Vídeo"

**Áreas de TI que estão crescendo:**
- Desenvolvimento Web
- Análise de Dados
- Cibersegurança
- Inteligência Artificial

**Dica:** Crie um portfólio com seus sites no GitHub!

---

## 🤔 DÚVIDAS?

Entre no grupo de WhatsApp e pergunte! Estou aqui para ajudar.

**Grupo:** [LINK DO GRUPO]

---

## 📋 CHECKLIST DE CONCLUSÃO

- [ ] Criei minha página HTML
- [ ] Adicionei CSS (cores e fontes)
- [ ] Personalizei com minhas informações
- [ ] Salvei o arquivo
- [ ] Abri no navegador
- [ ] Mostrei para alguém!

---

*Mini-curso oferecido como Projeto de Extensão II - UNOPAR*  
*Abril/2026*