# 📝 PENDÊNCIAS SIC - REINÍCIO 23/04/2026 19:33

**Data/Hora:** 23/04/2026 19:33  
**Situação:** Reinício realizado  
**Status:** ⚠️ Serviços não iniciaram automaticamente

---

## ❌ PROBLEMA IDENTIFICADO

Após reinício, os serviços **não subiram automaticamente**:

| Serviço | Status Esperado | Status Real |
|---------|-----------------|-------------|
| OpenSSH (sshd) | Automático | ❌ Manual |
| Terminal Services (RDP) | Automático | ❌ Manual |

**Resultado:** Servidor responde ping, mas **SSH e RDP estão offline**.

---

## 🛠️ SOLUÇÃO NECESSÁRIA

### **No SIC (executar como ADMINISTRADOR):**

```cmd
:: Configurar para automático
sc config sshd start= auto
sc config termservice start= auto

:: Iniciar agora
net start sshd
net start termservice

:: Verificar
sc query sshd
sc query termservice
```

**Ou via GUI:**
1. `services.msc` → Executar como admin
2. **OpenSSH SSH Server** → Propriedades → Inicialização: **Automático**
3. **Serviços de Área de Trabalho Remota** → Propriedades → Inicialização: **Automático**

---

## ✅ CHECKLIST PÓS-CORREÇÃO

- [ ] SSH configurado como Automático
- [ ] RDP configurado como Automático
- [ ] Testar reinício novamente
- [ ] Verificar se sobem sozinhos

---

## 📝 NOTAS

- Usuários funcionam: acib, stark
- Senha: Rcmp814k@#
- IP: 192.168.0.253
- Problema: Tipo de inicialização dos serviços

---

*Registrado em: 23/04/2026 19:33*  
*Por: Stark - Sistema de Gestão*
