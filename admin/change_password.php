<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

session_start();
$info = '';
$error = '';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $current = $_POST['current_password'] ?? '';
  $new1    = $_POST['new_password'] ?? '';
  $new2    = $_POST['new_password_confirm'] ?? '';

  if($new1 === '' || $new2 === ''){
    $error = 'La nueva contraseña es obligatoria';
  }elseif($new1 !== $new2){
    $error = 'La confirmación no coincide';
  }elseif(strlen($new1) < 8){
    $error = 'La nueva contraseña debe tener al menos 8 caracteres';
  } else {
    try{
      // obtener usuario actual
      $user = $_SESSION['admin_user'] ?? '';
      $stmt=$pdo->prepare('SELECT id,password_hash FROM usuario WHERE username=?');
      $stmt->execute([$user]);
      $row=$stmt->fetch();
      if(!$row){
        $error='Usuario inválido en sesión';
      }elseif(!password_verify($current, $row['password_hash'])){
        $error='La contraseña actual es incorrecta';
      }else{
        $newHash = password_hash($new1, PASSWORD_BCRYPT);
        $upd=$pdo->prepare('UPDATE usuario SET password_hash=? WHERE id=?');
        $upd->execute([$newHash, $row['id']]);
        $info='Contraseña actualizada correctamente';
      }
    }catch(Throwable $e){
      $error = 'Error: '.$e->getMessage();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cambiar contraseña</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= $base ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4">Cambiar contraseña</h1>
    <?php if($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if($info): ?><div class="alert alert-success"><?= htmlspecialchars($info) ?></div><?php endif; ?>
    <form method="post" class="card p-4 bg-white border-0 shadow-sm" autocomplete="off">
      <div class="mb-3">
        <label class="form-label">Contraseña actual</label>
        <input type="password" name="current_password" class="form-control" required>
      </div>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nueva contraseña</label>
          <input type="password" name="new_password" class="form-control" required minlength="8">
        </div>
        <div class="col-md-6">
          <label class="form-label">Confirmar nueva contraseña</label>
          <input type="password" name="new_password_confirm" class="form-control" required minlength="8">
        </div>
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a class="btn btn-secondary ms-2" href="index.php">Volver</a>
      </div>
    </form>
  </div>
</body>
</html>
