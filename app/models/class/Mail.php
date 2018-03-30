<?php namespace models;
class Mail extends PHPMailer {
    private $user; 
    public $url_menssage ;

    function __construct(User $User){
        parent::__construct(true);
        $this->user = $User; 
    }

    public function send_mail(){   

        if (!isset($this->url_menssage)) die('Hay que iniciar url_menssage');
        try {
            include URL_CONFIG . 'mail.php';
            //Server settings
            $this->SMTPDebug = 0;                 // Enable verbose debug output

            $this->isMail();                            // Set mailer to use SMTP
            $this->Host = gethostbyname(EMAIL_HOST);    // Specify main and backup SMTP servers
            $this->SMTPAuth = false;                    // Enable SMTP authentication
            $this->Username = EMAIL_USER;         // SMTP username
            $this->Password = EMAIL_PASS;         // SMTP password
            $this->SMTPSecure = 'TLS';            // Enable TLS encryption, `ssl` also accepted
            $this->Port = EMAIL_PORT;             // TCP port to connect to
            
            //Recipients
            $this->setFrom(EMAIL_FROM, EMAIL_NAME);

            $this->addAddress($this->user->email, 'Finalizar Registro');     // Add a recipient              

            //config 
            $this->CharSet = 'UTF-8';
            $this->isHTML(true);  

            //Attachments
            $this->AddEmbeddedImage(URL_LOGO, 'logoimg', 'logo.jpg');
            $this->AddEmbeddedImage(URL_BACKGROUND, 'backgroundimg', 'background.jpg');
            //Content
            $this->Subject = 'Here is the subject';

            $this->Body    = self::getContent($this->user->getToken());

            $this->send();
            return true;
        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            return \core\Error::set($this->ErrorInfo);
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