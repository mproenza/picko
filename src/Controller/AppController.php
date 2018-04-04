<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use App\Model\Entity\SharedTravel;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $helpers = array(
        'Html' => array(
            'className' => 'EnhancedHtml'
        ), 
        'Form' => array(
            'className' => 'BootstrapForm'
		)
	);

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        
        //$this->loadComponent('Auth');        
        $this->loadComponent('CakeDC/Users.UsersAuth');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        // Note: These defaults are just to get started quickly with development
        // and should not be used in production. You should instead set "_serialize"
        // in each action as required.
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        
        $this->_setPageTitle();
    }
    
    
    
    private function _setPageTitle() {
        $defaultTitle = $this->_getPageTitle('default');        
        $page_title = $defaultTitle['title'];
        $page_description = $defaultTitle['description'];
        
        $key = $this->request->getParam('controller').'.'.$this->request->getParam('action'); 
        $partialTitle = $this->_getPageTitle($key);
        
        if($partialTitle != null) {
            if($this->request->params['controller'] === 'pages') {
                if(isset($partialTitle[$this->request->params['pass'][0]])) {
                    $page_title = $partialTitle[$this->request->params['pass'][0]]['title'];
                    if(isset ($partialTitle[$this->request->params['pass'][0]]['description'])) $page_description = $partialTitle[$this->request->params['pass'][0]]['description'];
                }
                    
            } else {
                $page_title = $partialTitle['title'];
                if(isset ($partialTitle['description'])) $page_description = $partialTitle['description'];
            }
        }
        $this->set('page_title', $page_title);
        $this->set('page_description', $page_description);
    }
    
    private function _getPageTitle($key) {
        $pageTitles = array(
            'default' =>array('title'=>__d('meta', 'Taxi barato en Cuba'), 'description'=>__d('meta', '...')),
            
            // Access to all
            'pages.display' =>array(
                'contact'=>array('title'=>__d('meta', 'Contactar'), 'description'=>__d('meta', 'Contáctanos para cualquier pregunta o duda sobre cómo conseguir un taxi para moverte por Cuba usando YoTeLlevo')), 
                'faq'=>array('title'=>__d('meta', 'Preguntas Frecuentes'), 'description'=>__d('meta', 'Preguntas y respuestas sobre cómo conseguir un taxi para moverte por Cuba usando YoTeLlevo')),
                'testimonials'=>array('title'=>__d('meta', 'Testimonios de viajeros sorprendentes en Cuba'), 'description'=>__d('meta', 'Testimonios de viajeros que contrataron choferes con YoTeLlevo, Cuba')),
                'catalog-drivers-cuba'=>array('title'=>__d('meta', 'Choferes en Cuba: fotos y testimonios de viajeros'))),

            'SharedTravels.home' =>array('title'=>__d('meta', 'Taxi compartido en Cuba. Viajes hasta {0} y otros', 'La Habana, Viñales, Trinidad, Varadero'), 'description'=>__d('meta', 'Llega a destinos como {0} y otros por un buen precio usando nuestra amplia red de taxis compartidos', 'La Habana, Viñales, Trinidad, Varadero')),
            
            'SharedTravels.book' =>array(
                'title'=>function($viewVars, $queryParams) {
                    $modalityCode = $queryParams['s'];
                    $modality = SharedTravel::$modalities[$modalityCode];
                    
                    return __d('meta', 'Taxi compartido desde {0} hasta {1}', $modality['origin'], $modality['destination']);
                }, 
                'description'=>function($viewVars, $queryParams) {
                    $modalityCode = $queryParams['s'];
                    $modality = SharedTravel::$modalities[$modalityCode];
                    
                    return __d('meta', 'Reserva un taxi para ir de {0} a {1} por un precio de {2} cuc por asiento. Sólo 4 pasajeros en un auto moderno con aire acondicionado y mucho confort.', $modality['origin'], $modality['destination'], $modality['price']);
                }
            ),
            'SharedTravels.thanks' =>array('title'=>__d('meta', 'Gracias por su solicitud'), 'description'=>__d('meta', '...')),
            'SharedTravels.activate' =>array('title'=>__d('meta', 'Activar solicitud'), 'description'=>__d('meta', '...')),
            'SharedTravels.view' =>array('title'=>__d('meta', 'Datos de tu solicitud'), 'description'=>__d('meta', '...')),
              
            // ADMIN
            'SharedTravels.index' =>array('title'=>'Compartidos'),
            'SharedTravels.admin' =>array('title'=>'Admin'),
        );
        
        if(isset ($pageTitles[$key])) return $pageTitles[$key];
        
        return null;
    }
    
    
}
