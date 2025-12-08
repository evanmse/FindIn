<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIN - Connexion</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        /* Auth Pages Styles */
        .auth-container {
            min-height: 100vh;
            display: flex;
            background: var(--bg-secondary);
        }

        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            color: white;
            display: none;
        }

        @media (min-width: 1024px) {
            .auth-left {
                display: flex;
            }
        }

        .auth-left-content h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 800;
        }

        .auth-left-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 400px;
        }

        .auth-left-features {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .feature-item {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .feature-item i {
            font-size: 1.5rem;
            margin-top: 0.25rem;
        }

        .feature-item strong {
            display: block;
            margin-bottom: 0.25rem;
        }

        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: var(--bg-primary);
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
        }

        .auth-header {
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .auth-logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 1rem;
        }

        .auth-header h1 {
            font-size: 1.75rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .auth-header p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            background: var(--bg-secondary);
        }

        .form-group.error .form-input {
            border-color: #ef4444;
        }

        .form-error {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .remember-me input {
            cursor: pointer;
        }

        .forgot-password {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--color-secondary);
        }

        .btn-submit {
            width: 100%;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 2rem 0;
            color: var(--text-muted);
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        .oauth-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .oauth-btn {
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            background: var(--bg-primary);
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .oauth-btn:hover {
            border-color: var(--color-primary);
            background: var(--bg-secondary);
        }

        .auth-footer {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            text-align: center;
            color: var(--text-secondary);
        }

        .auth-footer p {
            margin-bottom: 0.5rem;
        }

        .auth-link {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-link:hover {
            color: var(--color-secondary);
        }

        .info-box {
            background: var(--bg-secondary);
            border-left: 4px solid var(--color-primary);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .info-box strong {
            color: var(--text-primary);
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }

            .auth-right {
                padding: 2rem 1rem;
            }

            .auth-card {
                max-width: 100%;
            }

            .auth-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>

    <div class="auth-container">
        <!-- Left Side (Hidden on mobile) -->
        <div class="auth-left">
            <div class="auth-left-content">
                <h1>Bienvenue sur FindIN</h1>
                <p>Révélez et développez les talents cachés de votre organisation</p>

                <div class="auth-left-features">
                    <div class="feature-item">
                        <i class="fas fa-search" style="color: rgba(255,255,255,0.8);"></i>
                        <div>
                            <strong>Recherche Intelligente</strong>
                            <span style="opacity: 0.9; font-size: 0.9rem;">Trouvez les compétences facilement</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-award" style="color: rgba(255,255,255,0.8);"></i>
                        <div>
                            <strong>Validation Complète</strong>
                            <span style="opacity: 0.9; font-size: 0.9rem;">Validez et développez vos compétences</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-chart-line" style="color: rgba(255,255,255,0.8);"></i>
                        <div>
                            <strong>Analytics Puissants</strong>
                            <span style="opacity: 0.9; font-size: 0.9rem;">Suivez votre progression en temps réel</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="auth-right">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="auth-logo">
                        <i class="fas fa-triangle"></i>
                    </div>
                    <h1>Connexion</h1>
                    <p>Accédez à votre compte FindIN</p>
                </div>

                <form method="POST" action="/login">
                    <div class="form-group">
                        <label class="form-label" for="email">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="vous@exemple.com"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">
                            <i class="fas fa-lock"></i> Mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="••••••••"
                            required
                        >
                    </div>

                    <div class="form-footer">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            Se souvenir de moi
                        </label>
                        <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" class="btn-submit">
                        Se connecter
                    </button>
                </form>

                <div class="auth-divider">OU</div>

                <div class="oauth-buttons">
                    <button class="oauth-btn">
                        <i class="fab fa-google"></i> Google
                    </button>
                    <button class="oauth-btn">
                        <i class="fab fa-microsoft"></i> Microsoft
                    </button>
                </div>

                <div class="info-box">
                    <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                    <strong>Test</strong> : Utilisez admin@findin.com / password
                </div>

                <div class="auth-footer">
                    <p>Pas encore inscrit ?</p>
                    <p><a href="/register" class="auth-link">Créer un compte</a></p>
                    <p style="margin-top: 1rem; font-size: 0.85rem;">
                        <a href="/" style="color: var(--text-secondary); text-decoration: none;">
                            ← Retour à l'accueil
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>
