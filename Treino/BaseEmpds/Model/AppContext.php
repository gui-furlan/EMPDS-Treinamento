<?php
/**
 * @author Glauco David Laicht
 */
namespace BaseEmpds\Model;

class AppContext{

  /**
   * @var \BaseEmpds\Model\AppContext
   */
  private static $instance;

  /**
   * @var string
   */
  private $appName;

  /**
   * @var \Geral\Model\Url
   */
  private $url;
  
  /**
    * @var \Doctrine\ORM\EntityManager
    */
  private $em;

  /**
   * Construtor privado, para que não seja construído diretamente
   */
  private function __construct(){
    $this->em  = &$GLOBALS['em'];
    $this->url = &$GLOBALS['url'];
    $this->appName = $this->url->getNameModule();
  }

  /**
   * @return \BaseEmpds\Model\AppContext
   */
  public static function getInstance(){
    if(!isset(self::$instance)){
      self::$instance = new AppContext();
    }
    return self::$instance;
  }

  /**
   * @return string
   */
  public function getAppName(){
    return $this->appName;
  }

  /**
   * @return \Geral\Model\Url
   */
  public function getUrl(){
    return $this->url;
  }

  /**
   * Inicia uma transação
   *
   * @param boolean $forceForSavePoint Executar o comando  diretamente, para criação de savepoint, caso já tenha uma transação aberta
   * @return void
   */
  public function beginTransaction($forceForSavePoint=false){
    if($forceForSavePoint){
      $this->em->getConnection()->beginTransaction();
    }
    else{
      if(!$this->em->getConnection()->isTransactionActive()){
        $this->em->getConnection()->beginTransaction();
      }
    }
  }

  /**
   * Efetiva uma transação
   *
   * @param boolean $forceForSavePoint Executar o comando diretamente, para efetivar o último savepoint, caso já tenha uma transação aberta
   * @return void
   */
  public function commitTransaction($forceForSavePoint=false){
    if($forceForSavePoint){
      $this->em->getConnection()->commit();
    }
    else{
      if($this->em->getConnection()->isTransactionActive()){
        $this->em->getConnection()->commit();
      }
    }
  }

  /**
   * Cancela uma transação
   *
   * @param boolean $forceForSavePoint Executar o comando diretamente, para cancelar o último savepoint, caso já tenha uma transação aberta
   * @return void
   */
  public function rollbackTransaction($forceForSavePoint=false){
    if($forceForSavePoint){
      $this->em->getConnection()->rollBack();
    }
    else{
      if($this->em->getConnection()->isTransactionActive()){
        $this->em->getConnection()->rollBack();
      }
    }
  }
}
