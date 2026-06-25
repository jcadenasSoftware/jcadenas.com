<?php include 'includes/header.php'; ?>
<?php
require_once 'db.php';
$id = (int)($_GET['id'] ?? 0);
$proyecto=null;
if($id){
  $stmt=$pdo->prepare('SELECT p.*, c.nombre cat_nombre FROM proyecto p JOIN categoria c ON c.id=p.categoria_id WHERE p.id=?');
  $stmt->execute([$id]);
  $proyecto=$stmt->fetch();
}
?>

<?php if(!$proyecto): ?>
<div class="container py-5">
  <div class="text-center">
    <i class="bi bi-exclamation-triangle display-1 text-muted"></i>
    <h2 class="mt-3">Producto no encontrado</h2>
    <a href="<?= $base ?>/portfolio.php" class="btn btn-primary mt-3">Ver Portafolio</a>
  </div>
</div>
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
?>

<!-- Hero Section -->
<section class="store-hero">
  <div class="container py-5">
    <div class="row g-4 align-items-center">
      <div class="col-lg-7">
        <div class="product-image-wrapper">
          <img src="<?= $isExternal ? htmlspecialchars($img) : ($base . $img) ?>" 
               alt="<?= htmlspecialchars($proyecto['titulo']) ?>"
               class="product-image">
          <span class="badge-category"><?= htmlspecialchars($proyecto['cat_nombre']) ?></span>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="product-info">
          <h1 class="product-title"><?= htmlspecialchars($proyecto['titulo']) ?></h1>
          <p class="product-description"><?= nl2br(htmlspecialchars($proyecto['descripcion'])) ?></p>
          
          <?php if($priceCop): ?>
            <div class="price-box">
              <span class="price-label">Precio especial</span>
              <span class="price-amount"><?= formatCOP($priceCop) ?></span>
              <span class="price-note">Pago único · Descarga inmediata</span>
            </div>
          <?php else: ?>
            <div class="price-box">
              <span class="badge bg-success fs-4"><i class="bi bi-gift me-2"></i>¡Completamente Gratis!</span>
            </div>
          <?php endif; ?>
          
          <!-- CTAs rápidos -->
          <div class="quick-actions">
            <a href="#payment-section" class="btn btn-primary btn-lg">
              <i class="bi bi-cart-check me-2"></i>Comprar Ahora
            </a>
            <a href="https://wa.me/573177564861?text=<?= rawurlencode('Hola, tengo dudas sobre: ' . $proyecto['titulo']) ?>" 
               target="_blank" class="btn btn-outline-success btn-lg">
              <i class="bi bi-whatsapp me-2"></i>Consultar
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Beneficios -->
<section class="benefits-section py-4 bg-light">
  <div class="container">
    <div class="row g-3 text-center">
      <div class="col-6 col-md-3">
        <div class="benefit-item">
          <i class="bi bi-shield-check text-success fs-1"></i>
          <div class="fw-bold mt-2">Compra Segura</div>
          <small class="text-muted">Transacción protegida</small>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="benefit-item">
          <i class="bi bi-download text-primary fs-1"></i>
          <div class="fw-bold mt-2">Descarga Inmediata</div>
          <small class="text-muted">Acceso instantáneo</small>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="benefit-item">
          <i class="bi bi-headset text-info fs-1"></i>
          <div class="fw-bold mt-2">Soporte Incluido</div>
          <small class="text-muted">Ayuda por WhatsApp</small>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="benefit-item">
          <i class="bi bi-file-code text-warning fs-1"></i>
          <div class="fw-bold mt-2">Código Fuente</div>
          <small class="text-muted">100% funcional</small>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sección de Pago -->
