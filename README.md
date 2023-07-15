# Pour commencer

- Modifier la connexion à la base de données dépend de vos configurations sur le fichier .env
    DATABASE_URL="mysql://user:password@127.0.0.1:3306/database?serverVersion=8&charset=utf8mb4"

- Installer les dépendances: composer install

- Ajouter les migrations à la base de donnée: php bin/console doctrine:migrations:migrate

- Pour ajouter un nouvel administrateur, utilisez cette commande : php bin/console app:create-admin