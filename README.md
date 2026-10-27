<div align="center">

<!-- Typing SVG rose fluo -->
<img src="https://readme-typing-svg.demolab.com?font=Fira+Code&weight=700&size=28&duration=3000&pause=1000&color=FF10F0&center=true&vCenter=true&width=900&lines=%F0%9F%94%91+Login+s%C3%A9curis%C3%A9+PHP;8+correctifs+OWASP+int%C3%A9gr%C3%A9s" alt="Typing SVG - Rose fluo" />
<br>
<img src="https://readme-typing-svg.demolab.com?font=Fira+Code&size=20&duration=3000&pause=1000&color=FF69B4&center=true&vCenter=true&width=900&lines=Anti-SQLi+%C2%B7+Anti-CSRF+%C2%B7+Anti-bruteforce;Rate-limit+%C2%B7+Timing-safe+%C2%B7+Session+timeout" alt="Typing SVG - Rose bonbon" />

<br><br>

<!-- Badges principaux -->
<img src="https://img.shields.io/badge/version-2.0-FF10F0?style=for-the-badge&logo=github&logoColor=white" alt="Version 2.0" />
<img src="https://img.shields.io/badge/statut-production--ready-16a34a?style=for-the-badge&logo=checkmarx&logoColor=white" alt="Production-ready" />
<img src="https://img.shields.io/badge/licence-MIT-E1000F?style=for-the-badge&logo=opensourceinitiative&logoColor=white" alt="MIT" />
<img src="https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 7.4+" />
<img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL 5.7+" />

<br><br>

<!-- Badges sécurité -->
<img src="https://img.shields.io/badge/Anti--SQLi-✓_PDO-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-SQLi" />
<img src="https://img.shields.io/badge/Anti--CSRF-✓_hash__equals-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-CSRF" />
<img src="https://img.shields.io/badge/Anti--Timing-✓_dummy__hash-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-Timing" />
<img src="https://img.shields.io/badge/Anti--Bruteforce-✓_ratelimit-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-Bruteforce" />
<img src="https://img.shields.io/badge/Anti--Fixation-✓_regenerate-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-Fixation" />
<img src="https://img.shields.io/badge/Anti--XSS-✓_h()__escape-16a34a?style=flat-square&logo=shield&logoColor=white" alt="Anti-XSS" />

<br><br>

<!-- Conformité -->
<img src="https://img.shields.io/badge/OWASP-Top_10-16a34a?style=flat-square" alt="OWASP Top 10" />
<img src="https://img.shields.io/badge/RGPD-conforme-16a34a?style=flat-square" alt="RGPD" />
<img src="https://img.shields.io/badge/Zéro_dépendance-0_CVE-FF10F0?style=flat-square&logo=checkmarx&logoColor=white" alt="Zéro dépendance" />

<br><br>

<!-- Bannière rose fluo -->
<img src="https://capsule-render.vercel.app/api?type=waving&color=FF10F0&height=120&section=header&text=🔑%20php-v2&fontSize=42&fontColor=ffffff&animation=twinkling&fontAlignY=35" width="100%" alt="Banner" />

</div>

---

## ⚡whoami

Un module d'authentification **PHP + MySQL** qui ne fait pas semblant.

- 🛡️ **8 correctifs OWASP** intégrés au-delà d'un login basique
- 🎯 **Production-ready** — pas de dépendance externe, pas de framework
- 🧪 **8 tests de sécurité** fournis (curl, SQL, time)
- 🇫🇷 **Conçu avec rigueur** — pour projets réels, pas pour démo
- 🚀 **Rapide à déployer** — 5 étapes, 3 minutes

Ce module est mon premier projet **PHP** dans l'écosystème `gunout`, après un focus Python / Web / Data. Il complète ma boîte à outils : quand un site vitrine a besoin d'un vrai login, je sors `php-v2`.

> *« La sécurité n'est pas un produit, c'est un processus. »* — Bruce Schneier

---

## 🛠️tech_stack

<div align="center">

<img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
<img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
<img src="https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white" alt="Apache" />
<img src="https://img.shields.io/badge/nginx-009639?style=for-the-badge&logo=nginx&logoColor=white" alt="nginx" />
<img src="https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white" alt="Git" />

<br>

