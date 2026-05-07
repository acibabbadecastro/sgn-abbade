# 📚 RELATÓRIO DE AULA PRÁTICA 2
## Desenvolvimento Responsivo

---

**Aluno:** Acib Abbade de Castro  
**RA:** 3850892305  
**Curso:** Análise e Desenvolvimento de Sistemas  
**Instituição:** UNOPAR  
**Data:** 02/05/2026  

---

## 1. OBJETIVO DA ATIVIDADE

Implementar a responsividade em uma página web, garantindo boa usabilidade em diferentes dispositivos (desktop, tablet, smartphone) através de Media Queries CSS.

---

## 2. DESCRIÇÃO DOS PROCEDIMENTOS

### 2.1 Ferramentas Utilizadas
- **Editor:** VS Code / Replit (https://replit.com)
- **Linguagens:** HTML5 e CSS3
- **Técnica:** Media Queries com breakpoints

### 2.2 Estrutura Implementada

A página foi construída com:
- **1 arquivo HTML** (`index.html`) contendo:
  - Cabeçalho com título da disciplina
  - Container principal com 6 blocos
  - Rodapé com identificação do aluno

- **1 arquivo CSS** (`style.css`) contendo:
  - Estilização básica dos elementos
  - 4 breakpoints de responsividade

### 2.3 Breakpoints Implementados

| Breakpoint | Largura | Dispositivo | Colunas |
|------------|---------|-------------|---------|
| **BP1** | ≥1280px | Desktop | 6 colunas |
| **BP2** | 768px - 1279px | Tablet | 3 colunas |
| **BP3** | 480px - 767px | Telas pequenas | 2 colunas |
| **BP4** | <480px | Smartphone | 1 coluna |

---

## 3. CÓDIGOS IMPLEMENTADOS

### 3.1 Arquivo: index.html

```html
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desenvolvimento Responsivo - Aula Prática 2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Desenvolvimento Responsivo</h1>
        <p>Aula Prática 2 - UNOPAR</p>
    </header>

    <main>
        <div class="container">
            <div class="bloco" style="background-color: #e74c3c;">
                <h2>Bloco 1</h2>
                <p>Conteúdo do bloco 1</p>
            </div>
            <div class="bloco" style="background-color: #3498db;">
                <h2>Bloco 2</h2>
                <p>Conteúdo do bloco 2</p>
            </div>
            <div class="bloco" style="background-color: #2ecc71;">
                <h2>Bloco 3</h2>
                <p>Conteúdo do bloco 3</p>
            </div>
            <div class="bloco" style="background-color: #f39c12;">
                <h2>Bloco 4</h2>
                <p>Conteúdo do bloco 4</p>
            </div>
            <div class="bloco" style="background-color: #9b59b6;">
                <h2>Bloco 5</h2>
                <p>Conteúdo do bloco 5</p>
            </div>
            <div class="bloco" style="background-color: #1abc9c;">
                <h2>Bloco 6</h2>
                <p>Conteúdo do bloco 6</p>
            </div>
        </div>
    </main>

    <footer>
        <p>Acib Abbade de Castro - Análise e Desenvolvimento de Sistemas - UNOPAR</p>
    </footer>
</body>
</html>
```

### 3.2 Arquivo: style.css

```css
/* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    padding: 20px;
    background-color: #f4f4f4;
}

header {
    text-align: center;
    margin-bottom: 30px;
    padding: 20px;
    background-color: #2c3e50;
    color: white;
    border-radius: 5px;
}

header h1 {
    margin-bottom: 10px;
}

.container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.bloco {
    flex: 1;
    min-width: 150px;
    padding: 30px;
    color: white;
    border-radius: 5px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.bloco h2 {
    margin-bottom: 15px;
    font-size: 1.5em;
}

.bloco p {
    font-size: 1em;
}

footer {
    text-align: center;
    margin-top: 30px;
    padding: 20px;
    background-color: #2c3e50;
    color: white;
    border-radius: 5px;
}

/* ===========================================
   MEDIA QUERIES - RESPONSIVIDADE
   =========================================== */

/* Breakpoint 1280px+ - Desktop (6 colunas) */
@media (min-width: 1280px) {
    .container {
        display: flex;
        flex-wrap: wrap;
    }
    
    .bloco {
        flex: 0 0 calc(16.666% - 20px); /* 6 blocos = 100% / 6 = 16.666% */
    }
}

/* Breakpoint 768px+ - Tablet (3 colunas) */
@media (min-width: 768px) and (max-width: 1279px) {
    .container {
        display: flex;
        flex-wrap: wrap;
    }
    
    .bloco {
        flex: 0 0 calc(33.333% - 20px); /* 3 blocos = 100% / 3 = 33.333% */
    }
}

/* Breakpoint 480px+ - Telas pequenas (2 colunas) */
@media (min-width: 480px) and (max-width: 767px) {
    .container {
        display: flex;
        flex-wrap: wrap;
    }
    
    .bloco {
        flex: 0 0 calc(50% - 20px); /* 2 blocos = 100% / 2 = 50% */
    }
}

/* Breakpoint < 480px - Smartphone (1 coluna) */
@media (max-width: 479px) {
    .container {
        display: flex;
        flex-direction: column;
    }
    
    .bloco {
        flex: 0 0 100%; /* 1 bloco por linha */
    }
    
    header h1 {
        font-size: 1.5em;
    }
    
    .bloco h2 {
        font-size: 1.2em;
    }
}
```

---

## 4. EXPLICAÇÃO TÉCNICA

### 4.1 Conceito de Responsividade

A responsividade web permite que uma página se adapte automaticamente ao tamanho da tela do dispositivo do usuário, garantindo boa usabilidade em:
- **Desktops** (telas grandes)
- **Tablets** (telas médias)
- **Smartphones** (telas pequenas)

### 4.2 Media Queries

As Media Queries são regras CSS que aplicam estilos condicionalmente baseados em características do dispositivo (largura, altura, orientação, etc.).

**Sintaxe:**
```css
@media (condição) {
    /* estilos aplicados quando a condição é verdadeira */
}
```

### 4.3 Breakpoints Utilizados

**Breakpoint 1 (≥1280px):**
- Dispositivo: Desktop
- Layout: 6 colunas (16.666% cada bloco)
- Justificativa: Telas grandes comportam todos os blocos lado a lado

**Breakpoint 2 (768px - 1279px):**
- Dispositivo: Tablet
- Layout: 3 colunas (33.333% cada bloco)
- Justificativa: Reduz para metade dos blocos por linha

**Breakpoint 3 (480px - 767px):**
- Dispositivo: Smartphones grandes / Mini tablets
- Layout: 2 colunas (50% cada bloco)
- Justificativa: Mantém legibilidade com 2 blocos por linha

**Breakpoint 4 (<480px):**
- Dispositivo: Smartphones
- Layout: 1 coluna (100% largura)
- Justificativa: Espaço limitado exige blocos empilhados

---

## 5. TESTES REALIZADOS

### 5.1 Procedimento de Teste
1. Acessar https://replit.com
2. Criar template HTML, CSS, JS
3. Copiar códigos para index.html e style.css
4. Clicar em "Run" para visualizar
5. Redimensionar janela do navegador
6. Verificar mudança de layout em cada breakpoint

### 5.2 Resultados Esperados

| Largura da Tela | Nº Colunas | Visualização |
|-----------------|------------|--------------|
| 1920px | 6 | Todos blocos em 1 linha |
| 1280px | 6 | Todos blocos em 1 linha |
| 1024px | 3 | 2 linhas de 3 blocos |
| 768px | 3 | 2 linhas de 3 blocos |
| 600px | 2 | 3 linhas de 2 blocos |
| 480px | 2 | 3 linhas de 2 blocos |
| 375px | 1 | 6 linhas de 1 bloco |

---

## 6. CONCLUSÃO

A atividade permitiu compreender na prática como implementar responsividade em páginas web utilizando Media Queries CSS. Os 4 breakpoints garantem que o conteúdo seja exibido de forma adequada em qualquer dispositivo, desde desktops até smartphones.

**Competências desenvolvidas:**
- ✅ Uso de Flexbox para layout
- ✅ Implementação de Media Queries
- ✅ Cálculo de porcentagens para colunas
- ✅ Teste em múltiplos dispositivos
- ✅ Boas práticas de desenvolvimento responsivo

---

## 7. REFERÊNCIAS

- MDN Web Docs - Media Queries: https://developer.mozilla.org/pt-BR/docs/Web/CSS/Media_Queries
- W3Schools - Responsive Web Design: https://www.w3schools.com/css/css_rwd_intro.asp
- Replit - Editor Online: https://replit.com

---

**Local e Data:** Taubaté/SP, 02 de maio de 2026

**Assinatura:** _________________________
**Acib Abbade de Castro**
