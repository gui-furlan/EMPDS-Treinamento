<?php

namespace Treino\Model\Validator;

use BaseEmpds\Model\BaseEntityValidator;
/**
 * Summary of EquipeValidator
 */
class EquipeValidator extends BaseEntityValidator{

    public function getRequiredFields(){
        return ["nome","sigla","descricao"];
    }
}