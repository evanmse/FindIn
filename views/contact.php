<?php if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../views/layouts/header.php';
require_once __DIR__ . '/../models/Database.php';

// Handle POST submission
$success = false;
$errorMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name === '' || $email === '' || $message === '') {
        $errorMsg = 'Tous les champs sont requis.';
    } else {
        try {
            $db = \Database::getInstance();
            $stmt = $db->prepare("INSERT INTO messages (nom, email, message) VALUES (:nom, :email, :message)");
            $stmt->execute([':nom' => $name, ':email' => $email, ':message' => $message]);
            $success = true;
        } catch (Exception $e) {
            $errorMsg = 'Impossible d\'enregistrer le message.';
        }
    }
}
?>
<main class="container">
    <section class="section">
        <h1>Contact</h1>
        <p>Une question ? Écrivez-nous — nous répondons habituellement sous 48h.</p>

        <div class="grid" style="margin-top:2rem;">
            <div class="card">
                <h3>Support</h3>
                <p>support@findin.com</p>
            </div>
            <div class="card">
                <h3>Commercial</h3>
                <p>contact@findin.com</p>
            </div>
            <div class="card">
                <h3>Siège</h3>
                <p>FindIN — 12 rue de l'Innovation, 75000 Paris</p>
            </div>
        </div>

        <div style="margin-top:2rem;" class="card">
            <h3>Envoyer un message</h3>
            <?php if ($success): ?>
                <div class="card" style="background:#ecfdf5;border:1px solid #10b981;color:#065f46;padding:16px;margin-bottom:16px;">Votre message a bien été envoyé. Nous vous répondrons sous 48h.</div>
            <?php elseif ($errorMsg): ?>
                <div class="card" style="background:#fff4f4;border:1px solid #ef4444;color:#7f1d1d;padding:16px;margin-bottom:16px;"><?php echo htmlspecialchars($errorMsg); ?></div>
            <?php endif; ?>

            <form action="/contact" method="post">
                <div class="form-group">
                    <label class="form-label">Votre nom</label>
                    <input class="form-control" type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" name="message" rows="6" required></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Envoyer</button>
            </form>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../views/layouts/footer.php';
