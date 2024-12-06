<?php

namespace BaseEmpds\Model\Validator;

use BaseEmpds\Model\Bean;
use BaseEmpds\Model\Validator\Traits\FormatMessages;
use BaseEmpds\Model\Validator\Traits\ValidateAttributes;

/**
 * Classe para realizar validações
 */
class Validator{

    use ValidateAttributes, FormatMessages;

    /**
     * Dados a serem validados
     * @var mixed
     */
    protected $data;

    /**
     * Regras a serem praticadas
     * @var array
     */
    protected $rules = [];

    /**
     * Mensagem a serem disparadas
     * @var array
     */
    protected $messages = [];

    /**
     * Erros obtidos
     * @var array
     */
    protected $errors;

    /**
     * Classe criada para realizar validações genéricas de dados
     *   - Baseado no Laravel Validation
     * 
     * Os principais tipos de validações possíveis são (Para ver todos acessar o Trait ValidateAttributes e analisar métodos com o prefixo validate):
     * - array: Se o dado é um array
     * - between: Se o dado está dentro de um valor (Se array ou string, será validado o tamanho, se for inteiro será validado se o valor está dentro do possível [Para este caso deverá ser repassado a regra de que o número deve ser um inteiro - Integer ou Numeric])
     * - date_format: Se a data está no formato desejado
     * - digits: Se o valor tem a quantidade de dígitos especificadas
     * - digits_between: Se os dígitos estão dentro de um valor mínimo e máximo 
     * - integer: Se o valor é um inteiro
     * - min: Se o valor é maior que o mínimo exigido (Se array ou string, será validado o tamanho, se for inteiro será validado se o valor é maior ou igual que o mínimo [Para este caso deverá ser repassado a regra de que o número deve ser um inteiro - Integer ou Numeric])
     * - min_digits: Se o valor contém um número mínimo de digitos
     * - max: Se o valor é menor que o máximo exigido (Se array ou string, será validado o tamanho, se for inteiro será validado se o valor é menor ou igual que o máximo [Para este caso deverá ser repassado a regra de que o número deve ser um inteiro - Integer ou Numeric])
     * - max_digits: Se o valor contém um número máximo de digitos
     * - numeric: Se o valor é numérico
     * - size: Se o valor tem o tamanho especificado (Se array ou string, será validado o tamanho, se for inteiro será validado se o valor é igual ao esperado [Para este caso deverá ser repassado a regra de que o número deve ser um inteiro - Integer ou Numeric])
     * - required: Se o campo tem um valor
     * - unique_entity: Bloqueia caso já exista um registro com este valor. Deve ser especificado a entidade e o campo a ser validado. Exemplo: unique_entity:Pessoa,email
     * - exists_entity: Verifica se existe um registro com este valor. Deve ser especificado a entidade e o campo a ser validado (Se não for especificado, será usado o id). Exemplo: exists_entity:Classe
     * 
     * @param mixed $data 
     *  Os dados podem ser um objeto (entidade) ou um array com dados. As validações podem ocorrer a filhos de objetos, por exemplo. conselho.classe.id para o id da classe dentro do conselho
     * @param array $rules 
     *  As regras sempre serão um array indexado (de chave numérica), onde cada valor deverá ser uma regra. Exemplo:
     *  $rules = [
     *    'nome' => ['required', 'between:3:100', unique_entity:Pessoa,nome]
     *  ];
     * @param array $messages
     *  A mensagem de erro que deve ser apresentada ao usuário. 
     *   Deve ser repassado um array, onde cada campo será uma chave. 
     * 
     *     Para cada campo, pode ser passado um array com a mensagem o tipo da validação 
     *     $messages = [
     *      'nome' => [
     *          'required' => 'Não foi informado um nome',
     *          'between' => 'O nome deverá ter entre 3 e 100 caracteres'
     *          'unique_entity' => 'Já existe uma pessoa com este nome'
     *     ];
     *     * Caso não repassado mensagens ou mensagem para uma validação será usado o texto padrão
     * 
     *   OU 
     * 
     *     Uma string que corresponde ao nome do campo que será substituido na mensagem "padrão" para o erro
     * 
     *     $messages = [
     *      'nome' => 'Nome da Pessoa'
     *     ];
     *     * Será utilizado o label "Nome da Pessoa" na mensagem padrão do sistema
     * 
     *   OU 
     *   
     *     Um mix de array para validação desejado e o label para as outras mensagens
     *     $messages = [
     *      'nome' => [
     *          'label' => 'Nome da Pessoa',
     *          'unique_entity' => 'Já existe uma pessoa com este nome'
     *     ];
     *     * Para as validações não especificadas será usada a mensagem padrão, substituindo o label por "Nome da Pessoa"
     *    
     */
    public function __construct($data, array $rules, array $messages = []){
        $this->setData($data);
        $this->setRules($rules);
        $this->setMessages($messages);
    }

