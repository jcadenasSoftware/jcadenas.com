<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero hero-compact section d-flex align-items-center" style="background:url('<?= $base ?>/assets/img/about.webp') center/cover no-repeat;">
  <div class="hero-content text-center">
    <div class="container">

      <!-- Imagen + texto en línea -->
      <div class="d-flex flex-column flex-md-row align-items-center mb-4">
        <!-- Imagen -->
        <picture class="me-md-4 mb-3 mb-md-0 text-center">
          <source srcset="<?= $base ?>/assets/img/profile.webp" type="image/webp">
          <img src="<?= $base ?>/assets/img/profile.jpg" alt="Joel Cadenas"
               class="profile-img shadow-lg" width="220" height="361"
               loading="eager" decoding="sync">
        </picture>
        <!-- Título y subtítulo -->
        <div class="text-center text-md-start align-self-start ms-md-4">
          <h1 class="display-4 fw-bold mb-2">Sobre mí</h1>
          <p class="lead mb-0">
            Hola, soy Joel Cadenas, Software Developer con experiencia en desarrollo Android (Kotlin), aplicaciones de escritorio en Java y plataformas web con backend propio.
          </p>
        </div>
      </div>
      <!-- Botones -->
      <div class="text-center mt-4">
        <a href="<?= $base ?>/cv.php" class="btn btn-outline-light btn-lg">
          <i class="bi bi-file-earmark-text me-2"></i>Ver currículum (1 página)
        </a>
        <a href="<?= $base ?>/resume.php" class="btn btn-outline-light btn-lg">
          <i class="bi bi-file-earmark-text me-2"></i>Resume (EN)
        </a>
        <a href="<?= $base ?>/contact.php" class="btn btn-outline-light btn-lg">
          <i class="bi bi-envelope me-2"></i>Contactar
        </a>
      </div>
    </div>
  </div>
</section> 

<!-- Mi Historia -->
<section class="section section-mi-perfil" id="mi-perfil">
  <div class="container container-narrow">
    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold mb-3">Mi Perfil</h2>
      <p class="lead">Mi historia en el desarrollo de software</p>
    </div>
    
    <div class="row align-items-center g-5">
      <div class="col-lg-8">
        <p class="perfil-paragraph">Hola, soy Joel Cadenas, ingeniero en informática especializado en programación Java y MySQL, desarrollo web y desarrollo móvil construyendo aplicaciones adecuadas a los requerimientos del cliente según su modelo de negocio y utilizando tecnologías actualizadas para un mejor uso de los recursos.</p>
        <p class="perfil-paragraph">A lo largo de mi trayectoria he participado en proyectos que integran tecnologías como Java, PHP, Python, Firebase y Google Maps API, entre otras. Lo que más me inspira es diseñar herramientas que generen un impacto real en las personas y optimicen los procesos de negocio.</p>
        <p class="perfil-paragraph mb-4">
          Mi experiencia profesional se fundamenta en el <strong>desarrollo independiente de proyectos</strong> para diversos clientes y sectores.
          A lo largo de mi carrera, he tenido la oportunidad de trabajar directamente con empresas y emprendedores,
          creando soluciones personalizadas que se adaptan a sus necesidades específicas. Esta modalidad de trabajo
          me ha permitido desarrollar una amplia versatilidad técnica y un profundo entendimiento de diferentes
          modelos de negocio, siempre enfocado en entregar productos de calidad que generen valor real.
        </p>
        <a href="<?= $base ?>/portfolio.php" class="btn btn-primary btn-lg">
          <i class="bi bi-briefcase me-2"></i>Ver Portafolio Completo
        </a>
      </div>
      <div class="col-lg-4">
        <div class="perfil-highlights">
          <div class="perfil-highlights-title">Enfoque de trabajo</div>
          <div class="perfil-highlight-item">
            <span class="perfil-highlight-icon"><i class="bi bi-diagram-3"></i></span>
            <span class="perfil-highlight-text">Soluciones end-to-end: front-end, back-end y base de datos.</span>
          </div>
          <div class="perfil-highlight-item">
            <span class="perfil-highlight-icon"><i class="bi bi-shield-check"></i></span>
            <span class="perfil-highlight-text">Buenas prácticas, seguridad y código mantenible.</span>
          </div>
          <div class="perfil-highlight-item">
            <span class="perfil-highlight-icon"><i class="bi bi-lightning-charge"></i></span>
            <span class="perfil-highlight-text">Entrega rápida con foco en impacto y resultados.</span>
          </div>
          <div class="perfil-highlight-item">
            <span class="perfil-highlight-icon"><i class="bi bi-people"></i></span>
            <span class="perfil-highlight-text">Comunicación clara y acompañamiento durante el proyecto.</span>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- container -->
