<?php
// Optional: local override for secrets without committing to repo
@include __DIR__ . '/config.local.php';

// Simple base path detection for local vs production
// If running on localhost or 127.0.0.1 assume project is in /jcadenas folder
$host = $_SERVER['HTTP_HOST'] ?? '';
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

if (str_contains($host, 'localhost') || str_contains($host, '127.0.0.1')) {
    $base = '/jcadenas';
    if (!defined('SITE_BASE_URL')) {
        define('SITE_BASE_URL', $protocol . $host . $base);
    }
} else {
    // On production the project must use one canonical domain to avoid duplicate URLs
    $base = '';
    if (!defined('SITE_BASE_URL')) {
        $canonicalBase = getenv('SITE_CANONICAL_URL') ?: 'https://jcadenas.com';
        define('SITE_BASE_URL', rtrim($canonicalBase, '/'));
    }
}

// Site base URL is now defined above based on current environment

// Normalize URLs to avoid duplicates (SEO):
// - Redirect /index.php to /
// - Redirect legacy privacy URLs to /xpendz/privacidad
// - Remove trailing slash from *.php/ URLs
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    $reqUri = (string)($_SERVER['REQUEST_URI'] ?? '/');
    $path = parse_url($reqUri, PHP_URL_PATH) ?: '/';
    $qs = parse_url($reqUri, PHP_URL_QUERY);
    $query = $qs ? ('?' . $qs) : '';

    $normalizedPath = $path;

    if ($normalizedPath !== '/') {
        $normalizedPath = rtrim($normalizedPath, '/');
        if ($normalizedPath === '') {
            $normalizedPath = '/';
        }
    }

    if ($normalizedPath === '/index.php') {
        $normalizedPath = '/';
    }

    if ($normalizedPath === '/xpendz.php') {
        $normalizedPath = '/xpendz';
    }

    if ($normalizedPath === '/xpendz-funciones.php') {
        $normalizedPath = '/xpendz/funciones';
    }

    if ($normalizedPath === '/funciones.php') {
        $normalizedPath = '/xpendz/funciones';
    }

    if ($normalizedPath === '/funciones') {
        $normalizedPath = '/xpendz/funciones';
    }

    if ($normalizedPath === '/xpendz-descargar.php') {
        $normalizedPath = '/xpendz/descargar';
    }

    if ($normalizedPath === '/xpendz/descargar.php') {
        $normalizedPath = '/xpendz/descargar';
    }

    if ($normalizedPath === '/descargar.php') {
        $normalizedPath = '/xpendz/descargar';
    }

    if ($normalizedPath === '/descargar') {
        $normalizedPath = '/xpendz/descargar';
    }

    if ($normalizedPath === '/xpendz-privacidad-seguridad.php') {
        $normalizedPath = '/xpendz/privacidad-y-seguridad';
    }

    if ($normalizedPath === '/xpendz/privacidad-y-seguridad.php') {
        $normalizedPath = '/xpendz/privacidad-y-seguridad';
    }

    if ($normalizedPath === '/privacidad-y-seguridad.php') {
        $normalizedPath = '/xpendz/privacidad-y-seguridad';
    }

    if ($normalizedPath === '/privacidad-y-seguridad') {
        $normalizedPath = '/xpendz/privacidad-y-seguridad';
    }

    if ($normalizedPath === '/privacidad.php') {
        $normalizedPath = '/xpendz/privacidad';
    }

    if ($normalizedPath === '/privacidad') {
        $normalizedPath = '/xpendz/privacidad';
    }

    if ($normalizedPath === '/eliminar-cuenta.php') {
        $normalizedPath = '/xpendz/eliminar-cuenta';
    }

    if ($normalizedPath === '/eliminar-cuenta') {
        $normalizedPath = '/xpendz/eliminar-cuenta';
    }

    if (preg_match('~\.php/+$~i', $normalizedPath)) {
        $normalizedPath = preg_replace('~/+$~', '', $normalizedPath);
    }

    if ($normalizedPath !== $path) {
        $dest = $normalizedPath . $query;
        header('Location: ' . $dest, true, 301);
        exit;
    }
}

// Email/Sender configuration
if (!defined('SITE_EMAIL_FROM')) { define('SITE_EMAIL_FROM', 'servicios@jcadenas.com'); }
if (!defined('SITE_EMAIL_FROM_NAME')) { define('SITE_EMAIL_FROM_NAME', 'Ing. Joel Cadenas'); }

