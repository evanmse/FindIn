<!-- views/dashboard/simple.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIN - Tableau de bord</title>
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #10b981;
            --dark: #1f2937;
            --light: #f9fafb;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .header {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .btn {
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-logout {
            background: #ef4444;
            color: white;
        }
        
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .card h3 {
            color: var(--dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .stat {
            text-align: center;
            padding: 1rem;
            background: var(--light);
            border-radius: 8px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary);
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .feature-list {
            list-style: none;
        }
        
        .feature-list li {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background: var(--light);
            border-radius: 5px;
            border-left: 4px solid var(--primary);
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="header">
            <div>
                <h1>FindIN 🚀</h1>
                <p>Plateforme de gestion des compétences</p>
            </div>
            <div class="user-info">
                <div>
                    <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur') ?></strong><br>
                    <small><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></small>
                </div>
                <a href="/logout" class="btn btn-logout">Déconnexion</a>
            </div>
        </div>
        
        <div class="cards">
            <div class="card">
                <h3>👤 Mon Profil</h3>
                <p>Gérez vos informations personnelles et vos compétences</p>
                <div class="stats">
                    <div class="stat">
                        <div class="stat-number">5</div>
                        <div class="stat-label">Compétences</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">3</div>
                        <div class="stat-label">Validées</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">80%</div>
                        <div class="stat-label">Profil complet</div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary" style="margin-top: 1rem; width: 100%;">Modifier mon profil</a>
            </div>
            
            <div class="card">
                <h3>🔍 Recherche</h3>
                <p>Trouvez des experts par compétences</p>
                <div style="margin: 1rem 0;">
                    <input type="text" placeholder="Rechercher une compétence..." 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <a href="#" class="btn btn-primary" style="width: 100%;">Rechercher</a>
            </div>
            
            <div class="card">
                <h3>📊 Vue d'ensemble</h3>
                <ul class="feature-list">
                    <li><strong>✅ Authentification</strong> - Système de connexion</li>
                    <li><strong>✅ Base de données</strong> - SQLite fonctionnel</li>
                    <li><strong>✅ Architecture MVC</strong> - Code organisé</li>
                    <li><strong>✅ Interface responsive</strong> - Adapté mobile/desktop</li>
                    <li><strong>✅ Gestion des sessions</strong> - Sécurisé</li>
                </ul>
            </div>
        </div>
        
        <div class="card" style="margin-top: 2rem;">
            <h3>🎯 Prochaines étapes</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
                <div style="padding: 1rem; background: #f0f9ff; border-radius: 8px;">
                    <h4>Phase 1</h4>
                    <ul>
                        <li>Gestion des compétences</li>
                        <li>Recherche avancée</li>
                        <li>Validation manager</li>
                    </ul>
                </div>
                <div style="padding: 1rem; background: #f0fdf4; border-radius: 8px;">
                    <h4>Phase 2</h4>
                    <ul>
                        <li>Tableaux de bord RH</li>
                        <li>Export des données</li>
                        <li>API REST</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
