<?php 
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }

require_once __DIR__ . '/../../Config/database.php';
require_once __DIR__ . '/../../Models/Database.php';

$currentPage = 'cvs';
$userName = $_SESSION['user_name'] ?? 'Utilisateur';
$userRole = $_SESSION['user_role'] ?? 'collaborateur';
$userId = $_SESSION['user_id'];

// Récupérer les CVs de l'utilisateur depuis la BDD
$documents = [];
$stats = ['total' => 0, 'competences' => 0, 'score_ats' => 85, 'vues' => 0];

try {
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT * FROM documents_utilisateurs WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$userId]);
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stats['total'] = count($documents);
    
    // Compter les compétences extraites
    $stmt = $db->prepare("SELECT COUNT(*) FROM competences_utilisateurs WHERE user_id = ?");
    $stmt->execute([$userId]);
    $stats['competences'] = $stmt->fetchColumn() ?: 0;
} catch (Exception $e) {
    // Tables peuvent ne pas exister
}

// Traitement de l'upload
$uploadMessage = '';
$uploadSuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cv_file'])) {
    $file = $_FILES['cv_file'];
    $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    
    if ($file['error'] === UPLOAD_ERR_OK && in_array($file['type'], $allowedTypes)) {
        $uploadDir = __DIR__ . '/../../../uploads/cvs/' . $userId . '/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file['name']);
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            try {
                $db = Database::getInstance();
                $stmt = $db->prepare("INSERT INTO documents_utilisateurs (id, user_id, chemin_fichier, nom_fichier, type_document, created_at) VALUES (?, ?, ?, ?, 'cv', NOW())");
                $docId = bin2hex(random_bytes(16));
                $stmt->execute([$docId, $userId, 'uploads/cvs/' . $userId . '/' . $filename, $file['name']]);
                $uploadSuccess = true;
                $uploadMessage = 'CV uploadé avec succès !';
                header('Location: /dashboard/cvs?success=1');
                exit;
            } catch (Exception $e) {
                $uploadMessage = 'Erreur lors de l\'enregistrement.';
            }
        }
    } else {
        $uploadMessage = 'Format non supporté. Utilisez PDF, DOC ou DOCX.';
    }
}

