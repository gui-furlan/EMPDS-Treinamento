<?php 

namespace Treino\Model\Validator;

use BaseEmpds\Model\BaseEntityValidator;



class MembroValidator extends BaseEntityValidator{
    public function getRequiredFields(){
        return ["pessoa","equipe"];
    }   
    
}