<?php

namespace BaseEmpds\Model\Exception;

class ForeignKeyConstraintViolationException extends BaseDoctrineException
{

    /**
     * Retorna a mensagem de falha
     * @return string
     */
    protected function getMessageException()
    {
        return 'O registro não pode ser atualizado pois está vinculado a outro.';
    }
}
