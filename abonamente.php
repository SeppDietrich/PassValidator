<?php
require_once("config.php");
$date = require("data/abonamente.php");
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Abonamente – TransAbon</title>
    <?php require_once("components/styleslink.php"); ?>
</head>
<body>
<!--Navbar-->
<?php require_once("components/navbar.php"); ?>

<div class="container">
    <h1>Abonamente</h1>
    <p class="subtitle">Prețurile sunt exprimate în lei (MDL). Abonamentele sunt valabile pe toate mijloacele de transport din regiune.</p>

    <div class="table-wrap">
        <table class="tabel-tarife">
            <tr>
                <th>Categorie</th>
                <?php foreach ($date['perioade'] as $perioada): ?>
                    <th class="pret"><?php echo htmlspecialchars($perioada); ?></th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($date['categorii'] as $categorie): ?>
                <?php if ($categorie['preturi'] === null): ?>
                    <tr class="gratuit">
                        <td><?php echo htmlspecialchars($categorie['nume']); ?></td>
                        <td class="pret" colspan="<?php echo count($date['perioade']); ?>">Gratuit</td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?php echo htmlspecialchars($categorie['nume']); ?></td>
                        <?php foreach ($date['perioade'] as $luni => $perioada): ?>
                            <td class="pret"><?php echo number_format($categorie['preturi'][$luni], 0, ',', '.'); ?> lei</td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<?php require_once("components/footer.php"); ?>
</body>
</html>