CREATE USER test_user WITH PASSWORD 'secret' CREATEDB;
CREATE DATABASE laravel_testing WITH OWNER = test_user;
