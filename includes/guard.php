<?php
require_once __DIR__ . '/../config.php';

/** Pagina de start a fiecărui rol. */
function pagina_rol(string $rol): string
{
    $pagini = [
        'administrator' => BASE_URL . 'admin/',
        'controlor'     => BASE_URL . 'controlor/',
        'client'        => BASE_URL . 'client/',
    ];
    return $pagini[$rol] ?? BASE_URL . 'client/';
}

/** Salvează utilizatorul autentificat în sesiune. */
function autentificaSesiune(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user_id']   = (int)$user['id'];
    $_SESSION['user_rol']  = $user['rol'];
    $_SESSION['user_nume'] = trim($user['prenume'] . ' ' . $user['nume']);
}

/**
 * Pune la începutul fiecărei pagini protejate.
 * Nelogat -> login; rol nepermis -> acces-interzis.php.
 */
function cere_rol(array $roluri): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . 'loggin.php');
        exit;
    }
    if (!in_array($_SESSION['user_rol'], $roluri, true)) {
        header('Location: ' . BASE_URL . 'acces-interzis.php');
        exit;
    }
}
