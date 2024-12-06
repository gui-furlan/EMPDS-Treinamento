<?php

namespace BaseEmpds\Model\Exception;

class SyntaxErrorException extends BaseDoctrineException
{

    /**
     * Retorna a mensagem de falha
     * @return string
     */
    protected function getMessageException()
    {
        return 'Existe um erro de sintaxe no comando executado.';
    }
}
