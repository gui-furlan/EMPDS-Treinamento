<?php

namespace BaseEmpds\Model\Interfaces;


/**
 * @author Gustavo Santos
 * @since  14/03/2021
 */
interface EntitySeeder
{
    /**
     * Retornar os dados que serão gerados em ambiente DEV
     * @return array
     */
    public function seedsOfDev();

    /**
     * Retornar os dados que serão gerados em ambiente HOM
     * @return array
     */
    public function seedsOfHom();

    /**
     * Retornar os dados que serão gerados em ambiente PROD
     * @return array
     */
    public function seedsOfProd();

    /**
     * Executa a operação de persistência no banco de dados
     * @return array
     */
    public function seeds();

    /**
     * Retornar os dados que serão gerados descordo com o ambiente que aplicação se encontra
     * @return array
     */
    public function loadSeedsOfEnvironment();

    /**
     * Realiza o Truncate na tabela da entidade
     * @return boolean numero de valores removidos
     */
    public function truncate();
}
