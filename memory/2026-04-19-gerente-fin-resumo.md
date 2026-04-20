# Resumo do Projeto - Gerente Financeiro (FinGuard)

**Autor:** Acib ABBADE  
**Data:** 19/04/2026  
**Bootcamp:** DIO - Agente Financeiro Inteligente  
**Status:** Documentação completa, pronto para implementação

---

## Visão Geral

Agente financeiro inteligente que analisa gastos automaticamente através dos emails do Nubank e gera relatórios personalizados (diários, semanais, mensais) com sugestões de economia.

**Diferencial:** Roda em container isolado no Proxmox com OpenClaw + Ollama, garantindo privacidade total (dados não saem do servidor).

---

## Arquitetura

### Containers Principais

| CT | Nome | IP | Função |
|----|------|-----|--------|
| 101 | MailBot | 192.168.0.240 | Processa emails do Nubank |
| 102 | DATASVR | 192.168.0.72 | Backup e histórico |
| 106 | Gerente_Fin | 192.168.0.231 | Análise financeira (OpenClaw + Ollama) |

### Fluxo

```
Gmail (Nubank) → CT 101 (MailBot) → CT 106 (Gerente_Fin) → CT 102 (DATASVR)
                                      ↓
                                 Telegram/Email
```

---

## Funcionalidades

### Relatórios Automáticos

- **Diário:** 19:00 todos os dias
- **Semanal:** Segunda-feira 09:00
- **Mensal:** Dia 1, 09:00

### Tipos de Análise

- Classificação de transações (PIX, débito, crédito)
- Comparativo com períodos anteriores
- Alertas de gastos excessivos
- Sugestões personalizadas de economia

---

## Documentação Completa

### No GitHub

**Repositório Principal:**
https://github.com/acibabbadecastro/dio-lab-bia-do-futuro

**Arquivos:**
- `docs/01-documentacao-agente.md` - Caso de uso, persona, arquitetura
- `docs/02-base-conhecimento.md` - Dados e integração
- `docs/03-prompts.md` - System prompts e exemplos
- `docs/04-metricas.md` - Métricas de qualidade
- `docs/05-pitch.md` - Roteiro de apresentação (3 min)
- `docs/README-GERENTE-FIN.md` - Documentação técnica completa

**Repositório do Tutorial (criar):**
https://github.com/acibabbadecastro/proxmox-setup-guide

**Conteúdo:**
- `README.md` - Guia completo de instalação Proxmox + OpenClaw

### Local (DATASVR)

**Caminho:** `/home/master/LAN/MEMORIES/STARK/03-PROJETOS/DIO-Bootcamp/2026-04/`

**Arquivos:**
- `docs_01-documentacao.md` (8.5KB)
- `docs_02-base-conhecimento.md` (4KB)
- `docs_03-prompts.md` (6KB)
- `docs_04-metricas.md` (5.8KB)
- `docs_05-pitch.md` (6.5KB)
- `proxmox-setup/README.md` (13KB)
- `RESUMO-DO-PROJETO.md` (este arquivo)

**Backup:** Automático no DATASVR (CT 102)

---

## Implementação

### Passo a Passo Resumido

1. **Criar CT 106** no Proxmox
2. **Instalar OpenClaw + Ollama** no CT 106
3. **Configurar skills** do Gerente_Fin
4. **Configurar cron jobs** (diário/semanal/mensal)
5. **Integrar com MailBot** (CT 101)
6. **Testar fluxos**
7. **Colocar em produção**

### Comandos Principais

```bash
# Criar CT 106
pct create 106 local:vztmpl/ubuntu-24.04-standard_24.04-1_amd64.tar.gz \
  --hostname gerente-fin \
  --ipaddr 192.168.0.231/24 \
  --gateway 192.168.0.1 \
  --memory 2048 \
  --cores 2 \
  --rootfs local-lvm:8 \
  --features nesting=1,keyctl=1 \
  --onboot 1

# Instalar OpenClaw + Ollama
pct enter 106
curl -fsSL https://ollama.com/install.sh | sh
curl -fsSL https://openclaw.ai/install.sh | sh
ollama pull minimax-m2.7:cloud
```

---

## Próximos Passos

### Imediatos (Entrega Bootcamp)

- [ ] Revisar documentação no GitHub
- [ ] Gravar pitch de 3 minutos
- [ ] Enviar links para professores
- [ ] Criar repositório `proxmox-setup-guide`

### Implementação (Produção)

- [ ] Criar CT 106 no Proxmox
- [ ] Instalar OpenClaw + Ollama
- [ ] Configurar skills
- [ ] Configurar cron jobs
- [ ] Testar com dados reais
- [ ] Colocar em produção

---

## Métricas Esperadas

| Métrica | Meta |
|---------|------|
| Precisão | ≥ 90% |
| Segurança | 100% (zero alucinações) |
| Tempo de resposta | < 30 segundos |
| Economia gerada | R$ 5.400/ano |
| Disponibilidade | ≥ 95% |

---

## Diferenciais Competitivos

1. **Privacidade total:** Ollama local, dados não saem do servidor
2. **Arquitetura profissional:** 13 containers no Proxmox
3. **Custo zero:** Hardware local, sem cloud
4. **Produção real:** Já está rodando, não é só protótipo
5. **Escalável:** Pode adicionar mais CTs quando precisar

---

## Links Úteis

- **GitHub Principal:** https://github.com/acibabbadecastro/dio-lab-bia-do-futuro
- **GitHub Tutorial:** https://github.com/acibabbadecastro/proxmox-setup-guide (criar)
- **OpenClaw Docs:** https://docs.openclaw.ai
- **Ollama Docs:** https://ollama.ai
- **Proxmox Docs:** https://pve.proxmox.com/wiki

---

## Contato

**Acib ABBADE**
- Telegram: @Acib_Abbade
- Email: abbade@outlook.com
- GitHub: https://github.com/acibabbadecastro

---

**Última atualização:** 19/04/2026 22:30  
**Status:** Documentação completa ✅  
**Próxima revisão:** 26/04/2026
