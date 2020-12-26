FROM mariadb:10.4

COPY /cfg/my.cnf /etc/mysql/my.cnf

COPY ./setup/setup.sql /docker-entrypoint-initdb.d/

EXPOSE 3306