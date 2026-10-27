<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/guard.php';
cere_rol(['client', 'administrator']);
$date = require __DIR__ . '/../data/abonamente.php';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Contul meu – TransAbon</title>
    <?php require_once __DIR__ . '/../components/styleslink.php'; ?>
</head>
<body>
<?php require_once __DIR__ . '/../components/navbar.php'; ?>

<div class="container">
    <h1>Contul meu</h1>
    <p class="subtitle">Bun venit, <?php echo htmlspecialchars($_SESSION['user_nume']); ?>.</p>

    <div class="notice">Machetă: datele sunt fictive, iar comanda și anularea abonamentelor se implementează în etapa următoare.</div>
    <div class="notice">Abonamentul TA-DEMO-0004 expiră în 2 zile. <button type="button" class="btn btn-sm" disabled>Comandă reînnoire</button></div>

    <div class="panel">
        <h2>Abonamentele mele</h2>
        <div class="table-wrap">
            <table>
                <thead>
                <tr><th>Cod</th><th>Categorie</th><th>Perioadă</th><th>Început</th><th>Expirare</th><th>Stare</th><th></th></tr>
                </thead>
                <tbody>
                <tr><td>TA-DEMO-0004</td><td>General</td><td>1 lună</td><td>2026-09-23</td><td>2026-10-22</td><td><span class="badge badge-activ">activ</span></td><td></td></tr>
                <tr><td>TA-DEMO-0005</td><td>General</td><td>1 lună</td><td>2026-11-01</td><td>2026-11-30</td><td><span class="badge badge-programat">programat</span></td><td class="actions"><button type="button" class="btn btn-sm btn-danger" disabled>Anulează</button></td></tr>
                <tr><td>TA-DEMO-0002</td><td>General</td><td>1 lună</td><td>2026-08-01</td><td>2026-08-30</td><td><span class="badge badge-expirat">expirat</span></td><td></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <h2>Comandă abonament</h2>
        <div class="inline-form">
            <div class="form-group">
                <label for="cat">Categorie</label>
                <select id="cat">
                    <?php foreach ($date['categorii'] as $c): ?>
                        <option><?php echo htmlspecialchars($c['nume']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="per">Perioadă</label>
                <select id="per">
                    <?php foreach ($date['perioade'] as $p): ?>
                        <option><?php echo htmlspecialchars($p); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="start">Data de început</label>
                <input id="start" type="date">
            </div>
            <button type="button" class="btn" disabled>Confirmă comanda</button>
        </div>
        <p class="muted">Abonamentul este valabil pe toate mijloacele de transport din regiune. Plata se face în afara aplicației.</p>
    </div>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
