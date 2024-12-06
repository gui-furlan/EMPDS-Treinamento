<?php

namespace Treino\View\Menu;

use Treino\Model\Transactions;

/**
 * Classe para criação do menu do index
 */
class Index extends BaseMenu
{

    public function loadOptions()
    {
        $sUrlModule = $this->getUrlModule();
        $this->addOptionValues('Pessoa', $sUrlModule . '/Pessoa/index', 'fas fa-user', [Transactions::GESTOR_TREINO]);
        $this->addOptionValues('Equipe', $sUrlModule . '/Equipe/index', 'fas fa-users', [Transactions::GESTOR_TREINO]);
    }
}
