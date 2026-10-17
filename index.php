<?php
session_start();
require_once("config.php");
$date = require("data/abonamente.php");

$denumireProiect  = "TransAbon – Sistemul de gestionare a abonamentelor de transport";
$descriereProiect = "Aplicație Web prin care clienții comandă online abonamente de transport, " .
        "iar controlorii verifică rapid valabilitatea lor prin codul unic al abonamentului.";

// Carousel code
$dir = "carousel-images/";
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

$all_files = scandir($dir);

$images = array_values(array_filter($all_files, function ($file) use ($allowed_extensions, $dir) {
    if (is_dir($dir . $file)) return false;
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    return in_array($extension, $allowed_extensions);
}));

// Initialize the counter in session ONLY if it doesn't exist yet
if (!isset($_SESSION['current_image'])) {
    $_SESSION['current_image'] = 0;
}

function carousel_image_src(string $dir, array $images, int $current_image): string {
    $total = count($images);
    if ($total === 0) return '';
    $index = (($current_image % $total) + $total) % $total;
    return $dir . $images[$index];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['next_image'])) {
        nextImage();
    }
    if (isset($_POST['previous_image'])) {
        previousImage();
    }
}

function nextImage(){
    $_SESSION['current_image']++;
}
function previousImage(){
    $_SESSION['current_image']--;
}
//carousel functions

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Acasă – TransAbon</title>
    <?php require_once("components/styleslink.php"); ?>

</head>
<body>
<!--Navbar-->
<?php require_once("components/navbar.php"); ?>

<!--Carousel-->
<div class="carousel-container">
    <?php
    echo '<img src="' . htmlspecialchars(carousel_image_src($dir, $images, $_SESSION['current_image'])) . '" alt="Imagine carusel" style="width: 100vw; height: 600px;">';
    ?>
    <div class="carousel-buttons">
        <form method="post">
            <button type="submit" name="previous_image"> <img src="images/previous.png" alt="Imaginea anterioară"></button>
        </form>
        <form method="post">
            <button type="submit" name="next_image"><img src="images/next.png" alt="Imaginea următoare"> </button>
        </form>

    </div>

</div>
<!--Content-->
<div class="container">

    <h1><?php echo htmlspecialchars($denumireProiect); ?></h1>
    <p class="subtitle"><?php echo htmlspecialchars($descriereProiect); ?></p>

    <h2>Abonamente disponibile</h2>
    <p>Abonamentele sunt valabile pe toate mijloacele de transport din regiune, nu sunt legate de un traseu anume.</p>
    <div class="card-grid">
        <?php foreach ($date['categorii'] as $categorie): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($categorie['nume']); ?></h3>
                <p><?php echo htmlspecialchars($categorie['descriere']); ?></p>
                <p class="price">
                    <?php if ($categorie['preturi'] === null): ?>
                        Gratuit
                    <?php else: ?>
                        de la <?php echo number_format(min($categorie['preturi']), 0, ',', '.'); ?> lei
                    <?php endif; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
    <p><a href="abonamente.php">Vezi toate tarifele</a></p>

    <h2>Cum comanzi un abonament</h2>
    <ol class="steps">
        <li>Consulți tipurile de abonament și tarifele, fără cont.</li>
        <li>Îți creezi un cont sau te autentifici.</li>
        <li>Alegi categoria, perioada și data de început, apoi confirmi comanda.</li>
        <li>Primești abonamentul cu un cod unic, vizibil în contul tău.</li>
        <li>Prezintă codul controlorului, care îl verifică în aplicație.</li>
    </ol>

</div>
<!--    FOOTER-->
<?php require_once("components/footer.php"); ?>
</body>
</html>