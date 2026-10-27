<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/guard.php';
cere_rol(['controlor', 'administrator']);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Validare abonamente – TransAbon</title>
    <?php require_once __DIR__ . '/../components/styleslink.php'; ?>
</head>
<body>
<?php require_once __DIR__ . '/../components/navbar.php'; ?>

<div class="container">
    <h1>Validare abonamente</h1>
    <p class="subtitle">Controlor: <?php echo htmlspecialchars($_SESSION['user_nume']); ?></p>

    <div class="notice">Machetă: validarea reală se implementează în etapa următoare.</div>

    <div class="check-box">
        <label for="code">Codul abonamentului</label>
        <input id="code" type="text" autocomplete="off" placeholder="TA-XXXXXXXX">
        <button type="button" class="btn" disabled>Verifică</button>

        <div class="result ok">
            <strong>VALID</strong>
            <span>Exemplu de rezultat: valabil 2026-09-23 – 2026-10-22</span>
        </div>
        <div class="result bad">
            <strong>EXPIRAT</strong>
            <span>Exemplu de rezultat: a expirat la 2026-08-30.</span>
        </div>
    </div>

    <div class="panel">
        <h2>Validările de azi</h2>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Ora</th><th>Cod</th><th>Rezultat</th></tr></thead>
                <tbody>
                <tr><td>09:05:41</td><td>TA-DEMO-0001</td><td><span class="badge badge-valid">VALID</span></td></tr>
                <tr><td>09:02:10</td><td>TA-DEMO-0002</td><td><span class="badge badge-expirat">EXPIRAT</span></td></tr>
                <tr><td>08:58:33</td><td>TA-ZZZZZZZZ</td><td><span class="badge badge-inexistent">COD INEXISTENT</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
