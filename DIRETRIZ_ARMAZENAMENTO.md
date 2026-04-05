# DIRETRIZ DE ARMAZENAMENTO - STARK

## REGRA FUNDAMENTAL

**TODO arquivo produzido pelo Stark ou qualquer agente deve ser salvo em:**

```
\\192.168.0.72\LAN\Stark_Output\
```

## ESTRUTURA DE PASTAS

```
LAN/
├── Stark_Output/              # RAIZ - TODO OUTPUT VAI AQUI
│   ├── Agentes/               # Outputs específicos por agente
│   │   ├── Stark/
│   │   ├── MailBot/
│   │   ├── Supervisor/
│   │   ├── SAMU/
│   │   └── ...
│   ├── Logs/                  # Logs de execução
│   ├── Configs/               # Configurações geradas
│   ├── Documentos/            # Documentos criados
│   └── Backups/               # Backups automáticos
│
├── Configs_Agentes/           # Configurações da infraestrutura
│
└── pve1/                      # Backups do host
```

## REGRAS

1. **TODO** = TODO, sem exceção
2. Estrutura hierárquica por agente/tipo
3. Nomes descritivos com data quando aplicável
4. Manter organizado = facilitar recuperação

## ACESSO

| Método | Caminho |
|--------|---------|
| Windows | \\192.168.0.72\LAN\Stark_Output\ |
| SSH | master@192.168.0.72:/home/master/LAN/Stark_Output/ |

## EXEMPLOS DE USO

| Tipo de Arquivo | Salvar em |
|-----------------|-----------|
| Relatório do Stark | Stark_Output/Stark/Relatorios/2026-04-03_relatorio.md |
| Log do SAMU | Stark_Output/Logs/SAMU/2026-04-03.log |
| Config gerada | Stark_Output/Configs/nome_config.json |
| Backup | Stark_Output/Backups/2026-04-03_backup.tar |

---

## ÚLTIMA ATUALIZAÇÃO
- Data: 2026-04-03 21:27
- Motivo: Acib solicitou que TODO output vá para HD 500GB
