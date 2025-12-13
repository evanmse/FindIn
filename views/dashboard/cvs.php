<?php 
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
$currentPage = 'cvs';
$userName = $_SESSION['user_name'] ?? 'Utilisateur';
$userRole = $_SESSION['user_role'] ?? 'collaborateur';
?>
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes CVs - FindIN</title>
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="/assets/css/dashboard.css" rel="stylesheet">
    <style>
        .cv-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; }
        .cv-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; overflow: hidden; transition: all 0.3s; }
        .cv-card:hover { transform: translateY(-5px); border-color: var(--accent-purple); }
        .cv-preview { height: 180px; background: linear-gradient(135deg, var(--bg-hover), var(--bg-primary)); display: flex; align-items: center; justify-content: center; position: relative; }
        .cv-preview i { font-size: 4rem; color: var(--text-secondary); opacity: 0.5; }
        .cv-status { position: absolute; top: 1rem; right: 1rem; }
        .cv-body { padding: 1.5rem; }
        .cv-name { font-weight: 600; font-size: 1.1rem; margin-bottom: 0.5rem; }
        .cv-meta { display: flex; flex-wrap: wrap; gap: 1rem; color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1rem; }
        .cv-skills { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.25rem; }
        .cv-skill { background: rgba(147, 51, 234, 0.1); color: var(--accent-purple); padding: 0.3rem 0.7rem; border-radius: 20px; font-size: 0.75rem; }
        .cv-actions { display: flex; gap: 0.5rem; }
        .cv-actions .btn { flex: 1; justify-content: center; }
        .generator-card { background: linear-gradient(135deg, rgba(147, 51, 234, 0.15), rgba(59, 130, 246, 0.15)); border: 1px solid rgba(147, 51, 234, 0.3); }
        .generator-content { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 300px; text-align: center; padding: 2rem; }
        .generator-icon { width: 80px; height: 80px; background: linear-gradient(135deg, var(--accent-purple), var(--accent-blue)); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; margin-bottom: 1.5rem; }
    </style>
</head>
<body>
    <?php include __DIR__ . '/_sidebar.php'; ?>
    <main class="main-content">
        <div class="page-header">
            <div><h1 class="page-title"><i class="fas fa-file-alt"></i> Mes CVs</h1><p class="page-subtitle">Gérez et optimisez vos curriculum vitae</p></div>
            <div class="header-actions"><button class="mobile-menu-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button><button class="theme-toggle" onclick="toggleTheme()"><i class="fas fa-moon"></i></button></div>
        </div>
        <div class="stats-grid">
            <div class="stat-card"><div class="stat-icon purple"><i class="fas fa-file-alt"></i></div><div class="stat-value">3</div><div class="stat-label">CVs uploadés</div></div>
            <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-brain"></i></div><div class="stat-value">24</div><div class="stat-label">Compétences extraites</div></div>
            <div class="stat-card"><div class="stat-icon green"><i class="fas fa-chart-line"></i></div><div class="stat-value">92%</div><div class="stat-label">Score ATS</div></div>
            <div class="stat-card"><div class="stat-icon yellow"><i class="fas fa-eye"></i></div><div class="stat-value">18</div><div class="stat-label">Vues recruteurs</div></div>
        </div>
        <label class="upload-zone" for="cvUpload" style="margin-bottom: 2rem;"><input type="file" id="cvUpload" accept=".pdf,.doc,.docx" multiple><i class="fas fa-cloud-upload-alt"></i><h3>Glissez vos CVs ici</h3><p>PDF, DOC, DOCX - Max 10 MB</p></label>
        <h2 style="font-size: 1.25rem; margin-bottom: 1.5rem;">Mes documents</h2>
        <div class="cv-grid">
            <div class="cv-card generator-card"><div class="generator-content"><div class="generator-icon"><i class="fas fa-magic"></i></div><h3>Générer un CV</h3><p style="color:var(--text-secondary);margin-bottom:1.5rem;">IA crée un CV professionnel</p><button class="btn btn-primary"><i class="fas fa-wand-magic-sparkles"></i> Créer</button></div></div>
            <div class="cv-card"><div class="cv-preview"><i class="fas fa-file-pdf"></i><div class="cv-status"><span class="badge badge-green"><i class="fas fa-star"></i> Principal</span></div></div><div class="cv-body"><h3 class="cv-name">CV_Dev_2024.pdf</h3><div class="cv-meta"><span><i class="fas fa-calendar"></i> 15 Nov</span><span><i class="fas fa-weight"></i> 245Ko</span></div><div class="cv-skills"><span class="cv-skill">PHP</span><span class="cv-skill">JS</span><span class="cv-skill">+5</span></div><div class="cv-actions"><button class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></button><button class="btn btn-outline btn-sm"><i class="fas fa-download"></i></button><button class="btn btn-outline btn-sm"><i class="fas fa-trash"></i></button></div></div></div>
            <div class="cv-card"><div class="cv-preview"><i class="fas fa-file-pdf"></i><div class="cv-status"><span class="badge badge-yellow"><i class="fas fa-clock"></i> Brouillon</span></div></div><div class="cv-body"><h3 class="cv-name">CV_Lead.pdf</h3><div class="cv-meta"><span><i class="fas fa-calendar"></i> 8 Nov</span><span><i class="fas fa-weight"></i> 312Ko</span></div><div class="cv-skills"><span class="cv-skill">Management</span><span class="cv-skill">+3</span></div><div class="cv-actions"><button class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></button><button class="btn btn-outline btn-sm"><i class="fas fa-download"></i></button><button class="btn btn-outline btn-sm"><i class="fas fa-trash"></i></button></div></div></div>
        </div>
    </main>
    <script>
        function toggleTheme(){const h=document.documentElement,n=h.getAttribute('data-theme')==='dark'?'light':'dark';h.setAttribute('data-theme',n);localStorage.setItem('theme',n);document.querySelector('.theme-toggle i').className=n==='dark'?'fas fa-moon':'fas fa-sun';}
        const t=localStorage.getItem('theme')||'dark';document.documentElement.setAttribute('data-theme',t);document.querySelector('.theme-toggle i').className=t==='dark'?'fas fa-moon':'fas fa-sun';
        function toggleSidebar(){document.querySelector('.sidebar').classList.toggle('open');}
    </script>
</body>
</html>
