<?php

namespace GreenFrog\Bundle\TodoBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
    * @ORM\OneToMany(targetEntity="Task", mappedBy="user", cascade={"remove", "persist"})
    * @ORM\OrderBy({"active" = "ASC", "progress" = "DESC"})
    */
    protected $tasks;

    /*
     * Our constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add tasks
     *
     * @param GreenFrog\Bundle\TodoBundle\Entity\Task $tasks
     */
    public function addTask(\GreenFrog\Bundle\TodoBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;
    }

    /**
     * Get tasks
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
    * Set tasks
    *
    * @param \Doctrine\Common\Collections\Collection $tasks
    */
    public function setTask(\Doctrine\Common\Collections\Collection $tasks)
    {
        $this->tasks = $tasks;
    }
    
    public function __toString() {
        return $this->getUsername();
    }
}