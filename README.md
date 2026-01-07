# Portail EMSI

Un portail web complet pour la gestion des candidats, recruteurs, offres et contenus — construit avec Laravel. Ce dépôt contient l'application backend + assets front-end et les scripts de migration/seeders pour initialiser les données.

**Statut:** Production-ready (ou en cours selon votre état actuel)

**Tech stack:** PHP 8+, Laravel, MySQL/Postgres, Composer, Vite, Node.js, Tailwind/Bootstrap (selon config)

**Principales fonctionnalités**
- Gestion des utilisateurs (candidats, recruteurs, admins)
- CRUD pour offres d'emploi, candidatures, documents et CV
- Système de messages et notifications
- Gestion de médias et documents associés aux profils
- Seeders et migrations pour initialisation rapide

**Avant de commencer**
- PHP >= 8.0
- Composer
- Node.js (v16+) et npm/yarn
- Base de données (MySQL ou Postgres)

Installation (locale)

1. Cloner le dépôt

```bash
git clone <votre-repo-url>
cd portail-emsi
```

2. Installer les dépendances PHP et JS

```bash
composer install
npm install
# ou
# yarn install
```

3. Copier le fichier d'environnement

```bash
cp .env.example .env
```

4. Configurer `.env`
- `APP_NAME`, `APP_URL`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Paramètres mail si nécessaire

5. Générer la clé d'application

```bash
php artisan key:generate
```

6. Lancer les migrations et seeders

```bash
php artisan migrate --seed
```

7. Compiler les assets front-end

```bash
npm run dev
# ou
# npm run build (pour production)
```

8. Lancer le serveur local

```bash
php artisan serve
```

Utilisation

- Accéder à l'URL fournie par `php artisan serve` (ex: http://127.0.0.1:8000)
- Se connecter avec les comptes seedés (consulter les seeders pour identifiants)

Tests

```bash
php artisan test
```

Déploiement

- Utiliser un serveur compatible PHP + Composer
- Configurer l'environnement et variables (`.env`) sur le serveur
- Exécuter `composer install --no-dev`, `php artisan migrate --force`, `npm run build`
- Mettre en place `storage` et `bootstrap/cache` avec les permissions adéquates

Structure principale du dépôt

- `app/` : logique applicative (modèles, contrôleurs)
- `database/migrations` et `database/seeders` : gestion du schéma et données initiales
- `resources/` : vues, assets front-end, CSS/JS
- `public/` : point d'entrée web

Contribution

Merci pour votre intérêt !

- Ouvrez une issue pour discuter des changements importants.
- Pour proposer une fonctionnalité ou correction : créez une branche (`feature/ma-fonction`) et ouvrez une PR claire avec description et tests si possible.
- Respectez les standards PSR et les conventions de commits (ex: Conventional Commits) si appliqué.

Bonnes pratiques

- Garder les secrets hors du dépôt (utiliser les variables d'environnement)
- Ajouter des migrations pour tout changement de schéma
- Ajouter des tests pour nouvelles fonctionnalités critiques

Licence

Précisez ici la licence utilisée (ex : MIT). Si vous n'avez pas encore choisi, ajoutez un fichier `LICENSE`.

Contact

- Mainteneur: Votre nom ou organisation
- Email: votre@email.tld
- Slack / Discord / autre: (optionnel)

Remarques / TODO
- Documenter les points d'API exposés
- Ajouter un guide de déploiement CI/CD (GitHub Actions / autre)

Fichier créé : [README.md](README.md)
