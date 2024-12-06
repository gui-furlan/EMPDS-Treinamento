<?php

namespace BaseEmpds\Model\Exception;

class InvalidArgumentException extends BaseDoctrineException
{

    /**
     * Retorna a mensagem de falha
     * @return string
     */
    protected function getMessageException()
    {
        return 'Um argumento inválido foi repassado para execução da função';
    }
}
