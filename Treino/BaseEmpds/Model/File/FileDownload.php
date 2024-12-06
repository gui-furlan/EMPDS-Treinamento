<?php

namespace BaseEmpds\Model\File;

use BaseEmpds\Model\AppContext;

class FileDownload{

  private $path;

  public function __construct($path=null){
    if(!$path){
      $this->loadPath($path);
    }
  }
  
  //Captura o arquivo
  public function getFileContent($fileName, $destinationSuffix){
    //Monta o caminho do arquivo
    $filePath = $this->path . DIRECTORY_SEPARATOR . $destinationSuffix . DIRECTORY_SEPARATOR . $fileName;
    if(!file_exists($filePath)){
      //Se o arquivo não for encontrado
      throw new \Exception('O arquivo "'.$fileName.'" não existe.');
    }
    
    return file_get_contents($filePath);
  }

  //Processa o download do arquivo
  public function downloadFile($fileName, $destinationSuffix, $downloadName = '', $fileSize = null){
    //Monta o caminho do arquivo
    $filePath = $this->path . DIRECTORY_SEPARATOR . $destinationSuffix . DIRECTORY_SEPARATOR . $fileName;
    if(!file_exists($filePath)){
      //Se o arquivo não for encontrado
      throw new \Exception('O arquivo "'.$fileName.'" não existe.');
    }

    $downloadName = ($downloadName ? $downloadName : $fileName);
    $fileSize = ($fileSize ? $fileSize : filesize($filePath));
    $this->addHeaders($downloadName, $fileSize);

    echo file_get_contents($filePath);
  }

  //Adiciona o cabeçalho da requisição
  protected function addHeaders($fileName = '', $fileSize = null){
    $fileName = ($fileName ? $fileName : 'arquivo');
    
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Type: application/octet-stream');
    header('Content-Transfer-Encoding: binary');
    if($fileSize){
      header('Content-Length: ' . $fileSize);
    }
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');
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