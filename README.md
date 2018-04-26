Never Code Alone
================

Initiative für Software Qualität

Getting started
---------------

Um einen kompletten Webseitenstack aufzusetzen wird im Rootverzeichnis des Repositories `docker-compose -p nca up -d` eingegeben. Nachdem der Stack aufgesetzt ist, kann man die Webseite unter **http://localhost:8080** erreichen. Um die komplette Testsuite auszuführen verbindet man sich mit `docker exec -it nca_codeception_1 bash` auf den Codeception Container. Innerhalb des Containers führt man `codecept build` und `codecept run -vvv` ein.

Projektaufbau
-------------

### Komponenten

* Webserver (nca_server_1)
* Datenbank (nca_db_1)
* WebDriver (nca_chrome_1, nca_firefox_1 and nca_hub_1)
* Codeception (nca_codeception_1)

### Erklärung

Die eigentliche Webseite befindet sich im **nca_server_1** container. Also basis für diesen Container wird das Image aus dem Projekt **nevercodealone/docker-webserver** genutzt. Vor jedem Deployment wird das Webserver Image mit dem aktuellen `HEAD` des Branches gebaut. Das gebaute Image wird dann auf den Rancher erzeugt, zusammen mit dem Datenbank Container (siehe dazu die `docker-compose-ci.yml` für mehr Informationen). Die Webseite ist dann unter der URL **http://{branch-name}.develop.nevercodealone.de** erreichbar.

Die WebDriver und der Codeception Container werden nur bei lokalem Deployment erzeugt (siehe `docker-compose.yml`). Für das Deployment innerhalb der Gitlab-Ci Infrastruktur gibt es einen zentralen WebDriver Container. Das Codeception Image wird vom Gitlab-Ci-Runner benutzt um die Tests innerhalb Gitlab gegen den frisch erzeugten Webserver Container im Rancher zu fahren. Nachdem die Tests abgeschlossen sind, werden die Ergebisse in einem Container im Rancher ausgerollt. Die Ergebnisse sind dann unter **http://output.{branch-name}.develop.nevercodealone.de** einsehbar.

Vor jedem neuen Deployment, nach dem Bau des Webserver-Images, wird die Rancher Umgebung für den Branch gelöscht, damit das neue Deployment in eine saubere Umgebung ausgerollt werden kann.

Der Codeception Container basiert auf dem Image aus **nevercodealone/docker-codeception**.

#### Stack Visualisierung

                                                +-------------+
                                                |             |
                                                |             |
                                                |  WebDriver  |
      +-------------+      +-------------+      |  Chrome     |
      |             |      |             | <----+             |
      |             |      |             |      +-------------+
      |  Datenbank  | <----+  Webserver  |
      |             |      |             |      +-------------+
      |             |      |             | <----+             |
      +-------------+      +-------------+      |             |
                                  ^             |  WebDriver  |
                                  |             |  Firefox    |
                                  |             |             |
                                  |             +-------------+
                                  |                    ^
                                  |                    |
                           +-------------+      +-------------+
                           |             |      |             |
                           |             |      |             |
                           | Codeception +----> |  WebDriver  |
                           |             |      |  Hub        |
                           |             |      |             |
                           +-------------+      +-------------+
