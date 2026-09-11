# Mère Teresa — gestion scolaire

Application Laravel 12 / MySQL avec le template HTML, CSS et JavaScript natif inspiré de Shopeers. L’interface conserve ses panneaux, widgets, filtres, exports, impressions et glisser-déposer ; les données scolaires sont maintenant enregistrées sur le serveur.

## Installation locale

PHP 8.2 à 8.4, Composer 2, MySQL/MariaDB transactionnel. Aucune compilation Node nécessaire.

```sh
composer install
cp .env.example .env
```

Configurer les accès MySQL dans `.env`, puis `APP_ENV=local`, `APP_DEBUG=true`, `APP_URL=http://127.0.0.1:8770` et `SESSION_SECURE_COOKIE=false` pour HTTP local.

```sh
php artisan key:generate
php artisan migrate
php artisan school:admin votre-adresse@example.com
php artisan serve --host=127.0.0.1 --port=8770
```

Le mot de passe administrateur est demandé sans être affiché. Aucun compte ou mot de passe par défaut n’est livré. Les administrateurs peuvent ensuite créer les autres comptes et leur attribuer un rôle depuis Utilisateurs.

## Import des données du template

`database/seed-data/template.json` contient les données initiales issues de `data.js`, y compris les notes auparavant calculées dans le navigateur. Ce fichier reste hors du répertoire public. L’import **remplace les données scolaires existantes**, conserve les utilisateurs et crée une sauvegarde privée vérifiée avant toute suppression. Les fichiers de pièces jointes restent sur disque, mais leurs anciens enregistrements sont remplacés.

```sh
php artisan school:import-template --replace --database-name=mere_theresa
```

Un seeder nommé est également disponible, après les migrations :

```sh
php artisan db:seed --class=TemplateDataSeeder --force
```

Il utilise le même import transactionnel et la même sauvegarde vérifiée. **Cette commande remplace les données scolaires de la base configurée dans `.env`**, sans supprimer les comptes utilisateurs. Elle ne doit être lancée qu’à l’initialisation voulue, jamais automatiquement à chaque mise à jour. Le seeder n’est pas inclus dans un `DatabaseSeeder` par défaut.

Le nom doit correspondre exactement à la base configurée. Pour une base Hostinger, employer son vrai nom, avec le préfixe du compte. Ne pas exécuter cette commande lors de chaque déploiement.

Contenu : 288 élèves, 18 enseignants, 12 classes, 6 demandes en attente, 84 paiements, 36 abonnements, 180 cours et 10 368 notes. Les données importées sont un jeu d’exemple, même une fois stockées en base.

## Fonctionnement

- Connexion Laravel par session et protection CSRF ; accès contrôlé par rôle.
- Utilisateurs, activation/désactivation, réinitialisation des mots de passe, rôles personnalisés et profil personnel.
- Écriture validée côté serveur, transactions, contrôle de capacité et de chevauchement du planning.
- Paiements idempotents, contrôle du solde et mise à jour atomique des scolarités.
- Révision serveur pour détecter un changement concurrent et éviter d’écraser une modification récente.
- Classes, inscriptions, paiements et notes filtrés par année scolaire active.
- Préférences d’affichage associées au compte ; aucun dossier scolaire en localStorage.
- Moyennes calculées sur les notes enregistrées ; une note absente reste vide.

## Vérification

```sh
php artisan test
```

Les tests PHP utilisent uniquement SQLite en mémoire. `tests/smoke.cjs` teste les parcours navigateur avec Playwright et Chrome ; renseigner `SCHOOL_TEST_URL`, `SCHOOL_TEST_EMAIL` et `SCHOOL_TEST_PASSWORD` vers une **instance locale de test isolée** initialisée avec le jeu de données. Ce test crée un élève et un paiement.

PHP 8.5 n’est pas supporté par certaines dépendances de ce fichier lock. Utiliser PHP 8.3/8.4 pour installer et déployer. Les essais locaux ont aussi tourné avec les dépendances déjà installées sous PHP 8.5, qui émet des dépréciations PDO ; les erreurs HTTP doivent être journalisées, pas ajoutées au JSON.

## Déploiement et limites

Voir [DEPLOY-HOSTINGER.md](DEPLOY-HOSTINGER.md) pour `app.lesbambinos.sn` et [INTEGRATION-LARAVEL.md](INTEGRATION-LARAVEL.md) pour l’architecture.

Cette version propose cinq rôles initiaux modifiables (voir [ROLES.md](ROLES.md)), des documents imprimables/PDF via le navigateur et un chargement global des données de l’année. Elle n’inclut pas de paiement bancaire en ligne, SMS, messagerie, portail parents ou pagination serveur. Les sauvegardes automatiques de production sont à configurer chez l’hébergeur.

L’ancien site vitrine est conservé dans la branche `archive/laravel-before-template-2026-09-11`.
