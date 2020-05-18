<?php namespace models;

final class Device{

  public $os , $browser , $agente, $browserShort, $device;
  public $isMovile = false, $isTablet = false, $isWatch= false, $isLaptop= false, $width;
    public function __construct($width){
        $this->agente = $_SERVER['HTTP_USER_AGENT'];
        $this->width = $width;
        $this->getOs();
        $this->getBrowser();
        $this->getDevice();
     }
    private function getOs(){
        if (preg_match('/linux/i', $this->agente)) {
            $this->os = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $this->agente)) {
            $this->os = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $this->agente)) {
            $this->os = 'windows';
        }else {
            $this->os = 'undefined';
        }
     }
    private function getBrowser(){
        $agente = $this->agente;
        $version= "";


        if(preg_match('/MSIE/i',$agente) && !preg_match('/Opera/i',$agente))
        {
            $this->browser = 'Internet Explorer';
            $this->browserShort = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$agente))
        {
            $this->browser = 'Mozilla Firefox';
            $this->browserShort = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$agente))
        {
            $this->browser = 'Google Chrome';
            $this->browserShort = "Chrome";
        }
        elseif(preg_match('/Safari/i',$agente))
        {
            $this->browser = 'Apple Safari';
            $this->browserShort = "Safari";
        }
        elseif(preg_match('/Opera/i',$agente))
        {
            $this->browser = 'Opera';
            $this->browserShort = "Opera";
        }
        elseif(preg_match('/Netscape/i',$agente))
        {
            $this->browser = 'Netscape';
            $this->browserShort = "Netscape";
        }

        return  $this->browserShort;

     }
    public function getDevice(){      

        switch($this->width){
            case ($this->width <= 300):
                $this->type = 'watch';
                $this->isWatch = true;
                break; 

            case ($this->width <= 560):
                $this->type = 'movile';
                $this->isMovile = true;
                break; 
            case ($this->width <= 800): 
                $this->type = 'tablet';
                $this->isTablet = true;
                break; 
            default: 
                $this->type = 'laptop';
                $this->isLaptop = true;
        }

        return $this->type;
     }
}