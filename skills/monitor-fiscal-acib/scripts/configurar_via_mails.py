#!/usr/bin/env python3
"""
Configuração do Monitor Fiscal para usar MAILS (CT 105)
Como não temos acesso direto ao CT 105, vamos configurar
o Stark para executar e comunicar com MAILS via API.
"""

import json
import os

CONFIG = {
    "versao": "1.0",
    "data_configuracao": "2026-04-16",
    
    # Integração com MAILS
    "mails": {
        "ct": 105,
        "ip": "192.168.0.224",
        "gateway_port": 18789,
        "funcao": "processamento_emails",
        "integracao": "via_gateway_openclaw"
    },
    
    # Configuração Stark (este container)
    "stark": {
        "ct": 100,
        "ip": "192.168.0.21",
        "executar_monitor": True,
        "frequencia": "3x ao dia (9h, 15h, 21h)"
    },
    
    # Fluxo de trabalho
    "workflow": {
        "1_mails": "CT 105 busca emails Nubank e salva em /tmp/emails/",
        "2_stark": "CT 100 executa monitor_fiscal e processa dados",
        "3_datadir": "Relatórios salvos em DATASVR (192.168.0.72)",
        "4_alerta": "Notificações via Telegram se limite > 85%"
    },
    
    # Contas monitoradas
    "contas": {
        "PJ65": {"banco": "Nubank", "tipo": "MEI", "limite": 81000.00},
        "PJ20": {"banco": "Nubank", "tipo": "MEI", "limite": 81000.00},
        "PF": {"banco": "Nubank", "tipo": "PF", "limite": 28559.70},
        "ESPOSA": {"tipo": "RESERVA", "uso": "quando MEI esgotado"}
    }
}

# Salvar configuração
config_dir = "/root/.openclaw/config"
os.makedirs(config_dir, exist_ok=True)

config_file = os.path.join(config_dir, "monitor_fiscal_mails_integration.json")
with open(config_file, 'w') as f:
    json.dump(CONFIG, f, indent=2)

print("=" * 60)
print("CONFIGURAÇÃO INTEGRADA MAILS + MONITOR FISCAL")
print("=" * 60)
print()
print(f"✅ Configuração salva em: {config_file}")
print()
print("FLUXO DE TRABALHO:")
print("-" * 60)
for passo, descricao in CONFIG['workflow'].items():
    print(f"  {passo}: {descricao}")
print()
print("CONTAS MONITORADAS:")
print("-" * 60)
for conta, info in CONFIG['contas'].items():
    print(f"  {conta}: {info['banco']} - {info['tipo']}")
print()
print("Para ativar:")
print("  1. Certifique-se que MAILS (CT 105) está rodando")
print("  2. Execute: python3 administrar_emails_financeiros.py")
print("  3. Ou aguarde execução automática (cron)")
print("=" * 60)
