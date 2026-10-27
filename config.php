<?php
declare(strict_types=1);

// ============================================
// Configuration centrale
// ============================================

// --- Base de données ---
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mon_site');
define('DB_USER', 'root');
define('DB_PASS', '');

// --- Environnement ---
define('APP_ENV', 'production'); // 'production' | 'development'

// --- Session ---
define('SESSION_TIMEOUT', 1800);        // 30 min d'inactivité
define('SESSION_COOKIE_NAME', 'APP_SESSID');

// --- Rate limiting ---
define('MAX_ATTEMPTS_PER_IP', 20);       // /15 min, toutes cibles
define('MAX_ATTEMPTS_PER_USER', 5);      // /15 min, par username
define('RATE_WINDOW_MINUTES', 15);

// --- HTTPS forcé ---
define('FORCE_HTTPS', APP_ENV === 'production');

// --- Proxy de confiance (à adapter) ---
define('TRUSTED_PROXIES', ['127.0.0.1', '::1']);

// --- Dummy hash pour timing attack ---
// Généré dynamiquement au premier accès, puis mis en cache.
// Si tu as un vrai hash existant, tu peux le mettre ici en dur.
// Exemple : password_hash('dummy', PASSWORD_DEFAULT)

// --- Fichier de log (hors webroot !) ---
define('LOG_FILE', '/var/log/app/login.log');
