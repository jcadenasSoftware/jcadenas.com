<?php include 'includes/header.php'; ?>
<?php
require_once 'db.php';
?>
<!-- Hero Portafolio -->
<section class="hero hero-compact section portfolio-hero d-flex align-items-center" style="background:url('<?= $base ?>/assets/img/hero-bg.webp') center/cover no-repeat;">
  <div class="hero-content text-center">
    <h1 id="portfolioTitle" class="display-4 fw-bold mb-2 user-select-none">Portafolio</h1>
    <p class="lead mb-0">Proyectos destacados en ingeniería de software, web y móvil.</p>
  </div>
</section>
<?php
$catSlug = $_GET['cat'] ?? 'all';
$cats = $pdo->query('SELECT slug,nombre FROM categoria ORDER BY nombre')->fetchAll(PDO::FETCH_KEY_PAIR);
$thumbSql = "(SELECT ruta FROM media WHERE proyecto_id=p.id AND tipo='imagen' ORDER BY orden LIMIT 1) AS thumb";
if($catSlug==='all' || !isset($cats[$catSlug])){
  $stmt=$pdo->query("SELECT p.*, c.slug cat_slug, c.nombre cat_nombre, $thumbSql FROM proyecto p JOIN categoria c ON c.id=p.categoria_id ORDER BY p.destacado DESC, p.creado_en DESC");
  $proyectos=$stmt->fetchAll();
}else{
  $stmt=$pdo->prepare("SELECT p.*, c.slug cat_slug, c.nombre cat_nombre, $thumbSql FROM proyecto p JOIN categoria c ON c.id=p.categoria_id WHERE c.slug=? ORDER BY p.destacado DESC, p.creado_en DESC");
  $stmt->execute([$catSlug]);
  $proyectos=$stmt->fetchAll();
}
?>
<section class="section portfolio-list">
  <div class="container py-4">
    <h2 class="display-5 fw-bold mb-4 text-center">Filtra los proyectos por tecnología</h2>
    <?php
  // mapping slug => icon file relative to /assets/tech
  $catIcons=[
    'java'=>'java.png',
    'python'=>'piton.png',
    'web'=>'html5.png',
    'android'=>'androide.png',
    'php'=>'php.png'
  ];
