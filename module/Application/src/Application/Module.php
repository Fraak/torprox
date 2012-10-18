<?php

namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Loader\StandardAutoloader;
use Zend\Loader\AutoloaderFactory;
use Zend\Http\Request as HttpRequest;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    BootstrapListenerInterface
{
    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'form-factory' => function(ServiceLocatorInterface $serviceLocator) {
                    $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
                    $builder = new \DoctrineORMModule\Form\Annotation\AnnotationBuilder($em);
                    return new Form\Factory($builder, new DoctrineEntity($em));
                }
            ),
        );
    }

    /**
     * Does silly hack for hybridauth notice
     *
     * @param EventInterface $e
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        // Make sure some silly ha store var is set to fix notice in bjhauthorize
        /** @var $e \Zend\Mvc\MvcEvent */
        if (!$e instanceof MvcEvent)
            return;

        if (!$e->getRequest() instanceof HttpRequest)
            return;

        if (!session_id())
            session_start();

        if(!isset($_SESSION['HA::STORE']))
        {
            $_SESSION['HA::STORE'] = array();
        }
    }
}