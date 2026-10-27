<?php
require_once(__DIR__ . "/../db.php");
require_once(__DIR__ . "/parola.php");

/**
 * Creează un utilizator. Returnează ['ok' => bool, 'id' => int|null, 'erori' => array].
 * Rolul îl stabilește codul apelant, niciodată formularul.
 */
function creeazaUtilizator(string $nume, string $prenume, string $email, string $parola, string $rol): array
{
    if (!DB_ENABLED) {
        return ['ok' => false, 'id' => null, 'erori' => ['Baza de date nu este conectată.']];
    }

    $erori = [];
    if (mb_strlen($nume) < 2) {
        $erori[] = 'Introdu numele (minim 2 caractere).';
    }
    if (mb_strlen($prenume) < 2) {
        $erori[] = 'Introdu prenumele (minim 2 caractere).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erori[] = 'Introdu o adresă de e-mail validă.';
    }
    $erori = array_merge($erori, valideazaParola($parola));
    if ($erori) {
        return ['ok' => false, 'id' => null, 'erori' => $erori];
    }

    try {
        $pdo  = getConnection();
        $stmt = $pdo->prepare(
            'INSERT INTO utilizatori (nume, prenume, email, parola_hash, rol)
             VALUES (:nume, :prenume, :email, :hash, :rol)'
        );
        $stmt->execute([
            ':nume'    => $nume,
            ':prenume' => $prenume,
            ':email'   => $email,
            ':hash'    => password_hash($parola, PASSWORD_DEFAULT),
            ':rol'     => $rol,
        ]);
        return ['ok' => true, 'id' => (int)$pdo->lastInsertId(), 'erori' => []];
    } catch (PDOException $e) {
        $mesaj = $e->getCode() === '23000'
            ? 'Există deja un cont cu acest e-mail.'
            : 'Contul nu a putut fi creat. Încearcă din nou.';
        return ['ok' => false, 'id' => null, 'erori' => [$mesaj]];
    }
}

function listaUtilizatori(): array
{
    if (!DB_ENABLED) {
        return [];
    }
    try {
        return getConnection()->query(
            'SELECT id, nume, prenume, email, rol, activ, ultima_autentificare FROM utilizatori ORDER BY id'
        )->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function seteazaActiv(int $id, bool $activ): bool
{
    if (!DB_ENABLED) {
        return false;
    }
    try {
        $stmt = getConnection()->prepare('UPDATE utilizatori SET activ = :activ WHERE id = :id');
        return $stmt->execute([':activ' => $activ ? 1 : 0, ':id' => $id]);
    } catch (PDOException $e) {
        return false;
    }
}

function numaraUtilizatori(): int
{
    if (!DB_ENABLED) {
        return 0;
    }
    try {
        return (int)getConnection()->query('SELECT COUNT(*) FROM utilizatori')->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

function adminExista(): bool
{
    if (!DB_ENABLED) {
        return false;
    }
    try {
        return (int)getConnection()->query("SELECT COUNT(*) FROM utilizatori WHERE rol = 'administrator'")->fetchColumn() > 0;
    } catch (PDOException $e) {
        return false;
    }
}
