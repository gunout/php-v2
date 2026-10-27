<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

session_name(SESSION_COOKIE_NAME);
session_set_cookie_params([
    'lifetime' => 0, 'path' => '/', 'domain' => '',
    'secure'   => FORCE_HTTPS, 'httponly' => true, 'samesite' => 'Strict',
]);
session_start();

// POST obligatoire + CSRF (empêche le logout CSRF)
if ($_SERVER['REQUEST_METHOD'] !== 'POST'
    || empty($_POST['csrf_token'])
    || !is_string($_POST['csrf_token'])
    || empty($_SESSION['csrf_token'])
    || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    die("Requête invalide.");
}

// Destruction complète
$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        [
            'expires'  => time() - 42000,
            'path'     => $params['path'],
            'domain'   => $params['domain'],
            'secure'   => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'] ?? 'Strict',
        ]
    );
}

session_destroy();

header('Location: login_form.php');
exit;
