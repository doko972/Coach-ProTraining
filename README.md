# Coach - Pro Training

Une application web complète de coaching sportif développée avec Laravel 10, permettant de gérer et suivre des programmes d'entraînement personnalisés.

![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-5.0-646CFF?style=for-the-badge&logo=vite&logoColor=white)

---

## Table des matières

- [Présentation](#-présentation)
- [Fonctionnalités](#-fonctionnalités)
- [Technologies](#-technologies)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Structure du projet](#-structure-du-projet)
- [Base de données](#-base-de-données)
- [Utilisation](#-utilisation)
- [Captures d'écran](#-captures-décran)
- [Auteur](#-auteur)

---

## Présentation

**Coach - Pro Training** est une application web moderne qui permet aux utilisateurs de suivre leurs programmes d'entraînement sportif avec un système complet de gestion. L'application propose un dashboard administrateur pour créer et gérer des programmes, et une interface utilisateur intuitive pour suivre ses séances, enregistrer ses performances et consulter ses statistiques.

### Pourquoi ce projet ?

- Remplacer le localStorage par une vraie base de données
- Offrir une interface d'administration complète
- Permettre un suivi personnalisé pour chaque utilisateur
- Créer une application évolutive et professionnelle

---

## Fonctionnalités

### Pour les Administrateurs

- **Dashboard** : Vue d'ensemble avec statistiques (programmes, exercices, séances, utilisateurs)
- **Gestion des programmes** : CRUD complet sur les programmes d'entraînement
- **Gestion des exercices** : Création et modification d'exercices avec catégories et niveaux de difficulté
- **Gestion des séances** : Attribution d'exercices aux séances avec séries et répétitions
- **Navigation fluide** : Basculer facilement entre l'interface admin et utilisateur

### Pour les Utilisateurs

- **Carnet d'entraînement** : 
  - Accès aux programmes actifs
  - Navigation par semaines et séances
  - Saisie des poids et répétitions
  - Validation des séries complétées
  - Sauvegarde automatique en base de données
  
-  **Chronomètre de repos** :
  - Timers prédéfinis (30s, 45s, 1min, 1m30, 2min, 3min)
  - Timer personnalisé
  - Historique des séries
  - Statistiques de repos
  
- **Calculateur 1RM** :
  - Calcul automatique des pourcentages (60% à 95%)
  - Interface intuitive

- **Notes de séance** : Enregistrement des ressentis et observations
- **Statistiques** : Suivi de la progression et du volume total
- **Gestion du profil** : Modification des informations personnelles et mot de passe

### Authentification & Sécurité

- Système d'authentification complet (Laravel Breeze)
- Gestion des rôles (Admin / Utilisateur)
- Middleware de protection des routes
- Réinitialisation de mot de passe par email

---

## Technologies

### Backend
- **Laravel 10** - Framework PHP
- **PHP 8.1+** - Langage serveur
- **MySQL 8.0** - Base de données relationnelle
- **Laravel Breeze** - Authentification

### Frontend
- **Vite 5** - Build tool
- **Sass/SCSS** - Préprocesseur CSS
- **JavaScript ES6+** - Interactivité
- **Blade** - Moteur de templates Laravel

### Outils
- **Composer** - Gestionnaire de dépendances PHP
- **NPM** - Gestionnaire de paquets JavaScript
- **Git** - Contrôle de version

---

## Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP** >= 8.1
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **NPM** >= 9.x
- **MySQL** >= 8.0
- **Git**

Vérifiez vos versions :
```bash
php -v
composer -V
node -v
npm -v
mysql --version
```

---

## Installation

### 1. Cloner le projet
```bash
git clone https://github.com/votre-username/coach-pro-training.git
cd coach-pro-training
```

### 2. Installer les dépendances PHP
```bash
composer install
```

### 3. Installer les dépendances JavaScript
```bash
npm install
npm install sass --save-dev
```

### 4. Configuration de l'environnement

Dupliquez le fichier `.env.example` :
```bash
cp .env.example .env
```

Générez la clé d'application :
```bash
php artisan key:generate
```

### 5. Configurer la base de données

Modifiez le fichier `.env` avec vos paramètres MySQL :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coach_app
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

Créez la base de données :
```sql
CREATE DATABASE coach_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Exécuter les migrations et seeders
```bash
php artisan migrate --seed
```
### 6.1 Supprimer les seeders
```bash
php artisan migrate:fresh
```

Cela va créer :
- Toutes les tables nécessaires
- Un utilisateur administrateur
- 15 exercices pré-configurés
- 1 programme complet (Cycle VOLUME)
- 4 semaines avec 3 séances chacune

### 7. Compiler les assets

**En développement :**
```bash
npm run dev
```

**Pour la production :**
```bash
npm run build
```

### 8. Lancer le serveur
```bash
php artisan serve
```

L'application sera accessible sur : **http://127.0.0.1:8000**

---

## Structure du projet
```
coach-pro-training/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ProgramController.php
│   │   │   │   ├── ExerciseController.php
│   │   │   │   └── SessionController.php
│   │   │   ├── User/
│   │   │   │   └── WorkoutController.php
│   │   │   └── HomeController.php
│   │   └── Middleware/
│   │       └── IsAdmin.php
│   └── Models/
│       ├── Program.php
│       ├── Week.php
│       ├── Session.php
│       ├── Exercise.php
│       ├── SessionExercise.php
│       ├── UserWorkout.php
│       └── UserNote.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── XXXX_XX_XX_create_programs_table.php
│   │   ├── XXXX_XX_XX_create_weeks_table.php
│   │   ├── XXXX_XX_XX_create_sessions_table.php
│   │   ├── XXXX_XX_XX_create_exercises_table.php
│   │   ├── XXXX_XX_XX_create_session_exercises_table.php
│   │   ├── XXXX_XX_XX_create_user_workouts_table.php
│   │   └── XXXX_XX_XX_create_user_notes_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── AdminUserSeeder.php
│       ├── ExerciseSeeder.php
│       └── ProgramSeeder.php
├── resources/
│   ├── js/
│   │   ├── app.js
│   │   ├── menu.js
│   │   └── workout.js
│   ├── scss/
│   │   ├── _variables.scss
│   │   └── app.scss
│   └── views/
│       ├── admin/
│       │   ├── layout.blade.php
│       │   ├── dashboard.blade.php
│       │   ├── programs/
│       │   ├── exercises/
│       │   └── sessions/
│       ├── auth/
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── forgot-password.blade.php
│       │   ├── reset-password.blade.php
│       │   ├── confirm-password.blade.php
│       │   └── verify-email.blade.php
│       ├── profile/
│       │   ├── layout.blade.php
│       │   └── edit.blade.php
│       ├── user/
│       │   ├── layout.blade.php
│       │   └── workout/
│       │       ├── index.blade.php
│       │       ├── chrono.blade.php
│       │       └── calc1rm.blade.php
│       └── welcome.blade.php
├── routes/
│   └── web.php
├── .env.example
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

---

## Base de données

### Schéma des tables

#### `users`
- Utilisateurs de l'application
- Champ `is_admin` pour distinguer les administrateurs

#### `programs`
- Programmes d'entraînement (ex: Cycle VOLUME)
- Contient les informations générales (phase, objectif)

#### `weeks`
- Semaines d'un programme (1 à 4)
- Relation : `belongs to Program`

#### `sessions`
- Séances d'entraînement (ex: Séance 1 - Pecs/Épaules/Triceps)
- Relation : `belongs to Week`

#### `exercises`
- Liste des exercices disponibles
- Catégories : Pectoraux, Dos, Jambes, etc.
- Niveaux : Débutant, Intermédiaire, Avancé

#### `session_exercises`
- Table pivot : lie les exercices aux séances
- Contient les séries et répétitions

#### `user_workouts`
- Enregistrements des performances utilisateur
- Poids, répétitions, validation par série

#### `user_notes`
- Notes de séance des utilisateurs

### Seeders

Le projet inclut 3 seeders principaux :

**1. AdminUserSeeder**
- Crée un compte administrateur
- Email : `admin@coach.com`
- Mot de passe : `password`

**2. ExerciseSeeder**
- 15 exercices pré-configurés :
  - Développé couché
  - Développé militaire
  - Squat
  - Tractions
  - Curl incliné
  - Et plus encore...

**3. ProgramSeeder**
- Programme "Cycle VOLUME" complet
- 4 semaines
- 3 séances par semaine
- 5 exercices par séance
- Total : 12 séances configurées

---

## Utilisation

### Première connexion

1. **Accédez à l'application** : http://127.0.0.1:8000
2. **Connectez-vous en tant qu'admin** :
   - Email : `admin@coach.com`
   - Mot de passe : `password`

### Interface Administrateur

Accédez au dashboard admin via le lien "Admin" dans le menu ou directement :
- **URL** : http://127.0.0.1:8000/admin/dashboard

**Actions disponibles :**
- Créer/modifier/supprimer des programmes
- Gérer les exercices
- Créer des séances et leur assigner des exercices
- Voir les statistiques globales

### Interface Utilisateur

**Carnet d'entraînement :**
- Sélectionnez une semaine (1-4)
- Choisissez une séance (1-3)
- Saisissez vos performances (poids, répétitions)
- Validez les séries complétées (✓)
- Cliquez sur "Sauvegarder"

**Chronomètre :**
- Sélectionnez un temps prédéfini ou personnalisé
- Utilisez Pause/Reprendre/Stop
- Consultez l'historique de vos séries

**Calculateur 1RM :**
- Entrez votre 1RM (en kg)
- Obtenez automatiquement tous les pourcentages

---

## Captures d'écran

### Page d'accueil
<img width="723" height="907" alt="Capture d'écran 2025-10-26 191722" src="https://github.com/user-attachments/assets/01b90976-e6c1-4d80-9a73-5c82eb9e7bb7" />

### Dashboard Admin
<img width="665" height="668" alt="Capture d'écran 2025-10-26 191802" src="https://github.com/user-attachments/assets/6efbcdbd-09a3-414f-a36a-1df97f839f42" />

### Calculateur du 1 RM
<img width="651" height="367" alt="Capture d'écran 2025-10-26 191810" src="https://github.com/user-attachments/assets/0015bb03-694d-4f42-8ac0-ecad42a0412f" />


### Chronomètre
<img width="640" height="487" alt="Capture d'écran 2025-10-26 191823" src="https://github.com/user-attachments/assets/304f58cc-359c-4950-87e8-e39c4c358e5d" />

### Page d'inscription
<img width="446" height="622" alt="Capture d'écran 2025-10-26 191733" src="https://github.com/user-attachments/assets/8e93f14c-8bcf-4521-a792-32e21a1deebf" />

---

## Identifiants par défaut

**Administrateur :**
- Email : `admin@coach.com`
- Mot de passe : `password`

**Important** : Changez ces identifiants en production !

---

## Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le projet
2. Créez une branche (`git checkout -b feature/amelioration`)
3. Committez vos changements (`git commit -m 'Ajout d'une fonctionnalité'`)
4. Pushez vers la branche (`git push origin feature/amelioration`)
5. Ouvrez une Pull Request

---

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

## Auteur

**doko972**

- GitHub : [@doko972](https://github.com/doko972)
- Email : doko972@gmail.com

---

## 🙏 Remerciements

- Laravel pour le framework exceptionnel
- La communauté open-source
- Tous les contributeurs

---

## 📞 Support

Pour toute question ou problème :
- Ouvrez une [issue](https://github.com/votre-username/coach-pro-training/issues)
- Consultez la [documentation Laravel](https://laravel.com/docs)

---
