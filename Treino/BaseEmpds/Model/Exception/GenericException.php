<?php
namespace BaseEmpds\Model\Exception;

use Geral\Model\Exception\FrameworkException;
use \Geral\Model\SystemMessages;
use \Geral\Model\Factory\LogFactory;
use \Exception;

/**
 * Exception de erro padrão
 */
abstract class GenericException extends FrameworkException{

    static private $ACCEPTED_LAYERS = [
        DIRECTORY_SEPARATOR.'Model'.DIRECTORY_SEPARATOR => 'M',
        DIRECTORY_SEPARATOR.'Entity'.DIRECTORY_SEPARATOR => 'E',
        DIRECTORY_SEPARATOR.'Controller'.DIRECTORY_SEPARATOR => 'C',
        DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR => 'V'
        //'/*/' => 'G' // Padrão é ser 'G'lobal
    ];
    
    public function __construct($message, $httpCode = 500, $detail = null, $messageCode = 0, $app = null){
        if(empty($app)) {
            $app = $GLOBALS['url'] -> getNameModule();
        }

        $this->docLink  = '';
        $this->httpCode = $httpCode;
        $this->detail   = $detail;
        $this->url      = $GLOBALS['url']->getFullUrl();
        
        Exception::__construct($message, $messageCode);

        if($this->prefix == 'E') {
            if(strlen($message) > 250){
                //A coluna de log de erro é limitada
                LogFactory::error(substr($message, 0, 253), ($detail) ? $message . ' -> Detalhes: '. $detail : $message);
            }
            else{
                LogFactory::error($message, $detail);
            }
        }
        
        foreach(self::$ACCEPTED_LAYERS as $dir => $layer) {
            if(strpos($this->file, $dir) !== false) {
                $this->layer = $layer;
            }
        }
        
        $this -> code = $this->prefix.$this->layer.' - '.$messageCode;
        SystemMessages::addException($this);
    }
}