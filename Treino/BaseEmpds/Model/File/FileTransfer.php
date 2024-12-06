<?php

namespace BaseEmpds\Model\File;

use BaseEmpds\Model\AppContext;
/**
 * Responsável pela transferência de um arquivo da pasta temporária para downloads
 * 
 * @author Glauco David Laicht
 */
class FileTransfer{

  private $pathSource;
  private $pathDestination;

  public function __construct(){
    $this->loadTempSource();
    $this->loadDestination();
  }

  //Move o arquivo da pasta temporária para a downloads
  public function transferFile($fileName, $destinationSuffix){
      //Monta o caminho do arquivo
      $filePath = $this->pathSource . $fileName;
      if(!file_exists($filePath)) {
        //Se o arquivo não for encontrado
        throw new \Exception('O arquivo "'.$fileName.'" não existe no diretório temp (uploads).');
      }
        
      $dirDestination = $this->pathDestination . $destinationSuffix;
      if(!is_dir($dirDestination)){
          mkdir($dirDestination, 0777, true);
      }

      $fileDestination = $dirDestination . DIRECTORY_SEPARATOR . $fileName;
      if(!rename($filePath, $fileDestination)){
          throw new \Exception('Não foi possível mover o arquivo "'.$fileName.'" para o diretório de destino.');
      }

      return $fileDestination;
  }
  
  /**
   * Retorna o caminho de destino do arquivo
   *
   * @return string
   */
  public function getDestinationPath(){
    return $this->pathDestination;
  }

  /**
   * Carrega a pasta temporária
   *
   * @return void
   */
  protected function loadTempSource(){
    $sep = DIRECTORY_SEPARATOR;
    $this->pathSource = DIR_FILES . $sep . AppContext::getInstance()->getAppName() . $sep . DIR_NAME_TEMP . $sep;
    if(!is_dir($this->pathSource)){
        mkdir($this->pathSource);
    }

    if(!file_exists( $this->pathSource )){
        throw new \Exception('Não foi localizado o diretório de arquivos temporários.');
    }
  }

  /**
   * Carrega a pasta de destino
   *
   * @return void
   */
  protected function loadDestination(){
    $sep = DIRECTORY_SEPARATOR;
    $this->pathDestination = DIR_FILES.$sep.AppContext::getInstance()->getAppName().$sep.DIR_NAME_DOWNLOADS.$sep;
    if(!is_dir($this->pathDestination)){
        mkdir($this->pathDestination);
    }

    if(!file_exists( $this->pathDestination )){
        throw new \Exception('Não foi localizado o diretório de destino dos arquivos.');
    }
  }
}