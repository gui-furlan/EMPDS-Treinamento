<?php

namespace BaseEmpds\Model\Exception;

class InvalidFieldNameException extends BaseDoctrineException
{

    /**
     * Retorna a mensagem de falha
     * @return string
     */
    protected function getMessageException()
    {
        return 'O nome informado para o campo é inválido.';
    }
}
