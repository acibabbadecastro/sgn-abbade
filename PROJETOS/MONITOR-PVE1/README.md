# Monitor PVE1 - Dashboard de Monitoramento

Dashboard em tempo real para monitoramento do servidor Proxmox PVE1.

## 📊 Funcionalidades

- **Hardware**: CPU, RAM, Disco, Temperatura, GPU
- **Containers**: Status dos CTs 100-112
- **Rede**: Portas abertas, conexões, tráfego, speedtest
  - **🆕 Gráfico de linhas**: Tráfego por porta (top 10) em tempo real
  - **🆕 Gráfico de barras**: Picos de tráfego por porta
  - **🆕 Tabela**: Top 20 conexões ativas
- **Segurança**: Falhas SSH, IPs bloqueados, firewall, alertas
  - **🆕 Detecção de atividades suspeitas**: Portas incomuns, IPs externos, múltiplas conexões

## 🚀 Instalação

### 1. Instalar dependências

```bash
apt update
apt install python3-flask speedtest-cli lm-sensors
```

### 2. Configurar como serviço systemd

```bash
cd /root/.openclaw/workspace/PROJETOS/MONITOR-PVE1

# Copiar serviço
cp monitor-pve1.service /etc/systemd/system/

# Recarregar systemd
systemctl daemon-reload

# Habilitar e iniciar
systemctl enable monitor-pve1
systemctl start monitor-pve1

# Verificar status
systemctl status monitor-pve1
```

### 3. Acessar o dashboard

Abra no navegador:
```
http://192.168.0.192:5000
```

## 📁 Estrutura

```
MONITOR-PVE1/
├── app.py                      # Backend Flask
├── index.html                  # Frontend dashboard
├── monitor-pve1.service        # Systemd service
├── scripts/
│   ├── hardware_stats.py       # Coleta hardware
│   ├── container_status.py     # Status containers
│   ├── network_monitor.py      # Rede/tráfego + detecção suspeita
│   ├── security_check.py       # Segurança
│   └── speedtest_cli.py        # Speedtest
└── README.md
```

## 🔧 Scripts de Coleta

Cada script pode ser executado independentemente:

```bash
# Hardware
python3 scripts/hardware_stats.py

# Containers
python3 scripts/container_status.py

# Rede
python3 scripts/network_monitor.py

# Segurança
python3 scripts/security_check.py

# Speedtest
python3 scripts/speedtest_cli.py
```

## 📡 API Endpoints

| Endpoint | Descrição |
|----------|-----------|
| `/api/hardware` | Estatísticas de hardware |
| `/api/containers` | Status dos containers |
| `/api/network` | Informações de rede |
| `/api/network/traffic` | **🆕** Tráfego por porta + histórico + picos |
| `/api/network/suspicious` | **🆕** Alertas de segurança de rede |
| `/api/security` | Status de segurança |
| `/api/speedtest` (POST) | Executar speedtest |
| `/api/history/hardware` | Histórico de hardware |

## 🔄 Auto-Refresh

O dashboard atualiza automaticamente:
- **Rede (tráfego + alertas):** A cada **2 segundos**
- **Hardware/Containers/Segurança:** A cada **5 segundos**

## 🛠️ Troubleshooting

### Verificar logs do serviço

```bash
journalctl -u monitor-pve1 -f
```

### Reiniciar serviço

```bash
systemctl restart monitor-pve1
```

### Parar serviço

```bash
systemctl stop monitor-pve1
```

### Desabilitar serviço

```bash
systemctl disable monitor-pve1
```

### Testar novos endpoints de rede

```bash
# Tráfego por porta
curl http://192.168.0.192:5000/api/network/traffic | jq

# Alertas de segurança
curl http://192.168.0.192:5000/api/network/suspicious | jq
```

### Instalar nethogs (opcional, melhora precisão)

```bash
apt install nethogs
```

Sem nethogs, o sistema usa `ss` como fallback (menos preciso).

## 📝 Notas

- Requer acesso root para comandos `pct` (containers Proxmox)
- Speedtest requer `speedtest-cli` instalado
- Temperatura requer `lm-sensors` configurado
- Firewall detection suporta iptables, nftables, ufw
- **Nethogs (opcional):** Melhora precisão do tráfego por porta
- **Chart.js:** Carregado via CDN (requer internet na primeira carga)

---

**Desenvolvido para PVE1 (192.168.0.192)**
