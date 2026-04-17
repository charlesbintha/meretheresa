# Groupe Scolaire Mère Thérèsa - Site Web

Site web du Groupe Scolaire Mère Thérèsa (École privée Les Bambinos), Guédiawaye, Sénégal.

## Stack Technique

- **Backend** : Laravel 11
- **Frontend** : Blade + Tailwind CSS 3.4
- **Build** : Vite
- **Polices** : Fredoka (titres) + Nunito (corps)
- **Animations** : CSS Keyframes + Intersection Observer

## Installation

### Prérequis
- PHP >= 8.2
- Composer
- Node.js >= 18
- NPM

### Étapes

```bash
# 1. Installer les dépendances PHP
composer install

# 2. Copier le fichier d'environnement
cp .env.example .env

# 3. Générer la clé de l'application
php artisan key:generate

# 4. Installer les dépendances Node
npm install

# 5. Compiler les assets (développement)
npm run dev

# 6. Lancer le serveur
php artisan serve
```

Le site sera accessible à `http://localhost:8000`

### Production

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Structure du Projet

```
mere-theresa/
├── app/Http/Controllers/PageController.php
├── resources/
│   ├── views/
│   │   ├── layouts/app.blade.php      # Layout principal
│   │   └── pages/
│   │       ├── home.blade.php         # Page d'accueil
│   │       ├── about.blade.php        # À propos
│   │       ├── programmes.blade.php   # Programmes
│   │       ├── admissions.blade.php   # Admissions & tarifs
│   │       ├── gallery.blade.php      # Galerie photos
│   │       ├── news.blade.php         # Actualités
│   │       └── contact.blade.php      # Contact
│   ├── css/app.css                    # Styles Tailwind
│   └── js/app.js                      # Animations JS
├── public/images/                     # Images du site
├── routes/web.php                     # Routes
├── tailwind.config.js                 # Configuration Tailwind
└── vite.config.js                     # Configuration Vite
```

## Pages

| Page | URL | Description |
|------|-----|-------------|
| Accueil | `/` | Hero, programmes, témoignages, actualités |
| À propos | `/a-propos` | Histoire, mission, équipe, infrastructures |
| Programmes | `/programmes` | Détail de chaque niveau (Garde → CM2) |
| Admissions | `/admissions` | Tarifs 2025/2026, documents, calendrier |
| Galerie | `/galerie` | Photos avec filtres et lightbox |
| Actualités | `/actualites` | Blog et événements |
| Contact | `/contact` | Formulaire et informations |

## Personnalisation

### Logo
Placer le logo dans `public/images/logo.png`

### Couleurs
Modifier `tailwind.config.js` pour ajuster la palette (primary = marron/bordeaux)

### Contenu
Éditer les fichiers Blade dans `resources/views/pages/`

## Contact

- **Tél** : 33-877-81-62 / 77-148-65-02
- **Email** : gardebambinos@gmail.com
- **Adresse** : SHS N° 60 Golf Nord, Guédiawaye, Sénégal
