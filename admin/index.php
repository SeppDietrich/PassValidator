<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/guard.php';
require_once __DIR__ . '/../includes/utilizatori.php';
cere_rol(['administrator']);
$date = require __DIR__ . '/../data/abonamente.php';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Administrare – TransAbon</title>
    <?php require_once __DIR__ . '/../components/styleslink.php'; ?>
</head>
<body>
<?php require_once __DIR__ . '/../components/navbar.php'; ?>

<div class="container">
    <h1>Administrare</h1>
    <p class="subtitle">Indicatorii abonamentelor, comenzilor și validărilor sunt fictivi. Numărul de conturi este real.</p>

    <div class="kpi-grid">
        <div class="kpi"><span class="kpi-value">1 284</span><span class="kpi-label">Abonamente active (fictiv)</span></div>
        <div class="kpi"><span class="kpi-value">96</span><span class="kpi-label">Comenzi în ultima săptămână (fictiv)</span></div>
        <div class="kpi"><span class="kpi-value">312</span><span class="kpi-label">Validări azi (fictiv)</span></div>
        <div class="kpi"><span class="kpi-value"><?php echo numaraUtilizatori(); ?></span><span class="kpi-label">Conturi</span></div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <h2>Conturi și roluri</h2>
            <a class="btn" href="utilizatori.php">Gestionează utilizatorii</a>
        </div>
        <p class="muted">Creare conturi de controlor, activare și dezactivare conturi.</p>
    </div>

    <div class="panel">
        <div class="panel-head">
            <h2>Tipuri de abonament și tarife (machetă)</h2>
            <button type="button" class="btn" disabled>Adaugă tip de abonament</button>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>Categorie</th>
                    <?php foreach ($date['perioade'] as $p): ?>
                        <th class="pret"><?php echo htmlspecialchars($p); ?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($date['categorii'] as $c): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['nume']); ?></td>
                        <?php if ($c['preturi'] === null): ?>
                            <td class="pret" colspan="<?php echo count($date['perioade']); ?>">Gratuit</td>
                        <?php else: ?>
                            <?php foreach ($date['perioade'] as $luni => $p): ?>
                                <td class="pret"><?php echo number_format($c['preturi'][$luni], 0, ',', '.'); ?> lei</td>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
