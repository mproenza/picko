<?php
namespace App\View\Helper;

use Cake\View\Helper\HtmlHelper;
use \Cake\Core\Configure;
use \Cake\I18n\I18n;

class EnhancedHtmlHelper extends HtmlHelper {
    
    private function _getCssAliases() {
        return array(
            'bootstrap'=>array(
                'debug'=>'bootstrap',
                'release'=>'bootstrap'
            ),
            'calendar'=>array(
                'debug'=>['fullcalendar/fullcalendar', 'fullcalendar/fullcalendar.print'],
                'release'=>['fullcalendar/fullcalendar', 'fullcalendar/fullcalendar.print']
            ),
            'default-bundle'=>array(/* common/font-awesome.min se usaba en el datepicker... lo cambie para que usara glyphicons */
                'debug'=>array('bootstrap', /*'common/font-awesome.min',*/ 'default'),
                'release'=>array('bootstrap', /*'common/font-awesome.min',*/ 'default')
            )
        );
    }
    
    
    private function _getScriptAliases() {
        return array(
            'bootstrap'=>array(
                'debug'=>'bootstrap',
                'release'=>'bootstrap'
            ),
            'jquery'=>array(
                'debug'=>'jquery',
                'release'=>'jquery'
            ),
            'datepicker'=>array(
                'debug'=>'datepicker/bootstrap-datepicker',
                'release'=>'datepicker/bootstrap-datepicker.min'
            ),
            'datepicker-locale'=>array(
                'debug'=>'datepicker/locales/bootstrap-datepicker.'.I18n::getLocale().'.min',
                'release'=>'datepicker/locales/bootstrap-datepicker.'.I18n::getLocale().'.min'
            ),
            'form-validator'=>[
                'debug'=>'form-validator/jquery.form-validator.min',
                'release'=>'form-validator/jquery.form-validator.min'
            ],
            'form-validator-locale'=>[
                'debug'=>'form-validator/lang/'.I18n::getLocale(),
                'release'=>'form-validator/lang/'.I18n::getLocale()
            ],
            'calendar'=>array(
                'debug'=>['fullcalendar/lib/moment.min', 'fullcalendar/lib/jquery.min', 'fullcalendar/fullcalendar'],
                'release'=>['fullcalendar/lib/moment.min', 'fullcalendar/lib/jquery.min', 'fullcalendar/fullcalendar']
            ),
            'default-bundle'=>array(
                'debug'=>array('jquery', 'bootstrap'),
                'release'=>array('jquery', 'bootstrap')
            )
        );
    }
    

    public function css($path, array $options = []) {
        $path = $this->_fixUrl($path, $this->_getCssAliases());
        
        if (!is_array($options)) {
            $rel = $options;
            $options = array();
            if ($rel) {
                $options['rel'] = $rel;
            }
            if (func_num_args() > 2) {
                $options = func_get_arg(2) + $options;
            }
            unset($rel);
        }

        return parent::css($path, $options);
    }
    
    public function script($url, array $options = []) {
        $url = $this->_fixUrl($url, $this->_getScriptAliases());
        
        return parent::script($url, $options);
    }
    
    private function _fixUrl($url, $aliases) {
        if(array_key_exists($url, $aliases)) {
            if(Configure::read("debug") > 0) {
                $url = $aliases[$url]['debug'];
            } else {
                $url = $aliases[$url]['release'];
            }
        }

        return $url;
    }
    
    public function lang($currentLang, $request) {
        $other = array('en' => 'es', 'es' => 'en');

        $lang_changed_url = \App\Util\LangUtil::getUrlParamsForLanguage($other[$currentLang], $request);

        if($currentLang != null && $currentLang == 'en')
            return $this->link($this->image('Spain.png').' <small><small>Ver en</small> Español</small>', $lang_changed_url, array('class'=>'nav-link', 'escape'=>false, 'style'=>'text-decoration:none'));
        else
            return $this->link($this->image('UK.png').' <small><small>See in</small> English</small>', $lang_changed_url, array('class'=>'nav-link', 'escape'=>false, 'style'=>'text-decoration:none'));

    }

}