<?php

define('AUTOR', 'Iurcu Nicolae');
define('VERSIUNE_APLICATIE', '2.0.0');
define('GRUPA', 'AAW-231');

// Calea proiectului față de rădăcina serverului (cu slash la sfârșit).
define('BASE_URL', '/gestionarea-abonamentelor/');

// Sesiunea se pornește o singură dată, aici.
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
