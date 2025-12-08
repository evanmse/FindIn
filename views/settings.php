<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIN - Paramètres</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0a0118;
            --bg-card: #1a0d2e;
            --text-white: #ffffff;
            --text-light: #e0e0e0;
            --accent-primary: #9333ea;
            --accent-blue: #3b82f6;
            --accent-pink: #ec4899;
            --border-light: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0a0118 0%, #1a0d2e 100%);
            color: var(--text-white);
            line-height: 1.6;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background: rgba(26, 13, 46, 0.8);
            backdrop-filter: blur(10px);
            border-right: 1px solid var(--border-light);
            padding: 2rem 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 0 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #9333ea 0%, #3b82f6 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .sidebar-title {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 0 1rem;
        }

        .nav-item {
            padding: 0.75rem 1rem;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(147, 51, 234, 0.2);
            color: var(--accent-primary);
        }

        .sidebar-section {
            margin-top: 2rem;
        }

        .sidebar-section-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
            overflow-y: auto;
            max-width: 1000px;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--text-light);
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border-light);
        }

        .tab {
            padding: 1rem;
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .tab:hover {
            color: var(--accent-primary);
        }

        .tab.active {
            color: var(--accent-primary);
            border-bottom-color: var(--accent-primary);
        }

        /* Sections */
        .settings-section {
            background: linear-gradient(135deg, rgba(147, 51, 234, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
            border: 1px solid var(--border-light);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            display: none;
        }

        .settings-section.active {
            display: block;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--accent-primary);
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-white);
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-light);
            border-radius: 8px;
            color: var(--text-white);
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--accent-primary);
            background: rgba(147, 51, 234, 0.1);
        }

        .form-description {
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        /* Toggle Switch */
        .toggle-switch {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.2);
            transition: 0.4s;
            border-radius: 26px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--accent-primary);
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #9333ea 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-light);
            color: var(--text-white);
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .tabs {
                flex-wrap: wrap;
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">F</div>
                <div class="sidebar-title">FindIN</div>
            </div>

            <nav class="sidebar-nav">
                <a href="/dashboard" class="nav-item">
                    <i class="fas fa-chart-line"></i> Tableau de bord
                </a>
            </nav>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Admin</div>
                <nav class="sidebar-nav">
                    <a href="/admin_users" class="nav-item">
                        <i class="fas fa-users"></i> Utilisateurs
                    </a>
                    <a href="/admin_competences" class="nav-item">
                        <i class="fas fa-certificate"></i> Compétences
                    </a>
                    <a href="#" class="nav-item active">
                        <i class="fas fa-cog"></i> Paramètres
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <div class="page-header">
                <h1 class="page-title">Paramètres</h1>
                <p class="page-subtitle">Gérez les paramètres de votre plateforme FindIN</p>
            </div>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" data-tab="general">
                    <i class="fas fa-cog"></i> Général
                </button>
                <button class="tab" data-tab="email">
                    <i class="fas fa-envelope"></i> Email
                </button>
                <button class="tab" data-tab="security">
                    <i class="fas fa-lock"></i> Sécurité
                </button>
                <button class="tab" data-tab="database">
                    <i class="fas fa-database"></i> Base de données
                </button>
            </div>

            <!-- General Settings -->
            <div class="settings-section active" id="general">
                <div class="section-title">
                    <i class="fas fa-cog"></i> Paramètres Généraux
                </div>

                <div class="form-group">
                    <label class="form-label">Nom de la plateforme</label>
                    <input type="text" class="form-input" value="FindIN">
                    <div class="form-description">Le nom affiché dans l'en-tête et les emails</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-textarea" rows="3">Plateforme de gestion des compétences et des talents</textarea>
                    <div class="form-description">Description courte de votre plateforme</div>
                </div>

                <div class="form-group">
                    <label class="form-label">URL principale</label>
                    <input type="url" class="form-input" value="http://localhost:8000">
                    <div class="form-description">L'URL de base de votre plateforme</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Langue par défaut</label>
                    <select class="form-select">
                        <option selected>Français</option>
                        <option>English</option>
                        <option>Español</option>
                        <option>Deutsch</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Fuseau horaire</label>
                    <select class="form-select">
                        <option selected>Europe/Paris (UTC+1)</option>
                        <option>Europe/London (UTC+0)</option>
                        <option>Europe/Berlin (UTC+1)</option>
                        <option>America/New_York (UTC-5)</option>
                    </select>
                </div>

                <div class="btn-group">
                    <button class="btn"><i class="fas fa-save"></i> Enregistrer les modifications</button>
                    <button class="btn btn-secondary"><i class="fas fa-redo"></i> Réinitialiser</button>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="settings-section" id="email">
                <div class="section-title">
                    <i class="fas fa-envelope"></i> Paramètres Email
                </div>

                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Configuration email actuellement active
                </div>

                <div class="form-group">
                    <label class="form-label">Adresse email d'envoi</label>
                    <input type="email" class="form-input" value="noreply@findin.local">
                    <div class="form-description">L'adresse utilisée pour envoyer les emails</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nom de l'expéditeur</label>
                    <input type="text" class="form-input" value="FindIN">
                </div>

                <div class="form-group">
                    <label class="form-label">Serveur SMTP</label>
                    <input type="text" class="form-input" value="localhost">
                </div>

                <div class="form-group">
                    <label class="form-label">Port SMTP</label>
                    <input type="number" class="form-input" value="587">
                </div>

                <div class="toggle-switch">
                    <label class="form-label">Activer TLS/SSL</label>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="btn-group">
                    <button class="btn"><i class="fas fa-envelope"></i> Envoyer un email de test</button>
                    <button class="btn"><i class="fas fa-save"></i> Enregistrer</button>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="settings-section" id="security">
                <div class="section-title">
                    <i class="fas fa-lock"></i> Sécurité
                </div>

                <h3 style="margin-top: 1.5rem; margin-bottom: 1rem; font-size: 1.1rem;">Authentification</h3>

                <div class="toggle-switch">
                    <label class="form-label">Authentification à deux facteurs (2FA)</label>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="toggle-switch">
                    <label class="form-label">Forcer HTTPS</label>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <h3 style="margin-top: 2rem; margin-bottom: 1rem; font-size: 1.1rem;">Sessions</h3>

                <div class="form-group">
                    <label class="form-label">Durée de session (minutes)</label>
                    <input type="number" class="form-input" value="60">
                    <div class="form-description">Temps avant expiration automatique de la session</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Limite de tentatives de connexion</label>
                    <input type="number" class="form-input" value="5">
                    <div class="form-description">Nombre de tentatives échouées avant blocage</div>
                </div>

                <h3 style="margin-top: 2rem; margin-bottom: 1rem; font-size: 1.1rem;">Danger Zone</h3>

                <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; padding: 1.5rem; margin-top: 1rem;">
                    <div style="color: #ef4444; font-weight: 600; margin-bottom: 1rem;">⚠️ Actions irréversibles</div>
                    <button class="btn" style="background: #ef4444;">
                        <i class="fas fa-trash"></i> Supprimer toutes les données
                    </button>
                </div>
            </div>

            <!-- Database Settings -->
            <div class="settings-section" id="database">
                <div class="section-title">
                    <i class="fas fa-database"></i> Base de données
                </div>

                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Connexion à la base de données établie avec succès
                </div>

                <div class="form-group">
                    <label class="form-label">Type de base de données</label>
                    <input type="text" class="form-input" value="MySQL" disabled>
                </div>

                <div class="form-group">
                    <label class="form-label">Serveur</label>
                    <input type="text" class="form-input" value="localhost">
                </div>

                <div class="form-group">
                    <label class="form-label">Port</label>
                    <input type="number" class="form-input" value="3306">
                </div>

                <div class="form-group">
                    <label class="form-label">Base de données</label>
                    <input type="text" class="form-input" value="findin_db">
                </div>

                <div class="form-group">
                    <label class="form-label">Utilisateur</label>
                    <input type="text" class="form-input" value="root">
                </div>

                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" class="form-input" placeholder="••••••••">
                </div>

                <div class="btn-group">
                    <button class="btn"><i class="fas fa-check"></i> Tester la connexion</button>
                    <button class="btn"><i class="fas fa-database"></i> Sauvegarder la base de données</button>
                </div>

                <h3 style="margin-top: 2rem; margin-bottom: 1rem; font-size: 1.1rem;">Statistiques</h3>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <div style="background: rgba(147, 51, 234, 0.1); border: 1px solid var(--border-light); border-radius: 8px; padding: 1rem;">
                        <div style="color: var(--text-light); font-size: 0.9rem;">Utilisateurs</div>
                        <div style="font-size: 1.8rem; font-weight: 700; color: var(--accent-primary);">156</div>
                    </div>
                    <div style="background: rgba(147, 51, 234, 0.1); border: 1px solid var(--border-light); border-radius: 8px; padding: 1rem;">
                        <div style="color: var(--text-light); font-size: 0.9rem;">Compétences</div>
                        <div style="font-size: 1.8rem; font-weight: 700; color: var(--accent-primary);">48</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                
                // Hide all sections
                document.querySelectorAll('.settings-section').forEach(section => {
                    section.classList.remove('active');
                });
                
                // Remove active class from all tabs
                document.querySelectorAll('.tab').forEach(t => {
                    t.classList.remove('active');
                });
                
                // Show selected section and mark tab as active
                document.getElementById(tabName).classList.add('active');
                this.classList.add('active');
            });
        });
    </script>
    
    <script src="/assets/js/main.js"></script>
</body>
</html>
