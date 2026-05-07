# PROJETO: MINHA PRÓPRIA IA CORE
## Sistema de Inteligência Artificial Personalizado

---

## 🎯 VISÃO GERAL

Criar um núcleo de IA próprio, similar ao OpenClaw, mas totalmente sob seu controle.

### **Funcionalidades:**
- 🤖 Processamento de linguagem natural
- 💾 Sistema de memória persistente
- 🔌 API REST para integração
- 🎨 Interface web personalizada
- 📱 Integração com Telegram/WhatsApp
- 🧠 Multi-modelos (Ollama, LM Studio, etc.)

---

## 🏗️ ARQUITETURA SUGERIDA

```
┌─────────────────────────────────────────┐
│           INTERFACE WEB                 │
│  (React/Vue/HTML + CSS + JavaScript)   │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│              API CORE                   │
│         (Python FastAPI)                │
│  • Gerenciamento de conversas          │
│  • Sistema de memória                  │
│  • Plugins/Habilidades                 │
│  • Autenticação                        │
└─────────────────┬───────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│           ENGINE DE IA                  │
│    (Ollama / LM Studio / OpenAI)       │
│  • Processamento de LLM                │
│  • Embeddings                          │
│  • Funções/Tools                       │
└─────────────────────────────────────────┘
                  │
┌─────────────────▼───────────────────────┐
│           BANCO DE DADOS              │
│      (PostgreSQL + Redis)              │
│  • Memórias de longo prazo            │
│  • Histórico de conversas             │
│  • Configurações                       │
└─────────────────────────────────────────┘
```

---

## 📋 REQUISITOS TÉCNICOS

### **Hardware Mínimo:**
- CPU: 4 cores
- RAM: 8GB (16GB recomendado)
- GPU: Opcional (acelera modelos)
- Disco: 50GB SSD

### **Software:**
- Python 3.10+
- Node.js 18+
- Docker (opcional)
- Ollama ou LM Studio

---

## 🚀 IMPLEMENTAÇÃO PASSO A PASSO

### **FASE 1: Setup Inicial (Dia 1)**

#### **1.1 Instalar Ollama:**
```bash
# Linux/Mac
curl https://ollama.ai/install.sh | sh

# Windows (PowerShell)
wget https://ollama.ai/download/OllamaSetup.exe -O ollama.exe
./ollama.exe
```

#### **1.2 Baixar modelo:**
```bash
ollama pull llama3.2
# ou
ollama pull mistral
# ou
ollama pull qwen2.5
```

#### **1.3 Testar:**
```bash
ollama run llama3.2
# Digite: Olá, como você está?
# Saia com: /bye
```

---

### **FASE 2: API Core (Dia 2-3)**

#### **2.1 Estrutura de Pastas:**
```
minha-ia-core/
├── backend/
│   ├── app/
│   │   ├── __init__.py
│   │   ├── main.py
│   │   ├── models/
│   │   ├── memory/
│   │   ├── plugins/
│   │   └── config.py
│   ├── requirements.txt
│   └── Dockerfile
├── frontend/
│   ├── public/
│   ├── src/
│   └── package.json
├── database/
│   └── schema.sql
└── docker-compose.yml
```

#### **2.2 Backend Python (FastAPI):**

**main.py:**
```python
from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import ollama
import json
from datetime import datetime

app = FastAPI(title="Minha IA Core")

class Mensagem(BaseModel):
    texto: str
    usuario_id: str = "default"
    contexto: dict = {}

class Resposta(BaseModel):
    texto: str
    timestamp: str
    modelo: str
    tokens: int

@app.post("/chat", response_model=Resposta)
async def chat(mensagem: Mensagem):
    try:
        # Buscar contexto/memória
        contexto = await buscar_memoria(mensagem.usuario_id)
        
        # Chamar Ollama
        response = ollama.chat(
            model='llama3.2',
            messages=[
                {'role': 'system', 'content': 'Você é um assistente útil e amigável.'},
                {'role': 'user', 'content': mensagem.texto}
            ]
        )
        
        # Salvar na memória
        await salvar_memoria(mensagem.usuario_id, mensagem.texto, response['message']['content'])
        
        return Resposta(
            texto=response['message']['content'],
            timestamp=datetime.now().isoformat(),
            modelo='llama3.2',
            tokens=response.get('prompt_eval_count', 0)
        )
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

async def buscar_memoria(usuario_id: str):
    # Implementar busca no banco de dados
    return []

async def salvar_memoria(usuario_id: str, pergunta: str, resposta: str):
    # Implementar salvamento
    pass

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000)
```

#### **2.3 requirements.txt:**
```
fastapi==0.109.0
uvicorn==0.27.0
ollama==0.1.7
psycopg2-binary==2.9.9
redis==5.0.1
pydantic==2.5.0
python-dotenv==1.0.0
```

---

### **FASE 3: Sistema de Memória (Dia 4-5)**

#### **3.1 Banco de Dados (PostgreSQL):**