<img src="https://img.shields.io/badge/Argon2id-✓_PHP_8+-16a34a?style=flat-square" alt="Argon2id" />
<img src="https://img.shields.io/badge/Bcrypt-fallback-000091?style=flat-square" alt="Bcrypt" />
<img src="https://img.shields.io/badge/PDO-prepared_statements-16a34a?style=flat-square" alt="PDO" />
<img src="https://img.shields.io/badge/CSRF-hash__equals-16a34a?style=flat-square" alt="CSRF" />

</div>

---

## ✨ Fonctionnalités de sécurité

<table>
<tr>
<td width="50%">

### 🛡️ Protection des identifiants
- **PDO prepared statements** (`EMULATE_PREPARES = false`)
- **`password_verify()`** (Argon2id PHP 8+)
- **`password_needs_rehash()`** (migration auto)
- **`preg_match`** strict sur username
- **Troncature** 100 / 1024 caractères

### 🚨 Anti-bruteforce
- **Rate-limit 1** : 20 tentatives / 15 min / IP
- **Rate-limit 2** : 5 tentatives / 15 min / IP+user
- **`429 + Retry-After`** (pas de `sleep()`)
- **Purge** 1/200 (`login_attempts` propre)
- **Index BDD** → requêtes < 5 ms

</td>
<td>

### 🔐 Gestion de session
- **Cookies** : `Secure + HttpOnly + SameSite=Strict`
- **`session_regenerate_id(true)`** après login
- **Timeout** : 30 min d'inactivité
- **Liaison IP** : invalide si IP change
- **Liaison User-Agent** : détection vol cookie
- **Rotation CSRF** après succès

### 🕵️ Anti-fuite d'information
- **Message générique** : `"Identifiants incorrects."`
- **Timing constant** : `password_verify()` toujours
- **Statut caché** : `active=0` = inexistant
- **Log sans mot de passe**, jamais
- **HTTPS forcé** (redirect 301)

</td>
</tr>
</table>

---

## 🚀 Installation

### 5 étapes, 3 minutes

```bash
# 1. Cloner
git clone https://github.com/gunout/php-v2.git
cd php-v2

# 2. Base de données
mysql -u root -p < sql/users.sql
mysql -u root -p < sql/login_attempts.sql

# 3. Configuration
cp config.example.php config.php
nano config.php   # DB_HOST, DB_NAME, DB_USER, DB_PASS

# 4. Créer un utilisateur
php create_user.php admin MonSuperMotDePasse2025!

# 5. Servir
php -S localhost:8080
# → http://localhost:8080/login_form.php
```

