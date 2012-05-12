<?php

namespace GreenFrog\Bundle\TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use GreenFrog\Bundle\TodoBundle\Form\TaskType;
use GreenFrog\Bundle\TodoBundle\Entity\Task;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $securityContext = $this->get('security.context');
        $user = $securityContext->getToken()->getUser();
        if(!$securityContext->isGranted('ROLE_USER')) {
            throw new Exception('Fort biddeun !');
        }
        
        //- New task Form : Default to current user
        $task = new Task();
        $task->setUser($user);
        $form = $this->get('form.factory')->create(new TaskType($user), $task);
        $tasks = $this->get('gf.task_manager')->getTasksList($user);

        return array(
            'form' => $form->createView(),
            'tasks' => $tasks,
        );
    }
}
