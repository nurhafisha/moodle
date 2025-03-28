# Moodle Simplifié

Moodle Simplifié est un projet de gestion d'unités d'enseignement (UE) pour les universités, simplifiant les interactions entre les administrateurs, professeurs et étudiants.

## 🛠 Technologies Utilisées
- **Backend** : Symfony 7
- **Base de Données** : MySQL
- **Serveur** : Apache (via XAMPP)
- **Frontend** : HTML, CSS, JavaScript 

## 🗒  Prérequis
- XAMPP ou tout autre environnement compatible avec Apache et MySQL
- PHP 8.2 ou supérieur
- Composer
- Symfony CLI

## 🔄 Installation
1. **Cloner le projet**
```bash
git clone https://github.com/votre-repo/moodle-simplifie.git
cd moodle-simplifie
```

2. **Installer les dépendances**
```bash
composer install
```
3. **Installing Encore**
- Make sure you download [node.js]([https://github.com/user/repo/blob/branch/other_file.md](https://nodejs.org/en/download/))
- Run these commands to install both the PHP and JavaScript dependencies in your project:
```bash
composer require symfony/webpack-encore-bundle
npm install
```

4. **Configurer la base de données**
- Créez une base de données MySQL :
```sql
CREATE DATABASE moodle_simplifie;
```
- Configurez le fichier `.env` avec vos identifiants MySQL :
```
DATABASE_URL="mysql://root:@localhost:3306/moodle_simplifie"
```

5. **Exécuter les migrations**
```bash
php bin/console doctrine:migrations:migrate
```

6. **Lancer le serveur Symfony**
```bash
symfony server:start
```
Accédez à votre application via `http://localhost:8000`

---

## 👥 Rôles et Fonctionnalités

### 👨‍💼 Administrateur
- Création et gestion des utilisateurs (professeurs, étudiants, autres admins).
- Gestion des UE.
- Attribution des UE aux professeurs et étudiants.

### 👨‍🏫 Professeur
- Création, modification et suppression de posts (messages et fichiers).
- Visualisation des posts dans les UE assignées.
- Accès à la liste des inscrits.

### 👨‍🎓 Étudiant
- Visualisation des posts (messages et fichiers).
- Téléchargement des fichiers partagés.
- Consultation des dernières actualités et de la liste des inscrits.

---

## 🔧 Commandes Utiles
- Lancer le serveur Symfony :
```bash
symfony server:start
```
- Appliquer les migrations :
```bash
php bin/console doctrine:migrations:migrate
```
- Créer un administrateur par défaut :
```bash
php bin/console app:create-admin username password
```

---

## 📄 Licence
Ce projet est sous licence MIT. Vous êtes libre de le modifier et de le redistribuer selon les termes de la licence.

---

