<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

// Cargar categorías y proyectos para selects
$categorias = $pdo->query('SELECT id, nombre FROM categoria ORDER BY nombre')->fetchAll();
$proyectos  = $pdo->query('SELECT id, titulo FROM proyecto ORDER BY creado_en DESC')->fetchAll();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$info = '';
$error = '';
$proj = null;

if($_SERVER['REQUEST_METHOD']==='POST'){
    $id = (int)($_POST['id'] ?? 0);
    $categoria_id = (int)($_POST['categoria_id'] ?? 0);
    $titulo       = trim($_POST['titulo'] ?? '');
    $slug         = trim($_POST['slug'] ?? '');
    $descripcion  = trim($_POST['descripcion'] ?? '');
    $repo_url     = trim($_POST['repo_url'] ?? '');
    $password_hint= trim($_POST['password_hint'] ?? '');
    $paypal_btn   = trim($_POST['paypal_button_id'] ?? '');
    $precio_in    = $_POST['precio'] ?? '';
    $destacado    = isset($_POST['destacado']) ? 1 : 0;

    if(!$id){
        $error='Selecciona un proyecto válido';
    }elseif(!$categoria_id || $titulo===''){
        $error='Categoría y título son obligatorios';
    }else{
        // Normalizar precio a decimal(8,2). Permitimos entrada con coma o punto
        $precio_norm = null;
        if($precio_in !== ''){
            $tmp = str_replace(['.',' '], '', (string)$precio_in); // quitar separadores de miles
            $tmp = str_replace([','], '.', $tmp); // decimal a punto
            $precio_norm = number_format((float)$tmp, 2, '.', '');
        }
        try{
            $stmt=$pdo->prepare('UPDATE proyecto SET categoria_id=?, titulo=?, slug=?, descripcion=?, repo_url=?, precio=?, paypal_button_id=?, destacado=?, password_hint=? WHERE id=?');
            $stmt->execute([$categoria_id,$titulo,$slug,$descripcion,$repo_url,$precio_norm,($paypal_btn?:null),$destacado,$password_hint,$id]);
            $info='Proyecto actualizado correctamente';
        }catch(Throwable $e){
            $error='Error al actualizar: '.$e->getMessage();
        }
    }
}

