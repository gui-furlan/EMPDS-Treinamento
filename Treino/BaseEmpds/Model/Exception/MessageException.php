<?php

namespace BaseEmpds\Model\Exception;

/**
 * Classe para mensagens de erros
 */
class MessageException extends BaseException
{

    /**
     * Retorna a mensagem de falha
     * @param string $message
     * @param int|null $code
     * @return string
     */
    public function __construct($message, $code = null)
    {
        parent::__construct($message, $code);
    }
}
