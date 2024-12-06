<?php

namespace BaseEmpds\Model\Service\Traits;

/**
 * Trait básico para iteração com arquivos
 * @author Glauco David Laicht
 */
trait BaseFileService{

  /**
   * Retorna o nome da entidade que armazena os arquivos
   * @return string
   */
  protected function getNameEntityFile(){
    return NAME_FILE_ENTITY;
  }
}