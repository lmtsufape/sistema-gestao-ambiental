# Sistema de Gestão Ambiental - Prefeitura de Garanhuns, PE

Este projeto é um sistema dedicado a gerenciar todos os requerimentos ambientais da Prefeitura de Garanhuns, Pernambuco. Foi desenvolvido pelo Laboratório Multidisciplinar de Tecnologias Sociais com o objetivo de otimizar e organizar os processos relacionados à gestão ambiental do município.

## Configuração e Instalação com Docker

A utilização do Docker facilita a configuração, instalação e execução do sistema em qualquer ambiente de desenvolvimento ou produção. Abaixo estão listados os passos para a configuração inicial do ambiente Docker para o projeto:

### Pré-requisitos

- Docker: Instale o Docker seguindo as instruções na [documentação oficial](https://docs.docker.com/engine/install/ubuntu/).
- Docker Compose: Instale o Docker Compose seguindo as instruções na [documentação oficial](https://docs.docker.com/compose/install/).

### Configuração do Ambiente

1. **Clone o Repositório:** Clone o repositório do projeto para o seu ambiente local.
    ```bash
    git clone URL_DO_REPOSITORIO
    cd DIRETORIO_DO_PROJETO
    ```

2. **Build do Docker:** Build das imagens Docker especificadas no `Dockerfile` e `docker-compose.yml`.
    ```bash
    docker-compose build
    ```

3. **Inicialização do Ambiente:** Inicialize os containers Docker.
    ```bash
    docker-compose up -d
    ```

4. **Instalação de Dependências:** Instale as dependências necessárias via Composer.
    ```bash
    docker-compose exec app composer install
    ```

5. **Configuração do Laravel:** Copie o arquivo de configuração de exemplo e gere a chave de aplicativo.
    ```bash
    cp .env.example .env
    docker-compose exec app php artisan key:generate
    ```

6. **Migrações e Seeds:** Execute as migrações e seeds para configurar o banco de dados.
    ```bash
    docker-compose exec app php artisan migrate --seed
    ```

7. **Permissões de Diretório:** Altere as permissões do diretório de armazenamento e bootstrap para o Laravel poder funcionar corretamente.
    ```bash
    docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
    ```

8. **Acesso:** Acesse o sistema via navegador na URL [http://localhost:8080](http://localhost:8080).

## Contribuição

Para contribuir com o projeto, por favor, siga as [diretrizes de contribuição](CONTRIBUTING.md) e o [código de conduta](CODE_OF_CONDUCT.md).
