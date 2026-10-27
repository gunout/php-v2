<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

// ============================================
// 0. HTTPS FORCÉ (avant tout, avant session)
// ============================================
if (FORCE_HTTPS && (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off')) {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $uri  = $_SERVER['REQUEST_URI'] ?? '/';
    // Sécurité : valider $host pour éviter open redirect
    if (preg_match('/^[a-z0-9.\-]+(:\d+)?$/i', $host)) {
        header('Location: https://' . $host . $uri, true, 301);
        exit;
    }
    http_response_code(400);
    die("Requête invalide (HTTPS).");
}

// ============================================
// 1. SESSION SÉCURISÉE
// ============================================
session_name(SESSION_COOKIE_NAME);
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => FORCE_HTTPS,
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_start();

// ============================================
// 2. UTILITAIRES
// ============================================

/**
 * IP réelle, derrière proxy de confiance.
 */
function getClientIp(): string {
    $remote = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    // Si on fait confiance au proxy qui nous parle
    if (in_array($remote, TRUSTED_PROXIES, true)) {
        // Cloudflare
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP);
            if ($ip !== false) return $ip;
        }
        // X-Forwarded-For (1ère IP = la plus proche du client)
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = array_map('trim', explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
            foreach ($ips as $ip) {
                $valid = filter_var($ip, FILTER_VALIDATE_IP);
                if ($valid !== false) return $valid;
            }
        }
    }
    return $remote;
}

/**
 * Échappement HTML (XSS).
 */
function h(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Log sécurisé (jamais de mot de passe).
 */
function secureLog(string $msg): void {
    $line = sprintf("[%s] %s\n", date('c'), $msg);
    if (@is_writable(LOG_FILE)) {
        @file_put_contents(LOG_FILE, $line, FILE_APPEND | LOCK_EX);
    }
    // Fallback : error_log
    @error_log($line);
}

/**
 * Dummy hash (généré dynamiquement, mis en cache session).
 * Utilisé pour le timing attack : on fait TOUJOURS un password_verify,
 * même si le username est inconnu.
 */
function getDummyHash(): string {
    if (!empty($_SESSION['_dummy_hash']) && is_string($_SESSION['_dummy_hash'])) {
        return $_SESSION['_dummy_hash'];
    }
    // PASSWORD_DEFAULT = Argon2id (PHP 7.4+) ou Bcrypt (PHP < 7.4)
    $hash = password_hash('dummy_' . bin2hex(random_bytes(8)), PASSWORD_DEFAULT);
    $_SESSION['_dummy_hash'] = $hash;
    return $hash;
}

// ============================================
// 3. CONNEXION BDD
// ============================================
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    secureLog('[DB_ERROR] ' . $e->getMessage());
    http_response_code(500);
    die("Erreur serveur.");
}

// ============================================
// 4. VALIDATION MÉTHODE (AVANT CSRF)
// ============================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    die("Méthode non autorisée.");
}

// ============================================
// 5. CSRF (token en session, champ POST)
// ============================================
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if (!isset($_POST['csrf_token'])
    || !is_string($_POST['csrf_token'])
    || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    secureLog('[CSRF_FAIL] ip=' . getClientIp());
    http_response_code(403);
    die("Requête invalide (CSRF).");
}

// ============================================
// 6. VALIDATION INPUT
// ============================================
if (!isset($_POST['username'], $_POST['password'])
    || !is_string($_POST['username'])
    || !is_string($_POST['password'])
) {
    http_response_code(400);
    die("Requête invalide.");
}

$username = trim($_POST['username']);
$password = $_POST['password'];

// Contrôles de taille
if ($username === '' || strlen($username) > 100
    || $password === '' || strlen($password) > 1024
) {
    http_response_code(400);
    die("Identifiants incorrects.");
}

// Validation du format username (adapter à ta politique)
if (!preg_match('/^[a-zA-Z0-9_.\-]{1,100}$/', $username)) {
    // On ne révèle pas la politique, on renvoie le message générique
    http_response_code(401);
    die("Identifiants incorrects.");
}

