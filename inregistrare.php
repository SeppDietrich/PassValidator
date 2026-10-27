<?php
require_once("config.php");
require_once("includes/guard.php");
require_once("includes/csrf.php");
require_once("includes/utilizatori.php");

if (!empty($_SESSION['user_id'])) {
    header("Location: " . pagina_rol($_SESSION['user_rol']));
    exit;
}

$erori = [];
$val   = ['nume' => '', 'prenume' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $val['nume']    = trim($_POST['nume'] ?? '');
    $val['prenume'] = trim($_POST['prenume'] ?? '');
    $val['email']   = trim($_POST['email'] ?? '');
    $parola         = $_POST['parola'] ?? '';
    $confirmare     = $_POST['confirmare'] ?? '';

    if (!csrf_valid()) {
        $erori[] = 'Sesiunea formularului a expirat. Încearcă din nou.';
    } elseif ($parola !== $confirmare) {
        $erori[] = 'Parolele nu coincid.';
    } else {
        // Rolul este fixat aici: orice cont creat prin această pagină este Client.
        $rezultat = creeazaUtilizator($val['nume'], $val['prenume'], $val['email'], $parola, 'client');
        if ($rezultat['ok']) {
            autentificaSesiune([
                'id'      => $rezultat['id'],
                'rol'     => 'client',
                'nume'    => $val['nume'],
                'prenume' => $val['prenume'],
            ]);
            header("Location: " . pagina_rol('client'));
            exit;
        }
        $erori = $rezultat['erori'];
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Creare cont – TransAbon</title>
    <?php require_once("components/styleslink.php"); ?>
</head>
<body>
<?php require_once("components/navbar.php"); ?>

<div class="login-container">
    <h2>Creare cont</h2>

    <?php if ($erori): ?>
        <div class="msg-err">
            <ul>
                <?php foreach ($erori as $eroare): ?>
                    <li><?php echo htmlspecialchars($eroare); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="inregistrare.php" method="POST">
        <?php echo csrf_camp(); ?>
        <div class="form-group">
            <label for="nume">Nume</label>
            <input type="text" id="nume" name="nume" value="<?php echo htmlspecialchars($val['nume']); ?>" required>
        </div>

        <div class="form-group">
            <label for="prenume">Prenume</label>
            <input type="text" id="prenume" name="prenume" value="<?php echo htmlspecialchars($val['prenume']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($val['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="parola">Parolă (minim 8 caractere, literă mare, literă mică, cifră)</label>
            <input type="password" id="parola" name="parola" required>
            <small id="parola-info" class="muted"></small>
        </div>

        <div class="form-group">
            <label for="confirmare">Confirmă parola</label>
            <input type="password" id="confirmare" name="confirmare" required>
        </div>

        <button type="submit">Creează cont</button>
    </form>

    <p class="form-link">Ai deja cont? <a href="loggin.php">Autentifică-te</a></p>
</div>

<?php require_once("components/footer.php"); ?>
<script src="<?php echo BASE_URL; ?>js/parola.js"></script>
</body>
</html>
