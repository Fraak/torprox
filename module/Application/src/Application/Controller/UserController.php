<?php

namespace Application\Controller;

use Zend\Http\Request as HttpRequest;
use Application\Entity\Search;
use Zend\View\Model\ViewModel;

class UserController extends BaseController
{
    public function settingsAction()
    {
        $request = $this->getHttpRequest();
        $identity = $this->getIdentity();
        $entity = $this->getEntityManager()->find('Application\Entity\Settings', $identity->getId());
        if($entity === null)
        {
            $entity = new \Application\Entity\Settings();
            $entity->setUser($identity);

        }
        $form = $this->getFormFactory()->createForm('Application\Entity\Settings', 'Save');
        $form->bind($entity);

        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $this->getEntityManager()->persist($entity);
                $this->getEntityManager()->flush();
                $this->flashMessenger()->addMessage('Settings saved.');
                return $this->redirect()->toRoute('home');
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function searchStringAddAction()
    {
        $request = $this->getHttpRequest();
        $identity = $this->getIdentity();

        $entity = new Search();
        $entity->setUser($identity);
        $form = $this->getFormFactory()->createForm('Application\Entity\Search');
        $form->bind($entity);

        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $this->getEntityManager()->persist($entity);
                $this->getEntityManager()->flush();
                $this->flashMessenger()->addMessage('Query saved.');
                $url = $this->url()->fromRoute('home') . '?query=' . urlencode($entity->getQuery());
                return $this->redirect()->toUrl($url);
            }
        }

        return $this->notFoundAction();
    }
}
