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

// Générer le token CSRF si absent
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function h(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 360px; margin: 80px auto; padding: 20px; }
        label { display: block; margin: 12px 0 4px; font-weight: 600; font-size: 0.9rem; }
        input[type=text], input[type=password] {
            width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;
            font-size: 1rem; box-sizing: border-box;
        }
        button {
            margin-top: 16px; width: 100%; padding: 12px;
            background: #000091; color: #fff; border: none; border-radius: 6px;
            font-size: 1rem; font-weight: 700; cursor: pointer;
        }
        button:hover { background: #1212ff; }
        .error { background: #ffe9e9; color: #E1000F; padding: 10px; border-radius: 6px; margin-bottom: 12px; }
    </style>
</head>
<body>
    <h1>🔑 Connexion</h1>

    <?php if (isset($_GET['expired'])): ?>
        <div class="error">Session expirée. Reconnectez-vous.</div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="error">Identifiants incorrects.</div>
    <?php endif; ?>

    <form action="login.php" method="POST" autocomplete="on">
        <!-- Token CSRF -->
        <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" required
               maxlength="100" autocomplete="username" autofocus>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required
               maxlength="1024" autocomplete="current-password">

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
