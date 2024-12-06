<?php 
namespace Treino\Model\Repository;

use BaseEmpds\Model\Repository\BaseRepository;

class EquipeRepository extends BaseRepository{
    public function getMembroBySigla($sigla){

        $builder = $this->newQueryBuilder();
        $builder->where('u.sigla=?1')->setParameter(1, $sigla);
        return $this->getOneOrNullResult($builder->getQuery(),false);

    }
    
}