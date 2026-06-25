<?php include 'includes/header.php'; ?>

<section class="hero section d-flex align-items-center cv-hero" style="background:url('<?= $base ?>/assets/img/resume_hero.webp') center/cover no-repeat; min-height:34vh;">
  <div class="hero-content text-center">
    <div class="container">
      <h1 class="display-4 fw-bold mb-2">Currículum</h1>
      <p class="lead mb-0">Versión corta, lista para imprimir y descargar</p>
    </div>
  </div>
</section>

<section class="section" id="cv-page">
  <div class="container container-narrow">
    <div class="cv-actions" style="display:flex; gap:.5rem; flex-wrap:wrap; justify-content:flex-end; margin-bottom:1rem;">
      <?php
        $pdfEs = __DIR__ . '/assets/cv/JoelCadenasCV.pdf';
        $pdfEn = __DIR__ . '/assets/cv/Joel_Cadenas_Resume_EN.pdf';
      ?>
      <?php if (file_exists($pdfEs)): ?>
        <a class="btn btn-sm cv-btn cv-btn-outline" href="<?= $base ?>/assets/cv/JoelCadenasCV.pdf" target="_blank" rel="noopener">
          <i class="bi bi-download me-2"></i>Descargar PDF (ES)
        </a>
      <?php endif; ?>
      <?php if (file_exists($pdfEn)): ?>
        <a class="btn btn-sm cv-btn cv-btn-outline" href="<?= $base ?>/assets/cv/Joel_Cadenas_Resume_EN.pdf" target="_blank" rel="noopener">
          <i class="bi bi-download me-2"></i>Download PDF (EN)
        </a>
      <?php endif; ?>
      <button class="btn btn-sm cv-btn cv-btn-solid" type="button" onclick="window.print()">
        <i class="bi bi-printer me-2"></i>Imprimir / Guardar PDF
      </button>
    </div>

    <header class="cv-header" style="display:flex; gap:1rem; justify-content:space-between; flex-wrap:wrap; align-items:flex-start; margin-bottom:1rem;">
      <div>
        <h1 class="mb-2" style="font-size:2.1rem; line-height:1.15;">Joel Cadenas</h1>
        <div class="text-muted" style="font-size:1.1rem; font-weight:700;">Software Developer (Android · Web · Desktop)</div>
        <div class="text-muted" style="margin-top:.25rem;">Bogotá, Colombia (Disponible remoto)</div>
      </div>
      <div class="cv-contact" style="min-width:260px;">
        <div class="cv-contact-grid">
          <a class="cv-contact-item" href="mailto:ing.jcadenas@gmail.com">
            <span class="cv-contact-ico"><i class="bi bi-envelope"></i></span>
            <span class="cv-contact-text">
              <span class="cv-contact-label">Correo</span>
              <span class="cv-contact-value">ing.jcadenas@gmail.com</span>
            </span>
          </a>
          <a class="cv-contact-item" href="https://wa.me/573177564861" target="_blank" rel="noopener">
            <span class="cv-contact-ico"><i class="bi bi-whatsapp"></i></span>
            <span class="cv-contact-text">
              <span class="cv-contact-label">WhatsApp</span>
              <span class="cv-contact-value">+57 317 756 4861</span>
            </span>
          </a>
          <a class="cv-contact-item" href="https://github.com/jcadenasSoftware" target="_blank" rel="noopener">
            <span class="cv-contact-ico"><i class="bi bi-github"></i></span>
            <span class="cv-contact-text">
              <span class="cv-contact-label">GitHub</span>
              <span class="cv-contact-value">jcadenasSoftware</span>
            </span>
          </a>
          <a class="cv-contact-item" href="https://jcadenas.com" target="_blank" rel="noopener">
            <span class="cv-contact-ico"><i class="bi bi-globe"></i></span>
            <span class="cv-contact-text">
              <span class="cv-contact-label">Sitio web</span>
              <span class="cv-contact-value">jcadenas.com</span>
            </span>
          </a>
        </div>
      </div>
    </header>

    <section class="cv-section" style="margin-bottom:1rem;">
      <h2 class="cv-title">Resumen</h2>
      <p style="margin:0;">Software Developer con experiencia en desarrollo Android (Kotlin), aplicaciones de escritorio en Java y plataformas web con backend propio. Especializado en construir soluciones end-to-end (frontend, backend y base de datos), integrando servicios cloud, autenticación segura, geolocalización y sincronización en tiempo real. Trabajo bajo buenas prácticas modernas como MVVM, Clean Architecture y principios SOLID, priorizando código mantenible, escalable y orientado a resultados.</p>
    </section>

    <section class="cv-section" style="margin-bottom:1rem;">
      <h2 class="cv-title">Habilidades</h2>
      <div class="cv-grid">
        <div><strong>Android:</strong> Kotlin, Jetpack Compose, MVVM, Room, GPS</div>
        <div><strong>Web:</strong> PHP, MySQL, HTML5, CSS3, JavaScript, Bootstrap</div>
        <div><strong>Desktop:</strong> Java, JavaFX, iReport/Jasper</div>
        <div><strong>Cloud:</strong> Firebase Authentication, Firebase Storage, Firebase (sincronización)</div>
        <div><strong>Arquitectura:</strong> Clean Architecture, SOLID</div>
      </div>
    </section>

    <section class="cv-section" style="margin-bottom:1rem;">
      <h2 class="cv-title">Proyectos destacados</h2>

      <article class="cv-item">
        <div class="cv-item-head">
          <div>
            <div class="cv-item-role">Mis Finanzas — Multiplataforma (Android + Desktop)</div>
            <div class="cv-item-links">
              <a href="https://github.com/jcadenasSoftware/mis-finanzas-apk" target="_blank" rel="noopener">GitHub Android</a>
              <span class="sep">|</span>
              <a href="https://github.com/jcadenasSoftware/mis-finanzas-msi-Java" target="_blank" rel="noopener">GitHub Desktop</a>
            </div>
          </div>
          <div class="cv-item-tech">Kotlin · Compose · MVVM · Room · Firebase · JavaFX</div>
        </div>
        <ul class="cv-bullets">
          <li>Sistema financiero multiplataforma con Android (Kotlin/Compose) y Desktop (JavaFX).</li>
          <li>Login con Firebase Authentication y sincronización cloud con Firebase para uso multiplataforma (móvil y computador).</li>
          <li>Módulos: cuentas, transacciones, transferencias, reportes gráficos y multiusuarios.</li>
        </ul>
      </article>

      <article class="cv-item">
        <div class="cv-item-head">
          <div>
            <div class="cv-item-role">Busca tu Mascota (Android) + Web informativa</div>
            <div class="cv-item-links">
              <a href="https://buscamostumascota.com" target="_blank" rel="noopener">buscamostumascota.com</a>
              <span class="sep">|</span>
              <a href="https://github.com/JcadenasSoftware/lost_pets" target="_blank" rel="noopener">GitHub</a>
            </div>
          </div>
          <div class="cv-item-tech">Kotlin · Jetpack Compose · Firebase · GPS · PHP · MySQL</div>
        </div>
        <ul class="cv-bullets">
          <li>Plataforma para publicación de mascotas perdidas/encontradas con geolocalización y mapa interactivo.</li>
          <li>Chat en tiempo real entre usuarios y generación de códigos QR.</li>
          <li>Autenticación segura con Firebase Authentication y sincronización de datos con Firebase.</li>
        </ul>
      </article>

      <article class="cv-item">
        <div class="cv-item-head">
          <div>
            <div class="cv-item-role">marysbelleza.com — Web en producción</div>
            <div class="cv-item-links">
              <a href="https://marysbelleza.com" target="_blank" rel="noopener">marysbelleza.com</a>
            </div>
          </div>
          <div class="cv-item-tech">PHP · MySQL · JavaScript · Bootstrap · SEO · Analytics</div>
        </div>
        <ul class="cv-bullets">
          <li>Sitio web en producción con panel admin para gestión de contenido y publicaciones.</li>
          <li>Sistema de interacción pública con comentarios y valoración por estrellas.</li>
          <li>Formulario con envío de email, SEO e integración de Analytics.</li>
        </ul>
      </article>

      <article class="cv-item">
        <div class="cv-item-head">
          <div>
            <div class="cv-item-role">Plataformas web de Hosting Productive</div>
            <div class="cv-item-links">
              <a href="https://jcadenas.com" target="_blank" rel="noopener">jcadenas.com</a>
              <span class="sep">|</span>
              <a href="https://marysbelleza.com" target="_blank" rel="noopener">marysbelleza.com</a>
            </div>
          </div>
          <div class="cv-item-tech">PHP · MySQL · Panel administrativo</div>
        </div>
        <ul class="cv-bullets">
          <li>Sitios web en producción con portafolio y dashboard administrativo.</li>
          <li>Back-end con base de datos MySQL y panel administrativo propio.</li>
        </ul>
      </article>

      <article class="cv-item">
        <div class="cv-item-head">
          <div>
            <div class="cv-item-role">Java Desktop — Sistema de inventarios</div>
            <div class="cv-item-links">
              <a href="https://github.com/jcadenasSoftware/Sistema-de-Inventarios-Java" target="_blank" rel="noopener">GitHub</a>
            </div>
          </div>
          <div class="cv-item-tech">Java · MySQL · iReport/Jasper</div>
        </div>
        <ul class="cv-bullets">
          <li>Sistema contable/inventarios con generación de libros y reportes.</li>
        </ul>
      </article>
    </section>

    <section class="cv-section" style="margin-bottom:1rem;">
      <h2 class="cv-title">Educación</h2>
      <div class="cv-row">
        <div><strong>Ingeniero en Informática</strong> — 2009 - 2015</div>
        <div style="margin-top:.35rem;"><strong>Diplomado en Programación en Java</strong> — 2017 - 2018</div>
      </div>
      <div style="margin-top:.6rem; display:flex; flex-wrap:wrap; gap:.65rem; align-items:center;">
        <a class="cv-edu-link" href="<?= $base ?>/about.php#certificados">Ver certificados</a>
        <div class="cv-cert-thumbs" aria-label="Certificados">
          <button class="cv-cert-thumb" type="button" data-img="<?= $base ?>/assets/img/universidad.webp" aria-label="Ver certificado: Universidad">
            <img src="<?= $base ?>/assets/img/universidad.webp" alt="Universidad" loading="lazy" decoding="async">
          </button>
          <button class="cv-cert-thumb" type="button" data-img="<?= $base ?>/assets/img/poliCol.png" aria-label="Ver certificado: Politécnico de Colombia">
            <img src="<?= $base ?>/assets/img/poliCol.png" alt="Politécnico de Colombia" loading="lazy" decoding="async">
          </button>
          <button class="cv-cert-thumb" type="button" data-img="<?= $base ?>/assets/img/slim.png" aria-label="Ver certificado: Fundación Carlos Slim">
            <img src="<?= $base ?>/assets/img/slim.png" alt="Fundación Carlos Slim" loading="lazy" decoding="async">
          </button>
        </div>
      </div>

      <div style="margin-top:.75rem;">
        <div style="font-weight:800;color:var(--cv-primary);margin-bottom:.25rem;">Certificados relevantes</div>
        <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
          <a class="cv-chip" href="<?= $base ?>/about.php#certificados">Git y GitHub</a>
          <a class="cv-chip" href="<?= $base ?>/about.php#certificados">Fundamentos de Python</a>
          <a class="cv-chip" href="<?= $base ?>/about.php#certificados">Fundamentos de Ingeniería de Software</a>
          <a class="cv-chip" href="<?= $base ?>/about.php#certificados">Introducción a la IA</a>
          <a class="cv-chip" href="<?= $base ?>/about.php#certificados">Fundamentos de LLMs</a>
        </div>
      </div>

      <div class="cv-lightbox" id="cv-lightbox" aria-hidden="true">
        <div class="cv-lightbox-backdrop" data-close="1"></div>
        <div class="cv-lightbox-dialog" role="dialog" aria-modal="true" aria-label="Certificado">
          <button class="cv-lightbox-close" type="button" data-close="1" aria-label="Cerrar">×</button>
          <img class="cv-lightbox-img" alt="Certificado" src="" decoding="async">
        </div>
      </div>
    </section>

    <section class="cv-section" style="margin-bottom:1rem;">
      <h2 class="cv-title">Idiomas</h2>
      <div class="cv-grid">
        <div><strong>Español:</strong> Nativo</div>
        <div><strong>Inglés:</strong> A2 (Básico)</div>
      </div>
    </section>

  </div>
