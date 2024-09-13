# Nome do Projeto

## Descrição

Este projeto utiliza Docker e GitHub Actions para automatizar o deployment em uma instância EC2.

## Como Começar

1. **Clone o repositório:**

    ```bash
    git clone https://github.com/seuusuario/seurepositorio.git
    ```

2. **Navegue para o diretório do projeto:**

    ```bash
    cd seu-repositorio
    ```

3. **Construa e inicie os containers Docker:**

    ```bash
    docker-compose up --build
    ```

4. **Acesse a aplicação:**

    - A aplicação PHP estará disponível em `http://localhost`
    - A aplicação Node.js estará disponível em `http://localhost:3000`

## Variáveis de Ambiente

Crie um arquivo `.env` na raiz do projeto e defina as seguintes variáveis:

```env
DB_HOST=localhost
DB_USER=root
DB_PASS=secret
PORT=3000
