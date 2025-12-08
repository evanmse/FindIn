<?php
// Dashboard - Redirection vers le nouveau dashboard professionnel
if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

// Inclure le nouveau dashboard professionnel
require_once __DIR__ . '/../dashboard_new.php';
exit;
?>
<!-- Ce fichier ne devrait jamais arriver ici -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        /* Dashboard Specific Styles */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            margin-top: 60px;
            background-color: var(--bg-secondary);
        }

        .sidebar {
            width: 250px;
            background: var(--bg-primary);
            border-right: 1px solid var(--border-color);
            padding: 2rem 0;
            position: fixed;
            height: calc(100vh - 60px);
            overflow-y: auto;
            left: 0;
            top: 60px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar-menu a:hover {
            background-color: var(--bg-secondary);
            color: var(--color-primary);
            border-left-color: var(--color-primary);
        }

        .sidebar-menu a.active {
            background-color: var(--bg-secondary);
            color: var(--color-primary);
            border-left-color: var(--color-primary);
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
        }

        .sidebar-divider {
            height: 1px;
            background: var(--border-color);
            margin: 1rem 0;
        }

        .sidebar-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }

        .sidebar-user {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .user-email {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 2rem;
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .dashboard-header h1 {
            font-size: 2rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .dashboard-header p {
            color: var(--text-secondary);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon.accent {
            background: linear-gradient(135deg, var(--color-secondary), var(--color-accent));
        }

        .stat-content h3 {
            font-size: 0.95rem;
            color: var(--text-secondary);
            margin: 0 0 0.5rem 0;
            font-weight: 500;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stat-change {
            font-size: 0.85rem;
            color: #10b981;
            margin-top: 0.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--color-primary);
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .skill-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .skill-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
        }

        .skill-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .skill-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .skill-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .skill-level {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: var(--bg-secondary);
            border-radius: 3px;
            margin-top: 1rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
            width: 0%;
            transition: width 0.6s ease;
        }

        .search-section {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .search-input-group {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            pointer-events: none;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .action-button {
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            background: var(--bg-secondary);
            border-radius: 0.5rem;
            color: var(--text-primary);
            text-decoration: none;
            text-align: center;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .action-button:hover {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .action-button.primary {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                overflow: visible;
                padding: 1rem 0;
            }

            .sidebar-menu {
                display: flex;
                overflow-x: auto;
                padding: 0 1rem;
            }

            .sidebar-menu li {
                flex-shrink: 0;
                margin-right: 1rem;
            }

            .sidebar-menu a {
                padding: 0.5rem 1rem;
                border-left: none;
                border-bottom: 3px solid transparent;
                white-space: nowrap;
            }

            .sidebar-menu a:hover,
            .sidebar-menu a.active {
                border-left: none;
                border-bottom-color: var(--color-primary);
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .skills-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header from layout -->
    <?php include '../layouts/header.php'; ?>

    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-user">
                <div class="user-avatar"><?php echo strtoupper(substr($user_name, 0, 2)); ?></div>
                <div class="user-name"><?php echo htmlspecialchars($user_name); ?></div>
                <div class="user-email"><?php echo htmlspecialchars($user_email); ?></div>
            </div>

            <ul class="sidebar-menu">
                <li><a href="/dashboard" class="active"><i class="fas fa-home"></i> Tableau de Bord</a></li>
                <li><a href="#skills"><i class="fas fa-star"></i> Mes Compétences</a></li>
                <li><a href="#validation"><i class="fas fa-check-circle"></i> En Validation</a></li>
                <li><a href="#analytics"><i class="fas fa-chart-bar"></i> Statistiques</a></li>
            </ul>

            <div class="sidebar-divider"></div>

            <p class="sidebar-title">Paramètres</p>
            <ul class="sidebar-menu">
                <li><a href="#profile"><i class="fas fa-user"></i> Mon Profil</a></li>
                <li><a href="#settings"><i class="fas fa-cog"></i> Paramètres</a></li>
                <li><a href="/logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1>Bienvenue, <?php echo htmlspecialchars($user_name); ?>!</h1>
                <p>Gérez vos compétences et suivez votre progression</p>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Compétences</h3>
                        <div class="stat-value">12</div>
                        <div class="stat-change">+2 ce mois-ci</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon accent">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>En Validation</h3>
                        <div class="stat-value">3</div>
                        <div class="stat-change">Attente de validation</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Validées</h3>
                        <div class="stat-value">9</div>
                        <div class="stat-change">+1 en attente</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon accent">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Progression</h3>
                        <div class="stat-value">75%</div>
                        <div class="stat-change">Profil complet à 75%</div>
                    </div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="search-section">
                <h2 class="section-title">
                    <i class="fas fa-search"></i> Rechercher des Compétences
                </h2>
                <div class="search-input-group">
                    <i class="fas fa-search search-icon"></i>
                    <input 
                        type="text" 
                        class="search-input" 
                        placeholder="Rechercher une compétence..." 
                        id="searchInput"
                    >
                </div>
                <div class="quick-actions">
                    <a href="#" class="action-button primary">
                        <i class="fas fa-plus"></i> Ajouter
                    </a>
                    <a href="#" class="action-button">
                        <i class="fas fa-filter"></i> Filtrer
                    </a>
                    <a href="#" class="action-button">
                        <i class="fas fa-download"></i> Exporter
                    </a>
                </div>
            </div>

            <!-- Skills Section -->
            <div id="skills">
                <h2 class="section-title">
                    <i class="fas fa-award"></i> Vos Compétences
                </h2>
                <div class="skills-grid">
                    <!-- Skill Card 1 -->
                    <div class="skill-card">
                        <span class="skill-icon">💻</span>
                        <div class="skill-name">PHP Development</div>
                        <div class="skill-level">Avancé - Validée</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 85%;"></div>
                        </div>
                    </div>

                    <!-- Skill Card 2 -->
                    <div class="skill-card">
                        <span class="skill-icon">🎨</span>
                        <div class="skill-name">UI/UX Design</div>
                        <div class="skill-level">Intermédiaire - Validée</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 70%;"></div>
                        </div>
                    </div>

                    <!-- Skill Card 3 -->
                    <div class="skill-card">
                        <span class="skill-icon">📊</span>
                        <div class="skill-name">Data Analysis</div>
                        <div class="skill-level">Avancé - En validation</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 75%;"></div>
                        </div>
                    </div>

                    <!-- Skill Card 4 -->
                    <div class="skill-card">
                        <span class="skill-icon">🚀</span>
                        <div class="skill-name">DevOps</div>
                        <div class="skill-level">Intermédiaire</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 60%;"></div>
                        </div>
                    </div>

                    <!-- Skill Card 5 -->
                    <div class="skill-card">
                        <span class="skill-icon">🤝</span>
                        <div class="skill-name">Leadership</div>
                        <div class="skill-level">Avancé - En validation</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 80%;"></div>
                        </div>
                    </div>

                    <!-- Skill Card 6 -->
                    <div class="skill-card">
                        <span class="skill-icon">📚</span>
                        <div class="skill-name">Gestion de Projet</div>
                        <div class="skill-level">Intermédiaire - Validée</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 65%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Preview -->
            <div id="analytics" style="margin-top: 2rem;">
                <h2 class="section-title">
                    <i class="fas fa-chart-line"></i> Aperçu Statistiques
                </h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Jours Actifs</h3>
                            <div class="stat-value">24</div>
                            <div class="stat-change">Ce mois-ci</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon accent">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Validateurs</h3>
                            <div class="stat-value">5</div>
                            <div class="stat-change">Équipe validante</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-target"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Objectifs</h3>
                            <div class="stat-value">3/5</div>
                            <div class="stat-change">Complétés</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer from layout -->
    <?php include '../layouts/footer.php'; ?>

    <script>
        // Active navigation item
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            if (link.getAttribute('href') === window.location.pathname) {
                link.classList.add('active');
            }
        });

        // Search functionality (placeholder)
        document.getElementById('searchInput')?.addEventListener('keyup', function(e) {
            console.log('Searching for:', e.target.value);
            // TODO: Implement search backend integration
        });

        // Progress bar animation on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const fill = entry.target.querySelector('.progress-fill');
                    if (fill && !fill.classList.contains('animated')) {
                        fill.style.animation = 'progressAnimation 0.8s ease forwards';
                        fill.classList.add('animated');
                    }
                }
            });
        });

        document.querySelectorAll('.progress-bar').forEach(el => observer.observe(el));
    </script>
</body>
</html>
