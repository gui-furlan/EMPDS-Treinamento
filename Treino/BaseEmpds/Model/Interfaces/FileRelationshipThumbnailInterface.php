<?php

namespace BaseEmpds\Model\Interfaces;

interface FileRelationshipThumbnailInterface extends FileRelationshipInterface
{

    /**
     * Retorna o diretório de armazenamento das thumbnails
     * @return mixed
     */
    public function getDirectoryStorageThumbnail();
}