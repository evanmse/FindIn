<<<<<<< HEAD
# 🎯 FindIN - Plateforme de Gestion des Compétences

[![Version](https://img.shields.io/badge/version-2.0.0-blue.svg)](CHANGELOG.md)
[![PHP](https://img.shields.io/badge/PHP-8.2+-purple.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](License.md)
=======
# FindIN - Plateforme de Gestion des Compétences

Application web pour la gestion des compétences en entreprise.
>>>>>>> origin/main

**FindIN** est une plateforme intelligente de gestion et de valorisation des compétences en entreprise. Elle permet d'identifier, valider et développer les talents cachés au sein des équipes.

<<<<<<< HEAD
## 🚀 Démarrage Rapide
=======
- **Gestion des utilisateurs** : Employés, Managers, RH, Administrateurs
- **Compétences** : Création, évaluation, suivi des niveaux
- **Dashboard** : 7 pages interactives (Accueil, Projets, Réunions, Documents, Certifications, Messages, Profil)
- **Recherche** : Recherche de collaborateurs par compétences
- **Authentification** : Connexion standard + Google OAuth
>>>>>>> origin/main

### Prérequis
- PHP 8.2+
- MySQL 8.0+ ou SQLite
- Apache (XAMPP recommandé)

<<<<<<< HEAD
### Installation Rapide

1. **Cloner le projet**
```bash
git clone https://github.com/votre-username/FindIn.git
=======
### Prérequis
- PHP 8.0+
- MySQL 5.7+ (XAMPP recommandé)
- Navigateur moderne

### Configuration

1. **Cloner le projet**
```bash
git clone https://github.com/BNWHITE/FindIn.git
>>>>>>> origin/main
cd FindIn
```

2. **Configurer la base de données**
<<<<<<< HEAD
=======
- Démarrer MySQL (XAMPP)
- Créer la base \`gestion_competences\`
- Importer le schéma SQL

3. **Configurer les variables** (optionnel)
```bash
export DB_HOST=127.0.0.1
export DB_NAME=gestion_competences
export DB_USER=root
export DB_PASS=
```

## 🚀 Démarrage

>>>>>>> origin/main
```bash
php scripts/setup/setup_mysql.php
```

<<<<<<< HEAD
3. **Configurer Apache**
```bash
bash scripts/update_apache.sh
```

4. **Accéder au site**
```
http://findin.local/
```

### 🔐 Comptes de test
- **Admin** : `admin@findin.fr` / `admin123`
- **User** : `test@findin.fr` / `test123`
=======
Accéder à : http://localhost:8000

## 🔐 Comptes de test

| Email | Mot de passe | Rôle |
|-------|--------------|------|
| admin@findin.fr | admin123 | Admin |
| test@findin.fr | test123 | Employé |
>>>>>>> origin/main

## 📚 Documentation Complète

<<<<<<< HEAD
- 📖 [Guide d'installation détaillé](docs/guides/INSTALLATION.md)
- 💻 [Guide de développement](docs/guides/DEVELOPMENT.md)
- 🏗️ [Architecture technique](docs/technical/ARCHITECTURE.md)
- 🗄️ [Documentation base de données](docs/technical/DATABASE.md)
- 📁 [Structure du projet](docs/STRUCTURE.md)

---

## ✨ Fonctionnalités principales

### 👤 Gestion des utilisateurs
- 🔐 Authentification sécurisée (bcrypt)
- 👥 Gestion des rôles (Employé, Manager, RH, Admin)
- 📊 Profils détaillés avec compétences
- 📄 Upload et parsing de CV

### 🎯 Gestion des compétences
- 📝 Déclaration de compétences par les utilisateurs
- ✅ Validation par les managers
- 🏷️ Catégorisation (savoir-faire, savoir-être, expertise)
- 📈 Niveaux de maîtrise (1-5)

### 🔍 Recherche avancée
- 🎯 Recherche par compétences
- 🔢 Filtrage par niveau
- 🏢 Filtrage par département
- 📊 Résultats pertinents

### 📊 Tableaux de bord
- 📈 Vue d'ensemble des compétences
- 📊 Statistiques par département
- 🎯 Besoins en compétences
- 📉 Analyse des écarts

### 💼 Gestion des projets
- 📋 Création de projets
- 🎯 Définition des besoins en compétences
- 👥 Affectation des ressources
- 📊 Suivi de l'avancement

---

## 🏗️ Structure du Projet

```
FindIn/
├── public/              # Point d'entrée web
│   ├── assets/         # CSS, JS, images
│   └── index.php       # Front controller
├── src/                # Code source
│   ├── Controllers/    # Contrôleurs MVC
│   ├── Models/         # Modèles de données
│   ├── Views/          # Vues et templates
│   └── Config/         # Configuration
├── database/           # Schémas et migrations SQL
├── storage/            # Uploads et logs
├── docs/               # Documentation complète
└── scripts/            # Scripts utilitaires
```

Voir [docs/STRUCTURE.md](docs/STRUCTURE.md) pour plus de détails.

---

## 🛠️ Technologies

- **Backend** : PHP 8.2, MVC Pattern
- **Base de données** : MySQL 8.0 / SQLite
- **Frontend** : HTML5, CSS3, JavaScript Vanilla
- **Serveur** : Apache 2.4

---

## 📝 Changelog

Voir [CHANGELOG.md](CHANGELOG.md) pour l'historique complet des versions.

## 🤝 Contribution

Les contributions sont les bienvenues ! Consultez le [guide de développement](docs/guides/DEVELOPMENT.md) pour commencer.

## 📄 License

MIT License - voir [LICENSE](License.md) pour plus de détails.

## 👤 Auteur

**FindIN Team**  
📧 Contact : support@findin.fr

---

**⭐ Si ce projet vous plaît, n'hésitez pas à lui donner une étoile !**

### Tableau de bord
![Dashboard](docs/screenshots/dashboard.png)

### Recherche de compétences
![Recherche](docs/screenshots/search.png)

---

## 🧪 Tests

```bash
# Tests unitaires
php tests/run_unit_tests.php

# Tests fonctionnels
php tests/run_feature_tests.php
```

---

## 🤝 Contribution

Les contributions sont les bienvenues ! Voici comment contribuer :

1. **Fork** le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'feat: Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une **Pull Request**

Voir [CONTRIBUTING.md](CONTRIBUTING.md) pour plus de détails.

---

## 📝 Conventions de code

- **PHP** : PSR-12
- **Git commits** : Conventional Commits
- **Branches** : GitFlow

Voir [docs/technical/CONVENTIONS.md](docs/technical/CONVENTIONS.md)

---

## 🔒 Sécurité

- ✅ Mots de passe hashés avec bcrypt
- ✅ Protection XSS (échappement HTML)
- ✅ Protection CSRF (tokens)
- ✅ Protection SQL Injection (requêtes préparées)
- ✅ Sessions sécurisées
- ✅ Validation des entrées utilisateur

Pour signaler une vulnérabilité : security@findin.com

---

## 📜 Licence

Ce projet est sous licence MIT. Voir [License.md](License.md) pour plus d'informations.

---

## 👥 Équipe

- **Lead Developer** : [Votre nom]
- **Contributors** : Voir [CONTRIBUTORS.md](CONTRIBUTORS.md)

---

## 📞 Support

- 📧 Email : support@findin.com
- 🐛 Issues : [GitHub Issues](https://github.com/votre-repo/FindIn/issues)
- 📖 Documentation : [docs/](docs/)
- 💬 Discord : [Rejoindre](https://discord.gg/findin)

---

## 🗺️ Roadmap

### Version 1.1 (Q1 2026)
- [ ] API REST complète
- [ ] Export PDF des compétences
- [ ] Notifications par email
- [ ] Tableau de bord RH avancé

### Version 2.0 (Q2 2026)
- [ ] Application mobile
- [ ] Intelligence artificielle pour recommandations
- [ ] Intégration Slack/Teams
- [ ] Gamification

Voir [ROADMAP.md](ROADMAP.md) pour le planning détaillé.

---

## 📊 Statistiques du projet

![GitHub stars](https://img.shields.io/github/stars/votre-repo/FindIn)
![GitHub forks](https://img.shields.io/github/forks/votre-repo/FindIn)
![GitHub issues](https://img.shields.io/github/issues/votre-repo/FindIn)

---

## 🌟 Remerciements

Merci à tous les contributeurs qui ont participé à ce projet !

---

**Fait avec ❤️ par l'équipe FindIN**
=======
\`\`\`
FindIN/
├── index.php          # Point d'entrée
├── router.php         # Routage des URLs
├── start.php          # Démarrage serveur
├── config/            # Configuration
├── controllers/       # Contrôleurs MVC
├── models/            # Modèles de données
├── views/             # Templates HTML
├── assets/            # CSS, JS, Images
└── uploads/           # Fichiers uploadés
\`\`\`

## 📝 Licence

MIT License - Voir [License.md](License.md)
>>>>>>> origin/main
