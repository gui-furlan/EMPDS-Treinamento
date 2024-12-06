<?php

namespace BaseEmpds\Model\Repository;

use BaseEmpds\Model\AppContext;
use BaseEmpds\Model\Interfaces\EntityRepository;
use Doctrine\ORM\NoResultException;

abstract class BaseRepository implements EntityRepository
{

    /**
     * @var string que aponta para o diretório onde está localizada a entidade
     */
    protected $entity;

    /** 
     * @var \BaseEmpds\Model\Repository\JoinRepository 
     */
    protected $join;


    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct()
    {
        $this->join = new JoinRepository();
        $this->addJoins();
        $this->em = $GLOBALS['em'];
    }

    /**
     * Adiciona os joins relativos a classe
     */
    protected function addJoins()
    {
    }

    /**
     * Inicia uma transação
     */
    public function beginTransaction()
    {
        AppContext::getInstance()->beginTransaction();
    }

    /**
     * Efetiva uma transação
     */
    public function commitTransaction()
    {
        AppContext::getInstance()->commitTransaction();
    }

    /**
     * Cancela uma transação
     */
    public function rollbackTransaction()
    {
        AppContext::getInstance()->rollbackTransaction();
    }

    /**
     * Função para recuperar todos os objetos do tipo Entity cadastrados na base
     */
    public function getAll($toArray = false)
    {
        //Instância um QueryBuilder
        $queryBuilder = $this->newQueryBuilder();
        //Aplica os Joins ativados
        $this->join->changeQueryJoin($queryBuilder);
        //Aplica alterações especificas da query
        $this->changeQuery($queryBuilder);
        //Retorna o Resultado 
        return $this->getResultQuery($queryBuilder->getQuery(), $toArray);
    }

    /**
     * Função para recuperar um objeto especifico do tipo Entity com base no seu $iId
     * @param $iId - identificador do usuário
     * @return $oEntity - objeto do tipo Entity
     */
    public function getById($iId, $toArray = false)
    {
        //Instância um QueryBuilder
        $queryBuilder = $this->newQueryBuilder();
        //Aplica os Joins ativados
        $this->join->changeQueryJoin($queryBuilder);
        //Aplica alterações especificas da query
        $this->changeQuery($queryBuilder);
        //Aplica as condições pelo ID
        $this->changeQueryById($iId, $queryBuilder);
        //Retorna o Resultado
        return $this->getOneOrNullResult($queryBuilder->getQuery(), $toArray);
    }

    /**
     * Função para recuperar um objeto especifico do tipo Entity com base no seu $iId, se falhar retornará um erro
     * @param $iId - identificador do usuário
     * @return $oEntity - objeto do tipo Entity
     */
    public function getByIdOrFail($iId)
    {
        //Instância um QueryBuilder
        $queryBuilder = $this->newQueryBuilder();
        //Aplica os Joins ativados
        $this->join->changeQueryJoin($queryBuilder);
        //Aplica alterações especificas da query
        $this->changeQuery($queryBuilder);
        //Aplica as condições pelo ID
        $this->changeQueryById($iId, $queryBuilder);
        try {
            $result = $this->getSingleResult($queryBuilder->getQuery());
        } catch (NoResultException $e) {
            throw new \Exception('Não foi possível encontrar o registro (Registro: ' . $this->getClassName() . ', ID: ' . $iId . ')!');
        }
        return $result;
    }

