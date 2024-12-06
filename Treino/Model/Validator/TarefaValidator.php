<?php

namespace Treino\Model\Validator;

use BaseEmpds\Model\BaseEntityValidator;
use BaseEmpds\Model\BaseFactory;


class TarefaValidator extends BaseEntityValidator
{

    /**
     * 
     * @var Treino\Entity\Tarefa
     */
    protected $entity;

    public function getRequiredFields()
    {
        return ["nome", "descricao", "membro"];
    }
    public function validateSave()
    {
        return $this->membroTarefaIncompleta();
    }
    public function membroTarefaIncompleta()
    {
        /**
         * @var Treino\Model\Repository\TarefaRepository
         */
        $tarefaRepo = BaseFactory::getRepository("Tarefa");
        $tarefaIncompleta = $tarefaRepo->membroTarefaIncompleta($this->entity->getMembro());
        if (!is_null($tarefaIncompleta)) {
            $this->addMessage("Este membro possuí alguma(s) tarefa(s) incompleta(s)");
            return false;
        }
        return true;
    }
}