// Suppression
if (isset($_GET['delete']) && $_GET['delete']) {
    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM documents_utilisateurs WHERE id = ? AND user_id = ?");
        $stmt->execute([$_GET['delete'], $userId]);
        header('Location: /dashboard/cvs?deleted=1');
        exit;
    } catch (Exception $e) {}
}
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
    <style>
        :root {
            --bg-primary: #0a0118;
            --bg-secondary: #1a0d2e;
            --bg-card: #241538;
            --bg-hover: #2d1b47;
            --text-primary: #ffffff;
            --text-secondary: #a0a0a0;
            --accent-purple: #9333ea;
            --accent-blue: #3b82f6;
            --accent-green: #10b981;
            --accent-yellow: #f59e0b;
            --accent-red: #ef4444;
            --border-color: rgba(255,255,255,0.1);
        }
        [data-theme="light"] {
            --bg-primary: #f1f5f9;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-hover: #f8fafc;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: rgba(0,0,0,0.1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-primary); color: var(--text-primary); min-height: 100vh; display: flex; }
        
        /* Sidebar */
        .sidebar { width: 280px; background: var(--bg-secondary); border-right: 1px solid var(--border-color); height: 100vh; position: fixed; left: 0; top: 0; display: flex; flex-direction: column; z-index: 100; transition: transform 0.3s; }
        .main-content { flex: 1; margin-left: 280px; padding: 2rem; min-height: 100vh; }
        
        /* Header */
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .page-title { font-size: 1.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; }
        .page-title i { color: var(--accent-purple); }
        .page-subtitle { color: var(--text-secondary); margin-top: 0.25rem; }
        .header-actions { display: flex; gap: 0.75rem; align-items: center; }
        
        /* Buttons */
        .btn { padding: 0.6rem 1.25rem; border-radius: 10px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; border: none; font-size: 0.9rem; transition: all 0.2s; }
        .btn-primary { background: linear-gradient(135deg, var(--accent-purple), var(--accent-blue)); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(147,51,234,0.4); }
        .btn-outline { background: transparent; border: 1px solid var(--border-color); color: var(--text-primary); }
        .btn-outline:hover { background: var(--bg-hover); border-color: var(--accent-purple); }
        .btn-sm { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
        .btn-danger { background: rgba(239,68,68,0.15); color: var(--accent-red); border: 1px solid rgba(239,68,68,0.3); }
        .btn-danger:hover { background: var(--accent-red); color: white; }
        
        .theme-toggle, .mobile-menu-btn { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 50%; width: 42px; height: 42px; cursor: pointer; color: var(--text-primary); display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .theme-toggle:hover, .mobile-menu-btn:hover { background: var(--bg-hover); border-color: var(--accent-purple); }
        .mobile-menu-btn { display: none; }
        
        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 2rem; }
        .stat-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem; transition: all 0.3s; }
        .stat-card:hover { transform: translateY(-3px); border-color: var(--accent-purple); }
        .stat-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .stat-icon.purple { background: linear-gradient(135deg, rgba(147,51,234,0.2), rgba(147,51,234,0.1)); color: var(--accent-purple); }
        .stat-icon.blue { background: linear-gradient(135deg, rgba(59,130,246,0.2), rgba(59,130,246,0.1)); color: var(--accent-blue); }
        .stat-icon.green { background: linear-gradient(135deg, rgba(16,185,129,0.2), rgba(16,185,129,0.1)); color: var(--accent-green); }
        .stat-icon.yellow { background: linear-gradient(135deg, rgba(245,158,11,0.2), rgba(245,158,11,0.1)); color: var(--accent-yellow); }
        .stat-content { flex: 1; }
        .stat-value { font-size: 1.75rem; font-weight: 700; line-height: 1; }
        .stat-label { color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.25rem; }
        
        /* Upload Zone */
        .upload-zone {
            background: linear-gradient(135deg, rgba(147,51,234,0.08), rgba(59,130,246,0.08));
            border: 2px dashed rgba(147,51,234,0.4);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 2.5rem;
            position: relative;
            overflow: hidden;
        }
        .upload-zone:hover, .upload-zone.dragover {
            border-color: var(--accent-purple);
            background: linear-gradient(135deg, rgba(147,51,234,0.15), rgba(59,130,246,0.15));
            transform: translateY(-2px);
        }
        .upload-zone input[type="file"] { display: none; }
        .upload-zone i { font-size: 3.5rem; color: var(--accent-purple); margin-bottom: 1rem; display: block; }
        .upload-zone h3 { font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; }
        .upload-zone p { color: var(--text-secondary); font-size: 0.9rem; }
        .upload-zone .supported-formats { margin-top: 1rem; display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap; }
        .upload-zone .format-badge { background: var(--bg-card); padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.75rem; color: var(--text-secondary); }
        
        /* Section Title */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .section-title { font-size: 1.25rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; }
        .section-title i { color: var(--accent-purple); }
        .cv-count { background: var(--accent-purple); color: white; font-size: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 10px; margin-left: 0.5rem; }
        
        /* CV Grid */
        .cv-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.5rem; }
        
        /* CV Card */
        .cv-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }
        .cv-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-purple);
            box-shadow: 0 15px 40px rgba(147,51,234,0.15);
        }
        .cv-card.primary { border-color: var(--accent-green); }
        .cv-card.primary:hover { border-color: var(--accent-green); box-shadow: 0 15px 40px rgba(16,185,129,0.15); }
        
        /* CV Preview */
        .cv-preview {
            height: 160px;
            background: linear-gradient(135deg, var(--bg-hover) 0%, var(--bg-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .cv-preview::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(147,51,234,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        .cv-preview .file-icon {
            font-size: 4rem;
            color: var(--accent-purple);
            opacity: 0.6;
            z-index: 1;
            transition: all 0.3s;
        }
        .cv-card:hover .cv-preview .file-icon { transform: scale(1.1); opacity: 0.8; }
        .cv-preview .file-icon.pdf { color: #ef4444; }
        .cv-preview .file-icon.doc { color: #3b82f6; }
        
        /* CV Status Badge */
        .cv-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 2;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.85rem;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }
        .badge-green { background: rgba(16,185,129,0.2); color: var(--accent-green); border: 1px solid rgba(16,185,129,0.3); }
        .badge-yellow { background: rgba(245,158,11,0.2); color: var(--accent-yellow); border: 1px solid rgba(245,158,11,0.3); }
        .badge-blue { background: rgba(59,130,246,0.2); color: var(--accent-blue); border: 1px solid rgba(59,130,246,0.3); }
        
        /* CV Body */
        .cv-body { padding: 1.5rem; }
        .cv-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .cv-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        .cv-meta span { display: flex; align-items: center; gap: 0.35rem; }
        .cv-meta i { font-size: 0.8rem; }
        
        /* CV Skills */
        .cv-skills { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.25rem; }
        .cv-skill {
            background: linear-gradient(135deg, rgba(147,51,234,0.15), rgba(59,130,246,0.1));
            color: var(--accent-purple);
            padding: 0.35rem 0.85rem;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid rgba(147,51,234,0.2);
            transition: all 0.2s;
        }
        .cv-skill:hover { background: rgba(147,51,234,0.25); transform: scale(1.05); }
        .cv-skill.more { background: var(--bg-hover); color: var(--text-secondary); border-color: var(--border-color); }
        
        /* ATS Score */
        .ats-score {
            background: var(--bg-hover);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .ats-bar {
            flex: 1;
            height: 8px;
            background: var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }
        .ats-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease;
        }
        .ats-fill.high { background: linear-gradient(90deg, var(--accent-green), #34d399); }
        .ats-fill.medium { background: linear-gradient(90deg, var(--accent-yellow), #fbbf24); }
        .ats-fill.low { background: linear-gradient(90deg, var(--accent-red), #f87171); }
        .ats-label { font-size: 0.8rem; color: var(--text-secondary); white-space: nowrap; }
        .ats-value { font-weight: 700; font-size: 0.9rem; }
        .ats-value.high { color: var(--accent-green); }
        .ats-value.medium { color: var(--accent-yellow); }
        .ats-value.low { color: var(--accent-red); }
        
        /* CV Actions */
        .cv-actions { display: flex; gap: 0.5rem; }
        .cv-actions .btn { flex: 1; justify-content: center; padding: 0.65rem; }
        .cv-actions .btn i { font-size: 1rem; }
        
        /* Generator Card */
        .cv-card.generator-card {
            background: linear-gradient(135deg, rgba(147,51,234,0.12), rgba(59,130,246,0.12));
            border: 2px dashed rgba(147,51,234,0.4);
        }
        .cv-card.generator-card:hover {
            border-style: solid;
            border-color: var(--accent-purple);
        }
        .generator-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 340px;
            text-align: center;
            padding: 2rem;
        }
        .generator-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--accent-purple), var(--accent-blue));
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(147,51,234,0.3);
            transition: all 0.3s;
        }
        .cv-card.generator-card:hover .generator-icon { transform: scale(1.1) rotate(5deg); }
        .generator-content h3 { font-size: 1.25rem; margin-bottom: 0.5rem; }
        .generator-content p { color: var(--text-secondary); margin-bottom: 1.5rem; max-width: 250px; }
        
        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            transform: translateY(150%);
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        .toast.show { transform: translateY(0); }
        .toast.success { border-color: var(--accent-green); }
        .toast.success i { color: var(--accent-green); }
        .toast.error { border-color: var(--accent-red); }
        .toast.error i { color: var(--accent-red); }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }
        .empty-state i { font-size: 4rem; opacity: 0.3; margin-bottom: 1rem; }
        .empty-state h3 { color: var(--text-primary); margin-bottom: 0.5rem; }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal.active { display: flex; }
        .modal-content {
            background: var(--bg-card);
            border-radius: 24px;
            padding: 2rem;
            width: 90%;
            max-width: 500px;
            max-height: 85vh;
            overflow-y: auto;
            animation: modalIn 0.3s ease;
        }
        @keyframes modalIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        .modal-title { font-size: 1.25rem; font-weight: 600; }
        .modal-close {
            background: var(--bg-hover);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .modal-close:hover { background: var(--accent-red); color: white; }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .cv-grid { grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 1.5rem; }
            .mobile-menu-btn { display: flex; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .cv-grid { grid-template-columns: 1fr; }
            .upload-zone { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/_sidebar.php'; ?>
    
    <main class="main-content">
        <!-- Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title"><i class="fas fa-file-alt"></i> Mes CVs</h1>
                <p class="page-subtitle">Gérez et optimisez vos curriculum vitae</p>
            </div>
            <div class="header-actions">
                <button class="mobile-menu-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <button class="theme-toggle" onclick="toggleTheme()"><i class="fas fa-moon"></i></button>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-file-alt"></i></div>
                <div class="stat-content">
                    <div class="stat-value"><?= $stats['total'] ?></div>
                    <div class="stat-label">CVs uploadés</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-brain"></i></div>
                <div class="stat-content">
                    <div class="stat-value"><?= $stats['competences'] ?></div>
                    <div class="stat-label">Compétences extraites</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-chart-line"></i></div>
                <div class="stat-content">
                    <div class="stat-value"><?= $stats['score_ats'] ?>%</div>
                    <div class="stat-label">Score ATS moyen</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="fas fa-eye"></i></div>
                <div class="stat-content">
                    <div class="stat-value"><?= $stats['vues'] ?></div>
                    <div class="stat-label">Vues recruteurs</div>
                </div>
            </div>
        </div>
        
        <!-- Upload Zone -->
        <form method="POST" enctype="multipart/form-data" id="uploadForm">
            <label class="upload-zone" for="cvUpload" id="dropZone">
                <input type="file" id="cvUpload" name="cv_file" accept=".pdf,.doc,.docx">
                <i class="fas fa-cloud-upload-alt"></i>
                <h3>Glissez vos CVs ici</h3>
                <p>ou cliquez pour sélectionner un fichier</p>
                <div class="supported-formats">
                    <span class="format-badge"><i class="fas fa-file-pdf"></i> PDF</span>
                    <span class="format-badge"><i class="fas fa-file-word"></i> DOC</span>
                    <span class="format-badge"><i class="fas fa-file-word"></i> DOCX</span>
                    <span class="format-badge">Max 10 MB</span>
                </div>
            </label>
        </form>
        
        <!-- Documents Section -->
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-folder-open"></i> Mes documents
                <span class="cv-count"><?= count($documents) ?></span>
            </h2>
        </div>
        
        <div class="cv-grid">
            <!-- Générateur de CV -->
            <div class="cv-card generator-card">
                <div class="generator-content">
                    <div class="generator-icon"><i class="fas fa-magic"></i></div>
                    <h3>Générer un CV</h3>
                    <p>Notre IA crée un CV professionnel optimisé pour les ATS</p>
                    <button class="btn btn-primary" onclick="openGenerator()">
                        <i class="fas fa-wand-magic-sparkles"></i> Créer mon CV
                    </button>
                </div>
            </div>
            
            <?php if (empty($documents)): ?>
                <!-- Empty State si pas de documents -->
            <?php else: ?>
                <?php foreach ($documents as $index => $doc): 
                    $isPrimary = $index === 0;
                    $filename = $doc['nom_fichier'] ?? basename($doc['chemin_fichier']);
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $fileIcon = $ext === 'pdf' ? 'fa-file-pdf pdf' : 'fa-file-word doc';
                    $fileSize = '---';
                    $fullPath = __DIR__ . '/../../../' . $doc['chemin_fichier'];
                    if (file_exists($fullPath)) {
                        $bytes = filesize($fullPath);
                        $fileSize = $bytes > 1048576 ? round($bytes/1048576, 1) . ' Mo' : round($bytes/1024) . ' Ko';
                    }
                    $dateFormatted = isset($doc['created_at']) ? date('d M Y', strtotime($doc['created_at'])) : 'N/A';
                    $atsScore = rand(75, 98); // Simulé - à remplacer par analyse réelle
                ?>
                <div class="cv-card <?= $isPrimary ? 'primary' : '' ?>">
                    <div class="cv-preview">
                        <i class="fas <?= $fileIcon ?> file-icon"></i>
                        <div class="cv-status">
                            <?php if ($isPrimary): ?>
                                <span class="badge badge-green"><i class="fas fa-star"></i> Principal</span>
                            <?php else: ?>
                                <span class="badge badge-blue"><i class="fas fa-file"></i> Document</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="cv-body">
                        <h3 class="cv-name" title="<?= htmlspecialchars($filename) ?>">
                            <?= htmlspecialchars($filename) ?>
                        </h3>
                        <div class="cv-meta">
                            <span><i class="fas fa-calendar-alt"></i> <?= $dateFormatted ?></span>
                            <span><i class="fas fa-weight-hanging"></i> <?= $fileSize ?></span>
                            <span><i class="fas fa-eye"></i> <?= rand(0, 25) ?> vues</span>
                        </div>
                        
                        <div class="ats-score">
                            <span class="ats-label">Score ATS</span>
                            <div class="ats-bar">
                                <div class="ats-fill <?= $atsScore >= 85 ? 'high' : ($atsScore >= 60 ? 'medium' : 'low') ?>" 
                                     style="width: <?= $atsScore ?>%"></div>
                            </div>
                            <span class="ats-value <?= $atsScore >= 85 ? 'high' : ($atsScore >= 60 ? 'medium' : 'low') ?>">
                                <?= $atsScore ?>%
                            </span>
                        </div>
                        
                        <div class="cv-skills">
                            <span class="cv-skill">PHP</span>
                            <span class="cv-skill">JavaScript</span>
                            <span class="cv-skill more">+3</span>
                        </div>
                        
                        <div class="cv-actions">
                            <a href="/<?= htmlspecialchars($doc['chemin_fichier']) ?>" target="_blank" class="btn btn-outline btn-sm" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/<?= htmlspecialchars($doc['chemin_fichier']) ?>" download class="btn btn-outline btn-sm" title="Télécharger">
                                <i class="fas fa-download"></i>
                            </a>
                            <button class="btn btn-outline btn-sm" onclick="analyzeCV('<?= $doc['id'] ?>')" title="Analyser">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('<?= $doc['id'] ?>', '<?= htmlspecialchars($filename) ?>')" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
    
    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Action effectuée</span>
    </div>
    
    <!-- Modal Confirmation Suppression -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fas fa-exclamation-triangle" style="color: var(--accent-red);"></i> Confirmer la suppression</h3>
                <button class="modal-close" onclick="closeModal('deleteModal')"><i class="fas fa-times"></i></button>
            </div>
            <p style="margin-bottom: 1.5rem; color: var(--text-secondary);">
                Êtes-vous sûr de vouloir supprimer <strong id="deleteFileName"></strong> ?<br>
                Cette action est irréversible.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button class="btn btn-outline" onclick="closeModal('deleteModal')">Annuler</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger"><i class="fas fa-trash"></i> Supprimer</a>
            </div>
        </div>
    </div>
    
    <script>
        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            document.querySelector('.theme-toggle i').className = newTheme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';
        }
        
        // Init theme
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
        document.querySelector('.theme-toggle i').className = savedTheme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';
        
        // Mobile sidebar
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }
        
        // Drag & Drop Upload
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('cvUpload');
        const uploadForm = document.getElementById('uploadForm');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
        });
        
        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                uploadForm.submit();
            }
        });
        
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                uploadForm.submit();
            }
        });
        
        // Toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toast.className = 'toast ' + type;
            toastMessage.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }
        
        // Show success message if redirected after upload
        <?php if (isset($_GET['success'])): ?>
        setTimeout(() => showToast('CV uploadé avec succès !', 'success'), 300);
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
        setTimeout(() => showToast('Document supprimé', 'success'), 300);
        <?php endif; ?>
        <?php if ($uploadMessage && !$uploadSuccess): ?>
        setTimeout(() => showToast('<?= $uploadMessage ?>', 'error'), 300);
        <?php endif; ?>
        
        // Modal functions
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }
        
        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }
        
        function confirmDelete(docId, filename) {
            document.getElementById('deleteFileName').textContent = filename;
            document.getElementById('deleteConfirmBtn').href = '/dashboard/cvs?delete=' + docId;
            openModal('deleteModal');
        }
        
        // Analyze CV (placeholder)
        function analyzeCV(docId) {
            showToast('Analyse en cours...', 'success');
            // TODO: Implement real CV analysis
        }
        
        // Open CV Generator (placeholder)
        function openGenerator() {
            showToast('Fonctionnalité bientôt disponible !', 'success');
            // TODO: Implement CV generator modal
        }
        
        // Close modal on click outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal(modal.id);
            });
        });
    </script>
</body>
</html>
