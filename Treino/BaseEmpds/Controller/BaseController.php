<?php

namespace BaseEmpds\Controller;

use Geral\Model\Factory\LogFactory;
use Geral\Model\SystemMessages;
use Geral\Controller\AbstractPrivateController;

use BaseEmpds\Model\Interfaces\EntityController;
use BaseEmpds\Model\BaseFactory;
use BaseEmpds\Model\Bean;
use BaseEmpds\Model\Validator\Validator;

use BaseEmpds\Model\Exception\ErrorException;
use BaseEmpds\Model\AppContext;


abstract class BaseController extends AbstractPrivateController implements EntityController
{

    /**
     * @var \BaseEmpds\Model\Interfaces\EntityRepository
     */
    protected $repository;

    /**
     * @var \BaseEmpds\Model\Interfaces\EntityValidatorInterface
     */
    protected $validator;

    /**
     * @var \BaseEmpds\Model\Interfaces\Entity
     */
    protected $entity;

    public final function __construct()
    {
        parent::__construct();
        $this->afterConstruct();
        $this->authCheck();
    }

    /**
     * Evento disparado após o construtor (Construtor é final para que sempre seja acionado o método authCheck)
     */
    protected function afterConstruct()
    {
    }

    public function index()
    {
        $this->prepareView();
        $this->view();
    }

    public function form()
    {
        $this->loadDataToView();
        $this->prepareView();
        $this->view();
    }

    protected function addCustomTransaction(array $customTransactions)
    {
        $this->addVarView('customTransactions', $customTransactions);
    }

    protected function loadDataToView()
    {
        $iId = $this->url->getSegment(4);
        if (!empty($iId)) {
            $this->entity = $this->getRepository()->getById($iId, false);
            if ($this->entity) {
                $this->addVarView('data', $this->getResponseData());
            } else {
                $this->setError('Este registro não está mais disponível para edição');

                $this->sendResponse();
            }
        }
    }

    public function getAll()
    {
        $aRegistros = $this->getRepository()->getAll(true);
        $this->setSuccess('Dados localizados com sucesso!', ["data" => $aRegistros]);
        $this->sendResponse();
    }

    public function getById()
    {
        $sId = $this->url->getSegment(4);
        if (empty($sId)) {
            $this->setError('Não foi informado um ID!');
            $this->sendResponse();
        }
        $this->entity = $this->getRepository()->getById($sId, false);
        $this->setSuccess('Registro encontrado com sucesso.', $this->getResponseData());
        $this->sendResponse();
    }

    /**
     * Função para salvar uma entity
     */
    public function save()
    {
        //Carrega os dados
        $this->loadEntity();
        //Formata os datas obtidos
        $this->formatDataPersist($this->getEntity());
        //Formata dados inserção
        $this->formatDataPersistSave();
        //Realiza a validação dos dados
        $this->validate();
        //Inicia a transação
        $this->beginTransaction();
        try {
            //Adiciona o registro
            $this->processAdd();
            //Efetiva a transação
            $this->commitTransaction();
        } catch (\Exception $e) {
            //Cancela a transação
            $this->rollbackTransaction();
            $this->catchException('Ocorreu um erro ao salvar os dados.', $e);
        }
        $this->sendResponse();
    }

    /**
     * Função para atualizar uma entity
     */
    public function update()
    {
        //Carrega os dados
        $this->loadEntity(true);
        //Formata os datas obtidos
        $this->formatDataPersist($this->getEntity());
        //Formata dados alteração
        $this->formatDataPersistUpdate();
        //Realiza a validação dos dados
        $this->validate();
        //Inicia a transação
        $this->beginTransaction();
        try {

            $this->processUpdate();
            //Efetiva a transação
            $this->commitTransaction();
        } catch (\Exception $e) {
            //Cancela a transação
            $this->rollbackTransaction();
            $this->catchException('Ocorreu um erro ao alterar os dados.', $e);
        }
        $this->sendResponse();
    }

