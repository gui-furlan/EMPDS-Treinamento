<?php
namespace BaseEmpds\Entity\Interfaces;

/**
 * FileInterface
 * @author Gustavo Hernandes Furtado de Avelar
 * @author Glauco David Laicht
 */

interface FileInterface
{
  /**
   * Retorna o nome do arquivo
   * @return string
   */
  public function getName();

  /**
   * Define o nome do arquivo
   * @param string $sName
   */
  public function setName($sName);

  /**
   * Retorna o nome único do arquivo gerado por algoritmo (Essencial para manter integridade)
   * @return string
   */
  public function getUniqueName();

  /**
   * Define o nome único do arquivo
   * @param string $sUniqueName
   */
  public function setUniqueName($sUniqueName);

  /**
   * Retorna o tamanho do arquivo (Em bytes)
   * @return int
   */
  public function getSize();

  /**
   * Define o tamanhho do arquivo (Em bytes)
   * @param int $iSize
   */
  public function setSize($iSize);

  /**
   * Retorna a extensão do arquivo
   * @return string
   */
  public function getExtension();

  /**
   * Define a extensão do arquivo
   * @param string $sExtension
   */
  public function setExtension($sExtension);
  
  /**
   * Retorna o caminho até o arquivo
   * @return string
   */
  public function getPath();
  
  /**
   * Define o caminho até o arquivo
   * @param string $sPath
   */
  public function setPath($sPath);

  /**
   * Retorna o hash do arquivo
   * @return string
   */
  public function getHash();
}