**schema.sql:**
```sql
-- Conversas
CREATE TABLE conversas (
    id SERIAL PRIMARY KEY,
    usuario_id VARCHAR(255) NOT NULL,
    mensagem TEXT NOT NULL,
    resposta TEXT NOT NULL,
    modelo VARCHAR(100),
    tokens_prompt INT,
    tokens_resposta INT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    metadata JSONB
);

-- Memórias de longo prazo
CREATE TABLE memorias (
    id SERIAL PRIMARY KEY,
    usuario_id VARCHAR(255) NOT NULL,
    tipo VARCHAR(50), -- 'preferencia', 'fato', 'contexto'
    conteudo TEXT NOT NULL,
    importancia FLOAT DEFAULT 1.0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    embedding VECTOR(384) -- Para busca semântica
);

-- Usuários
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    config JSONB DEFAULT '{}',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Índices
CREATE INDEX idx_conversas_usuario ON conversas(usuario_id);
CREATE INDEX idx_memorias_usuario ON memorias(usuario_id);
CREATE INDEX idx_memorias_tipo ON memorias(tipo);
```

#### **3.2 Módulo de Memória:**

**memory/manager.py:**
```python
import json
from typing import List, Dict, Optional
from datetime import datetime
import psycopg2
from psycopg2.extras import Json

class MemoryManager:
    def __init__(self, db_url: str):
        self.db_url = db_url
    
    def salvar_conversa(self, usuario_id: str, mensagem: str, resposta: str, 
                       modelo: str, metadata: Optional[Dict] = None):
        """Salva uma conversa no histórico"""
        conn = psycopg2.connect(self.db_url)
        cursor = conn.cursor()
        
        cursor.execute("""
            INSERT INTO conversas (usuario_id, mensagem, resposta, modelo, metadata)
            VALUES (%s, %s, %s, %s, %s)
        """, (usuario_id, mensagem, resposta, modelo, Json(metadata) if metadata else None))
        
        conn.commit()
        cursor.close()
        conn.close()
    
    def buscar_memorias_relevantes(self, usuario_id: str, 
                                   query: str, limite: int = 5) -> List[Dict]:
        """Busca memórias relevantes para o contexto"""
        conn = psycopg2.connect(self.db_url)
        cursor = conn.cursor()
        
        # Busca por similaridade (simplificado)
        cursor.execute("""
            SELECT conteudo, tipo, importancia
            FROM memorias
            WHERE usuario_id = %s
            ORDER BY importancia DESC, atualizado_em DESC
            LIMIT %s
        """, (usuario_id, limite))
        
        resultados = cursor.fetchall()
        cursor.close()
        conn.close()
        
        return [
            {'conteudo': r[0], 'tipo': r[1], 'importancia': r[2]}
            for r in resultados
        ]
    
    def salvar_fato(self, usuario_id: str, fato: str, 
                   importancia: float = 1.0):
        """Salva um fato importante sobre o usuário"""
        conn = psycopg2.connect(self.db_url)
        cursor = conn.cursor()
        
        cursor.execute("""
            INSERT INTO memorias (usuario_id, tipo, conteudo, importancia)
            VALUES (%s, 'fato', %s, %s)
            ON CONFLICT (usuario_id, conteudo) 
            DO UPDATE SET importancia = EXCLUDED.importancia,
                         atualizado_em = CURRENT_TIMESTAMP
        """, (usuario_id, fato, importancia))
        
        conn.commit()
        cursor.close()
        conn.close()
```

---

### **FASE 4: Interface Web (Dia 6-7)**

#### **4.1 HTML/CSS/JS Simples:**

**index.html:**
```html
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha IA Core</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .header h1 {
            font-size: 1.5rem;
        }
        
        .chat-container {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .message {
            max-width: 70%;
            padding: 1rem 1.5rem;
            border-radius: 20px;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .message.user {
            align-self: flex-end;
            background: white;
            color: #333;
        }
        
        .message.assistant {
            align-self: flex-start;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            backdrop-filter: blur(10px);
        }
        
        .input-container {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            gap: 1rem;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
        }
        
        .input-container input {
            flex: 1;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }
        
        .input-container input:focus {
            border-color: #667eea;
        }
        
        .input-container button {
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.3s;
        }
        
        .input-container button:hover {
            transform: scale(1.05);
        }
        
        .input-container button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🤖 Minha IA Core</h1>
        <span>Seu assistente pessoal</span>
    </div>
    
    <div class="chat-container" id="chatContainer">
        <div class="message assistant">
            Olá! Sou sua IA pessoal. Como posso ajudar você hoje?
        </div>
    </div>
    
    <div class="input-container">
        <input type="text" id="messageInput" 
               placeholder="Digite sua mensagem..." 
               onkeypress="if(event.key==='Enter') sendMessage()">
        <button id="sendBtn" onclick="sendMessage()">Enviar</button>
    </div>
    
    <script>
        const API_URL = 'http://localhost:8000/chat';
        
        async function sendMessage() {
            const input = document.getElementById('messageInput');
            const btn = document.getElementById('sendBtn');
            const container = document.getElementById('chatContainer');
            
            const message = input.value.trim();
            if (!message) return;
            
            // Adicionar mensagem do usuário
            const userDiv = document.createElement('div');
            userDiv.className = 'message user';
            userDiv.textContent = message;
            container.appendChild(userDiv);
            
            input.value = '';
            btn.disabled = true;
            btn.innerHTML = '<span class="loading"></span>';
            
            // Scroll para o final
            container.scrollTop = container.scrollHeight;
            
            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        texto: message,
                        usuario_id: 'acib'
                    })
                });
                
                const data = await response.json();
                
                // Adicionar resposta da IA
                const assistantDiv = document.createElement('div');
                assistantDiv.className = 'message assistant';
                assistantDiv.textContent = data.texto;
                container.appendChild(assistantDiv);
                
            } catch (error) {
                console.error('Erro:', error);
                const errorDiv = document.createElement('div');
                errorDiv.className = 'message assistant';
                errorDiv.style.background = 'rgba(255, 100, 100, 0.3)';
                errorDiv.textContent = 'Desculpe, ocorreu um erro. Tente novamente.';
                container.appendChild(errorDiv);
            }
            
            btn.disabled = false;
            btn.textContent = 'Enviar';
            container.scrollTop = container.scrollHeight;
        }
    </script>
</body>
</html>
```