if($id){
    $stmt=$pdo->prepare('SELECT * FROM proyecto WHERE id=?');
    $stmt->execute([$id]);
    $proj=$stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar proyecto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="<?= $base ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body class="bg-light">
  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-dark shadow-sm mb-4">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h1">
        <i class="bi bi-pencil-square me-2"></i>Editar Proyecto
      </span>
      <a href="index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i> Volver al panel</a>
    </div>
  </nav>

  <div class="container py-4">
    <?php if($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-circle-fill me-2"></i><?= htmlspecialchars($error) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <?php if($info): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($info) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Selector de proyecto -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3"><i class="bi bi-search me-2"></i>Selecciona el proyecto a editar</h5>
        <form method="get">
          <div class="row g-3">
            <div class="col-md-10">
              <select name="id" class="form-select" required onchange="this.form.submit()">
                <option value="">Selecciona un proyecto...</option>
                <?php foreach($proyectos as $p): ?>
                  <option value="<?= $p['id'] ?>" <?= $id===$p['id']?'selected':'' ?>><?= htmlspecialchars($p['titulo']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <?php if($proj): ?>
    <form method="post" class="card p-4 bg-white border-0 shadow-sm">
      <input type="hidden" name="id" value="<?= $proj['id'] ?>">
      
      <h5 class="card-title mb-4"><i class="bi bi-info-circle me-2"></i>Información del Proyecto</h5>
      
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label fw-semibold"><i class="bi bi-tags me-1"></i>Categoría <span class="text-danger">*</span></label>
          <select name="categoria_id" class="form-select" required>
            <?php foreach($categorias as $c): ?>
              <option value="<?= $c['id'] ?>" <?= ($proj['categoria_id']==$c['id'])?'selected':'' ?>><?= htmlspecialchars($c['nombre']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-8">
          <label class="form-label fw-semibold"><i class="bi bi-pencil me-1"></i>Título <span class="text-danger">*</span></label>
          <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($proj['titulo']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold"><i class="bi bi-link-45deg me-1"></i>Slug (URL amigable)</label>
          <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($proj['slug'] ?? '') ?>" placeholder="opcional">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold"><i class="bi bi-github me-1"></i>Repositorio / Demo (URL)</label>
          <input type="url" name="repo_url" class="form-control" value="<?= htmlspecialchars($proj['repo_url'] ?? '') ?>" placeholder="https://...">
        </div>
        <div class="col-12">
          <label class="form-label fw-semibold"><i class="bi bi-text-paragraph me-1"></i>Descripción</label>
          <textarea name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($proj['descripcion'] ?? '') ?></textarea>
        </div>
      </div>

      <hr class="my-4">
      <h5 class="card-title mb-4"><i class="bi bi-cash-coin me-2"></i>Monetización</h5>
      
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label fw-semibold"><i class="bi bi-currency-dollar me-1"></i>Precio (COP)</label>
          <input type="text" name="precio" id="precioInput" class="form-control" value="<?= htmlspecialchars($proj['precio'] ?? '') ?>" placeholder="Ej: 120.000,00" inputmode="decimal" autocomplete="off">
          <div class="form-text">Vista previa: <span id="precioPreview" class="fw-semibold"><?= formatCOP($proj['precio'] ?? 0) ?></span></div>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold"><i class="bi bi-paypal me-1"></i>PayPal Button ID</label>
          <input type="text" name="paypal_button_id" class="form-control" value="<?= htmlspecialchars($proj['paypal_button_id'] ?? '') ?>" placeholder="Ej: 4N593H9E8YGLC">
          <div class="form-text">ID del botón alojado en PayPal</div>
        </div>
        <div class="col-md-4 d-flex align-items-center">
          <div class="form-check form-switch mt-3">
            <input class="form-check-input" type="checkbox" name="destacado" id="chkDest" role="switch" <?= !empty($proj['destacado'])?'checked':'' ?>>
            <label class="form-check-label fw-semibold" for="chkDest">
              <i class="bi bi-star-fill text-warning me-1"></i>Proyecto Destacado
            </label>
          </div>
        </div>
      </div>

      <hr class="my-4">
      <h5 class="card-title mb-4"><i class="bi bi-shield-lock me-2"></i>Seguridad de Descarga</h5>
      
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label fw-semibold"><i class="bi bi-key me-1"></i>Pista de contraseña del ZIP</label>
          <input type="text" name="password_hint" class="form-control" value="<?= htmlspecialchars($proj['password_hint'] ?? '') ?>" placeholder="Ej: nombre del framework, versión, etc.">
          <div class="form-text"><i class="bi bi-info-circle me-1"></i>Solo modifica la pista. La contraseña del ZIP no se cambia aquí.</div>
        </div>
      </div>

      <hr class="my-4">
      
      <div class="d-flex gap-2 justify-content-between align-items-center flex-wrap">
        <a href="upload_media.php?proyecto_id=<?= $proj['id'] ?>" class="btn btn-outline-success">
          <i class="bi bi-cloud-upload me-1"></i>Subir Más Media
        </a>
        <div class="d-flex gap-2">
          <a href="index.php" class="btn btn-secondary">
            <i class="bi bi-x-circle me-1"></i>Cancelar
          </a>
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-save me-1"></i>Guardar Cambios
          </button>
        </div>
      </div>
    </form>

    <!-- Galería de Multimedia -->
    <?php if($proj): ?>
      <?php 
      $stmt_media = $pdo->prepare('SELECT * FROM media WHERE proyecto_id=? ORDER BY tipo DESC, orden');
      $stmt_media->execute([$proj['id']]);
      $media_items = $stmt_media->fetchAll();
      ?>
      
      <?php if($media_items): ?>
      <div class="card mt-4 border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="mb-0"><i class="bi bi-collection me-2"></i>Archivos Multimedia (<?= count($media_items) ?>)</h5>
          <p class="text-muted small mb-0 mt-1">Gestiona las imágenes y videos de este proyecto</p>
        </div>
        <div class="card-body">
          <div class="row g-3" id="mediaGallery">
            <?php foreach($media_items as $media): ?>
              <div class="col-md-4 col-lg-3" data-media-id="<?= $media['id'] ?>">
                <div class="card media-card h-100">
                  <?php if($media['tipo'] === 'imagen'): ?>
                    <img src="<?= $base . htmlspecialchars($media['ruta']) ?>" class="card-img-top" alt="" style="height: 180px; object-fit: cover;">
                  <?php else: ?>
                    <?php
                    $videoUrl = $media['ruta'];
                    $thumbUrl = 'https://via.placeholder.com/300x180?text=Video';
                    if(preg_match('~youtu(?:\.be/|.*v=)([\w-]{11})~', $videoUrl, $m)){
                      $thumbUrl = 'https://img.youtube.com/vi/'.$m[1].'/mqdefault.jpg';
                    }
                    ?>
                    <div class="position-relative">
                      <img src="<?= $thumbUrl ?>" class="card-img-top" alt="Video" style="height: 180px; object-fit: cover;">
                      <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                          <i class="bi bi-play-fill text-white fs-4"></i>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                  <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="badge <?= $media['tipo']==='video'?'bg-danger':'bg-success' ?>">
                        <i class="bi bi-<?= $media['tipo']==='video'?'play-circle':'image' ?>"></i>
                        <?= ucfirst($media['tipo']) ?>
                      </span>
                      <small class="text-muted">Orden: <?= $media['orden'] ?></small>
                    </div>
                    <?php if($media['tipo'] === 'video'): ?>
                      <div class="mt-2">
                        <small class="text-muted d-block text-truncate" title="<?= htmlspecialchars($media['ruta']) ?>">
                          <?= htmlspecialchars(mb_strimwidth($media['ruta'], 0, 40, '...')) ?>
                        </small>
                      </div>
                    <?php endif; ?>
                    <button class="btn btn-sm btn-outline-danger w-100 mt-2 delete-media-btn" data-id="<?= $media['id'] ?>" data-type="<?= $media['tipo'] ?>">
                      <i class="bi bi-trash"></i> Eliminar
                    </button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php else: ?>
      <div class="alert alert-info mt-4">
        <i class="bi bi-info-circle me-2"></i>No hay multimedia asociada a este proyecto. 
        <a href="upload_media.php?proyecto_id=<?= $proj['id'] ?>" class="alert-link">Sube imágenes o videos</a>
      </div>
      <?php endif; ?>
    <?php endif; ?>
    <?php endif; ?>
  </div>
<script>
  (function(){
    const input = document.getElementById('precioInput');
    const preview = document.getElementById('precioPreview');
    if(!input) return;
    function formatCOP(num){
      if(num===''||num==null) return '';
      const n = Number(num);
      if(isNaN(n)) return '';
      return '$ ' + n.toLocaleString('es-CO', {minimumFractionDigits: 0, maximumFractionDigits: 2});
    }
    function normalizeForCalc(str){
      // quita separadores de miles y cambia coma a punto
      if(!str) return '';
      let s = String(str).replace(/\./g,'').replace(/\s+/g,'');
      s = s.replace(/,/g,'.');
      return s;
    }
    function onInput(){
      // Mantener caret es complejo; haremos formateo suave en blur y vista previa en vivo
      const raw = input.value;
      const norm = normalizeForCalc(raw);
      const n = parseFloat(norm);
      preview.textContent = isNaN(n)? '' : formatCOP(n);
    }
    function onBlur(){
      const norm = normalizeForCalc(input.value);
      if(norm==='') { preview.textContent=''; return; }
      const n = parseFloat(norm);
      if(!isNaN(n)){
        // Mostrar con separadores y coma
        input.value = n.toLocaleString('es-CO', {minimumFractionDigits: 0, maximumFractionDigits: 2}).replace(/\u00A0/g,' ');
        preview.textContent = formatCOP(n);
      }
    }
    input.addEventListener('input', onInput);
    input.addEventListener('blur', onBlur);
    // inicial
    onInput();
  })();

  // Eliminar multimedia
  document.querySelectorAll('.delete-media-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
      const mediaId = this.dataset.id;
      const mediaType = this.dataset.type;
      
      if(!confirm(`¿Eliminar este ${mediaType === 'video' ? 'video' : 'imagen'}?\nEsta acción no se puede deshacer.`)) {
        return;
      }
      
      try {
        const response = await fetch('delete_media.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: `media_id=${mediaId}`
        });
        
        const result = await response.json();
        
        if(result.success) {
          // Eliminar del DOM
          const card = this.closest('[data-media-id]');
          card.style.transition = 'opacity 0.3s';
          card.style.opacity = '0';
          setTimeout(() => card.remove(), 300);
          
          // Mostrar mensaje
          const alert = document.createElement('div');
          alert.className = 'alert alert-success alert-dismissible fade show';
          alert.innerHTML = `<i class="bi bi-check-circle me-2"></i>${result.message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
          document.querySelector('.container').insertBefore(alert, document.querySelector('.container').firstChild);
          
          // Auto-cerrar
          setTimeout(() => alert.remove(), 3000);
        } else {
          alert('Error: ' + result.message);
        }
      } catch(error) {
        alert('Error al eliminar el archivo');
      }
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
