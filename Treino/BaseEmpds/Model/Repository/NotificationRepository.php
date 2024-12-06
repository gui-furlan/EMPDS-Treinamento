<?php

namespace BaseEmpds\Model\Repository;

use BaseEmpds\Model\Repository\BaseRepository;
use Geral\Model\Date;

abstract class NotificationRepository extends BaseRepository
{
  /**
   * @param \BaseEmpds\Entity\Notification $entity
   */
  protected function formatDataPersist($entity)
  {
    $date = $entity->getDate();
  
    if(is_string($date)){
      $entity->setDate(Date::convStringToDatetime($date, Date::DATA_FORMAT));
    } 
  }
}
