<?php

namespace BaseEmpds\Model;

class JoinEntity
{

    private $nome;
    private $alias;
    private $select;
    private $ativo = false;

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setSelect($select)
    {
        $this->select = $select;
    }

    public function getSelect()
    {
        return $this->select;
    }

    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }
}
