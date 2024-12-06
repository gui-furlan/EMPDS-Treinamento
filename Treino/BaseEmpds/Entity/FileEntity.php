<?php

namespace BaseEmpds\Entity;

use BaseEmpds\Entity\Interfaces\FileInterface;
use BaseEmpds\Entity\Interfaces\FileThumbnailInterface;
use BaseEmpds\Model\File\FileMapper;
use BaseEmpds\Model\Interfaces\Entity;
use BaseEmpds\Model\Utils\HashUtils;
use DateTime;
use JsonSerializable;

/**
 * As classes filhas DEVERÃO OBRIGATORIAMENTE ter as seguintes anotações:
 *   Entity, Table e HasLifecycleCallbacks
 * @author Glauco David Laicht
 */
abstract class FileEntity implements Entity, FileInterface, JsonSerializable, FileThumbnailInterface
{


  /**
   * @Id
   * @Column (type="integer")
   * @GeneratedValue
   */
  protected $id;

  /**
   * @Column (type="string", nullable=false)
   */
  protected $path;

  /**
   * @Column (type="string", nullable=false)
   */
  protected $name;

  /**
   * @Column (type="string", nullable=false)
   */
  protected $uniqueName;

  /**
   * @Column (type="integer", nullable=false)
   */
  protected $size;

  /**
   * @Column (type="string", nullable=false)
   */
  protected $extension;

  /**
   * @Column (type="string", nullable=false)
   */
  protected $hash;

  /**
   * @Column (type="string", nullable=true)
   */
  protected $thumbnailUniqueName;

  /**
   * @Column (type="string", nullable=true)
   */
  protected $thumbnailPath;

  /**
   * @var datetime $created
   * @Column(type="datetime")
   */
  protected $createdAt;

  /**
   * @var datetime $updated
   * @Column(type="datetime", nullable = true)
   */
  protected $updatedAt;

  /**
   * @PrePersist
   */
  public function onPrePersist(){
    $this->createdAt = new DateTime('now');
    $this->hash = HashUtils::getUuid();
  }

  /**
   * @PreUpdate
   */
  public function onPreUpdate(){
    $this->updatedAt = new DateTime('now');
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
    return $this;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName($name)
  {
    $this->name = $name;
    return $this;
  }

  public function getUniqueName()
  {
    return $this->uniqueName;
  }

  public function setUniqueName($sUniqueName)
  {
    $this->uniqueName = $sUniqueName;
    return $this;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function setPath($path)
  {
    $this->path = $path;
    return $this;
  }

  public function getSize()
  {
    return $this->size;
  }

  public function setSize($size)
  {
    $this->size = $size;
    return $this;
  }

  public function getExtension()
  {
    return $this->extension;
  }

  public function setExtension($extension)
  {
    $this->extension = $extension;
    return $this;
  }

  public function getHash()
  {
    return $this->hash;
  }

  public function getThumbnailUniqueName()
  {
    return $this->thumbnailUniqueName;
  }

  public function setThumbnailUniqueName($uniqueName)
  {
    $this->thumbnailUniqueName = $uniqueName;
    return $this;
  }

  public function getThumbnailPath()
  {
    return $this->thumbnailPath;
  }

  public function setThumbnailPath($path)
  {
    $this->thumbnailPath = $path;
    return $this;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function setCreateAt($createdAt)
  {
    $this->createdAt = $createdAt;
    return $this;
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt($updatedAt)
  {
    $this->updatedAt = $updatedAt;
    return $this;
  }

  /**
   * Carrega os dados do arquivo com base em FileMapper carregado
   */
  public function loadFromFileMapper(FileMapper $file)
  { 
    $this->setName($file->getName());
    $this->setUniqueName(($file->getUniqueName() ? $file->getUniqueName() : $file->getName()));
    $this->setSize($file->getSize());
    $this->setExtension($file->getExtension());
  }

  public function jsonSerialize()
  {
    return [
      'id'         => $this->getId(),
      'name'       => $this->getName(),
      'uniqueName' => $this->getUniqueName(),
      'path'       => $this->getPath(),
      'size'       => $this->getSize(),
      'extension'  => $this->getExtension(),
      'hash'       => $this->getHash(),
      'createdAt'  => $this->getCreatedAt(),
      'updatedAt'  => $this->getUpdatedAt()
    ];
  }
}