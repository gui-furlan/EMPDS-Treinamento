<?php

namespace BaseEmpds\Model;

use BaseEmpds\Model\Interfaces\EntityValidatorInterface;
use BaseEmpds\Model\Interfaces\Entity;
use BaseEmpds\Model\Validator\AbstractContext;
use BaseEmpds\Model\Validator\Validator;

abstract class BaseEntityValidator implements EntityValidatorInterface {

    /**
     * @var \BaseEmpds\Model\Interfaces\Entity
     */
    protected $entity;

    /**
     * @var array
     */
    protected $messages;

    /**
     * @var \BaseEmpds\Model\Validator\Validator[]
     */
    protected $validators;


    public function __construct(Entity $entity = null) {
        $this->entity   = $entity;
        $this->messages = [];
        $this->validators = [];
    }

    public function setEntity(Entity $oEntity) {
        $this->entity = $oEntity;
    }

    /**
     * Verifica se os campos obrigatórios informados
     * @return array
     */
    public function getRequiredFields() {
        return [];
    }

    /**
     * Retorna as mensagens de erro
     * @return array
     */
    public function getMessages() {
        return $this->messages;
    }

    /**
     * Adiciona uma mensagem de erro
     * @param string $message - Mensagem
     */
    protected function addMessage($message) {
        $this->messages[] = $message;
    }

    /**
     * Retorna se determinada entidade é válida
     * @return boolean
     */
    public function isValid(){
        //Realiza ajustes na entidade
        $this->prepareEntity();
        //Realiza validações de campos obrigatórios
        $requiredFields = $this->getRequiredFields();
        if (!$this->isFieldValid($requiredFields)) {
            return false;
        }
        if(!$this->applyValidators()){
            return false;
        }
        //Realiza validações específicas
        if(!$this->validate()){
            return false;
        }
        if(is_null($this->entity->getId()) || empty($this->entity->getId())){
            //Realiza validações específicas ao inserir
            return $this->validateSave();
        }
        //Realiza validações específicas ao alterar
        return $this->validateUpdate();
    }

    /**
     * Método que pode ser sobreescrito para ajustar dados na entidade
     */
    protected function prepareEntity(){ }

    /**
     * Método que pode ser sobreescrito para realizar validações específicas
     * @return boolean
     */
    public function validate(){
        return true;
    }

    /**
     * Método que pode ser sobreescrito para realizar validações específicas no salvar
     * @return boolean
     */
    public function validateSave(){
        return true;
    }

    /**
     * Método que pode ser sobreescrito para realizar validações específicas no alterar
     * @return boolean
     */
    public function validateUpdate(){
        return true;
    }


        /**
     * Adiciona um validator
     * @param Validator $validators
     * @return void
     */
    protected function addValidator(Validator $validators){
        $this->validators[] = $validators;
    }

    /**
     * Adiciona um validator
     * @param Validator $validators
     * @return void
     */
    protected function addValidatorByValues($rules, $messages=[], $data=null){
        $this->validators[] = new Validator(($data) ? $data : $this->entity, $rules, $messages);
    }

        /**
     * Método que pode ser sobreescrito para adicionar validadores
     * @return void
     */
    protected function prepareValidators() { }

    /**
     * Aplica validadores adicionados
     * @return boolean
     */
    protected function applyValidators(){
        $this->prepareValidators();
        $valid = true;
        if(count($this->validators) > 0) {
            foreach($this->validators as $validator){
                if(!$validator->validate()){
                    foreach($validator->getErrors() as $attribute => $errors){
                        $this->messages = array_merge($this->messages, $errors);
                    }
                    $valid = false;
                }
            }
        }
        return $valid;
    }

    /**
     * Retorna se um campo é válido
     * @param array $aRequired
     * @return boolean
     */
    protected function isFieldValid($aRequired) {
        foreach ($aRequired as $field) {
            $method = 'get' . ucfirst($field);
            $value  = call_user_func_array([$this->entity, $method], []);
            if (empty($value) && $value != '0') {
                $this->addMessage('O campo ' . $field . ' não foi informado!');
                return false;
            }
        }
        return true;
    } 

    protected function addMessagesFromContext(AbstractContext $context){
        foreach($context->getMessages() as $message) {
            $this->addMessage($message);
        }
    }
}