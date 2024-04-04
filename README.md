# EpsilonSymfony

## composer install
## npm install
## php bin/console doctrine:database:drop --force (si une bdd au même nom est déjà créé)
## php bin/console doctrine:database:create
## Si une migration a été effectué (dans le dossier migrations/) il faut la supprimer (laisse le .gitignore)
## php bin/console make:migration
## php bin/console doctrine:migrations:migrate
## php -S localhost:8000 -t public