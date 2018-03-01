Never Code Alone
================

Initiative für Software Qualität

Wir machen gerade ein Symfony Update

Dev-Environment:

1) `docker-compose -p nca -f etc/infrastructure/dev/docker-compose.yml pull`
2) `docker-compose -p nca -f etc/infrastructure/dev/docker-compose.yml build`
3) `docker-compose -p nca -f etc/infrastructure/dev/docker-compose.yml up -d`

Danach laufen die notwendigen Container und wir können uns in den PHP-Container einloggen per:
`docker exec -it nca_phpfpm_1 bash`

Als erstes sollte man nun `composer install` ausführen