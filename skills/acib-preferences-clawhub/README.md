# 🎯 Acib Preferences

**Personalized AI Learning System**

A comprehensive preference capture and application system that enables AI assistants to learn, remember, and apply user preferences across all interactions for increasingly personalized assistance.

---

## ✨ Features

### 📚 Multi-Dimensional Learning
- **Personal Profile**: Education, career, contacts, goals
- **Technical Stack**: Tools, frameworks, preferred patterns
- **Behavioral Patterns**: Productivity hours, decision styles, workflows
- **Cognitive Preferences**: Learning style, formats, detail levels
- **Emotional Intelligence**: State detection, needs anticipation
- **Access Management**: Credentials, SSH keys, security practices

### 🔄 Automatic Sync
- Real-time backup to DATASVR
- Cross-session continuity
- Preference auto-application

### 🎨 Adaptive Responses
Adapts automatically based on:
- Time of day (productivity patterns)
- Context (urgent vs exploratory)
- History (what worked before)
- Emotional state (detected from language)

---

## 🚀 Quick Start

```bash
# Add a new preference
./scripts/update-preference.sh --category tech --content "Prefers PostgreSQL over MySQL"

# View all preferences in a category
./scripts/update-preference.sh --list tech

# Search across all preferences
./scripts/update-preference.sh --search "deploy"

# Backup to DATASVR
./scripts/backup-preferences.sh
```

---

## 📁 Structure

```
acib-preferences/
├── SKILL.md              # Main skill documentation
├── README.md             # This file
├── scripts/
│   ├── update-preference.sh    # Add/update preferences
│   └── backup-preferences.sh   # Sync to DATASVR
└── references/           # Preference data
    ├── perfil.md        # Personal profile
    ├── tecnicas.md      # Technical preferences
    ├── workflows.md     # Standard processes
    ├── decisoes.md      # Key decisions
    ├── acessos.md       # Access management
    ├── comportamental.md # Behavioral patterns
    ├── cognitivo.md     # Cognitive style
    └── emocional.md     # Emotional patterns
```

---

## 🎯 Use Cases

### 1. Context Preservation
User works on project for 8 hours, needs /new  
**System**: Auto-saves all preferences, next session restores perfectly

### 2. Preference Auto-Application
User prefers vibrant colors (`#FF6B9D`)  
**System**: Applies automatically to new web projects

### 3. Behavioral Adaptation
User works best 9-11am for decisions, 3-5pm for technical work  
**System**: Suggests appropriate tasks based on current time

### 4. Emotional Intelligence
User says "Rápido" (under pressure)  
**System**: Prioritizes speed, minimizes explanations

---

## 🔧 Configuration

### Environment Variables
```bash
# DATASVR for backup (required)
DATASVR_IP=192.168.0.72
DATASVR_USER=root
DATASVR_PASS=Rcmp@814k$1982

# Sync interval (optional, default: 300s)
SYNC_INTERVAL=300
```

### Integration
Works seamlessly with:
- `new-session-prep` - Context capture before reset
- `new-session-detector` - Smart /new detection
- `context-preserver` - Real-time state sync

---

## 📊 Example Preferences Captured

```yaml
# Technical
Colors: "#FF6B9D → #C44569 → #F8B500"
Stack: "Proxmox LXC, Python, PostgreSQL, Nginx"
SSH: "Keys preferred over passwords"

# Behavioral
Peak hours: "9-11am decisions, 3-5pm execution"
Decision style: "Action first, theory later"
Documentation: "Always backup to ARCA"

# Emotional
Under pressure: "Prioritize speed"
Frustrated: "Offer break or quick fix"
Satisfied: "Validate and suggest next step"
```

---

## 🛡️ Security

- Credentials stored in `references/acessos.md`
- Encrypted at rest on DATASVR
- SSH keys use ed25519
- Automatic backups prevent data loss

---

## 🤝 Contributing

This is a personalized skill for Acib ABBADE. To adapt for other users:

1. Fork the skill
2. Update `references/` files with new user data
3. Adjust detection patterns in scripts
4. Test for 3+ sessions to validate learning

---

## 📈 Roadmap

- [x] Core preference capture (v1.0)
- [x] Real-time sync to DATASVR (v1.0)
- [x] 7-dimensional learning system (v1.1)
- [ ] ML-based preference prediction (v2.0)
- [ ] Cross-user pattern anonymization (v2.5)
- [ ] Voice/semantic preference detection (v3.0)

---

**Version**: 1.0.0  
**Created**: 2026-04-27  
**Author**: Stark 🤖 for Acib ABBADE  
**License**: Open Source (adapt for your users)

---

🎯 **Learn your users. Remember what matters. Apply automatically.**
