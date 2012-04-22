<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Zend\EventManager\EventCollection;

class AuthController extends ActionController
{
    /**
     * @return \Facebook
     */
    private function getFacebook()
    {
        return $this->getLocator()->get('facebook');
    }

    public function indexAction()
    {
        $facebook = $this->getFacebook();
        var_dump($facebook->getUser());
        die();
        return new ViewModel(array('user' => $facebook->getUser()));
    }
}
