<?php

namespace BaseEmpds\Model\File;

use BaseEmpds\Model\AppContext;
/**
 * Responsável pela deleção de Arquivos
 * 
 * @author Glauco David Laicht
 */
class FileDelete{

  private $path;
  
  public function __construct($path=null){
    if(!$path){
      $this->loadPath($path);
    }
    
  }

  //Realiza a deleção do arquivo
  public function deleteFile($fileName, $destinationSuffix, $ignoreOnNotFound=false){
    //Monta o caminho do arquivo
    $filePath = $this->path . DIRECTORY_SEPARATOR . $destinationSuffix . DIRECTORY_SEPARATOR . $fileName;
    if(!file_exists($filePath)){
      if($ignoreOnNotFound){
        return $filePath;
      }
      //Se o arquivo não for encontrado
      throw new \Exception('O arquivo "'.$fileName.'" não existe.');
    }
    
    if(!unlink($filePath)){
        throw new \Exception('Não foi possível remover o arquivo "'.$fileName.'" para o diretório de destino.');
    }

    return $filePath;

  }
  
  //Carrega o caminho do arquivo
  protected function loadPath(){
    $sep = DIRECTORY_SEPARATOR;
    $this->path = DIR_FILES.$sep.AppContext::getInstance()->getAppName().$sep.DIR_NAME_DOWNLOADS.$sep;
    if(!is_dir($this->path)){
        mkdir($this->path);
    }

    if(!file_exists($this->path)){
        throw new \Exception('Não foi localizado o diretório de destino dos arquivos.');
    }
  }
}