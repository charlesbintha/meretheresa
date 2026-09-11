# Intégration Laravel / MySQL

Le template est raccordé au schéma normalisé du projet scolaire local, distinct de l’ancien site vitrine GitHub.

- `resources/views/school/app.blade.php` : coque Blade, session et jeton CSRF.
- `public/template/server.js` : lecture initiale et commandes JSON, gestion des erreurs et conflits, aucun repli vers des données fictives.
- `GET /school-api/state` : données de l’année active, préférences et révision.
- `POST /school-api/commands` : action, identifiant facultatif, saisie et révision attendue.
- `SchoolStore` : validation, transactions, relations, contrôles de capacité, soldes et planning.
- `TemplateImporter` : remplacement des données scolaires avec sauvegarde JSON compressée vérifiée, suppression transactionnelle et clés étrangères actives.
- `school:admin` : création ou mise à jour explicite d’un compte administrateur.

Les permissions de `school_roles` contrôlent les lectures et écritures côté serveur, avec session Laravel et CSRF. `SchoolAccess` refuse les comptes désactivés et les sessions révoquées. `SchoolAccounts` gère les comptes, profils et rôles ; ces commandes participent à la transaction et à la révision de `SchoolStore`. Les anciennes routes CRUD et l’inscription publique ne sont pas exposées. Les rôles s’appliquent à l’ensemble de l’établissement, sans filtrage par classe ni portail parents. Voir [ROLES.md](ROLES.md).

Les élèves sont rattachés aux classes par `enrollments`. Les scolarités sont conservées dans `tuitions`, les versements dans `payments`, les trimestres dans `periods`, et les notes dans `grades`. Les trois services utilisent leurs tables existantes. Les préférences utilisent `school_preferences` et les actions sont journalisées dans `school_audit_logs`.

La révision globale sérialise les modifications et détecte une interface périmée. Un paiement possède une clé d’idempotence conservée lors d’une nouvelle tentative du même formulaire. Les requêtes échouées ne déclenchent pas de message de succès ; une erreur réseau demande de réessayer. Après un rechargement complet, vérifier l’historique avant de ressaisir un paiement dont le résultat était incertain.

Les données de l’année sont chargées en une fois pour cette première version (288 élèves, 10 368 notes importées). Pour des volumes nettement supérieurs, ajouter pagination, filtres et agrégats côté API. Les documents sont imprimables via le navigateur. Il n’y a pas d’intégration Wave/Orange Money : ces noms indiquent le moyen d’un paiement enregistré manuellement.

## Restaurer après un import

Avant l’import local du 11 septembre 2026, une sauvegarde SQL complète a été conservée dans `storage/app/private/backups/`, en plus de la sauvegarde JSON des tables remplacées. Ces fichiers sont ignorés par Git. Pour revenir à l’état antérieur, arrêter les écritures, importer la sauvegarde SQL dans une base de restauration vide, vérifier les comptes et les effectifs, puis sélectionner cette base dans `.env`. Une restauration du schéma antérieur doit être utilisée avec le code compatible, ou suivie de `php artisan migrate --force` pour recréer les colonnes de l’intégration.

Sur Hostinger, prévoir une sauvegarde SQL régulière via hPanel. La sauvegarde JSON est un instantané des seules tables scolaires remplacées, pas une sauvegarde des utilisateurs ni des fichiers joints.
