# Mère Teresa — template interactif de gestion scolaire

Prototype autonome inspiré de Shopeers, adapté aux modules du projet Laravel Mère Teresa. Tous les textes, tableaux, formulaires et graphiques sont du HTML/CSS/JavaScript modifiable, pas une image de l’interface.

## Ouvrir le template

Ouvrir `index.html` dans un navigateur récent. Aucun npm, build, CDN ou accès Internet n’est nécessaire.

Pour bénéficier d’une origine locale stable pour les sauvegardes :

```sh
cd mere-teresa-template
python3 -m http.server 8766 --bind 127.0.0.1
```

Puis ouvrir http://127.0.0.1:8766. Le même dossier et le même port permettent de retrouver les modifications sauvegardées.

## Parcours disponibles

| Écran | Interactions |
| --- | --- |
| Tableau de bord | Compteurs animés, périodes janvier/février/mars 2026, infobulles de graphique, barres sélectionnables, ajout/retrait de widgets, ordre par glisser-déposer ou flèche clavier. |
| Élèves | Recherche, filtre par classe, tri, pagination, sélection multiple, export CSV, création, modification, fiche avec onglets informations/paiements/résultats. |
| Inscriptions | Nouvelle demande, validation/refus, synchronisation du statut élève, attestation imprimable. |
| Classes et matières | Cartes des classes, recherche, filtre par cycle, capacité, enseignant principal, création/modification, matières et coefficients. |
| Enseignants | Annuaire, recherche, profil, création/modification. |
| Emploi du temps | Filtre par classe, semaines, ajout/modification/retrait d’un cours, glisser-déposer, contrôle des conflits de classe, d’enseignant et de salle. |
| Notes et bulletins | Classe, matière, trimestre, notes devoir/composition, moyenne en direct, sauvegarde, bulletin pondéré, impression et export CSV. |
| Vue financière | Sommes calculées à partir des paiements, évolution mensuelle, répartition par moyen de paiement, taux de recouvrement. |
| Paiements | Recherche, filtres, création, contrôle du solde de scolarité, reçu, export CSV. |
| Scolarités et factures | État des comptes, solde après paiements, filtres, facture, encaissement depuis une fiche. |
| Services | Cantine, transport, études du soir, abonnement, suspension/réactivation, contrôle des doublons, export. |
| Années scolaires | Création, modification de l’année active, activation d’une autre année. |
| Paramètres | Informations de l’école, thème clair/sombre, navigation compacte, remise à zéro de la démo. |

Transversal : recherche globale (Cmd+K / Ctrl+K), notifications, profil, menus mobiles, focus clavier, dialogues natifs, animations adaptées à la préférence de mouvement réduit.

## Scénario de validation conseillé

1. Dans **Élèves**, créer un dossier au statut **En attente**.
2. Dans **Inscriptions**, retrouver la demande automatiquement créée et la valider.
3. Ouvrir la fiche élève, enregistrer un paiement de scolarité et vérifier le reçu.
4. Consulter **Scolarités & factures** : le solde doit avoir diminué du montant payé.
5. Dans **Notes & bulletins**, saisir des notes et cliquer **Enregistrer les notes**. Ouvrir le bulletin correspondant.
6. Dans **Emploi du temps**, déplacer un cours vers un créneau libre ; un créneau occupé doit être refusé.
7. Personnaliser le tableau de bord puis recharger pour vérifier sa conservation.

Les boutons **Imprimer / PDF** ouvrent la boîte d’impression du navigateur. Choisir « Enregistrer au format PDF » pour obtenir un fichier PDF.

## Technologies et fichiers

- HTML sémantique, CSS Grid/Flexbox, variables CSS, graphiques SVG.
- JavaScript natif organisé par responsabilité, sans framework. Les scripts différés classiques permettent également l’ouverture directe en `file://`.
- `index.html` : structure commune.
- `styles.css` : composants, thèmes, responsive et impression.
- `icons.js` : icônes SVG Tabler embarquées.
- `data.js` : données fictives, préférences, sauvegarde locale, navigation.
- `ui.js` : composants, formats, calculs et helpers.
- `views.js` : écrans et widgets.
- `app.js` : navigation, rendu, filtres et interactions du tableau de bord.
- `interactions.js` : formulaires, dossiers, paiements, documents, recherche et glisser-déposer.
- `tests/smoke.cjs` : tests des parcours et contrôles de cohérence.
- `INTEGRATION-LARAVEL.md` : correspondance avec le projet actuel.

## Données et limites du prototype

- 288 élèves, 18 enseignants, 12 classes et 84 paiements fictifs au départ. Les contacts `example.test` sont volontairement non réels.
- Scénario visuel de référence : année 2025–2026, deuxième trimestre, mars 2026. Les nouveaux dossiers portent la date réelle de création.
- La scolarité trimestrielle de démonstration est fixée à 150 000 FCFA pour tous les élèves. Ce tarif est un exemple, pas un tarif de l’école.
- Les indicateurs proviennent des données de la maquette. Les inscriptions et paiements modifiés se répercutent dans les vues concernées.
- Les semaines de l’emploi du temps affichent un planning récurrent ; modifier un cours modifie toutes les semaines.
- L’activation d’une année change le contexte affiché. Le jeu de données n’est pas cloisonné par année dans cette maquette.
- Le glisser-déposer des widgets est limité à leur colonne ; la flèche ↑ offre une alternative clavier et tactile.
- La sauvegarde utilise `localStorage` (clé `mere-teresa-template-v1`). Elle est propre au navigateur et à l’origine : `localhost` et `127.0.0.1` ont des sauvegardes différentes. En cas de stockage indisponible, un message prévient que la session ne sera pas conservée.
- Aucune authentification serveur, aucun traitement de paiement, aucun envoi d’e-mail/SMS, aucune vraie IA. La maquette n’appelle pas le projet Laravel et n’utilise pas ses données.
- Les contrôles front-end servent à tester les parcours. Ils devront être doublés par des validations, permissions et transactions serveur lors de l’intégration.

## Vérifications

```sh
node tests/smoke.cjs
```

11 vérifications couvrent le rendu des pages, la cohérence élève/inscription, le solde après paiement, les trop-perçus, les notes, les doublons, les capacités, les dates, les conflits de planning et la sauvegarde.

Parcours également contrôlés dans le navigateur : création et recherche d’élève, fiche, paiement et reçu, rechargement, refus du trop-perçu, validation d’inscription et attestation, saisie et bulletin, modification de cours, activation d’abonnement, recherche globale. Rendu ordinateur et formulaire mobile inspectés.

## Références et crédits

Direction visuelle : [Shopeers — AI-Powered B2B eCommerce Analytics Dashboard, Dipa Inhouse](https://dribbble.com/shots/26628350-Shopeers-AI-Powered-B2B-eCommerce-Analytics-Dashboard), capture et vidéo fournies dans la demande. La vidéo montre les transitions de cartes et le survol du graphique ; le template en reprend l’intention avec des interactions de gestion scolaire.

Logo : fichier existant du projet `public/images/mere-theresa-logo.jpg`.

Icônes : Tabler Icons, licence MIT, texte fourni dans `assets/LICENSE-icons.txt`.
