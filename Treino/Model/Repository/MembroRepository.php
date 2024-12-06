<?php 

namespace Treino\Model\Repository;

use BaseEmpds\Model\BaseFactory;
use BaseEmpds\Model\Repository\BaseRepository;

class MembroRepository extends BaseRepository
{
    //format data persist serve para pegar o id da pessoa,e jogar o objeto completo pro banco 
    /**
     * Summary of formatDataPersist
     * @param Treino\Entity\Membro $entity
     * @return void
     */
    protected function formatDataPersist($entity){
        
        if(is_scalar( $entity->getPessoa())){
            /**
             * @var Treino/Model/Repository/PessoaRepository
             */
            $oPessoaRepository= BaseFactory::getRepository('Pessoa');
            $entity->setPessoa($oPessoaRepository->getById($entity->getPessoa()));

        }
        if (is_scalar($entity->getEquipe())) {
            /**
             * @var Treino/Model/Repository/EquipeRepository
             */
            $oEquipeRepository= BaseFactory::getRepository('Equipe');
            $entity->setEquipe($oEquipeRepository->getById($entity->getEquipe()));
        }
    }
    

    public function getAllMembrosByEquipe($idEquipe){
        
        $builder = $this->newQueryBuilder();
        //onde membro id pertencer a equipe
        
        $builder->join('u.pessoa','p')->addSelect('p');
        $builder->join('u.equipe','e')->addSelect('e');
        $builder->where('e.id=?1')->setParameter(1, $idEquipe);
        return $this->getResultQuery($builder->getQuery(),false);
    }
}