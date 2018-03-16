<?php
namespace App\Error;

use Cake\Core\Exception\Exception;

class ExpiredLinkException extends Exception {
    
    public function __construct($message = null, $code = 404) {
        if (empty($message)) {
            $message = __d('error', 'Enlace Expirado');
        }
        parent::__construct($message, $code);
    }
}

?>