<?php

namespace BaseEmpds\Entity;

use BaseEmpds\Model\Interfaces\Entity;
use JsonSerializable;

/**
 * As classes filhas DEVERÃO OBRIGATORIAMENTE ter as seguintes anotações:
 *   Entity, Table 
 * @author Glauco David Laicht
 */
abstract class NotificationDestination implements Entity, JsonSerializable
{

    /**
     * @Id
     * @Column (type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Notification")
     * @JoinColumn(name="id_notification", referencedColumnName="id", nullable=true)
     */
    protected $notification;

    /**
     * @Column(type="boolean", nullable=false)
     */
    private $read = false;

    /**
     * @Column(type="string", nullable=false)
     */
    private $email;

    public function getId()
    {
        return $this->id;
    }

    public function setId($iId)
    {
        $this->id = $iId;
        return $this;
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function setNotification($notification)
    {
        $this->notification = $notification;
        return $this;
    }
    
    public function isRead()
    {
        return $this->read;
    }

    public function setRead($read)
    {
        $this->read = $read;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id'           => $this->getId(),
            'notification' => $this->getNotification(),
            'read'         => $this->isRead(),
            'email'        => $this->getEmail()
        ];
    }
}
