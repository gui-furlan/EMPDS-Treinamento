<?php

namespace Treino\View\Menu;

abstract class BaseMenu
{

    /**
     * @var \Geral\Model\Url
     */
    protected $url;

    /**
     * @var array
     */
    protected $options = [];

    public function __construct()
    {
        $this->url = $GLOBALS['url'];
    }

    /**
     * Retorna a URL do módulo acessado
     */
    protected function getUrlModule()
    {
        return $this->url->getUrlModule();
    }

    /**
     * Adiciona uma opção de menu
     */
    protected function addOption(array $option)
    {
        $this->options[] = $option;
    }

    /**
     * Adiciopna uma opção de menu pelo parâmetros
     */
    protected function addOptionValues($descricao, $url, $icon, $transaction = [])
    {
        $this->addOption([
            'descricao'    => $descricao,
            'url'          => $url,
            'fontawesome'  => $icon,
            'transactions' => $transaction
        ]);
    }

    /**
     * Retorna as opções
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Carrega as opções
     */
    public abstract function loadOptions();
}
