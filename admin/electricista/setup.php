<?php
require_once __DIR__ . '/../../includes/electricista-admin-layout.php';

electricistaAdminSessionStart();

$error = '';
$success = '';
$configReady = electricistaIsDbConfigured();
$tablesReady = false;
$adminCount = 0;

if ($configReady) {
    try {
        $pdo = electricistaWorksPdo();
        $tablesReady = electricistaTablesReady($pdo);
        if ($tablesReady) {
            $adminCount = electricistaCountAdminUsers($pdo);
        }
    } catch (Throwable $exception) {
        $error = 'No fue posible conectar con la base de datos de Electricista.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $configReady && $tablesReady && $adminCount === 0) {
    if (!electricistaVerifyCsrf($_POST['csrf_token'] ?? null)) {
        $error = 'La sesión expiró. Intenta nuevamente.';
    } else {
        $setupToken = trim((string) ($_POST['setup_token'] ?? ''));
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $passwordConfirm = (string) ($_POST['password_confirm'] ?? '');

        if (ELECTRICISTA_ADMIN_SETUP_TOKEN === '') {
            $error = 'Define ELECTRICISTA_ADMIN_SETUP_TOKEN en config.local.php antes de usar este setup.';
        } elseif (!hash_equals(ELECTRICISTA_ADMIN_SETUP_TOKEN, $setupToken)) {
            $error = 'El token de configuración no es válido.';
        } elseif (!preg_match('/^[A-Za-z0-9_.-]{4,50}$/', $username)) {
            $error = 'Usa un nombre de usuario de 4 a 50 caracteres, con letras, números, punto, guion o guion bajo.';
        } elseif (strlen($password) < 12) {
            $error = 'La contraseña debe tener al menos 12 caracteres.';
        } elseif ($password !== $passwordConfirm) {
            $error = 'La confirmación de contraseña no coincide.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO electricista_admin_users (username, password_hash) VALUES (?, ?)');
            $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
            electricistaSetFlash('success', 'Administrador inicial creado correctamente. Ya puedes iniciar sesión.');
            header('Location: ' . electricistaAdminUrl('login.php'));
            exit;
        }
    }
}

electricistaAdminRenderHeader('Setup inicial | Admin Electricista');
?>
<div class="electricista-admin-login-wrap">
    <div class="electricista-admin-login-card">
        <p class="electricista-eyebrow">Configuración inicial</p>
        <h1 class="electricista-admin-title">Crear primer administrador</h1>
        <p class="electricista-admin-subtitle">Este formulario solo funciona cuando todavía no existe ningún usuario administrador.</p>

        <?php if ($error !== ''): ?>
        <div class="alert alert-danger electricista-admin-alert" role="alert"><?= electricistaHtml($error) ?></div>
        <?php endif; ?>

        <?php if (!$configReady): ?>
        <div class="alert alert-warning electricista-admin-alert" role="alert">Primero debes completar las credenciales de la base de datos en <code>config.local.php</code>.</div>
        <?php elseif (!$tablesReady): ?>
        <div class="alert alert-warning electricista-admin-alert" role="alert">Antes del setup ejecuta la migración <code>assets/data/migrations/004_create_electricista_works.sql</code>.</div>
        <?php elseif ($adminCount > 0): ?>
        <div class="alert alert-info electricista-admin-alert" role="alert">Ya existe al menos un administrador. Este setup inicial ha quedado deshabilitado.</div>
        <?php else: ?>
        <form method="post" class="electricista-admin-form-grid">
            <input type="hidden" name="csrf_token" value="<?= electricistaHtml(electricistaCsrfToken()) ?>">
            <div class="is-full">
                <label class="form-label" for="setup_token">Token de configuración</label>
                <input class="form-control" type="password" id="setup_token" name="setup_token" required>
                <div class="form-text">Debe coincidir con la constante <code>ELECTRICISTA_ADMIN_SETUP_TOKEN</code> definida en <code>config.local.php</code>.</div>
            </div>
            <div>
                <label class="form-label" for="username">Usuario administrador</label>
                <input class="form-control" type="text" id="username" name="username" required>
            </div>
            <div>
                <label class="form-label" for="password">Contraseña segura</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>
            <div class="is-full">
                <label class="form-label" for="password_confirm">Confirmar contraseña</label>
                <input class="form-control" type="password" id="password_confirm" name="password_confirm" required>
            </div>
            <div class="is-full d-grid gap-2">
                <button class="btn btn-primary" type="submit">Crear administrador inicial</button>
                <a class="btn btn-outline-light" href="<?= electricistaHtml(electricistaAdminUrl('login.php')) ?>">Volver al login</a>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>
<?php electricistaAdminRenderFooter(); ?>
