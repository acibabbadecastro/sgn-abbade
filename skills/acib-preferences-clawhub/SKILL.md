---
name: acib-preferences
description: Personalized learning system that captures, stores, and applies user preferences across all interactions. Use when interacting with Acib ABBADE (Telegram ID 1866226415) to maintain continuity, apply learned patterns, and provide increasingly personalized assistance. Triggers automatically on any task where context about user preferences, history, or workflows would improve response quality.
---

# Acib Preferences

Personalized learning system for Acib ABBADE.

## Overview

Captures and applies user preferences across sessions:
- Personal profile and goals
- Technical preferences and stack
- Behavioral patterns and workflows
- Access credentials and security
- Project history and decisions

## When to Use

Automatically triggered for Acib ABBADE (1866226415). The skill loads preference data to personalize:
- Response style and detail level
- Technical recommendations
- Workflow suggestions
- Security practices
- Communication tone

## Quick Start

```bash
# Update a preference
./scripts/update-preference.sh --category tech --content "Prefers vibrant colors"

# List all preferences
./scripts/update-preference.sh --list

# Search preferences
./scripts/update-preference.sh --search "deploy"
```

## Preference Categories

| File | Contents |
|------|----------|
| `references/perfil.md` | Personal data, contacts, education |
| `references/tecnicas.md` | Tech stack, tools, patterns |
| `references/workflows.md` | Standard processes, checklists |
| `references/decisoes.md` | Important architectural decisions |
| `references/acessos.md` | Credentials, SSH keys, access logs |
| `references/comportamental.md` | Productivity patterns, decision style |
| `references/cognitivo.md` | Learning style, formats |
| `references/emocional.md` | State detection, needs |

## Integration

Works with:
- `new-session-prep` - Captures context before /new
- `new-session-detector` - Detects when /new is needed
- `context-preserver` - Syncs state in real-time

## Backup

All preferences sync automatically to DATASVR at `\192.168.0.72\LAN\Acib\skills\acib-preferences\`

## Version

1.0.0 - Created 2026-04-27
