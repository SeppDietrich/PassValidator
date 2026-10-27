<?php
require_once(__DIR__ . "/../db.php");

/**
 * Verifică datele de autentificare.
 * Returnează ['ok' => bool, 'user' => array|null, 'eroare' => string|null].
 */
function autentificaUtilizator(string $email, string $parola): array
{
    if (!DB_ENABLED) {
        return ['ok' => false, 'user' => null,
            'eroare' => 'Autentificarea nu este încă activă: baza de date nu este conectată.'];
    }

    try {
        $pdo  = getConnection();
        $stmt = $pdo->prepare(
            'SELECT id, nume, prenume, parola_hash, rol, activ FROM utilizatori WHERE email = :email LIMIT 1'
        );
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($parola, $user['parola_hash'])) {
            if (!$user['activ']) {
                return ['ok' => false, 'user' => null,
                    'eroare' => 'Contul este dezactivat. Contactează administratorul.'];
            }
            $pdo->prepare('UPDATE utilizatori SET ultima_autentificare = NOW() WHERE id = :id')
                ->execute([':id' => $user['id']]);
            unset($user['parola_hash']);
            return ['ok' => true, 'user' => $user, 'eroare' => null];
        }
        return ['ok' => false, 'user' => null, 'eroare' => 'E-mail sau parolă incorectă.'];
    } catch (PDOException $e) {
        return ['ok' => false, 'user' => null,
            'eroare' => 'Serviciul de autentificare nu este disponibil momentan.'];
    }
}
