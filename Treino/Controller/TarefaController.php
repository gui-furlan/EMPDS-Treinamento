<?php

namespace Treino\Controller;

use BaseEmpds\Controller\BaseController;
use BaseEmpds\Model\BaseFactory;

class TarefaController extends BaseController
{

    /**
     * 
     * @return /Model/Repository/TarefaRepository 
     */
    protected function getRepository()
    {
        return BaseFactory::getRepository("Tarefa");
    }

    public function index()
    {
        $membroId = $this->request->input("membro");
        if (empty($membroId) && !is_numeric($membroId)) {
            $this->setError("o id informado é inexistente ou não foi informado");
            $this->sendResponse();
        }
        $this->addVarView("membro", BaseFactory::getEntityById("Membro", $membroId));
        parent::index();
    }
    public function form()
    {
        $membroId = $this->request->input("membro");
        if (!empty($membroId)) {
            $oMembro = BaseFactory::getEntityById("Membro", $membroId);
            if ($oMembro) {
                $this->addVarView("membro", $oMembro);
            } else {
                $this->setError("membro de id {$membroId} não foi encontrado.");
                $this->sendResponse();
            }
        }
        parent::form();

    }

    public function getTarefasMembro()
    {
        $membroId = $this->request->input("membro");
        if (!empty($membroId) && is_scalar($membroId)) {
            $aTarefas = $this->getRepository()->getTarefaByMembroId($membroId);
            $this->setSuccess('tarefas encontradas', ['data' => $aTarefas]);
        } else {
            $this->setError("insira um id válido");

        }
        $this->sendResponse();
    }
    public function completarTarefa(){
        $tarefaId = $this->request->input("tarefaId");
        if (is_numeric($tarefaId) && !empty($tarefaId)) {
         $this->getRepository()->completaTarefa($tarefaId) ? $this->setSuccess("Tarefa completa com sucesso!"): $this->setError("Não foi possível concluir a tarefa");   
        }else {
            $this->setError("Id é inválido!");
        }
        $this->sendResponse();
        return $this->processUpdate();
    }
    


}