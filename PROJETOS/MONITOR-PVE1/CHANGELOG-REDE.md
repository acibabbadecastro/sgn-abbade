# Changelog - Atualização de Monitoramento de Rede

**Data:** 2026-04-30  
**Versão:** 2.0 (Network Monitoring Update)

## 🎯 Objetivo

Adicionar monitoramento de rede em tempo real com gráficos interativos e detecção de atividades suspeitas.

---

## ✅ Implementado

### Backend (app.py)

#### Novos Endpoints
- [x] `/api/network/traffic` - Tráfego detalhado por porta
  - Retorna tráfego atual (upload/download/total em MB/s)
  - Histórico dos últimos 5 minutos (150 amostras × 2s)
  - Picos de tráfego por porta (sessão)
  - Top 20 conexões ativas

- [x] `/api/network/suspicious` - Alertas de segurança
  - Detecção de portas incomuns (>10000)
  - Conexões de IPs externos
  - Múltiplas conexões da mesma origem (>10)
  - Tentativas bloqueadas pelo firewall
  - Histórico de últimos 50 alertas

#### Estruturas de Dados
- [x] `NETWORK_TRAFFIC_HISTORY` - Deque (maxlen=150) para histórico
- [x] `PORT_PEAKS` - Dict para picos históricos
- [x] `SUSPICIOUS_ALERTS` - Deque (maxlen=50) para alertas
- [x] Thread locks para acesso seguro (TRAFFIC_HISTORY_LOCK, PEAKS_LOCK, ALERTS_LOCK)

### Scripts (scripts/network_monitor.py)

#### Novas Funções
- [x] `get_traffic_by_port()`
  - Usa nethogs se disponível (preciso por processo/porta)
  - Fallback para ss (menos preciso)
  - Converte KB/s → MB/s automaticamente
  
- [x] `detect_suspicious_activity()`
  - 4 tipos de detecção implementados
  - Retorna lista de alertas com severidade (high/medium/low)
  - Inclui recomendações de ação
  
- [x] `get_top_connections(limit=20)`
  - Ordena por tráfego (maior primeiro)
  - Marca conexões como "normal" ou "suspeito"
  - Extrai IP, porta, tráfego, processo

### Frontend (index.html)

#### Novos Gráficos
- [x] Gráfico de linhas (Chart.js) - Tráfego por porta
  - Canvas ID: `portTrafficChart`
  - Top 10 portas simultâneas
  - Cores diferentes por porta
  - Legenda interativa (clicar para filtrar)
  - Eixo Y: MB/s, Eixo X: Tempo (últimos 5 min)
  
- [x] Gráfico de barras (Chart.js) - Picos
  - Canvas ID: `portPeaksChart`
  - Top 10 portas por pico total
  - Clique filtra gráfico de linhas
  - Cores gradientes

#### Novos Painéis
- [x] Painel de Movimentações Suspeitas
  - Animação "pulse-red" quando ativo
  - Cards coloridos por severidade
  - Exibe tipo, descrição, detalhes, recomendação
  - Some quando sem alertas
  
- [x] Tabela de Conexões Ativas
  - Top 20 conexões
  - Colunas: IP, Porta, Tráfego, Duração, Status
  - Badge visual (normal/suspeito)
  - Ordenado por tráfego

#### Performance
- [x] Refresh rate diferenciado
  - Rede: 2 segundos (rápido)
  - Hardware/Containers: 5 segundos (padrão)
- [x] Atualização assíncrona (Promise.all)
- [x] Memory-efficient (deque com maxlen)

### Documentação

- [x] `memory/MONITOR-PVE1-REDE-ATUALIZADO.md` - Guia completo
- [x] `README.md` atualizado com novas features
- [x] `CHANGELOG-REDE.md` - Este arquivo

---

## 🔍 Testes Realizados

### Sintaxe Python
```bash
✅ app.py: OK (py_compile)
✅ scripts/network_monitor.py: OK (py_compile)
```

### Funções Network Monitor
```bash
✅ get_traffic_by_port() - Retorna dict de portas
✅ detect_suspicious_activity() - Detecta anomalias
✅ get_top_connections() - Lista conexões ativas
```

### Correções Aplicadas
- [x] Localhost (127.0.0.1) agora é considerado privado
- [x] Fallback automático se nethogs não instalado
- [x] Tratamento de erro em todas as funções

---

## 📊 Comparação Antes/Depois

| Feature | Antes | Depois |
|---------|-------|--------|
| **Refresh Rate** | 5s (geral) | 2s (rede) + 5s (resto) |
| **Tráfego por Porta** | ❌ Não tinha | ✅ Top 10 portas em tempo real |
| **Histórico** | ❌ Não tinha | ✅ 5 minutos (150 pontos) |
| **Picos** | ❌ Não tinha | ✅ Por porta (sessão) |
| **Alertas Susp.** | ❌ Não tinha | ✅ 4 tipos de detecção |
| **Tabela Conexões** | ❌ Não tinha | ✅ Top 20 ordenadas |
| **Gráficos** | 2 (hardware/rede) | 4 (+ tráfego/picos) |
| **Endpoints API** | 6 | 8 (+ traffic/suspicious) |

---

## 🚀 Como Usar

### Acessar Dashboard
```
http://192.168.0.192:5000
```

### Testar API
```bash
# Tráfego por porta
curl http://192.168.0.192:5000/api/network/traffic | jq

# Alertas
curl http://192.168.0.192:5000/api/network/suspicious | jq
```

### Instalar Dependência Opcional
```bash
# Para medição precisa por porta
apt install nethogs
```

---

## ⚠️ Limitações Conhecidas

1. **Nethogs não instalado**: Usa fallback `ss` (menos preciso)
2. **Duração da conexão**: Placeholder (não disponível via ss)
3. **Tráfego >3x média**: Detecção planejada (não implementada)
4. **Memória**: Histórico limitado a 5 minutos (intencional)

---

## 📝 Próximas Melhorias (Backlog)

- [ ] Alerta sonoro para severidade alta
- [ ] Exportar histórico em CSV
- [ ] Filtro por faixa de IP
- [ ] Mapa de calor (porta × hora)
- [ ] Detecção de tráfego >3x média
- [ ] Duração real da conexão (proc/net/tcp)
- [ ] WebSocket para push em tempo real

---

## 🛠️ Arquivos Modificados

| Arquivo | Mudanças | Linhas |
|---------|----------|--------|
| `app.py` | +2 endpoints, +variáveis globais | +150 |
| `scripts/network_monitor.py` | +3 funções principais | +200 |
| `index.html` | +2 gráficos, +2 painéis | +400 |
| `README.md` | Atualizado com features | +50 |

**Total:** ~800 linhas adicionadas

---

## ✅ Checklist de Entrega

- [x] Backend implementado (app.py)
- [x] Scripts atualizados (network_monitor.py)
- [x] Frontend completo (index.html)
- [x] Documentação criada
- [x] README atualizado
- [x] Código validado (py_compile)
- [x] Funções testadas manualmente
- [x] Bugs corrigidos (localhost detection)
- [x] Resumo salvo em memory/

---

**Status:** ✅ CONCLUÍDO  
**Próximo Passo:** Reiniciar serviço e validar no navegador

```bash
systemctl restart monitor-pve1
# Acessar: http://192.168.0.192:5000
```
