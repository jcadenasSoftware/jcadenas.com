<?php
class InvoiceGenerator {
    private static $lastNumber = 0;
    
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
}
