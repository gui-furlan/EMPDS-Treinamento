<?php
namespace BaseEmpds\Model\File;

use BaseEmpds\Entity\Interfaces\FileInterface;
use JsonSerializable;
use BaseEmpds\Model\AppContext;

/**
 * Esta classe possui os métodos e atributos comuns a manipulação de nomes de
 * arquivos
 *
 * @author Glauco David Laicht
 */
class FileMapper implements FileInterface, JsonSerializable
  
{
    private $name;
    private $extension;
    private $uniqueName;
    private $tempName;
    private $size;
    
    public function __construct($file=null){
      if($file){
        $this->loadFileProperties($file);
      } 
    }

    public function setName($sName){
      $this->name = $sName;
      return $this;
    }

    public function getName(){
        return $this->name;
    }

    public function setUniqueName($sUniqueName){
      $this->uniqueName = $sUniqueName;
      return $this;
    }

    public function getUniqueName(){
        return $this->uniqueName;
    }

    public function setSize($iSize){
      $this->size = $iSize;
      return $this;
    }

    public function getSize(){
      return $this->size;
    }

    public function setExtension($sExtension){
      $this->extension = $sExtension;
      return $this;
    }

    public function getExtension(){
        return $this->extension;
    }

    public function setTempName($sTempName){
      $this->tempName = $sTempName;
      return $this;
    }

    public function getTempName(){
        return $this->tempName;
    }

    public function setPath($sPath){}
    public function getPath(){
      return '';
    }

    public function getHash(){
      return $this->getUniqueName();
    }

    /**
     * Verifica se a extensão do arquivo está contida nas extensões permitidas
     * @param array extensions Extensões permitidas para verificação
     * @return  boolean
     **/
    public function hasExtension(Array $extensions){
      return in_array( $this->getExtension(), $extensions);
    }

    /**
     * Retorna se o arquivo tem o tamanho menor ou igual que o limite repassado
     * @return bool
     */
    public function sizeLessThen($sizeLimit){
      return $this->size <= $sizeLimit;
    }

    /**
     * Carrega dados do arquivo através de um destino
     */
    public function loadFromPath($path){
      $info = pathinfo($path);
      $size = filesize($path);
      $this->name       = $info['basename'];
      $this->extension  = strtolower($info['extension']);
      $this->size       = $size;
      $this->uniqueName = $info['basename'];
    }

    /**
     * Carrega as informações do array de upload
     *
     * @param array $file
     * @return void
     */
    public function loadFromRequest($file){
      $this->setName($file['originalName']);
      $this->setUniqueName($file['name']);
      $this->setSize($file['size']);
      $this->setExtension($file['extension']);
    }

    public function jsonSerialize()
    { 
        return [
            'originalName' => $this->getName(),
            'name'         => $this->getUniqueName(),
            'extension'    => $this->getExtension(),
            'size'         => $this->getSize(),
        ];
    }

    /**
     * Carrega as informações do arquivo através do upload
     */
    protected function loadFileProperties($file){
      if(empty($file['name'])) {
        throw new \Exception("Nome do arquivo não fornecido.");
      }

      $info = pathinfo( $file['name'] );
      $this->name       = $info['basename']; // Nome do arquivo, sem extensão.
      $this->extension  = strtolower($info['extension']); // Extensão, sem o ponto.
      $this->size       = $file['size']; // Nome do arquivo com extensão.
      $this->tempName   = $file['tmp_name']; // Nome temporário do arquivo
      $this->uniqueName = $this->generateUniqueName();
    }    

    /**
     * Criar um novo nome para o arquivo utilizando o nome da aplicação como sufixo.
     * O novo nome é criado no formato: <nome original após filtro>_<appsufixo>_<microtime>.<extensão>
     * @return string Novo nome
     **/
    private function generateUniqueName(){
      $fileName = preg_replace( "/[^a-z0-9_]/ui", '_', $this->getName());
      $appName  = AppContext::getInstance()->getAppName();
      if(!empty($appName)) {
          $fileName .= '_'.$appName;
      }
      $fileName .= '_' . str_replace( array( '.', ' ' ), '', microtime( true ) );
      $fileName .= '.' . $this->getExtension();

      return $fileName;
  }
}