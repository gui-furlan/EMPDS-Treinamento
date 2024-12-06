<?php
namespace BaseEmpds\Model\Exception;

/**
 * Exceção de errors
 *
 */
class ErrorException extends GenericException
{
    public function __construct($message, $httpCode = 500, $detail = null, $messageCode = 0, $app = null){
        $this->prefix = 'E';
        parent::__construct($message, $httpCode, $detail, $messageCode, $app);
    }
}