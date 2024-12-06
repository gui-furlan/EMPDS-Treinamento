<?php

namespace Treino\Controller;

use Geral\Controller\AbstractTestController;
use Geral\Model\Config;

class TestApiController extends AbstractTestController
{
    private $testConfig = [];

    public function index()
    {
        /**
         * @var array
         */
        $classFiles = Config::getAllEntities()['Treino'];

        foreach ($classFiles as $className) {
            // Obtém o nome da entity
            $testName = str_replace(str_replace('\\', '/', ENTITY_NAMESPACE), '', $className);
            // Verifica se essa tem tests
            $clazz  = TEST_NAMESPACE . 'Test' . $testName . 'Controller';
            if (class_exists($clazz)) {
                $this->testConfig[] = $testName;
            }
        }

        $this->addVarView('testes', $this->testConfig);
        $this->view();
    }

    public function test()
    {
        $name = $this->request->get('name');
        $clazz  = TEST_NAMESPACE . 'Test' . $name . 'Controller';

        if (!class_exists($clazz)) {
            $this->setError('Não existe arquivo de teste para o nome repassado. ' . $clazz);
            $this->sendResponse();
        }

        $test = new $clazz();
        if ($test instanceof  \BaseEmpds\Test\TestConfig) {
            $this->addVarView('testConfig', $test->getTestConfig());
        }
        $this->addVarView('controller', $name);
        $this->url->setNameController('Test');
        $this->url->setNameModule('Geral');

        $this->view('index');
    }
}
