<?php

namespace BaseEmpds\Controller\Traits;

/**
 * Trait para adicionar a um BaseController a função de alterar o status
 * @author Glauco David Laicht
 */
trait ChangeStatusController{

    public function disableEnable(){
        //Verifica o parâmetro repassado
        $iId = $this->url->getSegment(4);
        if (empty($iId)) {
            $this->setError('Nenhum ID foi informado.');
            $this->sendResponse();
        }
        //Verifica se o registro existe
        $this->entity = $this->getRepository()->getById($iId, false);
        if (!$this->entity) {
            $this->setError('O registro não foi encontrado.');
            $this->sendResponse();
        }
        //Se está ativo passa para desativo e vice-verso
        $this->entity->setSituacao(!$this->entity->getSituacao());
        $this->getRepository()->update($this->entity);
        $this->setSuccess('Registro ' . ($this->entity->getSituacao() ? 'ativado' : 'desativado') . ' com sucesso!', $this->getResponseData([
            'operation' => 'changeStatus'
        ]));
        $this->sendResponse();
    }

    public function loadDataToView(){
        $iId = $this->url->getSegment(4);
        if (!empty($iId)) {
            $this->entity = $this->getRepository()->getById($iId, false);
            if ($this->entity) {
                if (!$this->getEntity()->getSituacao()) {
                    $this->setError('Este registro está desativado e não pode ser alterado.');
                    $this->sendResponse();
                }
                $this->addVarView('data', $this->getResponseData());
            }
        }
    }
}