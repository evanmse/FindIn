<?php
// Quick PHP script to POST to /contact then check DB for insertion.
// Usage: php scripts/test_contact_flow.php

$base = 'http://localhost:8000';
$postUrl = $base . '/contact';

// Random test payload
$name = 'Smoke Tester '.rand(1000,9999);
$email = 'smoke+'.rand(1000,9999).'@local';
$message = 'Test message generated at '.date('c');

// Use curl to POST
$ch = curl_init($postUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'name' => $name,
    'email' => $email,
    'message' => $message
]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$out = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if ($info['http_code'] < 200 || $info['http_code'] >= 400) {
    echo "POST request returned HTTP {$info['http_code']}\n";
    exit(1);
}

// Now check DB for the message via models/Database.php
require_once __DIR__ . '/../models/Database.php';
$db = Database::getInstance();
$stmt = $db->prepare("SELECT * FROM messages WHERE email = :email ORDER BY cree_le DESC LIMIT 1");
$stmt->execute([':email' => $email]);
$row = $stmt->fetch();
if ($row) {
    echo "Found message: id=".($row['id'] ?? $row['id_message'])." name={$row['nom']} email={$row['email']}\n";
    exit(0);
} else {
    echo "Message not found in DB.\n";
    exit(2);
}
