<?php 

namespace Treino\Entity;

use BaseEmpds\Model\Interfaces\Entity;
use JsonSerializable;
/**
 * @Entity
 * @Table(name="Equipe")
 */
class Equipe implements JsonSerializable, Entity
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;
    
    /**
     * @Column(type="string", nullable=false)
     */
    private $nome;
    
    /**
     *  @Column(type="string", nullable=false,unique=true, length=12)
     * 
     */
    private $sigla;
    /**
     * @Column(type="string", nullable=false)
     */
    private $descricao;

    public function setId($id)
    {
        $this->id=$id;
    }
    /**
     * retorna o id da equipe
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * 
     * @param string $nome 
     * @return void
     */
    public function setNome($nome)
    {
        $this->nome=$nome;
    }
    /**
     * retorna o nome da equipe
     * 
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }
    /**
     * define a sigla da equipe
     * @param string $sigla
     * @return void
     */
    public function setSigla($sigla)
    {
        $this->sigla=$sigla;
    }
    /**
     * retorna a sigla da equipe
     * 
     * @return string
     */
    public function getSigla()
    {
        return $this-> sigla;
    }
    /**
     * define a descricao da equipe
     * @param string $descricao
     * @return void
     */
    public function setDescricao($descricao)
    {
        $this-> descricao = $descricao;
    }
    /**
     * retorna a descricao da equipe
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    public function jsonSerialize()
    {
        return [
           'id'  => $this->getId(),
           'nome' => $this->getNome(),
           'sigla' => $this->getSigla(),
           'descricao' => $this->getDescricao()
        ];
    }
}