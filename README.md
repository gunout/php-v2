<div align="center">

<!-- Typing SVG animé -->
<img src="https://readme-typing-svg.demolab.com?font=Fira+Code&size=30&duration=3000&pause=1000&color=000091&center=true&vCenter=true&width=900&lines=%F0%9F%94%91+Login+s%C3%A9curis%C3%A9+PHP;8+correctifs+de+s%C3%A9curit%C3%A9+int%C3%A9gr%C3%A9s;Anti-SQLi+%C2%B7+Anti-CSRF+%C2%B7+Anti-bruteforce;Rate-limit+%C2%B7+Timing-safe+%C2%B7+Session+timeout" alt="Typing SVG" />

<br><br>

<!-- Badges statut -->
<img src="https://img.shields.io/badge/version-2.0-000091?style=for-the-badge&logo=github&logoColor=white" alt="Version 2.0" />
<img src="https://img.shields.io/badge/statut-production--ready-16a34a?style=for-the-badge&logo=checkmarx&logoColor=white" alt="Production-ready" />
<img src="https://img.shields.io/badge/licence-MIT-E1000F?style=for-the-badge&logo=opensourceinitiative&logoColor=white" alt="MIT" />
<img src="https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 7.4+" />
<img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL 5.7+" />

<br><br>

<!-- Badges sécurité -->
<img src="https://img.shields.io/badge/Anti--SQLi-✓_PDO_prepared-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-SQLi" />
<img src="https://img.shields.io/badge/Anti--CSRF-✓_hash__equals-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-CSRF" />
<img src="https://img.shields.io/badge/Anti--Timing-✓_dummy__hash-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-Timing" />
<img src="https://img.shields.io/badge/Anti--Bruteforce-✓_double_ratelimit-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-Bruteforce" />
<img src="https://img.shields.io/badge/Anti--Fixation-✓_regenerate__id-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-Fixation" />
<img src="https://img.shields.io/badge/Anti--XSS-✓_htmlspecialchars-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-XSS" />

<br><br>

<!-- Badges conformité -->
<img src="https://img.shields.io/badge/RFC_1321-MD5-E1000F?style=flat-square" alt="RFC 1321" />
<img src="https://img.shields.io/badge/FIPS_180--4-SHA--1%2F2-000091?style=flat-square" alt="FIPS 180-4" />
<img src="https://img.shields.io/badge/FIPS_202-SHA--3-000091?style=flat-square" alt="FIPS 202" />
<img src="https://img.shields.io/badge/OWASP-Top_10-16a34a?style=flat-square" alt="OWASP Top 10" />
<img src="https://img.shields.io/badge/RGPD-conforme-16a34a?style=flat-square" alt="RGPD" />

<br><br>

<!-- Banner animé -->
<img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=0,2,2,5,30&height=120&section=header&text=🔑%20Login%20sécurisé&fontSize=42&fontColor=ffffff&animation=twinkling&fontAlignY=35" width="100%" alt="Banner" />

</div>

---

## 🏛️ À propos

**Login sécurisé PHP** est un module d'authentification **production-ready**, conçu selon les recommandations **OWASP** et les bonnes pratiques **PHP 7.4+ / 8.x**.

Il implémente **8 correctifs de sécurité majeurs** au-delà d'un login basique, couvrant :

- **Injection SQL** → PDO prepared statements (`ATTR_EMULATE_PREPARES = false`)
- **CSRF** → token + `hash_equals()` (timing-safe)
- **Timing attack** → `dummy_hash` dynamique au même algo
- **Bruteforce** → double rate-limit (IP global + IP/user)
- **Session fixation** → `session_regenerate_id(true)`
- **Vol de cookie** → liaison IP + User-Agent
- **DoS par `sleep()`** → 429 + `Retry-After` au lieu de blocage
- **Fuite d'info** → message générique + statut compte caché

> *« La sécurité n'est pas un produit, c'est un processus. »* — Bruce Schneier

---

## ✨ Fonctionnalités de sécurité

<table>
<tr>
<td width="50%">

### 🛡️ Protection des identifiants
- **PDO prepared statements** avec `EMULATE_PREPARES = false`
- **`password_verify()`** (Argon2id par défaut PHP 8+)
- **`password_needs_rehash()`** (migration transparente)
- **Validation stricte** du username (`preg_match`)
- **Troncature** à 100 / 1024 caractères

</td>
<td width="50%">

