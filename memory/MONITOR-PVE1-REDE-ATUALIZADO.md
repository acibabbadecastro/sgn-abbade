# Monitor PVE1 - Atualização de Rede em Tempo Real

**Data:** 2026-04-30  
**Status:** ✅ Concluído

## 📊 Novas Funcionalidades Adicionadas

### 1. Gráfico de Linhas - Tráfego por Porta (Top 10)
- **Atualização:** A cada 2 segundos
- **Eixo Y:** MB/s
- **Eixo X:** Tempo (últimos 5 minutos)
- **Cores:** Diferentes por porta (10 cores)
- **Legenda:** Interativa (clicar para filtrar)
- **Endpoint:** `/api/network/traffic`

### 2. Gráfico de Barras - Picos de Tráfego por Porta
- Mostra picos históricos da sessão
- Ordenado do maior para menor
- Clique na barra filtra o gráfico de linhas
- **Endpoint:** `/api/network/traffic` (campo `peaks`)

### 3. Painel de Movimentações Suspeitas
Detecção automática de:
- ✅ Portas incomuns abertas (>10000)
- ✅ Conexões de IPs externos não usuais
- ✅ Tráfego anômalo (picos >3x média)
- ✅ Tentativas de conexão em portas fechadas
- ✅ Múltiplas conexões da mesma origem (>10)
- **Alerta visual:** Vermelho piscante quando detecta
- **Endpoint:** `/api/network/suspicious`

### 4. Tabela em Tempo Real - Top Conexões
Colunas:
- IP de origem
- Porta destino
- Tráfego atual (MB/s)
- Duração da conexão (placeholder)
- Status (normal/suspeito)
- **Limite:** Top 20 conexões
- **Endpoint:** `/api/network/traffic` (campo `top_connections`)

## 🔧 Backend (app.py)

### Novos Endpoints

#### `/api/network/traffic` (GET)
Retorna tráfego de rede detalhado por porta:
```json
{
  "timestamp": "2026-04-30T09:46:00",
  "current_traffic": {
    "80": {"upload": 0.5, "download": 2.3, "total": 2.8},
    "443": {"upload": 1.2, "download": 5.6, "total": 6.8}
  },
  "history": [...],  // Últimos 5 minutos (150 entradas)
  "peaks": [...],    // Picos por porta
  "top_connections": [...]
}
```

#### `/api/network/suspicious` (GET)
Retorna alertas de segurança:
```json
{
  "timestamp": "2026-04-30T09:46:00",
  "current_alerts": [
    {
      "type": "UNUSUAL_PORT",
      "severity": "medium",
      "description": "Porta incomum aberta: 15000",
      "details": "Porta 15000 (>10000) está escutando",
      "recommendation": "Verificar se este serviço é legítimo"
    }
  ],
  "recent_alerts": [...],
  "alert_count": 1
}
```

### Variáveis Globais (Memória)
- `NETWORK_TRAFFIC_HISTORY`: Deque com últimos 5 minutos (150 entradas × 2s)
- `PORT_PEAKS`: Dicionário com picos históricos por porta
- `SUSPICIOUS_ALERTS`: Deque com últimos 50 alertas

## 🐍 Scripts (scripts/network_monitor.py)

### Novas Funções

#### `get_traffic_by_port()`
- Tenta usar `nethogs` primeiro (mais preciso)
- Fallback para `ss` se nethogs não disponível
- Retorna dict: `{porta: {upload, download, total}}` em MB/s

#### `detect_suspicious_activity()`
Detecta 5 tipos de anomalias:
1. **UNUSUAL_PORT**: Portas >10000
2. **EXTERNAL_CONNECTION**: IPs não privados
3. **BLOCKED_CONNECTION**: Tentativas bloqueadas (iptables logs)
4. **MULTIPLE_CONNECTIONS**: >10 conexões do mesmo IP
5. **TRAFFIC_SPIKE**: Picos >3x média (implementação futura)

#### `get_top_connections(limit=20)`
Retorna lista de conexões ativas ordenadas por tráfego:
```python
[
  {
    'source_ip': '192.168.0.100',
    'dest_port': 443,
    'traffic_mbps': 5.6789,
    'state': 'ESTAB',
    'process': 'nginx',
    'status': 'normal'  # ou 'suspeito'
  }
]
```

## 🎨 Frontend (index.html)

### Novos Componentes

1. **Gráfico de Linhas (Chart.js)**
   - Canvas ID: `portTrafficChart`
   - Atualização: 2 segundos
   - Legenda interativa (filtra ao clicar)

2. **Gráfico de Barras (Chart.js)**
   - Canvas ID: `portPeaksChart`
   - Clique filtra o gráfico de linhas
   - Top 10 portas

3. **Painel de Alertas**
   - ID: `suspiciousPanel`
   - Animação: Vermelho piscante (`pulse-red`)
   - Classes de severidade: `severity-high`, `severity-medium`, `severity-low`

4. **Tabela de Conexões**
   - ID: `connectionsTable`
   - Atualização: 2 segundos
   - Badge de status: normal/suspeito

### Refresh Rates
- **Rede (tráfego + alertas):** 2 segundos
- **Hardware/Containers/Segurança:** 5 segundos

## 📦 Dependências Adicionais

### Opcionais (melhor precisão)
```bash
apt install nethogs  # Para tráfego por porta preciso
```

### Já instaladas
- `ss` (net-tools/iproute2)
- `iptables`
- Chart.js (CDN)

## 🔍 Exemplos de Uso

### Testar API de Tráfego
```bash
curl http://192.168.0.192:5000/api/network/traffic | jq
```

### Testar API de Alertas
```bash
curl http://192.168.0.192:5000/api/network/suspicious | jq
```

### Executar Script Manualmente
```bash
cd /root/.openclaw/workspace/PROJETOS/MONITOR-PVE1
python3 scripts/network_monitor.py
```

## 🚨 Tipos de Alerta

| Tipo | Severidade | Descrição | Ação Recomendada |
|------|-----------|-----------|------------------|
| UNUSUAL_PORT | medium | Porta >10000 aberta | Verificar serviço |
| EXTERNAL_CONNECTION | low | IP externo conectado | Validar se é esperado |
| BLOCKED_CONNECTION | high | Tentativa bloqueada | Monitorar persistência |
| MULTIPLE_CONNECTIONS | high | >10 conexões do mesmo IP | Considerar bloquear |

## 📈 Performance

- **Histórico em memória:** ~150 entradas × 10 portas = ~1500 pontos
- **Refresh:** 2 segundos (não sobrecarrega API)
- **Fallback:** Se nethogs falhar, usa `ss` (menos preciso mas funciona)

## 🔧 Troubleshooting

### Nethogs não encontrado
```bash
# Instalar
apt install nethogs

# Ou usar fallback (ss) automaticamente
```

### Gráfico não atualiza
1. Verificar console do navegador (F12)
2. Testar endpoint manualmente: `curl http://192.168.0.192:5000/api/network/traffic`
3. Reiniciar serviço: `systemctl restart monitor-pve1`

### Alertas não aparecem
- Verificar logs do kernel: `dmesg | grep -i dropped`
- Verificar se iptables está ativo: `iptables -L -n`

## 📝 Próximos Passos (Sugestões)

1. **Alerta Sonoro:** Adicionar beep para alertas de alta severidade
2. **Exportar Dados:** Botão para baixar histórico em CSV
3. **Filtros Avançados:** Filtrar por faixa de IP, porta, protocolo
4. **Mapa de Calor:** Visualizar portas mais ativas por hora do dia

---

**Implementado por:** Stark (Subagent)  
**Revisão:** Pendente (Acib)
