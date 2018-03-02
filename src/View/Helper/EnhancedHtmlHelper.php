<?php
namespace App\View\Helper;

use Cake\View\Helper\HtmlHelper;

class EnhancedHtmlHelper extends HtmlHelper {
    
    private $_cssAliases = array(
        'bootstrap'=>array(
            'debug'=>'common/bootstrap-3.1.1-dist/css/bootstrap.min',
            'release'=>'common/bootstrap-3.1.1-dist/css/bootstrap.min'/*'http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.js'*/
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
            'debug'=>'common/bootstrap-3.1.1-dist/js/bootstrap.min',
            'release'=>'common/bootstrap-3.1.1-dist/js/bootstrap.min'
        ),
        'jquery'=>array(
            'debug'=>'common/jquery-1.9.0.min',
            'release'=>'common/jquery-1.9.0.min'
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
    

    public function css($path, $options = array()) {
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
    
    public function script($url, $options = array()) {
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
    
    
    public function link($title, $url = null, $options = array(), $confirmMessage = false) {
        if(is_array($url) && !isset ($url['plugin'])) $url['plugin'] = '';
        return parent::link($title, $url, $options, $confirmMessage);
    }

}

?>