</section> <!-- Mi Perfil -->

<!-- Habilidades Técnicas -->
<section class="section section-tech-skills">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="display-5 fw-bold mb-3 text-white">Habilidades Técnicas</h2>
      <p class="mb-4 text-white">Mi recorrido profesional me ha permitido dominar distintas tecnologías, las cuales he integrado en proyectos que puedes conocer mejor en la sección. <a href="<?= $base ?>/portfolio.php" class="link-accent text-white" style="text-decoration: underline;">Portafolio</a>.</p>
    </div>  
    <?php
    $techCards = [
      ['java.png','Java','Lenguaje OOP para back-end, Android y apps empresariales.'],
      ['php.png','PHP','Scripts del lado del servidor y CMS.'],
      ['html5.png','HTML5','Estructura semántica de la web.'],
      ['javascript.png','JavaScript','Interactividad en navegador y apps full-stack.'],
      ['css3.png','CSS3','Estilos responsivos y animaciones modernas.'],
      ['piton.png','Python','Automatización, ciencia de datos y back-end.'],
      ['mysql.png','MySQL','Base de datos relacional.'],
      ['oracle.png','Oracle','Gestor de bases de datos empresariales.'],
      ['kotlin.png','Kotlin','Desarrollo moderno para Android.'],
      ['androide.png','Android','Framework y SO para apps móviles.']
    ];
    ?>
    <div class="tech-skills-grid text-center">    
      <?php foreach ($techCards as $t): ?>
      <div class="tech-skill-item">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body">
            <img src="<?= $base ?>/assets/tech/<?= $t[0] ?>" alt="<?= $t[1] ?>" height="72" class="mb-1" loading="lazy" decoding="async">
            <h6 class="fw-bold mb-1"><?= $t[1] ?></h6>
            <p class="card-text small tech-description"><?= $t[2] ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- Educación y Certificaciones -->
