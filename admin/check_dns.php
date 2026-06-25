<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: text/html; charset=UTF-8');

$domain = 'jcadenas.com';

// Verificar registros DNS en tiempo real
function getDNSRecords($domain, $type = 'TXT') {
    $records = @dns_get_record($domain, constant('DNS_' . $type));
    return $records ?: [];
}

$spf = getDNSRecords($domain, 'TXT');
$dkim = getDNSRecords('hostingermail1._domainkey.' . $domain, 'TXT');
$dmarc = getDNSRecords('_dmarc.' . $domain, 'TXT');

$hasSPF = false;
$hasDKIM = false;

foreach($spf as $record) {
    if(isset($record['txt']) && strpos($record['txt'], 'v=spf1') !== false) {
        $hasSPF = $record['txt'];
        break;
    }
}

foreach($dkim as $record) {
    if(isset($record['txt']) && strpos($record['txt'], 'v=DKIM1') !== false) {
        $hasDKIM = substr($record['txt'], 0, 100);
        break;
    }
}

$timestamp = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificación DNS en Tiempo Real</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .pass { color: #198754; font-weight: bold; font-size: 1.2rem; }
        .fail { color: #dc3545; font-weight: bold; font-size: 1.2rem; }
        .code-box { background: #f8f9fa; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #0d6efd; font-family: monospace; font-size: 0.85rem; word-break: break-all; }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">🔍 Verificación DNS en Tiempo Real</h1>
            <button onclick="location.reload()" class="btn btn-primary">
                🔄 Recargar Estado
            </button>
        </div>

        <div class="alert alert-info">
            <strong>⏰ Última actualización:</strong> <?= $timestamp ?><br>
            <small>Esta página verifica el estado ACTUAL de tus registros DNS. Recarga cada 5-10 minutos para ver cambios.</small>
        </div>

        <!-- Estado SPF -->
        <div class="card mb-3 border-<?= $hasSPF ? 'success' : 'danger' ?>">
            <div class="card-header bg-<?= $hasSPF ? 'success' : 'danger' ?> text-white">
                <h5 class="mb-0">📧 SPF (Sender Policy Framework)</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Estado:</strong>
                    <?php if($hasSPF): ?>
                        <span class="pass">✓ ACTIVO</span>
                    <?php else: ?>
                        <span class="fail">✗ NO DETECTADO</span>
                    <?php endif; ?>
                </div>

                <?php if($hasSPF): ?>
                    <div class="alert alert-success">
                        <strong>✓ SPF está configurado correctamente</strong>
                        <div class="code-box mt-2"><?= htmlspecialchars($hasSPF) ?></div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <strong>⚠️ SPF NO está configurado o no se ha propagado aún</strong>
                        <p class="mb-2 mt-2">Por favor, verifica:</p>
                        <ol class="mb-2">
                            <li>¿Agregaste el registro en Hostinger DNS?</li>
                            <li>¿Hace cuánto lo agregaste? (puede tardar 1-4 horas)</li>
                        </ol>
                        <p class="mb-0"><strong>Registro a agregar:</strong></p>
                        <div class="code-box mt-2">
                            Tipo: TXT<br>
                            Nombre: @<br>
                            Valor: v=spf1 include:_spf.hostinger.com ~all
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Estado DKIM -->
        <div class="card mb-3 border-<?= $hasDKIM ? 'success' : 'danger' ?>">
            <div class="card-header bg-<?= $hasDKIM ? 'success' : 'danger' ?> text-white">
                <h5 class="mb-0">🔐 DKIM (DomainKeys Identified Mail)</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Estado:</strong>
                    <?php if($hasDKIM): ?>
                        <span class="pass">✓ ACTIVO</span>
                    <?php else: ?>
                        <span class="fail">✗ NO DETECTADO</span>
                    <?php endif; ?>
                </div>

                <?php if($hasDKIM): ?>
                    <div class="alert alert-success">
                        <strong>✓ DKIM está configurado correctamente</strong>
                        <div class="code-box mt-2"><?= htmlspecialchars($hasDKIM) ?>...</div>
                        <small class="text-muted">Selector: hostingermail1._domainkey</small>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <strong>⚠️ DKIM NO se detecta públicamente aún</strong>
                        <p class="mb-2 mt-2">Aunque Hostinger diga "Verificado", puede tardar en propagarse públicamente.</p>
                        <p class="mb-0"><strong>Tiempo de espera:</strong> 1-4 horas desde que se habilitó.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Diagnóstico -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">🎯 Diagnóstico y Próximos Pasos</h5>
            </div>
            <div class="card-body">
                <?php if($hasSPF && $hasDKIM): ?>
                    <div class="alert alert-success">
                        <h6>✅ ¡TODO CONFIGURADO CORRECTAMENTE!</h6>
                        <p class="mb-2">Ambos registros están activos. Los correos deberían llegar correctamente ahora.</p>
                        <p class="mb-0"><strong>Próximo paso:</strong></p>
                        <ol class="mt-2 mb-0">
                            <li>Espera 10-15 minutos más (caché de servidores)</li>
                            <li>Envía un nuevo correo de prueba</li>
                            <li>Debería llegar como: <code>servicios@jcadenas.com</code> sin advertencias</li>
                        </ol>
                    </div>
                <?php elseif($hasSPF && !$hasDKIM): ?>
                    <div class="alert alert-warning">
                        <h6>⏳ SPF configurado, esperando DKIM</h6>
                        <p class="mb-2">SPF está activo, pero DKIM aún no se propaga públicamente.</p>
                        <p class="mb-0"><strong>Acción:</strong> Esperar 1-4 horas más y recargar esta página.</p>
                    </div>
                <?php elseif(!$hasSPF && $hasDKIM): ?>
                    <div class="alert alert-danger">
                        <h6>🚨 FALTA SPF (CRÍTICO)</h6>
                        <p class="mb-2">DKIM está configurado, pero SPF NO.</p>
                        <p class="mb-0"><strong>Acción URGENTE:</strong> Agregar registro SPF en Hostinger DNS ahora.</p>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <h6>🚨 FALTAN AMBOS REGISTROS</h6>
                        <p class="mb-2">Ni SPF ni DKIM están detectándose públicamente.</p>
                        <p class="mb-0"><strong>Posibles causas:</strong></p>
                        <ul class="mt-2 mb-0">
                            <li>No se agregaron los registros en Hostinger DNS</li>
                            <li>Se agregaron hace muy poco (esperar 1-4 horas)</li>
                            <li>Error en la configuración (revisar valores exactos)</li>
                        </ul>
                    </div>
                <?php endif; ?>

                <hr>

                <h6>Tiempos de Propagación DNS:</h6>
                <table class="table table-sm">
                    <tr>
                        <td width="200"><strong>Recién agregado:</strong></td>
                        <td>0-30 min → Aún no visible ⏳</td>
                    </tr>
                    <tr>
                        <td><strong>30-60 minutos:</strong></td>
                        <td>Comenzando a propagarse ⏳</td>
                    </tr>
                    <tr>
                        <td><strong>1-4 horas:</strong></td>
                        <td>Mayoría de servidores lo tienen ✓</td>
                    </tr>
                    <tr>
                        <td><strong>24 horas:</strong></td>
                        <td>Propagación completa mundial ✓</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Verificación Externa -->
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">🌐 Verificación Externa (MXToolbox)</h5>
            </div>
            <div class="card-body">
                <p>Verifica tus registros desde servidores externos:</p>
                <div class="d-grid gap-2">
                    <a href="https://mxtoolbox.com/spf.aspx?domain=jcadenas.com" target="_blank" class="btn btn-outline-primary">
                        Verificar SPF en MXToolbox
                    </a>
                    <a href="https://mxtoolbox.com/dkim.aspx?domain=jcadenas.com&selector=hostingermail1" target="_blank" class="btn btn-outline-primary">
                        Verificar DKIM en MXToolbox
                    </a>
                    <a href="https://www.mail-tester.com/" target="_blank" class="btn btn-outline-success">
                        Probar Calidad del Correo (Mail-Tester)
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="purchases.php" class="btn btn-secondary">← Volver a Compras</a>
            <a href="diagnose.php" class="btn btn-primary">Enviar Correo de Prueba</a>
            <button onclick="location.reload()" class="btn btn-success">🔄 Recargar Estado</button>
        </div>

        <div class="alert alert-secondary mt-4">
            <small>
                <strong>💡 Consejo:</strong> Guarda esta página en marcadores y recárgala cada 10-15 minutos 
                hasta que ambos registros aparezcan en verde. Una vez en verde, envía un nuevo correo de prueba.
            </small>
        </div>
    </div>

    <script>
    // Auto-reload cada 2 minutos
    setTimeout(() => {
        if(confirm('¿Recargar página para actualizar estado DNS?')) {
            location.reload();
        }
    }, 120000); // 2 minutos
    </script>
</body>
</html>
