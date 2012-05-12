<?php

namespace GreenFrog\Bundle\TodoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class TaskType extends AbstractType
{
    private $user;
    public function __construct($user) {
        $this->user = $user;
    }
    public function buildForm(FormBuilder $builder, array $options)
    {
        $user = $this->user;
        //- Implements bootstrap class for top nav bar @ title
        $builder->add('title', null, array('attr' => array(
                    'class' => 'search-query span2',
                    'placeholder' => 'Add a new task'
                )));
        //- And if we are admin, we can choose mr task's user
        if($user->hasRole('ROLE_SUPER_ADMIN')) {
            $builder->add('user', 'entity', array(
                'class' => 'GreenFrogTodoBundle:User',
                'query_builder' => function(EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.id', 'DESC');
                },
                'data' => $user,
                'multiple' => false,
                'expanded' => false,
                'attr' => array(
                    'class' => 'select-navbar-hook'
                )
            ));
        }
    }

    // Todo : remove, its useless
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'GreenFrog\Bundle\TodoBundle\Entity\Task',
        );
    }

    public function getName()
    {
        return 'Task';
    }
}