<?php

namespace Treino\Controller\Traits;

use BaseEmpds\Model\BaseFactory;

trait FormatPessoaHelper
{
    /**
     * Recupera o valor parâmetro e busca uma Pessoa a partir disso
     * @return object
     */
    protected function getPessoaFormated($pessoa)
    {
        if (is_scalar($pessoa)) {
            /** @var \Votacoes\Model\Repository\PessoaRepository $pessoaRepository  */
            $pessoaRepository = BaseFactory::getRepository('Pessoa');
            return $pessoaRepository->getById($pessoa);
        }

        return $pessoa;
    }
}
