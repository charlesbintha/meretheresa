# Rapports — Mère Thérèsa

La rubrique **Rapports** propose deux pages :

- **KPI & diagrammes** : effectifs, élèves actifs, encaissements et soldes de scolarité, répartition par classe, statut, mois et mode de paiement ; résultats du deuxième trimestre. Le filtre de classe s’applique aux indicateurs. Cliquer une barre des effectifs ouvre le rapport de cette classe.
- **Rapports filtrables** : effectifs, encaissements, soldes de scolarité et résultats scolaires. Les filtres comprennent la classe, le statut de l’élève et la recherche par nom ou matricule. Les encaissements disposent de dates inclusives et d’un filtre par mode ; les résultats scolaires disposent du trimestre et du résultat ; les soldes disposent du statut de règlement.

Cliquer **Appliquer les filtres** pour actualiser les résultats. Les exports CSV et l’impression reprennent tous les résultats des filtres appliqués, au-delà de la page affichée. Les CSV protègent les cellules pouvant être interprétées comme des formules.

Les données proviennent de l’année scolaire active et de l’état serveur déjà filtré selon les permissions de l’utilisateur. Aucun nouvel accès aux données n’est accordé. Un utilisateur sans droit financier ne dispose pas des rapports financiers. Les soldes sont ceux des scolarités de l’année entière ; ils ne représentent pas nécessairement des impayés échus. Les moyennes exigent les deux notes de chaque matière : une note absente reste distincte d’une note zéro.

## Mise à jour Hostinger

Exécuter uniquement dans le dépôt de l’application (ne pas toucher au dossier voisin `mere-teresa`) :

```bash
cd /home/u528935801/domains/lesbambinos.sn/public_html/app
git pull --ff-only origin main
php artisan migrate --force
php artisan view:clear
```

La migration corrige uniquement l’ancienne orthographe du nom dans les paramètres. Aucun seeder ni remplacement des données n’est nécessaire. Actualiser le navigateur avec Ctrl + Maj + R.

## Vérification

```bash
node --test tests/js/reports.test.cjs
php artisan test
```
