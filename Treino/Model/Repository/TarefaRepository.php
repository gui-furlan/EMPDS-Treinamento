<?php

namespace Treino\Model\Repository;

use BaseEmpds\Model\BaseFactory;
use BaseEmpds\Model\Repository\BaseRepository;
use Geral\Model\Date;

class TarefaRepository extends BaseRepository
{
    /**
     * Summary of formatDataPersist
     * @param Treino\Entity\Tarefa $entity
     * @return void
     */
    protected function formatDataPersist($entity)
    {
        if (is_scalar($entity->getMembro())) {
            /**
             * @var Treino\Model\Repository\MembroRepository
             */
            $oMembroRepository = BaseFactory::getRepository('Membro');
            $entity->setMembro($oMembroRepository->getById($entity->getMembro()));

        }
        if(is_string($entity->getDataRegistro())) 
        {
        $dataFormatada = Date::convStringToDatetime($entity->getDataRegistro(),Date::DATAHORASEMSEGUNDOS_FORMAT);
        $entity->setDataRegistro($dataFormatada);
        }
    }
    public function getTarefaByMembroId($membroId)
    {
        $builder = $this->newQueryBuilder();
        $builder->join('u.membro', 'm')->addSelect('m');
        $builder->where('m.id=?1')->setParameter(1, $membroId);
        return $this->getResultQuery($builder->getQuery(), false);
    }
    public function membroTarefaIncompleta($membroId)
    {
        $builder = $this->newQueryBuilder();
        $builder->join('u.membro', 'm')
            ->where('m.id = ?1')
            ->andWhere('u.completed = ?2')
            ->setParameter(1, $membroId)
            ->setParameter(2, false);
        return $this->getOneOrNullResult($builder->getQuery());
    }
    //para puxar o endereço de tarefa preciso do que faço abaixo
    /**
     * Summary of completaTarefa
     * @param Treino\Entity\Tarefa $entity
     * 
     */
    public function completaTarefa($idTarefa)
    {
        try {
            # code...
            $tarefa = $this->getById($idTarefa);
            if (!is_null($idTarefa) && !$tarefa->getCompleted()) {

                $tarefa->setCompleted();
                $this->processUpdate($tarefa);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}