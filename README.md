

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

Créer le schéma de la base de données

Mettre a jour le schéma de la base de données 
php console doctrine:schema:update --force

Enregistrer des données dans la base
php bin/console doctrine:fixtures:load 
