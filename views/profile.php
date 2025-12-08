<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIN - Mon Profil</title>
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

        .nav-item i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
            overflow-y: auto;
            max-width: 900px;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, rgba(147, 51, 234, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
            border: 1px solid var(--border-light);
            border-radius: 12px;
            padding: 3rem 2rem;
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(147, 51, 234, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(40px);
        }

        .profile-content {
            position: relative;
            z-index: 1;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #9333ea 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            margin: 0 auto 1.5rem;
            border: 3px solid var(--border-light);
        }

        .profile-name {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            color: var(--accent-primary);
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .profile-stat {
            text-align: center;
        }

        .profile-stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--accent-primary);
        }

        .profile-stat-label {
            color: var(--text-light);
            font-size: 0.85rem;
        }

        /* Sections */
        .profile-section {
            background: linear-gradient(135deg, rgba(147, 51, 234, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
            border: 1px solid var(--border-light);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
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
        .form-textarea,
        .form-select {
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
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--accent-primary);
            background: rgba(147, 51, 234, 0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

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

        .badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            background: rgba(147, 51, 234, 0.2);
            color: var(--accent-primary);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .badge-group {
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .profile-stats {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
                font-size: 2rem;
            }

            .profile-name {
                font-size: 1.5rem;
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
                <a href="/competences" class="nav-item">
                    <i class="fas fa-certificate"></i> Mes compétences
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-search"></i> Rechercher
                </a>
                <a href="#" class="nav-item active">
                    <i class="fas fa-user"></i> Mon profil
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Mon Profil</h1>
            </div>

            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-content">
                    <div class="profile-avatar">JD</div>
                    <h2 class="profile-name">Jean Dupont</h2>
                    <p class="profile-role">Senior Software Developer</p>
                    <p style="color: var(--text-light); margin-bottom: 0;">Basé à Paris, France</p>
                    
                    <div class="profile-stats">
                        <div class="profile-stat">
                            <div class="profile-stat-value">8</div>
                            <div class="profile-stat-label">Années d'expérience</div>
                        </div>
                        <div class="profile-stat">
                            <div class="profile-stat-value">12</div>
                            <div class="profile-stat-label">Compétences</div>
                        </div>
                        <div class="profile-stat">
                            <div class="profile-stat-value">95%</div>
                            <div class="profile-stat-label">Profil complété</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information Personnelle -->
            <div class="profile-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i> Information Personnelle
                </h3>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-input" value="Jean">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-input" value="Dupont">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" value="jean.dupont@example.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" class="form-input" value="+33 6 XX XX XX XX">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Lieu</label>
                        <input type="text" class="form-input" value="Paris, France">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Département</label>
                        <input type="text" class="form-input" value="Ingénierie">
                    </div>
                </div>
            </div>

            <!-- Professionnel -->
            <div class="profile-section">
                <h3 class="section-title">
                    <i class="fas fa-briefcase"></i> Informations Professionnelles
                </h3>
                <div class="form-group">
                    <label class="form-label">Titre actuel</label>
                    <input type="text" class="form-input" value="Senior Software Developer">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Années d'expérience</label>
                        <input type="number" class="form-input" value="8">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Secteur</label>
                        <select class="form-select">
                            <option selected>Technologie</option>
                            <option>Finance</option>
                            <option>Santé</option>
                            <option>Éducation</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea class="form-textarea" placeholder="Parlez de vous...">Développeur passionné avec 8 ans d'expérience en développement web et mobile. Expert en PHP, JavaScript et architecture logicielle.</textarea>
                </div>
            </div>

            <!-- Compétences Clés -->
            <div class="profile-section">
                <h3 class="section-title">
                    <i class="fas fa-star"></i> Compétences Clés
                </h3>
                <div class="badge-group">
                    <span class="badge">PHP</span>
                    <span class="badge">JavaScript</span>
                    <span class="badge">React</span>
                    <span class="badge">DevOps</span>
                    <span class="badge">Leadership</span>
                    <span class="badge">Communication</span>
                </div>
                <p style="color: var(--text-light); font-size: 0.9rem;">
                    Ajoutez ou modifiez vos compétences dans la section <a href="/competences" style="color: var(--accent-primary);">Mes Compétences</a>
                </p>
            </div>

            <!-- Liens Sociaux -->
            <div class="profile-section">
                <h3 class="section-title">
                    <i class="fas fa-link"></i> Liens Sociaux
                </h3>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">LinkedIn</label>
                        <input type="url" class="form-input" placeholder="https://linkedin.com/in/...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">GitHub</label>
                        <input type="url" class="form-input" placeholder="https://github.com/...">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Portfolio</label>
                        <input type="url" class="form-input" placeholder="https://yourportfolio.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Twitter</label>
                        <input type="url" class="form-input" placeholder="https://twitter.com/...">
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="profile-section">
                <div class="btn-group">
                    <button class="btn"><i class="fas fa-save"></i> Enregistrer les modifications</button>
                    <button class="btn btn-secondary"><i class="fas fa-redo"></i> Réinitialiser</button>
                    <button class="btn btn-secondary" style="margin-left: auto;">
                        <i class="fas fa-cog"></i> Paramètres du compte
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/main.js"></script>
</body>
</html>
