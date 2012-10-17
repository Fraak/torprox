<?php
return array(
    'bjyauthorize' => array(
        'identity_provider' => 'BjyAuthorize\Provider\Identity\ZfcUserDoctrine',
        'default_role' => 'guest',
        'role_providers' => array(
            'BjyAuthorize\Provider\Role\Config' => array(
                'guest' => array(),
                'user'  => array(),
            ),

            'BjyAuthorize\Provider\Role\Doctrine' => array(
                'table'             => 'user_role',
                'role_id_field'     => 'role_id',
                'parent_role_field' => 'parent',
            ),
        ),

        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'user-config' => array(),
            ),
        ),

        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    array(array('user'), 'user-config', 'edit')
                ),
            ),
        ),
    ),
);