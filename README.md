#Lavravel kensyu

#Install docker
https://docs.docker.com/get-docker/

#Setup and run project

Then, run command to install and setup enviroment:
```sh
docker-compose up -d
```
The -d flag daemonizes the process, running your containers in the background.

After that, run command to generate key and migrate database:
```sh
docker-compose exec app bash
cd webapp
```
Make a copy of the .env.example file that Laravel includes by default and name the copy .env, which is the file Laravel expects to define its environment:
```sh
cp .env.example .env
```
Open .env file and modify the following fields, example:
- DB_DATABASE: test_db
- DB_PASSWORD: root

Generate key and migrate:
```sh
php artisan generate:key
php artisan migrate
```

Open browser and access to: http://localhost:8000

#PHPUnit - test all 
 ```sh
docker-compose exec app bash
cd webapp
vendor/bin/phpunit OR composer test
```
