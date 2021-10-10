<?php

namespace App\Email;

use PHPMailer\PHPMailer\PHPMailer;

class Client
{
    public function sendEmail(string $senderEmail, string $senderName, string $recipientEmail, string $recipientName, string $subject, string $body, string $attachmentFilepath): bool
    {
        $mail = new PHPMailer();

        $mail->isSMTP();

        $mail->Username   = $_ENV['SMTP_USERNAME'];
        $mail->Password   = $_ENV['SMTP_PASSWORD'];
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->Port       = $_ENV['SMTP_PORT'];
        $mail->SMTPAuth   = $_ENV['SMTP_AUTH'];
        $mail->SMTPSecure = $_ENV['SMTP_SECURE'];

        $mail->setFrom($senderEmail, $senderName);
        $mail->addAddress($recipientEmail, $recipientName);
        $mail->addAttachment($attachmentFilepath);

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = $body;

        return $mail->send();
    }
}
