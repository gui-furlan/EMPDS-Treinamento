<?php

namespace BaseEmpds\Model\Service;

require DIR_SYS . '/../libs/phpmailer/vendor/autoload.php';

use ErrorException;
use \Geral\Model\Config;
use \Geral\Model\Factory\MailMessageFactory;
use PHPMailer\PHPMailer\PHPMailer;

class SendMailService
{
  /**
   * @var \PHPMailer\PHPMailer\PHPMailer
   */
  private $mail;

  /**
   * @var array
   */
  private $replyTo;

  /**
   * @var array
   */
  private $replyToName;

  /**
   * @var string
   */
  private $log;

  /**
   * @var bool
   */
  private $saveLog = true;

  /**
   * @var string
   */
  private $recipientEmail;

  /**
   * @var string
   */
  private $emailSubject; 

  /**
   * @var string
   */
  private $emailContentHtml;

  function __construct()
  {
    $this->initPhpMailer();
  }

  private function initPhpMailer(): void
  {
    try {
      $this->mail = new PHPMailer(true);
    } catch (\Exception $e) {
      throw new ErrorException('Erro ao instanciar PHPMailer: ' . $e->getMessage());
    }
    $this->setPhpMailerConfig();
    $this->loadSenderConfig();
  }

  private function setPhpMailerConfig(): void
  {
    $this->mail->SMTPDebug  = 2;
    $this->mail->Debugoutput = function ($str, $level) {
      $this->log .= $str;
    };
    $this->mail->isSMTP();
    $this->mail->Host        = SMTP_HOST;
    $this->mail->Port        = SMTP_PORT;
    $this->mail->SMTPAuth    = false;
    $this->mail->SMTPSecure  = false;
    $this->mail->SMTPAutoTLS = false;
    $this->mail->Username    = SMTP_USER;
    $this->mail->Password    = SMTP_PASSWORD;
    $this->mail->CharSet     = "UTF-8";
    $this->mail->Encoding    = 'base64';
    $this->mail->isHTML(true);
  }

  private function loadSenderConfig(): void
  {
    $fromAddress = SMTP_FROM;
    $fromName = SMTP_FROM_NAME;

    if (Config::constantExist('SMTP_REPLYTO') && !empty(Config::getConstant('SMTP_REPLYTO'))) {
      $this->replyTo = Config::getConstant('SMTP_REPLYTO');
      $fromAddress = $this->replyTo;
    }
    if (Config::constantExist('SMTP_REPLYTO_NAME') && !empty(Config::getConstant('SMTP_REPLYTO_NAME'))) {
      $this->replyToName = Config::getConstant('SMTP_REPLYTO_NAME');
      $fromName = $this->replyToName;
    }
    $this->mail->setFrom($fromAddress, $fromName);
  }

  public function setSaveLog(bool $saveLog): SendMailService
  {
    $this->saveLog = $saveLog;
    return $this;
  }

  public function setRecipientEmail(string $recipientEmail): SendMailService
  {
    $this->recipientEmail = $recipientEmail;
    return $this;
  }

  public function setSubject(string $emailSubject): SendMailService
  {
    $this->emailSubject = $emailSubject;
    return $this;
  }

  public function setHtmlContent(string $emailContentHtml): SendMailService
  {
    $this->emailContentHtml = $emailContentHtml;
    return $this;
  }

  public function getRecipientEmail(): string
  {
    return $this->recipientEmail;
  }

  public function getSubject(): string
  {
    return $this->emailSubject;
  }

  public function getHtmlContent(): string
  {
    return $this->emailContentHtml;
  }

  public function send(): void
  {
    try {
      $this->mail->addAddress($this->getRecipientEmail());
      $this->mail->Subject = $this->getSubject();
      $this->mail->Body    = $this->getHtmlContent();

      if (!empty($this->replyTo)) {
        $this->mail->addReplyTo($this->replyTo, $this->replyToName);
      }
      $this->mail->send();
    } catch (\Exception $e) {
      throw new ErrorException('Erro ao enviar e-mail: ' . $e->getMessage());
    }
    if ($this->saveLog) {
      $emailMessage = MailMessageFactory::add([$this->getRecipientEmail()], $this->getSubject(), $this->getHtmlContent());
      MailMessageFactory::saveLog($emailMessage->getId(), $this->log);
    }
  }

  /**
   * Adiciona imagens ao corpo do e-mail
   *
   * @param string $imagePath
   * @param string $imageId
   * @return SendMailService
   */
  public function addImageToEmail(string $imagePath, string $imageId)
  {
    $this->mail->addEmbeddedImage($imagePath, $imageId);
    return $this;
  }
  /**
   * Adiciona anexos ao corpo do e-mail
   *
   * @param string $attachmentPath
   * @param string $attachmentName
   * @return SendMailService
   */
  public function addAttachmentToEmail(string $attachmentPath, string $attachmentName)
  {
    $this->mail->addAttachment($attachmentPath, $attachmentName);
    return $this;
  }
}
