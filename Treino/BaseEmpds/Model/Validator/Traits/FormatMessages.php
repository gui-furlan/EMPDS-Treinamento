<?php

namespace BaseEmpds\Model\Validator\Traits;

/**
 * Classe para aplicar formatação nas mensagens
 */
trait FormatMessages
{

    use ReplacesAttributes;

    protected $defaultMessages = [
        'accepted'             => 'O campo :attribute deve ser aceito.',
        'accepted_if'          => 'O :attribute deve ser aceito quando :other for :value.',
        'active_url'           => 'O campo :attribute não é uma URL válida.',
        'after'                => 'O campo :attribute deve ser uma data posterior a :date.',
        'after_or_equal'       => 'O campo :attribute deve ser uma data posterior ou igual a :date.',
        'alpha'                => 'O campo :attribute só pode conter letras.',
        'alpha_dash'           => 'O campo :attribute só pode conter letras, números e traços.',
        'alpha_num'            => 'O campo :attribute só pode conter letras e números.',
        'array'                => 'O campo :attribute deve ser uma matriz.',
        'before'               => 'O campo :attribute deve ser uma data anterior :date.',
        'before_or_equal'      => 'O campo :attribute deve ser uma data anterior ou igual a :date.',
        'between'              => [
            'numeric' => 'O campo :attribute deve ser entre :min e :max.',
            'file'    => 'O campo :attribute deve ser entre :min e :max kilobytes.',
            'string'  => 'O campo :attribute deve ser entre :min e :max caracteres.',
            'array'   => 'O campo :attribute deve ter entre :min e :max itens.',
        ],
        'boolean'              => 'O campo :attribute deve ser verdadeiro ou falso.',
        'confirmed'            => 'O campo :attribute de confirmação não confere.',
        'current_password'     => 'A senha está incorreta.',
        'date'                 => 'O campo :attribute não é uma data válida.',
        'date_equals'          => 'O campo :attribute deve ser uma data igual a :date.',
        'date_format'          => 'O campo :attribute não corresponde ao formato :format.',
        'declined'             => 'O :attribute deve ser recusado.',
        'declined_if'          => 'O :attribute deve ser recusado quando :other for :value.',
        'different'            => 'Os campos :attribute e :other devem ser diferentes.',
        'digits'               => 'O campo :attribute deve ter :digits dígitos.',
        'digits_between'       => 'O campo :attribute deve ter entre :min e :max dígitos.',
        'dimensions'           => 'O campo :attribute tem dimensões de imagem inválidas.',
        'distinct'             => 'O campo :attribute campo tem um valor duplicado.',
        'doesnt_start_with'    => 'O :attribute não pode começar com um dos seguintes: :values.',
        'email'                => 'O campo :attribute deve ser um endereço de e-mail válido.',
        'ends_with'            => 'O campo :attribute deve terminar com um dos seguintes: :values',
        'enum'                 => 'O :attribute selecionado é inválido.',
        'exists'               => 'O campo :attribute selecionado é inválido.',
        'exists_entity'        => 'O campo :attribute informado não é inválido.',
        'file'                 => 'O campo :attribute deve ser um arquivo.',
        'filled'               => 'O campo :attribute deve ter um valor.',
        'gt' => [
            'numeric' => 'O campo :attribute deve ser maior que :value.',
            'file'    => 'O campo :attribute deve ser maior que :value kilobytes.',
            'string'  => 'O campo :attribute deve ser maior que :value caracteres.',
            'array'   => 'O campo :attribute deve conter mais de :value itens.',
        ],
        'gte' => [
            'numeric' => 'O campo :attribute deve ser maior ou igual a :value.',
            'file'    => 'O campo :attribute deve ser maior ou igual a :value kilobytes.',
            'string'  => 'O campo :attribute deve ser maior ou igual a :value caracteres.',
            'array'   => 'O campo :attribute deve conter :value itens ou mais.',
        ],
        'image'                => 'O campo :attribute deve ser uma imagem.',
        'in'                   => 'O campo :attribute selecionado é inválido.',
        'in_array'             => 'O campo :attribute não existe em :other.',
        'integer'              => 'O campo :attribute deve ser um número inteiro.',
        'ip'                   => 'O campo :attribute deve ser um endereço de IP válido.',
        'ipv4'                 => 'O campo :attribute deve ser um endereço IPv4 válido.',
        'ipv6'                 => 'O campo :attribute deve ser um endereço IPv6 válido.',
        'json'                 => 'O campo :attribute deve ser uma string JSON válida.',
        'lt' => [
            'numeric' => 'O campo :attribute deve ser menor que :value.',
            'file'    => 'O campo :attribute deve ser menor que :value kilobytes.',
            'string'  => 'O campo :attribute deve ser menor que :value caracteres.',
            'array'   => 'O campo :attribute deve conter menos de :value itens.',
        ],
        'lte' => [
            'numeric' => 'O campo :attribute deve ser menor ou igual a :value.',
            'file'    => 'O campo :attribute deve ser menor ou igual a :value kilobytes.',
            'string'  => 'O campo :attribute deve ser menor ou igual a :value caracteres.',
            'array'   => 'O campo :attribute não deve conter mais que :value itens.',
        ],
        'max' => [
            'numeric' => 'O campo :attribute não pode ser superior a :max.',
            'file'    => 'O campo :attribute não pode ser superior a :max kilobytes.',
            'string'  => 'O campo :attribute não pode ser superior a :max caracteres.',
            'array'   => 'O campo :attribute não pode ter mais do que :max itens.',
        ],
        'max_digits'           => 'O campo :attribute não deve ter mais que :max dígitos.',
        'mimes'                => 'O campo :attribute deve ser um arquivo do tipo: :values.',
        'mimetypes'            => 'O campo :attribute deve ser um arquivo do tipo: :values.',
        'min' => [
            'numeric' => 'O campo :attribute deve ser pelo menos :min.',
            'file'    => 'O campo :attribute deve ter pelo menos :min kilobytes.',
            'string'  => 'O campo :attribute deve ter pelo menos :min caracteres.',
            'array'   => 'O campo :attribute deve ter pelo menos :min itens.',
        ],
        'min_digits'           => 'O campo :attribute deve ter pelo menos :min dígitos.',
        'not_in'               => 'O campo :attribute selecionado é inválido.',
        'multiple_of'          => 'O campo :attribute deve ser um múltiplo de :value.',
        'not_regex'            => 'O campo :attribute possui um formato inválido.',
        'numeric'              => 'O campo :attribute deve ser um número.',
        'password' => [
            'letters'          => 'O campo :attribute deve conter pelo menos uma letra.',
            'mixed'            => 'O campo :attribute deve conter pelo menos uma letra maiúscula e uma letra minúscula.',
            'numbers'          => 'O campo :attribute deve conter pelo menos um número.',
            'symbols'          => 'O campo :attribute deve conter pelo menos um símbolo.',
            'uncompromised'    => 'A senha que você inseriu em :attribute está em um vazamento de dados.'
                . ' Por favor escolha uma senha diferente.',
        ],
        'present'              => 'O campo :attribute deve estar presente.',
        'regex'                => 'O campo :attribute tem um formato inválido.',
        'required'             => 'O campo :attribute não foi informado.',
        'required_array_keys'  => 'O campo :attribute deve conter entradas para: :values.',
        'required_if'          => 'O campo :attribute é obrigatório quando :other for :value.',
        'required_unless'      => 'O campo :attribute é obrigatório exceto quando :other for :values.',
        'required_with'        => 'O campo :attribute é obrigatório quando :values está presente.',
        'required_with_all'    => 'O campo :attribute é obrigatório quando :values está presente.',
        'required_without'     => 'O campo :attribute é obrigatório quando :values não está presente.',
        'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos :values estão presentes.',
        'prohibited'           => 'O campo :attribute é proibido.',
        'prohibited_if'        => 'O campo :attribute é proibido quando :other for :value.',
        'prohibited_unless'    => 'O campo :attribute é proibido exceto quando :other for :values.',
        'prohibits'            => 'O campo :attribute proíbe :other de estar presente.',
        'same'                 => 'Os campos :attribute e :other devem corresponder.',
        'size'                 => [
            'numeric' => 'O campo :attribute deve ser :size.',
            'file'    => 'O campo :attribute deve ser :size kilobytes.',
            'string'  => 'O campo :attribute deve ser :size caracteres.',
            'array'   => 'O campo :attribute deve conter :size itens.',
        ],
        'starts_with'          => 'O campo :attribute deve começar com um dos seguintes valores: :values',
        'string'               => 'O campo :attribute deve ser uma string.',
        'timezone'             => 'O campo :attribute deve ser uma zona válida.',
        'unique'               => 'O campo :attribute já está sendo utilizado.',
        'unique_entity'        => 'O campo :attribute já está sendo utilizado.',
        'uploaded'             => 'Ocorreu uma falha no upload do campo :attribute.',
        'url'                  => 'O campo :attribute tem um formato inválido.',
        'uuid' => 'O campo :attribute deve ser um UUID válido.',
    ];

