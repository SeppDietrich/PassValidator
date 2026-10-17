<?php
session_start();
require_once("config.php");
require_once("includes/auth.php");

$eroare = '';
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email  = trim($_POST['email'] ?? '');
    $parola = $_POST['password'] ?? '';

    if ($email === '' || $parola === '') {
        $eroare = 'Completează e-mailul și parola.';
    } else {
        $rezultat = autentificaUtilizator($email, $parola);
        if ($rezultat['ok']) {
            session_regenerate_id(true);
            $_SESSION['user_id']   = $rezultat['user']['id'];
            $_SESSION['user_rol']  = $rezultat['user']['rol'];
            header("Location: index.php");
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
</div>

<?php require_once("components/footer.php"); ?>
</body>
</html>