<?php namespace models;
class Mail extends PHPMailer {
    private $userm, $count = 0; 
    public $url_menssage ;

    function __construct(User $User){
        parent::__construct(true);
        $this->user = $User; 
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