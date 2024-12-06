<?php

namespace Treino\Model;

/**
 * Classe que cria constante para os tipos de transactions do sistema
 */
abstract class Transactions
{

    const ADMIN              = 'admin';
    const DESENVOLVEDOR      = 'desenvolvedor';
    const ADMIN_USERS        = 'adminUsers';
    const GESTOR_TREINO      = 'gestor';

    /**
     * Adiciona as transações padrões do sistema
     */
    public static function loadTransactions(&$transactions)
    {
        //Coordenador
        $transactions[self::GESTOR_TREINO] = [
            'titulo'    => 'Gestor (TREINO)',
            'descricao' => 'Permite realizar todos os cadastros e o gestão do sistema'
        ];
    }
}
