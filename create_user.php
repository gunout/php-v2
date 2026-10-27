<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

// Protection : exécution CLI uniquement
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    die("Script CLI uniquement.");
}

if ($argc !== 3) {
    fwrite(STDERR, "Usage: php create_user.php <username> <password>\n");
    exit(1);
}

[, $username, $password] = $argv;

if (!preg_match('/^[a-zA-Z0-9_.\-]{1,100}$/', $username)) {
    fwrite(STDERR, "Username invalide.\n");
    exit(1);
}
if (strlen($password) < 12) {
    fwrite(STDERR, "Mot de passe trop court (min 12 caractères).\n");
    exit(1);
}

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        "INSERT INTO users (username, password_hash) VALUES (:u, :h)"
    );
    $stmt->execute([':u' => $username, ':h' => $hash]);

    echo "✅ Utilisateur '$username' créé (id=" . $pdo->lastInsertId() . ").\n";
    echo "   Hash : " . substr($hash, 0, 30) . "...\n";
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        fwrite(STDERR, "❌ Ce username existe déjà.\n");
    } else {
        fwrite(STDERR, "❌ Erreur BDD : " . $e->getMessage() . "\n");
    }
    exit(1);
}
