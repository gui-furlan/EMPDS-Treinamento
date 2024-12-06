<?php

namespace BaseEmpds\Controller\Traits;

use BaseEmpds\Model\BaseFactory;
use BaseEmpds\Model\File\FileDownload;
use BaseEmpds\Model\Service\Traits\BaseFileService;

/**
 * Trait para adicionar funções de adição de arquivo
 * @author Glauco David Laicht
 */
trait FileDownloadController{

  use BaseFileService;

  /**
   * @var \BaseEmpds\Model\File\FileDownload
   */
  private $fileDownload;

  /**
   * Instancia um FileDownload
   *
   * @return \BaseEmpds\Model\File\FileDownload
   */
  protected function getFileDownload(){
    if(!isset($this->fileDownload)){
      $this->fileDownload = new FileDownload();
    }
    return $this->fileDownload;
  }

  /**
   * Realiza a busca do arquivo e o download do mesmo através da Hash
   *  
   * @return void
   */
  public function downloadFiles(){
    //Pega o hash através da request do front
    $hash = $this->request->input('arquivo');
    //Verifique se o hash veio
    if(empty($hash)){
      $this->setError('Não foi repassado um id de arquivo.');
      $this->sendResponse();
    }
    
    /** 
     * Instancia o repositório
     * 
     * @var \BaseEmpds\Model\Repository\Interfaces\BaseFileRepositoryInterface 
    */
    $fileRepo = BaseFactory::getRepository($this->getNameEntityFile());
    if(!$fileRepo){
      $this->setError('Não é possível buscar o arquivo.');
      $this->sendResponse();
    }
    /**
     * Pega o file pela hash
     *  
     * @var \BaseEmpds\Entity\FileEntity 
    */
    $file = $fileRepo->getByHash($hash);
    if(!$file){ 
      $this->setError('Não foi encontrando o arquivo.');
      $this->sendResponse();
    }
    //Gera o nome do arquivo para download. Se não tem extensão adiciona, se tiver tira e adiciona.
    $downloadName = str_replace('.'.$file->getExtension(), '', $file->getName()) . '.' . $file->getExtension();
    $this->getFileDownload()->downloadFile($file->getUniqueName(), $file->getPath(), $downloadName, $file->getSize());
  }
}