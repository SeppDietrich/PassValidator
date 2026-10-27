<?php
/**
 * Regulile parolei, într-un singur loc.
 * Returnează lista erorilor (goală dacă parola este corectă).
 * Aceleași reguli sunt verificate și în browser, în js/parola.js.
 */
function valideazaParola(string $parola): array
{
    $erori = [];
    if (mb_strlen($parola) < 8) {
        $erori[] = 'Parola trebuie să aibă minim 8 caractere.';
    }
    if (strlen($parola) > 72) {
        $erori[] = 'Parola poate avea cel mult 72 de caractere.';
    }
    if (!preg_match('/\p{Lu}/u', $parola)) {
        $erori[] = 'Parola trebuie să conțină cel puțin o literă mare.';
    }
    if (!preg_match('/\p{Ll}/u', $parola)) {
        $erori[] = 'Parola trebuie să conțină cel puțin o literă mică.';
    }
    if (!preg_match('/\d/', $parola)) {
        $erori[] = 'Parola trebuie să conțină cel puțin o cifră.';
    }
    return $erori;
}
