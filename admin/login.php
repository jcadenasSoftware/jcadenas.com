<?php
session_start();
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';

$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $user=trim($_POST['username']??'');
    $pass=$_POST['password']??'';
    if($user!=='' && $pass!==''){
        $stmt=$pdo->prepare('SELECT id, password_hash FROM usuario WHERE username=?');
        $stmt->execute([$user]);
        $row=$stmt->fetch();
        if($row && password_verify($pass,$row['password_hash'])){
            $_SESSION['admin']=true;
            $_SESSION['admin_id'] = (int)$row['id'];
            $_SESSION['admin_user'] = $user;
            header('Location: index.php');
            exit;
        }
    }
    $err='Usuario o contraseña incorrectos';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center bg-light" style="height:100vh">
  <div class="card p-4 shadow" style="min-width:320px">
    <h4 class="mb-3 text-center">Acceso administrador</h4>
    <?php if($err): ?>
      <div class="alert alert-danger py-1"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Usuario</label>
        <input type="text" name="username" class="form-control" required autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
  </div>
</body>
</html>
