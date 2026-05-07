# 🤝 Como Contribuir com Maximous

Obrigado por seu interesse em contribuir com o Maximous! Este documento fornece diretrizes para contribuições.

## 🎯 Tipos de Contribuição

### 🐛 Reportar Bugs
- Use [Issues](https://github.com/acibabbadecastro/maximous/issues)
- Descreva o problema detalhadamente
- Inclua passos para reproduzir
- Informe seu ambiente (SO, versão, etc.)

### 💡 Sugerir Funcionalidades
- Abra uma Issue com label `enhancement`
- Explique o problema que resolve
- Descreva a solução proposta

### 🔧 Pull Requests
1. Fork o repositório
2. Crie uma branch: `git checkout -b feature/NomeFeature`
3. Faça suas alterações
4. Teste exaustivamente
5. Commit com mensagens claras
6. Push para sua fork
7. Abra um PR

## 📝 Padrões de Código

### Shell Scripts
```bash
#!/bin/bash
# Comentário explicativo
funcao_exemplo() {
    local variavel="valor"  # Use local
    echo "$variavel"
}
```

### Documentação
- Comente funções complexas
- Atualize o README se necessário
- Mantenha exemplos atualizados

## 🧪 Testes

Antes de submeter:
```bash
# Teste seus scripts
bash scripts/seu-script.sh

# Verifique sintaxe
shellcheck scripts/*.sh
```

## 📋 Checklist de PR

- [ ] Código testado localmente
- [ ] Documentação atualizada
- [ ] Sem erros de shellcheck
- [ ] Mensagens de commit claras
- [ ] PR descreve bem as mudanças

## 🙏 Agradecimentos

Toda contribuição é valiosa!
- Código
- Documentação
- Testes
- Feedback
- Divulgação

## 📞 Contato

Dúvidas? Entre em contato:
- **Email:** abbade@outlook.com
- **GitHub:** [@acibabbadecastro](https://github.com/acibabbadecastro)

---

**Obrigado por ajudar a melhorar o Maximous!** 🚀