    /**
     * Função para remover uma entity
     */
    public function remove()
    {
        $iId = $this->url->getSegment(4);
        if (empty($iId)) {
            $this->setError('Nenhum ID foi informado.');
            $this->sendResponse();
        }
        $this->entity = $this->getRepository()->getById($iId, false);
        if (!$this->entity) {
            $this->setError('O registro não foi encontrado.');
            $this->sendResponse();
        }

        //Inicia a transação
        $this->beginTransaction();
        try {
            $this->processRemove();
            //Efetiva a transação
            $this->commitTransaction();
        } catch (\Exception $e) {
            //Cancela a transação
            $this->rollbackTransaction();
            $this->catchException('Ocorreu um erro ao excluir os dados.', $e);
        }
        $this->sendResponse();
    }

    /** 
     * Validação 
     */
    protected function validate($entity = null)
    {
        if (!$entity) {
            //Caso não tenha sido repassada uma entidade, busca a atual
            $entity = $this->getEntity();
        }
        $validator = $this->getValidator();
        $validator->setEntity($entity);
        if ($validator && !$validator->isValid()) {
            $this->setError(implode(' ', $validator->getMessages()));
            $this->sendResponse();
        }
    }

    /**
     * Realiza a inserção
     */
    protected function processAdd()
    {
        $this->getRepository()->add($this->getEntity());
        $this->setSuccess('Cadastro realizado com sucesso!', $this->getResponseData([
            'operation' => 'add'
        ]));
    }

    /**
     * Realiza a alteração
     */
    protected function processUpdate()
    {
        $this->getRepository()->update($this->getEntity());
        $this->setSuccess('A alteração foi realizada com sucesso!', $this->getResponseData([
            'operation' => 'update'
        ]));
    }

    /**
     * Realiza a remoção
     */
    protected function processRemove()
    {
        $this->getRepository()->remove($this->getEntity());
        $this->setSuccess('Exclusão realizada com sucesso!', [
            'operation' => 'remove'
        ]);
    }

    /**
     * Aplica uma validação diretamente nos dados vindos da request
     *
     * @param array $rules
     * @param array $messages
     * @param mixed $data
     * @return void
     */
    protected function applyValidator($rules, $messages = [], $data = null)
    {
        $validator = new Validator(($data) ? $data : $this->request->getAll(), $rules, $messages);
        if ($validator->fails()) {
            $messages = [];
            foreach ($validator->getErrors() as $attribute => $errors) {
                $messages = array_merge($messages, $errors);
            }
            $this->setError(implode(' ', $messages));
            $this->sendResponse();
        }
    }

    /**
     * Retorna os dados para serialização
     * @return \BaseEmpds\Model\Interfaces\Entity
     */
    protected function getResponseData($data = [])
    {
        $entity = $this->getEntity();
        if ($entity instanceof \JsonSerializable) {
            $data["registro"] = $entity;
        }
        return $data;
    }

    /**
     *  Retorna o caminho completo até a classe filha
     * @return \BaseEmpds\Model\Interfaces\Entity
     */
    protected function getInstanceEntity()
    {
        return BaseFactory::getEntity($this->getClassName());
    }

    /**
     *  Retorna a classe da entidade
     *  @return \BaseEmpds\Model\Interfaces\Entity
     */
    protected function getEntity()
    {
        if (!isset($this->entity)) {
            $this->entity = $this->getInstanceEntity();
        }
        return $this->entity;
    }

    /**
     * Função que recebe os dados da entity a ser inserida na base de dados
     * @return \BaseEmpds\Model\Interfaces\Entity
     */
    protected function loadEntity($update = false)
    {
        //Carrega os dados da requisição
        $data = $this->getAllBodyParams();
        if ($update && isset($data['id']) && is_numeric($data['id'])) {
            //Se foi repassado um Id, carrega a entidade com todos os dados
            $this->entity = $this->getRepository()->getById($data['id']);
            if (is_null($this->entity)) {
                $this->setError('Não foi encontrado o registro selecionado.');
                $this->sendResponse();
            }
        } else {
            //Cria uma instância da entidade
            $this->entity = BaseFactory::getEntity($this->getClassName());
        }
        //Carrega automaticamente os dados
        $this->beanToEntity($data);
        return $this->entity;
    }

    /**
     * Carrega os dados automaticamente
     */
    protected function beanToEntity($data)
    {
        Bean::loadEntity($this->entity, $data, $this->getLoadEntityDataException());
    }

