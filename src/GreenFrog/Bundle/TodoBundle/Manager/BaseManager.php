<?php
// TODO : remove this file if useless (we have only 1 manager)
namespace GreenFrog\Bundle\TodoBundle\Manager;

abstract class BaseManager
{
    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}