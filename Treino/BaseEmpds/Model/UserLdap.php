<?php

namespace BaseEmpds\Model;

use BaseEmpds\Model\UserDataSession;
use Geral\Model\ConnLdap;
use Exception;

/**
 * Classe para abstrair dados do usuário obtidos do LDAP
 */
class UserLdap
{

    const TIPO_PROFESSOR = 'professor';
    const TIPO_TECNICO   = 'servidor';
    const TIPO_ALUNO     = 'aluno';

    /**
     * @var array
     */
    private $data;

    /**
     * Define os dados
     */
    public function setData($aValores = [])
    {
        $this->data = $aValores;
    }

    /**
     * Carrega os dados de um CPF
     */
    public function loadData($sCpf = null)
    {
        if (!$sCpf) {
            $sCpf = UserDataSession::getCpf();
        }

        try {
            $oConexao   = new ConnLdap();
            $this->data = $oConexao->getUserNormalized($sCpf);
        } catch (Exception $oException) {
            //Se deu erro e for no ambiente deve
            if ($_SERVER['AMBIENTE'] == 'DEV') {
                //E for um dos dois CPFs de teste
                $this->data = [
                    'nome'  => 'ALUNO TESTE',
                    'cpf'   => $sCpf,
                    'tipo'  => '',
                    'email' => $sCpf . '@udesc.br'
                ];
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * Retorna o nome do usuário
     * @return string
     */
    public function getNome()
    {
        return $this->getData('nome');
    }

    /**
     * Retorna o cpf do usuário
     * @return string
     */
    public function getCpf()
    {
        return $this->getData('cpf');
    }

    /**
     * Retorna o tipo do usuário
     * @return string
     */
    public function getTipo()
    {
        return $this->getData('tipo');
    }

    /**
     * Retorna a situação do usuário
     * @return string
     */
    public function getSituacao()
    {
        return $this->getData('situacao');
    }

    /**
     * Retorna a lotação do usuário
     * @return string
     */
    public function getLotacao()
    {
        return $this->getData('lotacao');
    }

    /**
     * Retorna o centro do usuário
     * @return string
     */
    public function getCentro()
    {
        return $this->getData('centro');
    }

    /**
     * Retorna o setor do usuário
     * @return string
     */
    public function getSetor()
    {
        return $this->getData('setor');
    }

    /**
     * Retorna o vínculo do usuário
     * @return string
     */
    public function getVinculo()
    {
        return $this->getData('vinculo');
    }

    /**
     * Retorna a função do usuário
     * @return string
     */
    public function getFuncao()
    {
        return $this->getData('funcao');
    }

    /**
     * Retorna a escolaridade do usuário
     * @return string
     */
    public function getEscolaridade()
    {
        return $this->getData('escolaridade');
    }

    /**
     * Retorna o e-mail do usuário
     * @return string
     */
    public function getEmail()
    {
        return $this->getData('email');
    }

    /**
     * Retorna o telefone comercial do usuário
     * @return string
     */
    public function getTelefoneComercial()
    {
        return $this->getData('telefoneComercial');
    }

    /**
     * Retorna o celular do usuário
     * @return string
     */
    public function getCelular()
    {
        return $this->getData('cpf');
    }

    /**
     * Retorna o telefone residencial do usuário
     * @return string
     */
    public function getTelefoneResidencial()
    {
        return $this->getData('telefoneResidencial');
    }

    /**
     * Retorna o base64 da imagem
     * @return string
     */
    public function getFoto()
    {
        return $this->getData('foto');
    }

    /**
     * Retorna se é professor
     * @return boolean
     */
    public function isProfessor()
    {
        return strtolower($this->getTipo()) === self::TIPO_PROFESSOR;
    }

    /**
     * Retorna se é um aluno
     */
    public function isAluno()
    {
        return strtolower($this->getTipo()) === strtolower(self::TIPO_ALUNO);
    }

    /**
     * Retorna se é um técnico
     */
    public function isTecnico()
    {
        return strtolower($this->getTipo()) === strtolower(self::TIPO_TECNICO);
    }

    /**
     * Retorna um dado se estiver disponível
     * @return mixed
     */
    private function getData($sChave, $xDefault = null)
    {
        return isset($this->data[$sChave]) ? $this->data[$sChave] : $xDefault;
    }
}
