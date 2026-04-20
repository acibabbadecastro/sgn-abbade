# 📋 MELHORIA: CADASTRO DE CLIENTE NA OS

**Documento:** 01_Melhoria_OS_Cadastro.md  
**Data:** 09/04/2026 14:57  
**Solicitante:** Acib ABBADE  
**Prioridade:** 🔴 ALTA  
**Status:** ⏳ Aguardando infraestrutura (CT 103/104 offline)

---

## 🎯 OBJETIVO

Permitir cadastro rápido de cliente diretamente da página de Ordem de Serviço, sem perder o contexto do formulário.

---

## 📝 FLUXO ATUAL (PROBLEMA)

```
1. Usuário abre página de Nova OS
2. Digita nome do cliente
3. Cliente não está cadastrado
4. Usuário precisa:
   - Sair da página de OS
   - Ir para página de Clientes
   - Cadastrar novo cliente
   - Voltar para página de OS
   - Preencher tudo de novo
```

**Problema:** Perde tempo, perde contexto, frustrante!

---

## ✅ FLUXO DESEJADO (SOLUÇÃO)

```
1. Usuário abre página de Nova OS
2. Digita nome do cliente no campo de busca
3. Sistema busca clientes cadastrados (autocomplete)
4. SE cliente existir:
   → Seleciona da lista
   → Campos preenchidos automaticamente
5. SE cliente NÃO existir:
   → Clica no botão "Novo Cliente"
   → Abre modal/nova aba de cadastro
   → Preenche cadastro rápido
   → Clica "Finalizar"
   → Sistema volta automaticamente para OS
   → Dados do cliente já preenchidos
6. Usuário continua preenchendo OS normalmente
```

**Vantagens:** Rápido, sem perder contexto, eficiente!

---

## 🎨 INTERFACE PROPOSTA

### **PÁGINA DE OS - CAMPO CLIENTE:**

```
+----------------------------------------------------------+
|  Cliente:                                                |
|  +---------------------------+  +---------------------+  |
|  | Digite o nome do cliente  |  | [+ Novo Cliente]    |  |
|  +---------------------------+  +---------------------+  |
|                                                          |
|  Resultados da busca (autocomplete):                     |
|  +----------------------------------------------------+  |
|  | MARIA SILVA                                        |  |
|  | (11) 99999-9999 - maria@email.com                  |  |
|  +----------------------------------------------------+  |
|  | JOÃO DA SILVA                                      |  |
|  | (11) 88888-8888 - joao@email.com                   |  |
|  +----------------------------------------------------+  |
+----------------------------------------------------------+
```

---

## 🔧 IMPLEMENTAÇÃO TÉCNICA

### **1. CAMPO DE BUSCA (HTML):**

```html
<div class="form-group">
    <label>Cliente:</label>
    <div class="input-group">
        <input type="text" 
               id="cliente_busca" 
               class="form-control" 
               placeholder="Digite o nome do cliente..."
               onkeyup="buscarCliente()">
        
        <button type="button" 
                class="btn btn-success" 
                onclick="abrirCadastroCliente()">
            <i class="fas fa-plus"></i> Novo Cliente
        </button>
    </div>
    
    <div id="cliente_resultados" class="autocomplete-results"></div>
</div>

<input type="hidden" id="cliente_id">
```

---

### **2. BUSCA AUTOMÁTICA (JavaScript):**

```javascript
function buscarCliente() {
    const nome = document.getElementById('cliente_busca').value;
    
    if (nome.length >= 3) {
        fetch(`/api/clientes/buscar?nome=${encodeURIComponent(nome)}`)
            .then(response => response.json())
            .then(clientes => {
                mostrarResultados(clientes);
            });
    }
}

function mostrarResultados(clientes) {
    const div = document.getElementById('cliente_resultados');
    div.innerHTML = '';
    
    clientes.forEach(cliente => {
        div.innerHTML += `
            <div class="cliente-item" onclick="selecionarCliente(${cliente.id})">
                <strong>${cliente.nome}</strong><br>
                <small>${cliente.telefone} - ${cliente.email}</small>
            </div>
        `;
    });
}

function selecionarCliente(id) {
    document.getElementById('cliente_id').value = id;
    document.getElementById('cliente_resultados').innerHTML = '';
}

function abrirCadastroCliente() {
    window.open('/clientes/cadastro', '_blank', 'width=800,height=600');
}
```

---

### **3. API DE BUSCA (PHP):**

```php
// /api/clientes/buscar.php
<?php
require_once '../includes/config.php';

$nome = $_GET['nome'] ?? '';

if (strlen($nome) < 3) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, nome, cpf_cnpj, telefone, email 
        FROM clientes.clientes 
        WHERE nome ILIKE '%$nome%' 
        ORDER BY nome 
        LIMIT 10";

$result = pg_query($conn, $sql);
$clientes = pg_fetch_all($result);

echo json_encode($clientes ?? []);
?>
```

