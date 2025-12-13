<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Database.php';
$db = Database::getInstance();
// Select all columns so this works with both MySQL (id_message) and SQLite (id)
$stmt = $db->query('SELECT * FROM messages ORDER BY cree_le DESC LIMIT 20');
$rows = $stmt->fetchAll();
foreach ($rows as $r) {
    echo "ID: " . ($r['id'] ?? $r['id_message'] ?? '') . "\n";
    echo "Name: " . ($r['nom'] ?? '') . "\n";
    echo "Email: " . ($r['email'] ?? '') . "\n";
    echo "Message: " . substr(($r['message'] ?? ''),0,120) . "\n";
    echo "Date: " . ($r['cree_le'] ?? '') . "\n";
    echo "----\n";
}
if (count($rows)===0) echo "(no messages)\n";
