<?php

namespace App\Model\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends AbsEntity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $createdTm;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $updatedTm;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $isDeleted;


    public function __construct() {
        $this->createdTm = new DateTime();
        $this->updatedTm = $this->createdTm;
        $this->isDeleted = 0;

        Predis\Client();
    }

    /**
     * @param $id
     */
    public function setId($id) : void {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId() : int {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) : void {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * @param DateTime $createdTm
     */
    public function setCreatedTm(DateTime $createdTm) : void {
        $this->createdTm = $createdTm;
    }

    /**
     * @return DateTime
     */
    public function getCreatedTm() : DateTime {
        return $this->createdTm;
    }

    /**
     * @param DateTime $updatedTm
     */
    public function setUpdatedTm(DateTime $updatedTm) : void {
        $this->updatedTm = $updatedTm;
    }

    /**
     * @return int
     */
    public function getIsDeleted() : int {
        return $this->isDeleted;
    }

    /**
     * @param int $isDeleted
     */
    public function setIsDeleted(int $isDeleted) : void {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedTm() : DateTime{
        return $this->updatedTm;
    }
}