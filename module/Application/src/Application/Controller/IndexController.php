<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{
    /**
     * @param string $query
     * @return \Zend\Feed\Reader\Reader
     */
    private function getRss($query)
    {
        $reader = \Zend\Feed\Reader\Reader::import('http://torrentz.eu/feed');
        \Zend\Feed\Reader\Reader::getHttpClient()
            ->setParameterGet(array('q' => $query));

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
        return $this->getRequest()->query()->get('query');
    }

    /**
     * @return ViewModel
     */
    private function getViewModel()
    {
        $query = $this->getQuery();
        if($query != null)
        {
            return new ViewModel(array(
                'feed' => $this->getRss($query),
                'query' => $query
            ));
        }

        return new ViewModel(array('query' => $query));
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
