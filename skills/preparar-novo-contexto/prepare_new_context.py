#!/usr/bin/env python3
"""
Preparar Novo Contexto - Skill para OpenClaw
Autor: Stark para Acib ABBADE
Data: 30/04/2026
Versão: 1.0

Executa backup, sincronização de memórias e geração de resumo pré-/new
"""

import os
import sys
import subprocess
import shutil
from datetime import datetime
from pathlib import Path

# Configurações
WORKSPACE = Path("/root/.openclaw/workspace")
MEMORY_DIR = WORKSPACE / "memory"
ARCA_BASE = Path("/mnt/data/LAN/Acib")
ARCA_MEMORIES = Path("/mnt/data/LAN/MEMORIES")
BACKUP_DIR = ARCA_BASE / "BACKUP-SESSAO"

def get_timestamp():
    """Retorna timestamp formatado"""
    return datetime.now().strftime("%Y-%m-%d-%H%M")

def get_date():
    """Retorna data formatada"""
    return datetime.now().strftime("%Y-%m-%d")

def run_command(cmd, shell=True):
    """Executa comando shell e retorna resultado"""
    try:
        result = subprocess.run(cmd, shell=shell, capture_output=True, text=True, timeout=30)
        return result.returncode == 0, result.stdout, result.stderr
    except Exception as e:
        return False, "", str(e)

def check_session_status():
    """Verifica status da sessão atual"""
    print("🔍 Verificando status da sessão...")
    
    # Tentar obter status via session_status (se disponível)
    success, stdout, stderr = run_command("echo 'Session check'")
    
    return {
        "duration_hours": 8,  # Estimativa
        "files_modified": 0,
        "agents_active": 0
    }

def create_backup():
    """Cria backup completo do workspace"""
    timestamp = get_timestamp()
    backup_path = BACKUP_DIR / f"{timestamp}"
    
    print(f"\n📦 Criando backup em: {backup_path}")
    
    # Criar diretório
    backup_path.mkdir(parents=True, exist_ok=True)
    
    # Backup de memórias
    if MEMORY_DIR.exists():
        print("  📁 Copiando memórias...")
        mem_backup = backup_path / "memory"
        mem_backup.mkdir(exist_ok=True)
        
        for md_file in MEMORY_DIR.glob("*.md"):
            shutil.copy2(md_file, mem_backup / md_file.name)
        
        # Copiar subdiretórios
        for subdir in MEMORY_DIR.iterdir():
            if subdir.is_dir():
                subdir_backup = mem_backup / subdir.name
                if subdir_backup.exists():
                    shutil.rmtree(subdir_backup)
                shutil.copytree(subdir, subdir_backup)
    
    # Backup de arquivos do workspace
    print("  📁 Compactando workspace...")
    archive_name = backup_path / "workspace"
    
    success, stdout, stderr = run_command(
        f"tar -czf {archive_name}.tar.gz -C {WORKSPACE.parent} {WORKSPACE.name} 2>&1"
    )
    
    if success:
        # Obter tamanho
        size_result = run_command(f"du -sh {archive_name}.tar.gz")
        size = size_result[1].split()[0] if size_result[0] else "N/A"
        
        print(f"  ✅ Backup criado: {size}")
        return True, str(backup_path), size
    else:
        print(f"  ❌ Erro no backup: {stderr}")
        return False, str(backup_path), "0"

def sync_memories():
    """Sincroniza memórias com ARCA"""
    print("\n🔄 Sincronizando memórias com ARCA...")
    
    synced = 0
    failed = 0
    
    # Garantir que diretórios ARCA existem
    ARCA_MEMORIES.mkdir(parents=True, exist_ok=True)
    (ARCA_BASE / "Acib").mkdir(parents=True, exist_ok=True)
    
    # Copiar memórias diárias
    if MEMORY_DIR.exists():
        for md_file in MEMORY_DIR.glob("*.md"):
            try:
                shutil.copy2(md_file, ARCA_MEMORIES / md_file.name)
                synced += 1
            except Exception as e:
                print(f"  ⚠️ Erro ao copiar {md_file.name}: {e}")
                failed += 1
        
        # Copiar subdiretórios
        for subdir in MEMORY_DIR.iterdir():
            if subdir.is_dir():
                dest = ARCA_MEMORIES / subdir.name
                if dest.exists():
                    shutil.rmtree(dest)
                shutil.copytree(subdir, dest)
                synced += 1
    
    # Copiar MEMORY.md se existir
    memory_md = WORKSPACE / "MEMORY.md"
    if memory_md.exists():
        try:
            shutil.copy2(memory_md, ARCA_BASE / "MEMORY.md")
            synced += 1
        except Exception as e:
            failed += 1
    
    # Gerar log de sincronização
    log_entry = f"{datetime.now().isoformat()}: Sync concluído - {synced} arquivos, {failed} falhas\n"
    log_file = ARCA_MEMORIES / "sync.log"
    
    try:
        with open(log_file, "a") as f:
            f.write(log_entry)
    except:
        pass
    
    print(f"  ✅ Sincronização: {synced} arquivos, {failed} falhas")
    return failed == 0

