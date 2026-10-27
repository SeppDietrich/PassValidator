<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/guard.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/utilizatori.php';
cere_rol(['administrator']);

$erori = [];
$val   = ['nume' => '', 'prenume' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actiune = $_POST['actiune'] ?? '';

    if (!csrf_valid()) {
        $erori[] = 'Sesiunea formularului a expirat. Încearcă din nou.';
    } elseif ($actiune === 'creeaza') {
        $val['nume']    = trim($_POST['nume'] ?? '');
        $val['prenume'] = trim($_POST['prenume'] ?? '');
        $val['email']   = trim($_POST['email'] ?? '');
        $rez = creeazaUtilizator($val['nume'], $val['prenume'], $val['email'], $_POST['parola'] ?? '', 'controlor');
        if ($rez['ok']) {
            $_SESSION['flash'] = 'Contul de controlor a fost creat.';
            header('Location: utilizatori.php');
            exit;
        }
        $erori = $rez['erori'];
    } elseif ($actiune === 'comuta') {
        $id    = (int)($_POST['id'] ?? 0);
        $activ = ($_POST['activ'] ?? '') === '1';
        if ($id === (int)$_SESSION['user_id']) {
            $erori[] = 'Nu îți poți dezactiva propriul cont.';
        } elseif (seteazaActiv($id, $activ)) {
            $_SESSION['flash'] = $activ ? 'Contul a fost activat.' : 'Contul a fost dezactivat.';
            header('Location: utilizatori.php');
            exit;
        } else {
            $erori[] = 'Operația nu a reușit.';
        }
    }
}

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
$utilizatori = listaUtilizatori();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Utilizatori – TransAbon</title>
    <?php require_once __DIR__ . '/../components/styleslink.php'; ?>
</head>
<body>
<?php require_once __DIR__ . '/../components/navbar.php'; ?>

<div class="container">
    <h1>Utilizatori</h1>
    <p class="subtitle"><a href="index.php">← Înapoi la administrare</a></p>

    <?php if (!DB_ENABLED): ?>
        <div class="msg-err">Baza de date nu este conectată (DB_ENABLED în db.php).</div>
    <?php endif; ?>
    <?php if ($flash !== ''): ?>
        <div class="msg-ok"><?php echo htmlspecialchars($flash); ?></div>
    <?php endif; ?>
    <?php if ($erori): ?>
        <div class="msg-err">
            <ul>
                <?php foreach ($erori as $e): ?>
                    <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="panel">
        <h2>Creează cont de controlor</h2>
        <form action="utilizatori.php" method="POST" class="inline-form">
            <?php echo csrf_camp(); ?>
            <input type="hidden" name="actiune" value="creeaza">
            <div class="form-group">
                <label for="nume">Nume</label>
                <input type="text" id="nume" name="nume" value="<?php echo htmlspecialchars($val['nume']); ?>" required>
            </div>
            <div class="form-group">
                <label for="prenume">Prenume</label>
                <input type="text" id="prenume" name="prenume" value="<?php echo htmlspecialchars($val['prenume']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($val['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="parola">Parolă</label>
                <input type="password" id="parola" name="parola" autocomplete="new-password" required>
            </div>
            <button type="submit" class="btn">Creează</button>
        </form>
        <p id="parola-info" class="muted"></p>
    </div>

    <div class="panel">
        <h2>Lista utilizatorilor</h2>
        <div class="table-wrap">
            <table>
                <thead>
                <tr><th>E-mail</th><th>Nume</th><th>Rol</th><th>Stare</th><th>Ultima autentificare</th><th></th></tr>
                </thead>
                <tbody>
                <?php foreach ($utilizatori as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo htmlspecialchars($u['prenume'] . ' ' . $u['nume']); ?></td>
                        <td><?php echo htmlspecialchars($u['rol']); ?></td>
                        <td>
                            <?php if ($u['activ']): ?>
                                <span class="badge badge-activ">activ</span>
                            <?php else: ?>
                                <span class="badge badge-expirat">dezactivat</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($u['ultima_autentificare'] ?? '—'); ?></td>
                        <td class="actions">
                            <?php if ((int)$u['id'] !== (int)$_SESSION['user_id']): ?>
                                <form action="utilizatori.php" method="POST">
                                    <?php echo csrf_camp(); ?>
                                    <input type="hidden" name="actiune" value="comuta">
                                    <input type="hidden" name="id" value="<?php echo (int)$u['id']; ?>">
                                    <input type="hidden" name="activ" value="<?php echo $u['activ'] ? '0' : '1'; ?>">
                                    <button type="submit" class="btn btn-sm <?php echo $u['activ'] ? 'btn-danger' : ''; ?>">
                                        <?php echo $u['activ'] ? 'Dezactivează' : 'Activează'; ?>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../components/footer.php'; ?>
<script src="<?php echo BASE_URL; ?>js/parola.js"></script>
</body>
</html>