<section id="payment-section" class="payment-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">Elige tu método de pago</h2>
      <p class="text-muted">Ofrecemos múltiples opciones para tu comodidad</p>
    </div>

    <!-- Tabs de métodos de pago -->
    <ul class="nav nav-pills nav-fill payment-tabs mb-4" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="colombia-tab" data-bs-toggle="pill" data-bs-target="#colombia" type="button">
          <i class="bi bi-bank me-2"></i>Métodos Colombia
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="paypal-tab" data-bs-toggle="pill" data-bs-target="#paypal" type="button">
          <i class="bi bi-paypal me-2"></i>PayPal Internacional
        </button>
      </li>
    </ul>

    <!-- Contenido de tabs -->
    <div class="tab-content">
      <!-- Tab: Métodos Colombia -->
      <div class="tab-pane fade show active" id="colombia" role="tabpanel">
        <div class="row g-4">
          <?php
          $metodosLocal = [
            ['name'=>'Nequi', 'icon'=>'phone', 'color'=>'danger', 'desc'=>'Transferencia instantánea desde tu celular'],
            ['name'=>'Daviplata', 'icon'=>'wallet2', 'color'=>'warning', 'desc'=>'Pago rápido y seguro con tu billetera digital'],
            ['name'=>'Bancolombia', 'icon'=>'bank', 'color'=>'primary', 'desc'=>'Transferencia o consignación bancaria'],
            ['name'=>'Movii', 'icon'=>'credit-card', 'color'=>'info', 'desc'=>'Paga con tu tarjeta prepaga Movii'],
            ['name'=>'Ualá', 'icon'=>'wallet', 'color'=>'success', 'desc'=>'Utiliza tu tarjeta Ualá'],
          ];
          foreach($metodosLocal as $metodo):
          ?>
          <div class="col-md-6 col-lg-4">
            <div class="payment-card">
              <div class="payment-card-icon bg-<?= $metodo['color'] ?>">
                <i class="bi bi-<?= $metodo['icon'] ?>"></i>
              </div>
              <h5 class="payment-card-title"><?= $metodo['name'] ?></h5>
              <p class="payment-card-desc"><?= $metodo['desc'] ?></p>
              <a href="https://wa.me/573177564861?text=<?= rawurlencode('Hola, quiero pagar con ' . $metodo['name'] . ' el proyecto: ' . $proyecto['titulo']) ?>" 
                 target="_blank" 
                 class="btn btn-outline-<?= $metodo['color'] ?> w-100">
                <i class="bi bi-whatsapp me-2"></i>Solicitar Datos
              </a>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Formulario de comprobante -->
        <div class="card mt-5 border-0 shadow-sm">
          <div class="card-body p-4">
            <h5 class="card-title mb-3">
              <i class="bi bi-file-earmark-check me-2 text-primary"></i>Ya pagaste? Envía tu comprobante
            </h5>
            <form action="<?= $base ?>/purchase_create.php" method="post" enctype="multipart/form-data" class="row g-3">
              <input type="hidden" name="proyecto_id" value="<?= $id ?>">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre completo</label>
                <input type="text" name="nombre" class="form-control" placeholder="Ej: Juan Pérez" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="tu@email.com" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Método de pago usado</label>
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
                <label class="form-label fw-semibold">Referencia de transacción</label>
                <input type="text" name="referencia" class="form-control" placeholder="Ej: 123456789" required>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Comprobante de pago (opcional)</label>
                <input type="file" name="recibo" class="form-control" accept="image/*,application/pdf">
                <div class="form-text">Formatos: JPG, PNG o PDF (máx. 5MB)</div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                  <i class="bi bi-send me-2"></i>Enviar Comprobante
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Tab: PayPal -->
      <div class="tab-pane fade" id="paypal" role="tabpanel">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-4 text-center">
                <div class="paypal-icon mb-3">
                  <i class="bi bi-paypal text-primary" style="font-size: 4rem;"></i>
                </div>
                <h5 class="card-title">Pago Internacional con PayPal</h5>
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
                  <div class="mt-3">
                    <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/cc-badges-ppmcvdam.png" alt="Tarjetas aceptadas" height="24" loading="lazy">
                  </div>
                <?php else: ?>
                  <form id="paypalForm" class="row g-3 mb-3">
                    <div class="col-12">
                      <input type="text" class="form-control" id="buyerName" placeholder="Tu nombre completo" required>
                    </div>
                    <div class="col-12">
                      <input type="email" class="form-control" id="buyerEmail" placeholder="tu@email.com" required>
                    </div>
                  </form>
                  <div id="paypal-button-container"></div>
                  <div id="paypal-msg" class="alert alert-info mt-3 d-none"></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ / Garantías -->