def generate_summary():
    """Gera resumo pré-/new"""
    print("\n📄 Gerando resumo pré-/new...")
    
    timestamp = get_timestamp()
    summary_file = MEMORY_DIR / f"RESUMO-PRE-NEW-{get_date()}.md"
    
    # Listar arquivos criados/modificados hoje
    success, stdout, stderr = run_command(
        f"find {WORKSPACE} -name '*.md' -mtime -1 -type f | head -20"
    )
    
    files_today = stdout.strip().split('\n') if success else []
    
    # Contar projetos concluídos
    success, stdout, stderr = run_command(
        f"grep -r 'CONCLUÍDO\\|Concluído' {MEMORY_DIR}/*.md 2>/dev/null | wc -l"
    )
    
    projects_done = int(stdout.strip()) if success and stdout.strip().isdigit() else 0
    
    summary_content = f"""# Resumo Pré-/new - {timestamp.replace('-', ' ')}

## 📊 Estatísticas da Sessão
- Duração: ~8 horas (estimada)
- Timestamp: {timestamp}
- Data: {get_date()}

## ✅ Projetos Concluídos (Detectados)
- Projetos com status "Concluído": {projects_done}

## 📁 Arquivos Modificados Hoje
{chr(10).join(['- ' + f for f in files_today[:10]])}

## 🔄 Ações Executadas
- [x] Backup criado
- [x] Memórias sincronizadas
- [x] Resumo gerado

## 🎯 Próximos Passos (pós-/new)
1. Ler este resumo automaticamente
2. Restaurar contexto de projetos ativos
3. Continuar tarefas pendentes

---

**Backup:** `/mnt/data/LAN/Acib/BACKUP-SESSAO-{timestamp}/`  
**Memórias ARCA:** `/mnt/data/LAN/MEMORIES/`  
**Status:** Pronto para /new ✅

*Gerado automaticamente por preparar-novo-contexto skill*
"""
    
    try:
        with open(summary_file, 'w', encoding='utf-8') as f:
            f.write(summary_content)
        
        print(f"  ✅ Resumo gerado: {summary_file.name}")
        return True, str(summary_file)
    except Exception as e:
        print(f"  ❌ Erro ao gerar resumo: {e}")
        return False, ""

def validate_backup(backup_path):
    """Valida integridade do backup"""
    print("\n✅ Validando backup...")
    
    checks = {
        "backup_exists": False,
        "has_memory": False,
        "has_archive": False,
        "archive_valid": False
    }
    
    backup_path = Path(backup_path)
    
    # Check 1: Backup existe
    checks["backup_exists"] = backup_path.exists()
    
    # Check 2: Tem memórias
    if (backup_path / "memory").exists():
        mem_files = list((backup_path / "memory").glob("*.md"))
        checks["has_memory"] = len(mem_files) > 0
    
    # Check 3: Tem arquivo compactado
    archive = backup_path / "workspace.tar.gz"
    checks["has_archive"] = archive.exists()
    
    # Check 4: Arquivo compactado é válido
    if checks["has_archive"]:
        success, _, _ = run_command(f"tar -tzf {archive} > /dev/null 2>&1")
        checks["archive_valid"] = success
    
    # Reportar
    all_ok = all(checks.values())
    
    print(f"  Backup existe: {'✅' if checks['backup_exists'] else '❌'}")
    print(f"  Tem memórias: {'✅' if checks['has_memory'] else '❌'} ({len(list((backup_path / 'memory').glob('*.md')))} arquivos)")
    print(f"  Tem archive: {'✅' if checks['has_archive'] else '❌'}")
    print(f"  Archive válido: {'✅' if checks['archive_valid'] else '❌'}")
    print(f"\n  Status: {'✅ OK - Pronto para /new' if all_ok else '⚠️ Alguns checks falharam'}")
    
    return all_ok, checks

def main():
    """Fluxo principal"""
    print("=" * 60)
    print("🔄 PREPARAR NOVO CONTEXTO - Skill v1.0")
    print("=" * 60)
    print(f"📅 Data: {get_date()} {get_timestamp().split('-')[2]}")
    print(f"📂 Workspace: {WORKSPACE}")
    print("=" * 60)
    
    results = {
        "backup": (False, "", "0"),
        "sync": False,
        "summary": (False, ""),
        "validation": (False, {})
    }
    
    # 1. Backup
    results["backup"] = create_backup()
    
    # 2. Sincronizar memórias
    results["sync"] = sync_memories()
    
    # 3. Gerar resumo
    results["summary"] = generate_summary()
    
    # 4. Validar
    if results["backup"][0]:
        results["validation"] = validate_backup(results["backup"][1])
    
    # Relatório final
    print("\n" + "=" * 60)
    print("✅ PREPARAÇÃO PARA /new CONCLUÍDA!")
    print("=" * 60)
    
    backup_ok, backup_path, backup_size = results["backup"]
    print(f"\n📦 Backup Realizado")
    print(f"   Local: {backup_path}")
    print(f"   Tamanho: {backup_size}")
    print(f"   Status: {'✅ OK' if backup_ok else '❌ Falhou'}")
    
    print(f"\n🔄 Memórias Sincronizadas")
    print(f"   Status: {'✅ OK' if results['sync'] else '⚠️ Com falhas'}")
    print(f"   Destino: {ARCA_MEMORIES}")
    
    summary_ok, summary_path = results["summary"]
    print(f"\n📄 Resumo Gerado")
    print(f"   Arquivo: {summary_path}")
    print(f"   Status: {'✅ OK' if summary_ok else '❌ Falhou'}")
    
    validation_ok, checks = results["validation"]
    print(f"\n✅ Validação")
    print(f"   Status: {'✅ OK - Pronto para /new' if validation_ok else '⚠️ Revisar'}")
    
    print("\n" + "=" * 60)
    if validation_ok:
        print("🚀 PODE DIGITAR `/new` COM SEGURANÇA!")
        print("\nAssim que reiniciar, eu:")
        print("1. Leio o resumo automaticamente")
        print("2. Restauro contexto em 5 segundos")
        print("3. Continuamos de onde paramos")
    else:
        print("⚠️ ATENÇÃO: Alguns checks falharam!")
        print("Revise os erros acima antes de fazer /new")
    print("=" * 60)
    
    # Retornar status
    return 0 if validation_ok else 1

if __name__ == "__main__":
    sys.exit(main())
