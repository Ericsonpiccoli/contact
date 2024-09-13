# Nome do Projeto

## Descrição

Este projeto utiliza Docker e GitHub Actions para automatizar o deployment em uma instância EC2.

## Como Começar

1. **Clone o repositório:**

    Com a GitHub CLI:
    ```bash
    gh repo clone Ericsonpiccoli/contact
    ```

    Ou usando Git:
    ```bash
    git clone git@github.com:Ericsonpiccoli/contact.git
    ```

2. **Navegue para o diretório do projeto:**

    ```bash
    cd contact
    ```

3. **Construa e inicie os containers Docker:**

    ```bash
    docker-compose up --build
    ```

4. **Acesse a aplicação:**

    - A aplicação PHP estará disponível em [http://localhost](http://localhost)
    - A aplicação Node.js estará disponível em [http://localhost:3000](http://localhost:3000)

## Variáveis de Ambiente

Crie um arquivo `.env` na raiz do projeto e defina as seguintes variáveis:

```env
DB_HOST=localhost
DB_USER=root
DB_PASS=secret
PORT=3000
