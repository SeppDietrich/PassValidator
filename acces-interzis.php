<?php
require_once("config.php");
require_once("includes/guard.php");
http_response_code(403);
$inapoi = !empty($_SESSION['user_id']) ? pagina_rol($_SESSION['user_rol']) : BASE_URL . 'index.php';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Acces interzis – TransAbon</title>
    <?php require_once("components/styleslink.php"); ?>
</head>
<body>
<?php require_once("components/navbar.php"); ?>

<div class="container">
    <h1>Acces interzis</h1>
    <p>Rolul contului tău nu are acces la această pagină.</p>
    <p><a href="<?php echo htmlspecialchars($inapoi); ?>">Înapoi</a></p>
</div>

<?php require_once("components/footer.php"); ?>
</body>
</html>
