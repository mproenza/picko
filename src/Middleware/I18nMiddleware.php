<?php
namespace App\Middleware;

use Cake\Core\Configure;
use Cake\Core\InstanceConfigTrait;
use Cake\I18n\I18n;
use Cake\Network\Request;
use Cake\Utility\Hash;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class I18nMiddleware
{
    use InstanceConfigTrait;

    /**
     * Default config.
     *
     * ### Valid keys
     *
     * - `detectLanguage`: If `true` will attempt to get browser locale and
     *   redirect to similar language available in app when going to site root.
     *   Default `true`.
     * - `defaultLanguage`: Default language for app. Default `en_US`.
     * - `languages`: Languages available in app. Default `[]`.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'detectLanguage' => true,
        'defaultLanguage' => 'en_US',
        'languages' => [],
    ];

    /**
     * Constructor.
     *
     * @param array $config Settings for the filter.
     */
    public function __construct($config = [])
    {
        /*if (isset($config['languages'])) {
            $config['languages'] = Hash::normalize($config['languages']);
        }*/

        $this->config($config);
    }

    /**
     * Sets appropriate locale and lang to I18n::locale() and App.language config
     * respectively based on "lang" request param.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Message\ResponseInterface $response The response.
     * @param callable $next Callback to invoke the next middleware.
     *
     * @return \Psr\Http\Message\ResponseInterface A response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $config = $this->config();
        $url = $request->getUri()->getPath();
        
        /*if ($url === '/') {
            $statusCode = 301;
            $lang = $config['defaultLanguage'];
            if ($config['detectLanguage']) {
                $statusCode = 302;
                $lang = $this->detectLanguage($request, $lang);
            }

            $response = new RedirectResponse(
                $request->getAttribute('webroot') . $lang,
                $statusCode
            );

            return $response;
        }*/
        
        /*$langs = $config['languages'];
        
        // Pôsibles comienzos de la url para que el idioma se considere que está presente (ej. '/en/')
        $possibleLangUrlStart = [];
        foreach($langs as $l) {
            $possibleLangUrlStart[] = '/'.$l.'/';
        }
        
        // Para que el idioma se considere que está en la url, los primeros caracteres hasta el primer '/' deben coincidir con uno de los posibles
        // comienzos de la url
        if(!in_array(substr($url, strpos($url, '/', 1)), $possibleLangUrlStart)) {
            $statusCode = 301;
            $lang = $this->_config['defaultLanguage'];
            if ($this->_config['detectLanguage']) {
                $statusCode = 302;
                $lang = $this->detectLanguage($request, $lang);
            }
            
            $response = new RedirectResponse(
                $request->getAttribute('webroot') . $lang. $url,
                $statusCode
            );

            return $response;
        }*/
        
        /*if (empty($request->url) ||  !$request->param('language')) {
            $statusCode = 301;
            $lang = $this->_config['defaultLanguage'];
            if ($this->_config['detectLanguage']) {
                $statusCode = 302;
                $lang = $this->detectLanguage($request, $lang);
            }

            $location = $request->webroot . $lang . (!empty($request->url) ? '/' . $request->url : '');
            $response->statusCode($statusCode);
            $response->header('Location', $location);

            return $response;
        }*/
        
        /*$params = $request->getAttribute('params');
        if (isset($params['nolang']) && $params['nolang']) {
            $statusCode = 301;
            $lang = $this->_config['defaultLanguage'];
            if ($this->_config['detectLanguage']) {
                $statusCode = 302;
                $lang = $this->detectLanguage($request, $lang);
            }
            
            $response = new RedirectResponse(
                $request->getAttribute('webroot') . $lang. $url,
                $statusCode
            );

            return $response;
        }*/
        
        if(!$this->_isLangInUrl($url, $config['languages'])) {
            $statusCode = 301;
            $lang = $this->_config['defaultLanguage'];
            if ($this->_config['detectLanguage']) {
                $statusCode = 302;
                $lang = $this->detectLanguage($request, $lang);
            }
            
            $response = new RedirectResponse(
                $request->getAttribute('webroot') . $lang. $url,
                $statusCode
            );

            return $response;
        } else {
            $lang = substr($url, 1, 2);
            
            I18n::locale($lang);
            Configure::write('App.language', $lang);
        }

        /*$langs = $config['languages'];
        $requestParams = $request->getAttribute('params');
        echo $requestParams['language'];
        $lang = isset($requestParams['language']) ? $requestParams['language'] : $config['defaultLanguage'];
        if (isset($langs[$lang])) {
            I18n::locale($langs[$lang]['locale']);
        } else {
            I18n::locale($lang);
        }

        Configure::write('App.language', $lang);*/

        return $next($request, $response);
    }

    /**
     * Get languages accepted by browser and return the one matching one of
     * those in config var `I18n.languages`.
     *
     * You should set config var `I18n.languages` to an array containing
     * languages available in your app.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param string|null $default Default language to return if no match is found.
     *
     * @return string
     */
    public function detectLanguage(ServerRequestInterface $request, $default = null)
    {
        if (empty($default)) {
            $lang = $this->_config['defaultLanguage'];
        } else {
            $lang = $default;
        }

        $browserLangs = $request->acceptLanguage();
        foreach ($browserLangs as $k => $langKey) {
            if (strpos($langKey, '-') !== false) {
                $browserLangs[$k] = substr($langKey, 0, 2);
            }
        }
        $acceptedLangs = array_intersect(
            $browserLangs,
            array_keys($this->_config['languages'])
        );
        if (!empty($acceptedLangs)) {
            $lang = reset($acceptedLangs);
        }

        return $lang;
    }
    
    private function _isLangInUrl($url, $allowedLangs) {
        $langInUrl = true;
        
        // Does it have at least 3 characters? i.e. /<2 chars for lang>
        if(strlen($url) < 3) $langInUrl = false;

        // If url length is 3, it has the structure /<2 chars for lang>, but if it is not an allowed lang, then it is not a lang
        else if(strlen($url) == 3 && !in_array( substr($url, -2), $allowedLangs ) ) $langInUrl = false;

        // If after 3 characters there is no /, then the url does not contain the language
        else if(strlen($url) > 3 && (!strpos($url, '/', 1) || strpos($url, '/', 1) > 3)) $langInUrl = false;
        
        return $langInUrl;
    }
}