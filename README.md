Never Code Alone
================

Initiative für Software Qualität

Application
-----------

... application stuff ...

Development
-----------

## Getting started

To get a running local environment there are a few steps which need to be taken care of.

1. Copy the `.env.dist` file to `.env` .
1. Run `docker-compose -f docker-compose.local.yml up --build -d` .
1. Connect to the web container and initialize the database.
    ```
    docker exec -it nca_web_1 bash
    root@d2694b48518b:/var/www/html# bin/console doctrine:schema:create
    ```

Afterwards you can connect to the application on http://localhost:8080.

### Using xdebug

Xdebug is configured to try to connect a remote debugger instead of waiting for a connection from a debugger since the ip address of the docker container can change with every deployment. Read more about the setup [here](https://blog.flavia-it.de/xdebug-im-docker-container/).

### Working on the database

If you want to work with the database the easiest way is to connect to adminer on http://localhost:8081 and login to the database with **nca** as username, password and database. If you want to directly connect to the database with your own tools you can reach the database port on `localhost:33006` .

Structure
---------

The application stack consists of 2 services: the webserver containing the application (called **web**) and the database holding the data (called **db**). When the application is deployed it is configured by labels so the **traefik** proxy can forward incoming http requests on port 80 and 443 of the container host to the web container.

Testing
-------

When the stack is run for testing the `docker-compose.dev.yml` file needs to be appended to the normal `docker-compose.yml` file to enable port forwarding to the network interface of the container host. This way the host running the tests can connect to the database from outside and run the database tests.

For the website tests a [zalenium](http://opensource.zalando.com/zalenium/) (self managing selenium stack) is hosted typically on the development container host which can reach the http(s) traefik endpoint of the deployed development stack.

### Branches

Usually a branch gets deployed to the address https://<branch-name>.develop.nevercodealone.de which can be visited and tested against after the deployment job has been succeeded. The database is not initialized after deployment so this is up to the developer. You can see how to do this in the ci test job.

### Master

The master branch works a bit different since it needs to test how the application behaves after an container upgrade (branch deployments are purged and redeployed on every test run). This includes filesystem and database migrations. For this to work a new stack is created (cloned) from the production stack which will then be upgraded to the latest version with the tag **master**.

