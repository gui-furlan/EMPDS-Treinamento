<?php 

namespace BaseEmpds\Model\File;

use BaseEmpds\Model\AppContext;
use Error;
use Geral\Model\WideImage;

class FileThumbnail {

  private $thumbnailPath;
  private $thumbnailName;
  private $thumbnailDestinationPath;

  const THUMBNAIL_WIDTH = 196;
  const THUMBNAIL_HEIGHT = 196;
  CONST IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'bmp'];


  public function __construct() {
    $this->loadThumbnailDestinationPath();
  }
  //Define onde o path da thumbnail será salvo
  public function setThumbnailPath($thumbnailPath)
  {
    $this->thumbnailPath = $thumbnailPath;
    return $this;
  }
  //Retorna o path da thumbnail
  public function getThumbnailPath()
  {
    return $this->thumbnailPath;
  }
  //Retorna o nome da thumbnail
  public function getThumbnailName()
  {
    return $this->thumbnailName;
  }
  /**
   * Cria o thumbnail do arquivo e retorna o nome. 
   *
   * @param BaseEmpds\Entity\FileEntity $file
   * @return string
   */
  public function makeThumbnail($file)
  {
    //Verifica que a extensão do arquivo é válida para gerar thumbnail
    if(!self::isImageForThumbnail($file)){
      throw new Error("O arquivo " . $file->getUniqueName() . " não é uma imagem válida para gerar thumbnail.");
    }
    //Cria o path inteiro do arquivo no seu destino
    $thumbnailFile = $this->thumbnailDestinationPath . $file->getPath() . DIRECTORY_SEPARATOR . $file->getUniqueName();
    
    //Verifica se o arquivo existe
    if (!file_exists($thumbnailFile)) {
      throw new Error('O arquivo "'.$thumbnailFile.'" não existe.');
    }
    //Instância a biblioteca WideImage
    $wideImageInstance = WideImage::createInstance($thumbnailFile);
    //Redimensiona a imagem de acordo com as dimensões definidas
    $resizedImage = $wideImageInstance->resize(self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT);
    //Cria o path inteiro da thumbnail
    $thumbnailPath = $this->thumbnailDestinationPath . DIRECTORY_SEPARATOR . $this->thumbnailPath;
    //Verifica se o diretório da thumbnail existe, se não existir cria
    if(!is_dir($thumbnailPath)){
      mkdir($thumbnailPath);
    }
    //Define o nome da thumbnail
    $this->thumbnailName = 'thumbnail_' . str_replace( array( '.', ' ' ), '', microtime( true ) ) . '_' .$file->getUniqueName();
    //Salva a thumbnail no destino
    $resizedImage->saveToFile($thumbnailPath . DIRECTORY_SEPARATOR . $this->getThumbnailName());
    //Retorna o nome da thumbnail
    return $this->getThumbnailName();
  }
  /**
   * Carrega o diretório de destino da thumbnail
   *
   * @return void
   */
  protected function loadThumbnailDestinationPath()
  {
    //Define o diretório de destino da thumbnail
    $this->thumbnailDestinationPath = DIR_FILES . DIRECTORY_SEPARATOR . AppContext::getInstance()->getAppName() . DIRECTORY_SEPARATOR . DIR_NAME_DOWNLOADS . DIRECTORY_SEPARATOR;
    //Verifica se o diretório de destino da thumbnail existe, se não existir cria
    if(!is_dir($this->thumbnailDestinationPath)){
        mkdir($this->thumbnailDestinationPath);
    }
    //Verifica se o diretório de destino da thumbnail existe, se não existir lança uma exceção
    if(!file_exists( $this->thumbnailDestinationPath )){
        throw new \Exception('Não foi localizado o diretório de destino da thumbnail.');
    }
  }
    /**
   * Define se o arquivo é imagem e aceita thumbnail
   * @return boolean
   */
  public static function isImageForThumbnail($file)
  {
    return in_array($file->getExtension(), self::IMAGE_EXTENSIONS, true);
  } 
}
