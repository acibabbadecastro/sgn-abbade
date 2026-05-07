# MAXIMOUS v2.0
## Maximum Context Optimizer User System

**Versão:** 2.0 - Atualizado em 27/04/2026  
**Autor:** Stark para Acib ABBADE  
**Local:** ~/.openclaw/workspace/skills/maximous-v2/

---

## 🎯 VISÃO GERAL

MAXIMOUS é um sistema de preservação de contexto e aprendizado de preferências que maximiza o valor de cada sessão de IA.

**Nova Versão 2.0 inclui 7 melhorias críticas:**

1. **Sync Imediato** - Eventos críticos salvos instantaneamente
2. **Verificação de Integridade** - Hash SHA-256 detecta corrupção
3. **Backup Multi-Cloud** - GitHub Gist + Google Drive + Dropbox + DATASVR
4. **Recuperação Granular** - Escolher o que recuperar (prefs, tarefas, projetos)
5. **Compressão Diferencial** - Apenas mudanças ocupam espaço novo
6. **Criptografia** - Dados sensíveis protegidos
7. **Dashboard** - Ver tudo que foi aprendido

---

## 🚀 COMANDOS DISPONÍVEIS

### Status e Monitoramento
```bash
# Dashboard completo
~/.openclaw/workspace/skills/maximous-v2/scripts/dashboard-status.sh

# Verificar integridade dos dados
~/.openclaw/workspace/skills/maximous-v2/scripts/integrity-check.sh check

# Scan por dados sensíveis
~/.openclaw/workspace/skills/maximous-v2/scripts/criptografia-segura.sh scan
```

### Backup e Sync
```bash
# Backup para todos os destinos
~/.openclaw/workspace/skills/maximous-v2/scripts/multi-cloud-sync.sh all

# Backup apenas DATASVR
~/.openclaw/workspace/skills/maximous-v2/scripts/multi-cloud-sync.sh datasvr

# Snapshot diferencial
~/.openclaw/workspace/skills/maximous-v2/scripts/compressao-diferencial.sh snapshot
```

### Recuperação
```bash
# Listar backups disponíveis
~/.openclaw/workspace/skills/maximous-v2/scripts/recovery-granular.sh list

# Menu interativo de recuperação
~/.openclaw/workspace/skills/maximous-v2/scripts/recovery-granular.sh

# Recuperar categoria específica
~/.openclaw/workspace/skills/maximous-v2/scripts/recovery-granular.sh restore preferencias
```

---

## ⚙️ CONFIGURAÇÃO

### Variáveis de Ambiente

Adicione ao `~/.bashrc` ou `~/.profile`:

```bash
# GitHub Gist (para backup em nuvem)
export GITHUB_TOKEN="seu_token_aqui"
export MAXIMOUS_GIST_ID="gist_id_aqui"

# Google Drive (requer rclone configurado)
export GDRIVE_FOLDER_ID="folder_id_aqui"

# Dropbox
export DROPBOX_TOKEN="seu_token_aqui"
```

### Configurar Cron Automático

```bash
# Backup a cada 30 minutos
~/.openclaw/workspace/skills/maximous-v2/scripts/multi-cloud-sync.sh setup

# Ou manualmente:
(crontab -l 2>/dev/null; echo '*/30 * * * * ~/.openclaw/workspace/skills/maximous-v2/scripts/multi-cloud-sync.sh all') | crontab -
```

---

## 📁 ESTRUTURA DE ARQUIVOS

```
maximous-v2/
├── scripts/
│   ├── sync-imediato.sh           # Melhoria 1
│   ├── integrity-check.sh         # Melhoria 2
│   ├── multi-cloud-sync.sh        # Melhoria 3
│   ├── recovery-granular.sh       # Melhoria 4
│   ├── compressao-diferencial.sh  # Melhoria 5
│   ├── criptografia-segura.sh     # Melhoria 6
│   └── dashboard-status.sh        # Melhoria 7
├── data/
│   ├── preferences.json
│   ├── context-current.json
│   ├── todos.json
│   └── .hashes/                   # Hash SHA-256 dos arquivos
├── secure/                        # Dados criptografados
├── snapshots/                     # Backups diferenciais
├── compressed/                    # Arquivos comprimidos
└── backups/                       # Backups multi-cloud
```

---

## 🔒 SEGURANÇA

- **Chave mestre:** Gerada automaticamente em `secure/.master-key`
- **Permissões:** 600 para arquivos sensíveis
- **Criptografia:** AES-256-CBC para dados sensíveis
- **Integridade:** SHA-256 para verificação de corrupção

---

## 📝 USO

### Para Desenvolvedores

O Maximous v2.0 pode ser integrado em qualquer fluxo de trabalho:

```bash
# Salvar evento crítico imediatamente
source ~/.openclaw/workspace/skills/maximous-v2/scripts/sync-imediato.sh
evento_critico "decisao-importante" "Conteúdo a ser salvo"

# Verificar saúde antes de operação importante
if ~/.openclaw/workspace/skills/maximous-v2/scripts/integrity-check.sh check; then
    echo "Sistema OK, prosseguindo..."
else
    echo "Problema detectado, recuperando..."
fi
```

---

## 🔄 MIGRAÇÃO DA v1.0

Dados da v1.0 são compatíveis. Para migrar:

```bash
# Copiar dados antigos
cp -r ~/.openclaw/workspace/skills/maximous/data/* \
      ~/.openclaw/workspace/skills/maximous-v2/data/ 2>/dev/null

# Gerar hashes iniciais
~/.openclaw/workspace/skills/maximous-v2/scripts/integrity-check.sh check

echo "✅ Migração concluída"
```

---

## 📞 SUPORTE

**Responsável:** Stark (CT 100)  
**Backup:** DATASVR (192.168.0.72)  
**Repositório:** github.com/acibabbadecastro/maximous (quando publicado)

---

**Changelog v2.0 (27/04/2026):**
- ✅ Melhoria 1: Sync Imediato
- ✅ Melhoria 2: Verificação de Integridade
- ✅ Melhoria 3: Backup Multi-Cloud
- ✅ Melhoria 4: Recuperação Granular
- ✅ Melhoria 5: Compressão Diferencial
- ✅ Melhoria 6: Criptografia
- ✅ Melhoria 7: Dashboard

**Não existe o que não possa fazer!** 💪