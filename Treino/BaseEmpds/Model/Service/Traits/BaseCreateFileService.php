<?php

namespace BaseEmpds\Model\Service\Traits;

use BaseEmpds\Entity\FileEntity;
use BaseEmpds\Entity\Interfaces\FileInterface;
use BaseEmpds\Model\BaseFactory;
use BaseEmpds\Model\Bean;
use BaseEmpds\Model\File\FileMapper;
use BaseEmpds\Model\File\FileTransfer;
use BaseEmpds\Model\File\FileThumbnail;
use BaseEmpds\Model\Interfaces\FileRelationshipInterface;
use BaseEmpds\Model\Interfaces\FileRelationshipThumbnailInterface;
use Exception;

/**
 * Trait básico para iteração com arquivos
 */
trait BaseCreateFileService
{

  use BaseFileService;

  /**
   * @var \BaseEmpds\Model\Interfaces\Entity|\BaseEmpds\Model\Interfaces\FileRelationshipInterface
   */
  protected $entity;

  /**
   * @var \BaseEmpds\Model\File\FileMapper
   */
  protected $fileTransfer;

  /**
   * @var \BaseEmpds\Model\File\FileThumbnail
   */
  protected $fileThumbnail;

  public function execute()
  {
    //Aciona a validação de arquivos
    $this->validate();
    //Processa os arquivos
    if (!$this->entity->isMultipleFileRelationship()) {
      //Se o relacionamento é de 1x1
      $this->processFile();
    } else {
      //Se o relacionamento é de 1xN
      $this->processMultipleFiles();
    }
  }

  protected function validate()
  {
    if (!$this->entity) {
      throw new Exception('Não foi informada uma entidade para processo o arquivo.');
    }

    if (!($this->entity instanceof FileRelationshipInterface)) {
      throw new Exception('A entidade informada não permite a gravação de arquivos.');
    }
  }

  /**
   * Processa os arquivos se a entidade possuir um relacionamento 1 x 1 com arquivos
   * @return void
   */
  protected function processFile()
  {
    //Busca os arquivos a serem movidos
    $arquivoProperties = $this->entity->getArquivoProperties();
    //Itera cada arquivo
    foreach ($arquivoProperties as $arquivoPropertie) {
      //Busca o arquivo
      /** @var \BaseEmpds\Entity\Interfaces\FileInterface[] */
      $files    = $this->parseFilesEntry($arquivoPropertie);
      //Arquivo a ser processado
      $file     = array_shift($files);
      //Transfere o arquivo
      $this->storageFileDestination($file->getUniqueName());
      //Cria a entidade arquivo
      $arquivo       = $this->createFileEntity($file);
      //Cria a thumbnail do arquivo
      $this->createImageThumbnail($arquivo);
      //Atribui o arquivo
      Bean::callSetter($this->entity, $arquivoPropertie, $arquivo);
      //Salva a entidade arquivo no banco de dados
      $this->saveFileEntity($arquivo);
    }
    //Salva a entidade de relacionamento com o arquivo
    $this->saveFileRelationshipEntity();
  }

  protected function createImageThumbnail(FileEntity $file)
  {
    if (!$file) {
      return;
    }
    if (!$this->entity instanceof FileRelationshipThumbnailInterface) {
      return;
    }
    if(!FileThumbnail::isImageForThumbnail($file)){
      return;
    }
    //Retorna a entidade criadora de  miniaturas
    $fileThumbnailEntity = $this->getFileThumbnail();
    //Cria a miniatura
    $thumbnailName       = $fileThumbnailEntity->setThumbnailPath($this->entity->getDirectoryStorageThumbnail())
                                               ->makeThumbnail($file);
    if (!$thumbnailName) {
      return;
    }
    //Define o nome da thumbnail no arquivo
    $file->setThumbnailUniqueName($thumbnailName);
    //Define o caminho da thumbnail no arquivo
    $file->setThumbnailPath($this->entity->getDirectoryStorageThumbnail());
  }