?>
    <div class="mb-4 text-center filter-tech">
      <a href="portfolio.php#proyectos" class="btn btn-primary btn-sm <?= $catSlug==='all'?'active':'' ?>">Todos</a>
      <?php foreach($cats as $slug=>$nombre): ?>
        <a href="portfolio.php?cat=<?= urlencode($slug) ?>#proyectos" class="btn btn-sm tech-<?= htmlspecialchars($slug) ?> <?= $catSlug===$slug?'active':'' ?>">
          <img src="<?= $base ?>/assets/tech/<?= $catIcons[$slug] ?? 'html5.png' ?>" alt="" height="16" class="me-1"> <?= htmlspecialchars($nombre) ?>
        </a>
      <?php endforeach; ?>
    </div>

    <div id="proyectos" class="row g-4">
      <?php foreach($proyectos as $p):
        $thumb = $p['thumb'];
        if(!$thumb){
          // intentar thumbnail de video
          $stmtThumb=$pdo->prepare('SELECT ruta FROM media WHERE proyecto_id=? AND tipo="video" ORDER BY orden LIMIT 1');
          $stmtThumb->execute([$p['id']]);
          $v=$stmtThumb->fetchColumn();
          if($v){
            if(preg_match('~youtu(?:\.be/|.*v=)([\w-]{11})~',$v,$m)){
              $thumb='https://img.youtube.com/vi/'.$m[1].'/hqdefault.jpg';
            }
          }
        }
        $thumb = $thumb ?: 'https://via.placeholder.com/600x338?text=Sin+imagen'; ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 shadow-sm project-card project-card-<?= htmlspecialchars($p['cat_slug']) ?>">
            <?php
              $thumbSrc = $thumb;
              $imgAttrs = 'class="card-img-top" loading="lazy" decoding="async" alt="'.htmlspecialchars($p['titulo']).'"';
              $sizes='(max-width: 992px) 100vw, 360px';
              $srcsetPng=''; $srcsetWebp='';
              if(str_starts_with($thumbSrc,'/')){
                $abs = __DIR__ . $thumbSrc;
                $dir = dirname($abs); $baseName = pathinfo($abs, PATHINFO_FILENAME); $ext = pathinfo($abs, PATHINFO_EXTENSION);
                $cands=[320,640,1024,1600]; $partsP=[]; $partsW=[];
                foreach($cands as $w){
                  $cand=$dir.DIRECTORY_SEPARATOR.$baseName."-w{$w}.".$ext; if(file_exists($cand)){ $partsP[] = $baseName."-w{$w}.{$ext} {$w}w"; }
                  $candW=$dir.DIRECTORY_SEPARATOR.$baseName."-w{$w}.webp"; if(file_exists($candW)){ $partsW[] = $baseName."-w{$w}.webp {$w}w"; }
                }
                if($partsP){ $webDir = dirname($thumbSrc); $srcsetPng = implode(', ', array_map(fn($p)=> $webDir.'/'.$p, $partsP)); }
                if($partsW){ $webDir = dirname($thumbSrc); $srcsetWebp = implode(', ', array_map(fn($p)=> $webDir.'/'.$p, $partsW)); }
              }
            ?>
            <picture>
              <?php if($srcsetWebp): ?><source type="image/webp" srcset="<?= htmlspecialchars($srcsetWebp) ?>" sizes="<?= $sizes ?>"><?php endif; ?>
              <img src="<?= $base . $thumbSrc ?>" <?= $srcsetPng? 'srcset="'.htmlspecialchars($srcsetPng).'"':'' ?> sizes="<?= $sizes ?>" <?= $imgAttrs ?> style="height: 220px; object-fit: cover;">
            </picture>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($p['titulo']) ?></h5>
              <p class="card-text small"><?= nl2br(htmlspecialchars(mb_strimwidth($p['descripcion'],0,120,'...'))) ?></p>
            </div>
            <div class="card-footer text-center">
              <?php if($p['repo_url']): 
                $isGithub = str_contains(strtolower($p['repo_url']), 'github.com');
                $btnClass = $isGithub ? 'btn-dark' : 'btn-outline-secondary';
                $btnText = $isGithub ? 'GitHub' : 'Demo';
              ?>
                <a href="<?= htmlspecialchars($p['repo_url']) ?>" target="_blank" class="btn btn-sm <?= $btnClass ?> me-1">
                  <?php if($isGithub): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                      <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                    </svg>
                  <?php else: ?>
                    <i class="bi bi-box-arrow-up-right"></i>
                  <?php endif; ?>
                  <?= $btnText ?>
                </a>
              <?php endif; ?>
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#proj<?= $p['id'] ?>">Detalles</button>
            </div>
          </div>
        </div>

        <!-- Modal Proyecto -->
        <div class="modal fade" id="proj<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
              <div class="modal-header border-0 bg-gradient-primary text-white py-2">
                <div class="d-flex align-items-center gap-2">
                  <h5 class="modal-title mb-0 fw-bold"><?= htmlspecialchars($p['titulo']) ?></h5>
                  <?php $icon = $catIcons[$p['cat_slug']] ?? null; ?>
                  <span class="badge bg-white text-dark">
                    <?php if($icon): ?>
                      <img src="<?= $base ?>/assets/tech/<?= htmlspecialchars($icon) ?>" alt="" height="12" class="me-1 align-text-top">
                    <?php endif; ?>
                    <?= htmlspecialchars($p['cat_nombre']) ?>
                  </span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body py-3">
                <?php 
                // Obtener media y priorizar videos
                $media=$pdo->prepare('SELECT * FROM media WHERE proyecto_id=? ORDER BY CASE WHEN tipo="video" THEN 0 ELSE 1 END, orden'); 
                $media->execute([$p['id']]); 
                $mitems=$media->fetchAll(); 
                ?>
                <?php if($mitems): ?>
                <div id="carousel<?= $p['id'] ?>" class="carousel slide mb-3" data-bs-ride="carousel">
                  <!-- Indicadores modernos -->
                  <?php if(count($mitems) > 1): ?>
                  <div class="carousel-indicators">
                    <?php foreach($mitems as $idx=>$_): ?>
                      <button type="button" data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide-to="<?= $idx ?>" <?= $idx===0?'class="active" aria-current="true"':'' ?> aria-label="Slide <?= $idx+1 ?>"></button>
                    <?php endforeach; ?>
                  </div>
                  <?php endif; ?>
                  
                  <!-- Contador de slides -->
                  <?php if(count($mitems) > 1): ?>
                  <div class="carousel-counter">
                    <span class="current-slide">1</span> / <?= count($mitems) ?>
                  </div>
                  <?php endif; ?>
                  
                  <div class="carousel-inner rounded-3" style="background: #000;">
                    <?php foreach($mitems as $idx=>$m): ?>
                      <div class="carousel-item <?= $idx===0?'active':'' ?>">
                        <?php if($m['tipo']==='imagen'): ?>
                          <?php
                            $r = $m['ruta']; $sizes2='(max-width: 992px) 100vw, 750px';
                            $srcsetP2=''; $srcsetW2='';
                            if(str_starts_with($r,'/')){
                              $abs2 = __DIR__ . $r; $dir2=dirname($abs2); $base2=pathinfo($abs2,PATHINFO_FILENAME); $ext2=pathinfo($abs2,PATHINFO_EXTENSION);
                              $partsP2=[]; $partsW2=[]; foreach([320,640,1024,1600] as $w){
                                $cand2=$dir2.DIRECTORY_SEPARATOR.$base2."-w{$w}.{$ext2}"; if(file_exists($cand2)){ $partsP2[]=$base2."-w{$w}.{$ext2} {$w}w"; }
                                $cand2w=$dir2.DIRECTORY_SEPARATOR.$base2."-w{$w}.webp"; if(file_exists($cand2w)){ $partsW2[]=$base2."-w{$w}.webp {$w}w"; }
                              }
                              if($partsP2){ $webDir2=dirname($r); $srcsetP2=implode(', ', array_map(fn($p)=> $webDir2.'/'.$p, $partsP2)); }
                              if($partsW2){ $webDir2=dirname($r); $srcsetW2=implode(', ', array_map(fn($p)=> $webDir2.'/'.$p, $partsW2)); }
                            }
                          ?>
                          <picture>
                            <?php if($srcsetW2): ?><source type="image/webp" srcset="<?= htmlspecialchars($srcsetW2) ?>" sizes="<?= $sizes2 ?>"><?php endif; ?>
                            <img src="<?= $base . $r ?>" <?= $srcsetP2? 'srcset="'.htmlspecialchars($srcsetP2).'"':'' ?> sizes="<?= $sizes2 ?>" class="d-block w-100" loading="lazy" decoding="async" alt="" style="max-height: 450px; object-fit: contain;">
                          </picture>
                        <?php else: ?>
                          <div class="ratio ratio-16x9">
                            <?php
            $src=$m['ruta'];
            if(str_contains($src,'watch?v=')){
              $src='https://www.youtube.com/embed/'.preg_replace('~.+watch\?v=([\w-]{11}).*~','$1',$src);
            }elseif(str_contains($src,'youtu.be/')){
              $src='https://www.youtube.com/embed/'.preg_replace('~.+youtu\.be/([\w-]{11}).*~','$1',$src);
            }elseif(preg_match('~vimeo\.com/(\d+)~',$src,$vm)){
              $src='https://player.vimeo.com/video/'.$vm[1];
            }
            ?>
            <?php
              $orig = $m['ruta'];
              // Lite embed for YouTube only
              if(preg_match('~youtu(?:\.be/|.*v=)([\w-]{11})~',$orig,$yt)){
                $ytId=$yt[1];
                $embed='https://www.youtube.com/embed/'.$ytId.'?autoplay=1';
                $thumb='https://img.youtube.com/vi/'.$ytId.'/hqdefault.jpg';
            ?>
              <div class="ratio ratio-16x9 mb-3" style="border-radius:.5rem; overflow:hidden;">
                <div class="lite-embed" data-src="<?= htmlspecialchars($embed) ?>" style="position:absolute;inset:0;background:url('<?= htmlspecialchars($thumb) ?>') center/cover no-repeat; cursor:pointer;">
                  <div style="position:absolute;inset:0;background:rgba(0,0,0,.25);"></div>
                  <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:68px;height:48px;background:#ff0000;border-radius:14px;box-shadow:0 0 30px rgba(0,0,0,.6);display:grid;place-items:center;">
                    <div style="width:0;height:0;border-left:18px solid #fff;border-top:12px solid transparent;border-bottom:12px solid transparent;margin-left:3px;"></div>
                  </div>
                </div>
              </div>
            <?php } else { ?>
              <iframe src="<?= htmlspecialchars($src) ?>" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
            <?php } ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                  <?php if(count($mitems) > 1): ?>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                  </button>
                  <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <!-- Descripción del proyecto -->
                <div class="project-description">
                  <h5 class="mb-3"><i class="bi bi-info-circle me-2"></i>Descripción</h5>
                  <p class="text-muted"><?= nl2br(htmlspecialchars($p['descripcion'])) ?></p>
                </div>
              </div>
              <div class="modal-footer border-0 bg-light">
                <div class="d-flex w-100 align-items-center justify-content-between flex-wrap gap-2">
                  <div>
                    <?php if($p['precio']): ?>
                      <div class="price-tag">
                        <span class="text-muted small">Precio:</span>
                        <span class="h4 mb-0 text-success ms-2"><?= formatCOP($p['precio']) ?></span>
                      </div>
                    <?php else: ?>
                      <span class="badge bg-success fs-6"><i class="bi bi-gift me-1"></i>Gratis</span>
                    <?php endif; ?>
                  </div>
                  <div class="d-flex gap-2">
                    <?php if($p['repo_url']): 
                      $isGithubModal = str_contains(strtolower($p['repo_url']), 'github.com');
                    ?>
                      <a href="<?= htmlspecialchars($p['repo_url']) ?>" target="_blank" class="btn <?= $isGithubModal ? 'btn-dark' : 'btn-outline-primary' ?>">
                        <?php if($isGithubModal): ?>
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                          </svg>
                          Ver en GitHub
                        <?php else: ?>
                          <i class="bi bi-box-arrow-up-right"></i>
                          Ver Demo
                        <?php endif; ?>
                      </a>
                    <?php endif; ?>
                    <a href="<?= $base ?>/store.php?id=<?= $p['id'] ?>" class="btn btn-success btn-lg">
                      <i class="bi bi-cart-plus me-1"></i>Comprar Ahora
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                      <i class="bi bi-x-circle me-1"></i>Cerrar
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- oculto: modal login -->
<div class="modal fade" id="adminLoginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="admin/login.php" method="post" class="p-4">
        <h5 class="mb-3">Acceso administrador</h5>
        <div class="mb-3">
          <label class="form-label">Usuario</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>
    </div>
  </div>
