# Sistema de Gerenciamento de Tarefas — CodeIgniter 4

Aplicação web simples para gerenciamento de tarefas, desenvolvida em **PHP** com o framework **CodeIgniter 4**. Também disponibiliza uma **API REST**.

## Funcionalidades

- Cadastrar tarefa (título, descrição e status: `pendente`, `em_andamento`, `concluida`)
- Listar todas as tarefas
- Editar tarefa existente
- Excluir tarefa
- Validação de formulários (server-side)
- Proteção contra CSRF e SQL Injection
- API REST para as mesmas operações (`/api/tasks`)

## Requisitos

Antes de começar, você precisa ter instalado:

- PHP >= 8.1
- Composer
- MySQL ou PostgreSQL
- Extensões PHP: `intl`, `mysqli` (ou `pgsql`), `json`

## 1. Clonar o repositório

```bash
git clone <url-do-repositorio>
cd <nome-da-pasta-do-projeto>
```

## 2. Instalar as dependências

```bash
composer install
```

## 3. Configurar variáveis de ambiente

Copie o arquivo de exemplo `env` e ajuste as configurações:

```bash
cp env .env
```

Edite o arquivo `.env` e configure (Remova o "#" para descomentar):

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = task_organizer
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

> Se estiver usando PostgreSQL, altere `DBDriver` para `Postgre` e ajuste a porta para `5432`.

## 4. Criar o banco de dados

Crie um banco de dados vazio (o nome deve ser igual ao definido em `database.default.database` no `.env`):

```sql
CREATE DATABASE task_organizer;
```

## 5. Rodar as migrations

A tabela `tasks` é criada automaticamente através da migration incluída no projeto:

```bash
php spark migrate
```

Isso criará a tabela `tasks` e alguns mocks com os campos: `id`, `title`, `description`, `status`, `created_at` e `updated_at`.

## 6. Assets (Bootstrap)

As views utilizam arquivos locais do Bootstrap, referenciados em `public/assets/bootstrap/`:

```
public/assets/bootstrap/bootstrap.min.css
public/assets/bootstrap/bootstrap.bundle.min.js
```

## 7. Executar a aplicação

Para rodar o servidor de desenvolvimento embutido do CodeIgniter:

```bash
php spark serve
```

A aplicação estará disponível em:

```
http://localhost:8080
```

## Rotas da aplicação (Web)

| Método | Rota            | Ação                          |
|--------|-----------------|-------------------------------|
| GET    | `/`             | Lista todas as tarefas        |
| GET    | `/create`       | Formulário de nova tarefa     |
| POST   | `/submit`       | Salva uma nova tarefa         |
| GET    | `/edit/{id}`    | Formulário de edição          |
| POST   | `/update/{id}`  | Atualiza uma tarefa           |
| GET    | `/delete/{id}`  | Exclui uma tarefa             |

## Rotas da API REST

Todas as rotas abaixo estão sob o prefixo `/api` e retornam JSON. Elas são isentas do filtro CSRF.

| Método | Rota              | Ação                          |
|--------|-------------------|-------------------------------|
| GET    | `/api/tasks`      | Lista todas as tarefas        |
| GET    | `/api/tasks/{id}` | Busca uma tarefa por ID       |
| POST   | `/api/tasks`      | Cria uma nova tarefa          |
| PUT    | `/api/tasks/{id}` | Atualiza uma tarefa existente |
| DELETE | `/api/tasks/{id}` | Exclui uma tarefa             |

### Exemplo de payload (POST/PUT)

```json
{
    "title": "Estudar CodeIgniter",
    "description": "Revisar documentação oficial",
    "status": "em_andamento"
}
```

`status` aceita apenas: `pendente`, `em_andamento` ou `concluida`.

### Testando a API com Postman

1. Abra o Postman e crie uma nova **Collection** (ex.: `Task Organizer API`), ou utilize a **Collection** pronta na pasta `postman/`.
2. Crie uma requisição para cada rota, conforme a tabela abaixo:

| Nome da requisição   | Método | URL                                   |
|----------------------|--------|---------------------------------------|
| Listar tarefas       | GET    | `http://localhost:8080/api/tasks`     |
| Buscar tarefa por ID | GET    | `http://localhost:8080/api/tasks/1`   |
| Criar tarefa         | POST   | `http://localhost:8080/api/tasks`     |
| Atualizar tarefa     | PUT    | `http://localhost:8080/api/tasks/1`   |
| Excluir tarefa       | DELETE | `http://localhost:8080/api/tasks/1`   |

3. Para as requisições **POST** e **PUT**:
   - Vá na aba **Body**.
   - Selecione a opção **raw**.
   - No dropdown à direita, selecione **JSON**.
   - Cole o payload de exemplo:

```json
{
    "title": "Nova tarefa",
    "description": "Descrição da tarefa",
    "status": "pendente"
}
```

4. Clique em **Send** e verifique a resposta:
   - `GET /api/tasks` → retorna todas as tarefas.
   - `GET /api/tasks/{id}` → retorna a tarefa correspondente ou erro 404 caso não exista.
   - `POST /api/tasks` → retorna a tarefa criada com status `201 Created`.
   - `PUT /api/tasks/{id}` → retorna a tarefa atualizada.
   - `DELETE /api/tasks/{id}` → retorna confirmação de exclusão.

## Estrutura do projeto

```
app/
├── Config/
│   ├── Routes.php        # Definição das rotas web e API
│   └── Filters.php       # Filtros (CSRF isento para /api/*)
├── Controllers/
│   ├── TaskController.php        # CRUD via views (web)
│   └── Api/
│       └── TaskController.php    # API REST
├── Models/
│   └── TaskModel.php     # Query Builder / Active Record
├── Database/
│   └── Migrations/
│       └── ..._CreateTasksTable.php
└── Views/
    ├── layout/
    │   └── main_layout.php
    └── tasks/
        ├── index.php
        ├── create.php
        └── edit.php
postman/
└── Task_Organizer.postman_collection.json   # Collection pronta para testar a API
```

## Segurança

- **CSRF**: habilitado globalmente para as rotas web, com exceção de `api/*` (necessário para chamadas de API sem token de formulário).
- **SQL Injection**: todas as consultas ao banco são feitas via Query Builder / Active Record do CodeIgniter, que utiliza binding de parâmetros.
- **Validação**: título obrigatório (máx. 255 caracteres) e status restrito à lista `pendente`, `em_andamento`, `concluida`, tanto no formulário web quanto na API.

## Observações

- Os status são armazenados sem acentos e com underscore (`em_andamento`, `concluida`) para evitar problemas de encoding em comparações e URLs, embora sejam exibidos formatados na interface.