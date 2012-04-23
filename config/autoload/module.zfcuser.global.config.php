<?php
return array(
    'zfcuser' => array(
        'use_redirect_parameter_if_present' => true,
        'login_after_registration' => true,
    ),
    'di'=> array(
        'instance'=>array(
            'alias'=>array(
                // OTHER ELEMENTS....
                'recaptcha_element' => 'Zend\Form\Element\Captcha'
            ),
            'recaptcha_element' => array(
                'parameters' => array(
                    'spec' => 'captcha',
                    'options'=>array(
                        'label'      => '',
                        'required'   => true,
                        'order'      => 500,
                        'captcha'    => array(
                            'captcha' => 'ReCaptcha',
                            'privkey' => '6Lc57s8SAAAAAIDQlFi0AJHPDV5xSmLCvYAU9uZL',
                            'pubkey'  => '6Lc57s8SAAAAAKa1i32sZpluBmzoBOEA9ge_3d-V',
                        ),
                    ),
                ),
            ),
            'ZfcUser\Form\Register' => array(
                'parameters' => array(
                    'captcha_element'=>'recaptcha_element',
                ),
            ),

            'zfcuser' => array(
                'parameters' => array(
                    'loginForm'    => 'Application\Form\Login',
                ),
            ),

            'ZfcUser\View\Helper\ZfcUserLoginWidget' => array(
                'parameters' => array(
                    'loginForm'      => 'Application\Form\Login',
                ),
            ),
        ),
    ),
);
