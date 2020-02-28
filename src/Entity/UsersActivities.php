<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersActivities
 *
 * @ORM\Table(name="UsersActivities")
 * @ORM\Entity(repositoryClass="App\Repository\UsersActivitiesRepository")
 */
class UsersActivities
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="object", type="string", length=255,nullable=true)
     */
    private $object;

    /**
     * @var int
     *
     * @ORM\Column(name="objectID", type="integer",nullable=true)
     */
    private $objectID;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255,nullable=true)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="string", length=255,nullable=true)
     */
    private $info;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime",nullable=true)
     */
    private $date;

     /**
      * @ORM\ManyToOne(targetEntity="App\Entity\Users")
	 * @ORM\JoinColumn(nullable=true)
      */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(?string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getObjectID(): ?int
    {
        return $this->objectID;
    }

    public function setObjectID(?int $objectID): self
    {
        $this->objectID = $objectID;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
