---
name: Acib ABBADE
description: Perfil completo do usuário - preferências, dados pessoais e contexto
role: Owner
identity: 1866226415
created: 2026-04-19
updated: 2026-04-19 (configurações vitais adicionadas)
type: user
---

## Informações Pessoais

**Nome:** Acib ABBADE
**Nome Completo:** Acib ABBADE DE CASTRO
**Telegram:** @Acib_Abbade (ID: 1866226415)
**Email Principal:** acibabbadecastro@gmail.com
**Email Secundário:** infoacib@gmail.com
**Email Outlook:** acib@outlook.com
**CPF:** 307.572.858-64
**Timezone:** Horário Brasília (UTC-3)

## Contexto Profissional

**Área:** Tecnologia da Informação / Automação
**Empresa:** ABBADE Informática (MEI)
**CNPJ:** 65.384.056/0001-32
**CNPJ Secundário:** 20.153.208/0001-58
**Hardware:** AMD Ryzen 5 5600X, 30GB RAM, RX 580 8GB, SSD 223GB

**Infraestrutura:**
- Proxmox PVE1 (192.168.0.192)
- Container CT 100 (Stark - Orquestrador) - IP: 192.168.0.21
- Outros containers: 101-107 (especializados)

**Cliente Principal:** Saulo/SERVMIL (Anderson)

## Contas Bancárias - Nubank

### CONTA PJ-65 (Principal)
- CNPJ: 65.384.056/0001-32
- Razão Social: ABBADE Informatica
- Conta: 986080174-7
- Agência: 0001
- Banco: Nubank (260)
- Tipo: Conta Corrente Empresarial

### CONTA PJ-20 (Secundária)
- CNPJ: 20.153.208/0001-58
- Conta: 118844303
- Banco: Nubank (260)

### CONTA PF
- CPF: 307.572.858-64
- Titular: ACIB ABBADE DE CASTRO
- Conta: 169842561
- Banco: Nubank (260)

## Limites Fiscais (2026)

**MEI Anual:** R$ 81.000,00
**IRPF Isenção:** R$ 28.559,70/ano

**Extratos Disponíveis:**
- PJ65: 27/02 a 03/04/2026
- PJ20: 01/01 a 03/04/2026
- PF: Janeiro/2026

## Top Fornecedores (Gastos Identificados)

| Fornecedor | Quantidade | Valor Total |
|------------|------------|-------------|
| Aplicação RDB | 11x | R$ 8.014,81 |
| ALL PRO IMPORTS | 4x | R$ 2.758,80 |
| ROGERIO ESPEDITO | 13x | R$ 2.268,28 |
| ATACADAO | 10x | R$ 1.529,73 |
| ATUAL PECAS (Silvana/Rogerio) | 14x | R$ 1.124,50 |
| HOUTER DO BRASIL | 2x | R$ 1.222,12 |

## Preferências de Comunicação (REGRA CRÍTICA)

**Estilo:**
- SEMPRE escrever como humano (nunca robótico)
- Códigos menos técnico, mais natural
- Emojis: máximo 10% (uso sutil)
- Linguagem direta e fluída
- Evitar "processando dados...", usar "pensando..."
- Evitar "erro detectado", usar "ops, deu problema"

**Decisões:**
- Pede autorização ANTES de ações destrutivas
- Prefere sistemas automatizados
- Valoriza documentação organizada
- Gosta de tomar decisões técnicas sozinho

## ⚠️ CONFIGURAÇÕES VITAIS (CRÍTICO - NUNCA ESQUECER)

### Sobre Skills
**REGRA DE OURO:** NENHUMA nova skill será instalada sem autorização explícita de Acib ABBADE.

**Processo obrigatório:**
1. Stark identifica necessidade
2. Stark explica: nome, função, utilidade, riscos
3. Acib responde: "Aprovo", "Não aprovo", ou "Explique melhor"
4. Somente após "Aprovo" ou "Sim" → instalar

**Skills ativas (aprovadas):**
- memory-never-forget (v4.13) - Aprovada 2026-04-19
- acib-profile (1.0) - Aprovada 2026-04-19

**Documentação:** Todas as skills em uso estão em SKILLS_UTILIZADAS.md

**Revisão:** Mensal com Acib ou quando solicitado

## Sistema Multi-Agente

### Agentes Configurados
| Agente | CT | IP | Especialidade | Senha Root |
|--------|-----|-----|---------------|------------|
| Stark (Maestro) | 100 | 192.168.0.21 | Coordenação/Geral | (chave SSH) |
| MailBot | 101 | 192.168.0.240 | Emails/Comunicação | Rcmp814k@# |
| DATASVR | 102 | 192.168.0.72 | Armazenamento/Dados | Rcmp@814k$1982 |
| Supervisor | 103 | 192.168.0.42 | Monitoramento | Rcmp814k@# |
| Vorcaro | 104 | 192.168.0.172 | Financeiro | Rcmp814k@# |
| OfficeBoy | 105 | 192.168.0.117 | Tarefas Administrativas | Rcmp814k@# |
| Seguranca | 106 | 192.168.0.231 | Segurança de Rede | Rcmp814k |
| SAMU | 107 | 192.168.0.64 | Emergências/Recovery | Rcmp814k@# |

**Arquitetura:**
- Modelo: ollama/minimax-m2.7:cloud (todos os CTs)
- Palavra Mágica Guardian: LIBERAR
- Protocolo: Independência total com coordenação minimalista

