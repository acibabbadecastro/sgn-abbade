# APOSTILA - MINI-WORKSHOP DESENVOLVIMENTO WEB
## Módulo 1: HTML Básico (60 minutos)

---

## 📚 O QUE É HTML?

**HTML** = HyperText Markup Language

É a **linguagem** usada para criar páginas web. Funciona como o **esqueleto** de um site.

**Exemplo:**
```html
<!DOCTYPE html>
<html>
<head>
    <title>Meu Primeiro Site</title>
</head>
<body>
    <h1>Olá, Mundo!</h1>
    <p>Este é meu primeiro site.</p>
</body>
</html>
```

---

## 🏗️ ESTRUTURA BÁSICA

Todo site HTML tem essa estrutura:

```html
<!DOCTYPE html>
<html>
    <head>
        <!-- Configurações (não aparece na página) -->
    </head>
    <body>
        <!-- Conteúdo VISÍVEL da página -->
    </body>
</html>
```

---

## 📝 TAGS ESSENCIAIS

### **Títulos:**
```html
<h1>Título Principal</h1>
<h2>Subtítulo</h2>
<h3>Título Menor</h3>
```

### **Parágrafos:**
```html
<p>Este é um parágrafo de texto.</p>
```

### **Imagens:**
```html
<img src="foto.jpg" alt="Descrição da imagem">
```

### **Links:**
```html
<a href="https://google.com">Clique aqui</a>
```

### **Quebra de linha:**
```html
<br>
```

---

## ✍️ EXERCÍCIO PRÁTICO 1

**Crie uma página com:**
1. Seu nome no título principal (h1)
2. Uma foto sua (img)
3. Seu bairro (p)
4. Sua idade (p)
5. Seu hobby favorito (p)

---

## 🎨 Módulo 2: CSS Básico (60 minutos)

### O QUE É CSS?

**CSS** = Cascading Style Sheets

É a linguagem que deixa o site **bonito** (cores, tamanhos, posições).

---

## 🎯 FORMAS DE USAR CSS

### **Forma 1: Dentro da tag (Inline)**
```html
<h1 style="color: blue;">Título Azul</h1>
```

### **Forma 2: No cabeçalho (Recomendado)**
```html
<head>
    <style>
        h1 {
            color: blue;
            font-size: 30px;
        }
        p {
            color: gray;
        }
    </style>
</head>
```

---

## 🌈 PROPRIEDADES IMPORTANTES

### **Cores:**
```css
color: red;           /* Cor do texto */
color: #FF0000;      /* Código hexadecimal */
color: rgb(255,0,0); /* RGB */
background-color: yellow; /* Cor de fundo */
```

### **Fontes:**
```css
font-size: 20px;      /* Tamanho */
font-family: Arial;   /* Tipo de letra */
font-weight: bold;    /* Negrito */
```

### **Espaçamento:**
```css
text-align: center;   /* Alinhamento */
margin: 10px;        /* Espaço externo */
padding: 20px;       /* Espaço interno */
```

---

## 🖼️ EXEMPLO COMPLETO

```html
<!DOCTYPE html>
<html>
<head>
    <title>Meu Perfil</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .foto {
            width: 200px;
            border-radius: 50%;
        }
        .caixa {
            background-color: white;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="caixa">
        <h1>João Silva</h1>
        <img src="foto.jpg" class="foto">
        <p>Moro em: Parque Meia Lua</p>
        <p>Idade: 25 anos</p>
        <p>Hobby: Futebol</p>
    </div>
</body>
</html>
```

---

## ✍️ EXERCÍCIO PRÁTICO 2

**Estilize sua página:**
1. Coloque fundo colorido
2. Mude a cor do título
3. Centralize o texto
4. Adicione bordas arredondadas
5. Mude o tamanho da foto

---

## 🎯 PROJETO FINAL (45 minutos)

### **Página de Apresentação Pessoal**

**Deve ter:**
- [ ] Título com seu nome
- [ ] Sua foto
- [ ] Informações: idade, bairro, hobby
- [ ] Contato (WhatsApp ou email)
- [ ] Cores e estilos personalizados
- [ ] Bordas e espaçamento organizado

---

## ✅ CHECKLIST DE CONCLUSÃO

- [ ] Criei minha página HTML
- [ ] Adicionei título, texto e imagem
- [ ] Apliquei CSS (cores e fontes)
- [ ] Página está organizada e bonita
- [ ] Publiquei meu site

---

## 📚 RECURSOS PARA CONTINUAR

**Sites gratuitos para estudar:**
- https://www.w3schools.com (inglês)
- https://developer.mozilla.org (português)
- https://www.cursoemvideo.com (cursos gratuitos)

**YouTube:**
- Canal "Curso em Vídeo" - Gustavo Guanabara

---

*Apostila elaborada para Mini-Workshop de Desenvolvimento Web*
*Projeto de Extensão II - UNOPAR*
*Abril/2026*
