<?php

namespace BaseEmpds\Test;

/**
 * @author Glauco
 * @since  03/09/2020
 * @version 2.0 25/02/2021 Gustavo Santos  
 */
abstract class TestConfig
{

    /**
     * @var array
     */
    private $testConfig = [];

    /**
     * @var string
     */
    private $baseRoute;

    public function __construct()
    {
        $this->baseRoute = $GLOBALS['url']->getUrlModule();
        $this->loadApiTests();
    }

    /**
     * Carrega os testes
     */
    abstract public function loadApiTests();

    /**
     * Configura as requisições ao backend para testes.
     * @param string $method Método da requisição (GET, POST, etc.).
     * @param array $config
     */
    protected function setTestConfig($method, $config)
    {
        $this->testConfig[$method] = $config;
    }

    /**
     * Construi o teste
     * @param string $method método do test GET ou POST
     * @param string $route rota que será testada
     * @param array  $data dados do corpo da requisição
     * @param array  $dataAttrToUrl dados enviados como param route
     */
    private function buildTest($method, $route, $data = [], $dataAttrToUrl = [])
    {
        $routeTest = $this->baseRoute . $route;

        $data = $data != null ? $data : [];
        $dataAttrToUrl = $dataAttrToUrl != null ? $dataAttrToUrl : [];

        $data = array_merge($data, $dataAttrToUrl);

        $config =  [
            'data' => $this->buildDataOfTest($data),
            'dataAttrToUrl' => $dataAttrToUrl != null ? [$dataAttrToUrl] : []
        ];

        $this->testConfig[$method][$routeTest] = $config;
    }

    /**
     * Construi um teste do método GET
     * @param string $route rota que será testada
     * @param array  $data dados do corpo da requisição
     * @param array  $dataAttrToUrl dados enviados como param route
     */
    public function buildGetTest($route, $data = [], $dataAttrToUrl = [])
    {
        return $this->buildTest("GET", $route, $data, $dataAttrToUrl);
    }

    /**
     * Construi um teste do método POST
     * @param string $route rota que será testada
     * @param array  $data dados do corpo da requisição
     * @param array  $dataAttrToUrl dados enviados como param route
     */
    public function buildPostTest($route, $data = [], $dataAttrToUrl = [])
    {
        return $this->buildTest("POST", $route, $data, $dataAttrToUrl);
    }

    /**
     * Retorna os testes
     * @return array
     */
    public function getTestConfig($method = null)
    {
        return !empty($method) ? $this->testConfig[$method] : $this->testConfig;
    }

    private function buildDataOfTest($data)
    {
        if (sizeof($data) == 0) {
            return '{}';
        }

        $dataJson = [];

        foreach ($data as $t) {
            $dataJson[$t] = '';
        }
        return json_encode($dataJson);
    }
}
