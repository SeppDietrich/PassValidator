<?php
require_once __DIR__ . '/../includes/guard.php';
require_once __DIR__ . '/../includes/csrf.php';

$logat    = !empty($_SESSION['user_id']);
$rol      = $_SESSION['user_rol'] ?? '';
$etichete = ['client' => 'Contul meu', 'controlor' => 'Validare', 'administrator' => 'Administrare'];
?>
<header>
    <div class="list-header">
        <div class="dropdown-button nav-item">
            <img src="<?php echo BASE_URL; ?>images/dropdown.png" alt="Meniu" style="width: 50px; height: 50px;">
            <div class="dropdown-content">
                <a href="<?php echo BASE_URL; ?>index.php">Acasă</a>
                <a href="<?php echo BASE_URL; ?>about.php">Despre</a>
                <a href="<?php echo BASE_URL; ?>abonamente.php">Abonamente</a>
                <a href="<?php echo BASE_URL; ?>feedback.php">Feedback</a>
                <a href="<?php echo BASE_URL; ?>contact.php">Contact</a>
                <?php if ($logat): ?>
                    <a href="<?php echo pagina_rol($rol); ?>"><?php echo $etichete[$rol] ?? 'Contul meu'; ?></a>
                    <?php if ($rol === 'administrator'): ?>
                        <a href="<?php echo BASE_URL; ?>admin/utilizatori.php">Utilizatori</a>
                        <a href="<?php echo BASE_URL; ?>client/">Pagina client</a>
                        <a href="<?php echo BASE_URL; ?>controlor/">Pagina controlor</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="login-button nav-item">
            <?php if ($logat): ?>
                <div class="nav-user">
                    <span><?php echo htmlspecialchars($_SESSION['user_nume']); ?></span>
                    <span class="role-badge"><?php echo htmlspecialchars($rol); ?></span>
                    <form action="<?php echo BASE_URL; ?>logout.php" method="POST">
                        <?php echo csrf_camp(); ?>
                        <button type="submit">Deconectare</button>
                    </form>
                </div>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>loggin.php"><img src="<?php echo BASE_URL; ?>images/loggin.png" alt="Autentificare" style="height: 50px;width: 50px"> </a>
            <?php endif; ?>
        </div>
    </div>
</header>
