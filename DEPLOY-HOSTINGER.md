# Déployer le template sur app.lesbambinos.sn

## État du dépôt

- Dépôt : https://github.com/charlesbintha/meretheresa
- Branche à déployer : `main`
- Ancienne application Laravel : branche `archive/laravel-before-template-2026-09-11` (état sauvegardé : `d08cdca0bd6f47fe5fd3de9dc5981f34b7051e70`).
- Le template est directement à la racine du dépôt, avec `index.html` comme point d’entrée.

Cette version est une application HTML/CSS/JavaScript statique. Aucun Composer, npm, serveur Node.js ou MySQL n’est nécessaire. Les données sont fictives et les changements restent dans le navigateur de chaque utilisateur : le déploiement ne crée pas une base partagée entre plusieurs personnes.

## Destination Hostinger

- Sous-domaine : `app.lesbambinos.sn`
- Racine du site : `/home/u528935801/domains/lesbambinos.sn/public_html/app`
- Point d’entrée attendu : `/home/u528935801/domains/lesbambinos.sn/public_html/app/index.html`

Le dossier de destination ne doit pas être `public_html` seul : celui-ci correspond au site principal. Le template doit être servi depuis le dossier `app`.

## Avant le premier déploiement

1. Dans hPanel, ouvrir le tableau de bord du site `lesbambinos.sn`.
2. Vérifier dans la gestion des sous-domaines que `app.lesbambinos.sn` utilise le dossier `public_html/app`. Si ce sous-domaine n’existe pas, le créer avec cette racine et utiliser les paramètres DNS fournis par Hostinger.
3. Si le dossier `app` contient déjà un site, en télécharger une sauvegarde avant remplacement. Déplacer ensuite les anciens fichiers hors du dossier public de destination, notamment les anciens `index.php` et `.htaccess` Laravel, afin d’éviter le mélange des deux applications. Ne pas modifier les fichiers du site principal `public_html`.

## Méthode recommandée : Git dans hPanel

1. Dans le tableau de bord du site, ouvrir **Avancé → Git**.
2. Cliquer **Continuer avec GitHub**, se connecter et autoriser Hostinger à accéder au dépôt `charlesbintha/meretheresa`.
3. Choisir ce dépôt.
4. Sélectionner la branche **main**.
5. Configurer le répertoire cible pour qu’il corresponde exactement à :

   ```text
   /home/u528935801/domains/lesbambinos.sn/public_html/app
   ```

   Si le champ affiche un chemin relatif au domaine et propose `public_html` par défaut, utiliser **public_html/app**. Si l’ancienne interface affiche « Install path » relatif à `public_html`, utiliser **app**. Vérifier la destination finale affichée avant de lancer le déploiement.

6. Cliquer **Deploy / Déployer** et attendre la confirmation.
7. Dans le gestionnaire de fichiers, vérifier que `index.html`, `styles.css`, `app.js`, les autres scripts et `assets/` sont directement dans `app/`, sans dossier `meretheresa-main` ou `mere-teresa-template` intermédiaire.
8. Vérifier que le certificat SSL couvre `app.lesbambinos.sn`, puis ouvrir **https://app.lesbambinos.sn**.

Le `.htaccess` fourni définit `index.html` comme page d’accueil et désactive l’indexation des dossiers. La navigation utilise des fragments d’URL (`#students`, `#payments`, etc.) : aucune réécriture SPA n’est nécessaire.

Après les prochains changements sur GitHub, cliquer **Redeploy / Redéployer** dans hPanel, ou activer le déploiement automatique de `main` si souhaité.

## Alternative : téléversement ZIP

Utiliser l’archive `mere-teresa-hostinger.zip` fournie avec cette livraison : son `index.html` est déjà à la racine.

1. Ouvrir **Fichiers → Gestionnaire de fichiers** puis `public_html/app`.
2. Téléverser l’archive et l’extraire directement dans ce dossier.
3. Vérifier la présence de `app/index.html`, et non `app/mere-teresa-template/index.html`.
4. Retirer l’archive ZIP du dossier public une fois l’extraction terminée.
5. Ouvrir https://app.lesbambinos.sn.

Si vous utilisez **GitHub → Code → Download ZIP**, l’archive contient un dossier `meretheresa-main`. C’est son contenu qu’il faut placer dans `app/`.

## Vérifications après déploiement

- Le tableau de bord s’affiche avec le logo et les styles.
- La page **Élèves** s’ouvre et le bouton **Ajouter un élève** affiche le formulaire.
- Les fenêtres de personnalisation et de paiement fonctionnent.
- Les styles d’impression s’appliquent aux reçus et bulletins.
- En cas d’ancienne version affichée, vider le cache du site dans hPanel si activé et actualiser le navigateur sans cache.

Si une ancienne application Laravel apparaît encore, vérifier d’abord la racine du sous-domaine et les anciens fichiers de routage. Si une erreur 403 apparaît, vérifier que `index.html` est présent directement dans la bonne racine. Ne pas appliquer des permissions 777 : conserver les permissions normales du gestionnaire de fichiers.

## Références Hostinger

- Déploiement Git : https://www.hostinger.com/support/1583302-how-to-deploy-a-git-repository-in-hostinger/
- Gestionnaire de fichiers : https://www.hostinger.com/support/4548688-basic-actions-in-the-file-manager-in-hostinger/
