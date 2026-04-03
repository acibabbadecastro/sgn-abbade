# Preferências do Sistema - Stark

---

## 🔌 INICIALIZAÇÃO AUTOMÁTICA

### Boot Automático (Hardware)
- **BIOS/UEFI:** Configurado para Ligar Automático em caso de queda de energia
- **Resultado:** Quando a energia retorna, o PC liga sozinho

### Agente Stark (OpenClaw) - Iniciar Automaticamente
- **Objetivo:** O agente deve iniciar automaticamente após o login do Ubuntu
- **Comando:** `openclaw gateway start`
- **Local do serviço:** `/home/master/.config/openclaw/autostart/`

---

## 📄 Como Ativar o Startup Automático

### Opção 1: systemd (Recomendado)
Criar arquivo `/home/master/.config/systemd/user/openclaw.service`:

```ini
[Unit]
Description=OpenClaw - Agente Stark
After=network-online.target

[Service]
Type=simple
ExecStart=/home/master/.nvm/versions/node/v24.14.0/bin/openclaw gateway start
Restart=on-failure
RestartSec=10

[Install]
WantedBy=default.target
```

### Opção 2: Script de Login
Adicionar ao arquivo `~/.bashrc` ou criar `~/.config/autostart/openclaw.desktop`:
```desktop
[Desktop Entry]
Type=Application
Name=OpenClaw
Exec=/home/master/.nvm/versions/node/v24.14.0/bin/openclaw gateway start
```

---

## 📂 Scripts de Backup (Pen Drive)

**Local:** `/media/master/Ventoy/Stark_Backup/Scripts/`

| Script | Função |
|--------|--------|
| `ATIVAR-LOGIN-AUTOMATICO.sh` | Remove senha do login |
| `BACKUP-AUTOMATICO.sh` | Faz backup para o pen drive |
| `RESTAURAR-BACKUP.sh` | Lista e restaura backups |

---

## 🔧 Configurações Atuais

| Item | Status |
|------|--------|
| Login automático | ⚠️ Pendente (precisa executar comando manual) |
| Ollama | ✅ Rodando na porta 11434 |
| OpenClaw Gateway | ✅ Rodando na porta 18789 |
| Telegram Bot | ✅ Ativado |

---

## 🖥️ Hardware

| Componente | Especificação |
|------------|---------------|
| CPU | AMD Ryzen 5 5600X |
| RAM | 30 GB |
| GPU | AMD Radeon RX 580 8GB |
| SSD | 223 GB |
| Pen Drive | 57 GB (Ventoy) |

---

## 🤖 Modelos Locais (Ollama)

- **Padrão:** phi4-mini:latest
- **Disponíveis:** qwen2.5:3b, qwen2.5:7b, qwen3.5:0.8b, qwen3.5:latest, llama3:8b, mistral