<?php
namespace BaseEmpds\Model;

class AuthPermission{

    /**
     * Permissões disponíveis
     * @var array
     */
    private $permissions;

    /**
     * Array de ações com permissões públicas (Qualquer perfil pode acessar)
     * @var array
     */
    private $ignoredAction;

    public function __construct(){
        $this->permissions   = [];
        $this->ignoredAction = [];
    }

    /**
     * Zera todas as permissões concedidas anteriormente
     */
    public function resetPermissionTransaction(){
        $this->permissions  = [];
    }

    /**
     * Adiciona permissão para uma transaction
     */
    public function addPermissionTransaction($transaction, $action = []){
        $this->permissions[$transaction] = $action;
    }

    /**
     * Remove uma permissão previamente concedida
     */
    public function removePermissionTransaction($transaction){
        if(array_key_exists($transaction, $this->permissions)){
            unset($this->permissions[$transaction]);
        }
    }

    /**
     * Adiciona permissão para uma ação
     */
    public function addPermissionAction($transaction, $action){
        if(!array_key_exists($transaction, $this->permissions)){
            $this->permissions[$transaction] = [];
        }
        $this->permissions[$transaction][] = $action;
    }

    /**
     * Remove permissão de uma ação
     */
    public function removePermissionAction($transaction, $action){
        if(array_key_exists($transaction, $this->permissions)){
            if (($key = array_search($action, $this->permissions[$transaction])) !== false) {
                unset($this->permissions[$transaction][$key]);
            }
        }
    }

    /**
     * Adiciona uma ação pública (qualquer um pode ter acesso)
     */
    public function addIgnoredFunction($action){
        if(is_array($action)){
            return array_walk($action, [$this, __METHOD__]);
        }
        $this->ignoredAction[] = $action;
    }

    /**
     * Retorna somente as transações permitidas
     * @return array
     */
    public function getTransactionsPermission(){
        return array_keys($this->permissions);
    }

    /**
     * Verifica se tem permissão para uma ação
     */
    public function hasPermissionAction($action, array $userTransaction){
        if(count($this->ignoredAction) > 0){
            //Se existe configurações de ações publicas
            if(in_array($action, $this->ignoredAction)){
                //Se a ação acionado está definida como pública
                return true;
            }
        }
        
        foreach ($userTransaction as $transaction) {
            if (array_key_exists($transaction, $this->permissions)) {
                //Se para a transação usuário, existe permissão
                if (count($this->permissions[$transaction]) == 0) {
                    //Tem permissão total
                    return true;
                }
                if (in_array($action, $this->permissions[$transaction])) {
                    //Tem permissão para a ação
                    return true;
                }
            }
        }
        return false;
    }
}