  /**
   * Processa os arquivos se a entidade possuir um relacionamento 1 x N com arquivos
   * @return void
   */
  protected function processMultipleFiles()
  {
    //Busca os arquivos a serem movidos
    $arquivoProperties = $this->entity->getArquivoProperties();
    if (count($arquivoProperties) > 0) {
      throw new Exception('Não existe suporte para múltiplos arquivos, com múltiplos campos.');
    }

    //Itera cada arquivo
    foreach ($arquivoProperties as $arquivoPropertie) {
      //Busca o arquivo
      /** @var \BaseEmpds\Entity\Interfaces\FileInterface[] */
      $files = $this->parseFilesEntry($arquivoPropertie);
      //Busca os arquivos
      foreach ($files as $file) {
        //Transferi o arquivo
        $this->storageFileDestination($file->getUniqueName());
        //Salva o arquivo no banco de dados
        $arquivo  = $this->createFileEntity($file);
        //Cria a thumbnail do arquivo
        $this->createImageThumbnail($arquivo);
        //Atribui o arquivo
        Bean::callSetter($this->entity, $arquivoPropertie, $arquivo);
        //Salva a entidade arquivo no banco de dados
        $this->saveFileEntity($arquivo);
        //Será gerado uma entidade para cada arquivo
        $this->saveFileRelationshipEntity();
        //Remove o id da entidade, para ser uma nova inserção
        $this->entity->setId(null);
        //Remove o id do arquivo
        Bean::callSetter($this->entity, $arquivoPropertie, null);
      }
    }
  }

  /**
   * Realiza conversão dos arquivos para um formato esperado
   *
   * @return \BaseEmpds\Entity\Interfaces\FileInterface[]
   */
  protected function parseFilesEntry($propertieFile)
  {
    /** @var \BaseEmpds\Entity\Interfaces\FileInterface[] */
    $files = Bean::callGetter($this->entity, $propertieFile);
    if (count(array_filter($files, function ($entry) {
      return !($entry instanceof FileInterface);
    })) == 0) {
      //Se todas as instâncias do array já são de FileInterface, então só retorna
      return $files;
    }
    //Arquivos a serem retornados
    $returnFiles = [];
    foreach ($files as $file) {
      if (is_array($file)) {
        //Se for um array, significa que veio o objeto do frontend
        $fileMapper = new FileMapper();
        $fileMapper->loadFromRequest($file);
        $returnFiles[] = $fileMapper;
      } else if (is_string($file)) {
        //Se for uma string, significa que é o arquivo com o path onde ele está
        $fileMapper = new FileMapper();
        $fileMapper->loadFromPath($file);
        $returnFiles[] = $fileMapper;
      } else {
        $returnFiles[] = $file;
      }
    }
    return $returnFiles;
  }

  /**
   * Grava o arquivo em seu destino
   *
   * @param string $nameFileTemp
   * @return string
   */
  protected function storageFileDestination($nameFileTemp)
  {
    return $this->getFileTransfer()->transferFile($nameFileTemp, $this->entity->getDirectoryStorage());
  }

  /**
   * Cria o arquivo
   * 
   * @param \BaseEmpds\Model\File\FileMapper
   * @return \BaseEmpds\Entity\Interfaces\FileInterface
   */
  protected function createFileEntity($fileInfo)
  {
    /** @var \BaseEmpds\Entity\FileEntity */
    $arquivo     = BaseFactory::getEntity($this->getNameEntityFile());
    if (!($arquivo instanceof FileEntity)) {
      throw new Exception('Não é possível incluir arquivo.');
    }
    $arquivo->loadFromFileMapper($fileInfo);
    $arquivo->setPath($this->entity->getDirectoryStorage());
    //Retorna o arquivo criado
    return $arquivo;
  }
  /**
   * Salva o arquivo no banco de dados
   *
   * @param [type] $file
   * @return void
   */
  protected function saveFileEntity($file)
  {
    /** @var \BaseEmpds\Model\Repository\BaseRepository */
    $repoArquivo = BaseFactory::getRepository($this->getNameEntityFile());
    //Grava o arquivo no banco de dados
    $repoArquivo->add($file);
  }

  /**
   * Salva a entidade que possui relacionamento com o arquivo
   *
   * @return void
   */
  protected function saveFileRelationshipEntity()
  {
    //Salva a entidade de relacionamento com o arquivo
    $this->getRepository()->add($this->entity);
  }

  /**
   * @return FileTransfer
   */
  protected function getFileTransfer()
  {
    if (!isset($this->fileTransfer)) {
      $this->fileTransfer = new FileTransfer();
    }
    return $this->fileTransfer;
  }

  /**
   *
   * @return FileThumbnail
   */
  protected function getFileThumbnail()
  {
    if (!isset($this->fileThumbnail)) {
      $this->fileThumbnail = new FileThumbnail();
    }
    return $this->fileThumbnail;
  }
}
