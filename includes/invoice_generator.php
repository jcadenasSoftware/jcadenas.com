<?php
require_once __DIR__ . '/../vendor/autoload.php';

use TCPDF as TCPDF;

class InvoiceGenerator {
    private static $lastNumber = 0;
    private $pdf;
    private $logoPath;
    
    // Datos del vendedor
    const SELLER_DATA = [
        'name'    => 'Ing. Joel Cadenas',
        'nit'     => 'NIT 700187067-5',
        'address' => 'Calle 135 #155-28',
        'city'    => 'Bogotá',
        'phone'   => '+573187488738',
        'email'   => 'servicios@jcadenas.com',
        'account' => 'Bancolombia 198-000087-02'
    ];

    public function __construct() {
        try {
            $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            $this->logoPath = __DIR__ . '/../assets/img/logo.webp';
            
            // Configuración inicial del PDF
            $this->pdf->SetCreator('JCadenas.com');
            $this->pdf->SetAuthor('Ing. Joel Cadenas');
            $this->pdf->SetTitle('Cuenta de Cobro');
            
            // Eliminar cabecera y pie de página por defecto
            $this->pdf->setPrintHeader(false);
            $this->pdf->setPrintFooter(false);
            
            // Márgenes
            $this->pdf->SetMargins(15, 15, 15);
            
            // Fuente por defecto
            $this->pdf->SetFont('helvetica', '', 10);
            
        } catch (Exception $e) {
            error_log("ERROR en constructor InvoiceGenerator: " . $e->getMessage());
            throw $e;
        }
    }

