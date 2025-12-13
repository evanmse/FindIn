# FindIN - Plateforme de Gestion des Compétences (MVP)

Application web pour la gestion des compétences en entreprise, développée avec PHP, MySQL, HTML, CSS et JavaScript.

## 🚀 Fonctionnalités


## 📦 Installation

### 1. Prérequis

### 2. Clone du projet
```bash
git clone https://github.com/votre-username/findin-mvp.git
cd findin-mvp
```

## 🔐 Démarrage HTTPS

### Option 1 : Démarrage Simple (HTTP)
```bash
php start.php
# ou
php -S localhost:8000 router.php
```

### Option 2 : Démarrage Sécurisé (HTTPS avec Caddy)
```bash
# Installer Caddy (macOS)
brew install caddy

# Terminal 1 : Lancer le serveur PHP
php start.php

# Terminal 2 : Lancer le proxy HTTPS
caddy run

# Accéder à : https://localhost:8443
```

### Option 3 : Script Automatisé
```bash
php start_secure.php
# Génère automatiquement les certificats SSL
```

### Headers de Sécurité Inclus
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: DENY`
- `X-XSS-Protection: 1; mode=block`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Strict-Transport-Security` (HSTS) en mode HTTPS
- `Permissions-Policy`

## 🏗️ Architecture

MVC (Model-View-Controller)
├── Models/      ← Logique métier et données
├── Views/       ← Templates HTML
├── Controllers/ ← Contrôleurs d'actions
└── Assets/      ← CSS, JS, Images

## Notes CV parsing & uploads

- CV parsing benefits from the `pdftotext` binary (part of poppler). On macOS install with:

	brew install poppler

- For improved in-PHP PDF parsing install composer dependencies:

	composer install

	This will install `smalot/pdfparser` which the code will automatically use when available.

- Upload locations: `uploads/cvs/`, `uploads/photos/`, `uploads/meetings/`, `uploads/tests/`, `uploads/reports/`.
- CV upload limits: 8MB, allowed: pdf, docx, txt. Photo limits: 5MB, allowed: jpg/jpeg/png/webp.
