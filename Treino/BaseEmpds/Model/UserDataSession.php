<?php

namespace BaseEmpds\Model;

use Geral\Model\UserSession;

/**
 * Classe referente a dados do usuário na sessão
 * 
 * Dados atualmente disponibilizados pelo framework $_SESSION['usuario'] = [ 'id', 'cpf', 'perfil', 'nome', 'logado']
 * @author Glauco David Laicht
 * @since 31/03/2020
 * @Model
 */
abstract class UserDataSession
{

    /**
     * Retorna o ID do usuário no Framework
     * @return string
     */
    public static function getIdFramework()
    {
        return self::getDataUsuario('id');
    }

    /**
     * Retorna o CPF do usuário
     * @return string
     */
    public static function getCpf()
    {
        return self::getDataUsuario('cpf');
    }

    /**
     * Retorna o perfil do usuário
     * @return string
     */
    public static function getPerfil()
    {
        return self::getDataUsuario('perfil');
    }

    /**
     * Retorna o nome do usuário
     * @return string
     */
    public static function getNome()
    {
        return self::getDataUsuario('nome');
    }

    /**
     * Retorna um dado do usuário na sessão, pelo nome da chave
     */
    public static function getDataUsuario($sChave, $xDefault = null)
    {
        if(!UserSession::paramExists($sChave)){
            return $xDefault;
        }
        
        $xData = UserSession::getParam($sChave);
        if (!$xData) {
            return $xDefault;
        }
        return $xData;
    }

    /**
     * Adiciona dados para a sessão do usuário
     * @param $aValores array Array de valores a serem adicionados a sessão do usuário
     */
    public static function setDataUsuario(array $aValores)
    {
        foreach ($aValores as $sChave => $xValor) {
            UserSession::setParam($sChave, $xValor);
        }
    }
    
    /**
     * Adiciona um único dado para a sessão do usuário
     * @param string $sChave 
     * @param $xValor 
     */
    public static function setSingleDataUsuario(String $sChave, $xValor)
    {
        UserSession::setParam($sChave, $xValor);
    }
}
