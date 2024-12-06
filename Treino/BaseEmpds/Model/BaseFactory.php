<?php

namespace BaseEmpds\Model;

/**
 * @author Rodrigo
 * @since  03/08/2020
 * @version 2.0 14/03/2021 Gustavo Santos
 */
abstract class BaseFactory
{
    /**
     *  @var string constante que aponta para o namespace da entity
     */
    const TIPO_ENTITY     = 1;
    const TIPO_MODEL      = 2;
    const TIPO_VALIDATOR  = 3;
    const TIPO_REPOSITORY = 4;

    /**
     * Retorna a interface Entity base no nome da classe descendente
     * 
     * @return \BaseEmpds\Model\Interfaces\EntityValidatorInterface
     */
    public static function getValidator($sEntityName)
    {
        $xClass = VALIDATOR_NAMESPACE . $sEntityName . 'Validator';
        return new $xClass();
    }

    /**
     * Retorna a interface Entity base no nome da classe descendente
     * 
     * @return \BaseEmpds\Model\Interfaces\EntityRepository
     */
    public static function getRepository($sEntityName)
    {
        $xClass = REPOSITORY_NAMESPACE . $sEntityName . 'Repository';
        return new $xClass();
    }

    /**
     * Retorna a interface Entity base no nome da classe descendente
     * 
     * @return \BaseEmpds\Model\Interfaces\EntityService
     */
    public static function getService($sAction, $sEntityName)
    {
        $xClass = SERVICE_NAMESPACE . $sAction . $sEntityName . 'Service';
        return new $xClass();
    }

    /**
     * Retorna a interface Entity base no nome da classe descendente
     * @return \BaseEmpds\Model\Interfaces\Entity
     */
    public static function getEntity($sEntityName)
    {
        $xClass = ENTITY_NAMESPACE . $sEntityName;
        return new $xClass();
    }

    /**
     * Retorna a instância de uma entidade, através de seu ID
     * 
     * NÃO É RECOMENDADO USAR ESTE MÉTODO DENTRO DE LOOPS, PARA EVITAR INSTÂNCIA MÚLTIPLAS DE REPOSITÓRIOS
     * 
     * @return \BaseEmpds\Model\Interfaces\Entity
     */
    public static function getEntityById($sEntityName, $id, $throws=false)
    {
        $xClass      = REPOSITORY_NAMESPACE . $sEntityName . 'Repository';
        /** @var \BaseEmpds\Model\Repository\BaseRepository */ 
        $oRepository = new $xClass();
        if($throws){
            return $oRepository->getByIdOrFail($id);
        }
        return $oRepository->getById($id);
    }

    /**
     * Retorna a classe de Seed
     * @return \BaseEmpds\Model\Interfaces\EntitySeeder
     */
    public static function getSeeder($sEntityName)
    {   
        $xClass  = SEEDER_NAMESPACE . $sEntityName . 'Seeder';

        return new $xClass();
    }


    /**
     * Retorna a classe de Teste
     * @return \BaseEmpds\Test\TestConfig
     */
    public static function getTest($sEntityName)
    {
        $xClass = TEST_NAMESPACE . 'Test' . $sEntityName . 'Controller';
        return new $xClass();
    }

    /**
     * Retorna se uma classe implementa uma interface, pelo nome das duas
     * @return boolean
     */
    public static function implements($sEntityName, $sInterface, $tipo = self::TIPO_ENTITY)
    {
        $sNameSpace = self::getNamespace($tipo);
        return is_subclass_of($sNameSpace . $sEntityName, $sInterface);
    }

    /**
     * Realiza chamado de um método estático
     * @return mixed
     */
    public static function callStatic($sEntityName, $sMethod, $parameters = [], $tipo = self::TIPO_ENTITY)
    {
        $sNameSpace = self::getNamespace($tipo);
        return call_user_func(array($sNameSpace . $sEntityName, $sMethod), $parameters);
    }

    /**
     * Retorna o namespace através das constantes de tipo
     * @param int $tipo
     * @return string
     */
    private static function getNamespace($tipo)
    {
        switch ($tipo) {
            case self::TIPO_ENTITY:
                return ENTITY_NAMESPACE;
            case self::TIPO_MODEL:
                return MODEL_NAMESPACE;
            case self::TIPO_REPOSITORY:
                return REPOSITORY_NAMESPACE;
            case self::TIPO_VALIDATOR:
                return VALIDATOR_NAMESPACE;
            default:
                return '';
        }
    }
}
