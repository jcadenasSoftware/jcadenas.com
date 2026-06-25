<?php include 'includes/header.php'; ?>
<?php
require_once 'db.php';
$id = (int)($_GET['id'] ?? 0);
$proyecto=null;
if($id){
  $stmt=$pdo->prepare('SELECT p.*, c.nombre cat_nombre, c.slug cat_slug FROM proyecto p JOIN categoria c ON c.id=p.categoria_id WHERE p.id=?');
  $stmt->execute([$id]);
  $proyecto=$stmt->fetch();
}
?>

<?php if(!$proyecto): ?>
<section class="section">
  <div class="container container-narrow text-center">
    <i class="bi bi-exclamation-triangle" style="font-size: 4rem; color: #6c757d;"></i>
    <h2 class="mt-3">Producto no encontrado</h2>
    <p class="text-muted">El proyecto que buscas no existe o ha sido eliminado.</p>
    <a href="<?= $base ?>/portfolio.php" class="btn btn-primary mt-3">Ver Portafolio</a>
  </div>
</section>

<?php else: 
  // Obtener imagen del proyecto
  $thumb = $pdo->prepare('SELECT ruta FROM media WHERE proyecto_id=? AND tipo="imagen" ORDER BY orden LIMIT 1');
  $thumb->execute([$id]);
  $img = $thumb->fetchColumn();
  if(!$img){
    $vstmt = $pdo->prepare('SELECT ruta FROM media WHERE proyecto_id=? AND tipo="video" ORDER BY orden LIMIT 1');
    $vstmt->execute([$id]);
    $vsrc = $vstmt->fetchColumn();
    if($vsrc && preg_match('~youtu(?:\.be/|.*v=)([\w-]{11})~',$vsrc,$m)){
      $img = 'https://img.youtube.com/vi/'.$m[1].'/maxresdefault.jpg';
    }
  }
  $img = $img ?: '/assets/img/placeholder.png';
  $isExternal = str_starts_with($img,'http://') || str_starts_with($img,'https://');
  if(!$isExternal && $img[0] !== '/') $img = '/'.$img;
  
  $priceCop = (float)($proyecto['precio'] ?? 0);
  $usd = $priceCop ? max(1, round($priceCop / COP_TO_USD_RATE, 2)) : 10.00;
  $isWebProject = (strtolower($proyecto['cat_slug']) === 'web');
?>