// ============================================
// 7. RATE LIMITING
// ============================================
$ip = getClientIp();

// 7a. Niveau 1 : global par IP (anti-botnet)
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM login_attempts
     WHERE ip = :ip
       AND attempted_at > NOW() - INTERVAL :w MINUTE"
);
$stmt->execute([':ip' => $ip, ':w' => RATE_WINDOW_MINUTES]);
if ((int)$stmt->fetchColumn() >= MAX_ATTEMPTS_PER_IP) {
    secureLog("[RATE_IP] ip=$ip");
    http_response_code(429);
    header('Retry-After: ' . (RATE_WINDOW_MINUTES * 60));
    die("Trop de tentatives depuis cette adresse. Réessayez plus tard.");
}

// 7b. Niveau 2 : par couple IP + username (anti-ciblage)
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM login_attempts
     WHERE ip = :ip
       AND username = :u
       AND success = 0
       AND attempted_at > NOW() - INTERVAL :w MINUTE"
);
$stmt->execute([':ip' => $ip, ':u' => $username, ':w' => RATE_WINDOW_MINUTES]);
if ((int)$stmt->fetchColumn() >= MAX_ATTEMPTS_PER_USER) {
    secureLog("[RATE_USER] ip=$ip user=$username");
    http_response_code(429);
    header('Retry-After: ' . (RATE_WINDOW_MINUTES * 60));
    die("Trop de tentatives sur ce compte. Réessayez plus tard.");
}

// 7c. Purge aléatoire (1 chance sur 200)
if (random_int(1, 200) === 1) {
    $pdo->exec("DELETE FROM login_attempts WHERE attempted_at < NOW() - INTERVAL 7 DAY");
}

// ============================================
// 8. RÉCUPÉRATION UTILISATEUR
// ============================================
$stmt = $pdo->prepare(
    "SELECT id, username, password_hash, active
     FROM users
     WHERE username = :u
     LIMIT 1"
);
$stmt->execute([':u' => $username]);
$row = $stmt->fetch();

// ============================================
// 9. VÉRIFICATION (timing-safe + statut caché)
// ============================================
$user = null;
$ok   = false;

if ($row) {
    if (password_verify($password, $row['password_hash'])) {
        if (!empty($row['active'])) {
            $user = $row;
            $ok   = true;
        }
    }
} else {
    // Timing constant : on vérifie un dummy si le user n'existe pas
    password_verify($password, getDummyHash());
}

// ============================================
// 10. LOG EN BASE
// ============================================
$logStmt = $pdo->prepare(
    "INSERT INTO login_attempts (ip, username, success) VALUES (:ip, :u, :s)"
);
$logStmt->execute([
    ':ip' => $ip,
    ':u'  => substr($username, 0, 100),
    ':s'  => $ok ? 1 : 0,
]);

// ============================================
// 11. SUCCÈS
// ============================================
if ($ok && $user) {
    // Anti session fixation
    session_regenerate_id(true);

    // Reset des données
    $_SESSION['user_id']       = (int)$user['id'];
    $_SESSION['username']      = $user['username'];
    $_SESSION['last_activity'] = time();
    $_SESSION['ip']            = $ip;
    $_SESSION['ua']            = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
    $_SESSION['csrf_token']    = bin2hex(random_bytes(32)); // rotation

    // Rehash si besoin (migration algo)
    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $upd = $pdo->prepare("UPDATE users SET password_hash = :h WHERE id = :id");
        $upd->execute([':h' => $newHash, ':id' => (int)$user['id']]);
    }

    secureLog("[LOGIN_OK] user={$user['username']} ip=$ip");
    header('Location: dashboard.php');
    exit;
}

// ============================================
// 12. ÉCHEC (message générique)
// ============================================
secureLog("[LOGIN_FAIL] user=" . substr($username, 0, 50) . " ip=$ip");
http_response_code(401);
echo "Identifiants incorrects.";
