<?php
// Dashboard FindIN - Role-based Professional Version
if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

$user_name = $_SESSION['user_name'] ?? 'Utilisateur';
$user_email = $_SESSION['user_email'] ?? 'user@example.com';
$user_role = $_SESSION['user_role'] ?? 'employe';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIN Dashboard - <?php echo htmlspecialchars($user_name); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #f8fafc;
            --sidebar-bg: #1e293b;
            --sidebar-text: #f1f5f9;
            --primary-color: #3b82f6;
            --primary-light: #dbeafe;
            --secondary-color: #64748b;
            --card-bg: #ffffff;
            --text-color: #1e293b;
            --border-color: #e2e8f0;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --shadow: rgba(0, 0, 0, 0.08);
        }

        .dark-mode {
            --bg-color: #0f172a;
            --sidebar-bg: #020617;
            --sidebar-text: #cbd5e1;
            --primary-color: #60a5fa;
            --primary-light: #1e3a8a;
            --secondary-color: #94a3b8;
            --card-bg: #1e293b;
            --text-color: #f1f5f9;
            --border-color: #334155;
            --shadow: rgba(255, 255, 255, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 280px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            padding: 30px 0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: var(--primary-color);
            padding: 0 30px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-profile {
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid var(--primary-color);
            background: linear-gradient(135deg, var(--primary-color), #9333ea);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .user-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .user-role {
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin-bottom: 20px;
            text-transform: capitalize;
        }

        .user-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--sidebar-text);
            opacity: 0.7;
        }

        .nav-menu {
            padding: 30px;
            flex-grow: 1;
        }

        .nav-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            color: var(--secondary-color);
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .nav-list {
            list-style: none;
            margin-bottom: 30px;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .shortcuts {
            margin-top: 30px;
        }

        .shortcut-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .shortcut-item {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .shortcut-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-title {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .theme-toggle {
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: var(--text-color);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--card-bg);
            box-shadow: 0 2px 8px var(--shadow);
            transition: all 0.2s ease;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
        }

        .date-filter {
            display: flex;
            gap: 10px;
            align-items: center;
            background-color: var(--card-bg);
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .date-filter:hover {
            border-color: var(--primary-color);
        }

        /* ===== STATS GRID ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px var(--shadow);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px var(--shadow);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-title {
            font-size: 1rem;
            color: var(--secondary-color);
            font-weight: 500;
        }

        .stat-trend {
            font-size: 0.9rem;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .trend-up {
            background-color: rgba(16, 185, 129, 0.15);
            color: var(--success-color);
        }

        .trend-down {
            background-color: rgba(239, 68, 68, 0.15);
            color: var(--danger-color);
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-subtitle {
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .progress-bar {
            height: 6px;
            background-color: var(--border-color);
            border-radius: 3px;
            margin-top: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 3px;
            background: linear-gradient(90deg, var(--primary-color), #60a5fa);
        }

        /* ===== TABLE SECTION ===== */
        .table-section {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px var(--shadow);
            border: 1px solid var(--border-color);
            margin-bottom: 30px;
            overflow-x: auto;
        }

        .table-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 15px;
            color: var(--secondary-color);
            font-weight: 500;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-active {
            background-color: rgba(16, 185, 129, 0.15);
            color: var(--success-color);
        }

        .status-pending {
            background-color: rgba(245, 158, 11, 0.15);
            color: var(--warning-color);
        }

        .status-completed {
            background-color: rgba(59, 130, 246, 0.15);
            color: var(--primary-color);
        }

        /* ===== CHARTS SECTION ===== */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .chart-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px var(--shadow);
            border: 1px solid var(--border-color);
        }

        .chart-placeholder {
            height: 200px;
            background: linear-gradient(135deg, var(--border-color) 25%, transparent 25%, transparent 50%, var(--border-color) 50%, var(--border-color) 75%, transparent 75%, transparent);
            background-size: 40px 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin-top: 20px;
        }

        /* ===== PROJECTS SECTION ===== */
        .projects-section {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px var(--shadow);
            border: 1px solid var(--border-color);
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .project-card {
            background: linear-gradient(135deg, var(--primary-light), rgba(59, 130, 246, 0.1));
            border-radius: 10px;
            padding: 20px;
            border-left: 5px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .project-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px var(--shadow);
        }

        .project-title {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .project-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .project-label {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 900px) {
            body {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                padding: 20px;
            }
            
            .nav-menu {
                display: flex;
                flex-wrap: wrap;
                gap: 30px;
            }
            
            .main-nav, .shortcuts {
                flex: 1;
                min-width: 200px;
            }
        }

        @media (max-width: 600px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .header-actions {
                width: 100%;
                justify-content: space-between;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo">
            <i class="fas fa-chart-line"></i>
            <span>FindIN</span>
        </div>
        
        <div class="user-profile">
            <div class="avatar"><?php echo strtoupper(substr($user_name, 0, 1)); ?></div>
            <h2 class="user-name"><?php echo htmlspecialchars($user_name); ?></h2>
            <p class="user-role"><?php echo ucfirst($user_role); ?></p>
            
            <div class="user-stats">
                <div class="stat-item">
                    <div class="stat-value">4.8</div>
                    <div class="stat-label">Rating</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">12</div>
                    <div class="stat-label">Skills</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">95%</div>
                    <div class="stat-label">Profile</div>
                </div>
            </div>
        </div>
        
        <div class="nav-menu">
            <div class="main-nav">
                <div class="nav-title">Navigation</div>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link active">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/competences" class="nav-link">
                            <i class="fas fa-star"></i>
                            <span>Compétences</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/profile" class="nav-link">
                            <i class="fas fa-user"></i>
                            <span>Mon Profil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/search" class="nav-link">
                            <i class="fas fa-search"></i>
                            <span>Rechercher</span>
                        </a>
                    </li>
                    <?php if ($user_role === 'admin' || $user_role === 'manager'): ?>
                    <li class="nav-item">
                        <a href="/admin_users" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="shortcuts">
                <div class="nav-title">Raccourcis</div>
                <div class="shortcut-grid">
                    <div class="shortcut-item" onclick="alert('CVs')">
                        <i class="fas fa-file-alt"></i>
                        <div>CVs</div>
                    </div>
                    <div class="shortcut-item" onclick="alert('Réunions')">
                        <i class="fas fa-calendar-alt"></i>
                        <div>Réunions</div>
                    </div>
                    <div class="shortcut-item" onclick="alert('Tests')">
                        <i class="fas fa-clipboard-check"></i>
                        <div>Tests</div>
                    </div>
                    <div class="shortcut-item" onclick="alert('Rapports')">
                        <i class="fas fa-chart-pie"></i>
                        <div>Rapports</div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="header">
            <h1 class="header-title">Tableau de bord</h1>
            <div class="header-actions">
                <div class="date-filter">
                    <i class="fas fa-calendar"></i>
                    <span>Décembre 2025</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>
        
        <!-- STATS GRID -->
        <div class="stats-grid">
            <div class="stat-card" style="animation: fadeIn 0.5s ease 0.1s backwards;">
                <div class="stat-header">
                    <div class="stat-title">COMPÉTENCES</div>
                    <div class="stat-trend trend-up">+3</div>
                </div>
                <div class="stat-value">12</div>
                <div class="stat-subtitle">Compétences totales</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 78%"></div>
                </div>
            </div>
            
            <div class="stat-card" style="animation: fadeIn 0.5s ease 0.2s backwards;">
                <div class="stat-header">
                    <div class="stat-title">VALIDÉES</div>
                    <div class="stat-trend trend-up">+2</div>
                </div>
                <div class="stat-value">9</div>
                <div class="stat-subtitle">Compétences validées</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 65%"></div>
                </div>
            </div>
            
            <div class="stat-card" style="animation: fadeIn 0.5s ease 0.3s backwards;">
                <div class="stat-header">
                    <div class="stat-title">EN VALIDATION</div>
                    <div class="stat-trend trend-down">-1</div>
                </div>
                <div class="stat-value">3</div>
                <div class="stat-subtitle">En attente de validation</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 58%"></div>
                </div>
            </div>
            
            <div class="stat-card" style="animation: fadeIn 0.5s ease 0.4s backwards;">
                <div class="stat-header">
                    <div class="stat-title">PROGRESSION</div>
                    <div class="stat-trend trend-up">+5%</div>
                </div>
                <div class="stat-value">75%</div>
                <div class="stat-subtitle">Profil complet</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 75%"></div>
                </div>
            </div>
        </div>
        
        <!-- TABLE SECTION - Dynamique selon le rôle -->
        <?php if ($user_role === 'admin'): ?>
            <!-- ADMIN TABLE -->
            <div class="table-section">
                <h2 class="table-title"><i class="fas fa-history"></i> Activités Récentes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Action</th>
                            <th>Compétence</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Luc Renault</td>
                            <td>Ajout compétence</td>
                            <td>PHP Development</td>
                            <td>2025-12-07</td>
                            <td><span class="status-badge status-active">Validée</span></td>
                        </tr>
                        <tr>
                            <td>Marie Delorme</td>
                            <td>Modification profil</td>
                            <td>UI/UX Design</td>
                            <td>2025-12-06</td>
                            <td><span class="status-badge status-pending">En attente</span></td>
                        </tr>
                        <tr>
                            <td>Denis Valentin</td>
                            <td>Demande validation</td>
                            <td>Data Analysis</td>
                            <td>2025-12-05</td>
                            <td><span class="status-badge status-pending">En attente</span></td>
                        </tr>
                        <tr>
                            <td>Nora Wang</td>
                            <td>Test réussi</td>
                            <td>DevOps</td>
                            <td>2025-12-04</td>
                            <td><span class="status-badge status-completed">Réussi</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <?php elseif ($user_role === 'manager'): ?>
            <!-- MANAGER TABLE -->
            <div class="table-section">
                <h2 class="table-title"><i class="fas fa-users"></i> Équipe</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Poste</th>
                            <th>Compétences</th>
                            <th>Performance</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Luc Renault</td>
                            <td>Développeur Senior</td>
                            <td>PHP, JavaScript, React</td>
                            <td>92%</td>
                            <td><span class="status-badge status-active">Actif</span></td>
                        </tr>
                        <tr>
                            <td>Marie Delorme</td>
                            <td>Designer UX</td>
                            <td>UI/UX, Figma, Design</td>
                            <td>88%</td>
                            <td><span class="status-badge status-active">Actif</span></td>
                        </tr>
                        <tr>
                            <td>Denis Valentin</td>
                            <td>Data Analyst</td>
                            <td>SQL, Python, Analytics</td>
                            <td>85%</td>
                            <td><span class="status-badge status-active">Actif</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <?php elseif ($user_role === 'rh'): ?>
            <!-- HR TABLE -->
            <div class="table-section">
                <h2 class="table-title"><i class="fas fa-briefcase"></i> Pipeline de Recrutement</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Poste</th>
                            <th>Candidats</th>
                            <th>Entretiens</th>
                            <th>Offres</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Développeur Senior</td>
                            <td>24</td>
                            <td>4</td>
                            <td>2</td>
                            <td><span class="status-badge status-active">Actif</span></td>
                        </tr>
                        <tr>
                            <td>Designer UX/UI</td>
                            <td>18</td>
                            <td>3</td>
                            <td>1</td>
                            <td><span class="status-badge status-active">Actif</span></td>
                        </tr>
                        <tr>
                            <td>Product Manager</td>
                            <td>12</td>
                            <td>2</td>
                            <td>0</td>
                            <td><span class="status-badge status-pending">En attente</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <!-- EMPLOYEE TABLE -->
            <div class="table-section">
                <h2 class="table-title"><i class="fas fa-star"></i> Vos Compétences</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Compétence</th>
                            <th>Niveau</th>
                            <th>Années</th>
                            <th>Validée</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fas fa-code"></i> PHP Development</td>
                            <td>Avancé</td>
                            <td>5+ ans</td>
                            <td>2023-06</td>
                            <td><span class="status-badge status-active">Validée</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-palette"></i> UI/UX Design</td>
                            <td>Intermédiaire</td>
                            <td>3 ans</td>
                            <td>2024-01</td>
                            <td><span class="status-badge status-active">Validée</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-chart-bar"></i> Data Analysis</td>
                            <td>Avancé</td>
                            <td>4 ans</td>
                            <td>-</td>
                            <td><span class="status-badge status-pending">En validation</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-server"></i> DevOps</td>
                            <td>Intermédiaire</td>
                            <td>2 ans</td>
                            <td>2024-11</td>
                            <td><span class="status-badge status-active">Validée</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-handshake"></i> Leadership</td>
                            <td>Avancé</td>
                            <td>3 ans</td>
                            <td>-</td>
                            <td><span class="status-badge status-pending">En validation</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <!-- PROJECTS SECTION -->
        <div class="projects-section">
            <h2 class="table-title"><i class="fas fa-briefcase"></i> En cours</h2>
            <div class="projects-grid">
                <div class="project-card">
                    <div class="project-title">Validation Compétences</div>
                    <div class="project-value">3</div>
                    <div class="project-label">En attente</div>
                </div>
                <div class="project-card">
                    <div class="project-title">Certifications</div>
                    <div class="project-value">2</div>
                    <div class="project-label">Formations actives</div>
                </div>
                <div class="project-card">
                    <div class="project-title">Projets Actifs</div>
                    <div class="project-value">5</div>
                    <div class="project-label">En cours</div>
                </div>
                <div class="project-card">
                    <div class="project-title">Connexions</div>
                    <div class="project-value">42</div>
                    <div class="project-label">Réseau</div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = themeToggle.querySelector('i');
        const savedTheme = localStorage.getItem('findin-theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            document.body.classList.add('dark-mode');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }
        
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            if (document.body.classList.contains('dark-mode')) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                localStorage.setItem('findin-theme', 'dark');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                localStorage.setItem('findin-theme', 'light');
            }
        });

        // Navigation active
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                navLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');
            });
        });

        // Date filter
        const dateFilter = document.querySelector('.date-filter');
        dateFilter.addEventListener('click', () => {
            const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            const currentMonth = dateFilter.querySelector('span').textContent.split(' ')[0];
            const currentYear = dateFilter.querySelector('span').textContent.split(' ')[1];
            const newMonth = months[(months.indexOf(currentMonth) + 1) % 12];
            const newYear = currentMonth === 'Décembre' ? parseInt(currentYear) + 1 : currentYear;
            dateFilter.querySelector('span').textContent = `${newMonth} ${newYear}`;
        });

        // Animations on load
        window.addEventListener('load', () => {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 + index * 100);
            });
        });
    </script>
</body>
</html>
