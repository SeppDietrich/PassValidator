<?php
session_start();
$denumireProiect      = "Sistem de Gestionare și Validare a Abonamentului";
$autor                = "Iurcu Nicolae";
$grupa                = "AAW-231";
$descriereProiect      = "Aplicație pentru gestionarea abonamentelor utilizatorilor: " .
        "validarea perioadei de acces, calculul zilelor rămase până la " .
        "expirare și monitorizarea ultimei utilizări.";
$utilizatoriPrincipali = ["Administratori de sistem", "Utilizatori abonați", "Operatori suport clienți"];
$entitatiPlanificate   = ["Abonament", "Utilizator", "Plată", "Rol de acces"];


//Variabile Constante
define('VERSIUNE_APLICATIE', '1.0.0');

//Definirea Clasei:

class Abonament {
    public int $id;
    public string $dataValidare;       // format y-m-d
    public string $dataExpirare;       // format y-m-d
    public string $rolAcces;
    public string $dataUltimaFolosire; // format y-m-d

    public function __construct(int $id, string $dataValidare, string $dataExpirare, string $rolAcces, string $dataUltimaFolosire){
        $this->id = $id;
        $this->dataValidare = $dataValidare;
        $this->dataExpirare = $dataExpirare;
        $this->rolAcces = $rolAcces;
        $this->dataUltimaFolosire = $dataUltimaFolosire;

    }

    //SEctiune de calcule
    public function zileRamasePanaLaExpirare(): int{
        $azi       = new DateTime('now');
        $expirare  = new DateTime($this->dataExpirare);
        $diferenta = $azi->diff($expirare);
        return $diferenta->invert ? -$diferenta->days : $diferenta->days;
    }
    public function zileDeLaUltimaFolosire(): int
    {
        $azi          = new DateTime('now');
        $ultimaFolos  = new DateTime($this->dataUltimaFolosire);
        return $azi->diff($ultimaFolos)->days;
    }
    public function procentPerioadaConsumata(): float
    {
        $validare  = new DateTime($this->dataValidare);
        $expirare  = new DateTime($this->dataExpirare);
        $azi       = new DateTime('now');

        $totalZile = max(1, $validare->diff($expirare)->days); // evită împărțirea la 0
        $zileScurse = $validare->diff($azi)->days;
        $zileScurse = max(0, min($zileScurse, $totalZile));

        return round(($zileScurse / $totalZile) * 100, 1);
    }
    public function status(): string
    {
        $zileRamase = $this->zileRamasePanaLaExpirare();

        if ($zileRamase > 0) {
            return "Activ";
        } else {
            return "Expirat";
        }
    }


}
$abonamente = [
        new Abonament(1, '2025-01-10', '2026-09-10', 'Standard', '2026-08-20'), // activ
        new Abonament(2, '2023-05-01', '2024-12-01', 'Premium',  '2024-04-15'), // expirat de mult
        new Abonament(3, '2026-06-01', '2026-10-01', 'Admin',    '2026-09-10'), // aproape de expirare
];

//Carousel code

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
    <title><?php echo htmlspecialchars($denumireProiect); ?></title>
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/header.css" rel="stylesheet">
    <link href="styles/content-body.css" rel="stylesheet">
    <link href="styles/carousel.css" rel="stylesheet">

</head>
<body>
<style>
</style>
<header>
        <div class="list-header">
            <div class="dropdown-button nav-item">
                Button
            </div>
            <div class="login-button nav-item">
                loggin
            </div>
        </div>
</header>
<!--Carousel-->
<div class="carousel-container">
    <?php
    echo '<img src="' . htmlspecialchars(carousel_image_src($dir, $images, $_SESSION['current_image'])) . '" alt="Image" style="width: 100vw; height: 600px;">';
    ?>
    <div class="carousel-buttons">
        <form method="post">
            <button type="submit" name="previous_image"> <img src="images/previous.png" alt=" Last Image Button"></button>
        </form>
        <form method="post">
            <button type="submit" name="next_image"><img src="images/next.png" alt="Next Image Button" > </button>
        </form>

    </div>

</div>
<!--Content-->
<div class="container">

    <h1><?php echo htmlspecialchars($denumireProiect); ?></h1>
    <p class="modul">Modul: Prezentare generală a proiectului</p>

    <h2>Detalii proiect</h2>
    <ul>
        <li><strong>Autor:</strong> <?php echo htmlspecialchars($autor); ?></li>
        <li><strong>Grupa:</strong> <?php echo htmlspecialchars($grupa); ?></li>
        <li><strong>Descriere:</strong> <?php echo htmlspecialchars($descriereProiect); ?></li>
        <li><strong>Utilizatori principali:</strong> <?php echo htmlspecialchars(implode(', ', $utilizatoriPrincipali)); ?></li>
        <li><strong>Entități planificate:</strong> <?php echo htmlspecialchars(implode(', ', $entitatiPlanificate)); ?></li>
    </ul>

    <h2>Entitatea: Abonament</h2>
    <p>Proprietăți: <code>id</code>, <code>dataValidare</code>, <code>dataExpirare</code>, <code>rolAcces</code>, <code>dataUltimaFolosire</code></p>
    <p>Constantă definită: <code>Versiune Aplicatie</code> = <?php echo VERSIUNE_APLICATIE; ?>
        (versiunea aplicatiei)</p>

    <h2>Rezultatele testării (3 seturi de date)</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Data validare</th>
            <th>Data expirare</th>
            <th>Rol acces</th>
            <th>Ultima folosire</th>
            <th>Zile rămase</th>
            <th>Zile de la ultima folosire</th>
            <th>% perioadă consumată</th>
            <th>Status</th>
        </tr>
        <?php foreach ($abonamente as $abonament):
            $status = $abonament->status();
            $clasaStatus = $status === 'Activ' ? 'activ' : (str_contains($status, 'grație') ? 'gratie' : 'expirat');
            ?>
            <tr>
                <td>#<?php echo $abonament->id; ?></td>
                <td><?php echo $abonament->dataValidare; ?></td>
                <td><?php echo $abonament->dataExpirare; ?></td>
                <td><?php echo htmlspecialchars($abonament->rolAcces); ?></td>
                <td><?php echo $abonament->dataUltimaFolosire; ?></td>
                <td><?php echo $abonament->zileRamasePanaLaExpirare() > 0 ? $abonament->zileRamasePanaLaExpirare() : "Expirat" ; ?></td>
                <td><?php echo $abonament->zileDeLaUltimaFolosire(); ?></td>
                <td><?php echo $abonament->procentPerioadaConsumata(); ?>%</td>
                <td class="<?php echo $clasaStatus; ?>"><?php echo $status; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <footer>
        Versiune aplicație: <?php echo VERSIUNE_APLICATIE; ?> &nbsp;|&nbsp;
        Autor: <?php echo htmlspecialchars($autor); ?>
    </footer>

</div>
</body>
</html>