</section>

<style>
  #cv-page{
    --cv-primary:#0F172A;
    --cv-primary-2:#1E293B;
    --cv-accent:#2563EB;
    --cv-gray:#E5E7EB;
    --cv-black:#0B0F19;
    --cv-shadow:0 .25rem .75rem rgba(15, 23, 42, .08);
    background:#f8f9fa;
    color:var(--cv-black);
  }
  #cv-page .container{padding-top:.5rem;}
  #cv-page a{color:var(--cv-accent);}
  #cv-page .cv-actions .btn{border-width:2px;}
  #cv-page .cv-btn{border-radius:.75rem;font-weight:800;letter-spacing:.01em;padding:.45rem .75rem;}
  #cv-page .cv-btn-outline{border:2px solid rgba(37,99,235,.55);color:var(--cv-accent);background:#fff;}
  #cv-page .cv-btn-outline:hover{background:rgba(37,99,235,.08);border-color:rgba(37,99,235,.85);}
  #cv-page .cv-btn-solid{border:2px solid var(--cv-accent);background:var(--cv-accent);color:#fff;}
  #cv-page .cv-btn-solid:hover{filter:brightness(.95);}
  #cv-page .cv-header{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:.9rem;padding:1rem 1.1rem;box-shadow:var(--cv-shadow);}
  #cv-page .cv-contact{font-size:.98rem;}
  #cv-page .cv-section{background:#fff;border:1px solid rgba(15,23,42,.08);border-radius:.9rem;padding:.9rem 1rem;box-shadow:var(--cv-shadow);}
  #cv-page .cv-section + .cv-section{margin-top:.9rem;}
  #cv-page .cv-title{display:flex;align-items:center;gap:.55rem;font-size:1.02rem;margin:0 0 .6rem 0;padding:0;text-transform:uppercase;letter-spacing:.10em;color:var(--cv-primary);}
  #cv-page .cv-title::before{content:"";width:10px;height:10px;border-radius:999px;background:var(--cv-accent);box-shadow:0 0 0 .2rem rgba(37,99,235,.18);}
  #cv-page p{line-height:1.7;color:#495057;}
  #cv-page .cv-bullets{color:#495057;}
  #cv-page .cv-grid{display:grid;grid-template-columns:1fr;gap:.35rem;}
  @media(min-width:768px){#cv-page .cv-grid{grid-template-columns:1fr 1fr;gap:.35rem 1.25rem;}}
  #cv-page .cv-item{border:1px solid rgba(15,23,42,.08);border-radius:.9rem;padding:.85rem 1rem;margin:.75rem 0;background:#fff;box-shadow:var(--cv-shadow);}
  #cv-page .cv-item-head{display:flex;gap:1rem;justify-content:space-between;flex-wrap:wrap;align-items:flex-start;}
  #cv-page .cv-item-role{font-weight:800;}
  #cv-page .cv-item-tech{color:#6c757d;font-weight:600;}
  #cv-page .cv-item-links{color:#6c757d;font-size:.95rem;}
  #cv-page .cv-item-links a{color:inherit;text-decoration:underline;}
  #cv-page .cv-item-links .sep{margin:0 .35rem;}
  #cv-page .cv-bullets{margin:.5rem 0 0 1.1rem;}
  #cv-page .cv-bullets li{margin:.15rem 0;}

  #cv-page .cv-edu-link{font-weight:800;text-decoration:underline;text-underline-offset:2px;}
  #cv-page .cv-cert-thumbs{display:flex;gap:.4rem;align-items:center;flex-wrap:wrap;}
  #cv-page .cv-cert-thumb{display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:.65rem;border:1px solid rgba(15,23,42,.12);background:#fff;box-shadow:0 .2rem .6rem rgba(15,23,42,.06);overflow:hidden;transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;padding:0;cursor:pointer;}
  #cv-page .cv-cert-thumb:hover{transform:translateY(-2px);box-shadow:0 .45rem 1.1rem rgba(15,23,42,.12);border-color:rgba(37,99,235,.28);}
  #cv-page .cv-cert-thumb img{max-width:100%;max-height:100%;object-fit:contain;}

  #cv-page .cv-chip{display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .6rem;border-radius:999px;background:rgba(37,99,235,.10);border:1px solid rgba(37,99,235,.22);color:var(--cv-accent);font-weight:800;text-decoration:none;font-size:.9rem;line-height:1.2;}
  #cv-page .cv-chip:hover{background:rgba(37,99,235,.16);border-color:rgba(37,99,235,.35);text-decoration:none;}

  #cv-page .cv-lightbox{position:fixed;inset:0;z-index:1080;display:none;align-items:center;justify-content:center;padding:1.25rem;}
  #cv-page .cv-lightbox.is-open{display:flex;}
  #cv-page .cv-lightbox-backdrop{position:absolute;inset:0;background:rgba(2,6,23,.72);backdrop-filter:blur(2px);}
  #cv-page .cv-lightbox-dialog{position:relative;z-index:1;max-width:min(940px, 96vw);max-height:92vh;background:#fff;border-radius:1rem;overflow:hidden;box-shadow:0 1rem 3rem rgba(0,0,0,.35);border:1px solid rgba(255,255,255,.12);}
  #cv-page .cv-lightbox-img{display:block;max-width:96vw;max-height:92vh;width:auto;height:auto;}
  #cv-page .cv-lightbox-close{position:absolute;top:.4rem;right:.55rem;border:0;background:rgba(15,23,42,.85);color:#fff;width:38px;height:38px;border-radius:999px;display:grid;place-items:center;font-size:1.4rem;line-height:1;}

  @media (max-width: 575.98px){
    .cv-hero{min-height:22vh !important;}
    .cv-hero .display-4{font-size:2rem;}
    .cv-hero .lead{font-size:1rem;}
    #cv-page .container{padding-top:.25rem;}
    #cv-page .cv-actions{justify-content:stretch !important; margin-bottom:.6rem !important;}
    #cv-page .cv-actions .cv-btn{width:100%;}
    #cv-page .cv-header{padding:.9rem .9rem;}
    #cv-page .cv-header h1{font-size:1.65rem !important;}
    #cv-page .cv-contact{min-width:0 !important; width:100%;}
    #cv-page .cv-contact-grid{grid-template-columns:1fr;}
    #cv-page .cv-contact-item{padding:.5rem .6rem;}
    #cv-page .cv-title{font-size:.95rem;}
    #cv-page .cv-section{padding:.8rem .9rem;}
  }

  #cv-page .cv-contact-grid{display:grid;grid-template-columns:1fr;gap:.45rem;}
  #cv-page .cv-contact-item{display:flex;gap:.65rem;align-items:center;padding:.55rem .65rem;border:1px solid rgba(15,23,42,.10);border-radius:.75rem;background:linear-gradient(180deg, #fff 0%, #fbfdff 100%);text-decoration:none;color:inherit;transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;}
  #cv-page .cv-contact-item:hover{transform:translateY(-2px);box-shadow:0 .35rem 1rem rgba(15,23,42,.12);border-color:rgba(37,99,235,.35);}
  #cv-page .cv-contact-ico{width:34px;height:34px;border-radius:999px;display:grid;place-items:center;background:rgba(37,99,235,.10);color:var(--cv-accent);flex:0 0 auto;}
  #cv-page .cv-contact-label{display:block;font-size:.78rem;letter-spacing:.06em;text-transform:uppercase;color:var(--cv-primary-2);}
  #cv-page .cv-contact-value{display:block;font-weight:700;color:var(--cv-black);}
  @media(min-width:992px){#cv-page .cv-contact-grid{grid-template-columns:1fr 1fr;}}

  #cv-page .cv-header,
  #cv-page .cv-section,
  #cv-page .cv-item{transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;}
  #cv-page .cv-header:hover,
  #cv-page .cv-section:hover,
  #cv-page .cv-item:hover{transform:translateY(-3px);box-shadow:0 .6rem 1.4rem rgba(15,23,42,.10);border-color:rgba(37,99,235,.22);}

  @media print{
    nav, footer, .cv-actions, .cv-hero{display:none !important;}
    #cv-page{background:#fff !important;}
    body{color:#000;}
    a{text-decoration:none; color:#000;}
    #cv-page .cv-header, #cv-page .cv-section, #cv-page .cv-item{box-shadow:none !important;border-color:#ddd !important;transform:none !important;}
    #cv-page .cv-contact-item{box-shadow:none !important;transform:none !important;border-color:#ddd !important;}
    #cv-page .cv-item{break-inside:avoid; page-break-inside:avoid;}
    #cv-page .cv-cert-thumbs{display:none !important;}
    #cv-page .cv-lightbox{display:none !important;}
    #cv-page .cv-chip{display:none !important;}
    .section{padding:0 !important;}
    .container{max-width:none !important; padding:0 !important;}
  }
</style>

<script>
  (function(){
    var lb = document.getElementById('cv-lightbox');
    if(!lb) return;
    var img = lb.querySelector('.cv-lightbox-img');
    var open = function(src){
      img.src = src;
      lb.classList.add('is-open');
      lb.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
    };
    var close = function(){
      lb.classList.remove('is-open');
      lb.setAttribute('aria-hidden', 'true');
      img.src = '';
      document.body.style.overflow = '';
    };
    document.querySelectorAll('#cv-page .cv-cert-thumb[data-img]').forEach(function(btn){
      btn.addEventListener('click', function(){ open(btn.getAttribute('data-img')); });
    });
    lb.addEventListener('click', function(e){
      if(e.target && e.target.getAttribute('data-close') === '1') close();
    });
    document.addEventListener('keydown', function(e){
      if(e.key === 'Escape' && lb.classList.contains('is-open')) close();
    });
  })();
</script>

<?php include 'includes/footer.php'; ?>
