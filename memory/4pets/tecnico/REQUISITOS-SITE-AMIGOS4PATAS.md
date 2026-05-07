# 🐾 REQUISITOS TÉCNICOS - SITE AMIGOS 4 PATAS
## Especificação Completa do Sistema

**Data:** 26/04/2026  
**Solicitante:** Acib ABBADE  
**Status:** Aguardando VPS (compra em andamento)

---

## 🎯 FUNCIONALIDADES PRINCIPAIS

### 1️⃣ CADASTRO DE ANIMAL (Formulário)

**Campos Obrigatórios:**
- 📸 Foto (até 5 fotos)
- 🐕 Nome do animal
- 📍 Bairro
- 📅 Data (sumiço/encontro)

**Campos Opcionais:**
- Espécie (cachorro/gato/outro)
- Idade aproximada
- Peso aproximado
- Cor/Raça
- Porte (pequeno/médio/grande)
- Castrado (sim/não/não sei)
- Vacinado (sim/não/não sei)
- Problemas de saúde
- Alergias
- Medicamentos
- Necessidades especiais
- Comportamento

**Dados do Proprietário/Quem Encontrou:**
- Nome
- Telefone/WhatsApp
- Email (opcional)
- Pode resgatar/ficar com animal?

---

### 2️⃣ PÁGINA DE CONFIRMAÇÃO (Após Cadastro)

**Após enviar formulário:**
- ✅ Mensagem: "Cadastro realizado com sucesso!"
- 👁️ Mostrar prévia do que foi cadastrado
- 🔗 Link para "Ver todos os animais"
- 📱 Botão: "Cadastrar outro animal"
- 💬 Botão: "Compartilhar no WhatsApp"

---

### 3️⃣ PÁGINA DE BUSCA/LISTAGEM (Principal)

**URL:** `/buscar` ou `/animais`

**Filtros Disponíveis:**

| Filtro | Tipo | Opções |
|--------|------|--------|
| **Status** | Dropdown | Perdido / Encontrado / Para Adoção / Resgatado / Todos |
| **Espécie** | Dropdown | Cachorro / Gato / Outro / Todos |
| **Bairro** | Dropdown | Lista dinâmica dos bairros cadastrados / Todos |
| **Porte** | Dropdown | Pequeno / Médio / Grande / Todos |
| **Data** | Date Picker | De: ___ Até: ___ |
| **Mês** | Dropdown | Janeiro, Fevereiro, Março... / Todos |
| **Ano** | Dropdown | 2026, 2025... / Todos |
| **Palavra-chave** | Texto | Buscar em nome, descrição, características |

**Exibição dos Resultados:**

```
┌─────────────────────────────────────────┐
│ 🔍 12 animais encontrados               │
│                                         │
│ [Filtros ativos: Perdido | Maio 2026]   │
│                                         │
├─────────────────────────────────────────┤
│                                         │
│ ┌─────────────────────────────────────┐ │
│ │ 📸 [FOTO]                           │ │
│ │                                     │ │
│ │ 🐕 THOR - PERDIDO                   │ │
│ │ 📍 Parque Meia Lua                  │ │
│ │ 📅 15/05/2026                       │ │
│ │                                     │ │
│ │ Caramelo, Porte Médio, 3 anos       │ │
│ │                                     │ │
│ │ [👁️ Ver detalhes]  [📱 WhatsApp]   │ │
│ └─────────────────────────────────────┘ │
│                                         │
│ ┌─────────────────────────────────────┐ │
│ │ 📸 [FOTO]                           │ │
│ │                                     │ │
│ │ 🐈 LUNA - ENCONTRADA                │ │
│ │ 📍 Jardim das Oliveiras             │ │
│ │ 📅 20/05/2026                       │ │
│ │                                     │ │
│ │ Preta, Filhote, Fêmea               │ │
│ └─────────────────────────────────────┘ │
│                                         │
│ [1] [2] [3] ... [Próximo →]            │
│                                         │
└─────────────────────────────────────────┘
```

**Ordenação:**
- Mais recentes primeiro (padrão)
- Mais antigos primeiro
- Por bairro (A-Z)
- Por nome do animal (A-Z)

---

### 4️⃣ PÁGINA DE DETALHES DO ANIMAL

**URL:** `/animal/[id]`

