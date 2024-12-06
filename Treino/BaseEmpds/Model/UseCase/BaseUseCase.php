<?php

namespace BaseEmpds\Model\UseCase;

use Exception;
use BaseEmpds\Model\AppContext;

/**
 * Classe padrão para definição dos UseCase
 * @author Augusto Rustick
 * @since  05/08/2022
 */
abstract class BaseUseCase
{

    /**
     * Inicia uma transação
     */
    protected function beginTransaction()
    {
        AppContext::getInstance()->beginTransaction();
    }

    /**
     * Efetiva uma transação
     */
    protected function commitTransaction()
    {
        AppContext::getInstance()->commitTransaction();
    }

    /**
     * Cancela uma transação
     */
    protected function rollbackTransaction()
    {
        AppContext::getInstance()->rollbackTransaction();
    }

    /**
     * Processa o fluxo do UseCase
     * @return boolean
     */
    public function process()
    {
        //Dispara validações
        $this->validate();
        //Inicia a transação
        $this->beginTransaction();
        try {
            //Faz a execussão das principais funções do fluxo
            $this->execute();
        } catch (Exception $ex) {
            $this->rollbackTransaction();
            throw $ex;
        }
        $this->commitTransaction();
        return true;
    }

    /**
     * Processa validações
     * @return boolean
     */
    protected function validate()
    {
        return true;
    }

    /**
     * Executa o fluxo do UseCase
     * @return void
     */
    protected abstract function execute();
}
