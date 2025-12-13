<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation - FindIN</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg-primary: #0a0118; --bg-secondary: #1a0d2e; --bg-card: #241538; --text-primary: #ffffff; --text-secondary: #a0a0a0; --accent-purple: #9333ea; --accent-blue: #3b82f6; --accent-green: #10b981; --border-color: rgba(255,255,255,0.1); }
        [data-theme="light"] { --bg-primary: #f8fafc; --bg-secondary: #ffffff; --bg-card: #ffffff; --text-primary: #1e293b; --text-secondary: #64748b; --border-color: rgba(0,0,0,0.1); }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-primary); color: var(--text-primary); line-height: 1.8; }
        .header { background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); padding: 1rem 2rem; position: sticky; top: 0; z-index: 100; }
        .header-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: var(--text-primary); font-weight: 700; font-size: 1.5rem; }
        .logo-icon { width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent-purple), var(--accent-blue)); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; }
        .nav-links { display: flex; gap: 2rem; align-items: center; }
        .nav-links a { color: var(--text-secondary); text-decoration: none; font-weight: 500; }
        .theme-toggle { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 50%; width: 40px; height: 40px; cursor: pointer; color: var(--text-primary); display: flex; align-items: center; justify-content: center; }
        .hero { padding: 4rem 2rem; text-align: center; background: linear-gradient(135deg, rgba(147,51,234,0.1), rgba(59,130,246,0.05)); }
        .hero h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; background: linear-gradient(135deg, var(--accent-purple), var(--accent-blue)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero p { color: var(--text-secondary); max-width: 600px; margin: 0 auto; }
        .content { max-width: 1000px; margin: 0 auto; padding: 3rem 2rem; }
        .search-box { max-width: 500px; margin: 0 auto 3rem; position: relative; }
        .search-box input { width: 100%; padding: 1rem 1rem 1rem 3rem; border-radius: 12px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-primary); font-size: 1rem; }
        .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); }
        .doc-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
        .doc-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 2rem; transition: all 0.3s; text-decoration: none; }
        .doc-card:hover { transform: translateY(-5px); border-color: var(--accent-purple); }
        .doc-card-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; }
        .doc-card-icon.purple { background: rgba(147,51,234,0.2); color: var(--accent-purple); }
        .doc-card-icon.blue { background: rgba(59,130,246,0.2); color: var(--accent-blue); }
        .doc-card-icon.green { background: rgba(16,185,129,0.2); color: var(--accent-green); }
        .doc-card h3 { font-size: 1.2rem; margin-bottom: 0.5rem; color: var(--text-primary); }
        .doc-card p { color: var(--text-secondary); font-size: 0.9rem; }
        .section-title { font-size: 1.5rem; margin: 3rem 0 1.5rem; color: var(--text-primary); }
        .faq-item { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; margin-bottom: 1rem; }
        .faq-question { padding: 1.25rem; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 500; }
        .faq-answer { padding: 0 1.25rem 1.25rem; color: var(--text-secondary); display: none; }
        .faq-item.active .faq-answer { display: block; }
        .faq-item.active .faq-icon { transform: rotate(180deg); }
        .footer { background: var(--bg-secondary); border-top: 1px solid var(--border-color); padding: 3rem 2rem; text-align: center; margin-top: 3rem; }
        .footer-links { display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
        .footer-links a { color: var(--text-secondary); text-decoration: none; font-size: 0.9rem; }
        @media (max-width: 768px) { .nav-links { display: none; } .hero h1 { font-size: 2rem; } }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <a href="/" class="logo"><div class="logo-icon"><i class="fas fa-search"></i></div><span>FindIN</span></a>
            <nav class="nav-links">
                <a href="/">Accueil</a><a href="/about">À propos</a><a href="/contact">Contact</a>
                <button class="theme-toggle" id="themeToggle"><i class="fas fa-moon"></i></button>
            </nav>
        </div>
    </header>

    <section class="hero">
        <h1>Documentation</h1>
        <p>Tout ce dont vous avez besoin pour maîtriser FindIN et optimiser votre recherche de compétences</p>
    </section>

    <div class="content">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher dans la documentation...">
        </div>

        <div class="doc-grid">
            <a href="#" class="doc-card">
                <div class="doc-card-icon purple"><i class="fas fa-rocket"></i></div>
                <h3>Démarrage rapide</h3>
                <p>Créez votre compte et configurez votre profil en quelques minutes.</p>
            </a>
            <a href="#" class="doc-card">
                <div class="doc-card-icon blue"><i class="fas fa-user-circle"></i></div>
                <h3>Gestion du profil</h3>
                <p>Personnalisez votre profil, ajoutez vos compétences et téléchargez votre CV.</p>
            </a>
            <a href="#" class="doc-card">
                <div class="doc-card-icon green"><i class="fas fa-search"></i></div>
                <h3>Recherche avancée</h3>
                <p>Maîtrisez les filtres et opérateurs pour des recherches précises.</p>
            </a>
            <a href="#" class="doc-card">
                <div class="doc-card-icon purple"><i class="fas fa-project-diagram"></i></div>
                <h3>Gestion de projets</h3>
                <p>Créez des projets et trouvez les bons collaborateurs.</p>
            </a>
            <a href="#" class="doc-card">
                <div class="doc-card-icon blue"><i class="fas fa-chart-line"></i></div>
                <h3>Tableau de bord</h3>
                <p>Analysez vos statistiques et suivez votre activité.</p>
            </a>
            <a href="#" class="doc-card">
                <div class="doc-card-icon green"><i class="fas fa-cog"></i></div>
                <h3>Paramètres</h3>
                <p>Configurez vos préférences et gérez votre compte.</p>
            </a>
        </div>

        <h2 class="section-title">Questions fréquentes</h2>

        <div class="faq-item">
            <div class="faq-question">Comment créer un compte ? <i class="fas fa-chevron-down faq-icon"></i></div>
            <div class="faq-answer">Cliquez sur "S'inscrire" en haut de la page, remplissez le formulaire avec vos informations et validez votre email.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Comment ajouter mes compétences ? <i class="fas fa-chevron-down faq-icon"></i></div>
            <div class="faq-answer">Rendez-vous sur votre profil, cliquez sur "Gérer mes compétences" et ajoutez-les une par une avec votre niveau d'expertise.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Comment rechercher un collaborateur ? <i class="fas fa-chevron-down faq-icon"></i></div>
            <div class="faq-answer">Utilisez la barre de recherche pour trouver des profils par compétence, département ou nom. Utilisez les filtres pour affiner.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question">Mes données sont-elles sécurisées ? <i class="fas fa-chevron-down faq-icon"></i></div>
            <div class="faq-answer">Oui, nous utilisons le chiffrement SSL, conformité RGPD et suivons les principes de Privacy by Design.</div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-links"><a href="/about">À propos</a><a href="/contact">Contact</a><a href="/privacy">Confidentialité</a><a href="/terms">Conditions</a><a href="/mentions_legales">Mentions légales</a></div>
        <p>&copy; 2024 FindIN. Tous droits réservés.</p>
    </footer>

    <script>
        const t=document.getElementById('themeToggle'),h=document.documentElement,i=t.querySelector('i'),s=localStorage.getItem('theme')||'dark';
        h.setAttribute('data-theme',s);i.className=s==='dark'?'fas fa-moon':'fas fa-sun';
        t.addEventListener('click',()=>{const n=h.getAttribute('data-theme')==='dark'?'light':'dark';h.setAttribute('data-theme',n);localStorage.setItem('theme',n);i.className=n==='dark'?'fas fa-moon':'fas fa-sun';});
        document.querySelectorAll('.faq-question').forEach(q => q.addEventListener('click', () => q.parentElement.classList.toggle('active')));
    </script>
</body>
</html>
