<?php

namespace BaseEmpds\Model\Interfaces;

/**
 * Interface para entidades que terão relacionamento com a tabela de arquivo
 */
interface FileRelationshipInterface{

  /**
   * Método deve retornar todos as propriedades/atributos da entidade que são um arquivo
   * 
   * @example 
   *  return [
   *    'arquivo'
   *  ]
   * 
   * OU
   * 
   *  return [
   *    'logo', 'documentacao'
   *  ]
   * 
   * Com isso, esses campos deverão ser um relacionamento para a tabela Arquivo
   * 
   * @return string[]
   */
  public function getArquivoProperties();

  /**
   * @return string
   */
  public function getDirectoryStorage();

  /**
   * Define se o relacionamento com a entidade será 1x1 (false) ou 1xN (true)
   * @return boolean
   */
  public function isMultipleFileRelationship();

}