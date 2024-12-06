<?php

namespace BaseEmpds\Controller;

use BaseEmpds\Model\Service\CreateFileRelationshipService;
use BaseEmpds\Model\Service\DeleteFileRelationshipService;

abstract class BaseFileRelationshipServiceController extends BaseServiceController{

    /**
     * Retorna o validator instânciado da classe filha
     * @param string $sAction
     * @return \BaseEmpds\Model\Interfaces\EntityService
     */
    protected function getInstanceService($sAction)
    {
        switch($sAction){
          case('Create'):
            return new CreateFileRelationshipService();
          case('Delete'):
            return new DeleteFileRelationshipService();
          default:
            return parent::getInstanceService($sAction);
        }
    }
}