    protected function makeMessage($attribute, $rule, $parameters = []){
        $message = $this->getMessage($attribute, $rule, $parameters);
        if($message){
            $attributeLabel = $this->getAttributeLabel($attribute);
            $message = str_replace(
                [':attribute', ':ATTRIBUTE', ':Attribute'],
                [$attributeLabel, strtoupper($attributeLabel), ucfirst($attributeLabel)],
                $message
            );

            $method = "replace".$rule;
            if(method_exists($this, $method)){
                return $this->$method($message, $attribute, $rule, $parameters);
            }
            return $message;
        }
        return 'Não foi possível realizar a validação do campo '.$attribute.' ('.$rule.')';
    }

    protected function getMessage($attribute, $rule, $parameters = [])
    {
        $rule    = $this->snake($rule);
        $message = '';
        if (isset($this->messages[$attribute])) {
            if (isset($this->messages[$attribute][$rule])) {
                $message = $this->messages[$attribute][$rule];
            }
        }

        if (!$message && isset($this->messages[$rule])) {
            $message = $this->messages[$rule];
        }

        if (!$message && isset($this->defaultMessages[$rule])) {
            $message = $this->defaultMessages[$rule];
            if(is_array($message)){
                $type = $this->getAttributeType($attribute);
                $message = (isset($message[$type])) ? $message[$type] : $message[array_key_first($message)];
            }
        }
        
        return $message;
    }

    protected function getAttributeLabel($attribute){
        if(isset($this->messages[$attribute])){
            if(is_string($this->messages[$attribute])){
                return $this->messages[$attribute];
            }
            elseif(is_array($this->messages[$attribute])){
                if(isset($this->messages[$attribute]['label'])){
                    return $this->messages[$attribute]['label'];
                }
            }
        }
        return $attribute;
    }

    /**
     * Get the data type of the given attribute.
     *
     * @param  string  $attribute
     * @return string
     */
    protected function getAttributeType($attribute)
    {
        if ($this->hasRule($attribute, ['Integer', 'Numeric'])) {
            return 'numeric';
        } 
        elseif ($this->hasRule($attribute, ['Array'])) {
            return 'array';
        }

        return 'string';
    }

    
    /**
     * Convert a string to snake case.
     * @param  string  $value
     * @param  string  $delimiter
     * @return string
     */
    private function snake($value, $delimiter = '_'){
        if(!ctype_lower($value)){
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value));
        }
        return $value;
    }
}
