<?php

namespace BaseEmpds\Model;

use Error;
use BaseEmpds\Model\UserDataSession;

abstract class BaseNotificationDataSession
{

  const NOTIFICATION_QUANTITY = 'qtde';
  const NOTIFICATION_LAST_CHECK = 'lastCheck';
  const NOTIFICATION = 'notification';
  const REFRESH_NOTIFICATION_TIME_IN_MINUTES = 5;
  const NOTIFICATION_DATE_FORMAT = 'Y-m-d H:i:s';

  protected static $instance;

  protected function __construct()
  {
  }

  /**
   * @return \BaseEmpds\Model\BaseNotificationDataSession
   */
  public abstract static function getInstance();

  /**
   * @return \BaseEmpds\Model\Repository\NotificationDestinationRepository | \BaseEmpds\Model\Repository\BaseRepository
   */
  protected abstract function getNotificationDestinationRepository();
  

  public function setQtdeNotificacoes($iQtde, $lastCheck = null)
  {
    if (is_null($iQtde)) {
      throw new Error('Quantidade de notificações inválida');
    }
    if (is_null($lastCheck)) {
      $lastCheck = date(self::NOTIFICATION_DATE_FORMAT);
    }
    UserDataSession::setDataUsuario([self::NOTIFICATION => [self::NOTIFICATION_QUANTITY => $iQtde, self::NOTIFICATION_LAST_CHECK => $lastCheck]]);
  }

  public function getQtdeNotificacoes()
  {
    $notification = UserDataSession::getDataUsuario(self::NOTIFICATION);
    if (!$notification) {
      $this->reloadQtdeNotificacoes();
      $notification = UserDataSession::getDataUsuario(self::NOTIFICATION);
    }
    if ($notification && isset($notification[self::NOTIFICATION_QUANTITY])) {
      return $notification[self::NOTIFICATION_QUANTITY];
    }
    return 0;
  }

  public function incrementQtdeNotificacoes()
  {
    $notificationQtd = $this->getQtdeNotificacoes();
    $qtde = intval($notificationQtd);
    $newQtde = $qtde + 1;
    $this->setQtdeNotificacoes(strval($newQtde), date(self::NOTIFICATION_DATE_FORMAT));
  }

  public function decrementQtdeNotificacoes()
  {
    $notificationQtd = $this->getQtdeNotificacoes();
    $qtde = intval($notificationQtd);
    $newQtde = $qtde > 0 ? ($qtde - 1) : 0;
    $this->setQtdeNotificacoes(strval($newQtde), date(self::NOTIFICATION_DATE_FORMAT));
  }

  public function clearQtdeNotificacoes()
  {
    $this->setQtdeNotificacoes(0);
  }

  private function reloadQtdeNotificacoes()
  {
    $userId = UserDataSession::getDataUsuario('idUsuario');
    if ($userId) {
      $oNotifacaoDestinatarioRepo = $this->getNotificationDestinationRepository();
      $qtde = $oNotifacaoDestinatarioRepo->countNotificationsByUserId($userId);
      $this->setQtdeNotificacoes($qtde, date(self::NOTIFICATION_DATE_FORMAT));
    }
  }

  private function getLastNotificationCheckDateTime()
  {
    $notification = UserDataSession::getDataUsuario(self::NOTIFICATION);
    if ($notification && isset($notification[self::NOTIFICATION_LAST_CHECK])) {
      return $notification[self::NOTIFICATION_LAST_CHECK];
    }
    return null;
  }

  public function getQtdeNotificacoesAtual()
  {
    $lastCheck = $this->getLastNotificationCheckDateTime();
    $now       = date(self::NOTIFICATION_DATE_FORMAT);
    $diff      = strtotime($now) - strtotime($lastCheck);
    $minutes   = floor($diff / 60);
    if ($minutes >= self::REFRESH_NOTIFICATION_TIME_IN_MINUTES) {
      $this->reloadQtdeNotificacoes();
    }
    return $this->getQtdeNotificacoes();
  }
}
