<?php

namespace BaseEmpds\Model;

use DateTime;

/**
 * @author Rodrigo
 * @since  11/09/2020
 */
abstract class DateUtils
{

    /**
     * Verifica se a diferença entre as datas é igual ou maior que a quantidade de dias passados. Caso o intervalo das datas for maior ou igual
     * a quantidade de dias informadas é retornado True, caso contrário retorna False.
     */
    public static function verificaDiferencaEntreData($dDataIni, $dDataFim, $iDias)
    {
        return (($dDataIni->diff($dDataFim)) >= $iDias);
    }

    /**
     * Verifica se a data de inicio é menor que a data de fim
     * @param Obj Date
     */
    public static function isDataInicioMenorDataFim($dDataIni, $dDataFim)
    {
        return ($dDataIni->getTimestamp() < $dDataFim->getTimestamp());
    }

    /**
     * Retorna se uma data atual (hoje) está dentro de um período de datas
     * @param $dDataIni Date
     * @param $dDataFinal Date
     */
    public static function isDataPeriodo($dDataIni, $dDataFinal)
    {
        //Retornar a data de hoje
        $date      = new DateTime('today');
        $dataAtual = $date->getTimestamp();
        return ($dataAtual >= $dDataIni->getTimestamp() && $dataAtual <= $dDataFinal->getTimestamp());
    }

    /** */
    /**
     * Retorna se a data é passada
     * @param $dDataIni Date
     * @param $dDataFinal Date
     */
    public static function isDataPassada($dDataIni, $dDataFinal)
    {
        $date = new DateTime('today');
        $dataAtual = $date->getTimestamp();
        if ($dDataIni->getTimestamp() <= $dataAtual || $dDataFinal->getTimestamp() < $dataAtual) {
            return false;
        }
        return true;
    }

    /**
     * Retorna se a data está dentro do limite
     * @param $dDataIni Date
     * @param $dDataFinal Date
     */
    public static function isDataDentroDoLimite($dDataIni, $dDataFinal)
    {
        $limite = strtotime('2100-01-01');
        if ($dDataIni->getTimestamp() > $limite || $dDataFinal->getTimestamp() > $limite) {
            return false;
        }
        return true;
    }
}
