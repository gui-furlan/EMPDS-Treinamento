<?php

namespace BaseEmpds\Model\Interfaces;

interface EntityRepository
{

    /**
     * Recuperar todos os objetos
     * @param boolean $toArray
     */
    public function getAll($toArray = false);

    /** 
     * Recuperar um único objeto com base no seu ID
     * @param int|null $iId 
     * @param boolean $toArray
     * @return \BaseEmpds\Model\Interfaces\Entity
     */
    public function getById($iId, $toArray = false);

    /**
     * Adicionar um novo objeto no banco de dados
     * @param \BaseEmpds\Model\Interfaces\Entity $oEntity - objeto do tipo Entity
     */
    public function add($oEntity);

    /**
     * Atualizar um objeto já existente no banco de dados
     * @param \BaseEmpds\Model\Interfaces\Entity $oEntity - objeto do tipo Entity
     */
    public function update($oEntity);

    /**
     * Remover um objeto já existente no banco de dados
     * @param \BaseEmpds\Model\Interfaces\Entity $oEntity - objeto do tipo Entity
     */
    public function remove($oEntity);

    /**
     * Remover um objeto já existente no banco de dados com base em seu ID
     * @param int $iId - Identificador do objeto
     */
    public function removeFromId($iId);

    /**
     * Realiza o Truncante na Tabela
     * @return boolean
     */
    public function truncate();
}
