Never Code Alone
================

Initiative für Software Qualität

Getting started
---------------

Um einen kompletten Webseitenstack lokal aufzusetzen, führe im Wurzelverzeichnis des Repositories docker-compose mit der Datei `docker-compose-local.yml` aus. Dabei ist zu beachten, dass docker-compose die Umgebungsvariable `DOCKER_IMAGE` benötigt um den Stack zu starten. Um alle Images aus der Container Registry laden zu können, stell sicher, dass du in die Registry eingeloggt bist.

    docker login registry.nevercodealone.de
    DOCKER_IMAGE=registry.nevercodealone.de/nevercodealone/nevercodealone:{branch-name} docker-compose -f docker-compose-local.yml -p nca up -d

Nachdem der Stack aufgesetzt ist, findest du die Webseite unter **http://localhost:8080**. Um die komplette Testsuite auszuführen verbinde dich  mit der Toolbox und führe die Tests als Benutzer `www-data` aus.

    docker exec -it nca_toolbox_1 bash
    su - www-data
    cd ./symfony
    vendor/bin/codecept run acceptance

Fehler im Webserver kannst du mittels `docker logs -f nca_server_1` ansehen.

Projektaufbau
-------------

### Komponenten

* Webserver (nca_server_1)
* Datenbank (nca_db_1)
* Toolbox (nca_toolbox_1)
* WebDriver [nur lokal] (nca_selenium_1)

### Erklärung

Die eigentliche Webseite befindet sich im **nca_server_1** container. Als Basis für diesen Container wird das Image aus dem Projekt **nevercodealone/docker-webserver** genutzt. Vor jedem Deployment wird das Webserver Image mit dem aktuellen `HEAD` des Branches gebaut. Das gebaute Image wird dann auf den Rancher deployed, zusammen mit dem Datenbank und dem Toolbox Container (siehe dazu die `docker-compose.yml` für mehr Informationen). Die Webseite ist dann unter der URL **http://{branch-name}.develop.nevercodealone.de** erreichbar.

Der WebDriver Container wird nur bei lokalen Tests erzeugt (siehe `docker-compose-local.yml`). Nachdem die Tests abgeschlossen sind, werden die Ergebisse in einem Container im Rancher ausgerollt. Die Ergebnisse sind dann unter **http://output.{branch-name}.develop.nevercodealone.de** einsehbar.

Vor jedem neuen Deployment, nach dem Bau des Webserver-Images, wird die Rancher Umgebung für den Branch gelöscht, damit das neue Deployment in eine saubere Umgebung ausgerollt werden kann.
