<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends BaseController
{
    /**
     * @param string $query
     * @return \Zend\Feed\Reader\Reader
     */
    private function getRss($query)
    {
        if($this->hasIdentity())
        {
            $query .= ' ' . $this->getUserSettings()->getSearchAddition();
        }
        $query = trim($query);
        $client = new \Zend\Http\Client('http://torrentz.eu/feedA');
        $client
            ->getRequest()
            ->getQuery()
            ->set('q', $query);

        $reader = \Zend\Feed\Reader\Reader::importString($client->send()->getBody());

        /** @var \Zend\Feed\Reader\Entry\Rss $entry */
        foreach($reader as $entry)
        {
            /** @var \DOMDocument $dom */
            preg_match('/Size: ([0-9]* [A-Z]*) Seeds: ([0-9,]*) Peers: ([0-9,]*) Hash: ([0-9a-z]*)/', $entry->getDescription(), $matches);

            $dom = $entry->getDomDocument();
            $element = $entry->getElement();
            $element->appendChild($dom->createElement('size', $matches[1]));
            $element->appendChild($dom->createElement('seeds', $matches[2]));
            $element->appendChild($dom->createElement('peers', $matches[3]));

            $closure = $dom->createElement('enclosure');
            $closure->setAttribute('url', 'magnet:?xt=urn:btih:'.strtoupper($matches[4]).'&dn='.$entry->getTitle());
            $closure->setAttribute('type', 'application/x-bittorrent');
            $element->appendChild($closure);
        }

        return $reader;
    }

    /**
     * @return string
     */
    private function getQuery()
    {
        return $this->getRequest()->getQuery()->get('query');
    }

    /**
     * @return ViewModel
     */
    protected function getViewModel()
    {
        $viewModel = parent::getViewModel();

        $query = $this->getQuery();
        $viewModel->setVariable('query', $query);
        if($query !== null)
        {
            $viewModel->setVariable('feed', $this->getRss($query));
        }

        return $viewModel;
    }

    public function indexAction()
    {
        return $this->getViewModel();
    }

    public function rssAction()
    {
        $this->getResponse()->headers()->addHeaderLine('content-type', 'application/xml');
        $model = $this->getViewModel();
        $model->setTerminal(true);
        return $model;
    }
}
