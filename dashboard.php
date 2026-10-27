<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

if (FORCE_HTTPS && (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off')) {
    header('Location: https://' . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '/'), true, 301);
    exit;
}

session_name(SESSION_COOKIE_NAME);
session_set_cookie_params([
    'lifetime' => 0, 'path' => '/', 'domain' => '',
    'secure'   => FORCE_HTTPS, 'httponly' => true, 'samesite' => 'Strict',
]);
session_start();

// 1. Authentification
if (empty($_SESSION['user_id'])) {
    header('Location: login_form.php');
    exit;
}

// 2. Expiration de session
if (!empty($_SESSION['last_activity'])
    && (time() - $_SESSION['last_activity']) > SESSION_TIMEOUT) {
    session_unset();
    session_destroy();
    header('Location: login_form.php?expired=1');
    exit;
}

// 3. Liaison IP + User-Agent (détection de vol de cookie)
$currentIp = $_SERVER['REMOTE_ADDR'] ?? '';
$currentUa = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
if (!empty($_SESSION['ip']) && $_SESSION['ip'] !== $currentIp) {
    // IP différente : soit VPN, soit vol de session. On déconnecte par sécurité.
    session_unset();
    session_destroy();
    header('Location: login_form.php?expired=1');
    exit;
}
if (!empty($_SESSION['ua']) && $_SESSION['ua'] !== $currentUa) {
    session_unset();
    session_destroy();
    header('Location: login_form.php?expired=1');
    exit;
}

// 4. Refresh du timer
$_SESSION['last_activity'] = time();

function h(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
</head>
<body>
    <h1>📊 Tableau de bord</h1>
    <p>Connecté en tant que <strong><?= h($_SESSION['username']) ?></strong>.</p>
    <p>User ID : <?= (int)$_SESSION['user_id'] ?></p>

    <form action="logout.php" method="POST" style="display:inline;">
        <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
        <button type="submit">Se déconnecter</button>
    </form>
</body>
</html>
