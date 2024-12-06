<?php

namespace Treino\Entity;

use BaseEmpds\Model\Interfaces\Entity;
use JsonSerializable;
use Geral\Model\Date;
/**
 * @Entity
 * @Table(name="Tarefa")
 */
class Tarefa implements JsonSerializable, Entity
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
     * @Column(type="string", nullable=false)
     */
    private $descricao;
    /**
     * @Column(type="datetime", nullable=false)
     */
    private $dataRegistro;
    /**
     * @Column(type="boolean", nullable=false)
     */
    private $completed;

    /**
     * @ManyToOne(targetEntity ="Membro")
     * @JoinColumn(name="membro_id" , referencedColumnName="id")
     */
    private $membro;
    public function __construct()
    {
        $this->dataRegistro = date(Date::DATAHORASEMSEGUNDOS_FORMAT);
        $this->completed= false;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * retorna o id da tarefa
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * define o nome da tarefa
     * @param string $nome 
     * @return void
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    /**
     * retorna o nome da tarefa
     * 
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }
    /**
     * define a descricao da tarefa
     * @param string $descricao
     * @return void
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
    /**
     * retorna a descricao da tarefa
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }
    /**
     * define a DataRegistro
     * 
     * @return void
     */
    public function setDataRegistro($dataRegistro)
    {
        $this->dataRegistro = $dataRegistro;
    }
    /**
     * get data da tarefa
     * 
     */
    public function getDataRegistro($isFormatted = false)
    {
        return $isFormatted ? Date::convDatetimeToString($this->dataRegistro,Date::DATA_FORMAT) : $this->dataRegistro;
    }
    /**
     * Summary of setCompleted
     * @return self
     */
    public function setCompleted()
    {
        $this->completed = true;
        return $this;
    }


    /**
     * Summary of getCompleted
     *
     */
    public function getCompleted()
    {
        return $this->completed;
    }
    /**
     * define a pessoa que será o membro
     * @param int $membro
     * @return void
     */
    public function setMembro($membro)
    {
        $this->membro = $membro;

    }
    /**
     * devolve o Membro da tarefa com o mesmo esquema de ter que fazer o data format 
     */
    public function getMembro()
    {
        return $this->membro;
    }
    public function jsonSerialize()
    {

        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'descricao' => $this->getDescricao(),
            'dataRegistro' => $this->getDataRegistro(true),
            'completa' => $this->getCompleted(),
            'membro' => $this->getMembro()

        ];
    }
}
