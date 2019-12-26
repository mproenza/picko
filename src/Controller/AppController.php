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
    use \Muffin\Footprint\Auth\FootprintAwareTrait;
    
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

        $this->_setPageMeta();


        // Enviar Auth hacia la vista para poderla usar de manera mas facil
        $this->set('Auth', $this->Auth);
    }



    private function _setPageMeta() {
        $defaultTitle = $this->_getPageMeta('default');
        $meta = $defaultTitle;

        $key = $this->request->getParam('controller').'.'.$this->request->getParam('action');
        
        $partialMeta = $this->_getPageMeta($key);
        if($partialMeta != null) {
            if($this->request->getParam('controller') === 'Pages') {
                if(isset($partialMeta[$this->request->getParam('pass')[0]])) {
                    $meta = $partialMeta[$this->request->getParam('pass')[0]];
                }
            } else {
                $meta = $partialMeta;
            }
        }
        
        $this->set('meta', $meta);
    }

    private function _getPageMeta($key) {
        $pageTitles = ['default' =>array('title'=>__d('meta', 'Taxi compartido en Cuba - {0} y otros', 'La Habana, Viñales, Trinidad, Varadero'), 'description'=>__d('meta', 'PickoCar es un servicio de taxi compartido en Cuba con excelentes precios y rutas que conectan {0} y otros', 'La Habana, Viñales, Trinidad, Varadero')),

            // HOMEPAGE
            'SharedTravels.home' => [
                'title'=>__d('meta', 'Taxi compartido en Cuba - {0} y otros', 'La Habana, Viñales, Trinidad, Varadero'), 
                'description'=>__d('meta', 'PickoCar es un servicio de taxi compartido en Cuba con excelentes precios y rutas que conectan {0} y otros', 'La Habana, Viñales, Trinidad, Varadero, Cayo Guillermo'),
                'hreflang'=>true
                ],

            // PAGES
            'Pages.display' =>array(
                'about'=>array(
                    'title'=>__d('meta', 'Sobre Nosotros'), 
                    'description'=>__d('meta', 'Conoce lo que hacemos en PickoCar, nuestro servicio de taxi compartido en Cuba que conecta varios destinos'),
                    'hreflang'=>true
                ),
                'faq'=>array(
                    'title'=>__d('meta', 'Preguntas Frecuentes'), 
                    'description'=>__d('meta', 'Preguntas frecuentes y respuestas sobre nuestro servicio de taxi en Cuba'),
                    'hreflang'=>true
                ),
                'taxi-fleet'=>array(
                    'title'=>__d('meta', 'Flota de taxi en Cuba'), 
                    'description'=>__d('meta', 'Fotos de los autos que usamos en PickoCar para trasladar a nuestros clientes en Cuba'),
                    'hreflang'=>true
                ),
                'havana-cienfuegos-trinidad'=>array(
                    'title'=>__d('meta', 'Taxi La Habana > Cienfuegos > Trinidad el mismo día'), 
                    'description'=>__d('meta', 'Reserva traslado económico La Habana > Trinidad con visita a Cienfuegos por sólo $99 total para 2 personas'),
                    'hreflang'=>true
                ),
                'taxi-combo' =>  [
                    'title'=>function($viewVars, $request) {
                        $route1 = SharedTravel::_routeFull(
                                SharedTravel::_routeFromOriginDestination(
                                        $viewVars['combo']['route1']['origin_id'], 
                                        $viewVars['combo']['route1']['destination_id']));

                        $route2 = SharedTravel::_routeFull(
                                SharedTravel::_routeFromOriginDestination(
                                        $viewVars['combo']['route2']['origin_id'], 
                                        $viewVars['combo']['route2']['destination_id']));
                    
                        return __d('meta', 'Taxi de {0} a {1} via {2} | Económico', 
                            $route1['origin'], 
                            $route2['destination'],
                            $route1['destination']);
                    },
                    'description'=>function($viewVars, $request) {
                        $route1 = SharedTravel::_routeFull(
                                SharedTravel::_routeFromOriginDestination(
                                        $viewVars['combo']['route1']['origin_id'], 
                                        $viewVars['combo']['route1']['destination_id']));

                        $route2 = SharedTravel::_routeFull(
                                SharedTravel::_routeFromOriginDestination(
                                        $viewVars['combo']['route2']['origin_id'], 
                                        $viewVars['combo']['route2']['destination_id']));
                        
                        $peopleCount = 2;
                        $priceRoute1 = $route1['price_x_seat']*$peopleCount;
                        $priceRoute2 = $route2['price_x_seat']*$peopleCount;
                        $totalPriceCombo = $priceRoute1 + $priceRoute2;
                        
                        return __d('meta', 'Combina 2 traslados en taxi colectivo de {0} a {1} y llega de manera económica por ${2} total para {3} personas', $route1['origin'], $route2['destination'], $totalPriceCombo, $peopleCount);
                    },
                    'hreflang'=>true
                ],
                'press-release'=>array('title'=>__d('meta', 'Lanzamiento de PickoCar | Reseña para la Prensa'), 'description'=>__d('meta', 'Reseña para la prensa del lanzamiento de PickoCar en Cuba')),
                'taxi-vs-viazul'=>array('title'=>__d('meta', 'Taxi compartido en Cuba con precios similares al bus Viazul'), 'description'=>__d('meta', 'PickoCar es un servicio de taxi compartido en Cuba con excelentes precios y rutas que conectan destinos como {0} y otros', 'La Habana, Viñales, Trinidad, Varadero, Cayo Guillermo')),
                /*'faq'=>array('title'=>__d('meta', 'Preguntas Frecuentes'), 'description'=>__d('meta', 'Preguntas y respuestas sobre cómo conseguir un taxi para moverte por Cuba usando YoTeLlevo')),
                'testimonials'=>array('title'=>__d('meta', 'Testimonios de viajeros sorprendentes en Cuba'), 'description'=>__d('meta', 'Testimonios de viajeros que contrataron choferes con YoTeLlevo, Cuba'))*/),
            
            // HOMEPAGE
            'Contact.index' => [
                'title'=>__d('meta', 'Contactar'), 
                'description'=>__d('meta', 'PickoCar es un servicio de taxi compartido en Cuba. Contáctanos para cualquier pregunta.'),
                'hreflang'=>true
            ],


            // USER ACTIONS
            'SharedTravels.book' =>  [
                'title'=>function($viewVars, $request) {
                    return __d('meta', 'Taxi compartido de {0} a {1}. Precio: ${2} por asiento', $viewVars['route']['origin'], $viewVars['route']['destination'], $viewVars['route']['price_x_seat']);
                },
                'description'=>function($viewVars, $request) {
                    return __d('meta', 'Reserva un taxi para ir de {0} a {1} por un precio de {2} cuc por asiento. Recogida en casa u hotel. Sólo 4 pasajeros en un auto moderno con aire acondicionado y mucho confort.', $viewVars['route']['origin'], $viewVars['route']['destination'], $viewVars['route']['price_x_seat']);
                },
                'hreflang'=>true
            ],
            'SharedTravels.thanks' =>array('title'=>__d('meta', 'Gracias por su solicitud'), 'description'=>'', 'robots-index'=>false),
            'SharedTravels.activate' =>array('title'=>__d('meta', 'Activar solicitud'), 'description'=>'', 'robots-index'=>false),
            'SharedTravels.view' =>array('title'=>__d('meta', 'Datos de tu solicitud'), 'description'=>'', 'robots-index'=>false),

            // ADMIN
            'SharedTravels.index' =>array('title'=>'Compartidos', 'description'=>''),
            'SharedTravels.admin' =>array('title'=>'Admin', 'description'=>''),

            'EmailQueues.index' =>array('title'=>'Email Queue', 'description'=>''),
            ];

        if(isset ($pageTitles[$key])) return $pageTitles[$key];

        return null;
    }
}