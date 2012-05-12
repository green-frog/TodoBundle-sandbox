<?php

namespace GreenFrog\Bundle\TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GreenFrog\Bundle\TodoBundle\Entity\Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="GreenFrog\Bundle\TodoBundle\Repository\TaskRepository")
 */
class Task
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @Assert\NotBlank(message="Title is required")
     * @Assert\MinLength(
     *      limit=3,
     *      message="Title should have at least {{ limit }} characters."
     * )
     * @Assert\MaxLength(140)
     * @ORM\Column(name="title", type="string", length=140)
     */
    private $title;

    /**
     * @var smallint $progress
     *
     * @ORM\Column(name="progress", type="smallint")
     */
    private $progress;

    /**
     * @var boolean $active
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks", cascade={"persist"})
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    protected $user;

    /*
     * Our constructor
     */
    public function __construct()
    {
        $this->progress = 0;
        $this->active = false;
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set progess
     *
     * @param smallint $progress
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Get progress
     *
     * @return smallint 
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * Set user
     *
     * @param GreenFrog\Bundle\TodoBundle\Entity\User $user
     */
    public function setUser(\GreenFrog\Bundle\TodoBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return GreenFrog\Bundle\TodoBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}