```
┌─────────────────────────────────────────┐
│ 🐕 THOR                                 │
│ Status: 🔴 PERDIDO                      │
│                                         │
│ ┌─────────────────┐                     │
│ │                 │                     │
│ │  [FOTO GRANDE]  │  ← Destaque        │
│ │                 │                     │
│ └─────────────────┘                     │
│                                         │
│ 📸 Mais fotos: [1] [2] [3] [4] [5]     │
│                                         │
├─────────────────────────────────────────┤
│ 📋 INFORMAÇÕES                          │
│                                         │
│ Nome: Thor                              │
│ Espécie: Cachorro                       │
│ Raça: Vira-lata (SRD)                   │
│ Idade: 3 anos                           │
│ Peso: 12 kg                             │
│ Porte: Médio                            │
│ Cor: Caramelo com mancha branca no peito│
│ Sexo: Macho                             │
│                                         │
├─────────────────────────────────────────┤
│ 🏥 SAÚDE                                │
│                                         │
│ Castrado: ✅ Sim                        │
│ Vacinado: ✅ Sim                        │
│ Problemas: Diabético (precisa insulina) │
│ Alergias: Nenhuma                       │
│ Medicamentos: Insulina 2x ao dia         │
│                                         │
├─────────────────────────────────────────┤
│ 📍 DESAPARECIMENTO                      │
│                                         │
│ Data: 15/05/2026                        │
│ Período: Tarde (14h-18h)                │
│ Bairro: Parque Meia Lua                 │
│ Endereço: Rua das Flores, 123           │
│ Ponto de ref.: Próximo ao mercado       │
│ Coleira: ✅ Sim (preta)                 │
│ Placa: ✅ Sim (nome + telefone)         │
│ Chip: ❌ Não                            │
│                                         │
├─────────────────────────────────────────┤
│ 👤 CONTATO                               │
│                                         │
│ Proprietário: Maria Silva               │
│ Telefone: (12) 98765-4321               │
│ WhatsApp: ✅ Disponível                 │
│                                         │
│ 💰 Recompensa: R$ 500,00                │
│                                         │
│ [📱 WhatsApp] [📞 Ligar] [✉️ Email]     │
│                                         │
├─────────────────────────────────────────┤
│ 📅 Cadastrado em: 15/05/2026 às 15:30   │
│ 👁️ Visualizações: 127                   │
│                                         │
│ [🔙 Voltar para busca]                  │
│                                         │
└─────────────────────────────────────────┘
```

---

## 🗄️ ESTRUTURA DO BANCO DE DADOS

### Tabela: `animais`

```sql
CREATE TABLE animais (
    id SERIAL PRIMARY KEY,
    status VARCHAR(20) NOT NULL, -- 'perdido', 'encontrado', 'adoção', 'resgatado'
    
    -- Informações básicas
    nome VARCHAR(100) NOT NULL,
    especie VARCHAR(20), -- 'cachorro', 'gato', 'outro'
    raca VARCHAR(100),
    idade VARCHAR(50),
    peso VARCHAR(50),
    porte VARCHAR(20), -- 'pequeno', 'medio', 'grande'
    cor VARCHAR(100),
    sexo VARCHAR(10), -- 'macho', 'femea', 'nao_sei'
    
    -- Saúde
    castrado VARCHAR(10), -- 'sim', 'nao', 'nao_sei'
    vacinado VARCHAR(10), -- 'sim', 'nao', 'nao_sei'
    problemas_saude TEXT,
    alergias TEXT,
    medicamentos TEXT,
    necessidades_especiais TEXT,
    comportamento TEXT,
    
    -- Localização
    bairro VARCHAR(100) NOT NULL,
    endereco TEXT,
    ponto_referencia TEXT,
    
    -- Data
    data_evento DATE NOT NULL,
    horario_evento VARCHAR(50),
    
    -- Acessórios
    coleira BOOLEAN DEFAULT FALSE,
    placa BOOLEAN DEFAULT FALSE,
    chip BOOLEAN DEFAULT FALSE,
    
    -- Contato
    nome_contato VARCHAR(100),
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    whatsapp BOOLEAN DEFAULT TRUE,
    pode_resgatar BOOLEAN DEFAULT FALSE,
    
    -- Adicionais
    recompensa DECIMAL(10,2),
    observacoes TEXT,
    
    -- Fotos (URLs)
    foto_principal VARCHAR(500),
    fotos_adicionais TEXT[], -- array de URLs
    
    -- Metadados
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    visualizacoes INTEGER DEFAULT 0,
    ativo BOOLEAN DEFAULT TRUE
);
```

### Tabela: `bairros` (para dropdown)

```sql
CREATE TABLE bairros (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) DEFAULT 'Taubaté',
    estado VARCHAR(2) DEFAULT 'SP',
    ativo BOOLEAN DEFAULT TRUE
);
```

**Bairros iniciais (Parque Meia Lua e região):**
- Parque Meia Lua
- Jardim das Oliveiras
- Vila São Jorge
- Jardim Paulista
- Centro
- [Adicionar outros da região]

---

## 🎨 DESIGN/WIREFRAMES

