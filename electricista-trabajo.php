<?php
require_once __DIR__ . '/includes/electricista-works.php';

$slug = trim((string) ($_GET['slug'] ?? ''));
$work = null;

if ($slug !== '') {
    try {
        $pdo = electricistaWorksPdo();
        if (electricistaTablesReady($pdo)) {
            $work = electricistaFetchPublicWorkBySlug($pdo, $slug);
        }
    } catch (Throwable $exception) {
        $work = null;
    }
}

if (!$work) {
    http_response_code(404);
    $pageTitle = 'Trabajo no encontrado | Joel Cadenas';
    $pageDescription = 'El trabajo solicitado no está disponible.';
    $pageCanonicalPath = 'electricista/trabajos';
    $pageBodyClass = 'electricista-work-detail-page';
    $pageSchema = null;
    include __DIR__ . '/includes/header-electricista.php';
    ?>
<section class="electricista-section electricista-work-empty-state">
    <div class="electricista-shell electricista-work-empty">
        <h1 class="electricista-section-title">Este trabajo no está disponible</h1>
        <p class="electricista-section-copy">Puede que aún no esté publicado o que la dirección haya cambiado.</p>
        <div class="electricista-hero-actions">
            <a class="electricista-button" href="<?= electricistaHtml(electricistaWorksUrl()) ?>">Volver a Trabajos</a>
            <a class="electricista-button electricista-button--primary" href="<?= electricistaHtml(electricistaWhatsappUrl()) ?>" target="_blank" rel="noopener">
                <i class="bi bi-whatsapp"></i>
                <span>Hablar por WhatsApp</span>
            </a>
        </div>
    </div>
</section>
<?php
    include __DIR__ . '/includes/footer-electricista.php';
    return;
}

$pageTitle = $work['title'] . ' | Trabajos realizados';
$pageDescription = $work['short_description'];
$pageCanonicalPath = 'electricista/trabajos/' . $work['slug'];
$pageBodyClass = 'electricista-work-detail-page';
$pageSchema = null;
$pageOgImage = $work['cover_image'] ?: electricistaData('default_og_image');
$pageNavLinks = electricistaNavigation('works');

include __DIR__ . '/includes/header-electricista.php';
?>
<section class="electricista-section electricista-work-detail-hero">
    <div class="electricista-shell electricista-work-detail-grid">
        <div class="electricista-work-detail-copy">
            <p class="electricista-eyebrow">Trabajo realizado</p>
            <h1 class="electricista-section-title"><?= electricistaHtml($work['title']) ?></h1>
            <div class="electricista-work-meta electricista-work-meta--secondary">
                <span class="electricista-work-chip"><?= electricistaHtml($work['category_name']) ?></span>
                <?php if (!empty($work['location'])): ?>
                <span><i class="bi bi-geo-alt"></i><?= electricistaHtml($work['location']) ?></span>
                <?php endif; ?>
                <?php if (!empty($work['work_date'])): ?>
                <span><i class="bi bi-calendar3"></i><?= electricistaHtml(electricistaFormatWorkDate($work['work_date'])) ?></span>
                <?php endif; ?>
            </div>
            <p class="electricista-section-copy"><?= nl2br(electricistaHtml($work['description'])) ?></p>
            <div class="electricista-hero-actions">
                <a class="electricista-button" href="<?= electricistaHtml(electricistaWorksUrl()) ?>">Volver a Trabajos</a>
                <a class="electricista-button electricista-button--primary" href="<?= electricistaHtml(electricistaWhatsappUrl()) ?>" target="_blank" rel="noopener">
                    <i class="bi bi-whatsapp"></i>
                    <span>Consultar este tipo de trabajo</span>
                </a>
            </div>
        </div>
        <div class="electricista-work-detail-media">
            <img src="<?= electricistaHtml(electricistaAbsoluteUrl($work['cover_image'])) ?>" alt="<?= electricistaHtml($work['cover_image_alt'] ?: $work['title']) ?>" loading="eager" decoding="async">
        </div>
    </div>
</section>

<?php if (!empty($work['images'])): ?>
<section class="electricista-section electricista-section--alt">
    <div class="electricista-shell">
        <div class="electricista-section-heading">
            <p class="electricista-eyebrow">Galería</p>
            <h2 class="electricista-section-title">Fotografías del trabajo</h2>
        </div>
        <div class="electricista-work-gallery-grid">
            <?php foreach ($work['images'] as $image): ?>
            <figure class="electricista-work-gallery-card">
                <img src="<?= electricistaHtml(electricistaAbsoluteUrl($image['image_path'])) ?>" alt="<?= electricistaHtml($image['alt_text'] ?: $work['title']) ?>" loading="lazy" decoding="async">
            </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php include __DIR__ . '/includes/footer-electricista.php'; ?>
