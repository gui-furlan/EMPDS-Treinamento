<?php

namespace BaseEmpds\Model\Repository\Interfaces;

use BaseEmpds\Model\Interfaces\EntityRepository;

/**
 * Interface responsável por implementar métodos da BaseFileRepository.
 * 
 * @author Glauco David Laicht
 */
interface BaseFileRepositoryInterface extends EntityRepository{
  
  public function getByHash($hash);

}