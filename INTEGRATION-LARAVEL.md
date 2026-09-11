# Préparation de l’intégration à Laravel

Cette étape n’est pas exécutée : le template est autonome afin de valider le design et les parcours. Le template occupe désormais la racine de `main`. L’ancien contenu GitHub, un site Laravel, est conservé dans `archive/laravel-before-template-2026-09-11`. Les modules de gestion scolaire décrits ci-dessous proviennent du projet Laravel local examiné lors de la création du template ; ils ne sont pas présents dans cette branche d’archive du site vitrine.

## Approche proposée

Conserver Laravel comme socle. Le template utilise du HTML, CSS et JavaScript natif : il peut être porté dans Blade et compilé avec le Vite déjà présent dans le projet, sans imposer React, Vue ou une réécriture du back-end.

1. Créer un layout Blade commun reprenant la structure de `index.html` (navigation, en-tête, dialogues, notifications).
2. Extraire les composants récurrents : boutons, cartes KPI, filtres, tableau, pagination, badge de statut, avatar, formulaire, panneau latéral.
3. Déplacer `styles.css` dans les ressources Vite et préserver les tokens CSS pour le thème.
4. Remplacer la navigation par hash par les routes nommées Laravel. Les pages Blade conservent les mêmes composants et styles.
5. Remplacer `MT.db` et les calculs de démonstration par des données issues des contrôleurs/Eloquent. Les tableaux utiliseront la pagination et les filtres côté serveur.
6. Remplacer les écritures `MT.forms` par des requêtes vers les routes existantes, protégées par CSRF et validées côté serveur. Les helpers de présentation et animations peuvent être conservés.
7. Raccorder le profil à `Auth::user()`, les autorisations aux policies et l’accès aux middleware existants. La page de connexion conserve le système d’authentification Laravel.
8. Raccorder les reçus, factures, attestations et bulletins aux générateurs de documents existants plutôt qu’au contenu imprimable de démonstration.
9. Conserver uniquement les préférences d’interface (thème, menu, widgets) en stockage local ou les déplacer vers les préférences utilisateur serveur. Les dossiers scolaires et paiements ne devront pas rester dans `localStorage`.

## Correspondance des écrans

Routes vérifiées dans `routes/web.php` du projet local de gestion scolaire au moment de la création du template. Ne pas les confondre avec les routes du site vitrine Laravel archivé sur GitHub.

| Template | Contrôleur / routes Laravel actuelles |
| --- | --- |
| `#dashboard` | `DashboardController` · `dashboard` |
| `#students` | `StudentController` · `students.index`, `students.store`, `students.show`, `students.update` |
| `#enrollments` | `EnrollmentController` · `enrollments.index`, `enrollments.store`, `enrollments.approve`, `enrollments.reject`, `enrollments.certificate` |
| `#classes` / onglet classes | `ClassRoomController` · `classes.*` |
| `#classes` / onglet matières | `SubjectController` · `subjects.*` |
| `#teachers` | `TeacherController` · `teachers.*` |
| `#timetable` | `TimetableController` · `timetables.*`, `timetables.class-view`, `timetables.teacher-view` |
| `#grades` / saisie | `GradeController` · `grades.*`, `grades.batch-entry`, `grades.store-batch`, `grades.export` |
| `#grades` / bulletins | `ReportCardController` · `report-cards.*`, `report-cards.generate`, `report-cards.pdf` |
| `#finance` | `BillingController` · `billing.dashboard` |
| `#payments` | `PaymentController` · `payments.*`, `payments.receipt`, `payments.generateReceipt`, `payments.exportPayments` |
| `#billing` | `TuitionController` / `BillingController` · `tuitions.*`, `billing.index`, `billing.show`, `billing.invoice` |
| `#services` / cantine | `CanteenSubscriptionController` · `canteen-subscriptions.*` |
| `#services` / transport | `TransportSubscriptionController` · `transport-subscriptions.*` |
| `#services` / études | `EveningStudyController` · `evening-studies.*` |
| `#years` | `AcademicYearController` · `academic-years.*`, `academic-years.set-current` |
| `#settings` | Écran à raccorder à la configuration de l’établissement ; aucun contrôleur de paramètres dédié identifié dans les routes examinées. |

## Transformations des données

- `firstName` / `lastName` → `first_name` / `last_name` sur `Student`.
- `birth` → `date_of_birth` ; `parent` → `parent_name` ; `phone` → `parent_phone` ; `email` → `parent_email`.
- Le template stocke directement `classId` sur l’élève pour la démo. Dans Laravel, utiliser `Enrollment` et son `class_id` / `academic_year_id` pour déterminer la classe de l’année active.
- Les libellés français de statut sont des valeurs de présentation. Préserver les valeurs métier/enum actuelles dans les modèles Laravel.
- `Payment.amount`, `method`, `date`, `reference` → `amount`, `payment_method`, `payment_date`, `receipt_number`. Préserver `student_id`, `tuition_id`, `payment_type` et `notes`.
- Le solde fictif `150000 - versements` doit être remplacé par le calcul réel des échéances/tarifs à partir de `Tuition` et des paiements associés.
- Les notes sont saisies par classe/matière/trimestre. Mapper `term` à `Period`, `test`/`exam` à `grade_type`, puis utiliser les champs de `Grade` (`score`, `max_score`, `teacher_id`, etc.).
- Les créneaux entiers de la démo (8, 10, 14, 16) deviennent des heures `start_time` / `end_time` et un `day_of_week` normalisé. Confirmer la numérotation des jours avant import.
- Les formules de service génériques de la maquette doivent être remplacées par les champs propres aux trois modèles de souscription.

## Critères à valider avant portage

- Navigation et noms des modules.
- Densité des tableaux et champs utiles aux utilisateurs.
- Formulaires, états et actions prioritaires.
- Affichage ordinateur/mobile, thème et logo.
- Règles financières, barèmes de notes, années et périodes réels.

Les essais de la maquette ne modifient aucune route, vue, table ni donnée du projet Laravel.
