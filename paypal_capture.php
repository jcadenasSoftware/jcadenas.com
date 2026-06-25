<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/db.php';

header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD']!=='POST'){ http_response_code(405); echo json_encode(['ok'=>false,'error'=>'Method not allowed']); exit; }

$data=json_decode(file_get_contents('php://input'), true) ?: [];
$orderID = $data['orderID'] ?? '';
$projectId = (int)($data['projectId'] ?? 0);
$buyerName = trim($data['name'] ?? '');
$buyerEmail = trim($data['email'] ?? '');

if(!$orderID || !$projectId || !$buyerEmail){ http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Missing fields']); exit; }

// Get PayPal access token
$baseUrl = PAYPAL_ENV==='live' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';
$ch = curl_init($baseUrl.'/v1/oauth2/token');
curl_setopt_array($ch,[
  CURLOPT_HTTPAUTH=>CURLAUTH_BASIC,
  CURLOPT_USERPWD=>PAYPAL_CLIENT_ID.':'.PAYPAL_CLIENT_SECRET,
  CURLOPT_POST=>true,
  CURLOPT_POSTFIELDS=>'grant_type=client_credentials',
  CURLOPT_RETURNTRANSFER=>true
]);
$auth = curl_exec($ch);
if($auth===false){ echo json_encode(['ok'=>false,'error'=>'PayPal auth failed']); exit; }
$authJson = json_decode($auth,true);
$accessToken = $authJson['access_token'] ?? '';
if(!$accessToken){ echo json_encode(['ok'=>false,'error'=>'No access token']); exit; }

// Capture order
$ch = curl_init($baseUrl.'/v2/checkout/orders/'.urlencode($orderID).'/capture');
curl_setopt_array($ch,[
  CURLOPT_HTTPHEADER=>[
    'Content-Type: application/json',
    'Authorization: Bearer '.$accessToken
  ],
  CURLOPT_POST=>true,
  CURLOPT_RETURNTRANSFER=>true
]);
$resp = curl_exec($ch);
if($resp===false){ echo json_encode(['ok'=>false,'error'=>'Capture failed']); exit; }
$cap = json_decode($resp,true);
$status = $cap['status'] ?? '';
$purchaseUnit = $cap['purchase_units'][0] ?? [];
$payments = $purchaseUnit['payments']['captures'][0] ?? [];
$txnId = $payments['id'] ?? null;
$amount = $payments['amount']['value'] ?? null;
$currency = $payments['amount']['currency_code'] ?? null;

if($status!=='COMPLETED' || !$txnId){ echo json_encode(['ok'=>false,'error'=>'Order not completed']); exit; }

// Load project for password and path
$stmt=$pdo->prepare('SELECT titulo, download_path, password_encrypted, password_hint FROM proyecto WHERE id=?');
$stmt->execute([$projectId]);
$proj=$stmt->fetch();
if(!$proj || empty($proj['download_path'])){ echo json_encode(['ok'=>false,'error'=>'Project not downloadable']); exit; }

$token = bin2hex(random_bytes(16));
$expiresAt = (new DateTime('+48 hours'))->format('Y-m-d H:i:s');

$ins=$pdo->prepare('INSERT INTO purchase (proyecto_id,nombre,email,metodo,monto,moneda,status,provider_txn_id,download_token,expires_at) VALUES (?,?,?,?,?,?,?,?,?,?)');
$ins->execute([$projectId,$buyerName,$buyerEmail,'paypal',$amount,$currency,'paid',$txnId,$token,$expiresAt]);

// Email with download link and password
$pwd = $proj['password_encrypted'] ? decryptSecret($proj['password_encrypted']) : '';
$link = (isset($_SERVER['HTTPS'])?'https':'http').'://'.($_SERVER['HTTP_HOST']??'').$GLOBALS['base'].'/download.php?token='.$token;
$subject = 'Tu compra está lista: '.$proj['titulo'];
$html = '<p>Gracias por tu compra.</p>'
      . '<p>Puedes descargar tu proyecto aquí: <a href="'.$link.'">Descargar</a> (expira en 48h)</p>'
      . ($pwd?'<p>Clave del ZIP: <strong>'.htmlspecialchars($pwd).'</strong></p>':'')
      . ($proj['password_hint']?'<p>Pista: '.htmlspecialchars($proj['password_hint']).'</p>':'');
@sendSiteEmail($buyerEmail,$subject,$html);

echo json_encode(['ok'=>true,'token'=>$token,'expires'=>$expiresAt]);
