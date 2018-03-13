<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace App\Mailer;

use Cake\Datasource\EntityInterface;
use CakeDC\Users\Mailer\UsersMailer;

/**
 * User Mailer
 *
 */
class AppUsersMailer extends UsersMailer
{
    protected function validation(EntityInterface $user)
    {
        parent::validation($user);
        $this->setProfile('hola');
    }

    protected function resetPassword(EntityInterface $user)
    {
        parent::resetPassword($user);
        $this->setProfile('hola');
    }
}
