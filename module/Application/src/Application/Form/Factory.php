<?php
namespace Application\Form;

use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Stdlib\Hydrator\HydratorInterface;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;

class Factory
{
    /**
     * @var AnnotationBuilder
     */
    protected $formBuilder;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @param AnnotationBuilder $formBuilder
     */
    public function __construct(AnnotationBuilder $formBuilder, HydratorInterface $hydrator = null)
    {
        $this->formBuilder = $formBuilder;
        $this->hydrator = $hydrator;
    }

    /**
     * @param string $entityClass
     * @return \Zend\Form\Form
     */
    public function createForm($entityClass, $submitValue = 'Submit')
    {
        $form = $this->formBuilder->createForm($entityClass);
        $form->setAttribute('method', 'post');
        $form->setHydrator($this->hydrator);

        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => $submitValue,
                'id' => 'submit',
            ),
        ));

        return $form;
    }
}