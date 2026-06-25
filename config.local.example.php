<?php
/**
 * Configuración Local (Hostinger Production)
 * 
 * INSTRUCCIONES:
 * 1. Renombrar este archivo a: config.local.php
 * 2. Completar los valores reales
 * 3. NO subir a GIT (ya está en .gitignore)
 * 4. Colocar FUERA de public_html por seguridad (opcional)
 */

// ========== SMTP CREDENTIALS (REQUERIDO) ==========
// Obtén estos datos desde el panel de Hostinger > Email > Configuración
define('SMTP_PASS', 'TU_CONTRASEÑA_SMTP_REAL');  // ⚠️ IMPORTANTE: Cambiar esto

// Si tu usuario SMTP es diferente (normalmente es igual al email)
// define('SMTP_USER', 'servicios@jcadenas.com');

// ========== DIRECTORIO DE DESCARGAS (REQUERIDO) ==========
// En Hostinger, típicamente es algo como:
// /home/u123456789/secure_downloads
// 
// Para encontrar tu ruta:
// 1. Conectar por SSH o File Manager
// 2. Ejecutar: pwd  (imprime directorio actual)
// 3. Normalmente es: /home/uXXXXXX/
//
define('SECURE_DOWNLOAD_BASE', '/home/u123456789/secure_downloads');  // ⚠️ CAMBIAR

// ========== PAYPAL (OPCIONAL) ==========
// Solo si usas PayPal para pagos
// define('PAYPAL_ENV', 'live');  // 'sandbox' o 'live'
// define('PAYPAL_CLIENT_ID', 'TU_CLIENT_ID_REAL');
// define('PAYPAL_CLIENT_SECRET', 'TU_SECRET_REAL');

// ========== APP SECRET (RECOMENDADO) ==========
// Cambiar por una clave aleatoria de 32 bytes
// Puedes generar una con: openssl rand -hex 32
// define('APP_SECRET', 'aqui_tu_clave_secreta_de_32_bytes_hex');

?>