    /**
     * Função para persistir um novo objeto Entity no banco de dados
     * @param \BaseEmpds\Model\Interfaces\Entity $oEntity = objeto do tipo Entity 
     **/
    public function add($oEntity)
    {
        try {
            $this->formatDataPersist($oEntity);
            $this->processAdd($oEntity);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Função para atualizar e persistir um novo objeto do tipo Pessoa no banco
     * @param \BaseEmpds\Model\Interfaces\Entity $oEntity = objeto do tipo Entity
     **/
    public function update($oEntity)
    {
        try {
            $this->formatDataPersist($oEntity);
            $this->processUpdate($oEntity);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Função para remover um objeto do tipo Entity
     * @param \BaseEmpds\Model\Interfaces\Entity $oEntity = objeto do tipo Entity
     */
    public function remove($oEntity)
    {
        try {
            $this->processRemove($oEntity);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Função para remover um objeto do tipo Entity com base no seu ID.
     * @param $iId - identificador do usuário
     */
    public function removeFromId($iId)
    {
        $oEntity = $this->getById($iId);
        if (!$oEntity) {
            throw new \Exception('Não foi possível encontrar o registro!');
        }
        $this->remove($oEntity);
    }

    /** 
     * @return \BaseEmpds\Model\Repository\JoinRepository 
     * */
    public function getJoin()
    {
        return $this->join;
    }

    /**
     * Retorna a quantidade de registro filtrando pelo valor de uma coluna
     * @param string $column
     * @param mixed $value
     * @return void
     */
    public function getCountByColumn($column, $value){
        //Instância um QueryBuilder
        $queryBuilder = $this->newQueryBuilder();
        $queryBuilder->where('u.'.$column.' = ?1')->setParameter(1, $value);
        $queryBuilder->select('count(u.'.$column.')');
        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * Realiza adição de join e cláusulas a query
     * @param \Doctrine\ORM\QueryBuilder $builder
     */
    protected function changeQuery($builder)
    {
    }

    /**
     * Formata os dados antes de persistir o objeto, se necessário
     * @param \BaseEmpds\Model\Interfaces\Entity $entity
     */
    protected function formatDataPersist($entity)
    {
    }

    /**
     * Executa o Add
     * @param \BaseEmpds\Model\Interfaces\Entity $entity
     */
    protected function processAdd($oEntity)
    {
        $this->em->persist($oEntity);
        $this->em->flush();
    }

    /**
     * Executa o update
     * @param \BaseEmpds\Model\Interfaces\Entity $entity
     */
    protected function processUpdate($oEntity)
    {
        $this->em->merge($oEntity);
        $this->em->flush();
    }

    /** 
     *  Executa um SQL
     */
    protected function getResultSQL($query)
    {

        return $this->prepareAndExecute($query)->fetchAll();
    }
    
    protected function getCountResultSQL($query)
    {
        return (int) $this->prepareAndExecute($query)->fetchColumn(0);
    }

    protected function prepareAndExecute($query)
    {
        $stmt = $GLOBALS['em']->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Executa o Remove
     * @param \BaseEmpds\Model\Interfaces\Entity $entity
     */
    protected function processRemove($oEntity)
    {
        $this->em->remove($oEntity);
        $this->em->flush();
    }

    /**
     * Cria um novo repositório
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function newRepository()
    {
        return $this->em->getRepository($this->getEntityName());
    }
    
    /**
     * Cria um novo QueryBuilder
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function newQueryBuilder()
    {
        return $this->newRepository()->createQueryBuilder('u');
    }

    /**
     * Cria uma nova query
     * @return \Doctrine\ORM\Query
     */
    protected function newQuery()
    {
        return $this->newQueryBuilder()->getQuery();
    }

    /**
     * Formata o retorno de um Query
     * @param \Doctrine\ORM\Query $query
     * @param boolean $toArray
     */
    protected function getResultQuery($query, $toArray = false)
    {
        return $toArray ? $query->getArrayResult() : $query->getResult();
    }

    /**
     * Retorna uma linha de registro, se não encontrar, um exception será disparado
     * @param \Doctrine\ORM\Query $query     
     */
    protected function getSingleResult($query)
    {
        return $query->getSingleResult();
    }

    /**
     * Formata o retorno de um Query
     * @param \Doctrine\ORM\Query $query
     * @param boolean $toArray
     */
    protected function getOneOrNullResult($query, $toArray = false)
    {
        return $toArray ? $query->getArrayResult() : $query->getOneOrNullResult();
    }

    /**
     * Retorna um registro de uma query SQL
     *
     * @param \Doctrine\ORM\Query $query
     * @return mixed
     */
    protected function getOneResultSQL($query)
	{
		return $this->prepareAndExecute($query)->fetch();	
	}

    /**
     * Realiza adição de join e cláusulas a query por ID
     * @param \Doctrine\ORM\QueryBuilder $builder
     */
    protected function changeQueryById($id, $builder)
    {
        $builder->where('u.id = ?1')->setParameter(1, $id);
    }

    /**
     * @inheritdoc
     */
    public function truncate()
    {

        $connection = $this->em->getConnection();
        $connection->beginTransaction();
        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0;');
            $connection->executeUpdate('TRUNCATE TABLE ' . $this->getClassName());
            $connection->query('SET FOREIGN_KEY_CHECKS=1;');
            $connection->commit();
            $this->em->flush();
        } catch (\Exception $e) {
            $connection->rollback();
            $e->getMessage();
        }
        return true;
    }

    /**
     * Carrega o caminho até a classe namespace + nome da classe
     * @return string
     */
    protected function loadEntityName()
    {
        return ENTITY_NAMESPACE . $this->getClassName();
    }

    /**
     * Retorna o nome da classe 
     * @return string
     */
    protected function getEntityName()
    {
        if (!isset($this->entity)) {
            $this->entity = $this->loadEntityName();
        }
        return $this->entity;
    }

    /**
     * Retorna o nome da entity a qual pertence o repository
     * @return string
     */
    private function getClassName()
    {
        $sNameClass = str_replace(REPOSITORY_NAMESPACE, '', '\\' . get_class($this));
        $sNameClass = str_replace('Repository', '', $sNameClass);
        return $sNameClass;
    }
}
