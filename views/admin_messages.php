<?php if (session_status() === PHP_SESSION_NONE) session_start();
// Only admin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: /login');
    exit;
}
require_once __DIR__ . '/../views/layouts/header.php';
require_once __DIR__ . '/../models/Database.php';

$db = \Database::getInstance();
// Fetch messages
$messages = [];
try {
    $stmt = $db->query("SELECT * FROM messages ORDER BY cree_le DESC LIMIT 200");
    while ($r = $stmt->fetch()) { $messages[] = $r; }
} catch (Exception $e) {
    // ignore
}
?>
<main class="container">
    <section class="section">
        <h1>Messages — Contact</h1>
        <p>Liste des messages envoyés via le formulaire de contact.</p>

        <div style="margin-top:1.5rem;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="padding:8px;text-align:left">#</th>
                        <th style="padding:8px;text-align:left">Nom</th>
                        <th style="padding:8px;text-align:left">Email</th>
                        <th style="padding:8px;text-align:left">Message</th>
                        <th style="padding:8px;text-align:left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($messages) === 0): ?>
                        <tr><td colspan="5" style="padding:12px">Aucun message trouvé.</td></tr>
                    <?php else: foreach ($messages as $m): ?>
                        <tr>
                            <td style="padding:8px"><?php echo htmlspecialchars($m['id'] ?? $m['id_message'] ?? ''); ?></td>
                            <td style="padding:8px"><?php echo htmlspecialchars($m['nom'] ?? ''); ?></td>
                            <td style="padding:8px"><?php echo htmlspecialchars($m['email'] ?? ''); ?></td>
                            <td style="padding:8px;max-width:500px;white-space:pre-wrap"><?php echo nl2br(htmlspecialchars($m['message'] ?? '')); ?></td>
                            <td style="padding:8px"><?php echo htmlspecialchars($m['cree_le'] ?? ''); ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../views/layouts/footer.php';
