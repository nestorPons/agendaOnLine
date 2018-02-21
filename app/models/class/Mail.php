<?php namespace models;
class Mail {
    public $url_menssage ;
    function __construct(){}
    public function send(User $User){   

        $mail = new PHPMailer(true);

        if (!isset($this->url_menssage)) die('Hay que iniciar url_menssage');
        try {

            include URL_CONFIG . 'mail.php';
            //Server settings
            $mail->SMTPDebug = 0;                 // Enable verbose debug output
            $mail->isSMTP();                      // Set mailer to use SMTP
            $mail->Host = EMAIL_HOST;             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;               // Enable SMTP authentication
            $mail->Username = EMAIL_USER;         // SMTP username
            $mail->Password = EMAIL_PASS;         // SMTP password
            $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = EMAIL_PORT;             // TCP port to connect to
            //Recipients
            $mail->setFrom(EMAIL_FROM, EMAIL_NAME);

            $mail->addAddress($User->email, 'Finalizar Registro');     // Add a recipient              

            //config 
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);  

            //Attachments
            $mail->AddEmbeddedImage(URL_LOGO, 'logoimg', 'logo.jpg');
            $mail->AddEmbeddedImage(URL_BACKGROUND, 'backgroundimg', 'background.jpg');
            //Content
            $mail->Subject = 'Here is the subject';

            $mail->Body    = self::getContent($User->getToken());

            $mail->send();
            return true;
        } catch (Exception $e) {
            return \core\Error::set($mail->ErrorInfo);
        }
     }
 
    private function getContent($token){
        
        ob_start(); # apertura de bufer
        include( $this->url_menssage );
        $begin = ob_get_contents();
        ob_end_clean(); # cierre de bufer

        return $begin;
     }
    
}