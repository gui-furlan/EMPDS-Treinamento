<?php

namespace Treino\Model\Repository;

use BaseEmpds\Model\Repository\BaseRepository;

class PessoaRepository extends BaseRepository
{
  /**
   * Retorna uma pessoa pelo cpf
   *
   * @param string $cpf
   * @return Treino\Entity\Pessoa
   */
  
  public function getByCpf($cpf)
  {
    $builder = $this->newQueryBuilder();
    $builder->where('u.cpf = ?1')->setParameter(1, $cpf);
    return $this->getOneOrNullResult($builder->getQuery(), false);
  }
}