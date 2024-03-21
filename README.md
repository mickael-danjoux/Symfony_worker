# Symfony Messenger

Project to test symfony messenger with worker.


### Start project

``` shell
docker compose up -d
symfony serve
```
Async messages worker is automatically start with symfony server in `.symfony.local.yaml`

### Stop project
``` shell
docker compose down
symfony server:stop
```
