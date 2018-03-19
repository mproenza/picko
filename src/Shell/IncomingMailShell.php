<?php
namespace App\Shell;

use Cake\Console\Shell;
use App\Util\Mail\MailReader;
use Cake\ORM\TableRegistry;
use App\Model\Entity\SharedTravel;
use Cake\Datasource\ConnectionManager;

class IncomingMailShell extends Shell
{
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
                
                $STTable = TableRegistry::get('SharedTravels');
                
                $request = $STTable->findByToken($requestId);
                
                // Sanity checks
                if($request == null || empty($request)) {
                    echo 'No existe esta solicitud';
                    return;
                }
                
                // TODO: Verificar que la solicitud no este expirada
                
                if($request['SharedTravel']['state'] == SharedTravel::$STATE_CONFIRMED) { // Solo se puede confirmar cuando esta en estado ACTIVATED
                    echo 'La solicitud ya está confirmada'; 
                    return;
                } else if($request['SharedTravel']['state'] != SharedTravel::$STATE_ACTIVATED) { // Solo se puede confirmar cuando esta en estado ACTIVATED
                    echo 'La solicitud no está activada todavía'; 
                    return;
                } 
                
                $datasource = ConnectionManager::get('default');
                $datasource->begin();
                
                $OK = $STTable->confirmRequest($request);
                
                if($OK) $datasource->commit();
                else {
                    // TODO: Enviar notificacion de fallo
                    
                    $datasource->rollback();
                }
            }
        }
        
        
        /*$Email = new Email('hola');
        $Email->to('martin@yotellevocuba.com')->subject('Correo entrante')->send("from: $sender, to: $to, subject: $subject, body: $body");*/
    }
}