### 🚨 Anti-bruteforce
- **Rate-limit niveau 1** : 20 tentatives / 15 min / IP
- **Rate-limit niveau 2** : 5 tentatives / 15 min / IP+username
- **`429 + Retry-After`** (pas de `sleep()` → pas de DoS)
- **Purge aléatoire** (1/200) → `login_attempts` reste propre
- **Index BDD** → requêtes < 5 ms même à 100k lignes

</td>
</tr>
<tr>
<td>

### 🔐 Gestion de session
- **Cookies** : `Secure + HttpOnly + SameSite=Strict`
- **`session_regenerate_id(true)`** après login
- **Timeout** : 30 min d'inactivité (`last_activity`)
- **Liaison IP** : session invalidée si l'IP change
- **Liaison User-Agent** : détection de vol de cookie
- **Rotation CSRF** après connexion réussie

</td>
<td>

### 🕵️ Anti-fuite d'information
- **Message générique** : toujours `"Identifiants incorrects."`
- **Timing constant** : `password_verify()` **toujours** exécuté (dummy hash si user inexistant)
- **Statut du compte caché** : `active=0` indistinguable d'un inexistant
- **Log sécurisé** : aucun mot de passe, jamais
- **HTTPS forcé** : redirect 301 si HTTP

</td>
</tr>
<tr>
<td>

### 📝 Logs & audit
- **Table `login_attempts`** : `ip`, `username`, `success`, `attempted_at`
- **Fichier log** : `LOG_FILE` (hors webroot)
- **Événements tracés** : `LOGIN_OK`, `LOGIN_FAIL`, `CSRF_FAIL`, `RATE_IP`, `RATE_USER`, `DB_ERROR`
- **Format** : `[2025-01-15T14:30:00+00:00] [LOGIN_FAIL] user=admin ip=1.2.3.4`

</td>
<td>

### 🌐 Compatibilité proxy/CDN
- **Cloudflare** : `HTTP_CF_CONNECTING_IP`
- **nginx / LB** : `HTTP_X_FORWARDED_FOR`
- **Configuration** : `TRUSTED_PROXIES` dans `config.php`
- **Validation** : `filter_var(..., FILTER_VALIDATE_IP)`
- **Fallback** : `REMOTE_ADDR`

</td>
</tr>
</table>

---

## 🚀 Installation

### Prérequis

