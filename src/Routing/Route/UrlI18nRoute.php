<?php
namespace App\Routing\Route;

use Cake\Routing\Route\DashedRoute;
use Cake\I18n\I18n;

class UrlI18nRoute extends DashedRoute
{   
    public function parse($url, $method = '')
    {
        $parts = explode('/', $url);
        
        $lang = I18n::getLocale();
        I18n::setLocale('en'); // Default lang
        foreach ($parts as $p) {
            $url = str_replace($p, __d('urls', $p), $url);
        }
        I18n::setLocale($lang);
        
        return parent::parse($url, $method);
    }
}
