# docker-laravel-handson
Based on https://qiita.com/ucan-lab/items/56c9dc3cf2e6762672f4

### Make sure with phpinfo.php
```
[mac] $ echo "<?php phpinfo();" > backend/public/phpinfo.php
```

### How to create a new project
0. Remove .git
```
$ rm -rf .git
```

1. Set up .env for docker-compose.yml.
```
$ cp .env.template .env
Add NGROK_AUTH key
```

2. Create laravel project
```
$ make create-project
```

3. Set up ./backend/.env.example
```
# This is default set up for DB based on ./.env.template.
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_local
DB_USERNAME=phper
DB_PASSWORD=secret
```

4. Initialization
```
$ make init
```

5. Install Packages
```
# composer packages
$ make install-recommend-packages
```

```js:backend/package.json
    "scripts": {
        "dev": "vite --host",
        "build": "vite build"
    },
```

6. Make sure
```
# Web server
$ open http://localhost:8080/

# Schemaspy. if you can not see it, run this command $make chemaspy
$ open http://localhost:8081/

# Php my admin
$ open http://localhost:8888/

# Ngrok
$ open http://localhost:4040/
```




### Docker Command
```
# build
$ docker-compose up -d --build

# down
$ docker-compose down
```

### Into to container
```
# app server
$ docker-compose exec app bash

# node server
$ docker-compose exec node ash

# db server
$ docker-compose exec db bash
```

### Output server log
```
# log for laravel
$ docker-compose logs

# specific service
$ docker-compose logs -f app

# schemaspy service
$ docker-compose logs schemaspy
```


### Connect to database management application
![image](https://user-images.githubusercontent.com/20104403/114467672-3b724680-9c25-11eb-97e3-b868b9c0cf09.png)

### FYI
```
# If you see memory limit error to composer install or using require, Raise the upper limit
$ php -d memory_limit=-1 /usr/bin/composer install
$ php -d memory_limit=-1 /usr/bin/composer require << PACKAGE >>

# You got conflict of package
$ composer install --ignore-platform-reqs
$ composer update --ignore-platform-reqs

# If you want to remove <none> images
$ docker image prune

# If you want to make sure .evn file for docker-compose.yml is working or not
$ docker-compose config
```

### Ruine the world
```
$  docker-compose down --rmi all --volumes --remove-orphans 
```

### localhosts
```
web server: http://localhost:8080/
ngrok:      http://localhost:4040/
schemaspy:  http://localhost:8081/
```
