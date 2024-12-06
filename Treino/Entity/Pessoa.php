<?php

namespace Treino\Entity;

use BaseEmpds\Model\Interfaces\Entity;
use JsonSerializable;

/**
 * @Entity
 * @Table(name="Pessoa")
 */
class Pessoa implements JsonSerializable, Entity
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
   * @Column(type="string", nullable=false, unique=true, length=11)
   */
  private $cpf;
  /**
   * @Column(type="integer", nullable=false)
   */
  private $idade;

  public function setId($id)
  {
    $this->id = $id;
  }
  /**
   * Retorna o id da pessoa
   *
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }
  /**
   * Define o nome da pessoa
   *
   * @param string $nome
   * @return void
   */
  public function setNome($nome)
  {
    $this->nome = $nome;
  }
  /**
   * Retorna o nome da pessoa
   *
   * @return string
   */
  public function getNome()
  {
    return $this->nome;
  }
  /**
   * Define o cpf da pessoa
   *
   * @param string $cpf
   * @return void
   */
  public function setCpf($cpf)
  {
    $this->cpf = $cpf;
  }
  /**
   * Retorna o cpf da pessoa
   *
   * @return string
   */
  public function getCpf()
  {
    return $this->cpf;
  }
  /**
   * Define a idade da pessoa
   *
   * @param integer $idade
   * @return void
   */
  public function setIdade($idade)
  {
    $this->idade = $idade;
  }
  /**
   * Retorna a idade da pessoa
   *
   * @return integer
   */
  public function getIdade()
  {
    return $this->idade;
  }

  public function jsonSerialize(){
    
    return [
      'id'    => $this->getId(),
      'nome'  => $this->getNome(),
      'cpf'   => $this->getCpf(),
      'idade' => $this->getIdade()
    ];
  }
}
