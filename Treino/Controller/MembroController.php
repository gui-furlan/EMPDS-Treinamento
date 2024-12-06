<?php 

namespace Treino\Controller;

use BaseEmpds\Controller\BaseController;
use BaseEmpds\Model\BaseFactory;
use Treino\Model\Repository\MembroRepository;
use BaseEmpds\Model\Repository\BaseRepository;

class MembroController extends BaseController
{
    // Adicionar um membro em uma equipe via form
    public function form(){
        $idEquipe = $this->request->input("equipe");
        
        if(is_scalar($idEquipe)){
            $oEquipe= BaseFactory::getEntityById("Equipe", $idEquipe);
        
            $this->addVarView("equipe", $oEquipe);
        }else{
            $this->setError("Classe {$idEquipe} não foi encontrada");
            $this->sendResponse();
        }
        parent::form();
    }
    // index da chamada

    public function index(){
        $idEquipe = $this->request->input("equipe");
        if(empty($idEquipe)&& !is_numeric($idEquipe)){
            $this->setError("Id informado é inexistente ou não foi informado");
            $this->sendResponse();
        }
        $this->addVarView("idEquipe", $idEquipe);
        parent::index();
    }
    public function getMembroByEquipeId()
    {

        /**
         * @var MembroRepository $membroRepository
         */
        $membroRepository= BaseFactory::getRepository("Membro");
        $idEquipe= $this->request->input("equipe");
        if (!empty($idEquipe)&& is_scalar($idEquipe)) {
            $aRegistros = $membroRepository->getAllMembrosByEquipe($idEquipe);
            $this->setSuccess('membros encontrados',['data'=> $aRegistros]);

        }else{
            $this-> setError("Inserir id Válido");
        }
        $this->sendResponse();
    }
}