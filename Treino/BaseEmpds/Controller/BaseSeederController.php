<?php

namespace BaseEmpds\Controller;

use BaseEmpds\Model\BaseFactory;
use BaseEmpds\Model\BaseSeeder;
use Geral\Controller\AbstractPrivateController;
use Geral\Model\Config;

/**
 * @author Glauco David Laicht
 * @since  14/03/2021
 */
class BaseSeederController extends AbstractPrivateController{

    /**
     * @var array
     */
    private $seedConfig;

    /**
     * @var BaseSeeder
     */
    protected $seed;

    function __construct() {
        parent::__construct();
        $this->authCheck();
    }

    public function index() {
        $this->seedConfig = [];
        /**  @var array */
        $classFiles       = Config::getAllEntities()[DEFAULT_APP];
        foreach ($classFiles as $className) {
            // Obtém o nome da entity
            $seedName = str_replace(str_replace('\\', '/', ENTITY_NAMESPACE), '', $className);
            // Verifica se essa tem Seeds
            $clazz    = SEEDER_NAMESPACE . $seedName . 'Seeder';
            if (class_exists($clazz)) {
                $this->seedConfig[] = $seedName;
            }
        }
        $this->addVarView('seeders', $this->seedConfig);
        $this->view();
    }

    public function loadSeeder() {
        $seedName = $this->request->get('seederEntity');
        $data     = $this->getSeeder()->loadSeedsOfEnvironment();
        $this->setSuccess('Seeds da ' . $seedName, ['data' => $data]);
        $this->sendResponse();
    }

    public function seed() {
        $data = $this->getSeeder()->seeds();
        $this->setSuccess('Seeder rodado com sucesso', ['data' => $data]);
        $this->sendResponse();
    }

    public function truncate() {
        $data = $this->getSeeder()->truncate();
        $this->setSuccess('Truncate rodado com sucesso', ['data' => $data]);
        $this->sendResponse();
    }

    private function getSeeder() {
        if (!isset($this->seed)) {
            $seedName   = $this->request->get('seederEntity');
            if (!$seedName) {
                $this->setError('Não foi informado o nome da seed');
                $this->sendResponse();
            }

            $this->seed = BaseFactory::getSeeder($seedName);
        }
        return $this->seed;
    }

    private function authCheck() {
        if (!$this->auth->isAllowedTransactions(['admin', 'desenvolvedor'])) {
            $this->setError('Usuário sem permissão para esta ação.');
            $this->sendResponse();
        }
    }
}