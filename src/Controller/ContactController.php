<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Form\ContactForm;
use Cake\Event\Event;

class ContactController extends AppController {
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index']);
        
        $this->viewBuilder()->setLayout('mobirise/default');
    }

    public function index() {
        $contact = new ContactForm();
        if ($this->request->is('post')) {
            if ($contact->execute($this->request->getData())) {
                $this->Flash->success(__d('errors', 'Gracias por el mensaje. Te responderemos muy pronto.'));
            } else {
                $this->Flash->error( __d('errors', 'Ocurrió un error enviando tu mensaje hacia nosotros.').' '.__('Intenta de nuevo.') );
            }
        }
        $this->set('contact', $contact);
    }
}