<?php

namespace BaseEmpds\Model\Exception;

abstract class BaseDoctrineException extends BaseException
{

    /**
     * @var \Doctrine\DBAL\Exception\ServerException $originalException
     */
    protected $originalException;

    public function __construct($exception)
    {
        $this->originalException = $exception;
        $message = $this->getMessageException();
        $code    = $this->getCodeException();
        parent::__construct($message, $code);
    }

    /**
     * Retorna a mensagem da Exception
     */
    protected abstract function getMessageException();

    /**
     * Retorna o código da Exception
     * @return integer|string|null
     */
    protected function getCodeException()
    {
        return $this->originalException->getCode();
    }
}
