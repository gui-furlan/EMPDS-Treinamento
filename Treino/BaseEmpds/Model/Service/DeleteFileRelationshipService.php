<?php
namespace BaseEmpds\Model\Service;

use BaseEmpds\Model\Service\BaseService;
use BaseEmpds\Model\Service\Traits\BaseDeleteFileService;

/**
 * Cria um service para a deleção de uma entidade que tem relacionamento com um arquivo
 */
class DeleteFileRelationshipService extends BaseService{

  use BaseDeleteFileService;
  
}