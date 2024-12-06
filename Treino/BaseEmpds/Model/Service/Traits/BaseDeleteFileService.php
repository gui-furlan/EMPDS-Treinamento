<?php

namespace BaseEmpds\Model\Service\Traits;

use BaseEmpds\Entity\FileEntity;
use BaseEmpds\Model\BaseFactory;
use BaseEmpds\Model\Bean;
use BaseEmpds\Model\File\FileDelete;

/**
 * Trait básico para remoção de arquivos
 */
trait BaseDeleteFileService
{

  use BaseFileService;

  /**
   * @var \BaseEmpds\Model\File\FileDelete
   */
  protected $fileDelete;

  /**
   * @var \BaseEmpds\Model\Interfaces\Entity|\BaseEmpds\Model\Interfaces\FileRelationshipInterface
   */
  protected $entity;

  public function execute()
  {
    //Aciona a validação de arquivos
    $this->validate();
    //Processa a remoção
    $this->deleteFile();
  }

  protected function validate()
  {
  }

  protected function deleteFile()
  {
    //Remove a entidade de relacionamento com o arquivo
    $this->deleteFileRelationshipEntity();
    //Busca os arquivos a serem movidos
    $arquivoProperties = $this->entity->getArquivoProperties();
    //Itera cada arquivo
    foreach ($arquivoProperties as $arquivoPropertie) {
      //Busca o arquivo
      /** @var \BaseEmpds\Entity\FileEntity[] */
      $files = Bean::callGetter($this->entity, $arquivoPropertie);
      if (!is_array($files)) {
        $files = array($files);
      }
      foreach ($files as $file) {
        //Remove o arquivo do seu destino
        $this->deleteFileFromDestination($file);
        //Remove a thumbnail do seu destino
        $this->deleteFileThumbnail($file);
      }
      //Remove o arquivo no banco de dados
      $this->deleteFileEntity($file);
    }
  }

  /**
   * Remove o arquivo em seu destino
   *
   * @param \BaseEmpds\Entity\FileEntity
   * @return void
   */
  protected function deleteFileFromDestination(FileEntity $file)
  {
    $this->getFileDelete()->deleteFile($file->getUniqueName(), $file->getPath(), true);
  }

  protected function deleteFileThumbnail(FileEntity $file)
  {
    if (!$file->getThumbnailPath() || !$file->getThumbnailUniqueName()) {
      return;
    }
    $this->getFileDelete()->deleteFile($file->getThumbnailUniqueName(), $file->getThumbnailPath(), true);
  }

  /**
   * Remove o arquivo no banco de dados
   * 
   * @param \BaseEmpds\Entity\FileEntity
   * @return void
   */
  protected function deleteFileEntity(FileEntity $file)
  {
    /** @var \BaseEmpds\Model\Repository\BaseRepository */
    $repoArquivo = BaseFactory::getRepository($this->getNameEntityFile());
    $repoArquivo->remove($file);
  }

  /**
   * Remove a entidade que possui relacionamento com o arquivo
   *
   * @return void
   */
  protected function deleteFileRelationshipEntity()
  {
    //Remove a entidade de relacionamento com o arquivo
    $this->getRepository()->remove($this->entity);
  }

  /**
   * @return \BaseEmpds\Model\File\FileDelete
   */
  protected function getFileDelete()
  {
    if (!isset($this->fileDelete)) {
      $this->fileDelete = new FileDelete();
    }
    return $this->fileDelete;
  }
}