## Projetos Ativos

**1. Sistema Multi-Agente (SGN)**
- Banco PostgreSQL (CT 103)
- Gestão de OS, estoque, clientes, financeiro
- Schema: os, clientes, estoque, financeiro, fornecedores, garantia, agenda

**2. Bootcamp DIO**
- Projeto: Assistente de Voz com IA
- Tecnologias: Python + JS + Whisper + ChatGPT + gTTS
- Repositório: https://github.com/acibabbadecastro/dio-voice-assistant

**3. Monitoramento**
- 8 containers gerenciados
- Backup automático a cada 4 horas (DATASVR)
- MailBot processando emails financeiros (553+ emails)

## Agente Stark

**Nome:** Stark
**Container:** CT 100
**IP:** 192.168.0.21
**Função:** Orquestrador/Maestro
**Criado:** 2026-04-02 (restore)

**Responsabilidades:**
- Coordenar outros agentes
- Gerenciar memórias
- Executar tarefas sob autorização
- NUNCA agir destrutivamente sem consentimento

## Estrutura de Dados

### Pastas Samba (DATASVR - 500GB)
- Raiz: /mnt/data/LAN/
- Memórias: /mnt/data/LAN/MEMORIES/
- Logs: /mnt/data/LAN/LOGS/
- Emails: /mnt/data/LAN/Emails/
- Financeiro: /home/master/Stark_Output/Financeiro/
- Backup Pendrive: /mnt/meu-pendrive/Stark_Backup/

### Hierarquia NF-E
- NFe/Compra/[ANO]/[EMPRESA]/[MÊS]/
- NFe/Emitidas/[ANO]/[EMPRESA]/[MÊS]/

## Contatos Importantes

**Clientes:**
- Saulo/SERVMIL (principal)
- Anderson (Servmil)

**Fornecedores:**
- ATUAL PECAS (Silvana Barbosa, Rogerio Espedito)
- ALL PRO IMPORTS

## Contexto Acadêmico

**Faculdade:** 6 disciplinas, 18 atividades
**Tabela:** academico.compromissos (CT 103)
**Live:** Red Team/Hardware Hacking (15/04)
**Curso:** DIO (bootcamp IA)

## Credenciais de Acesso

**Emails - App Passwords Gmail:**
| Email | App Password |
|-------|--------------|
| acibabbadecastro@gmail.com | juqqogjysxvpowtu |
| acibabbade@gmail.com | obtx vtvr znrw bxlv |

**OpenClaw:**
- Gateway Port: 18789
- Gateway Token: 84c98cf437f99f67f42553f4ec2639b49bf7991ee616d6ae
- Telegram Bot Token: 8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc

## Regras de Segurança

**Ações que REQUEREM autorização:**
- Deletar arquivos/bancos
- Enviar emails públicos
- Alterar credenciais
- Ações destrutivas

**Permitido sem pedir:**
- Ler arquivos
- Organizar dados
- Verificar logs
- Atualizar documentação

## Backups

**Local Principal:** /home/master/LAN/MEMORIES/STARK-KNOWLEDGE/
**Pendrive:** /mnt/meu-pendrive/Stark_Backup/
**DATASVR:** CT 102 (192.168.0.72)
**Frequência:** A cada 4 horas (automático)

## Tarefas Pendentes (Abril/2026)

**Alta Prioridade:**
- [ ] Contato Anderson - Servmil
- [ ] Holter retirar pedido Renato
- [ ] Comprar roteador para Servmil (R$ 2.750)

**Média Prioridade:**
- [ ] Enviar mensagem Sávio
- [ ] Analisar notebook Miss Slade
- [ ] Analisar notebook Abel

## Histórico de Memórias

**Problema Anterior:**
- Perda de ~25 dias de conversas (24/03 a 18/04/2026)
- Causa: Sobrescrição por cron jobs
- Solução: Nova estrutura em /home/master/LAN/MEMORIES/STARK-KNOWLEDGE/
- Skill memory-never-forget instalada (v4.13)

**Descoberta no DATASVR:**
- Backup crítico encontrado: /home/master/LAN/BACKUP_CRITICO/
- Memória antiga: /home/master/LAN/Stark_Output/Backups/memory_2026-04-03.md
- Dados completos recuperados e integrados neste perfil

## Preferências Técnicas

**Sistema:** Proxmox containers
**Linguagens:** Python, JavaScript
**Banco:** PostgreSQL
**Backup:** Sistema triplo (arquivo + DATASVR + pendrive)

**Não gosta:**
- Sistemas complexos demais
- Decisões automatizadas sem aviso
- Perda de dados/memórias

**Gosta:**
- Automação inteligente
- Documentação clara
- Sistemas multi-agente
- Decisões técnicas bem fundamentadas

## Notas Importantes

- Perdeu ~25 dias de conversas (erro cron) - AGORA CORRIGIDO
- Sistema de memória reforçado em /home/master/LAN/MEMORIES/
- Skill memory-never-forget instalada para evitar perdas futuras
- Prefere código que consiga explicar (não copiar sem entender)
- Guardian system ativo (palavra mágica: LIBERAR)
- SAMU e Supervisor em modo DORMANT (evitar loops)

---

**Atualizado:** 2026-04-19
**Próxima revisão:** Quando houver mudanças significativas
**Responsável:** Stark (CT 100)
**Versão:** 2.0 (com dados do DATASVR integrados)
