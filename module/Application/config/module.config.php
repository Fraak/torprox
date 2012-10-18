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
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'search-string-delete',
                            ),
                            'constraints' => array(
                                'id' => '[0-9]+'
                            ),
                        ),
                    ),
                    'list' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/list',
                            'defaults' => array(
                                'action' => 'search-string',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'base_path' => '/',
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout.phtml',
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
