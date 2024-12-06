<?php

namespace BaseEmpds\Model\Interfaces;

interface EntityController
{

    /**
     * Retorna uma lista de objetos do tipo Entity
     */
    public function getAll();

    /**
     * Salva dados da entity na base de dados
     */
    public function save();

    /**
     * Chama o método save para atualizar dados da entity
     */
    public function update();

    /**
     * Deleta um objeto do tipo entity da base de dados
     */
    public function remove();
}
