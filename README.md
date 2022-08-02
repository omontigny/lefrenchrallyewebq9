# Le French Rallye Qual 8

## Pré-requis
  * Avoir Docker et Docker-compose installé
  * Avoir une version PHP (+8.0) sur son poste
  * Avoir installé Symfony CLI
```bash
curl -sS https://get.symfony.com/cli/installer | bash
mv /Users/omontigny/.symfony/bin/symfony /usr/local/bin/symfony
symfony server:ca:install
```
* Ajouter `http://127.0.0.1:7080/proxy.pac` dans la partie proxy de la configuration réseau du système
* Avoir installé le `composer`
* Avoir installé `npm`

## Deployer l'application localement

  * cloner le repository
  * lancer `docker-compose up` (qui lancera un mysql, phpmyadmin, mailcatcher, redis)
  * Créer le fichier .env sur le modèle du .env.example `cp .env.example .env`
  * Lancer `symfony proxy:start`
  * Prévoir une entrée dans le fichier ~/.symfony/proxy.json
```json
{
    "tld": "local",
    "host": "localhost",
    "port": 7080,
    "domains": {
        "app.lefrenchrallye": "$FOLDER_PATH/lefrenchrallyeweb/public",
    }
}
```
  * Lancer le server : `symfony server:start` à partir du répertoire public
  * Accéder à l'application via l'URL : `https://app.lefrenchrallye.local`

## compose
  * compose install
  * npm install
## Creation Base
  * `php artisan migrate:fresh`

## Ajouter les données de départ (seed)
  * `php artisan db:seed`

### Ajouter une application Small
  * `php artisan db:seed --class="ApplicationSmalSeeder"`
### Ajouter une application Standard
  * `php artisan db:seed --class="ApplicationStdSeeder"`

## PhpMyAdmin pour voir les données en base
  * url : `http://$DB_HOST:8484`
  * host: `mysql`
  * login : `$DB_USERNAME`
  * password : `$DB_PASSWORD`
