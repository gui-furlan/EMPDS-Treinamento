<?php 

namespace Treino\Model\Validator;

use BaseEmpds\Model\BaseEntityValidator;
use Geral\Model\Validacao;

class PessoaValidator extends BaseEntityValidator
{
    /**
     * entidade pessoa
     * 
     * @var Treino\Entity\Pessoa
     */
  protected $entity;

  public function getRequiredFields()
  {
    return ["cpf","nome","idade"];
  }
  public function validate()
  {
    return $this->isPessoaCpfValid();
  }
  public function isPessoaCpfValid()
  {
   if (!Validacao::cpfIsValid($this->entity->getCpf())) {
        $this-> addMessage("CPF inderido é inválido!");
        return false;
   }
   return true;
  }

}