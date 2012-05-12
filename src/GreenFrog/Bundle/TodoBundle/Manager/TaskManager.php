<?php

namespace GreenFrog\Bundle\TodoBundle\Manager;

use Doctrine\ORM\EntityManager;
use GreenFrog\Bundle\TodoBundle\Entity\Task;

class TaskManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadTask($id) {
        return $this->getRepository()->find($id);
    }

    public function saveTask(Task $task)
    {
        $this->em->persist($task);
        $this->em->flush();
    }

    public function deleteTask(Task $task)
    {
        $this->em->remove($task);
        $this->em->flush();
    }

    public function setEnded(Task $task)
    {
        $this->getRepository()->toggleActive($task);
        $task->setProgress(0);
    }
    
    public function getTasksList($user) {
        return $this->getRepository()->getTasksList($user);
    }

    public function getRepository()
    {
        return $this->em->getRepository('GreenFrogTodoBundle:Task');
    }

}