<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Freek
 * Date: 23-4-12
 * Time: 18:38
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Form;

class Login extends \ZfcUser\Form\Login
{
    public function init()
    {
        $this->addElement('hidden', 'redirect', array(
            'ignore'     => true,
            'decorators' => array('ViewHelper'),
            'value' => '/'
        ));
        parent::init();
    }
}
