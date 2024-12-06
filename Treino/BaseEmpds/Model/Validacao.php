<?php

namespace BaseEmpds\Model;

/**
 * Classe para validação e processamento de campos
 */
abstract class Validacao
{

    /**
     * Valida campos obrigatórios
     * @param $aArr    = array composto dos campos a serem validados 
     * @param $aIgnora = array dos campos a serem ignorados
     */
    public static function isCamposObrigatoriosValidos($aArr, $aIgnora = [])
    {
        foreach ($aArr as $sNome => $xValor) {
            if (in_array($sNome, $aIgnora)) {
                continue;
            }
            if (is_object($xValor)) {
                continue;
            }
            if (empty($xValor)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Retorna se os campos para um objeto são válidos
     * @return boolean
     */
    public static function isObjectFieldValid($object, array $fields)
    {
        foreach ($fields as $field) {
            $method = 'get' . ucfirst($field);
            $value  = call_user_func_array([$object, $method], []);
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validar o e-mail
     * @param $email do usuário
     * @return string
     */
    public static function isEmailValido($sEmail)
    {
        return filter_var($sEmail, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Limpa caracteres especiais deixando apenas letras e números.
     * /[^[:alnum:]_]/ eh uma expressão regular eh equivalente a [a-zA-Z0-9], 
     * remove caracteres especiais
     * 
     * @param $sTxt = string a ser filtrada
     * @return string
     */
    public static function getParametroFiltrado($sTxt)
    {
        return preg_replace('/[^[:alnum:]_]/', '', $sTxt);
    }
    /**
     * Captura o cnpj passado, e aplica o método de validação de cnpj
     * @param string $cnpj
     * @return bool
     */
    public static function isCnpjValid($sCnpj)
    {
        $cnpj = preg_replace('/[^0-9]/is', '', $sCnpj);
        if (strlen($cnpj) != 14) {
            return false;
        }
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }
        for ($t = 12; $t < 14; $t++) {
            for ($d = 0, $m = ($t - 7), $i = 0; $i < $t; $i++) {
                $d += $cnpj[$i] * $m;
                $m = ($m == 2 ? 9 : --$m);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cnpj[$i] != $d) {
                return false;
            }
        }
        return true;
    }
    /**
    * Captura o telefone informado, retira tudo o que não é número, e verfica se o tamanho
    * é igual a 11(celular) ou 10(fixo)
    * @return bool
    */
    public static function isPhoneValid($phone)
    {
        $phoneCleaned = preg_replace('/[^0-9]/is', '', $phone);
        if (strlen($phoneCleaned) == 11 || strlen($phoneCleaned) == 10) {
            return true;
        }
        return false;
    }

    /** Recebe uma variável e transforma ela em um boolean */
    public static function formatStringToBoolean($xVar){
        return filter_var($xVar, FILTER_VALIDATE_BOOLEAN);  
    }
}
