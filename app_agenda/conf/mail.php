<?php 
// Constantes para el envio de emails
const EMAIL_FROM = $_ENV['EMAIL_FROM'];
const EMAIL_NAME = $_ENV['EMAIL_NAME'];
const EMAIL_HOST = $_ENV['EMAIL_HOST'];// 'smtp.sd3.gpaas.net';  //smtp.gmail.com';
const EMAIL_USER = $_ENV['EMAIL_USER'];
const EMAIL_PASS = $_ENV['EMAIL_PASS'];
const EMAIL_PORT = $_ENV['EMAIL_PORT'];

//Server settings
$this->SMTPDebug =3;           // Enable verbose debug output
$this->isMail();                // Set mailer to use SMTP
$this->Host = EMAIL_HOST;       // Specify main and backup SMTP servers
$this->SMTPAuth = true;        // Enable SMTP authentication
$this->Username = '';   // SMTP username
$this->Password = '';   // SMTP password
$this->SMTPSecure = 'TLS';      // Enable TLS encryption, `ssl` also accepted
$this->Port = 587;
 
$this->From =  EMAIL_FROM;
$this->FromName =  EMAIL_NAME;
//Recipients        
$this->AddReplyTo(EMAIL_FROM,EMAIL_NAME);
//config 
$this->CharSet = 'UTF-8';
$this->isHTML(true);  
//Attachments
$this->AddEmbeddedImage(URL_LOGO, 'logoimg', 'logo.jpg');
$this->AddEmbeddedImage(URL_BACKGROUND, 'backgroundimg', 'background.jpg');