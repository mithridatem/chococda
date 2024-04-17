# Installer le projet 
1 - git clone url repo

2 - Créer les variables d'environnement dans le fichier **.env** :
```yaml
DATABASE_URL="mysql://login:mdp@127.0.0.1:3306/nom_db?serverVersion=10.4.32-MariaDB&charset=utf8mb4"

LOGIN_SMTP=

PASSWORD_SMTP=

SERVER_SMTP=

PORT_SMTP=
```
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
