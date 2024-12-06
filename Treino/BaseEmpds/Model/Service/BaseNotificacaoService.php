<?php

namespace BaseEmpds\Model\Service;

use BaseEmpds\Model\Service\SendMailService;


abstract class BaseNotificacaoService
{

  CONST FOOTER_MESSAGE = "<br> <footer><b>Este é um e-mail automático enviado pelo sistema " . DEFAULT_APP .", por favor não responda.</b></footer>"; 

  /**
   * 
   *@var \BaseEmpds\Model\Service\SendMailService 
   */
  private $mailSender;

  protected function prepareEmail(string $email, string $subject, string $content)
  {
    $mailSender = $this->getMailSender();
    $mailSender->setRecipientEmail($email);
    $mailSender->setSubject($subject);
    $mailSender->setHtmlContent($content);
  }

  
  protected function send() {
    $this->getMailSender()->send();
  }

  public function addImage(string $imageId, string $imageName = '', string $imagePath = null)
  {
    if(is_null($imagePath)){  
      $imagePath = DIR_SYS . '/'.'imagens'.'/' . DEFAULT_APP . '/' . $imageName;
    }
    $this->getMailSender()->addImageToEmail($imagePath, $imageId);
  }

  protected function saveLog($saveLog = false)
  {
    $this->getMailSender()->setSaveLog($saveLog);
  }

  protected function getMailSender()
  {
    if($this->mailSender ===  null){
      $this->mailSender = new SendMailService();
    }
    return $this->mailSender;
  }


  public function getFooterMessage()
  {
    return self::FOOTER_MESSAGE;
  }

  public function createNotificationMessage($header, $body)
  {
    return "
      <div>
        <h3>" . $header . "</h3>" . 
          "<div>
            <p> 
              " . $body . "
            </p>
          </div>" . 
      "<div>" .
          self::FOOTER_MESSAGE .
      "</div>
      </div>";
  }

}