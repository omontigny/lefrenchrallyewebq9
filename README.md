# Le French Rallye Qual 8

## Pré-requis
  * Avoir Docker et Docker-compose installé
  * Avoir installé Symfony CLI
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
