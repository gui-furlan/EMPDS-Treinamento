<?php

namespace BaseEmpds\Model;

use BaseEmpds\Model\Interfaces\Entity;

abstract class Bean
{

    /**
     * Carrega os dados da entidade através de um array
     * @param \BaseEmpds\Model\Interfaces\Entity $entity 
     * @param array $data 
     */
    public static function loadEntity(Entity $entity, array $data, array $dataException = [])
    {
        foreach ($data as $propName => $value) {
            if (!in_array($propName, $dataException)) {
                static::callSetter($entity, $propName, $value);
            }
        }
    }

    /**
     * Define os dados de uma propriedade da entidade, se existir
     * @param \BaseEmpds\Model\Interfaces\Entity $entity 
     * @param string $propName 
     * @param mixed $value
     */
    public static function callSetter(Entity $entity, $propName, $value)
    {
        $method       = 'set' . ucfirst(strtolower($propName));
        if (method_exists($entity, $method)) {
            call_user_func_array([$entity, $method], [$value]);
        }
    }

    /**
     * Retorna os dados de uma propriedade da entidade, se existir
     * @param \BaseEmpds\Model\Interfaces\Entity $entity 
     * @param string $propName 
     */
    public static function callGetter(Entity $entity, $propName)
    {
        $method       = 'get' . ucfirst(strtolower($propName));
        if (method_exists($entity, $method)) {
            return call_user_func_array([$entity, $method], []);
        }
        return null;
    }
}
