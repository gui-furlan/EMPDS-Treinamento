<?php

namespace BaseEmpds\Model\File;

use BaseEmpds\Model\File\FileMapper;

use BaseEmpds\Model\AppContext;

/**
 * Responsável por realizar o upload do arquivo para a pasta temporária
 * 
 * @author Glauco David Laicht
 */
class FileUpload{

  //Extensões padrões permitidas
  const EXTENSIONS = ['pdf', 'docx', 'doc', 'xls', 'xlsx', 'odt', 'odf', 'ods', 'jpg', 'jpeg', 'png', 'csv', 'txt', 'json'];

  //Tamanho máximo permitido do arquivo
  const MAX_FILE_SIZE = 2 * 1024 * 1024;

  /**
   * @var string
   */
  private $appName;

  /**
   * @var array
   */
  private $files;

  public function __construct(){
    $this->files = [];
    $this->appName = AppContext::getInstance()->getAppName();
  }

  //Realiza o upload dos arquivos
  public function upload($files){
    $this->parseFiles($files);
  }

  /**
   * @return \BaseEmpds\Model\FileMapper[]
   */
  public function getFiles($inputName='file'){
    return isset($this->files[$inputName]) ? $this->files[$inputName] : [];
  }

  /**
   * @return array
   */
  public function getAllFiles(){
    return $this->files;
  }

  /**
   * Transcreve os arquivos enviados para um formato válido
   */
  protected function parseFiles($files){
    foreach($files as $nameInput => $fileInputs){
      $fileInputs = $this->reorderFiles($fileInputs);
      //Cria uma posição no array para o referido input
      $this->files[$nameInput] = [];
      //Para cada arquivo no input
      foreach($fileInputs as $file){
        $this->files[$nameInput][] = $this->parseFile($file);
      }
    }
  }

  /**
   * Ordena os arquivos quando são múltiplos, de vários arrays, para um só organizado.
   *
   * @param array $fileInputs
   * @return array
   */
  protected function reorderFiles($fileInputs){
    $isMulti = is_array($fileInputs['name']);
    $file_count = $isMulti ? count($fileInputs['name']) : 1;
    $file_keys = array_keys($fileInputs);

    $file_ary = [];
    for($i=0; $i<$file_count; $i++){
      foreach($file_keys as $key){
        if($isMulti){
          $file_ary[$i][$key] = $fileInputs[$key][$i];
        }
        else{
          $file_ary[$i][$key] = $fileInputs[$key];
        }
      }
    }
    return $file_ary;
  }

  /**
   * Realiza a verificação do arquivo e move ele para a pasta temporária
   * @return \BaseEmpds\Model\FileMapper
   */
  protected function parseFile($file){
    $file = new FileMapper($file);
    if(!$file->hasExtension( SELF::EXTENSIONS )){
       //Se o arquivo não possuir uma extensão permitida
      throw new \Exception("O arquivo enviado possui um tipo não permitido (".$file->getName().").");
    }
    if(!$file->sizeLessThen(self::MAX_FILE_SIZE)){
      //Se o arquivo possuir o tamanho maior que o permitido
      throw new \Exception("O arquivo enviado possui um tamanho maior que o permitido (".$file->getName().").");
    }
    $sep     = DIRECTORY_SEPARATOR;
    $fileDst = DIR_FILES . $sep . $this->appName . $sep . DIR_NAME_TEMP . $sep . $file->getUniqueName();
    if(move_uploaded_file($file->getTempName(), $fileDst)){
        //Se conseguiu remover o arquivo
        return $file;
    }
    //Se não conseguiu mover o arquivo
    throw new \Exception("Não foi possível mover o arquivo para o diretório temporário privado (".$file->getName().").");
  }
}