</div>
<style>
/* Estilos específicos para portfolio.php */

/* Sección lista de portafolio con fondo claro */
.portfolio-list {
  background-color: #f8f9fa !important;
  background-image: none !important;
  background: #f8f9fa !important;
}

.portfolio-list h2 {
  color: #1a202c !important;
  font-size: 2.5rem !important;
}

.portfolio-list p.lead {
  color: #4a5568 !important;
}

/* Tarjetas de proyectos con hover */
.portfolio-list .card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background-color: #ffffff !important;
  border: 1px solid #e9ecef !important;
  overflow: hidden;
}

.portfolio-list .card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
}

/* Imágenes de tarjetas con altura fija */
.portfolio-list .card-img-top {
  transition: transform 0.3s ease;
}

.portfolio-list .card:hover .card-img-top {
  transform: scale(1.05);
}

/* Botón GitHub oscuro */
.card-footer .btn-dark {
  background-color: #24292f !important;
  border-color: #24292f !important;
  color: white !important;
}

.card-footer .btn-dark:hover {
  background-color: #1c2128 !important;
  border-color: #1c2128 !important;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Alineación de iconos en botones */
.card-footer .btn svg,
.card-footer .btn i {
  vertical-align: text-top;
  margin-right: 2px;
}

/* ========== ESTILOS DEL MODAL ========== */

/* Modal más grande y elegante */
.modal-xl {
  max-width: 1140px;
}

/* Header del modal con gradiente */
.bg-gradient-primary {
  background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
}

.modal-header h5 {
  font-size: 1.25rem;
  letter-spacing: -0.3px;
}

.modal-header .badge {
  font-size: 0.75rem;
  font-weight: 500;
  padding: 0.35rem 0.6rem;
}

.modal-header.py-2 {
  padding-top: 0.75rem !important;
  padding-bottom: 0.75rem !important;
}

/* Carrusel mejorado */
.carousel-inner {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Contador de slides */
.carousel-counter {
  position: absolute;
  top: 15px;
  right: 15px;
  background: rgba(0, 0, 0, 0.7);
  color: white;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 0.875rem;
  font-weight: 600;
  z-index: 10;
  backdrop-filter: blur(5px);
}

.carousel-counter .current-slide {
  color: #0d6efd;
  font-size: 1.1rem;
}

/* Indicadores del carrusel más grandes */
.carousel-indicators [data-bs-target] {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.5);
  border: 2px solid white;
  opacity: 0.7;
  transition: all 0.3s ease;
}

.carousel-indicators .active {
  opacity: 1;
  background-color: #0d6efd;
  transform: scale(1.2);
}

/* Controles del carrusel más visibles */
.carousel-control-prev,
.carousel-control-next {
  width: 8%;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.carousel:hover .carousel-control-prev,
.carousel:hover .carousel-control-next {
  opacity: 1;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
  width: 40px;
  height: 40px;
  background-color: rgba(0, 0, 0, 0.6);
  border-radius: 50%;
  padding: 8px;
  backdrop-filter: blur(5px);
}

.carousel-control-prev:hover .carousel-control-prev-icon,
.carousel-control-next:hover .carousel-control-next-icon {
  background-color: rgba(0, 0, 0, 0.8);
  transform: scale(1.1);
}

/* Descripción del proyecto */
.project-description {
  margin-top: 2rem;
}

.project-description h5 {
  color: #1a202c;
  font-weight: 600;
  border-bottom: 2px solid #e9ecef;
  padding-bottom: 0.5rem;
}

.project-description p {
  line-height: 1.8;
  font-size: 1rem;
}

/* Footer del modal */
.modal-footer.bg-light {
  background-color: #f8f9fa !important;
  padding: 1.5rem;
}

.price-tag {
  display: flex;
  align-items: center;
}

.modal-footer .btn {
  padding: 0.625rem 1.25rem;
  font-weight: 500;
  transition: all 0.3s ease;
}

.modal-footer .btn-lg {
  padding: 0.75rem 1.5rem;
  font-size: 1.05rem;
  box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
}

.modal-footer .btn-lg:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(25, 135, 84, 0.4);
}

.modal-footer .btn-dark {
  background-color: #24292f;
  border-color: #24292f;
}

.modal-footer .btn-dark:hover {
  background-color: #1c2128;
  border-color: #1c2128;
}

/* Responsive para modal */
@media (max-width: 768px) {
  .modal-xl {
    max-width: 100%;
    margin: 0.5rem;
  }
  
  .modal-header h4 {
    font-size: 1.25rem;
  }
  
  .modal-footer .d-flex {
    flex-direction: column;
    align-items: stretch !important;
  }
  
  .modal-footer .btn {
    width: 100%;
  }
  
  .carousel-counter {
    font-size: 0.75rem;
    padding: 4px 10px;
  }
}

/* Botones de filtro mejorados */
.filter-tech .btn {
  transition: all 0.3s ease;
}

.filter-tech .btn-primary {
  background-color: #0d6efd !important;
  border-color: #0d6efd !important;
  color: #ffffff !important;
}

.filter-tech .btn-primary:hover {
  background-color: #0b5ed7 !important;
  border-color: #0a58ca !important;
}

.filter-tech .btn.active {
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Scroll suave al ancla */
html {
  scroll-behavior: smooth;
  scroll-padding-top: 80px;
}

/* Colores de tarjetas según tecnología - tonos muy suaves */
.project-card-java {
  background: linear-gradient(135deg, #fffbf5 0%, #fff9f0 100%) !important;
  border: 1px solid #f5ebe0 !important;
}

.project-card-python {
  background: linear-gradient(135deg, #f7fbff 0%, #f3f8ff 100%) !important;
  border: 1px solid #e8f0fe !important;
}

.project-card-web {
  background: linear-gradient(135deg, #fffcf9 0%, #fff8f3 100%) !important;
  border: 1px solid #ffe8dc !important;
}

.project-card-android {
  background: linear-gradient(135deg, #f8fdf8 0%, #f3faf3 100%) !important;
  border: 1px solid #e5f3e5 !important;
}

.project-card-php {
  background: linear-gradient(135deg, #fafafd 0%, #f6f6fb 100%) !important;
  border: 1px solid #ebebf5 !important;
}

/* Asegurar que el texto sea legible */
.project-card .card-title {
  color: #1a202c !important;
}

.project-card .card-text {
  color: #4a5568 !important;
}
</style>

<?php include 'includes/footer.php'; ?>
<script>
(function(){
  let clicks=0; const title=document.getElementById('portfolioTitle');
  title.addEventListener('click',()=>{clicks++; setTimeout(()=>clicks=0,400);
    if(clicks===3){var m=new bootstrap.Modal(document.getElementById('adminLoginModal'));m.show();}
  });
  // detener videos al cerrar modales
  document.querySelectorAll('.modal').forEach(m=>{
    m.addEventListener('hidden.bs.modal',()=>{
      m.querySelectorAll('iframe').forEach(f=>{const src=f.src; f.src=''; f.src=src;});
    });
  });
  
  // Actualizar contador de slides del carrusel
  document.querySelectorAll('.carousel').forEach(carousel => {
    const counter = carousel.querySelector('.current-slide');
    if(counter) {
      carousel.addEventListener('slide.bs.carousel', event => {
        counter.textContent = event.to + 1;
      });
    }
  });
  // Lite YouTube embed activation
  document.querySelectorAll('.lite-embed').forEach(el=>{
    el.setAttribute('role','button');
    el.setAttribute('tabindex','0');
    el.setAttribute('aria-label','Reproducir video');
    const activate=()=>{
      const src=el.getAttribute('data-src'); if(!src) return;
      const iframe=document.createElement('iframe');
      iframe.src=src;
      iframe.title='YouTube video';
      iframe.allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
      iframe.allowFullscreen=true;
      iframe.referrerPolicy='no-referrer-when-downgrade';
      iframe.style.position='absolute';
      iframe.style.inset='0';
      iframe.style.width='100%';
      iframe.style.height='100%';
      iframe.style.border='0';
      el.innerHTML='';
      el.appendChild(iframe);
    };
    el.addEventListener('click', activate);
    el.addEventListener('keydown', e=>{ if(e.key==='Enter' || e.key===' '){ e.preventDefault(); activate(); }});
  });
})();
</script>