<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: text/html; charset=UTF-8');

// Verificar registros DNS
function checkDNSRecord($domain, $type, $expected = null) {
    $records = @dns_get_record($domain, $type);
    return $records ?: [];
}

$domain = 'jcadenas.com';
$spfRecords = checkDNSRecord($domain, DNS_TXT);
// Hostinger usa hostingermail1._domainkey
$dkimRecords = checkDNSRecord('hostingermail1._domainkey.' . $domain, DNS_TXT);
// También verificar el selector default por si acaso
$dkimRecordsAlt = checkDNSRecord('default._domainkey.' . $domain, DNS_TXT);
$dmarcRecords = checkDNSRecord('_dmarc.' . $domain, DNS_TXT);

$hasSPF = false;
$hasDKIM = false;
$hasDMARC = false;

foreach($spfRecords as $r) {
    if(isset($r['txt']) && strpos($r['txt'], 'v=spf1') !== false) {
        $hasSPF = $r['txt'];
    }
}

foreach($dkimRecords as $r) {
    if(isset($r['txt']) && strpos($r['txt'], 'v=DKIM1') !== false) {
        $hasDKIM = $r['txt'];
    }
}
// También verificar selector alternativo
if(!$hasDKIM) {
    foreach($dkimRecordsAlt as $r) {
        if(isset($r['txt']) && strpos($r['txt'], 'v=DKIM1') !== false) {
            $hasDKIM = $r['txt'];
        }
    }
}