<!-- Hero / Product Section -->
<section class="section section-intro">
  <div class="container container-narrow">
    <div class="row align-items-start g-4">
      <!-- Imagen del producto -->
      <div class="col-md-6">
        <div class="product-image-container">
          <img src="<?= $isExternal ? htmlspecialchars($img) : ($base . $img) ?>" 
               alt="<?= htmlspecialchars($proyecto['titulo']) ?>"
               class="img-fluid shadow-sm"
               loading="eager"
               style="border-radius: 0.5rem; width: 100%;">
          <span class="badge-cat badge-cat-<?= htmlspecialchars($proyecto['cat_slug']) ?>">
            <?= htmlspecialchars($proyecto['cat_nombre']) ?>
          </span>
        </div>
      </div>

      <!-- Info del producto -->
      <div class="col-md-6">
        <h1 class="h2 mb-3"><?= htmlspecialchars($proyecto['titulo']) ?></h1>
        <p class="lead"><?= nl2br(htmlspecialchars($proyecto['descripcion'])) ?></p>
        
        <?php if($isWebProject): ?>
          <!-- Proyectos Web: Invitar a cotizar -->
          <div class="price-box-quote">
            <div class="price-icon">
              <i class="bi bi-calculator"></i>
            </div>
            <div>
              <p class="mb-2 fw-bold">¿Necesitas un proyecto web similar?</p>
              <p class="text-muted small mb-0">Cada proyecto web es único. Solicita una cotización personalizada.</p>
            </div>
          </div>
          <div class="d-grid gap-2 mt-3">
            <a href="<?= $base ?>/services.php?type=web&ref=<?= urlencode($proyecto['titulo']) ?>" 
               class="btn btn-accent btn-lg">
              <i class="bi bi-chat-dots me-2"></i>Solicitar Cotización
            </a>
            <a href="https://wa.me/573177564861?text=<?= rawurlencode('Hola, me interesa un proyecto web similar a: ' . $proyecto['titulo']) ?>" 
               target="_blank" 
               class="btn btn-success btn-lg">
              <i class="bi bi-whatsapp me-2"></i>Consultar por WhatsApp
            </a>
          </div>
        <?php elseif($priceCop > 0): ?>
          <!-- Proyectos con precio -->
          <div class="price-box-sale">
            <div class="price-label">Precio especial</div>
            <div class="price-amount"><?= formatCOP($priceCop) ?></div>
            <div class="price-note">Pago único · Descarga inmediata · Código fuente incluido</div>
          </div>
          <div class="d-grid gap-2 mt-3">
            <a href="#payment-methods" class="btn btn-accent btn-lg smooth-link">
              <i class="bi bi-cart-check me-2"></i>Comprar Ahora
            </a>
            <a href="https://wa.me/573177564861?text=<?= rawurlencode('Hola, tengo dudas sobre: ' . $proyecto['titulo']) ?>" 
               target="_blank" 
               class="btn btn-outline-success">
              <i class="bi bi-whatsapp me-2"></i>Consultar
            </a>
          </div>
        <?php else: ?>
          <!-- Proyectos gratis -->
          <div class="price-box-free">
            <i class="bi bi-gift-fill fs-1 text-success mb-2"></i>
            <div class="h3 mb-0">¡Completamente Gratis!</div>
            <p class="text-muted small">Descarga el código fuente sin costo</p>
          </div>
          <div class="d-grid gap-2 mt-3">
            <a href="#download-form" class="btn btn-success btn-lg smooth-link">
              <i class="bi bi-download me-2"></i>Descargar Gratis
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <?php if(!$isWebProject): ?>
    <!-- Beneficios -->
    <div class="benefits-grid mt-5">
      <div class="benefit-item">
        <i class="bi bi-shield-check"></i>
        <div class="fw-bold">Compra Segura</div>
        <small class="text-muted">Transacción protegida</small>
      </div>
      <div class="benefit-item">
        <i class="bi bi-download"></i>
        <div class="fw-bold">Descarga Inmediata</div>
        <small class="text-muted">Acceso instantáneo</small>
      </div>
      <div class="benefit-item">
        <i class="bi bi-headset"></i>
        <div class="fw-bold">Soporte Incluido</div>
        <small class="text-muted">Ayuda por WhatsApp</small>
      </div>
      <div class="benefit-item">
        <i class="bi bi-file-code"></i>
        <div class="fw-bold">Código Fuente</div>
        <small class="text-muted">100% funcional</small>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php if(!$isWebProject): ?>
