<?php

namespace BaseEmpds\Model\Exception;

class ConnectionException extends BaseDoctrineException
{

    /**
     * Retorna a mensagem de falha
     * @return string
     */
    protected function getMessageException()
    {
        return 'Não foi possível conectar ao banco de dados, tente novamente em instantes.';
    }
}