foreach($dmarcRecords as $r) {
    if(isset($r['txt']) && strpos($r['txt'], 'v=DMARC1') !== false) {
        $hasDMARC = $r['txt'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración de Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-ok { color: #198754; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        .code-box { background: #f8f9fa; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #0d6efd; font-family: monospace; font-size: 0.9rem; }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <h1 class="h3 mb-4">📧 Configuración de Autenticación de Email</h1>

        <div class="alert alert-info">
            <strong>🎯 Objetivo:</strong> Configurar SPF y DKIM para que los correos lleguen como <code>servicios@jcadenas.com</code> sin advertencias.
        </div>

        <!-- Estado Actual -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📊 Estado Actual de Autenticación</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td width="150"><strong>SPF:</strong></td>
                        <td>
                            <?php if($hasSPF): ?>
                                <span class="status-ok">✓ CONFIGURADO</span>
                                <div class="code-box mt-2"><?= htmlspecialchars($hasSPF) ?></div>
                            <?php else: ?>
                                <span class="status-error">✗ NO CONFIGURADO</span>
                                <div class="alert alert-danger mt-2 mb-0">
                                    <strong>⚠️ CRÍTICO:</strong> Sin SPF, los correos aparecen como spam
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>DKIM:</strong></td>
                        <td>
                            <?php if($hasDKIM): ?>
                                <span class="status-ok">✓ CONFIGURADO</span>
                                <div class="code-box mt-2" style="font-size:0.75rem; overflow:hidden; text-overflow:ellipsis;">
                                    <?= htmlspecialchars(substr($hasDKIM, 0, 100)) ?>...
                                </div>
                                <small class="text-muted">Selector: hostingermail1._domainkey</small>
                            <?php else: ?>
                                <span class="status-error">✗ NO CONFIGURADO</span>
                                <div class="alert alert-danger mt-2 mb-0">
                                    <strong>⚠️ CRÍTICO:</strong> Sin DKIM, no hay firma digital del correo
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>DMARC:</strong></td>
                        <td>
                            <?php if($hasDMARC): ?>
                                <span class="status-ok">✓ CONFIGURADO</span>
                                <div class="code-box mt-2"><?= htmlspecialchars($hasDMARC) ?></div>
                            <?php else: ?>
                                <span class="text-warning">⚠ NO CONFIGURADO</span>
                                <small class="d-block text-muted">(Recomendado pero no crítico)</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

                <?php if(!$hasSPF || !$hasDKIM): ?>
                <div class="alert alert-danger">
                    <strong>🚨 PROBLEMA IDENTIFICADO:</strong> 
                    Falta configuración SPF/DKIM. Por eso los correos aparecen como <code>u775031495@srv524.main-hosting.eu</code>
                </div>
                <?php else: ?>
                <div class="alert alert-success">
                    <strong>✅ TODO CORRECTO:</strong> 
                    SPF y DKIM están configurados. Los correos deberían llegar correctamente.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Paso 1: SPF -->
        <?php if(!$hasSPF): ?>
        <div class="card mb-3 border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">⚠️ Paso 1: Configurar SPF (URGENTE)</h5>
            </div>
            <div class="card-body">
                <h6>¿Qué es SPF?</h6>
                <p>SPF autoriza a Hostinger para enviar correos en nombre de <code>jcadenas.com</code></p>

                <h6 class="mt-3">Instrucciones paso a paso:</h6>
                <ol>
                    <li>
                        <strong>Ir a Panel de Hostinger:</strong>
                        <div class="code-box mt-2">
                            hPanel → Dominios → jcadenas.com → Administrar → DNS / Registros de Nombres
                        </div>
                    </li>
                    
                    <li class="mt-3">
                        <strong>Click en "Agregar Registro"</strong>
                    </li>
                    
                    <li class="mt-3">
                        <strong>Configurar el registro SPF:</strong>
                        <table class="table table-bordered mt-2">
                            <tr>
                                <td width="150"><strong>Tipo:</strong></td>
                                <td><code>TXT</code></td>
                            </tr>
                            <tr>
                                <td><strong>Nombre:</strong></td>
                                <td><code>@</code> o <code>jcadenas.com</code></td>
                            </tr>
                            <tr>
                                <td><strong>Valor:</strong></td>
                                <td>
                                    <div class="code-box">v=spf1 include:_spf.hostinger.com ~all</div>
                                    <button class="btn btn-sm btn-primary mt-2" onclick="copyToClipboard('v=spf1 include:_spf.hostinger.com ~all')">
                                        Copiar Valor
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TTL:</strong></td>
                                <td><code>14400</code> (4 horas)</td>
                            </tr>
                        </table>
                    </li>
                    
                    <li class="mt-3">
                        <strong>Guardar y esperar</strong> 1-4 horas para propagación
                    </li>
                </ol>

                <div class="alert alert-info">
                    <strong>💡 Nota:</strong> Si ya tienes un registro TXT para "@", tal vez necesites editarlo en lugar de crear uno nuevo.
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Paso 2: DKIM -->
        <?php if(!$hasDKIM): ?>
        <div class="card mb-3 border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">⚠️ Paso 2: Configurar DKIM (URGENTE)</h5>
            </div>
            <div class="card-body">
                <h6>¿Qué es DKIM?</h6>
                <p>DKIM firma digitalmente tus correos para demostrar que vienen realmente de ti.</p>

                <h6 class="mt-3">Instrucciones paso a paso:</h6>
                <ol>
                    <li>
                        <strong>Ir a Panel de Email:</strong>
                        <div class="code-box mt-2">
                            hPanel → Email → Email Accounts → servicios@jcadenas.com
                        </div>
                    </li>
                    
                    <li class="mt-3">
                        <strong>Buscar sección "DKIM Configuration" o "Email Authentication"</strong>
                    </li>
                    
                    <li class="mt-3">
                        <strong>Click en "Enable DKIM" o "Generate DKIM Keys"</strong>
                        <div class="alert alert-warning mt-2">
                            Hostinger generará automáticamente las claves DKIM y te mostrará un registro DNS para agregar.
                        </div>
                    </li>
                    
                    <li class="mt-3">
                        <strong>Copiar el registro DKIM generado</strong> (será similar a):
                        <div class="code-box mt-2">
                            Tipo: TXT<br>
                            Nombre: default._domainkey<br>
                            Valor: v=DKIM1; k=rsa; p=MIGfMA0GCSqGSIb3... (muy largo)
                        </div>
                    </li>
                    
                    <li class="mt-3">
                        <strong>Agregar en DNS:</strong>
                        <div class="code-box mt-2">
                            hPanel → Dominios → jcadenas.com → DNS → Agregar Registro
                        </div>
                    </li>
                    
                    <li class="mt-3">
                        <strong>Guardar y esperar</strong> 1-4 horas para propagación
                    </li>
                </ol>

                <div class="alert alert-info">
                    <strong>💡 Alternativa:</strong> Si no encuentras la opción DKIM, contacta al soporte de Hostinger y pide:
                    <blockquote class="mt-2">
                        "Por favor habiliten DKIM para servicios@jcadenas.com y envíenme el registro DNS para agregarlo"
                    </blockquote>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Paso 3: DMARC (opcional) -->
        <?php if(!$hasDMARC && ($hasSPF || $hasDKIM)): ?>
        <div class="card mb-3 border-warning">
            <div class="card-header bg-warning">
                <h5 class="mb-0">⚠️ Paso 3: Configurar DMARC (Recomendado)</h5>
            </div>
            <div class="card-body">
                <p>DMARC trabaja con SPF y DKIM para proteger tu dominio.</p>

                <h6>Agregar registro DMARC:</h6>
                <table class="table table-bordered">
                    <tr>
                        <td width="150"><strong>Tipo:</strong></td>
                        <td><code>TXT</code></td>
                    </tr>
                    <tr>
                        <td><strong>Nombre:</strong></td>
                        <td><code>_dmarc</code></td>
                    </tr>
                    <tr>
                        <td><strong>Valor:</strong></td>
                        <td>
                            <div class="code-box">v=DMARC1; p=none; rua=mailto:servicios@jcadenas.com</div>
                            <button class="btn btn-sm btn-primary mt-2" onclick="copyToClipboard('v=DMARC1; p=none; rua=mailto:servicios@jcadenas.com')">
                                Copiar Valor
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- Verificación -->
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">✅ Verificar Configuración (Después de 1-4 horas)</h5>
            </div>
            <div class="card-body">
                <p><strong>Recarga esta página</strong> después de configurar SPF y DKIM para verificar.</p>
                
                <h6 class="mt-3">Verificación online:</h6>
                <ul>
                    <li>
                        <a href="https://mxtoolbox.com/spf.aspx?domain=jcadenas.com" target="_blank">
                            Verificar SPF en MXToolbox
                        </a>
                    </li>
                    <li>
                        <a href="https://mxtoolbox.com/dkim.aspx?domain=jcadenas.com&selector=hostingermail1" target="_blank">
                            Verificar DKIM en MXToolbox (selector: hostingermail1)
                        </a>
                    </li>
                    <li>
                        <a href="https://mxtoolbox.com/SuperTool.aspx?action=dmarc%3ajcadenas.com" target="_blank">
                            Verificar DMARC en MXToolbox
                        </a>
                    </li>
                </ul>

                <h6 class="mt-3">Prueba de correo:</h6>
                <p>Una vez configurado, envía un correo de prueba desde:</p>
                <a href="diagnose.php" class="btn btn-primary">
                    Ir a Herramienta de Diagnóstico
                </a>
            </div>
        </div>

        <!-- Resultado Esperado -->
        <div class="card mb-3 border-success">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">🎯 Resultado Esperado</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-danger">❌ ANTES (Actual):</h6>
                        <div class="code-box">
                            <strong>De:</strong> u775031495@srv524.main-hosting.eu<br>
                            <strong>Advertencia:</strong> ⚠️ No se puede verificar el remitente
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">✅ DESPUÉS (Con SPF/DKIM):</h6>
                        <div class="code-box">
                            <strong>De:</strong> Ing. Joel Cadenas &lt;servicios@jcadenas.com&gt;<br>
                            <strong>Estado:</strong> ✓ Correo verificado
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="purchases.php" class="btn btn-primary">← Volver a Compras</a>
            <button onclick="location.reload()" class="btn btn-info">🔄 Recargar Estado</button>
        </div>
    </div>

    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('✓ Copiado al portapapeles: ' + text);
        });
    }
    </script>
</body>
</html>
