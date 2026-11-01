<?php
require_once __DIR__ . '/electricista-data.php';

if (!defined('ELECTRICISTA_DB_HOST')) {
    define('ELECTRICISTA_DB_HOST', getenv('ELECTRICISTA_DB_HOST') ?: 'localhost');
}

if (!defined('ELECTRICISTA_DB_PORT')) {
    define('ELECTRICISTA_DB_PORT', (int) (getenv('ELECTRICISTA_DB_PORT') ?: 3306));
}

if (!defined('ELECTRICISTA_DB_NAME')) {
    define('ELECTRICISTA_DB_NAME', getenv('ELECTRICISTA_DB_NAME') ?: '');
}

if (!defined('ELECTRICISTA_DB_USER')) {
    define('ELECTRICISTA_DB_USER', getenv('ELECTRICISTA_DB_USER') ?: '');
}

if (!defined('ELECTRICISTA_DB_PASS')) {
    define('ELECTRICISTA_DB_PASS', getenv('ELECTRICISTA_DB_PASS') ?: '');
}

if (!defined('ELECTRICISTA_ADMIN_SETUP_TOKEN')) {
    define('ELECTRICISTA_ADMIN_SETUP_TOKEN', getenv('ELECTRICISTA_ADMIN_SETUP_TOKEN') ?: '');
}

if (!defined('ELECTRICISTA_UPLOADS_BASE')) {
    define('ELECTRICISTA_UPLOADS_BASE', 'uploads/electricista/trabajos');
}

if (!defined('ELECTRICISTA_MAX_IMAGE_BYTES')) {
    define('ELECTRICISTA_MAX_IMAGE_BYTES', 32 * 1024 * 1024);
}

if (!defined('ELECTRICISTA_MAX_IMAGE_DIMENSION')) {
    define('ELECTRICISTA_MAX_IMAGE_DIMENSION', 2048);
}

if (!defined('ELECTRICISTA_JPEG_QUALITY')) {
    define('ELECTRICISTA_JPEG_QUALITY', 85);
}

if (!function_exists('electricistaAdminUrl')) {
    function electricistaAdminUrl(string $suffix = ''): string {
        $basePath = 'admin/electricista';
        $suffix = ltrim($suffix, '/');
        return siteUrl($suffix === '' ? ($basePath . '/index.php') : ($basePath . '/' . $suffix));
    }
}

if (!function_exists('electricistaIsDbConfigured')) {
    function electricistaIsDbConfigured(): bool {
        return ELECTRICISTA_DB_NAME !== ''
            && ELECTRICISTA_DB_USER !== ''
            && ELECTRICISTA_DB_PASS !== '';
    }
}

