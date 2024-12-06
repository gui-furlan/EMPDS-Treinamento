<?php

namespace BaseEmpds\Model\Repository;

use BaseEmpds\Model\BaseFactory;
use BaseEmpds\Model\Repository\BaseRepository;

abstract class NotificationDestinationRepository extends BaseRepository
{

  CONST NOTIFICATION_STATUS_FILTER_TODAS    = -1;
  CONST NOTIFICATION_STATUS_FILTER_NAO_LIDA = 0;
  CONST NOTIFICATION_STATUS_FILTER_LIDA     = 1;


  /**
   * @param \BaseEmpds\Entity\NotificationDestination $entity
   */
  protected function formatDataPersist($entity)
  {

    if(is_scalar($entity->getNotification())){
      $entity->setNotification(BaseFactory::getEntityById('Notification', $entity->getNotification(), true));
    }
  }
  
  public abstract function countNotificationsByUserId($iId);
  
}