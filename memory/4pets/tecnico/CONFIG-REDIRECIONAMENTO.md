# 🔧 CONFIGURAÇÃO DE REDIRECIONAMENTO - SITE 4PETS
## Data: 26/04/2026

---

## ✅ STATUS ATUAL

### Dentro do site (CT 4pets - Nginx):
| Configuração | Status | Detalhes |
|--------------|--------|----------|
| **Nginx** | ✅ Rodando | Default configurado |
| **Páginas** | ✅ OK | index.html, cadastrar.html, buscar.html |
| **Diretório** | ✅ OK | /var/www/amigos4patas/static |
| **Acesso local** | ✅ OK | http://192.168.0.200 |

**Nota:** A configuração Nginx com domínio específico teve erro de sintaxe.  
**Solução:** Usando configuração default que responde a qualquer requisição.

---

## 🎯 O QUE FOI CONFIGURADO (DENTRO)

### Nginx:
- ✅ Servidor web ativo
- ✅ Respondendo na porta 80
- ✅ Site acessível via IP 192.168.0.200
- ⚠️ Configuração específica de domínio com erro (corrigir futuro)

### Site:
- ✅ index.html (home)
- ✅ cadastrar.html (formulário)
- ✅ buscar.html (busca com filtros)
- ✅ Estrutura de pastas (/css, /js, /uploads)

---

## 🌐 O QUE FALTA (FORA DO SITE)

### 1. DNS (Registro.br)
```
A: @    → 192.168.0.200
A: www  → 192.168.0.200
```

### 2. Roteador
```
Porta 80   → 192.168.0.200:80
Porta 443  → 192.168.0.200:443
```

### 3. SSL (Certbot)
```
certbot --nginx -d amigos4patas.com.br -d www.amigos4patas.com.br
```

---

## 📝 PASSO A PASSO PARA REDIRECIONAMENTO FUNCIONAR

### PASSO 1: DNS (Registro.br) - VOCÊ FAZ
1. Acesse: https://registro.br
2. Login com CPF/senha
3. Vá em "Meus Domínios"
4. Clique em "amigos4patas.com.br"
5. Clique em "Edição de zona DNS"
6. Adicione:
   ```
   Tipo: A
   Nome: @
   Valor: 192.168.0.200
   ```
7. Adicione:
   ```
   Tipo: A
   Nome: www
   Valor: 192.168.0.200
   ```
8. Salvar

### PASSO 2: Roteador - VOCÊ FAZ
1. Acesse: http://192.168.0.1 (ou IP do seu roteador)
2. Login com admin/senha do roteador
3. Procure "Port Forwarding" ou "Redirecionamento de portas"
4. Adicione regra:
   - Porta externa: 80
   - IP interno: 192.168.0.200
   - Porta interna: 80
5. Adicione regra:
   - Porta externa: 443
   - IP interno: 192.168.0.200
   - Porta interna: 443
6. Salvar

### PASSO 3: SSL (HTTPS) - EU FAÇO
Assim que DNS e roteador estiverem OK, eu configuro o SSL.

---

## ⏱️ TEMPO DE PROPAGAÇÃO

Após configurar DNS:
- ⚡ Rápido: 5-15 minutos (novos registros)
- 🐌 Lento: Até 24-48 horas (mudanças globais)

---

## ✅ CHECKLIST PARA AMANHÃ

- [ ] Configurar DNS no Registro.br (5 min)
- [ ] Configurar portas no roteador (5 min)
- [ ] Testar acesso: http://amigos4patas.com.br
- [ ] Configurar SSL (eu faço)
- [ ] Testar HTTPS: https://amigos4patas.com.br

---

## 🚨 IMPORTANTE

**O site já está pronto e funcionando internamente!**

Só falta:
1. DNS apontar pro IP
2. Roteador liberar porta
3. SSL (HTTPS)

**Aí sim estará acessível de qualquer lugar do mundo!**

---

**Data:** 26/04/2026 13:45  
**Responsável técnico:** Stark  
**Próxima ação:** Acib configura DNS + Roteador
