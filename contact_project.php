<?php
require_once 'db.php';
$proyecto_id = (int)($_POST['proyecto_id'] ?? 0);
$nombre  = trim($_POST['nombre'] ?? '');
$email   = trim($_POST['email'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');
if($proyecto_id && filter_var($email,FILTER_VALIDATE_EMAIL) && $nombre!=='' && $mensaje!==''){
  // guardar en tabla leads sencilla
  $pdo->prepare('CREATE TABLE IF NOT EXISTS leads(
    id INT AUTO_INCREMENT PRIMARY KEY,
    proyecto_id INT,
    nombre VARCHAR(120),
    email VARCHAR(120),
    mensaje TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )')->execute();
  $stmt=$pdo->prepare('INSERT INTO leads(proyecto_id,nombre,email,mensaje) VALUES (?,?,?,?)');
  $stmt->execute([$proyecto_id,$nombre,$email,$mensaje]);
  // enviar correo al admin (configure mail)
  @mail('servicios@jcadenas.com','Nuevo Lead Portafolio',"Proyecto ID: $proyecto_id\nNombre: $nombre\nEmail: $email\nMensaje: $mensaje");
  header('Location: store.php?id='.$proyecto_id.'&sent=1');
  exit;
}
header('Location: store.php?id='.$proyecto_id.'&error=1');
