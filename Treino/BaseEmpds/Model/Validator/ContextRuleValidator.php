<?php

namespace BaseEmpds\Model\Validator;

//Marcador de contexto (Encapsula dados enviados para um Rule)
interface ContextRuleValidator
{

    /**
     * Adiciona uma mensagem
     * @param string $message
     */
    public function addMessage(string $message);

    /**
     * Retorna as mensagens adicionadas
     * @return string[]
     */
    public function getMessages();
}
