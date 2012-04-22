<?php
return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'FacebookBundle',
        'Application',
    ),
    'module_listener_options' => array( 
        'config_cache_enabled' => getenv('ENVIRONMENT') == 'production',
        'cache_dir'            => 'data/cache',
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
