<?php

namespace BaseEmpds\Model\Interfaces;

interface EntityService{

    /**
     * Define uma entidade
     * @param Entity $entity
     * @return void
     */
    public function setEntity(Entity $entity);

    /**
     * Executa algum procedimento
     * @return mixed
     */
    public function execute();
}