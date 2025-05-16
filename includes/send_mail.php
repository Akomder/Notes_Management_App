<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function sendActivationMail($to, $subject, $body, $toName = '') {
    $mail = new PHPMailer(true);
    try {
        // Detect environment
        $isLocal = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);

        $mail->isSMTP();
        if ($isLocal) {
            // Local SMTP (MailHog or Papercut)
            $mail->Host = 'localhost';
            $mail->Port = 1025; // Default for MailHog/Papercut
            $mail->SMTPAuth = false;
        } else {
            // Online SMTP (example: Gmail SMTP)
            $mail->Host = 'smtp.yourprovider.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your@email.com';
            $mail->Password = 'yourpassword';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
        }

        $mail->setFrom('noreply@yourdomain.com', 'Notes Management App');
        $mail->addAddress($to, $toName);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(false);

        $mail->send();
        return true;
    } catch (Exception $e) {
        // For debugging: error_log($mail->ErrorInfo);
        return false;
    }
}