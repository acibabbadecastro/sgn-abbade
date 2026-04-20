# 📱 API Local de SMS - Acib ABBADE

**Use seu plano de operadora para enviar SMS via Android Gateway**

---

## 🎯 O Que É

API local que transforma seu Android em um gateway de SMS, usando seu plano da operadora (TIM, Vivo, Claro, etc.) sem custos adicionais de APIs de terceiros.

---

## 📦 Instalação

### 1. Instalar dependências no CT 106 (Dr_Finance):

```bash
pct exec 106 -- pip3 install flask requests
```

### 2. Instalar app no Android:

**Opção A (Recomendada):** capcom6/android-sms-gateway
- Download: https://github.com/capcom6/android-sms-gateway/releases
- ✅ Criptografia end-to-end
- ✅ Webhooks
- ✅ Multi-chip

**Opção B:** SMS Gateway API (itsmeichigo)
- Download: https://github.com/itsmeichigo/SMSGateway/releases

### 3. Configurar app no Android:

1. Abrir app
2. Ir em **Settings** → **Server**
3. Ativar **HTTP API**
4. Definir porta (padrão: 8080)
5. Copiar **API Token**
6. Anotar **IP do celular** na rede Wi-Fi

---

## 🚀 Como Usar

### **Opção 1: API HTTP (Recomendado)**

```bash
# Iniciar API local
python3 /root/.openclaw/workspace/skills/android-sms-gateway/api-local.py

# Em outro terminal, enviar SMS:
curl -X POST http://localhost:5000/send \
  -H "Content-Type: application/json" \
  -d '{"to": "+5511999999999", "message": "Olá do OpenClaw!"}'
```

### **Opção 2: Script Shell**

```bash
# Usar script pronto
./enviar-sms.sh "+5511999999999" "Olá do OpenClaw!"
```

### **Opção 3: Integração com Dr_Finance**

No seu código Python do Dr_Finance:

```python
import requests

def enviar_alerta_sms(telefone, mensagem):
    """Envia alerta de gastos via SMS"""
    response = requests.post(
        'http://localhost:5000/send',
        json={
            'to': telefone,
            'message': f'🚨 Alerta Dr_Finance: {mensagem}'
        }
    )
    return response.json()

# Exemplo de uso
enviar_alerta_sms('+5511999999999', 'Gastos com combustível acima da média!')
```

---

## 📊 Endpoints da API

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `POST` | `/send` | Enviar SMS |
| `GET` | `/status` | Status do gateway |
| `GET` | `/messages` | Mensagens recebidas |
| `GET` | `/logs` | Histórico de envios |

---

## 🔧 Configuração

### Variáveis de Ambiente:

```bash
export SMS_GATEWAY_URL="http://192.168.0.100:8080"
export SMS_GATEWAY_TOKEN="seu-token-aqui"
export SMS_API_URL="http://localhost:5000"
```

### Ou editar `api-local.py`:

```python
SMS_GATEWAY_URL = 'http://192.168.0.100:8080'  # IP do seu Android
SMS_GATEWAY_TOKEN = 'seu-token-aqui'
```

---

## 📝 Exemplos de Uso

### Enviar SMS simples:

```bash
curl -X POST http://localhost:5000/send \
  -H "Content-Type: application/json" \
  -d '{"to": "+5511999999999", "message": "Teste"}'
```

### Enviar para múltiplos números:

```bash
for numero in "+5511999999999" "+5511888888888" "+5511777777777"; do
    curl -X POST http://localhost:5000/send \
      -H "Content-Type: application/json" \
      -d "{\"to\": \"$numero\", \"message\": \"Alerta Dr_Finance\"}"
done
```

### Verificar status:

```bash
curl http://localhost:5000/status
```

### Listar mensagens recebidas:

```bash
curl "http://localhost:5000/messages?limit=10"
```

### Ver histórico de envios:

```bash
curl "http://localhost:5000/logs?limit=50"
```

---

## 🔒 Segurança

- ✅ API roda apenas localmente (localhost:5000)
- ✅ Token de autenticação para o Android
- ✅ Logs criptografados (opcional)
- ✅ Sem dados na nuvem

---

## 💡 Casos de Uso com Dr_Finance

### 1. Alerta de Gastos Excessivos:

```python
if gasto_combustivel > limite_mensal * 0.8:
    enviar_alerta_sms(
        '+5511999999999',
        f'⚠️ Alerta: R$ {gasto_combustivel:.2f} em combustível (80% do limite)'
    )
```

### 2. Notificação de Relatório Diário:

```python
enviar_alerta_sms(
    '+5511999999999',
    '📊 Relatório financeiro das 19h disponível. Verifique Telegram.'
)
```

### 3. Alerta de Anomalia:

```python
if transacao.valor > media_categoria * 3:
    enviar_alerta_sms(
        '+5511999999999',
        f'🚨 Transação incomum: R$ {transacao.valor:.2f} em {transacao.categoria}'
    )
```

---

## 🐛 Troubleshooting

### "Não foi possível conectar ao Android Gateway"

1. Verifique se app está rodando no celular
2. Confirme IP do celular: `adb shell ip addr show wlan0`
3. Teste conectividade: `curl http://IP_DO_CELULAR:8080/api/v1/status`

### "Token inválido"

1. Abra app no Android
2. Vá em Settings → Security
3. Copie token atual
4. Atualize em `api-local.py`

### "SMS não envia"

1. Verifique se celular tem sinal
2. Confirme se há saldo/plano ativo
3. Verifique permissões do app (SMS, Telefone)

---

## 📞 Suporte

**Autor:** Acib ABBADE  
**Projeto:** Dr_Finance - Bootcamp DIO  
**GitHub:** https://github.com/acibabbadecastro/dr-finance

---

## 🎓 Licença

MIT License - Uso livre para projetos pessoais e educacionais.
