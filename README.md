# AFTERCLASSE API 

Test

## Setup general
1. Architecure
    - Php 7.1
    - MySql (pgsql is better)
    - Node/NPM version > 7
    - Composer
        - installation if needed :
        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
        php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
        php composer-setup.php
        php -r "unlink('composer-setup.php');"
2. Composer dependencies
    - `$ php composer.phar install`
3. Node dependencies
    - `$ npm install`

## Setup dev
1. require Setup general
2. Create `afterclass.local`
2.1 create virtual host that points on `web` folder
   <VirtualHost *:80>
           ServerAdmin webmaster@afterclasse.local
           DocumentRoot "C:\PROJECTS\afterclasse\test_bo_afterclasse_2017_symfony\web"
           ServerName afterclasse.local
           ErrorLog "logs/afterclasse-error.log"
           CustomLog "logs/afterclasse-access.log" common
   
       	<Directory "C:\PROJECTS\afterclasse\test_bo_afterclasse_2017_symfony\web">
       		Options Indexes FollowSymLinks Includes
       		AllowOverride All
       		Require all granted
       	</Directory>
   </VirtualHost>
2.2 update "hosts" file : `127.0.0.1 afterclasse.local`
4. Create database `$ php bin/console doctrine:database:create`
5. update database schema : `$ php bin/console doctrine:schema:update --force`
6. Enregistrer des données dans la base : `$ php bin/console doctrine:fixtures:load` 
