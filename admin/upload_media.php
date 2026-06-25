<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

// proyectos para el select
$proyectos = $pdo->query('SELECT id, titulo FROM proyecto ORDER BY creado_en DESC')->fetchAll();

$msg='';
$ok=false;
$isAjax = (
  (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest')
  || (isset($_POST['ajax']) && $_POST['ajax']==='1')
);

// Endpoint AJAX: obtener info del paquete del proyecto
if(isset($_GET['project_info'])){
    $pid=(int)$_GET['project_info'];
    $stmt=$pdo->prepare('SELECT download_path, download_mime, download_size, password_hint, updated_at FROM proyecto WHERE id=?');
    $stmt->execute([$pid]);
    $row=$stmt->fetch();
    header('Content-Type: application/json');
    if(!$row || empty($row['download_path'])){
        echo json_encode(['hasPackage'=>false]);
    }else{
        $name = basename($row['download_path']);
        $size = (int)($row['download_size']??0);
        echo json_encode([
            'hasPackage'=>true,
            'filename'=>$name,
            'mime'=>$row['download_mime'],
            'sizeBytes'=>$size,
            'sizeHuman'=>($size? (number_format($size/1048576,2).' MB') : '—'),
            'hint'=>$row['password_hint'],
            'updated_at'=>$row['updated_at'],
        ]);
    }
    exit;
}

// Endpoint AJAX: eliminar paquete existente
if($isAjax && isset($_POST['action']) && $_POST['action']==='delete_package'){
    $pid=(int)($_POST['proyecto_id']??0);
    $stmt=$pdo->prepare('SELECT download_path FROM proyecto WHERE id=?');
    $stmt->execute([$pid]);
    $path=$stmt->fetchColumn();
    $okDel=false; $msgDel='';
    if($path){
        $abs = (preg_match('~^[A-Za-z]:\\\\|^/~', $path)) ? $path : rtrim(SECURE_DOWNLOAD_BASE,'/\\').DIRECTORY_SEPARATOR.$path;
        if(is_file($abs)){ @unlink($abs); }
        $upd=$pdo->prepare('UPDATE proyecto SET download_path=NULL, download_mime=NULL, download_size=NULL, password_encrypted=NULL, password_hint=NULL, updated_at=NOW() WHERE id=?');
        $upd->execute([$pid]);
        $okDel=true; $msgDel='Paquete eliminado';
    } else { $msgDel='No hay paquete para eliminar'; }
    header('Content-Type: application/json');
    echo json_encode(['ok'=>$okDel,'message'=>$msgDel]);
    exit;
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $proyecto_id =(int)($_POST['proyecto_id']??0);
    $tipo        = $_POST['tipo']??'imagen';
    $orden       = (int)($_POST['orden']??0);

    if(!$proyecto_id){
        $msg='Selecciona proyecto';
    }elseif($tipo==='imagen'){
        if(!isset($_FILES['image_file'])){
            $msg='No se recibió archivo';
        }elseif($_FILES['image_file']['error']!==UPLOAD_ERR_OK){
            $errMap=[
              UPLOAD_ERR_INI_SIZE=>'El archivo excede upload_max_filesize',
              UPLOAD_ERR_FORM_SIZE=>'El archivo excede MAX_FILE_SIZE del formulario',
              UPLOAD_ERR_PARTIAL=>'El archivo se subió parcialmente',
              UPLOAD_ERR_NO_FILE=>'No se seleccionó archivo',
              UPLOAD_ERR_NO_TMP_DIR=>'Falta carpeta temporal en el servidor',
              UPLOAD_ERR_CANT_WRITE=>'No se pudo escribir el archivo en disco',
              UPLOAD_ERR_EXTENSION=>'Una extensión de PHP detuvo la subida'
            ];
            $code=(int)$_FILES['image_file']['error'];
            $msg=$errMap[$code] ?? ('Error de subida (código '.$code.')');
        } else {
            // Validar MIME
            $finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
            $mime = $finfo ? finfo_file($finfo, $_FILES['image_file']['tmp_name']) : null;
            if($finfo) finfo_close($finfo);
            $allowed=['image/jpeg','image/png','image/webp'];
            if($mime && !in_array($mime,$allowed,true)){
                $msg='Tipo de imagen no permitido (solo JPG, PNG, WEBP)';
            } else {
                // subir imagen
                $uploadDir = __DIR__.'/../assets/img/portfolio/';
                if(!is_dir($uploadDir)){
                    mkdir($uploadDir, 0775, true);
                }
                $cleanName = preg_replace('/[^A-Za-z0-9._-]/','_', basename($_FILES['image_file']['name']));
                $filename = time().'_'.$cleanName;
                $dest = $uploadDir.$filename;
                if(move_uploaded_file($_FILES['image_file']['tmp_name'],$dest)){
                    // crear variantes responsivas
                    try{
                      $sizes=[320,640,1024,1600];
                      $ext=strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                      $srcPath=$dest;
                      // cargar imagen
                      if($mime==='image/jpeg' || $ext==='jpg' || $ext==='jpeg'){
                        $createFn='imagecreatefromjpeg'; $saveFn='imagejpeg'; $quality=82;
                      }elseif($mime==='image/png' || $ext==='png'){
                        $createFn='imagecreatefrompng'; $saveFn=function($im,$to){ imagepng($im,$to,6); }; $quality=null;
                      }elseif($mime==='image/webp' || $ext==='webp'){
                        $createFn='imagecreatefromwebp'; $saveFn='imagewebp'; $quality=82;
                      }else{ $createFn=null; $saveFn=null; }
                      if($createFn && $saveFn && function_exists($createFn)){
                        $srcIm=@$createFn($srcPath);
                        if($srcIm){
                          $w=imagesx($srcIm); $h=imagesy($srcIm);
                          // generar versión webp del original
                          if(function_exists('imagewebp')){
                            $webpOriginal = $uploadDir.pathinfo($filename,PATHINFO_FILENAME).'.webp';
                            @imagewebp($srcIm, $webpOriginal, 82);
                          }
                          foreach($sizes as $tw){
                            if($tw >= $w) continue; // no ampliar
                            $th=(int)round($h*$tw/$w);
                            $dst=imagecreatetruecolor($tw,$th);
                            // preservar transparencia
                            imagealphablending($dst,false); imagesavealpha($dst,true);
                            imagecopyresampled($dst,$srcIm,0,0,0,0,$tw,$th,$w,$h);
                            $out=$uploadDir.pathinfo($filename,PATHINFO_FILENAME)."-w{$tw}.{$ext}";
                            if(is_callable($saveFn)){
                              if($quality===null){ $saveFn($dst,$out); } else { $saveFn($dst,$out,$quality); }
                            }else{
                              // callable string
                              if($quality===null){ $saveFn($dst,$out); } else { $saveFn($dst,$out,$quality); }
                            }
                            // webp variante
                            if(function_exists('imagewebp')){
                              $outWebp=$uploadDir.pathinfo($filename,PATHINFO_FILENAME)."-w{$tw}.webp";
                              @imagewebp($dst,$outWebp,82);
                            }
                            imagedestroy($dst);
                          }
                          imagedestroy($srcIm);
                        }
                      }
                    }catch(Throwable $e){ /* ignorar fallas de redimensionado */ }
                    $ruta='/assets/img/portfolio/'.$filename;
                    $stmt=$pdo->prepare('INSERT INTO media (proyecto_id,tipo,ruta,orden) VALUES (?,?,?,?)');
                    $stmt->execute([$proyecto_id,'imagen',$ruta,$orden]);
                    $msg='Imagen subida';
                    $ok=true;
                } else { $msg='Error al mover archivo (permiso o ruta inválida)'; }
            }
        }
    }elseif($tipo==='video'){
        $ruta = trim($_POST['video_url']??'');
        // convertir enlaces de YouTube / Vimeo a formato embed
        if(preg_match('~youtube\.com/watch\?v=([\w-]{11})~i',$ruta,$m)){
            $ruta = 'https://www.youtube.com/embed/'.$m[1];
        }elseif(preg_match('~youtu\.be/([\w-]{11})~i',$ruta,$m)){
            $ruta = 'https://www.youtube.com/embed/'.$m[1];
        }elseif(preg_match('~vimeo\.com/(\d+)~i',$ruta,$m)){
            $ruta = 'https://player.vimeo.com/video/'.$m[1];
        }
        if($ruta===''){$msg='URL vacía';} else {
            $stmt=$pdo->prepare('INSERT INTO media (proyecto_id,tipo,ruta,orden) VALUES (?,?,?,?)');
            $stmt->execute([$proyecto_id,'video',$ruta,$orden]);
            $msg='Video añadido';
            $ok=true;
        }
    }elseif($tipo==='paquete' && isset($_FILES['package_file']) && $_FILES['package_file']['error']==0){
        // subir paquete descargable (.zip / .7z) fuera del webroot
        $pass = trim($_POST['zip_password'] ?? '');
        $hint = trim($_POST['zip_hint'] ?? '');
        if($pass===''){
            $msg='La contraseña del paquete es obligatoria';
        } else {
            $allowedExt = ['zip','7z'];
            $cleanName = preg_replace('/[^A-Za-z0-9._-]/','_', basename($_FILES['package_file']['name']));
            $ext = strtolower(pathinfo($cleanName, PATHINFO_EXTENSION));
            if(!in_array($ext,$allowedExt,true)){
                $msg='Extensión no permitida. Usa .zip o .7z';
            } else {
                $projectDir = rtrim(SECURE_DOWNLOAD_BASE,'/\\').DIRECTORY_SEPARATOR.$proyecto_id.DIRECTORY_SEPARATOR;
                if(!is_dir($projectDir)){
                    @mkdir($projectDir, 0775, true);
                }
                $unique = 'project_'.$proyecto_id.'_'.date('Ymd_His').'_'.bin2hex(random_bytes(3)).'.'.$ext;
                $dest = $projectDir.$unique;
                if(move_uploaded_file($_FILES['package_file']['tmp_name'],$dest)){
                    // metadata
                    $size = filesize($dest) ?: 0;
                    $finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : false;
                    $mime = $finfo ? finfo_file($finfo,$dest) : null;
                    if($finfo) finfo_close($finfo);
                    if(!$mime){ $mime = $ext==='7z' ? 'application/x-7z-compressed' : 'application/zip'; }
                    // cifrar contraseña
                    $passEnc = encryptSecret($pass);
                    // si ya existe un paquete previo, eliminarlo para liberar espacio
                    $prev = $pdo->prepare('SELECT download_path FROM proyecto WHERE id=?');
                    $prev->execute([$proyecto_id]);
                    $prevPath = $prev->fetchColumn();
                    if($prevPath){
                        $absPrev = (preg_match('~^[A-Za-z]:\\\\|^/~', $prevPath)) ? $prevPath : rtrim(SECURE_DOWNLOAD_BASE,'/\\').DIRECTORY_SEPARATOR.$prevPath;
                        if(is_file($absPrev)){ @unlink($absPrev); }
                    }
                    // actualizar proyecto
                    $relative = $proyecto_id . '/' . basename($unique);
                    $stmt=$pdo->prepare('UPDATE proyecto SET download_path=?, download_mime=?, download_size=?, password_encrypted=?, password_hint=?, updated_at=NOW() WHERE id=?');
                    $stmt->execute([$relative,$mime,$size,$passEnc,$hint,$proyecto_id]);
                    $existsNow = is_file($dest) ? 'sí' : 'no';
                    $msg='Paquete subido correctamente. Ruta relativa: ' . $relative . ' · Existe en servidor: ' . $existsNow;
                    $ok=true;
                } else { $msg='Error al mover el archivo del paquete'; }
            }
        }
    }else{
        $msg='Selecciona un archivo válido';
    }
}

// Si es AJAX, responder JSON y salir
if($isAjax){
    header('Content-Type: application/json');
    echo json_encode(['ok'=>$ok,'message'=>$msg]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Subir media</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="<?= $base ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4">Subir imágenes / videos / paquete</h1>
    <?php if($msg): ?><div class="alert alert-info" id="serverMessage"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="card p-4 form-card bg-white border-0 shadow-sm">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Proyecto</label>
          <select name="proyecto_id" class="form-select" required>
            <option value="">Selecciona...</option>
            <?php foreach($proyectos as $p): ?>
              <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['titulo']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Orden</label>
          <input type="number" name="orden" class="form-control" value="0">
        </div>
        <div class="col-md-3">
          <label class="form-label">Tipo</label>
          <select name="tipo" class="form-select" id="tipoSelect">
            <option value="imagen">Imagen</option>
            <option value="video">Video</option>
            <option value="paquete">Paquete descargable (.zip/.7z)</option>
          </select>
        </div>
        <div class="col-12" id="imagenField">
          <label class="form-label">Archivo de imagen (jpg, png, webp)</label>
          <input type="file" name="image_file" class="form-control" accept="image/jpeg,image/png,image/webp">
        </div>
        <div class="col-12 d-none" id="videoField">
          <label class="form-label">URL del video (YouTube, Vimeo, etc.)</label>
          <input type="url" name="video_url" class="form-control">
        </div>
        <div class="col-12 d-none" id="paqueteField">
          <label class="form-label">Archivo de paquete (.zip o .7z)</label>
          <input type="file" name="package_file" class="form-control" accept=".zip,.7z">
          <div class="row mt-2">
            <div class="col-md-6">
              <label class="form-label">Contraseña del archivo</label>
              <input type="text" name="zip_password" class="form-control" placeholder="Requerida">
            </div>
            <div class="col-md-6">
              <label class="form-label">Pista de contraseña (opcional)</label>
              <input type="text" name="zip_hint" class="form-control" placeholder="Opcional">
            </div>
          </div>
          <div class="form-text">
            El archivo se guardará de forma segura fuera del webroot.
            Tamaño máximo por PHP: <?php echo htmlspecialchars(ini_get('upload_max_filesize').' / '.ini_get('post_max_size')); ?>
          </div>
          <div class="card mt-3 d-none" id="packageSummary">
            <div class="card-body py-2">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <div class="small text-muted">Paquete actual</div>
                  <div><strong id="pkgName">—</strong> <span class="badge bg-secondary" id="pkgSize"></span></div>
                  <div class="text-muted small">Actualizado: <span id="pkgUpdated">—</span> · Hint: <span id="pkgHint">—</span></div>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm" id="btnDeletePkg"><i class="bi bi-trash"></i> Eliminar</button>
              </div>
            </div>
          </div>
          <div class="progress mt-3 d-none" id="uploadProgressWrap" style="height:12px;">
            <div id="uploadProgress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:0%">0%</div>
          </div>
        </div>
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php" class="btn btn-secondary ms-2">Volver</a>
      </div>
    </form>
  </div>
<script>
  const tipoSel=document.getElementById('tipoSelect');
  const imgField=document.getElementById('imagenField');
  const vidField=document.getElementById('videoField');
  const pkgField=document.getElementById('paqueteField');
  const form=document.querySelector('form[enctype="multipart/form-data"]');
  const progressWrap=document.getElementById('uploadProgressWrap');
  const progressBar=document.getElementById('uploadProgress');
  const submitBtn=form.querySelector('button[type="submit"]');
  const serverMsg=document.getElementById('serverMessage');
  // Summary elements
  const pkgSummary=document.getElementById('packageSummary');
  const pkgName=document.getElementById('pkgName');
  const pkgSize=document.getElementById('pkgSize');
  const pkgUpdated=document.getElementById('pkgUpdated');
  const pkgHint=document.getElementById('pkgHint');
  const btnDeletePkg=document.getElementById('btnDeletePkg');
  tipoSel.addEventListener('change',()=>{
    if(tipoSel.value==='video'){
      vidField.classList.remove('d-none');
      imgField.classList.add('d-none');
      pkgField.classList.add('d-none');
    }else{
      if(tipoSel.value==='paquete'){
        pkgField.classList.remove('d-none');
        imgField.classList.add('d-none');
        vidField.classList.add('d-none');
      } else {
        imgField.classList.remove('d-none');
        vidField.classList.add('d-none');
        pkgField.classList.add('d-none');
      }
    }
  });

  // Cargar info de paquete al cambiar proyecto
  const proyectoSelect=document.querySelector('select[name="proyecto_id"]');
  async function loadPackageInfo(){
    const pid=proyectoSelect.value;
    if(!pid){ pkgSummary.classList.add('d-none'); return; }
    try{
      const res=await fetch(window.location.pathname + '?project_info=' + encodeURIComponent(pid), {headers:{'X-Requested-With':'XMLHttpRequest'}});
      const data=await res.json();
      if(data.hasPackage){
        pkgName.textContent=data.filename;
        pkgSize.textContent=data.sizeHuman;
        pkgUpdated.textContent=data.updated_at||'—';
        pkgHint.textContent=data.hint||'—';
        pkgSummary.classList.remove('d-none');
      }else{
        pkgSummary.classList.add('d-none');
      }
    }catch(_e){ pkgSummary.classList.add('d-none'); }
  }
  proyectoSelect.addEventListener('change', loadPackageInfo);
  // inicial
  loadPackageInfo();

  // Eliminar paquete
  if(btnDeletePkg){
    btnDeletePkg.addEventListener('click', async ()=>{
      const pid=proyectoSelect.value; if(!pid) return;
      if(!confirm('¿Eliminar el paquete actual? Esta acción no se puede deshacer.')) return;
      const fd=new FormData();
      fd.append('ajax','1');
      fd.append('action','delete_package');
      fd.append('proyecto_id', pid);
      const res=await fetch(window.location.href, {method:'POST', body:fd, headers:{'X-Requested-With':'XMLHttpRequest'}});
      const json=await res.json().catch(()=>({ok:false,message:'Error inesperado'}));
      const alert=document.createElement('div');
      alert.className='alert '+(json.ok?'alert-success':'alert-danger');
      alert.textContent=json.message|| (json.ok?'Eliminado':'Error');
      form.parentNode.insertBefore(alert, form);
      if(json.ok){ pkgSummary.classList.add('d-none'); }
    });
  }

  // Envío con progreso para paquete
  form.addEventListener('submit', function(e){
    if(tipoSel.value!== 'paquete') return; // comportamiento normal para imagen/video
    e.preventDefault();

    // Reset barra
    progressBar.style.width='0%';
    progressBar.textContent='0%';
    progressWrap.classList.remove('d-none');
    submitBtn.disabled=true;
    if(serverMsg) serverMsg.remove();

    const fd=new FormData(form);
    fd.append('ajax','1');

    const xhr=new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
    xhr.upload.addEventListener('progress', (ev)=>{
      if(ev.lengthComputable){
        const pct=Math.round((ev.loaded/ev.total)*100);
        progressBar.style.width=pct+'%';
        progressBar.textContent=pct+'%';
      }
    });
    xhr.onreadystatechange=function(){
      if(xhr.readyState===4){
        submitBtn.disabled=false;
        try{
          const res=JSON.parse(xhr.responseText||'{}');
          const alert=document.createElement('div');
          alert.className='alert '+(res.ok?'alert-success':'alert-danger');
          alert.textContent=res.message|| (res.ok?'Subida completada':'Error en la subida');
          form.parentNode.insertBefore(alert, form);
          if(res.ok){
            progressBar.classList.remove('progress-bar-animated');
            progressBar.classList.add('bg-success');
            progressBar.textContent='Completado';
          }else{
            progressBar.classList.add('bg-danger');
          }
        }catch(_e){ /* ignore */ }
      }
    };
    xhr.send(fd);
  });
</script>
</body>
</html>