---

### **4. CADASTRO RÁPIDO (MODAL):**

```html
<!-- Modal de Cadastro Rápido -->
<div id="modalCadastroCliente" class="modal">
    <div class="modal-content">
        <h2>Novo Cliente</h2>
        
        <form id="formCadastroCliente">
            <label>Nome:</label>
            <input type="text" id="novo_cliente_nome" required>
            
            <label>Telefone:</label>
            <input type="tel" id="novo_cliente_telefone" required>
            
            <label>Email:</label>
            <input type="email" id="novo_cliente_email">
            
            <label>CPF/CNPJ:</label>
            <input type="text" id="novo_cliente_documento">
            
            <button type="submit" class="btn btn-primary">
                Finalizar e Voltar para OS
            </button>
        </form>
    </div>
</div>
```

---

### **5. FINALIZAR CADASTRO (JavaScript):**

```javascript
document.getElementById('formCadastroCliente').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const cliente = {
        nome: document.getElementById('novo_cliente_nome').value,
        telefone: document.getElementById('novo_cliente_telefone').value,
        email: document.getElementById('novo_cliente_email').value,
        cpf_cnpj: document.getElementById('novo_cliente_documento').value
    };
    
    fetch('/api/clientes/criar', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(cliente)
    })
    .then(response => response.json())
    .then(novoCliente => {
        // Preenche campos na OS
        document.getElementById('cliente_id').value = novoCliente.id;
        document.getElementById('cliente_busca').value = novoCliente.nome;
        
        // Fecha modal
        document.getElementById('modalCadastroCliente').style.display = 'none';
        
        // Foca no próximo campo
        document.getElementById('equipamento').focus();
        
        alert('Cliente cadastrado com sucesso!');
    });
});
```

---

## 📂 ARQUIVOS NECESSÁRIOS

| Arquivo | Ação | Status |
|---------|------|--------|
| `/var/www/html/os/nova.php` | Modificar | ⏳ Pendente |
| `/var/www/html/api/clientes/buscar.php` | Criar | ⏳ Pendente |
| `/var/www/html/api/clientes/criar.php` | Criar | ⏳ Pendente |
| `/var/www/html/clientes/cadastro.php` | Verificar | ⏳ Pendente |
| `/var/www/html/js/os-cliente.js` | Criar | ⏳ Pendente |
| `/var/www/html/css/autocomplete.css` | Criar | ⏳ Pendente |

---

## 🗄️ BANCO DE DADOS

### **Tabelas Envolvidas:**

```sql
-- clientes.clientes (já existe)
CREATE TABLE clientes.clientes (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf_cnpj VARCHAR(20),
    email VARCHAR(255),
    telefone VARCHAR(20),
    endereco TEXT,
    tipo VARCHAR(20) DEFAULT 'PF',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- os.ordens_servico (já existe)
CREATE TABLE os.ordens_servico (
    id SERIAL PRIMARY KEY,
    cliente_id INTEGER REFERENCES clientes.clientes(id),
    numero_os VARCHAR(20) UNIQUE NOT NULL,
    status VARCHAR(50) DEFAULT 'aberta',
    equipamento VARCHAR(255),
    defeito_relatado TEXT,
    servico_realizado TEXT,
    valor_pecas DECIMAL(10,2),
    valor_mao_obra DECIMAL(10,2),
    valor_total DECIMAL(10,2),
    data_entrada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_saida TIMESTAMP,
    tecnico_responsavel VARCHAR(255),
    observacoes TEXT
);
```

---

## ✅ CRITÉRIOS DE ACEITE

- [ ] Busca funciona com 3+ caracteres
- [ ] Autocomplete mostra até 10 resultados
- [ ] Selecionar cliente preenche campos automaticamente
- [ ] Botão "Novo Cliente" abre modal/aba
- [ ] Cadastro rápido tem apenas campos essenciais
- [ ] Após cadastrar, volta para OS automaticamente
- [ ] Dados do novo cliente já preenchidos na OS
- [ ] Funciona em mobile (responsivo)

---

## 🚧 STATUS ATUAL

**Infraestrutura:**
- CT 103 (PostgreSQL): ❌ OFFLINE
- CT 104 (Web Server): ❌ OFFLINE

**Ação necessária:**
1. Acib precisa corrigir IPs dos containers no Proxmox
2. Após containers online, implementar melhoria

**Previsão:** Assim que infraestrutura for restaurada

---

## 📝 HISTÓRICO

| Data | Evento |
|------|--------|
| 09/04/2026 14:57 | Acib solicitou melhoria |
| 09/04/2026 14:57 | Documento criado |
| 09/04/2026 15:00 | Aguardando infraestrutura |

---

**Próxima ação:** Aguardar Acib corrigir IPs dos containers no Proxmox
