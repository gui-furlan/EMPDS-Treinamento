<?php

namespace BaseEmpds\Model\Traits;

/**
 * Trait para adicionar gerenciamento de atributos
 * @author Glauco David Laicht
 */
trait ManageAttributes{

    /**
     * Atributos
     * @var array
     */
    protected $attributes = [];

    /**
     * Define os atributos
     * @param array $attributes
     * @return void
     */
    public function setAttributes(array $attributes){
        $this->attributes = $attributes;
    }

    /**
     * Retorna os atributos
     * @return void
     */
    public function getAttributes(){
        return $this->attributes;
    }

    /**
     * Adiciona um atributo
     * @param string $attrName
     * @param mixed $attrValue
     * @return void
     */
    public function addAttribute($attrName, $attrValue){
        $this->attributes[$attrName] = $attrValue;
    }

    /**
     * Retorna o valor de um atributo
     * @param string $attrName
     * @return mixed
     */
    public function getAttribute($attrName, $defaultValue=null){
        if(isset($this->attributes[$attrName])){
            return $this->attributes[$attrName];
        }
        return $defaultValue;
    }
}