if (!function_exists('electricistaWorksPdo')) {
    function electricistaWorksPdo(): PDO {
        static $pdo = null;

        if ($pdo instanceof PDO) {
            return $pdo;
        }

        if (!electricistaIsDbConfigured()) {
            throw new RuntimeException('La base de datos de Electricista no está configurada.');
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            ELECTRICISTA_DB_HOST,
            ELECTRICISTA_DB_PORT,
            ELECTRICISTA_DB_NAME
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $pdo = new PDO($dsn, ELECTRICISTA_DB_USER, ELECTRICISTA_DB_PASS, $options);

        return $pdo;
    }
}

if (!function_exists('electricistaTablesReady')) {
    function electricistaTablesReady(PDO $pdo): bool {
        try {
            $pdo->query('SELECT 1 FROM electricista_works LIMIT 1');
            $pdo->query('SELECT 1 FROM electricista_categories LIMIT 1');
            $pdo->query('SELECT 1 FROM electricista_admin_users LIMIT 1');
            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }
}

if (!function_exists('electricistaAdminSessionStart')) {
    function electricistaAdminSessionStart(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        session_name('JCADENAS_ELECTRICISTA_ADMIN');

        $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        session_start();
    }
}

if (!function_exists('electricistaAdminIsLoggedIn')) {
    function electricistaAdminIsLoggedIn(): bool {
        electricistaAdminSessionStart();
        return !empty($_SESSION['electricista_admin']['id']);
    }
}

if (!function_exists('electricistaAdminCurrentUser')) {
    function electricistaAdminCurrentUser(): ?array {
        electricistaAdminSessionStart();
        return $_SESSION['electricista_admin'] ?? null;
    }
}

if (!function_exists('electricistaAdminLogin')) {
    function electricistaAdminLogin(array $user): void {
        electricistaAdminSessionStart();
        session_regenerate_id(true);
        $_SESSION['electricista_admin'] = [
            'id' => (int) ($user['id'] ?? 0),
            'username' => (string) ($user['username'] ?? ''),
        ];
    }
}

if (!function_exists('electricistaAdminLogout')) {
    function electricistaAdminLogout(): void {
        electricistaAdminSessionStart();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }
}

if (!function_exists('electricistaAdminRequireLogin')) {
    function electricistaAdminRequireLogin(): void {
        if (electricistaAdminIsLoggedIn()) {
            return;
        }
        header('Location: ' . electricistaAdminUrl('login.php'));
        exit;
    }
}

if (!function_exists('electricistaSetFlash')) {
    function electricistaSetFlash(string $type, string $message): void {
        electricistaAdminSessionStart();
        $_SESSION['electricista_flash'] = [
            'type' => $type,
            'message' => $message,
        ];
    }
}

if (!function_exists('electricistaConsumeFlash')) {
    function electricistaConsumeFlash(): ?array {
        electricistaAdminSessionStart();
        if (empty($_SESSION['electricista_flash'])) {
            return null;
        }
        $flash = $_SESSION['electricista_flash'];
        unset($_SESSION['electricista_flash']);
        return is_array($flash) ? $flash : null;
    }
}

if (!function_exists('electricistaCsrfToken')) {
    function electricistaCsrfToken(): string {
        electricistaAdminSessionStart();
        if (empty($_SESSION['electricista_csrf'])) {
            $_SESSION['electricista_csrf'] = bin2hex(random_bytes(32));
        }
        return (string) $_SESSION['electricista_csrf'];
    }
}

if (!function_exists('electricistaVerifyCsrf')) {
    function electricistaVerifyCsrf(?string $token): bool {
        electricistaAdminSessionStart();
        $sessionToken = $_SESSION['electricista_csrf'] ?? '';
        return is_string($token) && $token !== '' && is_string($sessionToken) && hash_equals($sessionToken, $token);
    }
}

if (!function_exists('electricistaSlugify')) {
    function electricistaSlugify(string $value, string $fallback = 'trabajo'): string {
        $value = trim($value);
        if ($value === '') {
            return $fallback;
        }

        $normalized = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        if ($normalized === false) {
            $normalized = $value;
        }

        $normalized = strtolower($normalized);
        $normalized = preg_replace('/[^a-z0-9]+/', '-', $normalized) ?? '';
        $normalized = trim($normalized, '-');

        return $normalized !== '' ? $normalized : $fallback;
    }
}

if (!function_exists('electricistaUniqueWorkSlug')) {
    function electricistaUniqueWorkSlug(PDO $pdo, string $slug, ?int $ignoreId = null): string {
        $slug = electricistaSlugify($slug);
        $baseSlug = $slug !== '' ? $slug : 'trabajo';
        $candidate = $baseSlug;
        $suffix = 2;

        while (true) {
            if ($ignoreId) {
                $stmt = $pdo->prepare('SELECT COUNT(*) FROM electricista_works WHERE slug = ? AND id <> ?');
                $stmt->execute([$candidate, $ignoreId]);
            } else {
                $stmt = $pdo->prepare('SELECT COUNT(*) FROM electricista_works WHERE slug = ?');
                $stmt->execute([$candidate]);
            }

            if ((int) $stmt->fetchColumn() === 0) {
                return $candidate;
            }

            $candidate = $baseSlug . '-' . $suffix;
            $suffix++;
        }
    }
}

if (!function_exists('electricistaCountAdminUsers')) {
    function electricistaCountAdminUsers(PDO $pdo): int {
        $stmt = $pdo->query('SELECT COUNT(*) FROM electricista_admin_users');
        return (int) $stmt->fetchColumn();
    }
}

if (!function_exists('electricistaFetchCategories')) {
    function electricistaFetchCategories(PDO $pdo, bool $onlyActive = true): array {
        $sql = 'SELECT id, name, slug, description FROM electricista_categories';
        if ($onlyActive) {
            $sql .= ' WHERE is_active = 1';
        }
        $sql .= ' ORDER BY sort_order ASC, name ASC';
        return $pdo->query($sql)->fetchAll();
    }
}

if (!function_exists('electricistaFetchAdminWorks')) {
    function electricistaFetchAdminWorks(PDO $pdo): array {
        $sql = 'SELECT w.*, c.name AS category_name,
                       (SELECT COUNT(*) FROM electricista_work_images wi WHERE wi.work_id = w.id) AS image_count
                FROM electricista_works w
                INNER JOIN electricista_categories c ON c.id = w.category_id
                ORDER BY w.created_at DESC, w.id DESC';
        return $pdo->query($sql)->fetchAll();
    }
}

if (!function_exists('electricistaFetchPublishedWorks')) {
    function electricistaFetchPublishedWorks(PDO $pdo): array {
        $sql = "SELECT w.*, c.name AS category_name, c.slug AS category_slug,
                       (SELECT COUNT(*) FROM electricista_work_images wi WHERE wi.work_id = w.id) AS image_count
                FROM electricista_works w
                INNER JOIN electricista_categories c ON c.id = w.category_id
                WHERE w.status = 'published'
                ORDER BY w.is_featured DESC, COALESCE(w.work_date, DATE(w.created_at)) DESC, w.id DESC";
        return $pdo->query($sql)->fetchAll();
    }
}

if (!function_exists('electricistaFetchPublishedWorksPage')) {
    function electricistaFetchPublishedWorksPage(PDO $pdo, int $page = 1, int $perPage = 6): array {
        $page = max(1, $page);
        $perPage = max(1, min(24, $perPage));
        $total = (int) $pdo->query("SELECT COUNT(*) FROM electricista_works WHERE status = 'published'")->fetchColumn();
        $totalPages = max(1, (int) ceil($total / $perPage));
        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $perPage;
        $stmt = $pdo->prepare("SELECT w.*, c.name AS category_name, c.slug AS category_slug,
                                      (SELECT COUNT(*) FROM electricista_work_images wi WHERE wi.work_id = w.id) AS image_count
                               FROM electricista_works w
                               INNER JOIN electricista_categories c ON c.id = w.category_id
                               WHERE w.status = 'published'
                               ORDER BY w.is_featured DESC, COALESCE(w.work_date, DATE(w.created_at)) DESC, w.id DESC
                               LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(),
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
        ];
    }
}

if (!function_exists('electricistaFetchPublicWorkBySlug')) {
    function electricistaFetchPublicWorkBySlug(PDO $pdo, string $slug): ?array {
        $stmt = $pdo->prepare("SELECT w.*, c.name AS category_name, c.slug AS category_slug
                               FROM electricista_works w
                               INNER JOIN electricista_categories c ON c.id = w.category_id
                               WHERE w.slug = ? AND w.status = 'published'
                               LIMIT 1");
        $stmt->execute([$slug]);
        $work = $stmt->fetch();
        if (!$work) {
            return null;
        }

        $work['images'] = electricistaFetchWorkImages($pdo, (int) $work['id']);
        return $work;
    }
}

if (!function_exists('electricistaFetchAdminWorkById')) {
    function electricistaFetchAdminWorkById(PDO $pdo, int $id): ?array {
        $stmt = $pdo->prepare('SELECT w.*, c.name AS category_name, c.slug AS category_slug
                               FROM electricista_works w
                               INNER JOIN electricista_categories c ON c.id = w.category_id
                               WHERE w.id = ?
                               LIMIT 1');
        $stmt->execute([$id]);
        $work = $stmt->fetch();
        if (!$work) {
            return null;
        }

        $work['images'] = electricistaFetchWorkImages($pdo, $id);
        return $work;
    }
}

if (!function_exists('electricistaFetchWorkImages')) {
    function electricistaFetchWorkImages(PDO $pdo, int $workId): array {
        $stmt = $pdo->prepare('SELECT id, work_id, image_path, alt_text, sort_order, created_at
                               FROM electricista_work_images
                               WHERE work_id = ?
                               ORDER BY sort_order ASC, id ASC');
        $stmt->execute([$workId]);
        return $stmt->fetchAll();
    }
}

if (!function_exists('electricistaFormatWorkDate')) {
    function electricistaFormatWorkDate(?string $date): string {
        if (!$date) {
            return '';
        }

        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return '';
        }

        return date('d/m/Y', $timestamp);
    }
}

if (!function_exists('electricistaWorkStatusLabel')) {
    function electricistaWorkStatusLabel(string $status): string {
        return $status === 'published' ? 'Publicado' : 'Borrador';
    }
}

if (!function_exists('electricistaUploadBaseRelativePath')) {
    function electricistaUploadBaseRelativePath(): string {
        return trim(ELECTRICISTA_UPLOADS_BASE, '/');
    }
}

if (!function_exists('electricistaUploadBaseAbsolutePath')) {
    function electricistaUploadBaseAbsolutePath(): string {
        return electricistaFilePath(electricistaUploadBaseRelativePath());
    }
}

if (!function_exists('electricistaEnsureDirectory')) {
    function electricistaEnsureDirectory(string $absolutePath): void {
        if (is_dir($absolutePath)) {
            return;
        }

        if (!mkdir($absolutePath, 0775, true) && !is_dir($absolutePath)) {
            throw new RuntimeException('No fue posible crear el directorio de subida.');
        }
    }
}

if (!function_exists('electricistaWorkUploadDirectory')) {
    function electricistaWorkUploadDirectory(int $workId): array {
        $relative = electricistaUploadBaseRelativePath() . '/trabajo-' . $workId;
        $absolute = electricistaFilePath($relative);
        electricistaEnsureDirectory($absolute);

        return [
            'relative' => $relative,
            'absolute' => $absolute,
        ];
    }
}

if (!function_exists('electricistaUploadErrorMessage')) {
    function electricistaUploadErrorMessage(int $errorCode, string $filename = ''): string {
        $label = $filename !== '' ? sprintf('«%s»', $filename) : 'El archivo';
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return sprintf('%s supera el tamaño máximo permitido por el servidor.', $label);
            case UPLOAD_ERR_PARTIAL:
                return sprintf('%s se subió de forma incompleta. Intenta nuevamente.', $label);
            case UPLOAD_ERR_NO_TMP_DIR:
            case UPLOAD_ERR_CANT_WRITE:
                return 'El servidor no pudo guardar el archivo temporal de la subida.';
            case UPLOAD_ERR_EXTENSION:
                return 'El servidor bloqueó la subida del archivo.';
            case UPLOAD_ERR_NO_FILE:
            default:
                return sprintf('%s no se recibió correctamente.', $label);
        }
    }
}

if (!function_exists('electricistaNormalizeImageWithImagick')) {
    function electricistaNormalizeImageWithImagick(string $sourcePath, string $targetPath): ?array {
        if (!extension_loaded('imagick')) {
            return null;
        }

        $image = new Imagick();
        try {
            if (!$image->readImage($sourcePath)) {
                return null;
            }
            $image->setIteratorIndex(0);

            switch ($image->getImageOrientation()) {
                case Imagick::ORIENTATION_TOPRIGHT:
                    $image->flopImage();
                    break;
                case Imagick::ORIENTATION_BOTTOMRIGHT:
                    $image->rotateImage('#ffffff', 180);
                    break;
                case Imagick::ORIENTATION_BOTTOMLEFT:
                    $image->flopImage();
                    $image->rotateImage('#ffffff', 180);
                    break;
                case Imagick::ORIENTATION_LEFTTOP:
                    $image->flopImage();
                    $image->rotateImage('#ffffff', -90);
                    break;
                case Imagick::ORIENTATION_RIGHTTOP:
                    $image->rotateImage('#ffffff', 90);
                    break;
                case Imagick::ORIENTATION_RIGHTBOTTOM:
                    $image->flopImage();
                    $image->rotateImage('#ffffff', 90);
                    break;
                case Imagick::ORIENTATION_LEFTBOTTOM:
                    $image->rotateImage('#ffffff', -90);
                    break;
            }
            $image->setImageOrientation(Imagick::ORIENTATION_TOPLEFT);

            if ($image->getImageAlphaChannel()) {
                $image->setImageBackgroundColor('#ffffff');
                $flattened = $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
                $image->clear();
                $image = $flattened;
                $image->setIteratorIndex(0);
            }

            $width = $image->getImageWidth();
            $height = $image->getImageHeight();
            if ($width <= 0 || $height <= 0) {
                return null;
            }

            $maxDimension = ELECTRICISTA_MAX_IMAGE_DIMENSION;
            if (max($width, $height) > $maxDimension) {
                $image->resizeImage($maxDimension, $maxDimension, Imagick::FILTER_LANCZOS, 1, true);
            }

            $image->stripImage();
            $image->setImageFormat('jpeg');
            $image->setImageCompressionQuality(ELECTRICISTA_JPEG_QUALITY);

            if (!$image->writeImage($targetPath)) {
                throw new RuntimeException('No se pudo guardar la imagen en el servidor.');
            }

            return [$image->getImageWidth(), $image->getImageHeight()];
        } catch (ImagickException $exception) {
            return null;
        } finally {
            $image->clear();
        }
    }
}

if (!function_exists('electricistaNormalizeImageWithGd')) {
    function electricistaNormalizeImageWithGd(string $sourcePath, string $targetPath): ?array {
        if (!extension_loaded('gd')) {
            return null;
        }

        $info = @getimagesize($sourcePath);
        if ($info === false) {
            return null;
        }

        $contents = @file_get_contents($sourcePath);
        if ($contents === false) {
            return null;
        }

        $source = @imagecreatefromstring($contents);
        if (!$source) {
            return null;
        }

        $orientation = 0;
        if (function_exists('exif_read_data') && ($info['mime'] ?? '') === 'image/jpeg') {
            $exif = @exif_read_data($sourcePath);
            $orientation = (int) ($exif['Orientation'] ?? 0);
        }
        switch ($orientation) {
            case 3:
                $source = imagerotate($source, 180, 0);
                break;
            case 6:
                $source = imagerotate($source, -90, 0);
                break;
            case 8:
                $source = imagerotate($source, 90, 0);
                break;
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $maxDimension = ELECTRICISTA_MAX_IMAGE_DIMENSION;
        $scale = max($width, $height) > $maxDimension ? $maxDimension / max($width, $height) : 1;
        $targetWidth = max(1, (int) round($width * $scale));
        $targetHeight = max(1, (int) round($height * $scale));

        $target = imagecreatetruecolor($targetWidth, $targetHeight);
        $white = imagecolorallocate($target, 255, 255, 255);
        imagefill($target, 0, 0, $white);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        $saved = imagejpeg($target, $targetPath, ELECTRICISTA_JPEG_QUALITY);
        imagedestroy($source);
        imagedestroy($target);

        if (!$saved) {
            throw new RuntimeException('No se pudo guardar la imagen en el servidor.');
        }

        return [$targetWidth, $targetHeight];
    }
}

if (!function_exists('electricistaNormalizeImageToJpeg')) {
    function electricistaNormalizeImageToJpeg(string $sourcePath, string $targetPath): ?array {
        $dimensions = electricistaNormalizeImageWithImagick($sourcePath, $targetPath);
        if ($dimensions !== null) {
            return $dimensions;
        }
        return electricistaNormalizeImageWithGd($sourcePath, $targetPath);
    }
}

if (!function_exists('electricistaStoreUploadedImage')) {
    function electricistaStoreUploadedImage(array $file, int $workId, string $slug, string $prefix = 'imagen'): array {
        $errorCode = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
        $originalName = trim((string) ($file['name'] ?? ''));
        if ($errorCode !== UPLOAD_ERR_OK) {
            throw new RuntimeException(electricistaUploadErrorMessage($errorCode, $originalName));
        }

        if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            throw new RuntimeException('La subida de imagen no es válida.');
        }

        $maxMegabytes = (int) round(ELECTRICISTA_MAX_IMAGE_BYTES / 1048576);
        if (!empty($file['size']) && (int) $file['size'] > ELECTRICISTA_MAX_IMAGE_BYTES) {
            $label = $originalName !== '' ? sprintf('«%s»', $originalName) : 'La imagen';
            throw new RuntimeException(sprintf('%s excede el tamaño máximo permitido de %d MB.', $label, $maxMegabytes));
        }

        $directories = electricistaWorkUploadDirectory($workId);
        $safePrefix = electricistaSlugify($prefix, 'imagen');
        $safeSlug = electricistaSlugify($slug, 'trabajo');
        $filename = sprintf('%s-%s-%s.jpg', $safePrefix, $safeSlug, bin2hex(random_bytes(6)));
        $absoluteTarget = $directories['absolute'] . '/' . $filename;

        $dimensions = electricistaNormalizeImageToJpeg($file['tmp_name'], $absoluteTarget);
        if ($dimensions === null || !is_file($absoluteTarget)) {
            $label = $originalName !== '' ? sprintf('«%s»', $originalName) : 'El archivo seleccionado';
            throw new RuntimeException($label . ' no es una imagen válida o su formato no es compatible.');
        }

        @chmod($absoluteTarget, 0644);

        return [
            'relative_path' => $directories['relative'] . '/' . $filename,
            'width' => (int) $dimensions[0],
            'height' => (int) $dimensions[1],
            'mime' => 'image/jpeg',
        ];
    }
}

if (!function_exists('electricistaDeleteUploadedFile')) {
    function electricistaDeleteUploadedFile(?string $relativePath): void {
        if (!$relativePath) {
            return;
        }

        $normalized = str_replace('\\', '/', ltrim($relativePath, '/'));
        $base = electricistaUploadBaseRelativePath();
        if (strpos($normalized, $base . '/') !== 0) {
            return;
        }

        $absolutePath = electricistaFilePath($normalized);
        if (is_file($absolutePath)) {
            @unlink($absolutePath);
        }
    }
}

if (!function_exists('electricistaEmptyUploadDirectory')) {
    function electricistaEmptyUploadDirectory(int $workId): void {
        $directory = electricistaFilePath(electricistaUploadBaseRelativePath() . '/trabajo-' . $workId);
        if (!is_dir($directory)) {
            return;
        }

        $files = scandir($directory);
        if (!is_array($files)) {
            return;
        }

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $directory . '/' . $file;
            if (is_file($path)) {
                @unlink($path);
            }
        }

        @rmdir($directory);
    }
}

if (!function_exists('electricistaHtml')) {
    function electricistaHtml(?string $value): string {
        return htmlspecialchars((string) $value, ENT_QUOTES);
    }
}