<section class="section section-light" id="educacion">
  <div class="container container-narrow">
    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold mb-3">Educación & Certificaciones</h2>
      <p class="lead text-muted">Mi formación académica y profesional</p>
    </div>

    <div class="text-center mb-3">
      <p class="mb-0" style="font-weight:700;color:#1a202c;">Formación académica</p>
    </div>

    <div class="education-grid">
      <!-- Primera tarjeta: Ingeniero en Informática (ocupa toda la fila) -->
      <div class="education-item education-item-full">
        <div class="card border-0 shadow-sm education-card-ingenieria">
          <div class="card-body p-2">
            <div class="text-center mb-2">
              <img src="<?= $base ?>/assets/img/universidad.webp" alt="Universidad Politécnica Territorial de Valencia" height="100" loading="lazy" decoding="async">
            </div>
            <h5 class="fw-bold text-center mb-1" style="font-size: 1.25rem;">Ingeniero en Informática</h5>
            <p class="text-center mb-1 fw-bold" style="font-size: 1rem;">Universidad Politécnica Territorial de Valencia</p>
            <p class="text-center mb-2"><span class="badge bg-primary">2015</span></p>
            <p class="small mb-0" style="font-size: 0.95rem; line-height: 1.5;">Administrar proyectos informáticos bajo estándares de calidad y pertinencia social. Auditar sistemas informáticos, desarrollar e implantar software, priorizando el uso de plataformas libres. Integrar y optimizar sistemas informáticos, diseñar, implementar y administrar bases de datos, así como redes informáticas, priorizando el uso de software libre.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5 cert-section-wrap" id="certificados">
      <div class="cert-section-dark">
        <div class="container container-narrow">
          <div class="text-center mb-4">
            <h3 class="fw-bold mb-2 cert-section-title">Certificados</h3>
            <p class="mb-0 cert-section-subtitle">Certificados (cursos) · Platzi y otros</p>
          </div>

      <?php
        $certificates = [
          [
            'file' => 'Certificado Git y GitHub.webp',
            'title' => 'Git y GitHub',
            'provider' => 'Platzi',
            'category' => 'desarrollo',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/12139-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Fundamentos de Python.webp',
            'title' => 'Fundamentos de Python',
            'provider' => 'Platzi',
            'category' => 'desarrollo',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/12164-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Fundamentos de Ingeniería de Software.webp',
            'title' => 'Fundamentos de Ingeniería de Software',
            'provider' => 'Platzi',
            'category' => 'desarrollo',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/11997-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Introducción a la Inteligencia Artificial.webp',
            'title' => 'Introducción a la Inteligencia Artificial',
            'provider' => 'Platzi',
            'category' => 'ia',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/12286-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Prompt Engineering.webp',
            'title' => 'Prompt Engineering',
            'provider' => 'Platzi',
            'category' => 'ia',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/11059-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Fundamentos de LLMs.webp',
            'title' => 'Fundamentos de LLMs',
            'provider' => 'Platzi',
            'category' => 'ia',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/11944-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Supabase.webp',
            'title' => 'Supabase',
            'provider' => 'Platzi',
            'category' => 'desarrollo',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/12323-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Windsurf AI.webp',
            'title' => 'Windsurf AI',
            'provider' => 'Platzi',
            'category' => 'ia',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/12544-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Inglés Básico A1 para Principiantes.webp',
            'title' => 'Inglés Básico A1 para Principiantes',
            'provider' => 'Platzi',
            'category' => 'idiomas',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/12298-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Inglés Básico A1 Verbo To Be.webp',
            'title' => 'Inglés Básico A1: Verbo To Be',
            'provider' => 'Platzi',
            'category' => 'idiomas',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/10629-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Estrategias para Aprender Inglés en Línea.webp',
            'title' => 'Estrategias para Aprender Inglés en Línea',
            'provider' => 'Platzi',
            'category' => 'idiomas',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/12290-course/diploma/detalle/'
          ],
          [
            'file' => 'Certificado Fundamentos de Matemáticas.webp',
            'title' => 'Fundamentos de Matemáticas',
            'provider' => 'Platzi',
            'category' => 'otros',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/11157-course/diploma/detalle/'
          ],

          [
            'file' => 'Diplomado Programación Java.webp',
            'title' => 'Diplomado Programación Java',
            'provider' => 'Politécnico de Colombia',
            'category' => 'desarrollo',
            'url' => null
          ],
          [
            'file' => 'Certificado Administrador de bases de datos.webp',
            'title' => 'Administrador de bases de datos',
            'provider' => 'Fundación Carlos Slim',
            'category' => 'desarrollo',
            'url' => null
          ],
          [
            'file' => 'Seminario Gestión de Proyectos.webp',
            'title' => 'Seminario Gestión de Proyectos',
            'provider' => 'Seminario',
            'category' => 'otros',
            'url' => null
          ],
        ];

        $certCategories = [
          'all' => 'Todos',
          'desarrollo' => 'Desarrollo',
          'ia' => 'IA',
          'idiomas' => 'Idiomas',
          'otros' => 'Otros'
        ];

        $certFolder = $base . '/assets/certificados/';
      ?>

          <div class="cert-filter" role="tablist" aria-label="Filtrar certificados">
        <?php foreach ($certCategories as $key => $label): ?>
          <button type="button" class="cert-pill<?= $key === 'all' ? ' active' : '' ?>" data-cert-filter="<?= htmlspecialchars($key, ENT_QUOTES) ?>">
            <?= htmlspecialchars($label, ENT_QUOTES) ?>
          </button>
        <?php endforeach; ?>
      </div>

          <div class="cert-grid" id="cert-grid">
        <?php foreach ($certificates as $c): ?>
          <?php
            $imgUrl = $certFolder . rawurlencode($c['file']);
            $title = $c['title'];
            $provider = $c['provider'];
            $cat = $c['category'];
            $link = $c['url'];
          ?>
          <button
            type="button"
            class="cert-card"
            data-cert-category="<?= htmlspecialchars($cat, ENT_QUOTES) ?>"
            data-cert-img="<?= htmlspecialchars($imgUrl, ENT_QUOTES) ?>"
            data-cert-title="<?= htmlspecialchars($title, ENT_QUOTES) ?>"
            data-cert-provider="<?= htmlspecialchars($provider, ENT_QUOTES) ?>"
            data-cert-url="<?= htmlspecialchars($link ?? '', ENT_QUOTES) ?>"
          >
            <span class="cert-thumb-wrap">
              <img src="<?= htmlspecialchars($imgUrl, ENT_QUOTES) ?>" alt="<?= htmlspecialchars($title, ENT_QUOTES) ?>" loading="lazy" decoding="async">
            </span>
            <span class="cert-meta">
              <span class="cert-title"><?= htmlspecialchars($title, ENT_QUOTES) ?></span>
              <span class="cert-provider"><?= htmlspecialchars($provider, ENT_QUOTES) ?></span>
            </span>
          </button>
        <?php endforeach; ?>
      </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="cert-modal" id="certModal" aria-hidden="true">
  <div class="cert-modal-backdrop" data-cert-close></div>
  <div class="cert-modal-dialog" role="dialog" aria-modal="true" aria-label="Certificado">
    <button type="button" class="cert-modal-close" data-cert-close aria-label="Cerrar">×</button>
    <div class="cert-modal-header">
      <div class="cert-modal-title" id="certModalTitle"></div>
      <div class="cert-modal-sub" id="certModalProvider"></div>
    </div>
    <div class="cert-modal-body">
      <img id="certModalImg" alt="" />
    </div>
    <div class="cert-modal-actions">
      <a id="certModalOpen" class="btn btn-outline-primary" href="#" target="_blank" rel="noopener" style="display:none;">Abrir en nueva pestaña</a>
      <a id="certModalPlatzi" class="btn btn-primary" href="#" target="_blank" rel="noopener" style="display:none;">Ver credencial</a>
    </div>
  </div>
