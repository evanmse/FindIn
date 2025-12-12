<?php if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../views/layouts/header.php';
?>
<main class="container">
    <section class="section">
        <h1>À propos de FindIN</h1>
        <p>FindIN aide les organisations à cartographier, valider et mobiliser les compétences internes. Notre mission est de transformer les talents en avantage stratégique pour les entreprises.</p>

        <div class="grid" style="margin-top:2rem;">
            <div class="card">
                <h3>Notre histoire</h3>
                <p>FindIN a été créé pour résoudre le défi de visibilité des compétences en entreprise : centraliser les compétences, faciliter la mobilité interne et accélérer la mise en place de formations.</p>
            </div>

            <div class="card">
                <h3>Nos valeurs</h3>
                <p>Transparence, empowerment, protection des données et innovation sont au coeur de notre approche.</p>
            </div>

            <div class="card">
                <h3>Contact</h3>
                <p>Pour toute demande commerciale ou support : <a href="/contact">contact@findin.com</a>.</p>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../views/layouts/footer.php';
