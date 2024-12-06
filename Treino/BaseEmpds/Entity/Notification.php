<?php

namespace BaseEmpds\Entity;

use BaseEmpds\Model\Interfaces\Entity;
use Geral\Model\Date;
use JsonSerializable;

/**
 * As classes filhas DEVERÃO OBRIGATORIAMENTE ter as seguintes anotações:
 *   Entity, Table 
 * @author Glauco David Laicht
 */
abstract class Notification implements Entity, JsonSerializable
{
    
    /**
     * @Id
     * @Column (type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column (type="string", nullable=false)
     */
    protected $title;

    /**
     * @Column (type="text", nullable=false)
     */
    protected $body;

    /**
     * @Column (type="datetime", nullable=false)
     */
    protected $date;

    public function getId()
    {
        return $this->id;
    }

    public function setId($iId)
    {
        $this->id = $iId;
        return $this;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function getDate($isFormatted = false)
    {
      return $isFormatted ? Date::convDateTimeToString($this->date, Date::DATA_FORMAT) : $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id'    => $this->getId(),
            'title' => $this->getTitle(),
            'body'  => $this->getBody(),
            'date'  => $this->getDate(true)
        ];
    }
}
