<?php
namespace EmailQueue\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\Event\Event;
use ArrayObject;
use Cake\Utility\Hash;

class EmailQueuesTable extends Table {

    public function initialize(array $config) {
        $this->setTable('email_queue');
        
        $this->addBehavior('Timestamp');
    }
    
    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary) {
        // Hacer que se devuelvan resultados a la Cakephp 2
        $query->hydrate(false);
        $query->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                
                if (isset($row['template_vars'])) {
                    $row['template_vars'] = json_decode($this->decode($row['template_vars']), true);
                }
                
                $formatted = ['EmailQueue'=>$row];
                return $formatted;
            });
        });
    }

    /**
     * Stores a new email message in the queue
     *
     * @param mixed $to email or array of emails as recipients
     * @param array $data associative array of variables to be passed to the email template
     * @param array $options list of options for email sending. Possible keys:
     *
     * - subject : Email's subject
     * - send_at : date time sting representing the time this email should be sent at (in UTC)
     * - template :  the name of the element to use as template for the email message
     * - layout : the name of the layout to be used to wrap email message
     * - format: Type of template to use (html, text or both)
     * - config : the name of the email config to be used for sending
     *
     * @param array $returnData a reference to get extra values from what happens. So far, the array can be filled with the following data:
     * 
     * - attachments_ids: an array with the ids of the attachments just saved
     * 
     * @return void
     */
    public function enqueue($to, array $data, $options = array(), array &$returnData = null) {
        $defaults = array(
            'subject' => '',
            'send_at' => gmdate('Y-m-d H:i:s'),
            'template' => 'default',
            'layout' => 'default',
            'format' => 'both',
            'template_vars' => $data,
            'config' => 'default',
            'attachments' => array(),
            'savepath' => './tmp/files/',
            'lang' => Configure::read('default_language')
        );

        $email = $options + $defaults;
        
        /*$attachments = array(); 
        if(isset ($options['attachments']) && $options['attachments'] != null && is_array($options['attachments']) && !empty ($options['attachments'])) {
            foreach ($options['attachments'] as $key => $value) {
                $attachments[] = array('filename'=>$key, 'contents'=>$value['contents'], 'mimetype'=>$value['mimetype']);
            }
        }*/
        
        $datasource = ConnectionManager::get('default');
        $datasource->begin();

        $OK = true;
        
        if (!is_array($to)) $to = array($to);
        foreach ($to as $t) {
            $email['to_inbox'] = $t;
            
            $email = $this->newEntity($email);
            
            $savedEmail = $this->save($email);
            
            $OK = $savedEmail?true:false;
            
            /*if($OK) {
                $emailId = $savedEmail->id;
            
                $attachmentModel = new EmailAttachment();
                
                if($returnData != null) $returnData['attachments_ids'] = array();
                foreach ($attachments as $a) {
                    $a = array('EmailAttachment'=>$a);
                    $a['EmailAttachment']['email_queue_id'] = $emailId;

                    $attachmentModel->create();
                    $OK = $attachmentModel->save($a);
                    
                    if($returnData != null) $returnData['attachments_ids'][] = $attachmentModel->getLastInsertID();
                    
                    if(!$OK) break;
                }
            }*/
            
            if(!$OK) break;
            
        }
        
        if($OK) $datasource->commit();
        else $datasource->rollback();
        
        return $OK;
    }

    /**
     * Returns a list of queued emails that needs to be sent
     *
     * @param integer $size, number of unset emails to return
     * @return array list of unsent emails
     * @access public
     */
    public function getBatch($size = 10) {
        $datasource = ConnectionManager::get('default');
        $datasource->begin();
        
        $emails = $this->find()
        ->where([
            'sent' => false,
            'send_tries <=' => 3,
            'send_at <=' => gmdate('Y-m-d H:i:s'),
            'locked' => false])
        ->order(['created' => 'ASC'])->toList();

        if (!empty($emails)) {
            $ids = Hash::extract($emails, '{n}.EmailQueue.id');            
            $this->updateAll(['locked' => true], ['id IN' => $ids]);
        }

        $datasource->commit();
        return $emails;
    }

    /**
     * Releases locks for all emails in $ids
     *
     * @return void
     * */
    public function releaseLocks($ids) {
        $this->updateAll(['locked' => false], ['id IN' => $ids]);
    }

    /**
     * Releases locks for all emails in queue, useful for recovering from crashes
     *
     * @return void
     * */
    public function clearLocks() {
        $this->updateAll(['locked' => false]);
    }

    /**
     * Marks an email from the queue as sent
     *
     * @param string $id, queued email id
     * @return boolean
     * @access public
     */
    public function success($id) {
        $this->updateAll(['sent' => true], ['id'=>$id]);
    }

    /**
     * Marks an email from the queue as failed, and increments the number of tries
     *
     * @param string $id, queued email id
     * @return boolean
     * @access public
     */
    public function fail($id) {
        $this->id = $id;
        $tries = $this->field('send_tries');
        return $this->saveField('send_tries', $tries + 1);
    }

    /**
     * Converts array data for template vars into a json serialized string
     *
     * @param array $options
     * @return boolean
     * */
    /*public function beforeSave($event, $entity, $options) {
        debug($entity->template_vars);
        
        if ($entity->template_vars) {
            $entity->template_vars = json_encode($this->encode($entity->template_vars));
        }
        
        debug($entity->template_vars);
    }*/
    
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        if (isset($data['template_vars'])) {
            $data['template_vars'] = json_encode($this->encode($data['template_vars']));
        }
    }
    

    /**
     * Converts template_vars back into a php array
     *
     * @param array $results
     * @param boolean $primary
     * @return array
     * */
    public function afterFind($results, $primary = false) {
        if (!$primary) {
            return parent::afterFind($results, $primary);
        }

        foreach ($results as &$r) {
            if (!isset($r[$this->alias]['template_vars'])) {
                return $results;
            }
            $r[$this->alias]['template_vars'] = json_decode($this->decode($r[$this->alias]['template_vars']), true);
        }

        return $results;
    }
    
    private function encode(array &$what) {
        foreach ($what as &$w) {
            if(!is_array($w) && is_string($w)) $w = utf8_encode(mb_convert_encoding($w, "HTML-ENTITIES", "UTF-8,ISO-8859-1"));
            else if(is_array($w))$this->encode($w);
        }
        return $what;
    }
    
    private function decode($what) {
        return utf8_decode($what);
    }
}