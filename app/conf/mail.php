<?php 
// Constantes para el envio de emails
const EMAIL_FROM = 'nestorpons@gmail.com';
const EMAIL_NAME = 'ReservaTuCita.com';
const EMAIL_HOST = 'mail.gandi.net';// 'smtp.sd3.gpaas.net';  //smtp.gmail.com';
const EMAIL_USER = 'nestorpons@gmail.com';
const EMAIL_PASS = 'QQasw2!!';
const EMAIL_PORT = 25;

//Server settings
$Mail->SMTPDebug = 0;           // Enable verbose debug output
$Mail->isMail();                // Set mailer to use SMTP
$Mail->Host = 'mail.gandi.net';       // Specify main and backup SMTP servers
$Mail->SMTPAuth = false;        // Enable SMTP authentication
$Mail->Username = '';   // SMTP username
$Mail->Password = '';   // SMTP password
$Mail->SMTPSecure = 'TLS';      // Enable TLS encryption, `ssl` also accepted
$Mail->Port = 25;
//$Mail->setFrom(EMAIL_FROM, EMAIL_NAME);  
$Mail->From =  'nestorpons@gmail.com';
$Mail->FromName =  'ReservaTuCita.com';
//Recipients        
$Mail->AddReplyTo(EMAIL_FROM,EMAIL_NAME);
//config 
$Mail->CharSet = 'UTF-8';
$Mail->isHTML(true);  
//Attachments
$Mail->AddEmbeddedImage(URL_LOGO, 'logoimg', 'logo.jpg');
$Mail->AddEmbeddedImage(URL_BACKGROUND, 'backgroundimg', 'background.jpg');