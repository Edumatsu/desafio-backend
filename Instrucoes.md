# Desafio desenvolvedor backend

O API foi desenvolvido para retornar apenas requisições GET no script index.php
Ex: ```http://localhost/index.php```
Toda chamada irá recalcular a pontuação de assertividade e prioridade, e guardará no arquivo tickets.json (se a constante "SAVE_JSON_FILE" estiver habilitada, no arquivo constants.php).

# Parâmetros para chamada de API:
### order_by
- Método de ordenação baseado no atributo
- Não possui valor padrão, caso deixado em branco retornará os tickets na ordem que vieram do arquivo.
- Pode ser:
    - priority
    - datecreate
    - dateupdate

### sort_by
- Método de ordenação crescente ou decrescente.
- Por padrão, é ascendente (asc).
- Pode ser:
    - asc
    - desc

### min_date
- Variável de filtro de mínima data de criação.
- Não possui valor padrão.
- Deve ser inserido em formato de data YYYY-mm-dd, dividido por "/" ou "-".
    - 2017-12-20
    - 2017/12/20

### max_date
- Variável de filtro de máxima data de criação.
- Não possui valor padrão.
- Deve ser inserido em formato de data YYYY-mm-dd, dividido por "/" ou "-".
    - 2017-12-20
    - 2017/12/20

### priority
- Filtragem por prioridade
- Não possui valor padrão
- Deve ser 'High' ou 'Normal'.

### page
- Paginação do script.
- Por padrão, cada página possui 5 tickets (pode ser alterado em constants.php)
- Por padrão, caso não informado, a página exibida é a primeira.
- Deve ser informado um numero natural maior que 0.

# Exemplo de chamadas de API
### Filtrar por prioridade, ordenada por data de criação decrescente, 2º página:
```http://localhost/index.php?priority=high&order_by=datecreate&sort_by=desc&page=2```

# Tecnologias utilizadas
- PHP 5.6.36
- Apache 2

# Observações
- Para realizar uma atualização do tickets.json, ative a flag "SAVE_JSON_FILE" no arquivo constants.php.
    - IMPORTANTE: O arquivo precisa ter permissões para escrita.
- A lista de palavras relacionadas a tickets positivos (bom humor) e negativos (mal humor) estão armazenadas no arquivo constants.php e foram extraídos de bases de dados disponíveis nas referências abaixo:
    - https://www.reclameaqui.com.br/

# Autor
Victor Monteiro Cunha