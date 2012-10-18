<?php

namespace Application\Controller;

use Guzzle\Http\Client;
use Zend\Http\Request as HttpRequest;
use Application\Entity\Search;
use Zend\View\Model\ViewModel;

class UserController extends BaseController
{
    /**
     * @return \Application\Entity\Search[]
     */
    protected function getUserQueries()
    {
        $results = $this->getEntityManager()
            ->createQuery('SELECT e FROM Application\Entity\Search e WHERE e.user = :user ORDER BY e.query')
            ->setParameter('user', $this->getIdentity())
            ->getResult();

        // Add result to search
        $client = new Client();

        $searchAddition = $this->getUserSettings()->getSearchAddition();
        $searches = array();

        foreach($results as $key => $result)
        {
            if($result->getQuery() === '') continue;
            $searches[$key] = $client->get('http://torrentz.eu/feedA?q=' . urlencode(trim($result->getQuery() . ' ' . $searchAddition)));
        }

        $responses = $client->send($searches);

        /** @var $response \Guzzle\Http\Message\Response */
        foreach($responses as $key => $response)
        {
            $xml = new \SimpleXMLElement($response->getBody(true));
            $result = count($xml->xpath('/rss/channel/item'));
            $results[$key]->setResult($result);
        }

        return $results;
    }

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
        /** @var $form \Zend\Form\Form */
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
                return $this->redirect()->toRoute('search/list');
            }
            else
            {
                $text = '<ul>';
                foreach($form->getMessages() as $element => $messages)
                {
                    foreach($messages as $messageText)
                    {
                        $text .= '<li>' . $messageText . '</li>';
                    }
                }
                $text .= '</ul>';
                $this->flashMessenger()->addMessage($text);
                return $this->redirect()->toRoute('search/list');
            }
        }

        return $this->notFoundAction();
    }

    public function searchStringAction()
    {
        $viewModel = $this->getViewModel();
        $viewModel->setVariable('user_queries', $this->getUserQueries());
        return $viewModel;
    }

    public function searchStringDeleteAction()
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->delete('Application\Entity\Search', 'e')
            ->andWhere('e.user = :user')
            ->andWhere('e.id = :id')
            ->setParameter('user', $this->getIdentity())
            ->setParameter('id', $this->getEvent()->getRouteMatch()->getParam('id'));

        $query->getQuery()->execute();
        return $this->redirect()->toRoute('search/list');
    }
}