---

### **FASE 5: Integrações (Dia 8-10)**

#### **5.1 Bot Telegram:**

**telegram_bot.py:**
```python
import asyncio
from telegram import Update
from telegram.ext import Application, CommandHandler, MessageHandler, filters
import requests

API_CORE_URL = "http://localhost:8000/chat"

async def start(update: Update, context):
    await update.message.reply_text(
        "Olá! Sou sua IA pessoal. Envie uma mensagem e vou te ajudar!"
    )

async def chat(update: Update, context):
    mensagem = update.message.text
    usuario_id = str(update.effective_user.id)
    
    try:
        response = requests.post(API_CORE_URL, json={
            "texto": mensagem,
            "usuario_id": usuario_id
        })
        
        data = response.json()
        await update.message.reply_text(data['texto'])
    except Exception as e:
        await update.message.reply_text(
            "Desculpe, estou com problemas técnicos. Tente novamente mais tarde."
        )

def main():
    # Substituir pelo seu token do BotFather
    application = Application.builder().token("SEU_TOKEN_AQUI").build()
    
    application.add_handler(CommandHandler("start", start))
    application.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, chat))
    
    application.run_polling()

if __name__ == "__main__":
    main()
```

---

## 🐳 DEPLOY COM DOCKER

**docker-compose.yml:**
```yaml
version: '3.8'

services:
  db:
    image: postgres:15
    environment:
      POSTGRES_USER: iauser
      POSTGRES_PASSWORD: iapass
      POSTGRES_DB: iacore
    volumes:
      - postgres_data:/var/lib/postgresql/data
      - ./database/schema.sql:/docker-entrypoint-initdb.d/schema.sql
    ports:
      - "5432:5432"

  redis:
    image: redis:7-alpine
    ports:
      - "6379:6379"

  backend:
    build: ./backend
    ports:
      - "8000:8000"
    environment:
      - DATABASE_URL=postgresql://iauser:iapass@db:5432/iacore
      - REDIS_URL=redis://redis:6379
    depends_on:
      - db
      - redis
    volumes:
      - ./backend:/app
    command: uvicorn app.main:app --host 0.0.0.0 --reload

  frontend:
    build: ./frontend
    ports:
      - "3000:3000"
    volumes:
      - ./frontend:/app

volumes:
  postgres_data:
```

---

## 🚀 PRÓXIMOS PASSOS

### **Semana 1:** Setup e Core
- [ ] Instalar Ollama e baixar modelo
- [ ] Criar estrutura de pastas
- [ ] Implementar API básica
- [ ] Testar comunicação com Ollama

### **Semana 2:** Memória e Interface
- [ ] Configurar PostgreSQL
- [ ] Implementar sistema de memória
- [ ] Criar interface web
- [ ] Testar fluxo completo

### **Semana 3:** Polish e Deploy
- [ ] Adicionar autenticação
- [ ] Criar bot Telegram
- [ ] Documentar API
- [ ] Deploy no seu servidor

---

## 💡 DICAS IMPORTANTES

### **Otimização:**
1. **Use modelos menores** para respostas rápidas (3B-7B parâmetros)
2. **Cache de respostas** frequentes
3. **Rate limiting** para evitar sobrecarga
4. **Monitoramento** de uso de recursos

### **Segurança:**
1. **Nunca exponha** a API diretamente
2. **Use HTTPS** em produção
3. **Autenticação JWT** para usuários
4. **Sanitize inputs** antes de enviar ao modelo

### **Escalabilidade:**
1. **Docker** para fácil deploy
2. **Load balancer** se muitos usuários
3. **Queue** (Redis/RabbitMQ) para processamento
4. **CDN** para assets estáticos

---

## 📚 RECURSOS

- **Ollama Docs:** https://ollama.ai/docs
- **FastAPI:** https://fastapi.tiangolo.com
- **PostgreSQL:** https://www.postgresql.org/docs
- **Docker:** https://docs.docker.com

---

**Quer que eu crie o protótipo da FASE 1 e 2 agora?** 🚀
