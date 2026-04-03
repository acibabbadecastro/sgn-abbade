# DATASVR (CT 102) - Servidor de Dados Central

## Identificação
| Campo | Valor |
|-------|-------|
| **Nome** | DATASVR |
| **Container ID** | 102 |
| **IP** | 192.168.0.72 |
| **OS** | Ubuntu 25.04 |

## Credenciais de Acesso
| Serviço | Usuário | Senha |
|---------|---------|-------|
| SSH | root | Rcmp@814k$1982 |
| Samba (Windows) | starkdata | Stark@2026 |

## Estrutura de Pastas (/mnt/data)
```
/mnt/data/
├── backups/        → Backups de todos os bots
├── logs/           → Logs de todos os bots
├── relatorios/     → Relatórios do Supervisor
├── supervisor/     → Logs/backups específicos do Supervisor
├── emails/        → Dados do EmailBot
├── financeiros/    → Dados do FinanceiroBot
├── contratos/      → Documentos legais
├── faturas/        → Faturas e Recibos
├── agenda/         → Lembretes e agendamentos
└── documentos/     → Documentos gerais
```

## Acesso pelo Windows 11
1. Abra o **Explorador de Arquivos**
2. Digite: `\\192.168.0.72\data`
3. Login: `starkdata`
4. Senha: `Stark@2026`

## Compartilhamento Samba
| Config | Valor |
|--------|-------|
| **Share Name** | data |
| **Path** | /mnt/data |
| **Browseable** | Yes |
| **Read Only** | No |
| **Valid Users** | starkdata |

## Status
✅ Configurado e operacional (457GB disponível)
