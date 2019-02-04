<?php

namespace App\Util;

use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;

class EmailsUtil {
    
    public static function email($to, $subject, array $vars, $config, $template, $options = null, $format = 'html') {
        $OK = true;
        if( !isset($options['enqueue']) || (isset($options['enqueue']) && $options['enqueue']) ) {
            $defaultOpt = array(
                        'template'=>$template,
                        'format'=>$format,
                        'subject'=>$subject,
                        'config'=>$config);
            if($options != null) $options = array_merge($defaultOpt, $options); else $options = $defaultOpt;
            
            $OK = TableRegistry::get('EmailQueue.EmailQueues')->enqueue($to, $vars, $options);
        } else {
            $Email = new Email($config);
            $Email->template($template)
            ->viewVars($vars)
            ->emailFormat($format)
            ->to($to)
            ->subject($subject);
            try {
                $Email->send();
            } catch ( Exception $e ) {
                $OK = false;
            }
        }
        
        return $OK;
    }
    
   
    public static function fixEmailBody($body) {
        $fixedBody = $body;
        
        // Remove the avatars
        $replacement = '['.__d('conversation', 'imagen borrada').']';
        $fixedBody = EmailsUtil::removeTag($fixedBody,'driver-avatar','<img','/>', $replacement);
        
        // Remove the footer
        $fixedBody = EmailsUtil::removeTag($fixedBody,'email-salute','<div','/div>');
        
        // Remove the social links
        $fixedBody = EmailsUtil::removeTag($fixedBody,'social-link','<a','/a>');
        
        return $fixedBody;
    }
    
    public static function removeAllEmailAddresses($text) {
        $fixedText = $text;
        
        $emailpattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
        $replacement = '['.__d('conversation', 'correo borrado').']';
        $fixedText = preg_replace($emailpattern, $replacement, $fixedText);
        
        return $fixedText;
    }
    
    public static function removeAllUrls($text) {
        $fixedText = $text;
        
        $urlpattern = "!\b(((ht|f)tp(s?))\://)?(www.|[a-z].)[a-z0-9\-\.]+\.(com|edu|gov|mil|net|org|biz|info|name|museum|us|ca|uk|cu)(\:[0-9]+)*(/($|[a-z0-9\.\,\;\?\\'\\\\\+&amp;%\$#\=~_\-]+))*\b!i";
        $replacement = '['.__d('conversation', 'url borrada').']';
        //$fixedText = preg_replace($urlpattern, $replacement, $fixedText);
        $fixedText = preg_replace_callback(
                $urlpattern, 
                function ($match) {
                    if(strpos($match[0], 'yotellevocuba.com') === 0 || strpos($match[0], 'yotellevocuba.com')) return $match[0];
                    return '['.__d('conversation', 'url borrada').']';
                }, 
                $fixedText);
        
        return $fixedText;
    }
    
    public static function splitBySeparator($message){
        $text = strip_tags( trim($message) );
        $splitter = strpos($text, Configure::read('email_message_separator_stripped')); 
        
        if($splitter !== false)
            $text = substr($text, 0, $splitter);
        
        return trim($text);
    }
    
    public static function getFirsPart($message){
        $text = EmailsUtil::splitBySeparator($message);
        
        $text = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*cuc*/i", "<b>$0</b>", $text);
        $text = preg_replace("/\d+\.*\d*\s*(\r\n|\n|\r)*(kms*|kilometros*|kilómetros*|km*)/i", '<span style="color:tomato"><b>$0</b></span>', $text);
        $text = preg_replace("/(\r\n|\n|\r)/", "<br/>", $text);
        return $text;
    }
    
    
    //str - string to search 
    //id - text to search for
    //start_tag - start delimiter to remove
    //end_tag - end delimiter to remove
    private static function removeTag($str, $id, $start_tag, $end_tag, $replacement = '') { // Source: http://www.katcode.com/php-html-parsing-extracting-and-removing-html-tag-of-specific-class-from-string/
        //find position of tag identifier. loops until all instance of text removed
        while(($pos_srch = strpos($str,$id))!==false) {
            //get text before identifier
            $beg = substr($str,0,$pos_srch);
            //get position of start tag
            $pos_start_tag = strrpos($beg,$start_tag);
            //echo 'start: '.$pos_start_tag.'<br>';
            //extract text up to but not including start tag
            $beg = substr($beg,0,$pos_start_tag);
            //echo "beg: ".$beg."<br>";

            //get text from identifier and on
            $end = substr($str,$pos_srch);

            //get length of end tag
            $end_tag_len = strlen($end_tag);
            //find position of end tag
            $pos_end_tag = strpos($end,$end_tag);
            //extract after end tag and on
            $end = substr($end,$pos_end_tag+$end_tag_len);

            $str = $beg.$replacement.$end;
        }

        //return processed string
        return $str;
    } 
}
?>
