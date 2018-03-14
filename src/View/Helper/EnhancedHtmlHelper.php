<?php
namespace App\View\Helper;

use Cake\View\Helper\HtmlHelper;
use \Cake\Core\Configure;

class EnhancedHtmlHelper extends HtmlHelper {
    
    private $_cssAliases = array(
        'bootstrap'=>array(
            'debug'=>'bootstrap',
            'release'=>'bootstrap'/*'http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.js'*/
        ),
        'jquery-ui'=>array(
            'debug'=>'common/jquery-ui-1.10.0.custom',
            'release'=>'common/jquery-ui-1.10.0.custom'
        ),
        'prettify'=>array(
            'debug'=>'common/prettify',
            'release'=>'common/prettify'
        ),
        'bootstrap-editable'=>array(
            'debug'=>'bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable',
            'release'=>'bootstrap3-editable-1.5.1/bootstrap3-editable/css/bootstrap-editable'
        ),
        'bootstrap-select2'=>array(
            'debug'=>array('bootstrap3-editable-1.5.1/select2/select2', 'bootstrap3-editable-1.5.1/select2/select2-bootstrap', 'bootstrap-editable'),
            'release'=>array('bootstrap3-editable-1.5.1/select2/select2', 'bootstrap3-editable-1.5.1/select2/select2-bootstrap', 'bootstrap-editable')
        ),
        'default-bundle'=>array(/* common/font-awesome.min se usaba en el datepicker... lo cambie para que usara glyphicons */
            'debug'=>array('bootstrap', /*'common/font-awesome.min',*/ 'default'),
            'release'=>array('bootstrap', /*'common/font-awesome.min',*/ 'default')
        )
    );
    
    private $_scriptAliases = array(
        'bootstrap'=>array(
            'debug'=>'bootstrap',
            'release'=>'bootstrap'
        ),
        'jquery'=>array(
            'debug'=>'jquery',
            'release'=>'jquery'
        ),
        'jquery-ui'=>array(
            'debug'=>'common/jquery-ui-1.9.2.custom.min',
            'release'=>'common/jquery-ui-1.9.2.custom.min'
        ),
        'prettify'=>array(
            'debug'=>'common/prettify',
            'release'=>'common/prettify'
        ),
        'bootstrap-editable'=>array(
            'debug'=>'bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable',
            'release'=>'bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable'
        ),
        'bootstrap-select2'=>array(
            'debug'=>array('bootstrap', 'bootstrap3-editable-1.5.1/inputs-ext/select2/select2', 'bootstrap-editable'),
            'release'=>array('bootstrap', 'bootstrap3-editable-1.5.1/inputs-ext/select2/select2', 'bootstrap-editable')
        ),
        'default-bundle'=>array(
            'debug'=>array('jquery', 'bootstrap'),
            'release'=>array('jquery', 'bootstrap')
        )
    );    
    

    public function css($path, array $options = []) {
        $path = $this->_fixUrl($path, $this->_cssAliases);
        
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
        $url = $this->_fixUrl($url, $this->_scriptAliases);
        
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
    
    
    /*public function link($title, $url = null, array $options = []) {
        //if(is_array($url) && !isset ($url['plugin'])) $url['plugin'] = '';
        return parent::link($title, $url, $options);
    }*/
    
    public function lang($currentLang, $request) {
        $other = array('en' => 'es', 'es' => 'en');
        $lang = $currentLang;

        $lang_changed_url             = $request->getParam('pass');
        $lang_changed_url['?']        = $request->getQueryParams();
        $lang_changed_url['language'] = $other[$lang];

        if($lang != null && $lang == 'en')
            return $this->link($this->image('Spain.png'), $lang_changed_url, array('class'=>'nav-link', 'escape'=>false, 'style'=>'text-decoration:none'));
        else
            return $this->link($this->image('UK.png'), $lang_changed_url, array('class'=>'nav-link', 'escape'=>false, 'style'=>'text-decoration:none'));

    }

}

?>
