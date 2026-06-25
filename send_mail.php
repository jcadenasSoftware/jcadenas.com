<?php
// Simple PHP mail handler (placeholder). Replace with PHPMailer for production.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = htmlspecialchars($_POST['name']);
    $email   = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if ($email) {
        $to      = 'tu_correo@jcadenas.com';
        $headers = "From: $name <$email>\r\nReply-To: $email\r\nContent-Type: text/plain; charset=utf-8\r\n";
        mail($to, $subject, $message, $headers);
        header('Location: /contact.php?success=1');
    } else {
        header('Location: /contact.php?error=1');
    }
    exit;
}
?>
