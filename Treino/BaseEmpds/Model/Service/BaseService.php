<?php

namespace BaseEmpds\Model\Service;

use BaseEmpds\Model\BaseFactory;
use BaseEmpds\Model\Interfaces\Entity;
use BaseEmpds\Model\Interfaces\EntityService;
use BaseEmpds\Model\Repository\BaseRepository;

abstract class BaseService implements EntityService{

    /**
     * @var \BaseEmpds\Model\Interfaces\Entity
     */
    protected $entity;

    /**
     * @var \BaseEmpds\Model\Repository\BaseRepository
     */
    protected $repository;

    /**
     * @inheritDoc
     */
    public function setEntity(Entity $entity){
        $this->entity = $entity;
    }

    /**
     * Define o repository
     */
    public function setRepository(BaseRepository $repository){
        $this->repository = $repository;
    }

    /**
     * Retorna o repository
     * @return \BaseEmpds\Model\Repository\BaseRepository
     */
    public function getRepository(){
        if(!isset($this->repository)){
            $classname = get_class($this->entity);
            if ($pos = strrpos($classname, '\\')){
                $classname = substr($classname, $pos + 1);
            }
            $this->repository = BaseFactory::getRepository($classname);
        }
        return $this->repository;
    }
}