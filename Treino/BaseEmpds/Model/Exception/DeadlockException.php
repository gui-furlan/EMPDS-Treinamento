<?php

namespace BaseEmpds\Model\Exception;

class DeadlockException extends BaseDoctrineException
{

    /**
     * Retorna a mensagem de falha
     * @return string
     */
    protected function getMessageException()
    {
        return 'Existem processos concorrentes no banco de dados que não permitem a execução do processo, tente novamente em instantes.';
    }
}
