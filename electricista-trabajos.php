<?php
require_once __DIR__ . '/includes/electricista-works.php';

$currentPage = max(1, (int) ($_GET['page'] ?? 1));
$pagination = [
    'items' => [],
    'page' => 1,
    'per_page' => 6,
    'total' => 0,
    'total_pages' => 1,
];

$pageTitle = 'Trabajos realizados | Joel Cadenas';
$pageDescription = 'Proyectos y soluciones técnicas realizadas para hogares y negocios en Bogotá.';
$pageCanonicalPath = $currentPage > 1 ? ('electricista/trabajos?page=' . $currentPage) : 'electricista/trabajos';
$pageBodyClass = 'electricista-works-page';
$pageSchema = null;
$pageOgImage = electricistaData('default_og_image');
$pageNavLinks = electricistaNavigation('works');

$works = [];
$dbReady = false;

try {
    $pdo = electricistaWorksPdo();
    if (electricistaTablesReady($pdo)) {
        $pagination = electricistaFetchPublishedWorksPage($pdo, $currentPage, 6);
        $works = $pagination['items'];
        $currentPage = (int) $pagination['page'];
        $dbReady = true;
    }
} catch (Throwable $exception) {
    $dbReady = false;
}

$buildPageUrl = static function (int $pageNumber): string {
    $url = electricistaWorksUrl();
    if ($pageNumber <= 1) {
        return $url;
    }
    return $url . '?page=' . $pageNumber;
};

include __DIR__ . '/includes/header-electricista.php';
?>
<section class="electricista-section electricista-works-hero" id="trabajos-publicos">
    <div class="electricista-shell electricista-works-intro">
        <div>
            <p class="electricista-eyebrow">Trabajos realizados</p>
            <h1 class="electricista-section-title">Proyectos y soluciones técnicas realizadas para hogares y negocios</h1>
            <p class="electricista-section-copy">Aquí encontrarás trabajos reales publicados desde el panel administrativo, con su información principal, imágenes y detalles del proyecto.</p>
            <?php if (!empty($pagination['total'])): ?>
            <p class="electricista-section-copy">Mostrando página <?= (int) $currentPage ?> de <?= (int) $pagination['total_pages'] ?> · <?= (int) $pagination['total'] ?> trabajo<?= (int) $pagination['total'] === 1 ? '' : 's' ?> publicado<?= (int) $pagination['total'] === 1 ? '' : 's' ?>.</p>
            <?php endif; ?>
        </div>
        <div class="electricista-works-intro-actions">
            <a class="electricista-button electricista-button--primary" href="<?= electricistaHtml(electricistaWhatsappUrl()) ?>" target="_blank" rel="noopener">
                <i class="bi bi-whatsapp"></i>
                <span>Solicitar información</span>
            </a>
        </div>
    </div>
</section>

<section class="electricista-section">
    <div class="electricista-shell">
        <?php if (empty($works)): ?>
        <div class="electricista-work-empty">
            <h2 class="electricista-section-title">Aún estamos preparando nuestros primeros proyectos</h2>
            <p class="electricista-section-copy">Pronto encontrarás aquí trabajos realizados, fotografías y detalles de cada solución.</p>
            <?php if (!$dbReady): ?>
            <p class="electricista-section-copy">La página ya está lista para mostrar publicaciones en cuanto la base de datos y el panel administrativo queden configurados.</p>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="electricista-works-grid">
            <?php foreach ($works as $work): ?>
            <article class="electricista-work-archive-card">
                <a class="electricista-work-archive-media" href="<?= electricistaHtml(electricistaWorksUrl($work['slug'])) ?>">
                    <img src="<?= electricistaHtml(electricistaAbsoluteUrl($work['cover_image'])) ?>" alt="<?= electricistaHtml($work['cover_image_alt'] ?: $work['title']) ?>" loading="lazy" decoding="async">
                </a>
                <div class="electricista-work-archive-body">
                    <div class="electricista-work-meta">
                        <span class="electricista-work-chip"><?= electricistaHtml($work['category_name']) ?></span>
                        <?php if (!empty($work['is_featured'])): ?>
                        <span class="electricista-work-chip electricista-work-chip--featured">Destacado</span>
                        <?php endif; ?>
                    </div>
                    <h2 class="electricista-service-title"><a href="<?= electricistaHtml(electricistaWorksUrl($work['slug'])) ?>"><?= electricistaHtml($work['title']) ?></a></h2>
                    <div class="electricista-work-meta electricista-work-meta--secondary">
                        <?php if (!empty($work['location'])): ?>
                        <span><i class="bi bi-geo-alt"></i><?= electricistaHtml($work['location']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($work['work_date'])): ?>
                        <span><i class="bi bi-calendar3"></i><?= electricistaHtml(electricistaFormatWorkDate($work['work_date'])) ?></span>
                        <?php endif; ?>
                    </div>
                    <p class="electricista-service-copy"><?= electricistaHtml($work['short_description']) ?></p>
                    <div class="electricista-service-actions">
                        <a class="electricista-button electricista-button--service" href="<?= electricistaHtml(electricistaWorksUrl($work['slug'])) ?>">Ver trabajo</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php if (($pagination['total_pages'] ?? 1) > 1): ?>
        <nav class="electricista-pagination" aria-label="Paginación de trabajos">
            <?php if ($currentPage > 1): ?>
            <a class="electricista-button electricista-button--secondary" href="<?= electricistaHtml($buildPageUrl($currentPage - 1)) ?>">Anterior</a>
            <?php endif; ?>
            <div class="electricista-pagination-pages">
                <?php for ($pageNumber = 1; $pageNumber <= (int) $pagination['total_pages']; $pageNumber++): ?>
                <a class="electricista-pagination-link<?= $pageNumber === $currentPage ? ' is-active' : '' ?>" href="<?= electricistaHtml($buildPageUrl($pageNumber)) ?>"><?= $pageNumber ?></a>
                <?php endfor; ?>
            </div>
            <?php if ($currentPage < (int) $pagination['total_pages']): ?>
            <a class="electricista-button electricista-button--secondary" href="<?= electricistaHtml($buildPageUrl($currentPage + 1)) ?>">Siguiente</a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php include __DIR__ . '/includes/footer-electricista.php'; ?>
