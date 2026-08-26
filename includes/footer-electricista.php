<?php require_once __DIR__ . '/electricista-data.php'; ?>
</main>
<footer class="electricista-footer" id="contacto">
    <div class="electricista-shell electricista-footer-grid">
        <div class="electricista-footer-meta">
            <a class="electricista-footer-brand" href="<?= htmlspecialchars(electricistaPageUrl(), ENT_QUOTES) ?>" aria-label="<?= htmlspecialchars((electricistaData('brand_name') ?: 'Joel Cadenas') . ' - inicio', ENT_QUOTES) ?>">
                <img src="<?= htmlspecialchars(electricistaAbsoluteUrl('assets/img/electricista/ui/logo-monocromatico-oscuro.png'), ENT_QUOTES) ?>" alt="<?= htmlspecialchars((electricistaData('brand_name') ?: 'Joel Cadenas') . ' · ' . (electricistaData('section_name') ?: 'Electricista Bogotá'), ENT_QUOTES) ?>" loading="lazy" decoding="async">
            </a>
            <nav class="electricista-footer-nav" aria-label="Navegación secundaria">
                <a href="<?= htmlspecialchars(electricistaPageUrl(), ENT_QUOTES) ?>#hero">Inicio</a>
                <a href="<?= htmlspecialchars(electricistaPageUrl(), ENT_QUOTES) ?>#servicios">Servicios</a>
                <a class="<?= (isset($pageBodyClass) && (str_contains((string) $pageBodyClass, 'works-page') || str_contains((string) $pageBodyClass, 'work-detail-page'))) ? 'is-active' : '' ?>" href="<?= htmlspecialchars(electricistaWorksUrl(), ENT_QUOTES) ?>">Trabajos</a>
                <a href="<?= htmlspecialchars(electricistaPageUrl(), ENT_QUOTES) ?>#cobertura">Cobertura</a>
            </nav>
            <p class="electricista-footer-contact">
                <a href="<?= htmlspecialchars(electricistaWhatsappUrl(), ENT_QUOTES) ?>" target="_blank" rel="noopener"><?= htmlspecialchars(electricistaData('whatsapp_display') ?: '+57 317 756 4861', ENT_QUOTES) ?></a>
            </p>
            <p class="electricista-footer-contact">
                <a href="mailto:servicios@jcadenas.com">servicios@jcadenas.com</a>
            </p>
            <p class="electricista-footer-copyright" data-electricista-gateway="<?= htmlspecialchars(electricistaAdminUrl('login.php'), ENT_QUOTES) ?>" role="button" tabindex="0" aria-label="Acceso interno administrativo">
                © <?= date('Y') ?>
            </p>
        </div>
    </div>
</footer>
<script src="<?= $base ?>/assets/js/electricista.js?v=<?= htmlspecialchars(electricistaAssetVersion(), ENT_QUOTES) ?>" defer></script>
</body>
</html>
