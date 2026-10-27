<?php
require_once("config.php");
require_once("includes/csrf.php");

// Deconectarea se face doar prin POST, cu token CSRF.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_valid()) {
    $_SESSION = [];
    session_destroy();
}
header("Location: " . BASE_URL . "index.php");
exit;
