<?php

namespace BaseEmpds\Model;

use BaseEmpds\Model\BaseFactory;
use BaseEmpds\Model\Interfaces\EntitySeeder;
use Exception;

/**
 * @author Gustavo Santos
 * @since  14/03/2021
 */
abstract class BaseSeeder implements EntitySeeder
{

    /**
     * @var BaseEmpds\Model\Interfaces\EntityRepository
     */
    private $repository;

    /**
     * @var array;
     */
    private $seedsToPlant;


    public final function __construct()
    {
        $this->loadSeedsOfEnvironment();
        $this->repository = BaseFactory::getRepository($this->getClassName());
    }

    abstract public function seedsOfDev();
    abstract public function seedsOfHom();
    abstract public function seedsOfProd();

    /**
     * @inheritdoc
     */
    public function loadSeedsOfEnvironment()
    {

        if (strcmp($_SERVER['AMBIENTE'], 'DEV') == 0) {
            return $this->seedsToPlant = $this->seedsOfDev();
        }

        if (strcmp($_SERVER['AMBIENTE'], 'HOM') == 0) {
            return $this->seedsToPlant = $this->seedsOfHom();
        }

        if (strcmp($_SERVER['AMBIENTE'], 'PROD') == 0) {
            return $this->seedsToPlant = $this->seedsOfProd();
        }

        return $this->seedsToPlant;
    }

    /**
     * @inheritdoc
     */
    public function seeds()
    {
        $sown = [];
        $erros = [];
        $alreadyExist = [];
        foreach ($this->seedsToPlant as $seed) {
            try {
                if ($this->repository->getById($seed['id']) == null) {
                    $entity = BaseFactory::getEntity($this->getClassName());
                    Bean::loadEntity($entity, $seed);

                    $this->repository->add($entity);
                    $sown[] = $entity;
                } else {
                    $alreadyExist[] = $seed;
                }
            } catch (Exception $th) {
                $erros[] = ['id' => $seed['id'], 'message' => $th->getMessage() . " - " . $th->getTraceAsString()];
            }
        }

        return ['dadosGerados' => $sown, 'erros' => $erros, 'jaExiste' => $alreadyExist];
    }

    /**
     * @inheritdoc
     */
    public function truncate()
    {
        return $this->repository->truncate();
    }

    /**
     * Retorna o nome da classe com base no nome da classe atual
     * @return String
     */
    private function getClassName()
    {
        $sNameClass = str_replace(SEEDER_NAMESPACE, '', "\\" . get_class($this));
        $sNameClass = str_replace('Seeder', '', $sNameClass);

        return $sNameClass;
    }
}
