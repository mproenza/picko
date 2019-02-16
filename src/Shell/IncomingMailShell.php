<?php
namespace App\Shell;

use Cake\Console\Shell;
use App\Util\Mail\MailReader;

class IncomingMailShell extends Shell
{
    public function initialize() {
        parent::initialize();
        $this->loadComponent('SharedTravelActions');
    }
    
    
    public function process() {
        $raw = '';
        $fd = fopen('php://stdin','r');
        while(!feof($fd)){ $raw .= fread($fd,1024); }
        
        
        $parser = new MailReader();
        $parser->readEmail($raw);
        
        $text = $parser->from;
        preg_match('#\<(.*?)\>#', $text, $match);
        $sender = $match[1];
        if($sender == null || strlen($sender) == 0) $sender = $text;
        
        $text = $parser->to;
        preg_match('#\<(.*?)\>#', $text, $match);
        $to = $match[1];
        if($to == null || strlen($to) == 0) $to = $text;
        $to = strtolower($to);
        
        $subject = trim($parser->subject);
        
        $body = /*h(*/$parser->body/*)*/; // h() para escapar los caracteres html
        
        if($to === 'compartido@pickocar.com') {
            $parseOK = preg_match('#\[\[(.+?)\]\]#is', $subject, $matches);
            if($parseOK) {
                $requestId = $matches[1];
                
                $this->out($requestId);
                
                $this->SharedTravelActions->confirm($requestId);
            }
        }
        
        
        /*$Email = new Email('hola');
        $Email->to('martin@yotellevocuba.com')->subject('Correo entrante')->send("from: $sender, to: $to, subject: $subject, body: $body");*/
    }
}