<!-- Sección de Métodos de Pago -->
<section class="section" id="payment-methods" style="background-color: #f8f9fa;">
  <div class="container container-narrow">
    <h2 class="text-center mb-4">Métodos de Pago</h2>
    <p class="text-center text-muted mb-5">Elige la opción más cómoda para ti</p>

    <!-- Tab Pills -->
    <ul class="nav nav-pills nav-fill payment-nav mb-4" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="colombia-tab" data-bs-toggle="pill" data-bs-target="#colombia-pay" type="button">
          <i class="bi bi-bank me-2"></i>Colombia
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="paypal-tab" data-bs-toggle="pill" data-bs-target="#paypal-pay" type="button">
          <i class="bi bi-paypal me-2"></i>PayPal
        </button>
      </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
      <!-- Métodos Colombia -->
      <div class="tab-pane fade show active" id="colombia-pay" role="tabpanel">
        <!-- Logos oficiales de plataformas -->
        <div class="payment-logos mb-4">
          <?php
          $paymentLogos = [
            ['name' => 'Nequi', 'files' => ['nequi.svg', 'nequi.png', 'nequi.webp']],
            ['name' => 'Daviplata', 'files' => ['daviplata.svg', 'daviplata.webp', 'daviplata.png']],
            ['name' => 'Bancolombia', 'files' => ['bancolombia.svg', 'bancolombia.png', 'bancolombia.webp']],
            ['name' => 'Movii', 'files' => ['movii.svg', 'movii.png', 'movii.webp']],
            ['name' => 'Ualá', 'files' => ['uala.svg', 'uala.png', 'uala.webp']],
          ];
          foreach($paymentLogos as $logo):
            $foundFile = '';
            foreach($logo['files'] as $file):
              $logoPath = __DIR__ . '/assets/img/payments/' . $file;
              if(file_exists($logoPath)):
                $foundFile = $file;
                break;
              endif;
            endforeach;
            if($foundFile):
          ?>
            <img src="<?= $base ?>/assets/img/payments/<?= htmlspecialchars($foundFile) ?>" 
                 alt="<?= htmlspecialchars($logo['name']) ?>"
                 title="<?= htmlspecialchars($logo['name']) ?>"
                 class="payment-logo"
                 loading="lazy">
          <?php 
            endif;
          endforeach; 
          ?>
        </div>

        <!-- Botón único para solicitar datos -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body text-center p-4">
            <i class="bi bi-chat-square-text text-primary fs-1 mb-3"></i>
            <h5 class="mb-2">Solicita los datos de pago</h5>
            <p class="text-muted mb-3">
              Por seguridad, te compartiremos los datos de la plataforma que elijas por WhatsApp.
            </p>
            <a href="https://wa.me/573177564861?text=<?= rawurlencode('Hola, quiero comprar: ' . $proyecto['titulo'] . '. ¿Cuáles son los datos para transferir?') ?>" 
               target="_blank" 
               class="btn btn-success btn-lg">
              <i class="bi bi-whatsapp me-2"></i>Solicitar Datos por WhatsApp
            </a>
          </div>
        </div>

        <!-- Formulario para enviar comprobante -->
        <div class="card border-0 shadow-sm" id="download-form">
          <div class="card-body p-4">
            <h5 class="mb-3">
              <i class="bi bi-file-earmark-check text-primary me-2"></i><?php if($priceCop > 0): ?>¿Ya realizaste el pago?<?php else: ?>Solicita tu descarga gratis<?php endif; ?>
            </h5>
            <p class="text-muted mb-4"><?php if($priceCop > 0): ?>Envía tu comprobante para recibir el enlace de descarga.<?php else: ?>Ingresa tus datos para recibir el enlace de descarga en tu email.<?php endif; ?></p>
            
            <form action="<?= siteUrl('purchase_create.php') ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="proyecto_id" value="<?= $id ?>">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Nombre completo</label>
                  <input type="text" name="nombre" class="form-control" placeholder="Ej: Juan Pérez" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Email</label>
                  <input type="email" name="email" class="form-control" placeholder="tu@email.com" required>
                </div>
                <?php if($priceCop > 0): ?>
                <!-- Campos adicionales para proyectos con precio -->
                <div class="col-md-6">
                  <label class="form-label fw-bold">Número de documento <span class="text-muted">(opcional)</span></label>
                  <input type="text" name="documento" class="form-control" placeholder="Ej: 12345678 o CC 12345678">
                  <small class="text-muted">Cédula, pasaporte u otro documento de identidad</small>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Dirección <span class="text-muted">(opcional)</span></label>
                  <input type="text" name="direccion" class="form-control" placeholder="Ej: Calle 123 #45-67, Bogotá">
                  <small class="text-muted">Ciudad y país si estás fuera de Colombia</small>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Método usado</label>
                  <select name="metodo" class="form-select" required>
                    <option value="">Selecciona...</option>
                    <option value="nequi">Nequi</option>
                    <option value="daviplata">Daviplata</option>
                    <option value="bancolombia">Bancolombia</option>
                    <option value="movii">Movii</option>
                    <option value="uala">Ualá</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Referencia</label>
                  <input type="text" name="referencia" class="form-control" placeholder="Número de transacción" required>
                </div>
                <div class="col-12">
                  <label class="form-label fw-bold">Comprobante <span class="text-muted">(opcional)</span></label>
                  <input type="file" name="recibo" class="form-control" accept="image/*,application/pdf">
                  <small class="text-muted">JPG, PNG o PDF (máx. 5MB) - Ayuda a procesar tu solicitud más rápido</small>
                </div>
                <?php else: ?>
                <input type="hidden" name="metodo" value="gratis">
                <input type="hidden" name="referencia" value="descarga-gratuita">
                <?php endif; ?>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-send me-2"></i><?php if($priceCop > 0): ?>Enviar Comprobante<?php else: ?>Solicitar Descarga<?php endif; ?>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- PayPal -->
      <div class="tab-pane fade" id="paypal-pay" role="tabpanel">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4 text-center">
            <i class="bi bi-paypal text-primary" style="font-size: 4rem;"></i>
            <h5 class="mt-3 mb-2">Pago Internacional con PayPal</h5>
            <p class="text-muted mb-4">
              Paga de forma segura con tarjeta de crédito/débito o tu cuenta PayPal
            </p>
            
            <?php if(!empty($proyecto['paypal_button_id'])): ?>
              <?php $ppBase = (strtolower(PAYPAL_ENV ?? 'live')==='sandbox') ? 'https://www.sandbox.paypal.com' : 'https://www.paypal.com'; ?>
              <form action="<?= $ppBase ?>/cgi-bin/webscr" method="post" target="_top">
                <input type="hidden" name="cmd" value="_s-xclick" />
                <input type="hidden" name="hosted_button_id" value="<?= htmlspecialchars($proyecto['paypal_button_id']) ?>" />
                <?php if(defined('PAYPAL_CURRENCY')): ?>
                <input type="hidden" name="currency_code" value="<?= htmlspecialchars(PAYPAL_CURRENCY) ?>" />
                <?php endif; ?>
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" name="submit" title="Pagar con PayPal" alt="Comprar ahora" />
              </form>
            <?php else: ?>
              <form id="paypalForm" class="mb-3">
                <div class="row g-3 justify-content-center">
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="buyerName" placeholder="Tu nombre completo" required>
                  </div>
                  <div class="col-md-6">
                    <input type="email" class="form-control" id="buyerEmail" placeholder="tu@email.com" required>
                  </div>
                </div>
              </form>
              <div id="paypal-button-container"></div>
              <div id="paypal-msg" class="alert d-none mt-3"></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="section">
  <div class="container container-narrow">
    <h3 class="text-center mb-4">Preguntas Frecuentes</h3>
    <div class="accordion" id="faqAccordion">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
            ¿Cuándo recibo el proyecto?
          </button>
        </h2>
        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Una vez confirmemos tu pago, recibirás el enlace de descarga en tu email en menos de 24 horas (generalmente en pocas horas).
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
            ¿Incluye soporte técnico?
          </button>
        </h2>
        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Sí, ofrecemos soporte básico por WhatsApp para resolver dudas sobre la instalación y configuración del proyecto.
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
            ¿Puedo solicitar modificaciones personalizadas?
          </button>
        </h2>
        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Sí, las modificaciones personalizadas tienen un costo adicional. Contáctanos por WhatsApp para cotizar tus requerimientos específicos.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; // Fin if(!$isWebProject) ?>

