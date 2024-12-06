<?php

namespace BaseEmpds\Model\Exception;

class TableNotFoundException extends BaseDoctrineException
{

    /**
     * Retorna a mensagem de falha
     * @return string
     */
    protected function getMessageException()
    {
        return 'A tabela para execução do processo não existe.';
    }
}
