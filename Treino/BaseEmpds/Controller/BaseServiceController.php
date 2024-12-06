<?php

namespace BaseEmpds\Controller;

abstract class BaseServiceController extends BaseController{

    /**
     * @var \BaseEmpds\Model\Interfaces\EntityService
     */
    protected $service;

    /**
     * Realiza a inserção
     */
    protected function processAdd()
    {
        //Carrega o service
        /** @var \BaseEmpds\Model\Service\BaseService */
        $this->service = $this->getInstanceService('Create');
        if($this->service){
            $this->service->setEntity($this->getEntity());
            $this->service->setRepository($this->getRepository());
            $this->service->execute();
            $this->setSuccess('Cadastro realizado com sucesso!', $this->getResponseData([
                'operation' => 'add'
            ]));
        }
        else{
            parent::processAdd();
        }
    }

    /**
     * Realiza a alteração
     */
    protected function processUpdate()
    {
        //Carrega o service
        /** @var \BaseEmpds\Model\Service\BaseService */
        $this->service = $this->getInstanceService('Update');
        if($this->service){
            $this->service->setEntity($this->getEntity());
            $this->service->setRepository($this->getRepository());
            $this->service->execute();
            $this->setSuccess('A alteração foi realizada com sucesso!', $this->getResponseData([
                'operation' => 'update'
            ]));
        }
        else{
            parent::processUpdate();
        }
    }

    /**
     * Realiza a remoção
     */
    protected function processRemove()
    {
        //Carrega o service
        /** @var \BaseEmpds\Model\Service\BaseService */
        $this->service = $this->getInstanceService('Delete');
        if($this->service){
            $this->service->setEntity($this->getEntity());
            $this->service->setRepository($this->getRepository());
            $this->service->execute();
            $this->setSuccess('Exclusão realizada com sucesso!', [
                'operation' => 'remove'
            ]);
        }
        else{
            parent::processRemove();
        }
    }

    /**
     * Retorna o validator instânciado da classe filha
     * @param string $sAction
     * @return \BaseEmpds\Model\Interfaces\EntityService | null
     */
    protected function getInstanceService($sAction)
    {
        $xClass = SERVICE_NAMESPACE . $sAction . $this->getClassName() . 'Service';
        if(class_exists($xClass)){
            return new $xClass();
        }
        return null;
    }
}