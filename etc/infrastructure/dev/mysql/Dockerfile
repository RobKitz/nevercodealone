FROM mysql:5.7.18

ADD ./conf/my.cnf /etc/mysql/mysql.conf.d/my.cnf
ADD init.sql /docker-entrypoint-initdb.d/

EXPOSE 3306
