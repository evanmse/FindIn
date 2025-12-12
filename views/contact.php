<?php if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../views/layouts/header.php';
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
