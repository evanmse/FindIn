<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIN - Gestion des Compétences</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="findin-header">
        <div class="header-container">
            <a href="/" class="findin-logo">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="4" y="4" width="24" height="24" rx="6" fill="#2563eb"/>
                    <path d="M16 10L20 18H12L16 10Z" fill="white"/>
                </svg>
                <span>FindIN</span>
            </a>

            <nav class="nav-links">
                <a href="/" class="nav-link">Accueil</a>
                <a href="#features" class="nav-link">Fonctionnalités</a>
                <a href="/pricing" class="nav-link">Tarifs</a>
                <a href="/about" class="nav-link">À propos</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/dashboard" class="btn btn-primary">Tableau de bord</a>
                    <a href="/logout" class="nav-link"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-primary">Se connecter</a>
                <?php endif; ?>
                <button class="theme-toggle" id="themeToggle" aria-label="Basculer thème">
                    <i class="fas fa-moon theme-icon"></i>
                </button>
            </nav>

            <button class="nav-toggle" id="navToggle" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>

        <nav class="nav-panel" id="navPanel">
            <a href="/">Accueil</a>
            <a href="#features">Fonctionnalités</a>
            <a href="/pricing">Tarifs</a>
            <a href="/about">À propos</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/dashboard">Tableau de bord</a>
                <a href="/logout">Déconnexion</a>
            <?php else: ?>
                <a href="/login">Se connecter</a>
                <a href="/register">S'inscrire</a>
            <?php endif; ?>
        </nav>
    </header>
