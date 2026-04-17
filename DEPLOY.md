# Déploiement sur Hostinger

Guide pour déployer **Groupe Scolaire Mère Thérèsa** (Laravel 11 + Vite + Tailwind) sur un hébergement Hostinger (mutualisé Premium / Business ou Cloud).

> **Principe clé** — Tailwind et JS sont **compilés en local** avec Vite, puis on envoie le projet complet (y compris `vendor/` et `public/build/`) sur le serveur. Pas besoin de Node.js côté Hostinger.

---

## 1. Prérequis Hostinger (à faire une fois dans hPanel)

| Étape | Où | Valeur |
|------|-----|--------|
| Version PHP | hPanel → Avancé → **Configuration PHP** | **8.2** ou supérieure |
| Activer SSH (Premium+) | hPanel → Avancé → **Accès SSH** | Noter hôte, port, login |
| Créer la base MySQL (optionnel) | hPanel → Bases de données → **MySQL** | Noter `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_HOST` |
| Certificat SSL | hPanel → Sécurité → **SSL** | Activer (Let's Encrypt gratuit) |

> La base MySQL n'est **pas obligatoire** pour ce site : aujourd'hui les formulaires (`contact`, `newsletter`) sont en `TODO`. Si vous ne branchez rien tout de suite, laissez `DB_CONNECTION=sqlite` dans le `.env` de prod pour éviter toute connexion MySQL inutile.

---

## 2. Build local (avant chaque déploiement)

Depuis `mere-theresa/` sur votre machine :

```bash
# 1. Dépendances PHP production (sans les packages de dev)
composer install --no-dev --optimize-autoloader

# 2. Dépendances Node (build uniquement, pas embarqué sur le serveur)
npm install

# 3. Compilation Tailwind + JS → public/build/
npm run build
```

Après l'étape 3, vous devez avoir :

```
public/build/manifest.json
public/build/assets/app-xxxxx.css   ← Tailwind compilé et minifié
public/build/assets/app-xxxxx.js
```

> `@vite(...)` dans `resources/views/layouts/app.blade.php` lit `manifest.json` pour injecter les bons noms hashés. **Si `public/build/` manque côté serveur, la page casse.**

---

## 3. Structure recommandée côté serveur

Le répertoire web par défaut d'Hostinger est `~/public_html/`, mais Laravel doit servir depuis son dossier `public/` interne. On place donc le projet **à côté** de `public_html` et on repointe la racine web.

```
~/                        (home SSH, souvent /home/uXXXXXXXX/)
├── mere-theresa/         ← projet complet (hors public_html)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── public/           ← NOUVELLE racine web
│   │   └── build/        ← CSS/JS compilés par Vite
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/           ← OUI, uploadé
│   ├── .env              ← créé sur le serveur (voir §5)
│   └── artisan
└── public_html/          ← peut être supprimé ou redirigé
```

Dans hPanel : **Sites web → (votre domaine) → Avancé → Changer la racine des documents** et renseigner :

```
mere-theresa/public
```

> **Alternative sans changement de racine** (plans sans cette option) : mettez un `.htaccess` dans `public_html/` qui renvoie vers `../mere-theresa/public/`. Moins propre — préférez le changement de racine.

---

## 4. Fichiers à envoyer / à ignorer

**À uploader** (FTP, SFTP, ou `rsync` si SSH) :

```
app/  bootstrap/  config/  database/  public/  resources/  routes/
storage/  vendor/  artisan  composer.json  composer.lock  package.json
```

**À NE PAS uploader** :

| Exclu | Pourquoi |
|-------|----------|
| `node_modules/` | Inutile en prod (déjà compilé dans `public/build/`) |
| `.env` (le vôtre) | Contient des secrets locaux — on en crée un spécifique sur le serveur |
| `.git/` | Inutile |
| `tests/` | Optionnel |
| `*.docx`, `images/` (racine du repo) | Assets de planning, pas du site |

Exemple `rsync` depuis `mere-theresa/` (SSH) :

```bash
rsync -avz --delete \
  --exclude='node_modules' --exclude='.env' --exclude='.git' \
  --exclude='storage/logs/*' --exclude='storage/framework/cache/*' \
  ./ uXXXXXXXX@votre-serveur.hostinger:~/mere-theresa/
```

---

## 5. Configurer `.env` de production (sur le serveur)

Copier `.env.example` → `.env` puis ajuster :

```env
APP_NAME="Groupe Scolaire Mère Thérèsa"
APP_ENV=production
APP_KEY=                       # généré à l'étape suivante
APP_DEBUG=false
APP_URL=https://votre-domaine.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# Option A — pas de base (forms en TODO) :
DB_CONNECTION=sqlite
# Option B — MySQL (si vous branchez les formulaires) :
# DB_CONNECTION=mysql
# DB_HOST=localhost
# DB_PORT=3306
# DB_DATABASE=uXXXX_bambinos
# DB_USERNAME=uXXXX_admin
# DB_PASSWORD=...

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=contact@votre-domaine.com
MAIL_PASSWORD=...
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="contact@votre-domaine.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Puis, en SSH dans `~/mere-theresa/` :

```bash
php artisan key:generate --force
```

---

## 6. Commandes post-déploiement (SSH)

Depuis `~/mere-theresa/` :

```bash
# Permissions — obligatoire sinon 500 à cause de storage/logs
chmod -R 775 storage bootstrap/cache

# Caches (gros gain de perf en prod)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Si vous exposez des fichiers uploadés depuis storage/app/public
php artisan storage:link
```

> **Sans SSH** (plan mutualisé basique) : le site tourne quand même sans les `*:cache`, mais c'est plus lent. Vous pouvez lancer ces commandes plus tard via le **Terminal du Navigateur** d'Hostinger (hPanel → Avancé → Terminal).

---

## 7. Vérification

- Ouvrir `https://votre-domaine.com` — la page d'accueil doit afficher le Tailwind compilé (fonts Fredoka + Nunito, hero bordeaux).
- Ouvrir les DevTools → onglet **Network** : les fichiers `public/build/assets/app-xxxxx.css` et `.js` doivent renvoyer **200** (pas 404).
- Tester `/a-propos`, `/programmes`, `/contact`.
- En cas de 500 : consulter `storage/logs/laravel.log`.

---

## 8. Re-déploiement (mise à jour)

Workflow à répéter à chaque changement :

```bash
# En local (mere-theresa/)
composer install --no-dev --optimize-autoloader
npm run build

# Push
rsync -avz --delete \
  --exclude='node_modules' --exclude='.env' --exclude='.git' \
  --exclude='storage/logs/*' --exclude='storage/framework/cache/*' \
  ./ uXXXXXXXX@serveur:~/mere-theresa/

# En SSH sur le serveur
cd ~/mere-theresa
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

> **Astuce Tailwind** : si une modif de classe n'apparaît pas après déploiement, c'est presque toujours parce que `npm run build` n'a pas été relancé, ou que `public/build/` n'a pas été synchronisé. Tailwind fait du purge à la compilation — les classes absentes du code source ne sont **pas** dans le CSS final.

---

## 9. Problèmes fréquents

| Symptôme | Cause probable | Correctif |
|----------|---------------|-----------|
| Page blanche / 500 | `.env` manquant ou `APP_KEY` vide | `php artisan key:generate --force` |
| CSS absent, page en "Times New Roman" | `public/build/` non uploadé | Rebuilder en local et re-uploader |
| `The Mix manifest does not exist` | Pareil — `public/build/manifest.json` manquant | idem |
| 403 / Forbidden | Racine documents pas pointée sur `mere-theresa/public` | Corriger dans hPanel |
| 500 sur certaines routes seulement | `storage/` ou `bootstrap/cache/` non-writable | `chmod -R 775 storage bootstrap/cache` |
| Après déploiement, ancien contenu | Cache routes/vues obsolète | `php artisan optimize:clear` puis recacher |
