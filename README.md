# Installer le projet 
1 - git clone url repo
2 - créer les variables d'environnement dans le fichier .env
DATABASE_URL="mysql://login:mdp@127.0.0.1:3306/nom_db?serverVersion=10.4.32-MariaDB&charset=utf8mb4"
SMTP_LOGIN=
SMTP_PASSWORD=
SMTP_SERVER=
SMTP_PORT=
3 - se déplacer dans le dossier 
```bash
cd nom_dossier
```
4 - installer les dépendances
```bash
composer install
```
5 - créer la base (facultatif)
```bash
symfony console d:d:c
```
6 - migrer la structure de données (facultatif)
```bash
symfony console d:m:m
```