### Cores Sugeridas:
- **Primária:** Verde (#2E7D32) - Esperança/natureza
- **Secundária:** Laranja (#F57C00) - Atenção/alerta
- **Fundo:** Branco/Off-white (#FAFAFA)
- **Texto:** Cinza escuro (#333333)
- **Sucesso:** Verde claro (#4CAF50)
- **Perigo:** Vermelho (#D32F2F)

### Layout Responsivo:
- 📱 Mobile: 1 coluna (celular)
- 📲 Tablet: 2 colunas
- 💻 Desktop: 3 colunas (grid)

---

## 🔧 TECNOLOGIAS RECOMENDADAS (VPS)

### Backend:
- **Python + Flask** (fácil, rápido)
- **PostgreSQL** (banco de dados)
- **SQLAlchemy** (ORM)

### Frontend:
- **HTML5 + CSS3 + JavaScript**
- **Bootstrap 5** (responsivo)
- **jQuery** ou **Vanilla JS** (interações)

### Upload de Fotos:
- **Pasta local no VPS** `/var/www/uploads/`
- **Nginx** servindo arquivos estáticos
- **Thumbnail automático** (redimensionar fotos)

### Filtros/Busca:
- **SQL com WHERE dinâmico**
- **Paginação** (10 ou 20 itens por página)
- **Índices** no banco para performance

---

## 📋 CHECKLIST DE IMPLEMENTAÇÃO

### Fase 1: Banco de Dados
- [ ] Criar tabela `animais`
- [ ] Criar tabela `bairros`
- [ ] Inserir bairros iniciais
- [ ] Criar índices para busca

### Fase 2: Backend (Python/Flask)
- [ ] Configurar Flask
- [ ] Rota `/cadastrar` (POST)
- [ ] Rota `/buscar` (GET com filtros)
- [ ] Rota `/animal/<id>` (GET detalhes)
- [ ] Upload de fotos (salvar no disco)
- [ ] Validação de dados

### Fase 3: Frontend
- [ ] Página inicial (home)
- [ ] Formulário de cadastro
- [ ] Página de confirmação (após cadastro)
- [ ] Página de busca com filtros
- [ ] Página de detalhes do animal
- [ ] Template base (header, footer, menu)

### Fase 4: Funcionalidades Extras
- [ ] Paginação na busca
- [ ] Contador de visualizações
- [ ] Botão "Compartilhar no WhatsApp"
- [ ] Thumbnail de fotos
- [ ] Responsivo (mobile)

### Fase 5: Deploy
- [ ] Configurar Nginx
- [ ] Configurar SSL (HTTPS)
- [ ] Backup automático do banco
- [ ] Testar tudo

---

## 🚀 FLUXO DE USO COMPLETO

```
USUÁRIO ACESSA SITE
        ↓
├─→ [Quero cadastrar animal]
│         ↓
│   PREENCHE FORMULÁRIO
│   (foto + dados)
│         ↓
│   CLICA [CADASTRAR]
│         ↓
│   ✅ PÁGINA DE CONFIRMAÇÃO
│   "Cadastro realizado!"
│         ↓
│   ├─→ [Ver todos os animais]
│   └─→ [Cadastrar outro]
│
└─→ [Quero procurar animal]
          ↓
    SELECIONA FILTROS
    (bairro: Parque Meia Lua,
     status: Perdido,
     mês: Maio)
          ↓
    CLICA [BUSCAR]
          ↓
    📋 LISTA DE ANIMAIS
    (com fotos e resumo)
          ↓
    CLICA EM UM ANIMAL
          ↓
    👁️ PÁGINA DE DETALHES
    (todas as infos + contato)
          ↓
    [📱 WhatsApp] → Abre WhatsApp
```

---

## 💾 BACKUP E SEGURANÇA

- **Backup diário** do banco PostgreSQL
- **Backup das fotos** (pasta uploads)
- **SSL/HTTPS** obrigatório
- **Proteção contra SQL Injection** (usar ORM)
- **Validação** de todos os inputs
- **Limite de tamanho** de fotos (max 5MB cada)

---

## 📱 INTEGRAÇÃO COM WHATSAPP

### Botão de Contato:
```html
<a href="https://wa.me/5512987654321?text=Olá! Vi sobre o animal NOME no site Amigos 4 Patas."
   target="_blank">
   📱 WhatsApp
</a>
```

### Compartilhar:
```html
<a href="https://wa.me/?text=Olha esse animal perdido: https://site.com/animal/123"
   target="_blank">
   💬 Compartilhar
</a>
```

---

## ⏰ ESTIMATIVA DE TEMPO

Com VPS configurado e acesso:
- **Banco de dados:** 2-3 horas
- **Backend Python:** 4-6 horas
- **Frontend:** 4-6 horas
- **Testes e ajustes:** 2-3 horas
- **Deploy:** 1-2 horas

**Total estimado:** 2-3 dias de trabalho

---

*Documento criado em: 26/04/2026*  
*Por: Stark - Assistente Técnico de Acib ABBADE*  
*Status: Aguardando credenciais do VPS*
