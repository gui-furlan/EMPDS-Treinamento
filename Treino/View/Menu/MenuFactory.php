<?php

namespace Treino\View\Menu;

use Treino\Model\Transactions;

/**
 * Classe para criação do menu lateral
 */
class MenuFactory
{
    const MENU_OPTIONS = [
        'Index'
    ];

    const MENU_CLONE = [
        //'NOVO_MENU' => 'MENU_A_CLONAR'
    ];

    public function loadOptions()
    {
        //Carrega opções
        $options = [];
        $sControllerName = $GLOBALS['url']->getNameController();
        $sUrlModule      = $GLOBALS['url']->getUrlModule();
        foreach (self::MENU_OPTIONS as $menuOption) {
            // Obtém o nome da entity
            $clazz = '\\' . ROOT_NAMESPACE  . '\\' . 'View\\' . 'Menu\\' . $menuOption;
            if (class_exists($clazz)) {
                /** @var \Bolsistas\Model\Menu\BaseMenu */
                $oClass = new $clazz();
                $oClass->loadOptions();

                $options[$menuOption] = $oClass->getOptions();
            }
        }
        //Adiciona um Home
        if (!array_key_exists($sControllerName, $options)) {
            $options[$sControllerName][] = $this->getOptionFormated('Home', $sUrlModule . '/Index/index', 'home');
        }
        //Adiciona opções do desenvolvedor
        if ($_SERVER['AMBIENTE'] == 'DEV') {
            $devOptions = $this->getDevOptions();
            if ($sControllerName == 'Index') {
                foreach ($devOptions as $devOption) {
                    $options[$sControllerName][] = $devOption;
                }
            } else {
                $aDevOptions = $this->getOptionFormated('Desenvolvedor', '', 'knight', [Transactions::DESENVOLVEDOR]);
                $aDevOptions['links'] = $devOptions;
                $options[$sControllerName][] = $aDevOptions;
            }
        }
        //Carrega clone
        foreach (self::MENU_CLONE as $menuOption => $menuClone) {
            $options[$menuOption] = $options[$menuClone];
        }
        return $options;
    }

    private function getDevOptions()
    {
        $sUrlModule  = $GLOBALS['url']->getUrlModule();
        $aDevOptions = [];
        $aDevOptions[] = $this->getOptionFormated('Seeder', $sUrlModule . '/Seeder', 'grain', [Transactions::DESENVOLVEDOR]);
        $aDevOptions[] = $this->getOptionFormated('Testes Api', $sUrlModule . '/TestApi', 'signal', [Transactions::DESENVOLVEDOR]);
        $aDevOptions[] = $this->getOptionFormated('Admin', '/Geral/Admin', 'console', [Transactions::DESENVOLVEDOR]);
        $aDevOptions[] = $this->getOptionFormated('Entidades', '/Geral/Admin/adminEntities', 'floppy-disk', [Transactions::DESENVOLVEDOR]);
        $aDevOptions[] = $this->getOptionFormated('Consultas SQL', '/Geral/DbAdmin/sqlQueryBuilder', 'transfer', [Transactions::DESENVOLVEDOR]);
        $aDevOptions[] = $this->getOptionFormated('Update', '/Geral/Update/check', 'off', [Transactions::DESENVOLVEDOR]);

        return $aDevOptions;
    }

    private function getOptionFormated($descricao, $url, $icon, $transaction = [])
    {
        return [
            'descricao'    => $descricao,
            'url'          => $url,
            'glyphicon'    => $icon,
            'transactions' => $transaction
        ];
    }
}
