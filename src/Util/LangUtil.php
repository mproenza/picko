<?php
namespace App\Util;

class LangUtil {

    public static function getLangSetup($lang) {
        $langs = array(
            'es'=>array('desc'=>__('Español'), 'alt'=>'en', 'altDesc'=>__('Inglés')),
            'en'=>array('desc'=>__('Inglés'), 'alt'=>'es', 'altDesc'=>__('Español')),
        );

        return $langs[$lang];
    }

    public static function getUrlParamsForLanguage($lang, $request) {
        $urlParams = $request->getParam('pass');

        if($request->getParam('action') != 'home') {
            $urlParams['controller'] = $request->getParam('controller');
            $urlParams['action'] = $request->getParam('action');

            if($urlParams['controller'] == 'SharedTravels') $urlParams['controller'] = 'shared-rides';
        }

        if(is_array($urlParams)){
            $urlParams['?']        = $request->getQueryParams();
            $urlParams['language'] = $lang;
        } else {
            $urlParams = '/'.$lang.'/'.$urlParams;
        }

        return $urlParams;
    }
}