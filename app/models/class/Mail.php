<?php namespace models;
class Mail extends PHPMailer {
    private $userm, $count = 0; 
    public $url_menssage ;

    function __construct(User $User){
        parent::__construct(true);
        $this->user = $User; 

        include_once URL_CONFIG . 'mail.php';
        
        //Recipients        
        $this->setFrom(EMAIL_FROM, EMAIL_NAME);
        $this->addAddress($User->email, $User->nombre);     // Add a recipient              
        $this->AddReplyTo(EMAIL_FROM,EMAIL_NAME);
        //config 
        $this->CharSet = 'UTF-8';
        $this->isHTML(true);  
        //Attachments
        $this->AddEmbeddedImage(URL_LOGO, 'logoimg', 'logo.jpg');
        $this->AddEmbeddedImage(URL_BACKGROUND, 'backgroundimg', 'background.jpg');
    }

    public function send(){   

        if (!isset($this->url_menssage)) die('Hay que iniciar url_menssage');
        try {
            //Content
            $this->Subject =  $this->Subject??EMAIL_NAME;
            $this->Body    = self::getContent($this->user->getToken());

            return parent::send();
    
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