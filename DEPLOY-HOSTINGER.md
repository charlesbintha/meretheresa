# Déployer sur app.lesbambinos.sn

Cette version utilise Laravel et MySQL. L’ancien déploiement statique et son ZIP ne conviennent plus.

## Répertoires

- Code privé : `/home/u528935801/domains/lesbambinos.sn/mere-teresa`
- Racine du sous-domaine : `/home/u528935801/domains/lesbambinos.sn/public_html/app`
- Entrée publique : `public_html/app/index.php`

Le code Laravel, `.env`, `vendor`, `database` et `storage` restent hors de `public_html`. Seul le contenu de `public/` est copié dans `public_html/app`. Le fichier `deploy/hostinger-index.php` adapte les chemins à cette disposition. Cette séparation suit le [principe documenté par Hostinger](https://www.hostinger.com/fr/support/6152127-comment-deployer-laravel-8-chez-hostinger/), avec un point d’entrée adapté à Laravel 12.

## 1. Préparer hPanel

Vérifier que le sous-domaine utilise `public_html/app`, que son SSL est actif et que PHP 8.3 ou 8.4 est sélectionné. Vérifier également la version PHP en SSH avec `php -v`. Créer une base MySQL et son utilisateur ; noter le nom complet fourni par hPanel. Activer l’accès SSH si disponible sur votre offre.

## 2. Installer le code privé

En SSH, récupérer `main` dans le répertoire privé (utiliser une clé SSH GitHub autorisée si le dépôt est privé) :

```sh
cd /home/u528935801/domains/lesbambinos.sn
git clone --branch main git@github.com:charlesbintha/meretheresa.git mere-teresa
cd mere-teresa
composer install --no-dev --optimize-autoloader
cp .env.example .env
```

Si le dossier existe déjà, utiliser son dépôt avec `git pull --ff-only origin main`. Préserver son `.env` et sa clé existante.

## 3. Configurer la base

Éditer le `.env` privé avec les valeurs fournies par hPanel :

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://app.lesbambinos.sn
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_complet_de_la_base_hostinger
DB_USERNAME=utilisateur_mysql_hostinger
DB_PASSWORD="mot_de_passe_mysql"
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_ENCRYPT=true
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Utiliser l’hôte MySQL indiqué par hPanel s’il diffère. Générer la clé **uniquement à la première installation** :

```sh
php artisan key:generate
php artisan migrate --force
php artisan school:admin votre-adresse@example.com
```

La dernière commande demande un mot de passe de 12 caractères minimum et sa confirmation, sans les afficher.

Pour démarrer avec les données de `data.js`, lancer une seule fois la commande ci-dessous en remplaçant le nom de base. Elle écrase les données scolaires de cette base après sauvegarde privée, en conservant les comptes :

```sh
php artisan school:import-template --replace --database-name=nom_complet_de_la_base_hostinger
```

La base locale `mere_theresa` a déjà été importée. L’envoi du code sur GitHub ne copie pas MySQL sur Hostinger. Si vous souhaitez transférer ultérieurement des modifications locales, exporter la base locale puis l’importer dans la base Hostinger ; ne pas relancer l’import du jeu d’exemple par-dessus ces modifications.

## 4. Publier les fichiers publics

Sauvegarder d’abord le dossier `public_html/app` existant hors de `public_html`, puis libérer ce dossier pour éviter que l’ancien `index.html` soit encore servi. Ne toucher qu’au sous-dossier `app`, pas au site principal.

Depuis le répertoire privé `mere-teresa` :

```sh
mkdir -p ../public_html/app
cp -R public/. ../public_html/app/
cp deploy/hostinger-index.php ../public_html/app/index.php
chmod -R u+rwX storage bootstrap/cache
chmod 600 .env
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Le `.htaccess` à publier est **`public/.htaccess`**, jamais celui de la racine privée. Laisser les sauvegardes sous `storage/app/private/backups` hors du site public.

## 5. Vérifier

Ouvrir `https://app.lesbambinos.sn/login`, se connecter avec le compte créé, puis vérifier les élèves, paiements et notes. Créer une fiche de test et recharger la page pour vérifier sa persistance. Les chemins `/.env`, `/database/seed-data/template.json` et `/storage/logs/laravel.log` doivent être inaccessibles. L’API sans connexion doit renvoyer un refus ou rediriger vers la connexion.

Pour les prochaines mises à jour : sauvegarder la base, mettre temporairement l’application en maintenance (`php artisan down`), récupérer le code, installer les dépendances, exécuter `php artisan migrate --force`, recopier les fichiers publics et le point d’entrée adapté, reconstruire les caches puis `php artisan up`. **Ne pas relancer l’import destructif du template**. En cas d’échec, consulter `storage/logs/laravel.log` dans le répertoire privé.

## Sans accès SSH

Préparer `vendor/` avec Composer sur une machine compatible, téléverser le projet complet dans le dossier privé et les fichiers publics dans `public_html/app`. Utiliser un terminal fourni par l’hébergeur pour les commandes Artisan. Ne pas créer de route web publique permettant de lancer des migrations ou un import.
