<?php

namespace BaseEmpds\Model\Exception;

class UniqueConstraintViolationException extends BaseDoctrineException
{

    /**
     * Retorna a mensagem de falha
     * @return string
     */
    protected function getMessageException()
    {
        $detail = '';
        if (preg_match("%key 'unique_(?P<key>.+)'%", $this->originalException->getMessage(), $match)) {
            $detail = ' (' . $match['key'] . ')';
        }
        return 'Já existe um registro com estas informações' . $detail;
    }
}
