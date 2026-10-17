<?php
require_once(__DIR__ . "/../db.php");

/**
 * Verifică datele de autentificare.
 * Returnează ['ok' => bool, 'user' => array|null, 'eroare' => string|null].
 *
 * Presupune un tabel "utilizatori" (obiectul „Utilizator” din caietul de sarcini)
 * cu coloanele: id, email, parola_hash, rol, activ.
 * Numele tabelului/coloanelor se ajustează când se creează baza de date.
 */
function autentificaUtilizator(string $email, string $parola): array
{
    if (!DB_ENABLED) {
        return ['ok' => false, 'user' => null,
            'eroare' => 'Autentificarea nu este încă activă: baza de date nu este conectată.'];
    }

    try {
        $stmt = getConnection()->prepare(
            'SELECT id, email, parola_hash, rol FROM utilizatori WHERE email = :email AND activ = 1 LIMIT 1'
        );
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($parola, $user['parola_hash'])) {
            unset($user['parola_hash']);
            return ['ok' => true, 'user' => $user, 'eroare' => null];
        }
        return ['ok' => false, 'user' => null, 'eroare' => 'E-mail sau parolă incorectă.'];
    } catch (PDOException $e) {
        return ['ok' => false, 'user' => null,
            'eroare' => 'Serviciul de autentificare nu este disponibil momentan.'];
    }
}