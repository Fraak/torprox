<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Zend\Http\Request as HttpRequest;

class BaseController extends AbstractActionController
{
    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    /**
     * @return \Application\Form\Factory
     */
    protected function getFormFactory()
    {
        return $this->getServiceLocator()->get('form-factory');
    }

    /**
     * @return \ZfcUser\Entity\User
     * @throws \RuntimeException
     */
    protected function getIdentity()
    {
        if(!$this->hasIdentity())
        {
            throw new \RuntimeException('User not logged in');
        }

        return $this->zfcUserAuthentication()->getIdentity();
    }

    /**
     * @return bool
     */
    protected function hasIdentity()
    {
        return $this->zfcUserAuthentication()->hasIdentity();
    }

    /**
     * @return \Application\Entity\Settings
     */
    protected function getUserSettings()
    {
        $user = $this->getIdentity();
        $settings = $this->getEntityManager()->find('Application\Entity\Settings', $user->getId());
        if($settings === null)
        {
            $settings = new \Application\Entity\Settings();
            $settings->setUser($user);
        }

        return $settings;
    }

    /**
     * @return HttpRequest
     */
    protected function getHttpRequest()
    {
        $request = $this->getRequest();
        if(!$request instanceof HttpRequest)
        {
            throw new \RuntimeException('Can only handle http requests');
        }

        return $request;
    }
}
