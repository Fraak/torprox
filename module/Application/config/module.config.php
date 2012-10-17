<?php
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'application-index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'rss' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/rss',
                    'defaults' => array(
                        'controller' => 'application-index',
                        'action'     => 'rss',
                    ),
                ),
            ),
            'settings' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/settings',
                    'defaults' => array(
                        'controller' => 'application-user',
                        'action' => 'settings',
                    ),
                ),
            ),
            'search' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/search',
                    'may_terminate' => false,
                    'defaults' => array(
                        'controller' => 'application-user',
                    ),
                ),
                'child_routes' => array(
                    'add' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'action' => 'search-string-add',
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/delete',
                            'defaults' => array(
                                'action' => 'search-string-delete',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'application-index' => 'Application\Controller\IndexController',
            'application-user' => 'Application\Controller\UserController',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'application_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/Application/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'application_driver',
                ),
            ),
        ),
    ),
);
