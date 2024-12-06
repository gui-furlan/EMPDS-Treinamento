<?php

namespace Treino\Entity;

use BaseEmpds\Model\Interfaces\Entity;
use JsonSerializable;

/**
 * @Entity
 * @Table(name="Membro")
 */
class Membro implements JsonSerializable, Entity
{

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;
    /**
     * 
     * @OneToOne(targetEntity ="Pessoa")
     * @JoinColumn(name="pessoa_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $pessoa;

     /**
     * 
     * @ManyToOne(targetEntity ="Equipe")
     * @JoinColumn(name="equipe_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $equipe;

    
    public function setId($id)
    {
        $this->id=$id;
    }
    
    /**
   * Retorna o id do membro
   *
   * @return integer
   */
    public function getId()
    {
        return $this->id;
    }
    /**
     * define a pessoa que será o membro
     * @param int $pessoa
     * @return void
     */
    public function setPessoa($pessoa)
    {
        $this -> pessoa=$pessoa;
    } 

    /**
     *  Retorna a pessoa
     * @return int
     */
    public function getPessoa()
    {
        return $this-> pessoa;
    }
    /**
     * Define a equipe do membro
     * @param int $equipe
     * @return void
     */
    public function setEquipe($equipe)
    {
        $this-> equipe=$equipe;
    }
    /**
     * 
     * Retorna o id da equipe
     * @return int
     */
    public function getEquipe ()
    {
        return $this-> equipe;
    } 
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'equipe'=> $this->getEquipe(),
            'pessoa'=> $this->getPessoa()
            
        ];
    }
}