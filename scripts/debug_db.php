<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Database.php';

try {
    $db = Database::getInstance();
    echo "DB_TYPE=" . DB_TYPE . PHP_EOL;
    if (defined('DB_PATH')) echo "DB_PATH=" . DB_PATH . PHP_EOL;

    // Try a count
    $stmt = $db->query('SELECT COUNT(*) as c FROM messages');
    $row = $stmt->fetch();
    echo "messages_count=" . ($row['c'] ?? $row[0] ?? 'N/A') . PHP_EOL;

    // Also dump first rows for inspection
    $all = $db->query('SELECT * FROM messages ORDER BY cree_le DESC LIMIT 10')->fetchAll();
    echo "sample_rows=" . PHP_EOL;
    var_dump($all);

    // Show PDO driver name
    $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
    echo "pdo_driver=" . $driver . PHP_EOL;

    // If sqlite, show the file path we are using
    if ($driver === 'sqlite') {
        // We already printed DB_PATH when defined
        echo "using sqlite file: " . (defined('DB_PATH') ? DB_PATH : __DIR__ . '/../database.sqlite') . PHP_EOL;
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
}
