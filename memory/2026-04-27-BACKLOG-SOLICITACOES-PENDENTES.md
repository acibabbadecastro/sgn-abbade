# 📋 BACKLOG DE SOLICITAÇÕES - Site Amigos de 4 Patas
## Documento de Registro de Alterações Pendentes

**Data:** 27/04/2026  
**Hora:** 10:05  
**Solicitante:** Acib Abbade de Castro  
**Status:** ⏳ Pendente Execução  

---

## 🎯 SOLICITAÇÕES IDENTIFICADAS

### ✅ 1. SESSÃO RAÇAS/CUIDADOS/TEMPERAMENTOS
**Prioridade:** 🔴 ALTA  
**Status:** ⏳ Aguardando execução  
**Complexidade:** ⭐⭐⭐ (Média)  
**Estimativa:** 30-45 minutos  

**Descrição:**  
Criar página ou seção dedicada às principais raças de cães e gatos contendo:
- 🐕 Principais raças de cães
- 🐈 Principais raças de gatos  
- 🏥 Cuidados específicos por raça
- 🎭 Temperamentos e personalidades
- 📜 História da raça (origem)
- ❓ Como surgiu (evolução/seleção)

**Método de Execução:**
1. Pesquisar dados sobre raças populares no Brasil
2. Criar estrutura JSON/YAML com informações organizadas
3. Desenvolver template HTML responsivo
4. Criar cards interativos com filtros
5. Integrar ao menu principal do site

**Arquivos a Criar:**
- `/racas.html` - Página principal
- `/js/racas-data.js` - Base de dados
- `/css/racas.css` - Estilos específicos (ou usar existente)

---

### ✅ 2. SESSÃO JURÍDICA/CONFLITOS/MEDIAÇÃO
**Prioridade:** 🔴 ALTA  
**Status:** ⏳ Aguardando execução  
**Complexidade:** ⭐⭐⭐⭐ (Alta - requer pesquisa jurídica)  
**Estimativa:** 45-60 minutos  

**Descrição:**  
Seção especializada em problemas jurídicos e conflitos envolvendo animais, agindo como mediadora para manter a paz entre vizinhos.

**Casos a Documentar:**
- 🐱 Gatos invadindo casa do vizinho (jardim, quintal, telhado)
- 🐕 Cães latindo sem parar (perturbação de sossego)
- 💩 Fezes em áreas comuns/escadas
- 🐾 Arranhões/danos em propriedade
- 🚫 Animais em condomínios (regras, proibições)
- ⚖️ Responsabilidade civil por danos causados por pets

**Abordagem:** "Ajuda aos dois lados"
- 👤 Dono do pet: Como resolver/prevenir problemas
- 🏠 Vizinho prejudicado: Como proceder legalmente
- ⚖️ Base legal: Artigos do Código Civil, Lei de Perturbação

**Método de Execução:**
1. Pesquisar legislação aplicável:
   - Código Civil (arts. 186, 927 - responsabilidade)
   - Lei de Perturbação do Sossego (Lei 9.605/98)
   - Lei de Condomínios
   - Lei 14.064/2020 (proteção animal)
2. Criar guia prático por cenário
3. Desenvolver fluxograma de resolução
4. Incluir modelos de notificação/formalização
5. Destacar mediação antes de ação judicial

**Arquivos a Criar:**
- `/juridico.html` ou `/conflitos.html`
- `/docs/guia-juridico-animais.pdf` (opcional)
- Seção em FAQ ou página dedicada

---

### ✅ 3. BALÃO/CHAT DE AJUDA VIRTUAL
**Prioridade:** 🟡 MÉDIA  
**Status:** ⏳ Aguardando execução  
**Complexidade:** ⭐⭐ (Baixa-Média)  
**Estimativa:** 20-30 minutos  

**Descrição:**  
Widget flutuante tipo "Como posso ajudar?" ou "Posso colaborar?" com conversas prontas para assuntos comuns do site.

**Funcionalidades:**
- 💬 Balão flutuante no canto inferior direito
- 🤖 Mensagens pré-programadas por contexto
- 🎯 Direcionamento rápido:
  - "Perdi meu pet" → Link perdidos
  - "Quero adotar" → Link adoção
  - "Vi um animal perdido" → Link avistados
  - "Denunciar maus tratos" → Link denúncia
  - "Problema com vizinho/pet" → Link jurídico

**Método de Execução:**
1. Criar widget HTML/CSS flutuante
2. Desenvolver lógica de respostas (JavaScript simples)
3. Preparar árvore de decisão (if/else ou switch)
4. Integrar com links internos do site
5. Opção de minimizar/fechar para usuário

**Arquivos a Modificar/Criar:**
- Modificar `index.html` (incluir script)
- Criar `/js/chat-widget.js`
- Adicionar CSS no arquivo de estilos existente

---