    /**
     * Define os dados
     * @param mixed $data
     * @return void
     */
    public function setData($data){
        $this->data = $data;
    }

    /**
     * Define as regras
     * @param array $rules
     * @return void
     */
    public function setRules(array $rules){
        $this->rules = $rules;
    }

    /**
     * Define as mensagems
     * @param array $messages
     * @return void
     */
    public function setMessages(array $messages){
        $this->messages = $messages;
    }

    /**
     * Realiza a validação
     * @return boolean
     */
    public function validate(){
        $this->errors = [];
        foreach($this->rules as $attrName => $attrRules){
            $this->validateAttribute($attrName, $attrRules);
        }

        return !$this->fails();
    }

    /**
     * Retorna se houve alguma falha
     * @return void
     */
    public function fails(){
        if(!isset($this->errors)){
            $this->validate();
        }
        return count($this->errors) > 0;
    }

    /**
     * Retorna os erros ocorridos
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }

    /**
     * Realiza a validação de um atributo
     * @param string $attribute
     * @param array $rule
     * @return void
     */
    protected function validateAttribute($attrName, $attrRules){
        $attrValue = $this->getValue($attrName);
        foreach($attrRules as $attrRule){
            [$rule, $parameters] = $this->parseRule($attrRule);
            if(is_object($rule)){
                //@todo Adicionar implementação, quando o que for repassado for um objeto
            }
            elseif(is_string($rule)){
                $method = "validate".$rule;
                if((!method_exists($this, $method)) || (!$this->$method($attrName, $attrValue, $parameters))){
                    $this->addFailure($attrName, $rule, $parameters);
                }
            }
        }
    }

    /**
     * Retorna o valor de um atributo
     *
     * @param string $attribute
     * @return void
     */
    public function getValue($attribute){
        if(strpos($attribute, '.') === false){
            if(is_object($this->data)){
                return Bean::callGetter($this->data, $attribute);
            }
            else{
                return isset($this->data[$attribute]) ? $this->data[$attribute] : null;
            }
        }
        return $this->getValueRecursive(explode('.', $attribute), $this->data);
    }

    /**
     * Carrega o valor recursivamente
     *
     * @param array $nestedAttributes
     * @param mixed $dataParent
     * @return void
     */
    protected function getValueRecursive($nestedAttributes, $dataParent){
        $returnValue = null;
        $value       = array_shift($nestedAttributes);
        if(is_array($dataParent)){
            $returnValue = isset($dataParent[$value]) ? $dataParent[$value] : null;
        }
        elseif(is_object($dataParent)){
            $method = 'get' . ucfirst(strtolower($value));
            if (method_exists($dataParent, $method)) {
                $returnValue = call_user_func_array([$dataParent, $method], []);
            }
        }
        if($returnValue && count($nestedAttributes) > 0){
            return $this->getValueRecursive($nestedAttributes, $returnValue);
        }
        return $returnValue;
    }

    /**
     * Extrai informações sobre a regra
     * @param string $rule
     * @return void
     */
    protected function parseStringRule($rule){
        $parameters = [];
        if (strpos($rule, ':') !== false) {
            [$rule, $parameter] = explode(':', $rule, 2);
            $parameters = str_getcsv($parameter);
        }
        return [$this->studly(trim($rule)), $parameters];
    }

    protected function parseRule($rule){
        if(is_object($rule)){
            return [$rule, []];
        }

        if(is_array($rule)){
            return [$this->studly(trim($rule[0], '')), array_slice($rule, 1)];
        }
        return $this->parseStringRule($rule);
    }

    /**
     * Adiciona uma erro ocorrido
     * @param string $attribute
     * @param string $rule
     * @param array $parameters
     * @return void
     */
    protected function addFailure($attribute, $rule, $parameters = []){
        if(!isset($this->errors[$attribute])){
            $this->errors[$attribute] = [];
        }
        $this->errors[$attribute][] = $this->makeMessage($attribute, $rule, $parameters);
    }

    /**
     * Determine if the given attribute has a rule in the given set.
     *
     * @param  string  $attribute
     * @param  string|array  $rules
     * @return bool
     */
    protected function hasRule($attribute, $rules)
    {
        return ! is_null($this->getRule($attribute, $rules));
    }

    /**
     * Get a rule and its parameters for a given attribute.
     *
     * @param  string  $attribute
     * @param  string|array  $rules
     * @return array|null
     */
    protected function getRule($attribute, $rules)
    {
        if(!array_key_exists($attribute, $this->rules)) {
            return;
        }

        $rules = (array) $rules;
        foreach ($this->rules[$attribute] as $rule) {
            [$rule, $parameters] = $this->parseRule($rule);
            if (in_array($rule, $rules)) {
                return [$rule, $parameters];
            }
        }
    }

    private function studly($value){
        $words = explode(' ', str_replace(['-', '_'], ' ', $value));
        $studlyWords = array_map(function($word) {
            return ucfirst($word);
        }, $words);
        return implode($studlyWords);
    }
}
