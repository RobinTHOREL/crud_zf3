# crud_zf3

Run

`cd crud_zf3`

`docker-compose up -d`

`docker-compose run --rm zf composer install`

`docker-compose run --rm zf vendor/bin/doctrine-module orm:info` 

`docker-compose run --rm zf vendor/bin/doctrine-module orm:schema-tool:update --dump-sql`

`docker-compose run --rm zf php vendor/bin/doctrine-module orm:schema-tool:update --force`

`docker-compose run --rm zf php vendor/bin/doctrine-module orm:validate-schema`