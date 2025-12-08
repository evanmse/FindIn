<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIN - Inscription</title>
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
            max-width: 500px;
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-row.full {
            grid-template-columns: 1fr;
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

        .form-input,
        .form-select {
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

        .form-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        .form-input::placeholder,
        .form-select::placeholder {
            color: var(--text-muted);
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            background: var(--bg-secondary);
        }

        .form-group.error .form-input,
        .form-group.error .form-select {
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

        .password-strength {
            height: 4px;
            background: var(--bg-secondary);
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .password-strength-fill {
            height: 100%;
            background: #ef4444;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .password-strength-fill.weak {
            width: 33%;
            background: #ef4444;
        }

        .password-strength-fill.medium {
            width: 66%;
            background: #f59e0b;
        }

        .password-strength-fill.strong {
            width: 100%;
            background: #10b981;
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
            margin-top: 1rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .terms {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin: 1.5rem 0;
        }

        .terms input {
            margin-right: 0.5rem;
            cursor: pointer;
        }

        .terms a {
            color: var(--color-primary);
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
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
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #166534;
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

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
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
                <h1>Rejoignez FindIN</h1>
                <p>Commencez à gérer et développer vos compétences</p>

                <div class="auth-left-features">
                    <div class="feature-item">
                        <i class="fas fa-user-plus" style="color: rgba(255,255,255,0.8);"></i>
                        <div>
                            <strong>Création Gratuite</strong>
                            <span style="opacity: 0.9; font-size: 0.9rem;">Commencez en quelques secondes</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-lock" style="color: rgba(255,255,255,0.8);"></i>
                        <div>
                            <strong>Données Sécurisées</strong>
                            <span style="opacity: 0.9; font-size: 0.9rem;">Vos informations sont protégées</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-rocket" style="color: rgba(255,255,255,0.8);"></i>
                        <div>
                            <strong>Prêt Immédiatement</strong>
                            <span style="opacity: 0.9; font-size: 0.9rem;">Accédez au tableau de bord maintenant</span>
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
                    <h1>Inscription</h1>
                    <p>Créez votre compte FindIN en 30 secondes</p>
                </div>

                <form method="POST" action="/register" id="registerForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="prenom">
                                <i class="fas fa-user"></i> Prénom *
                            </label>
                            <input 
                                type="text" 
                                id="prenom" 
                                name="prenom" 
                                class="form-input" 
                                placeholder="Jean"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="nom">
                                <i class="fas fa-user"></i> Nom *
                            </label>
                            <input 
                                type="text" 
                                id="nom" 
                                name="nom" 
                                class="form-input" 
                                placeholder="Dupont"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group form-row full">
                        <label class="form-label" for="email">
                            <i class="fas fa-envelope"></i> Email *
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

                    <div class="form-group form-row full">
                        <label class="form-label" for="id_departement">
                            <i class="fas fa-building"></i> Département
                        </label>
                        <select id="id_departement" name="id_departement" class="form-select">
                            <option value="">Sélectionnez un département</option>
                            <option value="direction">Direction</option>
                            <option value="rh">Ressources Humaines</option>
                            <option value="dev">Développement</option>
                            <option value="marketing">Marketing</option>
                            <option value="commercial">Commercial</option>
                        </select>
                    </div>

                    <div class="form-group form-row full">
                        <label class="form-label" for="password">
                            <i class="fas fa-lock"></i> Mot de passe *
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="••••••••"
                            required
                            onkeyup="checkPasswordStrength()"
                        >
                        <div class="password-strength">
                            <div class="password-strength-fill" id="strengthBar"></div>
                        </div>
                    </div>

                    <div class="form-group form-row full">
                        <label class="form-label" for="confirm_password">
                            <i class="fas fa-lock"></i> Confirmer le mot de passe *
                        </label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="form-input" 
                            placeholder="••••••••"
                            required
                        >
                    </div>

                    <div class="terms">
                        <label>
                            <input type="checkbox" name="accept_terms" required>
                            J'accepte les <a href="#">Conditions d'utilisation</a> et la <a href="#">Politique de confidentialité</a>
                        </label>
                    </div>

                    <button type="submit" class="btn-submit">
                        Créer mon compte
                    </button>
                </form>

                <div class="info-box">
                    <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
                    Accès immédiat à votre tableau de bord après inscription
                </div>

                <div class="auth-footer">
                    <p>Vous avez déjà un compte ?</p>
                    <p><a href="/login" class="auth-link">Se connecter ici</a></p>
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

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const bar = document.getElementById('strengthBar');
            
            if (!password) {
                bar.className = 'password-strength-fill';
                return;
            }

            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            bar.className = 'password-strength-fill';
            if (strength === 1) bar.classList.add('weak');
            else if (strength === 2 || strength === 3) bar.classList.add('medium');
            else if (strength === 4) bar.classList.add('strong');
        }

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                document.getElementById('confirm_password').classList.add('error');
                alert('Les mots de passe ne correspondent pas');
            }
        });
    </script>
</body>
</html>
