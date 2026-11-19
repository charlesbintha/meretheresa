# Comptabilité de Mère Thérèsa

Référentiel retenu avec l’établissement : SYSCOHADA révisé (école privée commerciale).

## Plan de comptes

La nomenclature de `database/data/syscohada.json` contient 1 339 comptes et rubriques de la transcription publique du SYSCOHADA révisé, plus sept subdivisions scolaires. Les comptes de regroupement et la classe 9 ne sont pas imputables dans la comptabilité générale. Les utilisateurs autorisés peuvent ajouter des subdivisions ; un compte déjà utilisé ne peut pas être subdivisé.

Sources : [publication OHADA, 2017](https://biblio.ohada.org/pmb/opac_css/doc_num.php?explnum_id=2063), [transcription de la nomenclature](https://plan-comptable-ohada.com/nouvelle-norme-2016/plan-comptable-syscohada-revise.csv). Les rubriques du compte de résultat suivent les préfixes SYSCOHADA ; les comptes de résultat non rattachés restent visibles et entrent dans le résultat net.

## Circuit des écritures

Les exercices comptables sont indépendants des années scolaires. L’exercice initial est 2026. Créer les suivants dans Comptabilité. Journaux : AN, AC, VE, CA (caisse principale), BQ (BOA), MW (Wave), MO (Orange Money), MM (mobile non précisé), OD.

Saisir des écritures équilibrées et cocher la vérification, puis enregistrer et valider. Date, référence, comptes imputables et équilibre sont contrôlés côté serveur. Une écriture validée est immuable. La contrepassation génère un brouillon inverse, à vérifier et valider. L’exercice clôturé est définitivement verrouillé ; la clôture est réservée à la permission de configuration et refuse les brouillons restants. Les à-nouveaux de l’exercice suivant sont à préparer séparément.

La préparation des encaissements est idempotente, par ligne d’encaissement d’élève ou du personnel. Les dates absentes restent vides ; le compte de trésorerie reste vide si le mode de paiement est inconnu. Les encaissements sans date sont proposés dans l’exercice de début de leur année scolaire. Vérifier la date réelle et changer l’exercice au besoin. Les paiements de dates connues hors exercice sont ignorés pour cet exercice.

Le crédit proposé est la créance famille (411101). Cette reprise ne constate pas automatiquement du chiffre d’affaires : il faut rapprocher chaque règlement de la créance, facture ou solde d’ouverture correspondant. Une modification de la source bloque la validation du brouillon ; une nouvelle préparation actualise uniquement les brouillons dont la source a changé et réinitialise leur vérification. Un règlement déjà validé ne sera pas modifié par une nouvelle préparation : toute correction comptable passe par contrepassation.

## États et limites de présentation

Balance : ouvertures avant la période, mouvements et soldes. Grand livre : lignes par compte avec solde progressif. Bilan : présentation de gestion nette, avec reclassement des soldes de tiers et de trésorerie et intégration du résultat courant. Compte de résultat : charges, produits, chiffre d’affaires et résultats intermédiaires. Bilan et résultat couvrent le début de l’exercice jusqu’à la date de fin sélectionnée ; la date de début s’applique à la balance et au grand livre.

Seules les écritures validées alimentent ces états. Les montants de scolarité futurs du classeur ne deviennent pas des produits comptables. Les à-nouveaux, immobilisations, amortissements, stocks, achats, paie, taxes et écritures d’inventaire doivent être renseignés pour obtenir des états complets. Il s’agit d’états de gestion, pas d’une liasse réglementaire avec annexes et comparatif N−1. Les exports Excel et PDF reprennent toutes les lignes des résultats sélectionnés, pas seulement la page affichée.

## Accès

Administrateur : tous les droits. Comptabilité : consultation, préparation et validation. Direction : consultation. Les rôles restent modifiables dans l’administration. La configuration et la clôture nécessitent `accounting.configure`.

## Comptes de trésorerie

L’onglet « Banque et caisses » présente BOA (5211), la caisse principale (5711), Wave (5521) et Orange Money (5522). Les coordonnées sont facultatives et modifiables avec la permission accounting.configure. Aucun solde d’ouverture n’est inventé. Les nouveaux encaissements Wave et Orange Money sont préparés dans des journaux distincts ; les écritures déjà préparées ou validées restent inchangées tant que leur source ne change pas. Le compte 552 reste disponible pour les reprises historiques ou les paiements mobiles dont l’opérateur est inconnu.

## Dépenses et fournisseurs

Le menu permet de créer et modifier les fournisseurs, saisir une facture simple en FCFA, rechercher et filtrer les factures, consulter le reste à régler, préparer des règlements partiels et exporter en Excel/PDF. La facture génère un brouillon AC (charge au débit, fournisseur 4011 au crédit). Le règlement génère un brouillon dans le journal du compte choisi (4011 au débit, trésorerie au crédit). La validation nécessite accounting.post et une confirmation de vérification. Seuls les règlements validés sont comptés comme réglés ; les brouillons réservent leur montant afin d’empêcher un dépassement. Un règlement en brouillon peut être annulé.

Les justificatifs PDF/JPG/PNG (10 Mo maximum) sont stockés sur le disque privé et téléchargés après contrôle de la permission accounting.view. Un justificatif manquant est signalé mais n’empêche pas la saisie. Les coordonnées BOA restent facultatives. Aucun paiement bancaire externe n’est exécuté.

La saisie dédiée utilise un seul compte de charges, sans ventilation de TVA. Les immobilisations et factures à plusieurs imputations doivent passer par la saisie comptable générale. Les écritures validées liées aux dépenses ne sont pas modifiables ; leur contrepassation automatisée et les avoirs fournisseurs ne sont pas encore pris en charge dans ce module. Les factures de ce module ne doivent pas être ressaisies manuellement dans un autre journal.
