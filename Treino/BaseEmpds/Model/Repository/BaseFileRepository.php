<?php

namespace BaseEmpds\Model\Repository;

use BaseEmpds\Model\Repository\Interfaces\BaseFileRepositoryInterface;
/**
 * Repositório para métodos de manipulação com arquivos
 * 
 * @author Glauco David Laicht
 */
abstract class BaseFileRepository extends BaseRepository implements BaseFileRepositoryInterface
{
  /**
   * Retorna um File encontrado por Hash
   *
   * @param string $hash
   * @return \BaseEmpds\Entity\FileEntity
   */
  public function getByHash($hash){
    //Instância um QueryBuilder
    $queryBuilder = $this->newQueryBuilder();
    //Aplica os Joins ativados
    $this->join->changeQueryJoin($queryBuilder);
    //Aplica alterações especificas da query
    $this->changeQuery($queryBuilder);
    //Aplica as condições
    $queryBuilder->where('u.hash = ?1')->setParameter(1, $hash);
    //Retorna o Resultado
    return $this->getOneOrNullResult($queryBuilder->getQuery(), false);
  }
}