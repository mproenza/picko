<?php
namespace ADmad\I18n\Routing\Route;

use Cake\Core\Configure;
use Cake\Routing\Route\DashedRoute;
use Cake\Utility\Hash;

class I18nRoute extends DashedRoute
{
    /**
     * Regular expression for `lang` route element.
     *
     * @var string
     */
    protected static $_langRegEx = null;

    /**
     * Constructor for a Route.
     *
     * @param string $template Template string with parameter placeholders
     * @param array $defaults Array of defaults for the route.
     * @param string $options Array of parameters and additional options for the Route
     *
     * @return void
     */
    public function __construct($template, $defaults = [], array $options = [])
    {
        if (strpos($template, ':lang') === false) {
            $template = '/:lang' . $template;
        }
        if ($template === '/:lang/') {
            $template = '/:lang';
        }

        $options['inflect'] = 'dasherize';
        $options['persist'][] = 'lang';

        if (!array_key_exists('lang', $options)) {
            if (self::$_langRegEx === null &&
                $langs = Configure::read('I18n.languages')
            ) {
                self::$_langRegEx = implode('|', array_keys(Hash::normalize($langs)));
            }
            $options['lang'] = self::$_langRegEx;
        }

        parent::__construct($template, $defaults, $options);
    }
    
    public function parse($url, $method = '')
    { 
        $addLang = false;
        
        $params = parent::parse($url, $method);
        if (!$params) {
            /**
            * The language preppeneded here is dummy: it is only used to satisfy DashedRoute::parse() and allow it to parse routes correctly 
            * as we already defined a param :lang in the constructor of I18nRoute class
            */
           $dummyLang = 'en';
           //if(!empty(Configure::read('I18n.languages'))) $dummyLang = Configure::read('I18n.languages')[0];
           
           $allowedLangs = Configure::read('I18n.languages');

           // Does it have at least 3 characters? i.e. /<2 chars for lang>
           if(strlen($url) < 3) $addLang = true;

           // If url length is 3, it has the structure /<2 chars for lang>, but if it is not an allowed lang, then it is not a lang
           else if(strlen($url) == 3 && !in_array( substr($url, 1), $allowedLangs ) ) $addLang = true;
           
           // If after 3 characters there is no /, then the url does not contain the language
           else if(strlen($url) > 3 && (!strpos($url, '/', 1) || strpos($url, '/', 1) > 3)) $addLang = true;

           if($addLang) $url = '/'.$dummyLang.$url;
           
           // Retry DashedRoute::parse()
           $params = parent::parse($url, $method);
           
           if(!$params) return false;
           
        }
        
        // Add an indicator to the middleware to redirect to a proper url with the language
        $params['langAdded'] = $addLang;

        return $params;
    }
    
}
