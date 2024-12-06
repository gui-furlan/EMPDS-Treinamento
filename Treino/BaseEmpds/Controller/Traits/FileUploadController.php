<?php

namespace BaseEmpds\Controller\Traits;

use BaseEmpds\Model\Bean;
use BaseEmpds\Model\File\FileMapper;
use BaseEmpds\Model\File\FileUpload;

/**
 * Trait para adicionar funções de adição de arquivo
 * @author Glauco David Laicht
 */
trait FileUploadController{

  /**
   * @var \BaseEmpds\Model\File\FileUpload
   */
  private $fileUpload;

  /**
   * Instancia um FileUpload
   *
   * @return \BaseEmpds\Model\File\FileUpload
   */
  protected function getFileUpload(){
    if(!isset($this->fileUpload)){
      $this->fileUpload = new FileUpload();
    }
    return $this->fileUpload;
  }

  //Realiza o upload dos arquivos
  public function uploadFiles(){
    $fileUpload = $this->getFileUpload();
    try {
        $fileUpload->upload($_FILES);
        $this->setSuccess('Upload realizado com sucesso', $fileUpload->getAllFiles());
    }
    catch(\Exception $e) {
        $this->setError('Não foi possível realizar o upload do arquivo', ['detail' => $e->getMessage()]);
    }
    $this->sendResponse();
  }

  /**
   * Carrega os dados automaticamente
   */
  protected function beanToEntity($data)
  {
    parent::beanToEntity($data);

    $arquivosToSave = $this->entity->getArquivoProperties();
    //Itera cada arquivo
    foreach($arquivosToSave as $arquivoToSave){
      //Busca o arquivo
      $files       = Bean::callGetter($this->entity, $arquivoToSave);
      $fileMappers = [];
      foreach($files as $file){
        $fileMapper = new FileMapper();
        $fileMapper->loadFromRequest($file);
        $fileMappers[] = $fileMapper;
      }
      //Atribui o arquivo
      Bean::callSetter($this->entity, $arquivoToSave, $fileMappers);
    }
  }
}