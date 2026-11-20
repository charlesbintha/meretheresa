# Démonstration Horizon

URL : https://app.lesbambinos.sn/demo/

Installation indépendante : `/home/u528935801/domains/lesbambinos.sn/horizon-demo`.
Racine publique : `/home/u528935801/domains/lesbambinos.sn/public_html/app/public/demo`.
SQLite privé : `database/horizon-demo.sqlite`. Ne jamais copier le `.env` de production.
Clé APP_KEY, cookie de session, stockage et base distincts ; MAIL_MAILER=log.
Le logo Horizon est un SVG original d’exemple fourni dans `public/template/assets/horizon-logo.svg`.

La commande `php artisan school:create-demo` ne fonctionne que sur une base SQLite
nommée horizon-demo.sqlite, sans utilisateur ni élève, avec SCHOOL_DEMO=true.
Elle initialise 288 élèves fictifs, leurs classes et matières, les notes du premier
trimestre 2026–2027, les échéances mensuelles, des services et règlements d’exemple.
Les adresses des familles sont en example.invalid. Aucun courriel n’est envoyé.
Elle affiche une seule fois le mot de passe aléatoire du compte admin@horizon.example.
Ne pas conserver ce mot de passe dans Git.

Après une mise à jour de la copie privée, conserver le `.env`, SQLite et storage,
exécuter les migrations, puis synchroniser les assets vers la racine publique démo.
Conserver son index.php spécifique : il démarre la copie privée et définit publicPath.
Ne jamais relancer l’initialisation pour une simple mise à jour.

# Notes et bulletins

Notes sur 20 : devoir et composition (poids 1 et 2). Les cellules vides restent
manquantes et peuvent être enregistrées progressivement ; vider une note existante
la supprime. Les matières et coefficients sont ceux du catalogue scolaire.
Bulletins scolaires : sélectionner la classe et le trimestre, renseigner appréciation,
absences en demi-journées et retards, puis générer les dossiers complets sélectionnés.
Les rangs portent sur les dossiers complets, avec rang partagé en cas d’égalité.
Chaque génération conserve un instantané ; une génération identique réutilise
l’archive, des résultats modifiés produisent une nouvelle version. Le bouton
« Dernier généré » ouvre la dernière archive. Impression A4, ou PDF via le navigateur.
La génération ne transmet aucun bulletin aux parents et ne publie pas de notes.
