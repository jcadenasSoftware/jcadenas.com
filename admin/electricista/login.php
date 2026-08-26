<?php
require_once __DIR__ . '/../../includes/electricista-admin-layout.php';

electricistaAdminSessionStart();

if (electricistaAdminIsLoggedIn()) {
    header('Location: ' . electricistaAdminUrl('index.php'));
    exit;
}

$error = '';
$tablesReady = false;
$adminCount = 0;
$configReady = electricistaIsDbConfigured();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $configReady && $tablesReady) {
    if (!electricistaVerifyCsrf($_POST['csrf_token'] ?? null)) {
        $error = 'La sesión expiró. Intenta nuevamente.';
    } else {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $error = 'Ingresa usuario y contraseña.';
        } else {
            $stmt = $pdo->prepare('SELECT id, username, password_hash FROM electricista_admin_users WHERE username = ? AND is_active = 1 LIMIT 1');
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                electricistaAdminLogin($user);
                electricistaSetFlash('success', 'Sesión iniciada correctamente.');
                header('Location: ' . electricistaAdminUrl('index.php'));
                exit;
            }

            $error = 'Usuario o contraseña incorrectos.';
        }
    }
}

electricistaAdminRenderHeader('Acceso | Admin Electricista');
?>
<div class="electricista-admin-login-wrap">
    <div class="electricista-admin-login-card">
        <p class="electricista-eyebrow">Panel administrativo</p>
        <h1 class="electricista-admin-title">Acceso a trabajos de Electricista</h1>
        <p class="electricista-admin-subtitle">Inicia sesión para crear, editar, publicar y administrar trabajos realizados con su portada y galería.</p>

        <?php if ($error !== ''): ?>
        <div class="alert alert-danger electricista-admin-alert" role="alert"><?= electricistaHtml($error) ?></div>
        <?php endif; ?>

        <?php if (!$configReady): ?>
        <div class="alert alert-warning electricista-admin-alert" role="alert">
            Falta configurar las credenciales de la base de datos de Electricista en <code>config.local.php</code>.
        </div>
        <?php elseif (!$tablesReady): ?>
        <div class="alert alert-warning electricista-admin-alert" role="alert">
            La base de datos está configurada, pero aún no existen las tablas de Electricista. Ejecuta primero la migración <code>assets/data/migrations/004_create_electricista_works.sql</code>.
        </div>
        <?php elseif ($adminCount === 0): ?>
        <div class="alert alert-info electricista-admin-alert" role="alert">
            Todavía no existe ningún usuario administrador. Crea el primero desde <a href="<?= electricistaHtml(electricistaAdminUrl('setup.php')) ?>">setup.php</a>.
        </div>
        <?php endif; ?>

        <form method="post" class="electricista-admin-form-grid">
            <input type="hidden" name="csrf_token" value="<?= electricistaHtml(electricistaCsrfToken()) ?>">
            <div class="is-full">
                <label class="form-label" for="username">Usuario</label>
                <input class="form-control" type="text" id="username" name="username" autocomplete="username" required>
            </div>
            <div class="is-full">
                <label class="form-label" for="password">Contraseña</label>
                <input class="form-control" type="password" id="password" name="password" autocomplete="current-password" required>
            </div>
            <div class="is-full d-grid">
                <button class="btn btn-primary" type="submit"<?= (!$configReady || !$tablesReady || $adminCount === 0) ? ' disabled' : '' ?>>Entrar al panel</button>
            </div>
        </form>

        <hr>

        <ul class="electricista-admin-help-list">
            <li>Base de datos objetivo: <strong>u775031495_electricista</strong>.</li>
            <li>La contraseña no queda en el repositorio; se lee desde <code>config.local.php</code>.</li>
            <li>El primer administrador se crea manualmente y de forma segura desde <code>setup.php</code>.</li>
        </ul>
    </div>
</div>
<?php electricistaAdminRenderFooter(); ?>
