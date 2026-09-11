# Utilisateurs, profils et rôles

## Écrans

- **Utilisateurs** : rechercher, filtrer par rôle, créer un compte, modifier ses coordonnées/rôle, activer ou désactiver, réinitialiser un mot de passe. Aucun compte n’est supprimé physiquement.
- **Rôles & permissions** : créer et modifier un rôle, choisir ses accès, supprimer un rôle non attribué. Le rôle Administrateur est protégé.
- **Mon profil** : nom, e-mail, téléphone et mot de passe. Modifier son e-mail ou son mot de passe nécessite le mot de passe actuel. Le rôle ne peut pas être modifié depuis le profil.

## Rôles initiaux

| Rôle | Accès initiaux |
|---|---|
| Administrateur | Tous les modules, paramètres, utilisateurs et rôles |
| Direction | Consultation des modules scolaires, finances, notes et services |
| Secrétariat | Gestion des élèves, inscriptions, organisation pédagogique et services |
| Comptabilité | Gestion des paiements et services ; consultation des dossiers élèves liés |
| Pédagogie | Gestion des notes ; consultation des élèves et de l’organisation pédagogique |

Les rôles s’appliquent à **l’ensemble de l’établissement**, pas uniquement à certaines classes. Les permissions des quatre rôles non administrateurs sont modifiables. Un rôle sans permission permet uniquement l’accès au profil et aux préférences.

Une permission de modification inclut la consultation correspondante. Les modules Notes, Finances et Services nécessitent les dossiers élèves (y compris leurs coordonnées familiales) et les libellés de classe. Les Notes nécessitent aussi l’organisation pédagogique. Ces dépendances sont ajoutées automatiquement et expliquées dans le formulaire du rôle.

La gestion des comptes et des rôles reste réservée aux administrateurs ; elle ne peut pas être ajoutée à un rôle personnalisé. Un administrateur ne peut pas se désactiver ni modifier lui-même son rôle. Le dernier administrateur actif ne peut pas être rétrogradé ou désactivé. Un rôle attribué, même à un compte désactivé, doit être réaffecté avant suppression.

## Connexions et mots de passe

- Mot de passe de 12 caractères minimum, confirmé, stocké uniquement sous forme de hash. La limite de 72 octets du hachage bcrypt est vérifiée côté serveur.
- Aucun e-mail automatique d’invitation n’est envoyé : l’administrateur communique les accès par un canal privé.
- Une désactivation, une modification de rôle ou une réinitialisation de mot de passe révoque les sessions concernées dès la requête suivante.
- Un changement de mot de passe personnel conserve la session courante et révoque les autres sessions.
- Un changement d’e-mail personnel exige aussi le mot de passe actuel.
- Les comptes existants marqués administrateurs conservent leurs accès lors de la migration. Les anciens comptes sans rôle doivent être affectés par un administrateur.

Les permissions sont contrôlées à chaque commande et les données non autorisées sont retirées des réponses JSON. Les liens/boutons de l’interface reflètent ces permissions. Les actions sont journalisées sans les mots de passe. `school:admin` reste disponible en SSH pour rétablir un accès administrateur.

## Mise à jour de l’application Hostinger existante

Ces commandes concernent uniquement `/home/u528935801/domains/lesbambinos.sn/public_html/app`. Elles ne modifient pas l’autre projet `mere-teresa`.

```sh
cd /home/u528935801/domains/lesbambinos.sn/public_html/app &&
git pull --ff-only origin main &&
php artisan migrate --force &&
php artisan view:clear &&
php artisan route:clear
```

Le `.htaccess` personnalisé du serveur n’est pas modifié par cette livraison. La migration ajoute les rôles et les champs de profil sans remplacer les données scolaires. **Ne pas relancer le seeder** pour cette mise à jour. Recharger complètement le navigateur puis ouvrir Utilisateurs / Rôles & permissions avec le compte administrateur actuel.

## Validation

`SchoolAccountsTest` couvre les permissions de lecture/écriture, l’escalade par le profil, les mots de passe, le dernier administrateur, les rôles attribués et la révocation de sessions. `tests/accounts-smoke.cjs` vérifie les parcours dans un navigateur et doit être utilisé uniquement sur une base de test isolée.