<?php if(!$isWebProject): ?>
<script>
// Smooth scroll para enlaces internos
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('a.smooth-link').forEach(link => {
    link.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if(href.startsWith('#')) {
        e.preventDefault();
        const target = document.querySelector(href);
        if(target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }
    });
  });
});
</script>
<?php endif; ?>

<?php if(empty($proyecto['paypal_button_id']) && !$isWebProject): ?>
<script src="https://www.paypal.com/sdk/js?client-id=<?= urlencode(PAYPAL_CLIENT_ID) ?>&currency=<?= urlencode(PAYPAL_CURRENCY) ?>" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  function readyPayPal(){ return window.paypal && document.getElementById('paypal-button-container'); }
  function mount(){
    if(!readyPayPal()) { setTimeout(mount, 300); return; }
    const msg = document.getElementById('paypal-msg');
    const amount = <?= json_encode(number_format($usd,2,'.','')) ?>;
    const projectId = <?= (int)$id ?>;
    window.paypal.Buttons({
      style: { layout:'vertical', color:'blue', shape:'rect', label:'paypal', height:45 },
      createOrder: (data, actions) => {
        const name = document.getElementById('buyerName').value.trim();
        const email = document.getElementById('buyerEmail').value.trim();
        if(!name || !email){ 
          msg.textContent='Por favor ingresa tu nombre y email';
          msg.classList.remove('d-none', 'alert-success', 'alert-danger');
          msg.classList.add('alert-warning');
          return; 
        }
        return actions.order.create({
          purchase_units: [{ amount: { value: amount } }]
        });
      },
      onApprove: async (data, actions) => {
        try{
          const name = document.getElementById('buyerName').value.trim();
          const email = document.getElementById('buyerEmail').value.trim();
          const res = await fetch('<?= $base ?>/paypal_capture.php',{
            method:'POST', headers:{'Content-Type':'application/json'},
            body: JSON.stringify({ orderID: data.orderID, projectId: projectId, name, email })
          });
          const json = await res.json();
          if(json.ok){
            msg.innerHTML = '<i class="bi bi-check-circle me-2"></i>¡Pago confirmado! <a href="<?= $base ?>/download.php?token='+json.token+'" class="alert-link">Descargar proyecto</a>';
            msg.classList.remove('d-none', 'alert-warning', 'alert-danger');
            msg.classList.add('alert-success');
          }else{
            msg.textContent = json.error || 'No se pudo confirmar el pago';
            msg.classList.remove('d-none', 'alert-success', 'alert-warning');
            msg.classList.add('alert-danger');
          }
        }catch(e){ 
          msg.textContent='Error de conexión'; 
          msg.classList.remove('d-none', 'alert-success', 'alert-warning');
          msg.classList.add('alert-danger');
        }
      },
      onError: (err) => { 
        msg.textContent='Error al procesar el pago';
        msg.classList.remove('d-none', 'alert-success', 'alert-warning');
        msg.classList.add('alert-danger');
      }
    }).render('#paypal-button-container');
  }
  mount();
});
</script>
<?php endif; ?>