<section class="faq-section py-5 bg-light">
  <div class="container">
    <h3 class="text-center mb-4">Preguntas Frecuentes</h3>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="accordion" id="faqAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                ¿Cuándo recibo el proyecto?
              </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Una vez confirmemos tu pago, recibirás el enlace de descarga en tu email en menos de 24 horas.
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
                Sí, ofrecemos soporte por WhatsApp para resolver dudas sobre la instalación y configuración del proyecto.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                ¿Puedo solicitar modificaciones?
              </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Las modificaciones personalizadas tienen un costo adicional. Contáctanos por WhatsApp para cotizar.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if(empty($proyecto['paypal_button_id'])): ?>
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
          msg.classList.remove('d-none', 'alert-success');
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
            msg.classList.remove('d-none', 'alert-warning');
            msg.classList.add('alert-success');
          }else{
            msg.textContent = json.error || 'No se pudo confirmar el pago';
            msg.classList.remove('d-none', 'alert-success');
            msg.classList.add('alert-danger');
          }
        }catch(e){ 
          msg.textContent='Error de conexión'; 
          msg.classList.remove('d-none');
          msg.classList.add('alert-danger');
        }
      },
      onError: (err) => { 
        msg.textContent='Error al procesar el pago';
        msg.classList.remove('d-none');
        msg.classList.add('alert-danger');
      }
    }).render('#paypal-button-container');
  }
  mount();
});
</script>
<?php endif; ?>

<style>
/* Hero Section */
.store-hero {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.product-image-wrapper {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.product-image {
  width: 100%;
  height: auto;
  display: block;
  transition: transform 0.3s ease;
}

.product-image-wrapper:hover .product-image {
  transform: scale(1.05);
}

.badge-category {
  position: absolute;
  top: 20px;
  left: 20px;
  background: rgba(13, 110, 253, 0.95);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 30px;
  font-weight: 600;
  font-size: 0.875rem;
  backdrop-filter: blur(10px);
}

.product-info {
  padding: 2rem;
}

.product-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #1a202c;
  margin-bottom: 1rem;
  line-height: 1.2;
}

.product-description {
  font-size: 1.1rem;
  color: #4a5568;
  line-height: 1.8;
  margin-bottom: 2rem;
}

.price-box {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  padding: 1.5rem;
  border-radius: 12px;
  margin-bottom: 2rem;
  text-align: center;
  box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
}

.price-label {
  display: block;
  color: rgba(255, 255, 255, 0.9);
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 0.5rem;
}

.price-amount {
  display: block;
  color: white;
  font-size: 3rem;
  font-weight: 700;
  line-height: 1;
  margin-bottom: 0.5rem;
}

.price-note {
  display: block;
  color: rgba(255, 255, 255, 0.8);
  font-size: 0.875rem;
}

.quick-actions {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.quick-actions .btn {
  flex: 1;
  min-width: 200px;
}

/* Benefits Section */
.benefits-section {
  border-top: 1px solid #e9ecef;
  border-bottom: 1px solid #e9ecef;
}

.benefit-item {
  padding: 1rem;
}

/* Payment Section */
.payment-section {
  background: white;
}

.section-title {
  font-size: 2rem;
  font-weight: 700;
  color: #1a202c;
}

.payment-tabs .nav-link {
  border-radius: 12px;
  padding: 1rem 1.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
  background: #f8f9fa;
  color: #6c757d;
  border: 2px solid transparent;
}

.payment-tabs .nav-link:hover {
  background: #e9ecef;
}

.payment-tabs .nav-link.active {
  background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
  color: white;
  border-color: #0d6efd;
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(13, 110, 253, 0.3);
}

/* Payment Cards */
.payment-card {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  text-align: center;
  transition: all 0.3s ease;
  border: 2px solid #e9ecef;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.payment-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
  border-color: #0d6efd;
}

.payment-card-icon {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  font-size: 2rem;
  color: white;
}

.payment-card-title {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 0.75rem;
  color: #1a202c;
}

.payment-card-desc {
  color: #6c757d;
  font-size: 0.9rem;
  margin-bottom: 1.5rem;
  flex-grow: 1;
}

/* FAQ Section */
.faq-section .accordion-button {
  font-weight: 600;
  padding: 1.25rem;
}

.faq-section .accordion-button:not(.collapsed) {
  background-color: #e7f3ff;
  color: #0d6efd;
}

/* Responsive */
@media (max-width: 768px) {
  .product-title {
    font-size: 1.75rem;
  }
  
  .price-amount {
    font-size: 2rem;
  }
  
  .quick-actions {
    flex-direction: column;
  }
  
  .quick-actions .btn {
    width: 100%;
  }
  
  .payment-tabs .nav-link {
    font-size: 0.875rem;
    padding: 0.75rem 1rem;
  }
}
</style>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