**Prérequis** : PHP 7.4+ · MySQL 5.7+ · Apache/nginx · HTTPS (Let's Encrypt)

---

## 📁 Structure du projet

```
/php-v2/
├── config.php                  # ⚙️ Configuration (BDD, session, rate-limit)
├── login.php                   # 🔑 Script principal (8 correctifs)
├── login_form.php              # 📝 Formulaire HTML avec token CSRF
├── dashboard.php               # 📊 Page protégée (session + IP/UA)
├── logout.php                  # 🚪 Déconnexion propre (POST + CSRF)
├── create_user.php             # 👤 Outil CLI de création
│
├── sql/
│   ├── users.sql               # 👥 Table utilisateurs
│   └── login_attempts.sql      # 🚨 Table logs + index
│
├── .htaccess                   # 🔧 Redirection HTTPS + sécurité
└── README.md                   # 📖 Ce fichier
```

---

## 🧪 Tests de sécurité

### 1. HTTPS forcé

```bash
curl -I http://localhost:8080/login_form.php
# Attendu : 301 → Location: https://...
```

### 2. CSRF protection

```bash
curl -X POST https://localhost:8080/login.php -d "username=admin&password=test"
# Attendu : 403 → "Requête invalide (CSRF)."
```

### 3. Rate-limit IP (21 requêtes)

```bash
for i in {1..21}; do
  curl -s -o /dev/null -w "%{http_code}\n" \
       -X POST https://localhost:8080/login.php \
       -d "username=test&password=x&csrf_token=XXXXX"
done
# Attendu : 401 × 20 puis 429
```

### 4. Timing attack (messages identiques)

```bash
time curl -s -o /dev/null -X POST https://localhost:8080/login.php \
     -d "username=admin&password=wrong&csrf_token=XXXXX"
time curl -s -o /dev/null -X POST https://localhost:8080/login.php \
     -d "username=inexistant&password=wrong&csrf_token=XXXXX"
# Attendu : temps ≈ identique (~100-200 ms)
```

Voir le README complet pour les **8 tests détaillés**.

---

## 📊 Tableau des 8 correctifs v2

| # | Faille initiale | Gravité | Correctif |
|---|-----------------|---------|-----------|
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
| **A03 — Injection** | ✅ | PDO prepared, `preg_match` |
| **A04 — Insecure Design** | ✅ | Rate-limit, timing-safe, dummy hash |
| **A05 — Security Misconfiguration** | ✅ | `APP_ENV`, config centralisée, logs hors webroot |
| **A06 — Vulnerable Components** | ✅ | PHP 7.4+, MySQL 5.7+, zéro dépendance |
| **A07 — Auth Failures** | ✅ | 8 correctifs, `password_needs_rehash()` |
| **A08 — Data Integrity** | ✅ | `hash_equals()` pour CSRF |
| **A09 — Logging Failures** | ✅ | `login_attempts`, `LOG_FILE`, événements tracés |
| **A10 — SSRF** | ✅ | Aucune requête externe |

---

## 📋 Compatibilité

| Composant | Version min | Recommandé |
|-----------|-------------|------------|
| **PHP** | 7.4 | 8.2+ |
| **MySQL** | 5.7 | 8.0+ |
| **MariaDB** | 10.3 | 10.6+ |
| **Apache** | 2.4 | 2.4.57+ |
| **nginx** | 1.18 | 1.24+ |

**Algorithme de hash** :
- PHP 8.0+ : `PASSWORD_DEFAULT` = **Argon2id** ✅
- PHP 7.4 : `PASSWORD_DEFAULT` = **Bcrypt** cost 10

---

## 🔧 Maintenance

### Purge des logs

```sql
DELETE FROM login_attempts WHERE attempted_at < NOW() - INTERVAL 7 DAY;
```

### Cron quotidien

```cron
0 3 * * * mysql -u root -p'pass' mon_site -e "DELETE FROM login_attempts WHERE attempted_at < NOW() - INTERVAL 7 DAY;"
```

### Top IP suspectes

```sql
SELECT ip, COUNT(*) AS fails
FROM login_attempts
WHERE success = 0 AND attempted_at > NOW() - INTERVAL 24 HOUR
GROUP BY ip ORDER BY fails DESC LIMIT 10;
```

---

## 🎯 Cas d'usage

### Scénario 1 — Site vitrine avec espace admin

```
/login/     ← module d'authentification
/admin/     ← dashboard protégé
```

### Scénario 2 — API avec sessions

```
POST /api/login    → login.php
GET  /api/me       → dashboard.php (JSON)
POST /api/logout   → logout.php
```

### Scénario 3 — Multi-tenant

Ajouter `tenant_id` dans `users` et adapter :
```sql
SELECT id, password_hash FROM users WHERE username = ? AND tenant_id = ?
```

---

## 🧬 Dépendances

**Aucune dépendance externe.** Uniquement :

- **PHP natif** (`PDO`, `password_*`, `session_*`, `hash_equals`)
- **MySQL** (InnoDB, utf8mb4)
- **Modules PHP** : `pdo_mysql`, `session`, `json`, `filter`

Aucun Composer, aucun framework, aucun CDN. **Zéro dépendance = zéro CVE transitive.**

---

## 🤝 Contribuer

1. Fork le repo
2. Branche (`git checkout -b feat/ma-fonctionnalite`)
3. Commit (`git commit -m 'feat: ajout de X'`)
4. Push (`git push origin feat/ma-fonctionnalite`)
5. Pull Request

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

Distribué sous **licence MIT**. Voir [`LICENSE`](LICENSE).

---

## 👤 Auteur

**gunout**

[![GitHub](https://img.shields.io/badge/GitHub-gunout-181717?style=for-the-badge&logo=github)](https://github.com/gunout)

> Python & Automation · Web Development · Shell & Scripting · Veille & Data · Aerospace, maritime, real estate, health, public policy

---

<div align="center">

### 🇫🇷 République Française

**Liberté · Égalité · Fraternité**

*Login sécurisé — Anti-SQLi · Anti-CSRF · Anti-Timing · Rate-limit · Session*

<br>

<img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=0,2,2,5,30&height=100&section=footer&text=©%20gunout%20·%20Tous%20droits%20réservés&fontSize=20&fontColor=ffffff" width="100%" alt="Footer" />

</div>
