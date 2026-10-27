<?php
require_once("config.php");
require_once("includes/guard.php");
require_once("includes/csrf.php");
require_once("includes/auth.php");

// Utilizatorul deja autentificat merge direct la pagina rolului.
if (!empty($_SESSION['user_id'])) {
    header("Location: " . pagina_rol($_SESSION['user_rol']));
    exit;
}

$eroare = '';
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email  = trim($_POST['email'] ?? '');
    $parola = $_POST['password'] ?? '';

    if (!csrf_valid()) {
        $eroare = 'Sesiunea formularului a expirat. Încearcă din nou.';
    } elseif ($email === '' || $parola === '') {
        $eroare = 'Completează e-mailul și parola.';
    } else {
        $rezultat = autentificaUtilizator($email, $parola);
        if ($rezultat['ok']) {
            autentificaSesiune($rezultat['user']);
            header("Location: " . pagina_rol($rezultat['user']['rol']));
            exit;
        }
        $eroare = $rezultat['eroare'];
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Autentificare – TransAbon</title>
    <?php require_once("components/styleslink.php"); ?>
</head>
<body>
<!--Navbar-->
<?php require_once("components/navbar.php"); ?>
<!--LOGIN CONTENT-->

<div class="login-container">
    <h2>Autentificare</h2>

    <?php if ($eroare !== ''): ?>
        <div class="msg-err"><?php echo htmlspecialchars($eroare); ?></div>
    <?php endif; ?>

    <form action="loggin.php" method="POST">
        <?php echo csrf_camp(); ?>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Parolă</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Autentificare</button>
    </form>

    <p class="form-link">Nu ai cont? <a href="inregistrare.php">Creează cont</a></p>
</div>

<?php require_once("components/footer.php"); ?>
</body>
</html>
