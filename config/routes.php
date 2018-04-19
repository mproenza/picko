<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
use Cake\I18n\I18n;
use \Cake\Core\Configure;
use App\Model\Entity\SharedTravel;
use App\Routing\Route\UrlI18nRoute;
use Cake\Utility\Inflector;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

// Filtro para crear urls con el idioma actual al principio
Router::addUrlFilter(function ($params, $request) {
    if (isset($request->params['language']) && !isset($params['language'])) {
        $params['language'] = $request->params['language'];
    } elseif (!isset($params['language'])) {
        $params['language'] = Configure::read('default_language');
    }

    return $params;
});

// Filtro para crear url traducidas al idioma actual
Router::addUrlFilter(function ($params, $request) {
    // Si esta el lenguaje pero no esta ni el controller ni la action, entonces es el link de cambio de lenguaje.
    // Debemos poner en los params
    /*if(isset($params['language']) && !isset($params['_name']) && !(isset($params['controller']) || isset($params['action']))) {
        
        $currentLang = I18n::getLocale();
        
        I18n::setLocale($params['language']);
        
        $controller = $request->params['controller'];
        if($controller == 'SharedTravels') $controller = 'shared-rides';
        $params['controller'] = __d('urls', $controller);
        $params['action'] = __d('urls', $request->params['action']);
        
        I18n::setLocale($currentLang);
        
        return $params;
    }*/
    
    // Si esta el lenguaje en los parametros, cambiar a ese lenguaje en para las traducciones temporalmente
    $currentLang = I18n::getLocale();
    if(isset($params['language'])) I18n::setLocale($params['language']);
    
    if(isset($params['controller'])) {
        $params['controller'] = __d('urls', $params['controller']);
    }
    if(isset($params['action'])) {
        $params['action'] = __d('urls', $params['action']);
    }
    
    I18n::setLocale($currentLang);

    return $params;
});

// Filtro para los slug para las solicitudes. Ej. para generar la url /book/taxi-from-la-habana-to-trinidad-2pm
/*Router::addUrlFilter(function ($params, $request) {
    if(isset($params['controller']) &&  $params['controller'] == 'shared-rides'
        && isset($params['action']) &&  $params['action'] == 'book') {
        
        $modalityCode = $params['?']['s'];
        $modality = SharedTravel::$modalities[$modalityCode];
        
        $params['?']['slug'] = 'taxi-from-'.strtolower(str_replace(' ', '-', $modality['origin'])).'-to-'.strtolower(str_replace(' ', '-', $modality['destination'])).'-'.str_replace(' ', '-', $modality['time']);
    }

    return $params;
});*/
 
Router::scope('/:language', function (RouteBuilder $routes) {
    
    $routes->connect('/', ['controller' => 'SharedTravels', 'action' => 'home'], ['_name'=>'homepage'])
            ->setPatterns(['language' => 'en|es']);

    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display'])
            ->setPatterns(['language' => 'en|es']);
    
    // Shared Rides
    $routes->connect('/shared-rides/:action/*', ['controller' => 'SharedTravels'], ['routeClass' => 'UrlI18nRoute'])
            ->setPatterns(['language' => 'en|es']);
    $routes->connect('/shared-rides/*', ['controller' => 'SharedTravels', 'action' => 'index'], ['routeClass' => 'UrlI18nRoute'])
            ->setPatterns(['language' => 'en|es']);
    
    // Email Queue
    $routes->connect('/email-queue/:action/*', ['plugin'=>'EmailQueue', 'controller' => 'EmailQueues'])
            ->setPatterns(['language' => 'en|es']);
    $routes->connect('/email-queue/*', ['plugin'=>'EmailQueue', 'controller' => 'EmailQueues', 'action' => 'index'])
            ->setPatterns(['language' => 'en|es']);
    
    // Calendar
    $routes->connect('/calendar/:action/*', ['plugin'=>'Calendar', 'controller' => 'Calendars'])
            ->setPatterns(['language' => 'en|es']);
    $routes->connect('/calendar/*', ['plugin'=>'Calendar', 'controller' => 'Calendars', 'action' => 'index'])
            ->setPatterns(['language' => 'en|es']);
    
    // CAKEDC/USERS PLUGIN
    $routes->plugin('CakeDC/Users', ['path' => '/users'], function ($routes) {
        $routes->fallbacks('DashedRoute');
    });
    $routes->connect('/login', ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/profile/*', ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'profile']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();