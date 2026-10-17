<?php
require_once("config.php");

$erori  = [];
$trimis = false;
$val    = ['nume' => '', 'email' => '', 'evaluare' => '', 'mesaj' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $val['nume']     = trim($_POST['nume'] ?? '');
    $val['email']    = trim($_POST['email'] ?? '');
    $val['evaluare'] = trim($_POST['evaluare'] ?? '');
    $val['mesaj']    = trim($_POST['mesaj'] ?? '');

    if (mb_strlen($val['nume']) < 2) {
        $erori[] = 'Introdu numele (minim 2 caractere).';
    }
    if (!filter_var($val['email'], FILTER_VALIDATE_EMAIL)) {
        $erori[] = 'Introdu o adresă de e-mail validă.';
    }
    if (!in_array($val['evaluare'], ['1', '2', '3', '4', '5'], true)) {
        $erori[] = 'Alege o evaluare de la 1 la 5.';
    }
    if (mb_strlen($val['mesaj']) < 10) {
        $erori[] = 'Mesajul trebuie să aibă minim 10 caractere.';
    }

    if (!$erori) {
        // Deocamdată mesajul nu se salvează; doar se afișează confirmarea.
        $trimis = true;
        $val = ['nume' => '', 'email' => '', 'evaluare' => '', 'mesaj' => ''];
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Feedback – TransAbon</title>
    <?php require_once("components/styleslink.php"); ?>
</head>
<body>
<!--Navbar-->
<?php require_once("components/navbar.php"); ?>

<div class="container">
    <h1>Feedback</h1>
    <p class="subtitle">Spune-ne ce crezi despre TransAbon și cum îl putem îmbunătăți.</p>

    <div class="form-card">
        <?php if ($trimis): ?>
            <div class="msg-ok">Mulțumim! Mesajul tău a fost primit.</div>
        <?php endif; ?>

        <?php if ($erori): ?>
            <div class="msg-err">
                <ul>
                    <?php foreach ($erori as $eroare): ?>
                        <li><?php echo htmlspecialchars($eroare); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="feedback.php" method="POST">
            <div class="form-group">
                <label for="nume">Nume</label>
                <input type="text" id="nume" name="nume" value="<?php echo htmlspecialchars($val['nume']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($val['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="evaluare">Evaluare</label>
                <select id="evaluare" name="evaluare" required>
                    <option value="">Alege...</option>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?php echo $i; ?>" <?php echo $val['evaluare'] === (string)$i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="mesaj">Mesaj</label>
                <textarea id="mesaj" name="mesaj" rows="5" required><?php echo htmlspecialchars($val['mesaj']); ?></textarea>
            </div>

            <button type="submit">Trimite</button>
        </form>
    </div>
</div>

<?php require_once("components/footer.php"); ?>
</body>
</html>