</div>

<!-- Call to Action 
<section class="section bg-dark text-light" id="cta">
  <div class="container text-center">
    <h2 class="display-5 fw-bold mb-3">¿Listo para trabajar juntos?</h2>
    <p class="lead mb-4">Convirtamos tu idea en una solución digital exitosa</p>
    <div class="d-flex gap-3 justify-content-center flex-wrap">
      <a href="<?= $base ?>/contact.php" class="btn btn-accent btn-lg">
        <i class="bi bi-envelope me-2"></i>Iniciar Proyecto
      </a>
      <a href="<?= $base ?>/portfolio.php" class="btn btn-outline-light btn-lg">
        <i class="bi bi-eye me-2"></i>Ver Portafolio
      </a>
    </div>
  </div>
</section>
-->
<style>
/* Estilos específicos para la página About */

.cert-filter{display:flex;flex-wrap:wrap;gap:.5rem;justify-content:center;margin-bottom:1rem;}
.cert-section-wrap{background:#1a202c;margin-left:calc(50% - 50vw);margin-right:calc(50% - 50vw);padding:3rem 0;}
.cert-section-dark{background:transparent;padding:0;border-radius:0;}
.cert-section-title{color:#f8fafc;font-size:clamp(1.8rem, 1.2rem + 1.6vw, 2.4rem);letter-spacing:.2px;}
.cert-section-subtitle{color:#e2e8f0;font-size:1rem;line-height:1.6;}
.cert-pill{appearance:none;border:1px solid rgba(255,255,255,.22);background:rgba(255,255,255,.06);color:#fff;padding:.45rem .75rem;border-radius:999px;font-weight:600;font-size:.95rem;cursor:pointer;}
.cert-pill:hover{background:rgba(255,255,255,.10);} 
.cert-pill.active{background:#0d6efd;color:#fff;border-color:#0d6efd;}
.cert-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;}
@media (min-width:768px){.cert-grid{grid-template-columns:repeat(3,minmax(0,1fr));}}
@media (min-width:992px){.cert-grid{grid-template-columns:repeat(4,minmax(0,1fr));}}
.cert-card{border:1px solid rgba(0,0,0,.08);background:#fff;border-radius:.85rem;overflow:hidden;cursor:pointer;text-align:left;padding:0;display:flex;flex-direction:column;min-height:100%;box-shadow:0 .25rem .75rem rgba(0,0,0,.06);transition:transform .2s ease, box-shadow .2s ease;border:0;}
.cert-card:hover{transform:translateY(-3px);box-shadow:0 .6rem 1.5rem rgba(0,0,0,.12);} 
.cert-thumb-wrap{display:block;background:linear-gradient(135deg, #f8f9fa 0%, #eef2ff 100%);padding:.5rem;}
.cert-thumb-wrap img{width:100%;height:160px;object-fit:contain;display:block;background:#fff;border-radius:.5rem;}
.cert-meta{display:flex;flex-direction:column;gap:.2rem;padding:.75rem .85rem;}
.cert-title{font-weight:700;color:#0b0f19;font-size:.95rem;line-height:1.2;}
.cert-provider{color:#6c757d;font-size:.85rem;}

.cert-modal{position:fixed;inset:0;display:none;align-items:center;justify-content:center;z-index:2000;padding:1rem;}
.cert-modal.is-open{display:flex;}
.cert-modal-backdrop{position:absolute;inset:0;background:rgba(0,0,0,.65);} 
.cert-modal-dialog{position:relative;background:#fff;border-radius:1rem;max-width:min(980px, 96vw);max-height:86vh;overflow:auto;box-shadow:0 1rem 3rem rgba(0,0,0,.35);padding:1rem;}
.cert-modal-close{position:absolute;top:.75rem;right:.75rem;width:42px;height:42px;border-radius:999px;border:0;background:rgba(0,0,0,.06);font-size:1.6rem;line-height:1;cursor:pointer;}
.cert-modal-header{padding:.25rem 2.75rem .75rem .25rem;}
.cert-modal-title{font-weight:800;font-size:1.1rem;color:#0b0f19;}
.cert-modal-sub{color:#6c757d;font-size:.9rem;}
.cert-modal-body{display:flex;justify-content:center;}
.cert-modal-body img{width:100%;height:auto;max-height:62vh;display:block;border-radius:.75rem;background:#fff;object-fit:contain;}
.cert-modal-actions{display:flex;flex-wrap:wrap;gap:.5rem;justify-content:flex-end;margin-top:.85rem;}

@media (min-width: 992px){
  .cert-modal-body img{max-height:55vh;}
}

@media print{
  .cert-filter,.cert-grid,.cert-modal{display:none !important;}
}

/* Sección Mi Perfil con fondo sólido claro */
.section-mi-perfil {
  background-color: #f8f9fa !important;
}

.perfil-paragraph{font-size:1.05rem;line-height:1.75;color:#495057;margin:0 0 .95rem;}
.perfil-paragraph strong{color:#2d3748;}

.perfil-highlights{background:#ffffff;border:1px solid rgba(15,23,42,.08);border-radius:1rem;box-shadow:0 .6rem 1.6rem rgba(15,23,42,.08);padding:1.1rem 1.1rem;}
.perfil-highlights-title{font-weight:800;color:#1a202c;font-size:1.05rem;margin-bottom:.85rem;letter-spacing:.2px;}
.perfil-highlight-item{display:flex;gap:.65rem;align-items:flex-start;padding:.55rem .2rem;border-top:1px solid rgba(15,23,42,.06);}
.perfil-highlight-item:first-of-type{border-top:0;padding-top:0;}
.perfil-highlight-icon{width:38px;height:38px;border-radius:.85rem;background:linear-gradient(135deg, rgba(13,110,253,.12), rgba(253,126,20,.10));display:flex;align-items:center;justify-content:center;flex:0 0 auto;color:#0d6efd;}
.perfil-highlight-icon i{font-size:1.15rem;}
.perfil-highlight-text{font-size:.95rem;line-height:1.5;color:#4a5568;}

@media (max-width: 991.98px){
  .perfil-highlights{margin-top:1.25rem;}
}

/* About hero: avoid cropped profile image on desktop */
@media (min-width: 992px){
  .hero.hero-compact picture{flex:0 0 auto;}
  .hero.hero-compact .profile-img{height:auto !important;max-height:320px !important;width:200px !important;object-fit:contain;}
}

/* About: two-column layout for Mi Perfil (Bootstrap grid is not loaded here) */
#mi-perfil .row{display:grid;grid-template-columns:1fr;gap:2rem;}
@media (min-width: 992px){
  #mi-perfil .row{grid-template-columns:2fr 1fr;align-items:start;}
}
#mi-perfil .col-lg-8,#mi-perfil .col-lg-4{width:auto;}

.section-mi-perfil h2 {
  color: #1a202c !important;
}

.section-mi-perfil p {
  color: #4a5568 !important;
}

.section-mi-perfil .lead {
  color: #2d3748 !important;
}

/* Sección de habilidades técnicas con fondo oscuro */
.section-tech-skills {
  background-color: #1a202c !important;
  padding: 3rem 0 !important;
}

/* Textos blancos en la sección */
.section-tech-skills h2,
.section-tech-skills p,
.section-tech-skills a {
  color: #ffffff !important;
}

.section-tech-skills .lead {
  color: #e2e8f0 !important;
}

/* Grid de educación - Primera tarjeta ocupa toda la fila, las otras dos lado a lado */
.education-grid {
  display: grid;
  gap: 1.5rem;
  grid-template-columns: 1fr;
}

@media (min-width: 992px) {
  .education-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .education-item-full {
    grid-column: 1 / -1; /* Ocupa ambas columnas */
  }
}

/* Tarjeta Ingeniero en Informática con fondo naranja claro */
.education-card-ingenieria {
  background: linear-gradient(135deg, #fff0e0 0%, #ffd9a8 100%) !important;
  border: 1px solid #ffb366 !important;
}

.education-card-ingenieria h5,
.education-card-ingenieria p {
  color: #2c3e50 !important;
}

/* Tarjeta Diplomado Java con fondo amarillo/dorado */
.education-card-java {
  background: linear-gradient(135deg, #fef9e6 0%, #f5e6a8 100%) !important;
  border: 1px solid #d4af37 !important;
}

.education-card-java h5,
.education-card-java p {
  color: #2c3e50 !important;
}

/* Tarjeta Administrador BD con fondo turquesa/verde azulado */
.education-card-slim {
  background: linear-gradient(135deg, #d4f1f4 0%, #75d0d8 100%) !important;
  border: 1px solid #17a2b8 !important;
}

.education-card-slim h5,
.education-card-slim p {
  color: #2c3e50 !important;
}

/* Efecto hover para todas las tarjetas de educación */
.education-card-ingenieria,
.education-card-java,
.education-card-slim {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.education-card-ingenieria:hover,
.education-card-java:hover,
.education-card-slim:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

.ingenieria-layout {
  display: grid;
  grid-template-columns: 50px 1fr;
  gap: 1rem;
  align-items: start;
}

.ingenieria-logo {
  width: 50px;
  height: auto;
  display: block;
}

.ingenieria-content {
  min-width: 0;
}

.ingenieria-header {
  margin-bottom: 0.5rem;
  line-height: 1.8;
}

.ingenieria-title {
  font-size: 1.15rem;
  color: #212529;
}

.ingenieria-university {
  font-size: 0.95rem;
  color: #495057;
}

.ingenieria-separator {
  color: #6c757d;
  margin: 0 0.5rem;
}

.ingenieria-description {
  font-size: 0.875rem;
  color: #6c757d;
  margin: 0;
  line-height: 1.5;
}

/* Estilos para las tarjetas de tecnologías */
.tech-skills-grid .card h6 {
  font-size: 1.05rem !important; /* Tamaño del nombre */
  color: #212529 !important; /* Negro */
  margin-bottom: 0.25rem !important; /* Espacio muy reducido */
}

.tech-skills-grid .card img {
  margin-bottom: 0.35rem !important; /* Espacio mínimo bajo el icono */
}

.tech-skills-grid .card .tech-description {
  color: #000000 !important; /* Negro puro para mejor legibilidad */
  margin-bottom: 0 !important; /* Eliminar margen inferior */
  font-size: 0.78rem !important; /* Texto más pequeño */
  line-height: 1.25 !important; /* Interlineado muy compacto */
}

.tech-skills-grid .card-body {
  padding: 0.75rem 0.6rem !important; /* Padding mínimo */
}

/* Efecto hover para tarjetas de habilidades técnicas */
.tech-skills-grid .card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.tech-skills-grid .card:hover {
  transform: translateY(-6px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.timeline-container {
  position: relative;
  padding-left: 2rem;
}

.timeline-container::before {
  content: '';
  position: absolute;
  left: 1rem;
  top: 0;
  bottom: 0;
  width: 2px;
  background: linear-gradient(to bottom, #0d6efd, #6f42c1);
}

.timeline-item {
  position: relative;
  margin-bottom: 3rem;
}

.timeline-marker {
  position: absolute;
  left: -2.5rem;
  top: 0;
  width: 3rem;
  height: 3rem;
  background: #fff;
  border: 3px solid #0d6efd;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  color: #0d6efd;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.timeline-content {
  background: #fff;
  padding: 1.5rem;
  border-radius: 0.5rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  border-left: 4px solid #0d6efd;
}

.timeline-date {
  color: #6c757d;
  font-weight: 600;
  font-size: 0.9rem;
  margin-bottom: 0.5rem;
}

.tech-stack .badge {
  font-size: 0.75rem;
}

.education-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.education-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.education-icon i {
  font-size: 2.5rem;
}

.process-step {
  position: relative;
}

.process-icon {
  position: relative;
  display: inline-block;
}

.step-number {
  position: absolute;
  top: -10px;
  right: -10px;
  background: #fd7e14;
  color: white;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
  font-weight: bold;
}

.process-icon i {
  font-size: 2.5rem;
  color: #0d6efd;
}

.interest-item i {
  font-size: 2.5rem;
  display: block;
}

.stat-item h3 {
  font-size: 2rem;
  font-weight: bold;
}

.progress-bar {
  transition: width 1.5s ease-in-out;
}

.bg-purple {
  background-color: #6f42c1 !important;
}

</style>

<script>
(function(){
  var pills = Array.prototype.slice.call(document.querySelectorAll('[data-cert-filter]'));
  var cards = Array.prototype.slice.call(document.querySelectorAll('.cert-card'));
  var modal = document.getElementById('certModal');
  var modalImg = document.getElementById('certModalImg');
  var modalTitle = document.getElementById('certModalTitle');
  var modalProvider = document.getElementById('certModalProvider');
  var modalOpen = document.getElementById('certModalOpen');
  var modalPlatzi = document.getElementById('certModalPlatzi');

  function setActivePill(key){
    pills.forEach(function(p){
      var isActive = p.getAttribute('data-cert-filter') === key;
      p.classList.toggle('active', isActive);
    });
  }

  function applyFilter(key){
    setActivePill(key);
    cards.forEach(function(c){
      var cat = c.getAttribute('data-cert-category');
      var show = (key === 'all') || (cat === key);
      c.style.display = show ? '' : 'none';
    });
  }

  function openModal(card){
    var img = card.getAttribute('data-cert-img') || '';
    var title = card.getAttribute('data-cert-title') || '';
    var provider = card.getAttribute('data-cert-provider') || '';
    var url = card.getAttribute('data-cert-url') || '';

    modalImg.src = img;
    modalImg.alt = title;
    modalTitle.textContent = title;
    modalProvider.textContent = provider;

    modalOpen.style.display = img ? '' : 'none';
    modalOpen.href = img || '#';

    if(url){
      modalPlatzi.style.display = '';
      modalPlatzi.href = url;
    }else{
      modalPlatzi.style.display = 'none';
      modalPlatzi.href = '#';
    }

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeModal(){
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  pills.forEach(function(p){
    p.addEventListener('click', function(){
      applyFilter(p.getAttribute('data-cert-filter'));
    });
  });

  cards.forEach(function(c){
    c.addEventListener('click', function(){
      openModal(c);
    });
  });

  modal.addEventListener('click', function(e){
    if(e.target && e.target.hasAttribute('data-cert-close')) closeModal();
  });

  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
  });

  applyFilter('all');
})();
</script>

<?php include 'includes/footer.php'; ?>