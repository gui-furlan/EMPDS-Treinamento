<?php
namespace BaseEmpds\Model\Service;

use BaseEmpds\Model\Service\BaseService;
use BaseEmpds\Model\Service\Traits\BaseCreateFileService;

/**
 * Cria um service para a criação de uma entidade que tem relacionamento com um arquivo
 */
class CreateFileRelationshipService extends BaseService{

  use BaseCreateFileService;
  
}