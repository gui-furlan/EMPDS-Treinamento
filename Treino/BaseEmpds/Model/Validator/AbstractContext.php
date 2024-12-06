<?php

namespace BaseEmpds\Model\Validator;

abstract class AbstractContext implements ContextRuleValidator {

    /**
     * @var string[]
     */
    private $messages = [];

    /**
     * Adiciona uma mensagem
     * @param string $message
     */
    public function addMessage(string $message)
    {
        $this->messages[] = $message;
    }

    /**
     * Retorna as mensagens adicionadas
     * @return string[]
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