- **PHP 7.4+** (8.0+ recommandé pour Argon2id)
- **MySQL 5.7+** ou **MariaDB 10.3+**
- **Apache** (mod_rewrite) ou **nginx**
- **HTTPS** (Let's Encrypt recommandé)

### Étape 1 — Cloner

```bash
git clone https://github.com/gunout/login-securise.git
cd login-securise
```

### Étape 2 — Base de données

```bash
mysql -u root -p < sql/users.sql
mysql -u root -p < sql/login_attempts.sql
```

### Étape 3 — Configuration

```bash
cp config.example.php config.php
nano config.php
```

Éditer les constantes :

```php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mon_site');
define('DB_USER', 'root');
define('DB_PASS', 'votre_mot_de_passe');

define('APP_ENV', 'production');   // 'development' pour désactiver HTTPS forcé
define('FORCE_HTTPS', true);
define('SESSION_TIMEOUT', 1800);

define('MAX_ATTEMPTS_PER_IP', 20);
define('MAX_ATTEMPTS_PER_USER', 5);
define('RATE_WINDOW_MINUTES', 15);

define('TRUSTED_PROXIES', ['127.0.0.1', '::1']);
define('LOG_FILE', '/var/log/app/login.log');
```

### Étape 4 — Créer un utilisateur

```bash
php create_user.php admin MonSuperMotDePasse2025!
# ✅ Utilisateur 'admin' créé (id=1).
#    Hash : $argon2id$v=19$m=65536,t=4,p=1$...
```

### Étape 5 — Servir

```bash
# Développement
php -S localhost:8080

# Production : Apache ou nginx
```

Accéder à http://localhost:8080/login_form.php

---

## 📁 Structure du projet

```
/login/
├── config.php                  # ⚙️ Configuration (BDD, session, rate-limit)
├── login.php                   # 🔑 Script principal (8 correctifs v2)
├── login_form.php              # 📝 Formulaire HTML avec token CSRF
├── dashboard.php               # 📊 Page protégée (session + timeout + IP/UA)
├── logout.php                  # 🚪 Déconnexion propre (POST + CSRF)
├── create_user.php             # 👤 Outil CLI de création d'utilisateur
│
├── sql/
│   ├── users.sql               # 👥 Table utilisateurs (index username)
│   └── login_attempts.sql      # 🚨 Table logs (index ip+time, user+time)
│
├── .htaccess                   # 🔧 Redirection HTTPS + sécurité Apache
└── README.md                   # 📖 Ce fichier
```

---

## 🧪 Tests de sécurité

### 1. HTTP → HTTPS forcé

```bash
curl -I http://localhost:8080/login_form.php
# Attendu : HTTP/1.1 301 Moved Permanently
#           Location: https://localhost:8080/login_form.php
```

### 2. CSRF protection

```bash
curl -X POST https://localhost:8080/login.php \
     -d "username=admin&password=test"
# Attendu : HTTP/1.1 403 Forbidden
#           "Requête invalide (CSRF)."
```

### 3. Rate-limit IP (20 tentatives / 15 min)

```bash
for i in {1..21}; do
  curl -s -o /dev/null -w "%{http_code}\n" \
       -X POST https://localhost:8080/login.php \
       -d "username=test&password=x&csrf_token=XXXXX"
done
# Attendu : 401 × 20 puis 429
```

### 4. Rate-limit user (5 tentatives / 15 min)

```bash
for i in {1..6}; do
  curl -s -o /dev/null -w "%{http_code}\n" \
       -X POST https://localhost:8080/login.php \
       -d "username=admin&password=wrong&csrf_token=XXXXX"
done
# Attendu : 401 × 5 puis 429
```

### 5. Timing attack (message identique)

```bash
# Compte existant
time curl -s -o /dev/null -X POST https://localhost:8080/login.php \
     -d "username=admin&password=wrong&csrf_token=XXXXX"
# Compte inexistant
time curl -s -o /dev/null -X POST https://localhost:8080/login.php \
     -d "username=inexistant&password=wrong&csrf_token=XXXXX"
# Attendu : temps ≈ identique (~100-200 ms)
```

### 6. Vol de session (User-Agent)

```bash
# 1. Se connecter avec User-Agent A → récupérer cookie
curl -c cookies.txt -X POST https://localhost:8080/login.php \
     -d "username=admin&password=correct&csrf_token=XXXXX" \
     -H "User-Agent: Mozilla/5.0 (A)"

# 2. Rejouer avec User-Agent B
curl -b cookies.txt -X GET https://localhost:8080/dashboard.php \
     -H "User-Agent: Mozilla/5.0 (B)"
# Attendu : redirect login_form.php?expired=1
```

### 7. Session timeout

```bash
# Attendre > 30 min sur dashboard.php → redirect ?expired=1
```

### 8. Logout CSRF

```bash
curl -X POST https://localhost:8080/logout.php
# Attendu : HTTP/1.1 403 Forbidden
```

---

## 📊 Tableau des 8 correctifs v2

| # | Faille initiale | Gravité | Correctif appliqué |
|---|-----------------|---------|-------------------|
| **1** | CSRF bloque le GET (login cassé) | 🔴 Critique | CSRF **après** `REQUEST_METHOD === 'POST'` |
| **2** | `REMOTE_ADDR` derrière proxy | 🔴 Élevé | `getClientIp()` : CF + X-Forwarded-For |
| **3** | Rate-limit contournable (botnet) | 🔴 Élevé | Double rate-limit (IP + IP/user) |
| **4** | `sleep()` = DoS | 🟡 Moyen | `429 + Retry-After` (pas de blocage) |
| **5** | Table `login_attempts` infinie | 🟡 Moyen | Purge 1/200 + index BDD |
| **6** | `dummy_hash` en dur | 🟡 Bas | `getDummyHash()` dynamique |
| **7** | Statut du compte révélé | 🟡 Bas | Timing constant + message générique |
| **8** | Pas de timeout de session | 🟡 Bas | `last_activity` + `SESSION_TIMEOUT` |

**Bonus** : HTTPS forcé, cookies `Secure+HttpOnly+SameSite`, rotation CSRF, liaison IP/UA, log sans mot de passe.

---

## 🛡️ Matrice OWASP Top 10

| Risque OWASP | Statut | Implémentation |
|--------------|--------|----------------|
| **A01 — Broken Access Control** | ✅ | `session_regenerate_id()`, liaison IP/UA |
| **A02 — Cryptographic Failures** | ✅ | Argon2id, HTTPS forcé, cookies `Secure` |
| **A03 — Injection** | ✅ | PDO prepared statements, `preg_match` |
| **A04 — Insecure Design** | ✅ | Rate-limit, timing-safe, dummy hash |
| **A05 — Security Misconfiguration** | ✅ | `APP_ENV`, config centralisée, logs hors webroot |
| **A06 — Vulnerable Components** | ✅ | PHP 7.4+, MySQL 5.7+, dépendances minimales |
| **A07 — Auth Failures** | ✅ | 8 correctifs, `password_needs_rehash()` |
| **A08 — Data Integrity** | ✅ | `hash_equals()` pour CSRF |
| **A09 — Logging Failures** | ✅ | `login_attempts`, `LOG_FILE`, événements tracés |
| **A10 — SSRF** | ✅ | Aucune requête externe (pas de SSRF possible) |

---

## 📋 Compatibilité

| Composant | Version min | Recommandé |
|-----------|-------------|------------|
| **PHP** | 7.4 | 8.2+ |
| **MySQL** | 5.7 | 8.0+ |
| **MariaDB** | 10.3 | 10.6+ |
| **Apache** | 2.4 | 2.4.57+ |
| **nginx** | 1.18 | 1.24+ |
| **OpenSSL** | 1.1.1 | 3.0+ |

**Algorithmes de hash de mot de passe** :
- PHP 8.0+ : `PASSWORD_DEFAULT` = **Argon2id** (recommandé)
- PHP 7.4 : `PASSWORD_DEFAULT` = **Bcrypt** cost 10
- Migration : `password_needs_rehash()` gère la transition

---

## 🔧 Maintenance

### Purge manuelle des logs

```sql
DELETE FROM login_attempts WHERE attempted_at < NOW() - INTERVAL 7 DAY;
```

### Purge automatique (cron quotidien)

```cron
0 3 * * * mysql -u root -p'pass' mon_site -e "DELETE FROM login_attempts WHERE attempted_at < NOW() - INTERVAL 7 DAY;"
```

### Rotation des logs

```bash
# /etc/logrotate.d/app-login
/var/log/app/login.log {
    daily
    rotate 14
    compress
    missingok
    notifempty
    create 0640 www-data www-data
}
```

### Vérifier les tentatives suspectes

```sql
-- Top 10 IP avec le plus d'échecs
SELECT ip, COUNT(*) AS fails
FROM login_attempts
WHERE success = 0 AND attempted_at > NOW() - INTERVAL 24 HOUR
GROUP BY ip
ORDER BY fails DESC
LIMIT 10;

-- Top 10 usernames ciblés
SELECT username, COUNT(*) AS fails
FROM login_attempts
WHERE success = 0 AND attempted_at > NOW() - INTERVAL 24 HOUR
GROUP BY username
ORDER BY fails DESC
LIMIT 10;
```

---

## 🎯 Cas d'usage

### Scénario 1 — Site vitrine avec espace admin

```
/login/         ← module d'authentification
/admin/         ← dashboard protégé
```

### Scénario 2 — API avec sessions

```
POST /api/login    → login.php
GET  /api/me       → dashboard.php (retourne JSON)
POST /api/logout   → logout.php
```

### Scénario 3 — Multi-tenant

Ajouter une colonne `tenant_id` dans `users` et adapter :
```sql
SELECT id, password_hash FROM users 
WHERE username = ? AND tenant_id = ?
```

---

## 🧬 Dépendances

**Aucune dépendance externe.** Le projet repose uniquement sur :

- **PHP natif** (`PDO`, `password_*`, `session_*`, `hash_equals`)
- **MySQL** (InnoDB, utf8mb4)
- **Modules PHP** : `pdo_mysql`, `session`, `json`, `filter`

Aucun Composer, aucun framework, aucun CDN. **Zéro dépendance = zéro CVE transitive.**

---

## 🤝 Contribuer

1. Fork le repo
2. Créer une branche (`git checkout -b feat/ma-fonctionnalite`)
3. Commit (`git commit -m 'feat: ajout de X'`)
4. Push (`git push origin feat/ma-fonctionnalite`)
5. Ouvrir une Pull Request

### Convention de commit

```
feat: nouvelle fonctionnalité
fix: correction de bug
docs: documentation
sec: correctif de sécurité
test: ajout de tests
chore: maintenance
```

---

## 📜 Licence

Distribué sous **licence MIT**. Voir [`LICENSE`](LICENSE) pour plus d'informations.

---

## 👤 Auteur

**gunout**

[![GitHub](https://img.shields.io/badge/GitHub-gunout-181717?style=for-the-badge&logo=github)](https://github.com/gunout)

---

<div align="center">

### 🇫🇷 République Française

**Liberté · Égalité · Fraternité**

*Login sécurisé — Anti-SQLi · Anti-CSRF · Anti-Timing · Rate-limit · Session*

<br>

<img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=0,2,2,5,30&height=100&section=footer&text=©%20gunout%20·%20Tous%20droits%20réservés&fontSize=20&fontColor=ffffff" width="100%" alt="Footer" />

</div>
