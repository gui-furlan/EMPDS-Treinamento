<?php

namespace BaseEmpds\Model\Repository;

use BaseEmpds\Model\JoinEntity;

class JoinRepository
{

    /** 
     * @var \BaseEmpds\Model\JoinEntity[] 
     */
    protected $joins;

    public function __construct()
    {
        $this->joins = [];
    }

    /**
     * Adiciona um Join
     */
    public function addJoin($nome, $ativo = false, $alias = null, $select = null)
    {
        $join = new JoinEntity();
        $join->setNome($nome);
        $join->setAtivo($ativo);
        $join->setAlias((is_null($alias) ? substr($alias, 0, 1) :  $alias));
        $join->setSelect((is_null($select) ? $this->alias : $select));
        return $this->joins[$nome] = $join;
    }

    /**
     * Retorna um Join pelo nome
     * @return \BaseEmpds\Model\JoinEntity
     */
    public function getJoinByNome($nome)
    {
        return isset($this->joins[$nome]) ?? null;
    }

    /**
     * Altera a Query adicionando os joins ativos
     */
    public function changeQueryJoin(\Doctrine\ORM\QueryBuilder $builder)
    {
        $joins = $this->getJoinsAtivo();
        foreach ($joins as $join) {
            $builder->leftJoin($join->getNome(), $join->getAlias())->addSelect($join->getSelect());
        }
    }

    /**
     * Retorna todos os JOINs ativos
     * @return \BaseEmpds\Model\Repository\JoinEntity[]
     */
    protected function getJoinsAtivo()
    {
        $joins = [];
        foreach ($this->joins as $join) {
            if ($join->getAtivo()) {
                $joins[] = $join;
            }
        }
        return $joins;
    }
}
