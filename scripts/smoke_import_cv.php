<?php
/**
 * Simple smoke test: import a sample CV, parse it and optionally create a user.
 * Usage: php scripts/smoke_import_cv.php [path-to-sample]
 */
chdir(__DIR__ . '/..');
require_once 'config/database.php';
require_once 'lib/cv_parser.php';
require_once 'models/Database.php';

$sample = $argv[1] ?? __DIR__ . '/samples/sample_cv.txt';
if (!file_exists($sample)) {
    echo "Sample file not found: $sample\n";
    exit(1);
}

// copy into uploads
if (!is_dir('uploads/cvs')) mkdir('uploads/cvs', 0755, true);
$target = 'uploads/cvs/' . time() . '_' . basename($sample);
copy($sample, $target);

echo "Copied sample to: $target\n";

$parsed = parse_cv_file($target);
echo "Parsed text snippet:\n" . substr($parsed['text'],0,400) . "\n\n";
echo "Emails: " . implode(', ', $parsed['emails']) . "\n";
echo "Phones: " . implode(', ', $parsed['phones']) . "\n";
echo "Names: " . implode(', ', $parsed['names']) . "\n";
echo "Skills: " . implode(', ', $parsed['skills']) . "\n";

// optionally create/update user if email found
if (!empty($parsed['emails'])) {
    $email = $parsed['emails'][0];
    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT * FROM utilisateurs WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $u = $stmt->fetch();
    $prenom = $parsed['names'][0] ?? '';
    if ($u) {
        $stmt = $db->prepare('UPDATE utilisateurs SET prenom = ?, competences = ? WHERE email = ?');
        $stmt->execute([$prenom, implode(', ', $parsed['skills']), $email]);
        echo "Updated user $email\n";
    } else {
        // insert
        if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
            $stmt = $db->prepare('INSERT INTO utilisateurs (id_utilisateur, email, prenom, nom, role, competences) VALUES (UUID(), ?, ?, ?, ?, ?)');
            $stmt->execute([$email, $prenom, '', 'employe', implode(', ', $parsed['skills'])]);
        } else {
            $stmt = $db->prepare('INSERT INTO utilisateurs (email, prenom, nom, role, competences) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$email, $prenom, '', 'employe', implode(', ', $parsed['skills'])]);
        }
        echo "Created user $email\n";
    }
} else {
    echo "No email found in CV; skipping DB save.\n";
}

echo "Smoke import done.\n";
