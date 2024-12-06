<?php

namespace BaseEmpds\Model\Interfaces;

interface EntityValidatorInterface
{

    /**
     * Retorna se é válido
     * @return boolean
     */
    public function isValid();

    /**
     * Retorna um Array com as mensagens de falha da validação
     * @return array
     */
    public function getMessages();

    /**
     *  Retorna um Array com os campos requeridos para validação
     *  @return array
     */
    public function getRequiredFields();
}
