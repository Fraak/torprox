<?php
return array(
    'navigation' => array(
        'default' => array(
            'account' => array(
                'label' => 'Account',
                'route' => 'user',
                'resource' => 'user-config',
                'privilege' => 'edit',
                'pages' => array(
                    'settings' => array(
                        'label' => 'Settings',
                        'route' => 'settings',
                    ),
                    'change-password' => array(
                        'label' => 'Change Password',
                        'route' => 'zfcuser/changepassword',
                    ),
                ),
            ),

            'stored' => array(
                'label' => 'Stored',
                'route' => 'search/list',
                'resource' => 'user-config',
                'privilege' => 'edit',
            ),
        ),
    ),
);