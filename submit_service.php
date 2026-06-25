<?php
require_once 'db.php';
$nombre = trim($_POST['nombre']??'');
$email  = trim($_POST['email']??'');
$tel    = trim($_POST['telefono']??'');
$serv   = trim($_POST['servicio']??'');
$pres   = trim($_POST['presupuesto']??'');
$plazo  = trim($_POST['plazo']??'');
$desc   = trim($_POST['descripcion']??'');
$ref    = trim($_POST['referencia']??'');
if($nombre && filter_var($email,FILTER_VALIDATE_EMAIL) && $serv && $desc){
  $pdo->prepare('CREATE TABLE IF NOT EXISTS solicitudes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120),
    email VARCHAR(120),
    telefono VARCHAR(60),
    servicio VARCHAR(60),
    presupuesto VARCHAR(40),
    plazo VARCHAR(40),
    referencia VARCHAR(255),
    descripcion TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )')->execute();
  $stmt=$pdo->prepare('INSERT INTO solicitudes(nombre,email,telefono,servicio,presupuesto,plazo,referencia,descripcion) VALUES(?,?,?,?,?,?,?,?)');
  $stmt->execute([$nombre,$email,$tel,$serv,$pres,$plazo,$ref,$desc]);
  // send email
  $mensaje="Nombre: $nombre\nEmail: $email\nTel: $tel\nServicio: $serv\nPresupuesto: $pres\nPlazo: $plazo\nReferencia: $ref\nDescripcion:\n$desc";
  @mail('servicios@jcadenas.com','Nueva solicitud de servicio',$mensaje);
  header('Location: services.php?sent=1');
  exit;
}
header('Location: services.php?error=1');
