#!/bin/sh

echo >> laradock/.env
echo "MYSQL_VERSION=5.7" >> laradock/.env
echo "MYSQL_DATABASE=laravel" >> laradock/.env
echo "MYSQL_USER=admin" >> laradock/.env
echo "MYSQL_PASSWORD=root" >> laradock/.env
echo >> laradock/mysql/my.cnf
echo "default_authentication_plugin=mysql_native_password" >> laradock/mysql/my.cnf

cp createdb.sql laradock/mysql/docker-entrypoint-initdb.d/

cd laradock && docker-compose up -d nginx mysql workspace