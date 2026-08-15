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
      <button class="btn btn-sm cv-btn cv-btn-solid" type="button" onclick="window.print()">
        <i class="bi bi-printer me-2"></i>Imprimir / Guardar PDF
      </button>
    </div>

    <div class="cv-print-title" style="display:none;">
      HOJA DE VIDA
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

    <section class="cv-section cv-section-summary" style="margin-bottom:1rem;">
      <h2 class="cv-title">Resumen</h2>
      <p style="margin:0;">Software Developer con experiencia en desarrollo web (PHP, MySQL, JavaScript), aplicaciones Android (Kotlin) y de escritorio (Java). Especializado en desarrollo frontend y backend, Programación Orientada a Objetos y construcción de soluciones end-to-end. Experiencia en aplicaciones multiplataforma, integración de servicios cloud, autenticación, geolocalización y sincronización de datos. Trabajo con Clean Architecture, principios SOLID y Git/GitHub, orientado a desarrollar software mantenible, escalable y funcional.</p>
    </section>

    <section class="cv-section cv-section-skills" style="margin-bottom:1rem;">
      <h2 class="cv-title">Habilidades</h2>
      <div class="cv-grid">
        <div><strong>Lenguajes:</strong> PHP, Java, Kotlin, JavaScript</div>
        <div><strong>Bases de datos:</strong> MySQL, SQLite</div>
        <div><strong>Android:</strong> Kotlin, Jetpack Compose, MVVM, Room, GPS</div>
        <div><strong>Cloud:</strong> Firebase Authentication, Firebase Storage, sincronización</div>
        <div><strong>Desarrollo Web:</strong> Frontend/Backend, HTML5, CSS3, Bootstrap</div>
        <div><strong>Desktop:</strong> Java, JavaFX, iReport/Jasper</div>
        <div><strong>Herramientas:</strong> Git, GitHub, Programación Orientada a Objetos</div>
        <div><strong>Arquitectura:</strong> Clean Architecture, SOLID</div>
      </div>
    </section>

    <section class="cv-section cv-section-projects" style="margin-bottom:1rem;">
      <h2 class="cv-title">Proyectos destacados</h2>

      <article class="cv-item">
        <div class="cv-item-head">
          <div>
            <div class="cv-item-role">Xpendz — Multiplataforma (Android + Desktop)</div>
            <div class="cv-item-links">
              <a href="https://jcadenas.com/xpendz" target="_blank" rel="noopener">Sitio web oficial</a>
              <span class="sep">|</span>
              <a href="https://github.com/jcadenasSoftware/mis-finanzas-apk" target="_blank" rel="noopener">GitHub Android</a>
              <span class="sep">|</span>
              <a href="https://github.com/jcadenasSoftware/mis-finanzas-msi-Java" target="_blank" rel="noopener">GitHub Desktop</a>
            </div>
          </div>
          <div class="cv-item-tech">Kotlin · Compose · MVVM · Room · Firebase · JavaFX</div>
        </div>
        <ul class="cv-bullets">
          <li>Ecosistema financiero que incluye aplicación Android, aplicación Desktop y sitio web oficial.</li>
          <li>Módulos completos: cuentas, transacciones, transferencias, presupuestos, metas, préstamos, gráficos y reportes.</li>
          <li>Autenticación segura con Firebase y sincronización cloud entre las versiones móvil y escritorio.</li>
          <li>Actualmente en etapa de pruebas internas y proceso de publicación en Google Play.</li>
        </ul>
      </article>

      <article class="cv-item">
        <div class="cv-item-head">
          <div>
            <div class="cv-item-role">Buscamos tu mascota — Android + Sitio web oficial</div>
            <div class="cv-item-links">
              <a href="https://buscamostumascota.com" target="_blank" rel="noopener">Sitio web oficial</a>
              <span class="sep">|</span>
              <a href="https://github.com/JcadenasSoftware/lost_pets" target="_blank" rel="noopener">GitHub</a>
            </div>
          </div>
          <div class="cv-item-tech">Kotlin · Jetpack Compose · Firebase · Google Maps · Material 3</div>
        </div>
        <ul class="cv-bullets">
          <li>Plataforma propia de búsqueda y recuperación de mascotas perdidas con geolocalización y Google Maps.</li>
          <li>Desarrollada con Kotlin y Jetpack Compose, utilizando Firebase como infraestructura backend/cloud.</li>
          <li>Sistema de mascotas perdidas/encontradas con mensajería entre usuarios, envío de archivos e imágenes, captura de fotografías desde la cámara y notificaciones push.</li>
          <li>Generación de códigos QR asociados a la ficha de la mascota, historial médico, citas veterinarias con recordatorios y sitio web oficial actualmente en desarrollo.</li>
        </ul>
      </article>

      <article class="cv-item">
        <div class="cv-item-head">
          <div>
            <div class="cv-item-role">marysbelleza.com — Plataforma web en producción</div>
            <div class="cv-item-links">
              <a href="https://marysbelleza.com" target="_blank" rel="noopener">marysbelleza.com</a>
            </div>
          </div>
          <div class="cv-item-tech">PHP · MySQL · JavaScript · Bootstrap · SEO</div>
        </div>
        <ul class="cv-bullets">
          <li>Plataforma web PHP/MySQL en producción con panel administrativo para publicaciones, galería de trabajos, gestión multimedia y moderación de contenido.</li>
          <li>Galería dinámica con fotografías, videos, comentarios públicos y valoración por estrellas.</li>
          <li>Formulario de contacto y solicitud de citas con envío de correo mediante SMTP, integración con WhatsApp y optimización SEO.</li>
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
              <span class="sep">|</span>
              <a href="https://jcadenas.com/xpendz/" target="_blank" rel="noopener">Sitio web oficial de Xpendz</a>
              <span class="sep">|</span>
              <a href="https://buscamostumascota.com" target="_blank" rel="noopener">Sitio web oficial de Buscamos tu mascota</a>
            </div>
          </div>
          <div class="cv-item-tech">PHP · MySQL · Panel administrativo</div>
        </div>
        <ul class="cv-bullets">
          <li>Sitios web en producción con portafolio, contenido dinámico y dashboards administrativos.</li>
          <li>Desarrollo de back-end con PHP/MySQL y paneles administrativos propios, además de sitios web oficiales para proyectos de software.</li>
        </ul>
      </article>

      <article class="cv-item">
        <div class="cv-item-head">
          <div>
            <div class="cv-item-role">Xpendz Desktop — Aplicación financiera</div>
            <div class="cv-item-links">
              <a href="https://github.com/jcadenasSoftware/Xpendz-msi-Java.git" target="_blank" rel="noopener">GitHub</a>
            </div>
          </div>
          <div class="cv-item-tech">Java · JavaFX · SQLite · Firestore · Maven</div>
        </div>
        <ul class="cv-bullets">
          <li>Aplicación financiera de escritorio para Windows integrada al ecosistema multiplataforma Xpendz.</li>
          <li>Gestión de cuentas, transacciones, transferencias, presupuestos, metas y préstamos con persistencia local SQLite y sincronización cloud con Firestore.</li>
          <li>Dashboard financiero con gráficos, análisis mensual y exportación CSV, interfaz JavaFX con tema claro/oscuro y distribución mediante instalador MSI.</li>
        </ul>
      </article>
    </section>

    <section class="cv-section cv-section-education" style="margin-bottom:1rem;">
      <h2 class="cv-title">Educación y certificaciones</h2>
      <?php
        $featuredTraining = [
          [
            'title' => 'Diplomado en Programación en Java',
            'provider' => 'Politécnico de Colombia',
            'year' => '2018',
            'category_label' => 'Desarrollo',
            'file' => 'Diplomado Programación Java.webp',
            'url' => null,
          ],
          [
            'title' => 'Administrador de Bases de Datos',
            'provider' => 'Fundación Carlos Slim / Capacítate para el Empleo',
            'year' => '2019',
            'category_label' => 'Bases de datos',
            'file' => 'Certificado Administrador de bases de datos.webp',
            'url' => null,
          ],
        ];
        $certificates = [
          [
            'title' => 'Git y GitHub',
            'provider' => 'Platzi',
            'year' => '2026',
            'category_label' => 'Desarrollo',
            'file' => 'Certificado Git y GitHub.webp',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/12139-course/diploma/detalle/',
          ],
          [
            'title' => 'Fundamentos de Ingeniería de Software',
            'provider' => 'Platzi',
            'year' => '2026',
            'category_label' => 'Desarrollo',
            'file' => 'Certificado Fundamentos de Ingeniería de Software.webp',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/11997-course/diploma/detalle/',
          ],
          [
            'title' => 'Fundamentos del Desarrollo Web Profesional',
            'provider' => 'Platzi',
            'year' => '2026',
            'category_label' => 'Web',
            'file' => 'Fundamentos Desarrollo web profesional.webp',
            'url' => 'https://platzi.com/p/ing.jcadenas/ruta/30063-ruta/diploma/detalle/',
          ],
          [
            'title' => 'Fundamentos de JavaScript',
            'provider' => 'Platzi',
            'year' => '2026',
            'category_label' => 'Web',
            'file' => 'Certificado Fundamentos de JavaScript.webp',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/10266-course/diploma/detalle/',
          ],
          [
            'title' => 'Fundamentos de Python',
            'provider' => 'Platzi',
            'year' => '2026',
            'category_label' => 'Desarrollo',
            'file' => 'Certificado Fundamentos de Python.webp',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/12164-course/diploma/detalle/',
          ],
          [
            'title' => 'Introducción a la Inteligencia Artificial',
            'provider' => 'Platzi',
            'year' => '2025',
            'category_label' => 'IA',
            'file' => 'Certificado Introducción a la Inteligencia Artificial.webp',
            'url' => 'https://platzi.com/p/ing.jcadenas/curso/12286-course/diploma/detalle/',
          ],
        ];
        $certBase = $base . '/assets/certificados/';
      ?>
      <div class="cv-edu-wrap">
        <div class="cv-edu-block">
          <div class="cv-subtitle">Educación formal</div>
          <article class="cv-edu-card cv-edu-card-degree">
            <div class="cv-degree-image">
              <img src="<?= $certBase ?>titulo-ingeniero-informatica.webp" alt="Título de Ingeniero en Informática" loading="lazy" />
            </div>
            <div class="cv-edu-content">
              <div class="cv-edu-name">Ingeniero en Informática</div>
              <div class="cv-edu-meta">Título universitario · Venezuela</div>
              <div class="cv-edu-inst">Universidad Politécnica Territorial de Valencia · 2015</div>
              <div class="cv-edu-actions">
                <button
                  class="btn btn-sm cv-btn cv-btn-outline"
                  type="button"
                  data-lightbox-kind="image"
                  data-lightbox-kicker="Educación formal"
                  data-lightbox-title="Ingeniero en Informática"
                  data-lightbox-subtitle="Título universitario · Venezuela"
                  data-lightbox-img="<?= $certBase ?>titulo-ingeniero-informatica.webp"
                  data-lightbox-url=""
                >Ver título</button>
              </div>
            </div>
          </article>
        </div>

        <div class="cv-edu-block">
          <div class="cv-subtitle">Formación profesional</div>
          <div class="cv-training-grid">
            <?php foreach ($featuredTraining as $training): ?>
              <?php $imgUrl = $certBase . rawurlencode($training['file']); ?>
              <article class="cv-edu-card cv-edu-card-training">
                <div class="cv-edu-card-top">
                  <span class="cv-edu-tag"><?= htmlspecialchars($training['category_label'], ENT_QUOTES) ?></span>
                  <span class="cv-edu-tag cv-edu-tag-soft">Formación destacada</span>
                </div>
                <div class="cv-edu-name"><?= htmlspecialchars($training['title'], ENT_QUOTES) ?></div>
                <div class="cv-edu-inst"><?= htmlspecialchars($training['provider'], ENT_QUOTES) ?> · <?= htmlspecialchars($training['year'], ENT_QUOTES) ?></div>
                <div class="cv-edu-actions">
                  <button
                    class="btn btn-sm cv-btn cv-btn-outline"
                    type="button"
                    data-lightbox-kind="image"
                    data-lightbox-kicker="Formación profesional"
                    data-lightbox-title="<?= htmlspecialchars($training['title'], ENT_QUOTES) ?>"
                    data-lightbox-subtitle="<?= htmlspecialchars($training['provider'] . ' · ' . $training['year'], ENT_QUOTES) ?>"
                    data-lightbox-img="<?= htmlspecialchars($imgUrl, ENT_QUOTES) ?>"
                    data-lightbox-url="<?= htmlspecialchars($training['url'] ?? '', ENT_QUOTES) ?>"
                  >Ver certificado</button>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="cv-edu-block">
          <div class="cv-subtitle">Certificaciones técnicas</div>
          <div class="cv-cert-grid">
            <?php foreach ($certificates as $certificate): ?>
              <?php $imgUrl = $certBase . rawurlencode($certificate['file']); ?>
              <article class="cv-cert-card">
                <div class="cv-cert-card-top">
                  <span class="cv-cert-category"><?= htmlspecialchars($certificate['category_label'], ENT_QUOTES) ?></span>
                </div>
                <div class="cv-cert-name"><?= htmlspecialchars($certificate['title'], ENT_QUOTES) ?></div>
                <div class="cv-cert-provider"><?= htmlspecialchars($certificate['provider'], ENT_QUOTES) ?> · <?= htmlspecialchars($certificate['year'], ENT_QUOTES) ?></div>
                <div class="cv-cert-actions">
                  <button
                    class="btn btn-sm cv-btn cv-btn-outline"
                    type="button"
                    data-lightbox-kind="image"
                    data-lightbox-kicker="<?= htmlspecialchars($certificate['category_label'], ENT_QUOTES) ?>"
                    data-lightbox-title="<?= htmlspecialchars($certificate['title'], ENT_QUOTES) ?>"
                    data-lightbox-subtitle="<?= htmlspecialchars($certificate['provider'] . ' · ' . $certificate['year'], ENT_QUOTES) ?>"
                    data-lightbox-img="<?= htmlspecialchars($imgUrl, ENT_QUOTES) ?>"
                    data-lightbox-url="<?= htmlspecialchars($certificate['url'] ?? '', ENT_QUOTES) ?>"
                  >Ver certificado</button>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
          <div style="margin-top:.75rem; text-align:right;">
            <a href="<?= $base ?>/about.php#certificados" class="cv-link-all">Ver todas las certificaciones →</a>
          </div>
        </div>
      </div>

      <div class="cv-lightbox" id="cv-lightbox" aria-hidden="true">
        <div class="cv-lightbox-backdrop" data-close="1"></div>
        <div class="cv-lightbox-dialog" role="dialog" aria-modal="true" aria-label="Certificado o título">
          <button class="cv-lightbox-close" type="button" data-close="1" aria-label="Cerrar">×</button>
          <div class="cv-lightbox-head">
            <div class="cv-lightbox-kicker" id="cv-lightbox-kicker"></div>
            <div class="cv-lightbox-title" id="cv-lightbox-title"></div>
            <div class="cv-lightbox-sub" id="cv-lightbox-sub"></div>
          </div>
          <div class="cv-lightbox-body">
            <img class="cv-lightbox-img" id="cv-lightbox-img" alt="" src="" decoding="async">
            <div class="cv-lightbox-placeholder" id="cv-lightbox-placeholder" hidden>
              <div class="cv-degree-placeholder cv-degree-placeholder-modal">
                <span class="cv-degree-badge">Mock</span>
                <span class="cv-degree-icon"><i class="bi bi-file-earmark-lock"></i></span>
                <div class="cv-degree-text" id="cv-lightbox-placeholder-title">Mock temporal del título</div>
                <p class="cv-degree-copy" id="cv-lightbox-placeholder-copy">La versión pública protegida se incorporará posteriormente.</p>
                <code class="cv-degree-file" id="cv-lightbox-placeholder-file">assets/img/titulo-ingeniero-informatica.jpg</code>
              </div>
            </div>
          </div>
          <div class="cv-lightbox-actions">
            <a class="btn btn-sm cv-btn cv-btn-outline" id="cv-lightbox-open" href="#" target="_blank" rel="noopener" style="display:none;">Abrir imagen</a>
            <a class="btn btn-sm cv-btn cv-btn-solid" id="cv-lightbox-credential" href="#" target="_blank" rel="noopener" style="display:none;">Ver credencial</a>
          </div>
        </div>
      </div>
    </section>

    <section class="cv-section cv-section-languages" style="margin-bottom:1rem;">
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

  #cv-page .cv-edu-wrap{display:grid;gap:1rem;}
  #cv-page .cv-edu-block{display:grid;gap:.75rem;}
  #cv-page .cv-subtitle{font-size:.82rem;font-weight:800;letter-spacing:.11em;text-transform:uppercase;color:var(--cv-primary-2);}
  #cv-page .cv-edu-card{border:1px solid rgba(15,23,42,.08);border-radius:.9rem;background:#fff;box-shadow:var(--cv-shadow);padding:1rem;display:grid;gap:1rem;align-items:start;}
  #cv-page .cv-edu-card-degree{grid-template-columns:minmax(180px, 240px) 1fr;}
  #cv-page .cv-training-grid{display:grid;grid-template-columns:1fr;gap:.75rem;}
  @media(min-width:768px){#cv-page .cv-training-grid{grid-template-columns:1fr 1fr;}}
  #cv-page .cv-edu-card-top,#cv-page .cv-cert-card-top{display:flex;gap:.45rem;flex-wrap:wrap;align-items:center;justify-content:space-between;}
  #cv-page .cv-edu-tag,#cv-page .cv-cert-category,#cv-page .cv-cert-flag{display:inline-flex;align-items:center;justify-content:center;padding:.23rem .55rem;border-radius:999px;font-size:.77rem;font-weight:800;line-height:1.2;border:1px solid rgba(37,99,235,.20);}
  #cv-page .cv-edu-tag,#cv-page .cv-cert-category{background:rgba(37,99,235,.10);color:var(--cv-accent);}
  #cv-page .cv-edu-tag-soft,#cv-page .cv-cert-flag{background:rgba(15,23,42,.06);color:var(--cv-primary-2);border-color:rgba(15,23,42,.10);}
  #cv-page .cv-edu-content{display:grid;gap:.45rem;align-self:center;}
  #cv-page .cv-edu-name{font-size:1.08rem;font-weight:800;color:var(--cv-primary);line-height:1.3;}
  #cv-page .cv-edu-meta{font-weight:700;color:#495057;}
  #cv-page .cv-edu-inst,#cv-page .cv-cert-provider{color:#6c757d;font-weight:600;line-height:1.5;}
  #cv-page .cv-edu-note{margin:0;color:#6c757d;font-size:.95rem;line-height:1.6;}
  #cv-page .cv-edu-actions,#cv-page .cv-cert-actions,#cv-page .cv-lightbox-actions{display:flex;gap:.5rem;flex-wrap:wrap;}
  #cv-page .cv-degree-placeholder{min-height:210px;border:1px dashed rgba(37,99,235,.28);border-radius:1rem;background:linear-gradient(180deg, rgba(37,99,235,.06) 0%, rgba(248,250,252,.95) 100%);display:grid;place-items:center;text-align:center;padding:1rem;color:var(--cv-primary);position:relative;overflow:hidden;}
  #cv-page .cv-degree-placeholder::after{content:"";position:absolute;inset:auto -12% -22% auto;width:140px;height:140px;border-radius:50%;background:rgba(37,99,235,.08);}
  #cv-page .cv-degree-image{min-height:210px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(15,23,42,.08);border-radius:1rem;background:#fff;overflow:hidden;}
  #cv-page .cv-degree-image img{display:block;max-width:100%;max-height:300px;width:auto;height:auto;object-fit:contain;}
  #cv-page .cv-degree-badge{position:absolute;top:.8rem;left:.8rem;display:inline-flex;padding:.24rem .55rem;border-radius:999px;background:rgba(37,99,235,.12);color:var(--cv-accent);font-size:.76rem;font-weight:800;letter-spacing:.04em;text-transform:uppercase;}
  #cv-page .cv-degree-icon{font-size:2.2rem;color:var(--cv-accent);margin-bottom:.5rem;display:block;}
  #cv-page .cv-degree-text{font-weight:800;line-height:1.45;position:relative;z-index:1;}
  #cv-page .cv-degree-copy{margin:0;color:#6c757d;line-height:1.6;max-width:32rem;}
  #cv-page .cv-degree-file{display:inline-block;margin-top:.2rem;padding:.3rem .55rem;border-radius:.55rem;background:#f8fafc;border:1px solid rgba(15,23,42,.08);color:var(--cv-primary-2);font-size:.85rem;word-break:break-all;}
  #cv-page .cv-cert-grid{display:grid;grid-template-columns:1fr;gap:.75rem;}
  @media(min-width:768px){#cv-page .cv-cert-grid{grid-template-columns:repeat(2, minmax(0, 1fr));}}
  #cv-page .cv-cert-card{border:1px solid rgba(15,23,42,.08);border-radius:.9rem;background:#fff;box-shadow:var(--cv-shadow);padding:.9rem;display:grid;gap:.75rem;align-content:start;}
  #cv-page .cv-cert-name{font-weight:800;color:var(--cv-primary);line-height:1.4;}
  #cv-page .cv-link-all{font-weight:700;color:var(--cv-accent);text-decoration:none;font-size:.92rem;}
  #cv-page .cv-link-all:hover{text-decoration:underline;}
  #cv-page .cv-lightbox{position:fixed;inset:0;z-index:1080;display:none;align-items:center;justify-content:center;padding:1.25rem;}
  #cv-page .cv-lightbox.is-open{display:flex;}
  #cv-page .cv-lightbox-backdrop{position:absolute;inset:0;background:rgba(2,6,23,.72);backdrop-filter:blur(2px);}
  #cv-page .cv-lightbox-dialog{position:relative;z-index:1;width:min(980px, 96vw);max-height:92vh;background:#fff;border-radius:1rem;overflow:auto;box-shadow:0 1rem 3rem rgba(0,0,0,.35);border:1px solid rgba(255,255,255,.12);padding:1rem;display:grid;gap:1rem;}
  #cv-page .cv-lightbox-head{padding-right:2.75rem;display:grid;gap:.2rem;}
  #cv-page .cv-lightbox-kicker{font-size:.8rem;font-weight:800;letter-spacing:.11em;text-transform:uppercase;color:var(--cv-accent);}
  #cv-page .cv-lightbox-title{font-size:1.15rem;font-weight:800;color:var(--cv-primary);line-height:1.3;}
  #cv-page .cv-lightbox-sub{color:#6c757d;font-weight:600;}
  #cv-page .cv-lightbox-body{display:grid;place-items:center;min-height:240px;}
  #cv-page .cv-lightbox-img{display:block;max-width:100%;max-height:65vh;width:auto;height:auto;border-radius:.8rem;border:1px solid rgba(15,23,42,.08);background:#fff;}
  #cv-page .cv-lightbox-placeholder{width:100%;}
  #cv-page .cv-degree-placeholder-modal{min-height:300px;}
  #cv-page .cv-lightbox-close{position:absolute;top:.7rem;right:.7rem;border:0;background:rgba(15,23,42,.85);color:#fff;width:38px;height:38px;border-radius:999px;display:grid;place-items:center;font-size:1.4rem;line-height:1;}

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
    #cv-page .cv-edu-card-degree{grid-template-columns:1fr;}
    #cv-page .cv-degree-placeholder{min-height:180px;}
    #cv-page .cv-edu-actions .cv-btn,
    #cv-page .cv-cert-actions .cv-btn,
    #cv-page .cv-lightbox-actions .cv-btn{width:100%;}
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

  @page{
    size:A4;
    margin:9mm 10mm;
  }

  @media print{
    html, body{
      background:#fff !important;
      color:#000 !important;
      font-size:10pt;
      line-height:1.32;
      -webkit-print-color-adjust:exact;
      print-color-adjust:exact;
    }
    nav, footer, .cv-actions, .cv-hero{display:none !important;}
    #cv-page,
    .section,
    .container{background:#fff !important; padding:0 !important; margin:0 !important;}
    #cv-page .container{max-width:none !important; padding-top:0 !important;}
    a{color:#000 !important; text-decoration:none !important;}
    #cv-page p{margin:0 !important; line-height:1.38 !important; color:#000 !important;}
    #cv-page .cv-header,
    #cv-page .cv-section,
    #cv-page .cv-item,
    #cv-page .cv-edu-card,
    #cv-page .cv-cert-card,
    #cv-page .cv-contact-item{box-shadow:none !important; transform:none !important;}
    #cv-page .cv-header,
    #cv-page .cv-section,
    #cv-page .cv-item,
    #cv-page .cv-edu-card,
    #cv-page .cv-cert-card{border:1px solid #d8dee8 !important; border-radius:0 !important; break-inside:avoid; page-break-inside:avoid;}
    #cv-page .cv-lightbox,
    #cv-page .cv-edu-actions,
    #cv-page .cv-cert-actions,
    #cv-page .cv-item-links,
    #cv-page .cv-edu-note,
    #cv-page .cv-contact-ico,
    #cv-page .cv-contact-label{display:none !important;}

    #cv-page .cv-print-title{display:block !important; font-size:13pt; font-weight:800; text-transform:uppercase; letter-spacing:.08em; margin:0 0 3mm 0; text-align:center; color:#000;}

    #cv-page .cv-header{
      display:grid !important;
      grid-template-columns:1.1fr 1fr;
      gap:2mm 4mm;
      padding:3mm 4mm !important;
      margin:0 0 2mm 0 !important;
    }
    #cv-page .cv-header h1{font-size:19pt !important; line-height:1.05 !important; margin:0 0 0.8mm 0 !important;}
    #cv-page .cv-header .text-muted{font-size:9.5pt !important; line-height:1.2 !important; margin-top:0 !important;}
    #cv-page .cv-contact{min-width:0 !important; width:auto !important; font-size:8.8pt !important;}
    #cv-page .cv-contact-grid{grid-template-columns:1fr 1fr !important; gap:0.8mm 3.5mm !important;}
    #cv-page .cv-contact-item{padding:0 !important; border:0 !important; background:none !important; display:block !important;}
    #cv-page .cv-contact-value{font-size:8.8pt !important; font-weight:600 !important; line-height:1.18 !important;}

    #cv-page .cv-section{padding:2.8mm 3.5mm !important; margin:0 0 2mm 0 !important;}
    #cv-page .cv-section + .cv-section{margin-top:0 !important;}
    #cv-page .cv-title{font-size:8.4pt !important; margin:0 0 1.5mm 0 !important; letter-spacing:.08em !important; break-after:avoid-page; page-break-after:avoid;}
    #cv-page .cv-title::before{width:6px; height:6px; box-shadow:none !important;}
    #cv-page .cv-grid{grid-template-columns:1fr 1fr !important; gap:0.8mm 3.5mm !important;}
    #cv-page .cv-section-summary p{font-size:8.9pt !important;}
    #cv-page .cv-section-skills .cv-grid,
    #cv-page .cv-section-languages .cv-grid{font-size:8.8pt !important;}

    #cv-page .cv-item{padding:2.2mm 3mm !important; margin:1.5mm 0 0 0 !important;}
    #cv-page .cv-item-head{gap:0.8mm 3.5mm !important; margin-bottom:0.6mm !important;}
    #cv-page .cv-item-role{font-size:9.2pt !important; line-height:1.18 !important;}
    #cv-page .cv-item-tech{font-size:8.2pt !important; line-height:1.18 !important;}
    #cv-page .cv-bullets{margin:0.1rem 0 0 .85rem !important; font-size:8.4pt !important;}
    #cv-page .cv-bullets li{margin:0 !important; line-height:1.2 !important;}

    #cv-page .cv-edu-wrap{gap:2mm !important;}
    #cv-page .cv-edu-block{gap:1.5mm !important; break-inside:avoid; page-break-inside:avoid;}
    #cv-page .cv-subtitle{font-size:7.5pt !important; letter-spacing:.08em !important;}
    #cv-page .cv-edu-card,
    #cv-page .cv-cert-card{padding:2mm 3mm !important; gap:1.2mm !important;}
    #cv-page .cv-edu-card-degree{grid-template-columns:1fr !important; gap:1.5mm !important;}
    #cv-page .cv-degree-placeholder{display:none !important;}
    #cv-page .cv-degree-image{display:none !important;}
    #cv-page .cv-edu-name{font-size:9pt !important; line-height:1.18 !important;}
    #cv-page .cv-edu-meta{font-size:8.5pt !important;}
    #cv-page .cv-edu-inst,
    #cv-page .cv-cert-provider{font-size:8.2pt !important; line-height:1.2 !important; color:#333 !important;}
    #cv-page .cv-training-grid,
    #cv-page .cv-cert-grid{grid-template-columns:1fr 1fr !important; gap:1.5mm 2.5mm !important;}
    #cv-page .cv-edu-card-top,
    #cv-page .cv-cert-card-top{justify-content:flex-start !important; gap:1mm !important;}
    #cv-page .cv-edu-tag,
    #cv-page .cv-edu-tag-soft,
    #cv-page .cv-cert-category{padding:0 4px !important; font-size:6.5pt !important; border-color:#d8dee8 !important; background:none !important; color:#000 !important;}
    #cv-page .cv-cert-name{font-size:8.6pt !important; line-height:1.2 !important;}
    #cv-page .cv-link-all{display:block !important; margin-top:1mm !important; font-size:7.5pt !important; text-align:right !important; color:#000 !important;}

    #cv-page .cv-section,
    #cv-page .cv-item,
    #cv-page .cv-edu-card,
    #cv-page .cv-cert-card{orphans:3; widows:3;}
    #cv-page .cv-section-languages{break-before:avoid-page; page-break-before:avoid;}
  }
</style>

<script>
  (function(){
    var lb = document.getElementById('cv-lightbox');
    if(!lb) return;

    var img = document.getElementById('cv-lightbox-img');
    var kicker = document.getElementById('cv-lightbox-kicker');
    var title = document.getElementById('cv-lightbox-title');
    var sub = document.getElementById('cv-lightbox-sub');
    var placeholder = document.getElementById('cv-lightbox-placeholder');
    var placeholderTitle = document.getElementById('cv-lightbox-placeholder-title');
    var placeholderCopy = document.getElementById('cv-lightbox-placeholder-copy');
    var placeholderFile = document.getElementById('cv-lightbox-placeholder-file');
    var openLink = document.getElementById('cv-lightbox-open');
    var credentialLink = document.getElementById('cv-lightbox-credential');

    var showModal = function(){
      lb.classList.add('is-open');
      lb.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
    };

    var resetModal = function(){
      img.src = '';
      img.alt = '';
      img.hidden = true;
      placeholder.hidden = true;
      kicker.textContent = '';
      title.textContent = '';
      sub.textContent = '';
      placeholderTitle.textContent = '';
      placeholderCopy.textContent = '';
      placeholderFile.textContent = '';
      openLink.style.display = 'none';
      credentialLink.style.display = 'none';
      openLink.href = '#';
      credentialLink.href = '#';
    };

    var closeModal = function(){
      lb.classList.remove('is-open');
      lb.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      resetModal();
    };

    var openFromButton = function(btn){
      resetModal();
      kicker.textContent = btn.getAttribute('data-lightbox-kicker') || '';
      title.textContent = btn.getAttribute('data-lightbox-title') || '';
      sub.textContent = btn.getAttribute('data-lightbox-subtitle') || '';

      if(btn.getAttribute('data-lightbox-kind') === 'placeholder'){
        placeholder.hidden = false;
        placeholderTitle.textContent = btn.getAttribute('data-placeholder-title') || '';
        placeholderCopy.textContent = btn.getAttribute('data-placeholder-copy') || '';
        placeholderFile.textContent = btn.getAttribute('data-placeholder-file') || '';
        showModal();
        return;
      }

      var imageSrc = btn.getAttribute('data-lightbox-img') || '';
      var credentialUrl = btn.getAttribute('data-lightbox-url') || '';
      img.src = imageSrc;
      img.alt = btn.getAttribute('data-lightbox-title') || '';
      img.hidden = false;
      openLink.href = imageSrc;
      openLink.style.display = imageSrc ? '' : 'none';
      credentialLink.href = credentialUrl || '#';
      credentialLink.style.display = credentialUrl ? '' : 'none';
      showModal();
    };

    document.querySelectorAll('#cv-page [data-lightbox-kind]').forEach(function(btn){
      btn.addEventListener('click', function(){ openFromButton(btn); });
    });

    lb.addEventListener('click', function(e){
      if(e.target && e.target.getAttribute('data-close') === '1') closeModal();
    });

    document.addEventListener('keydown', function(e){
      if(e.key === 'Escape' && lb.classList.contains('is-open')) closeModal();
    });
  })();
</script>

<?php include 'includes/footer.php'; ?>
