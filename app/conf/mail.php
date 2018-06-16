<?php 
// Constantes para el envio de emails
const EMAIL_FROM = 'admin@reservatucita.com';
const EMAIL_NAME = 'ReservaTuCita.com';
const EMAIL_HOST = 'mail.gandi.net';// 'smtp.sd3.gpaas.net';  //smtp.gmail.com';
const EMAIL_USER = 'admin@reservatucita.com';
const EMAIL_PASS = 'QQasw2!!';
const EMAIL_PORT = 25;

//Server settings
$this->SMTPDebug = 2;           // Enable verbose debug output
$this->isMail();                // Set mailer to use SMTP
$this->Host = 'mail.gandi.net'; // Specify main and backup SMTP servers
$this->SMTPAuth = false;        // Enable SMTP authentication
$this->Username = '';   // SMTP username
$this->Password = '';   // SMTP password
$this->SMTPSecure = 'TLS';      // Enable TLS encryption, `ssl` also accepted
$this->Port = 25;
 
//Recipients        
$this->AddReplyTo(EMAIL_FROM,EMAIL_NAME);
//config 
$this->CharSet = 'UTF-8';
$this->isHTML(true);  
//Attachments
$this->AddEmbeddedImage(URL_LOGO, 'logoimg', 'logo.jpg');
$this->AddEmbeddedImage(URL_BACKGROUND, 'backgroundimg', 'background.jpg');