// Optional SMTP config (env/override)
if (!defined('SMTP_HOST')) { define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.hostinger.com'); }
if (!defined('SMTP_PORT')) { define('SMTP_PORT', (int)(getenv('SMTP_PORT') ?: 465)); }
if (!defined('SMTP_SECURE')) { define('SMTP_SECURE', getenv('SMTP_SECURE') ?: 'ssl'); }
if (!defined('SMTP_USER')) { define('SMTP_USER', getenv('SMTP_USER') ?: 'servicios@jcadenas.com'); }
if (!defined('SMTP_PASS')) { define('SMTP_PASS', getenv('SMTP_PASS') ?: ''); }

// SMTP sender (AUTH LOGIN over SSL/TLS). Minimal implementation for Hostinger.
if (!function_exists('sendSMTPEmail')) {
    function sendSMTPEmail(string $to, string $subject, string $html, string $fromEmail, string $fromName = ''): bool {
        $host = SMTP_HOST;
        $port = (int)SMTP_PORT;
        $secure = strtolower((string)SMTP_SECURE);
        $user = SMTP_USER;
        $pass = SMTP_PASS;

        $remote = ($secure === 'ssl' ? 'ssl://' : '') . $host . ':' . $port;
        $fp = @stream_socket_client($remote, $errno, $errstr, 20, STREAM_CLIENT_CONNECT);
        if (!$fp) return false;
        stream_set_timeout($fp, 20);

        $readLine = function() use ($fp) { return fgets($fp, 512); };
        $readResponse = function(string $expected) use ($readLine) {
            $buffer = '';
            while (true) {
                $line = $readLine();
                if ($line === false) {
                    return false;
                }
                $buffer .= $line;
                if (strlen($line) < 4 || $line[3] !== '-') {
                    break;
                }
            }
            return strncmp($buffer, $expected, 3) === 0 ? $buffer : false;
        };
        $write = function($cmd) use ($fp) { fwrite($fp, $cmd); };

        if ($readResponse('220') === false) { fclose($fp); return false; }
        $write("EHLO jcadenas.com\r\n");
        if ($readResponse('250') === false) { fclose($fp); return false; }
        $write("AUTH LOGIN\r\n");
        if ($readResponse('334') === false) { fclose($fp); return false; }
        $write(base64_encode($user) . "\r\n");
        if ($readResponse('334') === false) { fclose($fp); return false; }
        $write(base64_encode($pass) . "\r\n");
        if ($readResponse('235') === false) { fclose($fp); return false; }

        $fromHeader = $fromName ? sprintf('"%s" <%s>', addslashes($fromName), $fromEmail) : $fromEmail;
        $date = date('r');
        $boundary = '=_part_'.bin2hex(random_bytes(8));
        $headers = [
            'Date: '.$date,
            'From: '.$fromHeader,
            'Reply-To: '.$fromEmail,
            'To: '.$to,
            'Subject: '.$subject,
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
            'X-Mailer: JCadenas/1.0',
            'X-Priority: 3',
            'Message-ID: <'.bin2hex(random_bytes(16)).'@jcadenas.com>',
        ];
        // MAIL FROM
        $write("MAIL FROM:<{$fromEmail}>\r\n");
        if ($readResponse('250') === false) { fclose($fp); return false; }
        // RCPT TO
        $write("RCPT TO:<{$to}>\r\n");
        if ($readResponse('250') === false) { fclose($fp); return false; }
        // DATA
        $write("DATA\r\n");
        if ($readResponse('354') === false) { fclose($fp); return false; }

        // Ensure lines end with CRLF and escape leading dots
        $body = preg_replace("~\r?\n~", "\r\n", $html);
        $body = preg_replace('/\r\n\./', "\r\n..", $body);
        $data = implode("\r\n", $headers) . "\r\n\r\n" . $body . "\r\n.\r\n";
        $write($data);
        if ($readResponse('250') === false) { fclose($fp); return false; }
        // QUIT
        $write("QUIT\r\n");
        fclose($fp);
        return true;
    }
}

// Email helper: try SMTP first; fallback to mail()
if (!function_exists('sendSiteEmail')) {
    function sendSiteEmail(string $to, string $subject, string $html, string $from = SITE_EMAIL_FROM): bool {
        $fromName = defined('SITE_EMAIL_FROM_NAME') ? SITE_EMAIL_FROM_NAME : '';
        $ok = false;
        if (defined('SMTP_HOST') && SMTP_HOST) {
            $ok = @sendSMTPEmail($to, $subject, $html, $from, $fromName);
        }
        if ($ok) return true;
        // Fallback to mail()
        $fromHeader = $fromName ? sprintf('"%s" <%s>', addslashes($fromName), $from) : $from;
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: {$fromHeader}\r\n";
        $headers .= "Reply-To: {$from}\r\n";
        $headers .= "X-Mailer: PHP/".phpversion()."\r\n";
        return @mail($to, $subject, $html, $headers);
    }
}

// Secure downloads base directory (outside web root). Adjust if needed.
if (!defined('SECURE_DOWNLOAD_BASE')) {
    // Auto-detect environment
    if (stripos(PHP_OS, 'WIN') !== false) {
        // Windows (local development)
        define('SECURE_DOWNLOAD_BASE', 'c:/secure_downloads/jcadenas/projects');
    } else {
        // Linux (Hostinger/Production)
        // Detectar el home directory del usuario en Hostinger
        $homeDir = getenv('HOME') ?: '/home/' . get_current_user();
        define('SECURE_DOWNLOAD_BASE', $homeDir . '/secure_downloads/jcadenas/projects');
    }
}

// Application secret for encrypting ZIP passwords (REPLACE with a strong 32-byte secret)
if (!defined('APP_SECRET')) {
    define('APP_SECRET', 'REPLACE_WITH_A_RANDOM_32_BYTE_SECRET_123456');
}

// PayPal configuration (set your real credentials in production)
if (!defined('PAYPAL_ENV')) { define('PAYPAL_ENV', 'sandbox'); } // 'sandbox' or 'live'
if (!defined('PAYPAL_CLIENT_ID')) { define('PAYPAL_CLIENT_ID', 'YOUR_PAYPAL_CLIENT_ID'); }
if (!defined('PAYPAL_CLIENT_SECRET')) { define('PAYPAL_CLIENT_SECRET', 'YOUR_PAYPAL_CLIENT_SECRET'); }
if (!defined('PAYPAL_CURRENCY')) { define('PAYPAL_CURRENCY', 'USD'); }
// Rough COP→USD rate for estimation; adjust in production
if (!defined('COP_TO_USD_RATE')) { define('COP_TO_USD_RATE', 4000.0); }

// Symmetric encryption helpers (AES-256-GCM)
if (!function_exists('encryptSecret')) {
    function encryptSecret(string $plain, string $key = APP_SECRET): string {
        if (empty($plain)) {
            return '';
        }
        
        try {
            $keyBin = substr(hash('sha256', $key, true), 0, 32);
            $iv = random_bytes(12); // Generar IV aleatorio
            
            $cipher = openssl_encrypt($plain, 'aes-256-gcm', $keyBin, OPENSSL_RAW_DATA, $iv, $tag, '', 16);
            
            if ($cipher === false) {
                throw new Exception('Error en encriptación');
            }
            
            // format: base64(iv|tag|cipher)
            return base64_encode($iv . $tag . $cipher);
        } catch (Exception $e) {
            error_log("Error al encriptar: " . $e->getMessage());
            return '';
        }
    }
}

if (!function_exists('resetProjectPassword')) {
    function resetProjectPassword(int $projectId, string $newPassword): bool {
        try {
            $encrypted = encryptSecret($newPassword);
            if (empty($encrypted)) {
                return false;
            }
            
            global $pdo;
            $stmt = $pdo->prepare('UPDATE proyecto SET password_encrypted = ? WHERE id = ?');
            return $stmt->execute([$encrypted, $projectId]);
        } catch (Exception $e) {
            error_log("Error al resetear contraseña: " . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('decryptSecret')) {
    function decryptSecret(string $b64, string $key = APP_SECRET): string {
        if (empty($b64)) {
            return '';
        }
        
        try {
            $keyBin = substr(hash('sha256', $key, true), 0, 32);
            $raw = base64_decode($b64, true);
            
            if ($raw === false || strlen($raw) < 28) {
                return '';
            }
            
            $iv = substr($raw, 0, 12);
            $tag = substr($raw, 12, 16);
            $cipher = substr($raw, 28);
            
            $plain = openssl_decrypt($cipher, 'aes-256-gcm', $keyBin, OPENSSL_RAW_DATA, $iv, $tag);
            
            return $plain !== false ? $plain : '';
        } catch (Exception $e) {
            error_log("Error al descifrar: " . $e->getMessage());
            return '';
        }
    }
}

// Build absolute URL from site base URL
if (!function_exists('siteUrl')) {
    function siteUrl(string $path = ''): string {
        $base = rtrim(SITE_BASE_URL, '/');
        $p = trim($path, '/');
        return $p ? ($base . '/' . $p) : ($base . '/');
    }
}

// Centralized placeholder for Google Play download URL (replace before launch)
if (!defined('XPENDZ_GOOGLE_PLAY_URL')) {
    // TODO: Replace with the official Google Play URL before public launch
    define('XPENDZ_GOOGLE_PLAY_URL', siteUrl('xpendz') . '#descargar');
}

// Currency formatting for Colombian Pesos
if (!function_exists('formatCOP')) {
    function formatCOP($amount, bool $decimals = false): string {
        if ($amount === null || $amount === '') return '';
        $num = (float)$amount;
        $dec = $decimals ? 2 : 0;
        // Example: $ 120.000 or $ 120.000,50
        return '$ ' . number_format($num, $dec, ',', '.');
    }
}
?>
<?php

