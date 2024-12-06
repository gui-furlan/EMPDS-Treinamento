<?php

namespace BaseEmpds\Model\Interfaces;

/**
 * @author Andrew
 * @since  04/08/2020
 */
interface EntityArrayLoader
{
    /**
     * Cria entidade a partir do json
     * @param array $data
     */
    public static function fromArray(array $data);
}
