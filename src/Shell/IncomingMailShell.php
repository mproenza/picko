<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Mailer\Email;

class IncomingMailShell extends Shell
{
    public function process() {
        $raw = '';
        $fd = fopen('php://stdin','r');
        while(!feof($fd)){ $raw .= fread($fd,1024); }
        
        $Email = new Email('hola');
        $Email->to('martin@yotellevocuba.com')->subject('Correo entrante')->send($raw);
    }
}
