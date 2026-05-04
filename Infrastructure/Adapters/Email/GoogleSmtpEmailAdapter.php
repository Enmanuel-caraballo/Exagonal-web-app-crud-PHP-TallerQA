<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../Application/Ports/Out/SentVerificationEmailPort.php';
final class GoogleSmtpEmailAdapter implements SentVerificationEmailPort
{

    public function sendVerificationEmail(string $email, string $name, string $verificationToken): void
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USER') ?: '';
            $mail->Password = getenv('SMTP_PASS') ?: '';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('enmanuelcm03@gmail.com', 'Users system');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Confirma tu Email';

            $link = "http://localhost/crud-usuarios/public/index.php?route=auth.verify&token={$verificationToken}&email={$email}";

            $mail->Body = "Hola {$name},<br><br>Por favor, haz clic en el siguiente enlace para activar tu cuenta:<br><a href='{$link}'>Verificar mi cuenta</a>";

            $mail->send();

        }catch (Exception $e){
            throw new RuntimeException("No se pudo enviar el correo: {$mail->ErrorInfo}");
        }
    }
}