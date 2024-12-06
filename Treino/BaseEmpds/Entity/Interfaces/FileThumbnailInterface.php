<?php
namespace BaseEmpds\Entity\Interfaces;

interface FileThumbnailInterface 
{
    /**
   * Define o caminho até a miniatura da imagem
   */
  public function setThumbnailPath($sThumbnailPath);

  /**
   * Retorna o caminho até a miniatura da imagem
   */
  public function getThumbnailPath();

  /**
   * Define o nome único da miniatura da imagem
   */
  public function setThumbnailUniqueName($sThumbnailUniqueName);

  /**
   * Retorna o nome único da miniatura da imagem
   */
  public function getThumbnailUniqueName();
}