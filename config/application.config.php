<?php
return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',

        'ZfcBase',
        'ZfcUser',
        'ZfcUserDoctrineORM',
        'ScnSocialAuth',
        'BjyAuthorize',

        'DluTwBootstrap',
        'WfkSncSocialAuthDoctrineORM',

        'WfkLayout',
        'Application',
    ),
    'module_listener_options' => array( 
        'config_cache_enabled' => false,
        'cache_dir'            => 'data/cache',
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);