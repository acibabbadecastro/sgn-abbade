# 📚 CURSOS E CERTIFICADOS - ESTRUTURA ORGANIZACIONAL

**Criado em:** 27/04/2026  
**Proprietário:** Acib ABBADE  
**Regra:** TODOS os cursos, certificados e diplomas devem ser armazenados aqui

---

## 🗂️ ESTRUTURA DE PASTAS

```
cursos-certificados/
│
├── cursos/              # Materiais de cursos (PDFs, aulas, anotações)
│   ├── 2024/
│   │   ├── unopar/      # Faculdade UNOPAR
│   │   ├── bradesco/    # Banco Bradesco
│   │   ├── dio/         # Digital Innovation One
│   │   ├── alura/       # Alura
│   │   ├── udemy/       # Udemy
│   │   └── outros/      # Outras instituições
│   ├── 2025/
│   │   └── [mesma estrutura]
│   └── 2026/
│       └── [mesma estrutura]
│
├── certificados/        # Certificados de conclusão
│   ├── 2024/
│   │   └── [instituições]
│   ├── 2025/
│   │   └── [instituições]
│   └── 2026/
│       └── [instituições]
│
├── diplomas/            # Diplomas formais
│   ├── 2024/
│   │   └── [instituições]
│   ├── 2025/
│   │   └── [instituições]
│   └── 2026/
│       └── [instituições]
│
└── competencias/        # Rastreamento de habilidades
    ├── hard-skills/   # Técnicas (Python, Linux, Docker, etc)
    ├── soft-skills/   # Comportamentais (comunicação, liderança)
    └── idiomas/       # Certificações de idiomas
```

---

## 📋 REGRAS DE ARMAZENAMENTO

### Quando receber um arquivo:

1. **Identificar o TIPO**
   - É curso/material? → pasta `cursos/`
   - É certificado? → pasta `certificados/`
   - É diploma? → pasta `diplomas/`

2. **Identificar o ANO**
   - Quando foi concluído/emissão

3. **Identificar a INSTITUIÇÃO**
   - unopar, bradesco, dio, alura, udemy, outros

4. **NOMEAR o arquivo**
   ```
   [DATA]_[NOME-CURSO]_[INSTITUICAO].[ext]
   
   Exemplo:
   2026-04-27_GenAI-Dados_Bradesco.pdf
   ```

---

## ✅ CHECKLIST DE ARMAZENAMENTO

- [ ] Arquivo salvo na pasta correta
- [ ] Nome do arquivo descritivo
- [ ] Data de conclusão registrada
- [ ] Anotações importantes salvas em .md
- [ ] Link de verificação (se houver)
- [ ] Adicionado ao currículo (se relevante)

---

## 🔄 PROCESSO AUTOMÁTICO

**Quando Acib enviar:**
1. PDF de curso → detectar automaticamente
2. Extrair metadados (data, instituição, nome)
3. Mover para pasta correta
4. Renomear padronizado
5. Confirmar salvo

---

*Estrutura criada em 27/04/2026*
