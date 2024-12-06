<?php

namespace BaseEmpds\Model\Exception;

class NotNullConstraintViolationException extends BaseDoctrineException
{

    /**
     * Retorna a mensagem de falha
     * @return string
     */
    protected function getMessageException()
    {
        return 'Um campo é obrigatório e não teve valor informado.';
    }
}