<style>
/* Estilos coherentes con el resto del sitio */
.product-image-container {
  position: relative;
}

.badge-cat {
  position: absolute;
  top: 1rem;
  left: 1rem;
  padding: 0.5rem 1rem;
  border-radius: 2rem;
  font-weight: 600;
  font-size: 0.875rem;
  background: rgba(13, 110, 253, 0.9);
  color: white;
  backdrop-filter: blur(10px);
}

.badge-cat-java { background: rgba(220, 53, 69, 0.9); }
.badge-cat-python { background: rgba(13, 202, 240, 0.9); }
.badge-cat-web { background: rgba(13, 110, 253, 0.9); }
.badge-cat-android { background: rgba(25, 135, 84, 0.9); }
.badge-cat-php { background: rgba(111, 66, 193, 0.9); }

/* Cajas de precio */
.price-box-sale {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  padding: 1.5rem;
  border-radius: 0.5rem;
  text-align: center;
  color: white;
}

.price-label {
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  opacity: 0.9;
  margin-bottom: 0.5rem;
}

.price-amount {
  font-size: 2.5rem;
  font-weight: 700;
  line-height: 1;
  margin: 0.5rem 0;
}

.price-note {
  font-size: 0.875rem;
  opacity: 0.9;
}

.price-box-free {
  background: #f8f9fa;
  padding: 2rem;
  border-radius: 0.5rem;
  text-align: center;
  border: 2px solid #198754;
}

.price-box-quote {
  background: #f8f9fa;
  padding: 1.5rem;
  border-radius: 0.5rem;
  border-left: 4px solid #0d6efd;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.price-icon {
  font-size: 2.5rem;
  color: #0d6efd;
}

/* Beneficios */
.benefits-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  padding: 2rem;
  background: white;
  border-radius: 0.5rem;
  box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}

.benefit-item {
  text-align: center;
}

.benefit-item i {
  font-size: 2rem;
  color: #198754;
  margin-bottom: 0.5rem;
}

/* Navigation Tabs */
.payment-nav .nav-link {
  padding: 1rem;
  font-weight: 600;
  border-radius: 0.5rem;
  transition: all 0.3s ease;
  background: white;
  color: #6c757d;
  border: 2px solid #e9ecef;
}

.payment-nav .nav-link:hover {
  background: #f8f9fa;
}

.payment-nav .nav-link.active {
  background: #0d6efd;
  color: white;
  border-color: #0d6efd;
}

/* Logos de métodos de pago */
.payment-logos {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  gap: 2rem;
  padding: 2rem;
  background: white;
  border-radius: 0.5rem;
}

.payment-logo {
  height: 40px;
  width: auto;
  opacity: 0.8;
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.payment-logo:hover {
  opacity: 1;
  transform: scale(1.1);
}

/* Accordion FAQ */
.accordion-item {
  border: 1px solid #e9ecef;
  margin-bottom: 0.5rem;
  border-radius: 0.5rem;
  overflow: hidden;
}

.accordion-button {
  font-weight: 600;
  padding: 1rem 1.25rem;
  background: white;
}

.accordion-button:not(.collapsed) {
  background-color: #e7f3ff;
  color: #0d6efd;
}

.accordion-button:focus {
  box-shadow: none;
  border-color: #0d6efd;
}

.accordion-body {
  padding: 1rem 1.25rem;
  line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
  .price-amount {
    font-size: 2rem;
  }
  
  .benefits-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    padding: 1rem;
  }
  
  .payment-logos {
    gap: 1rem;
    padding: 1rem;
  }
  
  .payment-logo {
    height: 30px;
  }
}
</style>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
