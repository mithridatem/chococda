<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private string $login;
    private string $password;
    private string $server;
    private int $port;
    private PHPMailer $mail;

    public function __construct(string $login, string $password, string $server, int $port)
    {
        $this->login = $login;
        $this->password = $password;
        $this->server = $server;
        $this->port = $port;
        $this->mail = new PHPMailer(true);
    }
    public function sendEmail(string $receiver, string $object, string $body)
    {
        try {
            $this->config();
            //Recipients
            $this->mail->setFrom($this->login);
            $this->mail->addAddress($receiver);

            //Content
            $this->mail->isHTML(true);
            $this->mail->Subject = $object;
            $this->mail->Body    = $body;
            $this->mail->send();
            return 'Le mail à été envoyé';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
    public function config()
    {
        //Server settings
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
        $this->mail->isSMTP();
        $this->mail->Host       = $this->server;
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $this->login;
        $this->mail->Password   = $this->password;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port       = $this->port;
    }
}
