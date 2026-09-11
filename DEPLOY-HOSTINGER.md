# Mise à jour de l’application scolaire sur Hostinger

## Installation concernée

- URL : `https://app.lesbambinos.sn`
- Dépôt Git de l’application : `/home/u528935801/domains/lesbambinos.sn/public_html/app`
- Entrée Laravel : `public_html/app/public/index.php`

**Le dossier `/home/u528935801/domains/lesbambinos.sn/mere-teresa` appartient à un autre projet et ne doit pas être modifié.** Ne pas y exécuter les commandes de cette application. Ne pas copier `deploy/hostinger-index.php` dans l’installation actuelle : ce fichier correspond à l’ancienne disposition proposée et pointe vers cet autre dossier.

## Mise à jour par Git SSH

Sauvegarder la base de l’application avant une mise à jour. Puis, dans le terminal SSH :

```sh
cd /home/u528935801/domains/lesbambinos.sn/public_html/app &&
git pull --ff-only origin main &&
php artisan migrate --force &&
php artisan view:clear &&
php artisan route:clear
```

Si `composer.json` ou `composer.lock` ont changé, exécuter aussi `composer install --no-dev --optimize-autoloader` avec PHP 8.3/8.4. Les mises à jour de la gestion des profils et rôles n’ajoutent pas de dépendance Composer.

Conserver le `.env`, sa clé `APP_KEY`, ses accès MySQL et le `.htaccess` adapté au serveur. Ne pas employer `git reset --hard` pour résoudre un conflit avec la configuration locale. Les mises à jour ne nécessitent pas de relancer le seeder, qui remplacerait les données scolaires.

Après la mise à jour, recharger complètement le navigateur (Ctrl+F5, ou Cmd+Maj+R sur Mac).

## Routage web actuel

Le sous-domaine pointe actuellement sur `public_html/app`. Son `.htaccess` local dirige toutes les requêtes vers `public/`, sans servir directement le code Laravel ou le `.env` :

```apache
Options -Indexes -MultiViews
DirectoryIndex index.php
RewriteEngine On
RewriteRule (^|/)\. - [F,L]
RewriteRule ^public(?:/|$) - [L]
RewriteRule ^(.*)$ public/$1 [L]
```

Le `public/.htaccess` livré par Laravel reste en place. Cette configuration locale remplace le `Require all denied` présent dans le `.htaccess` racine du dépôt. Elle n’est pas remplacée par les mises à jour actuelles, qui ne modifient pas ce fichier. Si un futur `git pull` signale un conflit à cet endroit, le résoudre en conservant le routage adapté, sans supprimer la protection des fichiers privés.

Vérifier que `/login` et `/template/assets/back.jpg` fonctionnent, et que `/.env`, `/composer.json`, `/database/seed-data/template.json` et `/storage/logs/laravel.log` ne donnent jamais accès aux fichiers correspondants. Les deux premiers écrans d’administration des comptes sont `/#users` et `/#roles` après connexion.

## Base de données et initialisation

Le `.env` de **cette application** doit utiliser une base MySQL dédiée, distincte de celle du site principal. Utiliser les noms complets et le mot de passe fournis par hPanel. Après un changement du `.env` :

```sh
php artisan config:clear
php artisan config:cache
php artisan migrate:status
```

Pour créer les tables sur une base neuve : `php artisan migrate --force`. Pour créer ou rétablir un administrateur : `php artisan school:admin votre-adresse@example.com` (mot de passe demandé sans affichage).

Pour importer volontairement les données initiales de `data.js` :

```sh
php artisan db:seed --class=TemplateDataSeeder --force
```

Ce seeder **remplace les données scolaires de la base configurée**, après sauvegarde vérifiée, en conservant les utilisateurs et les rôles. Ne pas l’exécuter lors d’une mise à jour normale. Les sauvegardes sont privées dans `storage/app/private/backups`. Prévoir également une sauvegarde SQL régulière via hPanel.

## Profils et rôles

La migration `2026_09_11_160000_add_user_profiles_and_roles` ajoute les cinq rôles initiaux et affecte les anciens administrateurs au rôle protégé. Elle ne remplace ni les comptes ni les données scolaires. Voir [ROLES.md](ROLES.md) pour les permissions, la création de comptes et la gestion du profil.