### ✅ 4. OTIMIZAR TAMANHO DO SITE
**Prioridade:** 🟡 MÉDIA  
**Status:** ⏳ Aguardando execução  
**Complexidade:** ⭐⭐ (Baixa)  
**Estimativa:** 15-20 minutos  

**Descrição:**  
Usuário questionou se o site está "muito extenso/comprido". Verificar e otimizar sem perder funcionalidades.

**Diagnóstico Atual:**
- `index.html`: ~33KB (aceitável, mas pode otimizar)
- Total de páginas: 4 principais + admin
- Carregamento: Pode implementar lazy loading

**Método de Execução:**
1. Verificar se há CSS/JS redundante
2. Implementar carregamento lazy de imagens/seções
3. Minificar arquivos (remover espaços/comentários desnecessários)
4. Separar CSS crítico (inline) do restante (arquivo externo)
5. Carregar JavaScript assíncrono quando possível
6. Avaliar se alguma seção pode ser colapsável (accordion)

**Arquivos a Analisar:**
- `index.html` - principal candidato
- `perdidos.html` - verificar se está otimizado
- `avistados.html` - verificar se está otimizado
- `adocao.html` - verificar se está otimizado

---

### ✅ 5. SESSÃO/CADASTRO DE PARCERIAS
**Prioridade:** 🟢 BAIXA  
**Status:** ⏳ Aguardando execução  
**Complexidade:** ⭐⭐ (Baixa)  
**Estimativa:** 20 minutos  

**Descrição:**  
Expandir seção de parceiros para incluir:
- 🏥 Clínicas veterinárias
- 🛒 Casas de ração/pet shops
- 🤝 ONGs de proteção animal
- 🐕 Grupos de resgate
- 💰 Canal para doações e apoio

**Funcionalidades:**
- Formulário para novas parcerias se candidatarem
- Cards de parceiros com logo, endereço, telefone
- Destaque para parceiros que apoiam/doam
- Integração com mapa (localização)

**Método de Execução:**
1. Criar página `/parceiros.html` ou expandir existente
2. Desenvolver formulário de candidatura
3. Backend para receber cadastros (PHP/json)
4. Criar cards responsivos
5. Adicionar filtros por tipo (clínica, loja, ONG)

**Arquivos a Criar/Modificar:**
- `/parceiros.html` (nova página ou expandir)
- `/salvar-parceria.php` (backend)
- Modificar menu principal para incluir link

---

## 📊 RESUMO DE PRIORIDADES

| # | Tarefa | Prioridade | Tempo Est. | Complexidade |
|---|--------|------------|------------|--------------|
| 1 | Raças/Cuidados | 🔴 ALTA | 30-45 min | ⭐⭐⭐ |
| 2 | Jurídica/Conflitos | 🔴 ALTA | 45-60 min | ⭐⭐⭐⭐ |
| 3 | Chat/Balão Ajuda | 🟡 MÉDIA | 20-30 min | ⭐⭐ |
| 4 | Otimizar Tamanho | 🟡 MÉDIA | 15-20 min | ⭐⭐ |
| 5 | Parcerias | 🟢 BAIXA | 20 min | ⭐⭐ |

---

## 🛠️ MÉTODO DE TRABALHO

### Para Cada Solicitação:

1. **PESQUISA** (se necessário)
   - Verificar legislação atualizada
   - Consultar fontes oficiais
   - Validar informações

2. **PLANEJAMENTO**
   - Definir arquivos a criar/modificar
   - Estimar tempo de execução
   - Prever possíveis obstáculos

3. **DESENVOLVIMENTO**
   - Criar em ambiente local/workspace primeiro
   - Testar funcionalidades
   - Validar responsividade (mobile/desktop)

4. **DEPLOY**
   - Fazer backup do existente
   - Enviar para servidor (CT 107)
   - Verificar se está funcionando online
   - Testar novamente

5. **DOCUMENTAÇÃO**
   - Atualizar este backlog (marcar como concluído)
   - Registrar em MEMORY.md
   - Criar resumo para usuário

---

## 🔄 PROXIMOS PASSOS

Aguardando definição de prioridade do usuário para:
1. Executar item #1 e #2 (Alta prioridade)
2. Executar item #3 e #4 (Média prioridade)
3. Executar item #5 (Baixa prioridade)
4. Executar todos de uma vez (sessão longa)

---

## 📁 ARQUIVOS RELACIONADOS

- Site: https://amigos4patas.com.br
- Admin: https://amigos4patas.com.br/admin.php
- Pasta local: `/root/.openclaw/workspace/amigos4patas-*`
- Servidor: CT 107 (192.168.0.200)

---

**Documento criado por:** Stark 🤖  
**Data de criação:** 27/04/2026 10:05  
**Última atualização:** 27/04/2026 10:05  
**Status:** ⏳ Aguardando execução
