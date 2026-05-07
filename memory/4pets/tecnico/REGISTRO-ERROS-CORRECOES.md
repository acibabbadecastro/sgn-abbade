# 📋 REGISTRO COMPLETO DE ERROS E CORREÇÕES
## Site Amigos 4 Patas - Configuração do Zero ao Funcionamento
**Data:** 26/04/2026  
**Responsável:** Stark  
**Status:** ✅ CONCLUÍDO

---

## 🎯 OBJETIVO
Configurar o site `amigos4patas.com.br` para funcionar via Cloudflare Tunnel sem abrir portas no roteador do provedor.

---

## ❌ ERROS ENCONTRADOS E TENTATIVAS DE CORREÇÃO

### ERRO #1: Cloudflared Não Instalado
**Sintoma:** Comando `cloudflared` não encontrado  
**Causa:** Pacote não instalado no CT 4pets  
**Tentativa de Correção:** Instalação via apt + download manual do .deb  
**Resultado:** ✅ FUNCIONOU - Instalado com sucesso

---

### ERRO #2: Configuração Nginx Quebrada
**Sintoma:** Erros de sintaxe ao criar arquivo de configuração via `bash -c`  
**Causa:** Parsing incorreto de strings com heredoc (`<<`) no comando remoto  
**Tentativas de Correção:**
1. ❌ Tentativa com heredoc - Falhou (bash: line X: server: command not found)
2. ❌ Tentativa com `cat >` - Falhou (comandos sendo interpretados)
3. ✅ **Solução:** Usar `sed` para modificar arquivo existente - FUNCIONOU

---

### ERRO #3: Site Não Respondendo via IP Local
**Sintoma:** `http://192.168.0.200` retornava "Conexão recusada"  
**Causa:** Firewall do Proxmox ativo no CT 107 (`firewall=1`)  
**Tentativas de Correção:**
1. ❌ Tentativa modificar via `pct config` - Comando não existe
2. ✅ **Solução:** `sed -i 's/firewall=1/firewall=0/g' /etc/pve/lxc/107.conf` - FUNCIONOU

---

### ERRO #4: Porta 80 Não Escutando
**Sintoma:** Nginx rodando mas sem portas abertas na 80  
**Causa:** Configuração `sites-enabled` vazia (link removido)  
**Tentativa de Correção:** Recriar link simbólico para `sites-available/default`  
**Resultado:** ✅ FUNCIONOU

---

### ERRO #5: Redirecionamento em Excesso (Loop)
**Sintoma:** `ERR_TOO_MANY_REDIRECTS` ao acessar  
**Causa:** Nginx configurado com redirecionamento automático  
**Tentativas de Correção:**
1. ❌ Edição manual - Dificuldade com escaping no bash remoto
2. ✅ **Solução:** Modificação via `sed` e reinício do Nginx - FUNCIONOU

---

### ERRO #6: DNS Não Propagando (Público Inacessível)
**Sintoma:** `DNS_PROBE_FINISHED_NXDOMAIN` no navegador  
**Causa:** Nameservers alterados no Registro.br mas DNS global não atualizou  
**Tentativas:**
- Aguardar propagação natural (30min-2h)
- Sugestão de flush DNS local
- **Observação:** Fora do controle técnico - depende de propagação global

---

### ERRO #7: Cloudflared Tunnel Parado
**Sintoma:** "Tunnel Down" no painel Cloudflare  
**Causa:** Serviço systemd parado após reinicializações  
**Tentativas de Correção:**
1. ✅ `systemctl start cloudflared` - FUNCIONOU temporariamente
2. ❌ Tunnel caiu novamente depois - Requeria reinstall
3. ✅ **Solução Final:** `cloudflared service install <TOKEN>` - FUNCIONOU

---

### ERRO #8: ERRO CRÍTICO - `try_files` Corrompido
**Sintoma:** Cloudflare retornava "521 Web Server Is Down" / Site inacessível  
**Causa:** Arquivo de configuração Nginx criado com parsing errado:  
```nginx
try_files  / =404;  ❌ ERRADO
```
**Deveria ser:**
```nginx
try_files $uri $uri/ =404;  ✅ CORRETO
```

**Impacto:** Nginx retornava HTTP 301 (Moved Permanently) em vez de servir os arquivos, quebrando a comunicação com o Cloudflare.

**Tentativas de Correção:**
1. ❌ Várias tentativas com `bash -c` e heredoc - Todas falharam por escaping incorreto
2. ❌ Tentativa com `printf` - Também falhou
3. ✅ **Solução Final:** `sed -i 's/try_files  \/ =404;/try_files \$uri \$uri\/ =404;/g'` - FUNCIONOU

---

## ✅ RESULTADOS FINAIS

### O Que Funcionou:
| Componente | Status | URL |
|------------|--------|-----|
| **Site Local** | ✅ FUNCIONANDO | http://192.168.0.200 |
| **Nginx** | ✅ HTTP 200 OK | - |
| **Cloudflare Tunnel** | ✅ Conectado | - |
| **Firewall Proxmox** | ✅ Desativado | - |

### O Que Ainda Depende de Tempo:
| Componente | Status | Observação |
|------------|--------|------------|
| **Site Público** | ⏳ Aguardando | DNS propagando globalmente |
| **HTTPS** | ⏳ Pendente | Depende do domínio resolver |

---

## 📚 LIÇÕES APRENDIDAS

### 1. Configuração Nginx via SSH
**Problema:** Criar arquivos multi-linha via `bash -c` é propenso a erros de escaping  
**Solução:** Usar `sed` para modificar arquivos existentes é mais confiável

### 2. Firewall do Proxmox
**Problema:** Esqueci de verificar o firewall do CT  
**Solução:** Sempre verificar `/etc/pve/lxc/<id>.conf` para `firewall=1`

### 3. Testes Locais Antes do Público
**Problema:** Foquei no DNS público antes de garantir que o local funcionava  
**Solução:** Sempre validar `http://localhost` e `http://<IP>` antes de configurar DNS

### 4. Erro Crítico de Digitação
**Problema:** O `try_files` corrompido quebrou todo o acesso  
**Solução:** Sempre testar a config com `nginx -t` E fazer request real (`curl` ou `nc`)

---

## 🔄 COMANDOS QUE FUNCIONARAM (Para Referência)

```bash
# Instalar Cloudflared
wget https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-amd64.deb
dpkg -i cloudflared-linux-amd64.deb

# Desativar firewall Proxmox
sed -i 's/firewall=1/firewall=0/g' /etc/pve/lxc/107.conf

# Corrigir try_files no Nginx
sed -i 's/try_files  \/ =404;/try_files \$uri \$uri\/ =404;/g' /etc/nginx/sites-available/default

# Instalar serviço Cloudflared
cloudflared service install <TOKEN>

# Verificar porta 80
ss -tlnp | grep :80

# Testar Nginx interno
echo -e "GET / HTTP/1.1\r\nHost: localhost\r\n\r\n" | nc -q 1 localhost 80
```

---

## ✍️ NOTAS DO DESENVOLVEDOR

> "Este foi um caso complexo onde múltiplos erros se acumularam. O erro mais crítico foi o `try_files` corrompido, que passou despercebido porque o Nginx validava sintaticamente (`nginx -t` retornava OK) mas semanticamente estava errado.
> 
> A lição principal: VALIDAR COM TESTE REAL DE HTTP, não apenas sintaxe."

---

**Documento criado:** 26/04/2026  
**Última atualização:** 26/04/2026 19:43  
**Status:** Concluído
