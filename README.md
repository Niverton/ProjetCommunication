#  Mise en valeur des réserves
## Projets de communication transdisciplinaire L3 S6 2016/2017

Benoit FAGET, Rémy MAUGEY, Oussama MEHDAOUI, Timothée JOURDE et Carlos NEZOUT

Veuillez suivre ces quelques instructions pour utiliser l'application web.

### Base de données MySQL

- Installer PHP
- Installer MySQL
- Installer phpMyAdmin
- Lancer le service MySQL
- Se rendre dans le répertoire d'installation de phpMyAdmin puis y lancer un serveur PHP :
```
php --server localhost:9090
```
- Ouvrir un navigateur web et se rendre à l'adresse `localhost:9090`
- Créer une base
- Y importer le dump SQL `MySQLWorkbench/final_dump.sql`

### Paramétrage de Lumen

À la racine du dépôt :
```
cp env .env
```

Éditer `.env` et modifier les lignes suivantes :
```
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nom_de_la_base
DB_USERNAME=nom_utilisateur_mysql
DB_PASSWORD=mot_de_passe
```

### Serveur web

À la racine du dépôt :
```
cd public
php --server localhost:8080
```

Dans un navigateur web, se rendre à l'adresse `localhost:8080`.