    /**
     * Retorna uma instaria do repositório da entidade
     * @return \BaseEmpds\Model\Interfaces\EntityRepository
     */
    protected function getInstanceRepository()
    {
        return BaseFactory::getRepository($this->getClassName());
    }

    /**
     * Retorna a instância do repositório
     * @return \BaseEmpds\Model\Repository\BaseRepository
     */
    protected function getRepository()
    {
        if (!isset($this->repository)) {
            $this->repository = $this->getInstanceRepository();
        }
        return $this->repository;
    }

    /**
     *  Retorna o validator instânciado da classe filha
     *  @return \BaseEmpds\Model\Interfaces\EntityValidatorInterface
     */
    protected function getInstanceValidator()
    {
        return BaseFactory::getValidator($this->getClassName());
    }

    /**
     * Retorna a instância do repositório
     * @return \BaseEmpds\Model\Interfaces\EntityValidatorInterface;
     */
    protected function getValidator()
    {
        if (!isset($this->validator)) {
            $this->validator = $this->getInstanceValidator();
        }
        return $this->validator;
    }

    /**
     * Retorna o nome da classe com base no nome da classe atual
     * @return string
     */
    protected function getClassName()
    {
        /*
        get_class retorna um string com o caminho completo onde se encontra a classe,
        essa string é dividida, então pega-se apenas o nome da classe que importa para nós.
        */
        return str_replace('Controller', '', str_replace(CONTROLLER_NAMESPACE, '', '\\' . get_class($this)));
    }

    /**
     * Formata os dados da entidade antes de persistir
     * @param \BaseEmpds\Model\Interfaces\Entity $entity
     */
    protected function formatDataPersist($entity)
    {
    }

    /**
     * Formata os dados da entidade antes de salvar
     */
    protected function formatDataPersistSave()
    {
    }

    /**
     * Formata os dados da entidade antes de alterar
     */
    protected function formatDataPersistUpdate()
    {
    }

    /** Prepara o index e o form antes de chamar a view */
    protected function prepareView()
    {
    }

    /** Define o nome dos campos que não devem ser carregados automaticamente para a entity */
    protected function getLoadEntityDataException()
    {
        return [];
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
     * retorna true ou false dependendo se o ambiente em que ele está sendo chamado é o de developer 
     * @return bool
     */
    public function isDev()
    {
        return $_SERVER['AMBIENTE'] == 'DEV';
    }

    /**
     * @inheritDoc
     */
    protected function setError($msg, $data = [])
    {
        try {
            SystemMessages::addExtraFields($data);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
        }

        SystemMessages::setResultStatus(SystemMessages::RESULT_ERROR_STATUS);

        new ErrorException($msg);
    }

    /**
     * Realiza tratativa em exceptions ocorridos
     * @param string $baseMessage
     * @param \Exception $e
     */
    protected function catchException($baseMessage, $e)
    {
        $message = '';
        if ($e instanceof \Doctrine\DBAL\Exception\ServerException) {
            $nameSpace = '\\BaseEmpds\\Model\\Exception\\';
            $class     = substr(strrchr(get_class($e), "\\"), 1);
            $className = $nameSpace . $class;
            if (class_exists($className)) {
                $instance = new $className($e);
                $message  = $instance->getMessage();
            }
        }
        if ($this->isDev()) {
            $message .= ' -> ' . $e->getMessage();
        } else {
            //Quando não for, registra em banco os dados extras, para que seja possível verificar.
            $exceptionMessage = $e->getMessage();
            if ($exceptionMessage) {
                LogFactory::error($baseMessage, $message . ' -> ' . $e->getMessage());
            }
        }
        if ($message) {
            $baseMessage = trim($baseMessage) . ' Detalhes: ' . $message;
        }
        $this->setError(substr($baseMessage, 0, 254));
    }

    /**
     * Realiza verificações de permissão
     */
    protected function authCheck()
    {
        $aTransactions = $this->auth->getAllowedTransactions();
        if (!isset($aTransactions)) {
            $this->setError('Usuário sem permissão para acessar este módulo.');
            $this->sendResponse();
        }
    }

    /** Retorna todos os campos enviados pelo usuário 
     *  @return []
     */
    protected function getAllBodyParams()
    {
        return $this->request->getAllBodyParams();
    }
}