    public function generateInvoiceNumber() {
        global $pdo;
        $year = date('Y');
        $month = date('m');
        
        try {
            // Modificar la consulta para MySQL
            $stmt = $pdo->query("SELECT MAX(CAST(SUBSTRING(invoice_number, -3) AS UNSIGNED)) as last_num 
                               FROM purchase 
                               WHERE invoice_number LIKE 'CC-{$year}{$month}-%'");
            self::$lastNumber = (int)$stmt->fetchColumn();
        } catch (Exception $e) {
            self::$lastNumber = 0;
        }
        
        self::$lastNumber++;
        return sprintf("CC-%s%s-%03d", $year, $month, self::$lastNumber);
    }

    public function generatePDF($project, $purchase) {
        try {
            $this->pdf->AddPage();
            
            // Usar el número de factura que ya viene en $purchase
            $invoiceNumber = $purchase['invoice_number'] ?? $this->generateInvoiceNumber();
            
            // === ENCABEZADO CON LOGO Y DATOS DEL PROVEEDOR ===
            $this->createNewHeader();
            
            // === SECCIÓN CUENTA DE COBRO Y DATOS DEL CLIENTE ===
            $this->createInvoiceClientSection($invoiceNumber, $purchase);
            
            // === TABLA DE DETALLES ===
            $this->createNewDetailsTable($project);
            
            // === TÉRMINOS Y CONDICIONES COMO PIE DE PÁGINA ===
            $this->createFooterTerms($project);
            
            // Generar nombre de archivo temporal
            $tempDir = sys_get_temp_dir();
            $filename = "cuenta-cobro-{$invoiceNumber}.pdf";
            $filepath = $tempDir . DIRECTORY_SEPARATOR . $filename;
            
            // Guardar PDF
            $this->pdf->Output($filepath, 'F');
            
            return $filepath;
        } catch (Exception $e) {
            error_log("ERROR en generación de PDF: " . $e->getMessage());
            throw $e;
        }
    }
    
    private function createNewHeader() {
        // Logo en la esquina superior izquierda
        if (file_exists($this->logoPath)) {
            try {
                $this->pdf->Image($this->logoPath, 15, 15, 40, 0, '', '', '', false, 300, '', false, false, 0);
            } catch (Exception $e) {
                // Si falla el logo, continuar sin él
            }
        }
        
        // Datos del proveedor centrados
        $this->pdf->SetXY(70, 15);
        $this->pdf->SetFont('helvetica', 'B', 11);
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->Cell(80, 5, self::SELLER_DATA['name'], 0, 1, 'C');
        
        $this->pdf->SetXY(70, 20);
        $this->pdf->SetFont('helvetica', '', 9);
        $this->pdf->Cell(80, 4, self::SELLER_DATA['nit'], 0, 1, 'C');
        
        $this->pdf->SetXY(70, 24);
        $this->pdf->Cell(80, 4, self::SELLER_DATA['address'] . ', ' . self::SELLER_DATA['city'], 0, 1, 'C');
        
        $this->pdf->SetXY(70, 28);
        $this->pdf->Cell(80, 4, 'Tel: ' . self::SELLER_DATA['phone'], 0, 1, 'C');
        
        $this->pdf->SetXY(70, 32);
        $this->pdf->Cell(80, 4, 'Email: ' . self::SELLER_DATA['email'], 0, 1, 'C');
        
        // Marca JCADENAS en la esquina superior derecha
        $this->pdf->SetXY(150, 15);
        $this->pdf->SetFont('helvetica', 'B', 16);
        $this->pdf->SetTextColor(44, 62, 80);
        $this->pdf->Cell(45, 8, 'JCADENAS', 0, 1, 'R');
        
        $this->pdf->SetXY(150, 23);
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->SetTextColor(100, 100, 100);
        $this->pdf->Cell(45, 5, 'INGENIERÍA Y SOFTWARE', 0, 1, 'R');
        
        // Fecha de generación debajo de JCADENAS
        $this->pdf->SetXY(150, 30);
        $this->pdf->SetFont('helvetica', '', 9);
        $this->pdf->SetTextColor(100, 100, 100);
        $this->pdf->Cell(45, 4, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');
        
        // Línea separadora horizontal
        $this->pdf->SetDrawColor(200, 200, 200);
        $this->pdf->Line(15, 45, 195, 45);
        
        $this->pdf->SetTextColor(0, 0, 0);
    }
    
    private function createInvoiceClientSection($invoiceNumber, $purchase) {
        $startY = 55;
        
        // === DATOS DEL CLIENTE (Izquierda) ===
        $this->pdf->SetXY(15, $startY);
        $this->pdf->SetFont('helvetica', 'B', 11);
        $this->pdf->SetTextColor(44, 62, 80);
        $this->pdf->Cell(90, 8, 'DATOS DEL CLIENTE', 0, 0, 'L');
        
        // === CUENTA DE COBRO (Derecha) ===
        $this->pdf->SetXY(110, $startY);
        $this->pdf->SetFont('helvetica', 'B', 16);
        $this->pdf->SetTextColor(44, 62, 80);
        $this->pdf->Cell(85, 8, 'CUENTA DE COBRO', 0, 1, 'C');
        
        // Nombre del cliente
        $this->pdf->SetXY(15, $startY + 8);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->Cell(90, 6, strtoupper($purchase['nombre']), 0, 0, 'L');
        
        // Número de cuenta de cobro
        $this->pdf->SetXY(110, $startY + 8);
        $this->pdf->SetFont('helvetica', 'B', 12);
        $this->pdf->SetTextColor(0, 102, 204);
        $this->pdf->Cell(85, 6, 'No. ' . $invoiceNumber, 0, 1, 'C');
        
        // Email del cliente
        $this->pdf->SetXY(15, $startY + 14);
        $this->pdf->SetFont('helvetica', '', 9);
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->Cell(90, 6, 'Email: ' . $purchase['email'], 0, 0, 'L');
        
        // Documento y dirección si están disponibles
        $currentY = $startY + 20;
        if (!empty($purchase['documento'])) {
            $this->pdf->SetXY(15, $currentY);
            $this->pdf->Cell(90, 5, 'Documento: ' . $purchase['documento'], 0, 0, 'L');
            $currentY += 5;
        }
        if (!empty($purchase['direccion'])) {
            $this->pdf->SetXY(15, $currentY);
            $this->pdf->Cell(90, 5, 'Dirección: ' . $purchase['direccion'], 0, 0, 'L');
        }
        
        $this->pdf->SetTextColor(0, 0, 0);
    }
    
    private function createNewDetailsTable($project) {
        $startY = 105; // Aumentar espacio para los campos adicionales
        
        // Título de la sección
        $this->pdf->SetXY(15, $startY);
        $this->pdf->SetFont('helvetica', 'B', 12);
        $this->pdf->SetTextColor(44, 62, 80);
        $this->pdf->Cell(0, 10, 'DETALLE DE SERVICIOS', 0, 1, 'L');
        
        // Encabezados de la tabla
        $this->pdf->SetXY(15, $startY + 15);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->SetFillColor(52, 73, 94); // Azul oscuro
        $this->pdf->SetTextColor(255, 255, 255); // Texto blanco
        
        $this->pdf->Cell(15, 8, 'ITEM', 1, 0, 'C', true);
        $this->pdf->Cell(90, 8, 'DESCRIPCIÓN', 1, 0, 'C', true);
        $this->pdf->Cell(15, 8, 'CANT.', 1, 0, 'C', true);
        $this->pdf->Cell(32, 8, 'VALOR UNITARIO', 1, 0, 'C', true);
        $this->pdf->Cell(28, 8, 'VALOR TOTAL', 1, 1, 'C', true);
        
        // Fila de datos
        $this->pdf->SetFont('helvetica', '', 9);
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFillColor(249, 249, 249); // Gris muy claro
        
        $valor = $project['precio'] ? number_format($project['precio'], 0, ',', '.') : '0';
        $valorTexto = $project['precio'] ? 'COP ' . $valor : 'GRATIS';
        
        $this->pdf->Cell(15, 10, '001', 1, 0, 'C', true);
        $this->pdf->Cell(90, 10, ' ' . $project['titulo'], 1, 0, 'L', true);
        $this->pdf->Cell(15, 10, '1', 1, 0, 'C', true);
        $this->pdf->Cell(32, 10, $valorTexto, 1, 0, 'R', true);
        $this->pdf->Cell(28, 10, $valorTexto, 1, 1, 'R', true);
        
        $this->pdf->SetTextColor(0, 0, 0);
    }
    
    private function createFooterTerms($project) {
        // Posicionar términos en la parte inferior de la página
        $this->pdf->SetY(250); // Posición fija cerca del final de la página
        
        // Línea separadora superior
        $this->pdf->SetDrawColor(200, 200, 200);
        $this->pdf->Line(15, 250, 195, 250);
        
        $this->pdf->Ln(5);
        
        // Título de términos y condiciones
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->SetTextColor(44, 62, 80);
        $this->pdf->Cell(0, 6, 'TÉRMINOS Y CONDICIONES:', 0, 1, 'L');
        
        // Contenido de términos
        $this->pdf->SetFont('helvetica', '', 8);
        $this->pdf->SetTextColor(80, 80, 80);
        
        if ($project['precio'] == 0) {
            $terms = 'Este software se proporciona de forma gratuita. Al realizar modificaciones al código, se debe mantener y mencionar la autoría original de Ing. Joel Cadenas como desarrollador principal. El software se entrega "tal como está" sin garantías de ningún tipo.';
        } else {
            $terms = 'La licencia de uso de este software es personal e intransferible. Los derechos de autor y propiedad intelectual permanecen con el desarrollador. El pago debe realizarse en un plazo máximo de 30 días calendario. Una vez realizado el pago, se enviará el enlace de descarga correspondiente.';
        }
        
        $this->pdf->MultiCell(0, 4, $terms, 0, 'J');
        
        // Footer con información de contacto
        $this->pdf->Ln(3);
        $this->pdf->SetFont('helvetica', '', 8);
        $this->pdf->SetTextColor(100, 100, 100);
        $this->pdf->Cell(0, 4, 'Para consultas: ' . self::SELLER_DATA['email'] . ' | ' . self::SELLER_DATA['phone'], 0, 1, 'C');
        
        $this->pdf->SetTextColor(0, 0, 0);
    }
}
