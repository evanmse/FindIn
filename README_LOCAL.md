# Lancer le site en local

Instructions rapides pour lancer cette application PHP localement (macOS) — deux modes : PHP built-in (rapide) ou XAMPP (MySQL).

1) Ouvrez un terminal et placez-vous à la racine du projet :

```bash
cd "/Users/s.sy/Documents/ISEP/APP INFO/FINDIN MVP/findin-mvp-main"
```

Mode A — PHP intégré (SQLite, rapide)
```bash
php -S localhost:8000 -t .
```
Puis ouvrez : http://localhost:8000

Mode B — XAMPP / Apache + MySQL (préférable pour importer `gestion_competences.sql`)
- Placez le dossier du projet dans le répertoire htdocs de XAMPP (par ex. /Applications/XAMPP/htdocs/findin)
- Démarrez Apache et MySQL via le panneau XAMPP
- Importez la base SQL fournie (`gestion_competences.sql`) depuis phpMyAdmin (créez d'abord la base `gestion_competences` si nécessaire)
- Modifiez `config/database.php` : changez `DB_TYPE` en `mysql` (ou définissez une variable d'environnement `DB_TYPE=mysql`) et vérifiez `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`.

Exemple (macOS : export temporaire pour test) :
```bash
export DB_TYPE=mysql
export DB_HOST=127.0.0.1
export DB_PORT=3306
export DB_NAME=gestion_competences
export DB_USER=root
export DB_PASS=""
php -S localhost:8000 -t .
```

Notes importantes :
- Le routeur utilise `index.php` à la racine et charge `views/index.php` comme page d'accueil.
- Les assets (CSS/JS/images) sont servis depuis le dossier `assets/`.
- Si vous utilisez MySQL/XAMPP, importez `gestion_competences.sql` (fichier attaché) dans phpMyAdmin avant d'indiquer `DB_TYPE=mysql`.

Prochaines étapes que je peux faire pour vous :
- Finaliser l'intégration des images (hero mockup, logos) dans `assets/img/` et ajuster responsive
- Déplacer les styles embarqués dans `views/index.php` vers `assets/css/style.css` (si vous souhaitez un fichier unique)
- Mettre en place un système d'authentification complet (hash des mots de passe, sessions sécurisées)

Si vous voulez que je termine l'un de ces points maintenant, dites lequel et je l'implémente.