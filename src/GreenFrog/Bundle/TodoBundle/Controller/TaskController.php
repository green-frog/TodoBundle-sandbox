<?php

namespace GreenFrog\Bundle\TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use GreenFrog\Bundle\TodoBundle\Form\TaskType;
use GreenFrog\Bundle\TodoBundle\Entity\Task;

/**
 * @Route("/task")
 */
class TaskController extends Controller
{
    private $task;
    private $tm;
    /**
     * @Route("/add", name="task_add")
     * @Template()
     */
    public function taskAddAction() {
        $request = $this->getRequest();
        
        //- Our vars : User, Task & Form
        $securityContext = $this->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $task = new Task();
        $form = $this->get('form.factory')->create(new TaskType($user), $task);
        
        if($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                //- Add task to current user if nothing in
                $postData = $request->request->get('Task');
                if(!isset($postData['user'])) {
                    $task->setUser($user);
                }

                //- Insert
                $this->get('gf.task_manager')->saveTask($task);

                //- Sending some flash
                $this->get('session')->setFlash('success', sprintf('Task " <b>%s</b> " added', $task->getTitle()));
            }
        } else {
            throw new \Exception('POST please !');
        }
        
        //- Ok, lets move to our home
        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/end/{id}", name="task_end", options={"expose"=true})
     * @Template("GreenFrogTodoBundle:Task:blank.html.twig")
     */
    public function taskEndAction() {
        if($this->isAllowed()) {
            //- Here we process logic
            $this->tm->setEnded($this->task);
            $this->tm->saveTask($this->task);
        } else {
            //- Render a fake 500 error
            throw new \Exception('Error');
        }
        return array('value' => "Success");
    }

    /**
     * @Route("/edit", name="task_edit", options={"expose"=true})
     * @Template("GreenFrogTodoBundle:Task:blank.html.twig")
     */
    public function taskEditAction() {
        if($this->isAllowed()) {
            //- Here we process logic
            $value = $this->getRequest()->get('value');
            $this->task->setTitle($value);
            $this->tm->saveTask($this->task);
        } else {
            //- Render a fake 500 error
            throw new \Exception('Error');
        }

        return array('value' => $value);
    }

    /**
     * @Route("/del/{id}", name="task_del", options={"expose"=true})
     * @Template("GreenFrogTodoBundle:Task:blank.html.twig")
     */
    public function taskDelAction() {
        if($this->isAllowed()) {
            //- Here we process logic
            $this->tm->deleteTask($this->task);
        } else {
            //- Render a fake 500 error
            throw new \Exception('Error');
        }
        return array('value' => "Success");
    }

    private function isAllowed($method = 'GET') {
        $return = false;
        $request = $this->getRequest();

        //- Make it only avaible in ajax
        if(!$request->isXmlHttpRequest()) {
            return new \Exception('Error');
        }
        //- Lets be sure user can process and task exists
        $securityContext = $this->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $this->tm = $this->get('gf.task_manager');
        $id = $method == 'GET' ? $request->get('id') : substr($request->get('id'), 10, strlen($request->get('id'))-10);
        $task = $this->tm->loadTask($id);
        if($task) {
            if(($task->getUser() === $user) || $user->hasRole('ROLE_SUPER_ADMIN')) {
                $return = true;
            }
        }
        $this->task = $task;
        return $return;
    }
}
