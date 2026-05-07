# 🚨 ERRO SQL - PORTAL DE NEGÓCIOS PREFEITURA

**Data do Erro:** 07/05/2026 00:17 GMT-3  
**Projeto:** Portal de Negócios - Jacareí/SP  
**URL:** http://portaldenegocios.jacarei.sp.gov.br/dashboard  
**Chat ID:** telegram:1866226415  
**Message ID:** 17457  
**Sender:** Acib ABBADE (1866226415)

---

## 📊 DETALHES DO ERRO

### Exception
```
Illuminate\Database\QueryException
SQLSTATE[42703]: Undefined column: 7 
ERROR: column "product_id" does not exist 
LINE 1: select "product_id" from "purchases" 
HINT: Perhaps you meant to reference the column "purchases.product_ids".
```

### Query Problemática
```sql
select "product_id" from "purchases"
```

### Raw Sql
```
select "product_id" from "purchases"
```

---

## 🏗️ AMBIENTE

| Campo | Valor |
|-------|-------|
| **PHP Version** | 8.3.6 |
| **Laravel Version** | 10.48.29 |
| **Laravel Locale** | en |
| **Laravel Config Cached** | true |
| **App Debug** | true |
| **App Env** | local |
| **Database** | PostgreSQL |

---

## 👤 USUÁRIO AFETADO

```json
{
  "id": 275,
  "name": "Acib Abbade",
  "email": "acibabbade@gmail.com",
  "current_team_id": 277,
  "company_type": "mei",
  "administrator": false
}
```

---

## 📍 LOCAL DO ERRO

### Stack Trace
```
App\Http\Middleware\CheckCnpj:29 → handle
App\Routing\RouteFileRegistrar:3 → {closure}
Illuminate\Routing\Controller:closure
```

### Código Problemático (Closure)
```php
// 1. Puxamos as compras uma única vez (Filtro Ninja!)
$purchases = \App\Models\Purchase::select('product_id')->get();

// 2. Tiramos o .purchases do load()
$currentTeam = \auth()->user()?->currentTeam?->load(['products', 'sector']);

// 3. Tiramos o .purchases do with() e calculamos na mão
$teams = \App\Models\Team::with(['products', 'sector'])->get()->map(function ($team) use ($purchases) {
    $products = $team->products->map(function ($product) use ($purchases) {
        $salesTotal = $purchases->filter(function ($purchase) use ($product) {
            $ids = \is_string($purchase->product_ids)
                ? \json_decode($purchase->product_ids, true)
                : (array) $purchase->product_ids;

            if (!\is_array($ids) || empty($ids)) {
                return false;
            }

            return \in_array($product->id, $ids);
        })->count();

        return [
            'name' => $product->name,
            'sales_total' => $salesTotal,
        ];
    });
```

---

## 🔍 DIAGNÓSTICO

### Problema
A coluna na tabela `purchases` se chama **`product_ids`** (plural, JSON array), mas o código está tentando acessar **`product_id`** (singular).

### Causa
Inconsistência entre:
1. **Model/Database:** Coluna `product_ids` (JSON/array)
2. **Código:** Tentando acessar `product_id` (singular)

### Contexto
O código parece estar em refatoração/migração:
- Comentários mencionam "Filtro Ninja"
- Há lógica para lidar com JSON (`json_decode`)
- Parece que houve mudança de `product_id` (singular) para `product_ids` (array/múltiplos)

---

## ✅ SOLUÇÃO

### Opção 1: Corrigir o Select (Recomendado)

```php
// ONDE ESTÁ (ERRADO):
$purchases = \App\Models\Purchase::select('product_id')->get();

// COMO DEVERIA FICAR (CORRETO):
$purchases = \App\Models\Purchase::select('id', 'product_ids')->get();
```

### Opção 2: Remover o Select Desnecessário

Se o código não usa diretamente `$purchases`, talvez nem precise do select:

```php
// Se for só para filtrar depois:
$purchases = \App\Models\Purchase::all();
```

### Opção 3: Verificar Migration

Criar migration para adicionar coluna `product_id` se for necessário:

```bash
php artisan make:migration add_product_id_to_purchases_table
```

```php
// Emigration
public function up()
{
    Schema::table('purchases', function (Blueprint $table) {
        $table->foreignId('product_id')->nullable()->constrained();
    });
}
```

---

## 📝 ARQUIVOS PARA VERIFICAR

| Arquivo | Ação |
|---------|------|
| `app/Models/Purchase.php` | Verificar $fillable e casts |
| `database/migrations/*_create_purchases_table.php` | Verificar schema |
| `app/Http/Controllers/DashboardController.php` | Corrigir select |
| `routes/web.php` | Verificar route `dashboard` |

---

## 🐛 QUERIES EXECUTADAS (LOG)

| Tempo | Query |
|-------|-------|
| 38.89ms | `select * from "sessions" where "id" = ?` |
| 1.53ms | `select * from "users" where "id" = 275` |
| 1.41ms | `select * from "notifications" where "notifiable_type" = ?` |
| 1.15ms | `select exists(select * from "oficinas" where "status" in (?, ?))` |

---

## 🎯 AÇÕES RECOMENDADAS

### Imediato
- [ ] Corrigir `select('product_id')` para `select('id', 'product_ids')`
- [ ] Testar dashboard após correção
- [ ] Verificar se há outros lugares com mesmo erro

### Longo Prazo
- [ ] Padronizar nomenclatura (sempre plural ou singular)
- [ ] Adicionar testes para evitar regressão
- [ ] Documentar schema da tabela `purchases`

---

## 📌 NOTAS

- **Ambiente:** Local (App Env: local, App Debug: true)
- **Debug habilitado:** Mostrar detalhes completos do erro
- **Impacto:** Dashboard não carrega para usuário
- **Prioridade:** 🔴 Alta (afeta funcionalidade principal)

---

**Arquivo criado:** 07/05/2026 00:17 GMT-3  
**Local:** `/root/.openclaw/workspace/projetos/portal-negocios/erro_sql_prefeitura.md`

---

*Stark - Erro documentado para correção!* 🤖
