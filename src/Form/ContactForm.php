<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Mailer\Email;

class ContactForm extends Form {

    protected function _buildSchema(Schema $schema) {
        return $schema->addField('name', 'string')
                        ->addField('email', ['type' => 'string'])
                        ->addField('body', ['type' => 'text']);
    }

    protected function _buildValidator(Validator $validator) {
        return $validator->add('name', 'length', [
                    'rule' => ['minLength', 1],
                    'message' => __d('errors', 'El nombre es obligatorio')
                ])->add('email', 'format', [
                    'rule' => 'email',
                    'message' => __d('errors', 'Teclee un email válido'),
        ]);
    }

    protected function _execute(array $data) {
        if(ini_get('intl.default_locale') == 'es') {
            $to = 'maylen@pickocar.com';
        } else {
            $to = 'martin@pickocar.com';
        }
        
        $Email = new Email('hola');
        $OK = $Email->to($to)->subject('Nuevo contacto')->send($data['name'].' | '.$data['email'].' | '.$data['body']);
        
        return $OK;
    }

}
