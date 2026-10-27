<?php
// Creează conturile de test. Rulează o singură dată, apoi ȘTERGE acest fișier.
require_once("config.php");
require_once("includes/utilizatori.php");

header('Content-Type: text/plain; charset=utf-8');

if (!DB_ENABLED) {
    exit("Baza de date nu este activă. Setează DB_ENABLED = true în db.php.\n");
}
if (adminExista()) {
    exit("Administratorul există deja. Șterge seed.php.\n");
}

$conturi = [
    ['Admin',     'Demo', 'admin@transabon.md',     'administrator'],
    ['Controlor', 'Demo', 'controlor@transabon.md', 'controlor'],
];

foreach ($conturi as [$nume, $prenume, $email, $rol]) {
    $r = creeazaUtilizator($nume, $prenume, $email, 'Demo123!', $rol);
    echo $email . ' (' . $rol . '): ' . ($r['ok'] ? 'creat' : implode(' ', $r['erori'])) . "\n";
}
echo "\nParola de test: Demo123!\nȘterge acum seed.php.\n";
