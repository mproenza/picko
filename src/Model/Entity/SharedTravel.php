<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

class SharedTravel extends Entity {
    
    public static $localities = array(
        0=>['name'=>'La Habana', 'slug'=>'habana', 'code'=>'HAB', 'short'=>'Hab'],
        1=>['name'=>'Trinidad', 'slug'=>'trinidad', 'code'=>'TRI', 'short'=>'Tri'], 
        2=>['name'=>'Viñales', 'slug'=>'vinales', 'code'=>'VIN', 'short'=>'Viñ'], 
        3=>['name'=>'Varadero', 'slug'=>'varadero', 'code'=>'VAR', 'short'=>'Var'],
        4=>['name'=>'Cienfuegos', 'slug'=>'cienfuegos', 'code'=>'CFG', 'short'=>'Cfg'], 
        7=>['name'=>'Santa Clara', 'slug'=>'santa-clara', 'code'=>'SCL', 'short'=>'S. Clara'],
        5=>['name'=>'Cayo Coco', 'slug'=>'cayo-coco', 'code'=>'CAC', 'short'=>'C. Coco'],
        6=>['name'=>'Cayo Guillermo', 'slug'=>'cayo-guillermo', 'code'=>'CAG', 'short'=>'C. Guillermo'],
        8=>['name'=>'Playa Larga', 'slug'=>'playa-larga', 'code'=>'PLL', 'short'=>'P. Larga'],
        9=>['name'=>'Playa Girón', 'slug'=>'playa-giron', 'code'=>'PLG', 'short'=>'P. Giron',  'use_as_origin'=>false],
        10=>['name'=>'Cayo Santa María', 'slug'=>'cayo-santa-maria', 'code'=>'CAM', 'short'=>'C. Sta Maria', 'use_as_origin'=>false],
    );
    
    public static $routes_info = [
        0 => [
            1=>['kms'=>'360', 'hrs'=>'4'],
            2=>['kms'=>'190', 'hrs'=>'2.30'],
            3=>['kms'=>'180', 'hrs'=>'2'],
            4=>['kms'=>'260', 'hrs'=>'3'],
            5=>['kms'=>'560', 'hrs'=>'7'],
            6=>['kms'=>'600', 'hrs'=>'7.30'],
            7=>['kms'=>'300', 'hrs'=>'3.30'],
            8=>['kms'=>'190', 'hrs'=>'2.30'],
            9=>['kms'=>'220', 'hrs'=>'3'],
        ],
        
        1 => [
            2=>['kms'=>'560', 'hrs'=>'6.30'],
            3=>['kms'=>'300', 'hrs'=>'4'],
            4=>['kms'=>'80', 'hrs'=>'1'],
            5=>['kms'=>'250', 'hrs'=>'3.30'],
            6=>['kms'=>'290', 'hrs'=>'4'],
            8=>['kms'=>'240', 'hrs'=>'3'],
            9=>['kms'=>'280', 'hrs'=>'3.30'],
            10=>['kms'=>'210', 'hrs'=>'3'],
        ],
        
        2 => [
            3=>['kms'=>'400', 'hrs'=>'4.30'],
            4=>['kms'=>'480', 'hrs'=>'5'],
            5=>['kms'=>'780', 'hrs'=>'8'],
            6=>['kms'=>'820', 'hrs'=>'8.30'],
            7=>['kms'=>'500', 'hrs'=>'5.30'],
            8=>['kms'=>'400', 'hrs'=>'4.30'],
            9=>['kms'=>'440', 'hrs'=>'5'],
        ],
        
        3 => [
            4=>['kms'=>'200', 'hrs'=>'3'],
            5=>['kms'=>'500', 'hrs'=>'6.30'],
            6=>['kms'=>'540', 'hrs'=>'7'],
            7=>['kms'=>'230', 'hrs'=>'3'],
            8=>['kms'=>'130', 'hrs'=>'2'],
        ],
        
        4 => [
            5=>['kms'=>'320', 'hrs'=>'4'],
            6=>['kms'=>'360', 'hrs'=>'4.30'],
            8=>['kms'=>'150', 'hrs'=>'2'],
            9=>['kms'=>'110', 'hrs'=>'1.30'],
        ],
        
        5 => [
            7=>['kms'=>'250', 'hrs'=>'3'],
        ],
        
        6 => [
            7=>['kms'=>'290', 'hrs'=>'3.30'],
        ],
        
        7 => [
            8=>['kms'=>'160', 'hrs'=>'2'],
            9=>['kms'=>'200', 'hrs'=>'2.30'],
        ]
        
    ];
    public static function _routeInfo($origin, $destination) {
        if(isset(self::$routes_info[$origin])) {
            if(isset(self::$routes_info[$origin][$destination])) return self::$routes_info[$origin][$destination];
        }
        if(isset(self::$routes_info[$destination])) {
            if(isset(self::$routes_info[$destination][$origin])) return self::$routes_info[$destination][$origin];
        }
        
        return null;
    }
    
    public static $routes = [
        ['origin_id'=>0, 'destination_id'=>1, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>0, 'destination_id'=>2, 'price_x_seat'=>25, 'departure_times'=>[11]],
        ['origin_id'=>0, 'destination_id'=>3, 'price_x_seat'=>25, 'departure_times'=>[14]],
        ['origin_id'=>0, 'destination_id'=>4, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>0, 'destination_id'=>7, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>0, 'destination_id'=>8, 'price_x_seat'=>30, 'departure_times'=>[8, 14]],
        ['origin_id'=>0, 'destination_id'=>9, 'price_x_seat'=>30, 'departure_times'=>[8, 14]],
        ['origin_id'=>1, 'destination_id'=>0, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>1, 'destination_id'=>2, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>1, 'destination_id'=>3, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>1, 'destination_id'=>10, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>1, 'destination_id'=>5, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>1, 'destination_id'=>6, 'price_x_seat'=>40, 'departure_times'=>[8]],
        ['origin_id'=>1, 'destination_id'=>8, 'price_x_seat'=>30, 'departure_times'=>[8, 14]],
        ['origin_id'=>1, 'destination_id'=>9, 'price_x_seat'=>30, 'departure_times'=>[8, 14]],
        ['origin_id'=>2, 'destination_id'=>0, 'price_x_seat'=>25, 'departure_times'=>[8, 14]],
        ['origin_id'=>2, 'destination_id'=>3, 'price_x_seat'=>45, 'departure_times'=>[8, 14]],
        ['origin_id'=>2, 'destination_id'=>1, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>2, 'destination_id'=>4, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>2, 'destination_id'=>7, 'price_x_seat'=>45, 'departure_times'=>[8]],
        ['origin_id'=>2, 'destination_id'=>8, 'price_x_seat'=>40, 'departure_times'=>[8]],
        ['origin_id'=>2, 'destination_id'=>9, 'price_x_seat'=>45, 'departure_times'=>[8]],
        ['origin_id'=>3, 'destination_id'=>0, 'price_x_seat'=>30, 'departure_times'=>[8, 14]],
        ['origin_id'=>3, 'destination_id'=>1, 'price_x_seat'=>35, 'departure_times'=>[14]],
        ['origin_id'=>3, 'destination_id'=>2, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>3, 'destination_id'=>4, 'price_x_seat'=>35, 'departure_times'=>[14]],
        ['origin_id'=>4, 'destination_id'=>0, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>4, 'destination_id'=>1, 'price_x_seat'=>15, 'departure_times'=>[7]],
        ['origin_id'=>4, 'destination_id'=>2, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>4, 'destination_id'=>3, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>4, 'destination_id'=>5, 'price_x_seat'=>40, 'departure_times'=>[8]],
        ['origin_id'=>4, 'destination_id'=>6, 'price_x_seat'=>45, 'departure_times'=>[8]],
        ['origin_id'=>4, 'destination_id'=>8, 'price_x_seat'=>30, 'departure_times'=>[8, 14]],
        ['origin_id'=>4, 'destination_id'=>9, 'price_x_seat'=>30, 'departure_times'=>[8, 14]],
        ['origin_id'=>5, 'destination_id'=>0, 'price_x_seat'=>60, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>1, 'price_x_seat'=>45, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>3, 'price_x_seat'=>60, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>7, 'price_x_seat'=>55, 'departure_times'=>[14]],
        ['origin_id'=>6, 'destination_id'=>0, 'price_x_seat'=>65, 'departure_times'=>[14]],
        ['origin_id'=>6, 'destination_id'=>1, 'price_x_seat'=>50, 'departure_times'=>[14]],
        ['origin_id'=>6, 'destination_id'=>3, 'price_x_seat'=>65, 'departure_times'=>[14]],
        ['origin_id'=>6, 'destination_id'=>7, 'price_x_seat'=>60, 'departure_times'=>[14]],
        ['origin_id'=>7, 'destination_id'=>0, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>7, 'destination_id'=>2, 'price_x_seat'=>45, 'departure_times'=>[8]],
        ['origin_id'=>7, 'destination_id'=>3, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>7, 'destination_id'=>8, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>7, 'destination_id'=>9, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>8, 'destination_id'=>0, 'price_x_seat'=>30, 'departure_times'=>[8, 10]],
        ['origin_id'=>8, 'destination_id'=>1, 'price_x_seat'=>30, 'departure_times'=>[11, 16]],
        ['origin_id'=>8, 'destination_id'=>3, 'price_x_seat'=>35, 'departure_times'=>[11]],
        ['origin_id'=>8, 'destination_id'=>2, 'price_x_seat'=>40, 'departure_times'=>[8, 10]],
        ['origin_id'=>8, 'destination_id'=>4, 'price_x_seat'=>30, 'departure_times'=>[11, 16]],
        ['origin_id'=>9, 'destination_id'=>0, 'price_x_seat'=>30, 'departure_times'=>[8, 10]],
        ['origin_id'=>9, 'destination_id'=>2, 'price_x_seat'=>45, 'departure_times'=>[8, 10]],
        ['origin_id'=>9, 'destination_id'=>1, 'price_x_seat'=>30, 'departure_times'=>[11, 16]],
        ['origin_id'=>9, 'destination_id'=>4, 'price_x_seat'=>30, 'departure_times'=>[11, 16]]
    ];
    public static function _routeFull($route) {
        // Evitar ponerle los datos extra a las rutas si ya se hizo (esto es porque se pudiera llamar a _routeFull() varias veces en una ejecucion)
        if(isset($route['isFull']) && $route['isFull']) return $route;
        
        $route['origin'] = self::$localities[$route['origin_id']]['name'];
        $route['origin_short'] = self::$localities[$route['origin_id']]['short'];
        $route['destination'] = self::$localities[$route['destination_id']]['name'];
        $route['destination_short'] = self::$localities[$route['destination_id']]['short'];
        $route['code'] = self::$localities[$route['origin_id']]['code'].self::$localities[$route['destination_id']]['code'];
        $route['slug'] = 'taxi-'.self::$localities[$route['origin_id']]['slug'].'--'.self::$localities[$route['destination_id']]['slug'];
        
        // Poner am y pm a la hora de salida
        if(isset($route['departure_time'])) {
            $d = 'am';
            if($route['departure_time'] > 12) {
                $route['departure_time'] -= 12;
                $d = 'pm';
            } else if( $route['departure_time'] == 12) $d = 'pm';
            $route['departure_time_desc'] = $route['departure_time'].' '.$d;
        }
        
        if(!isset($route['departure_times'])) {
            foreach (self::$routes as $r) { // Poner los departure_times si le faltan
                if($r['origin_id'] == $route['origin_id'] && $r['destination_id'] == $route['destination_id']) {
                    $route['departure_times'] = $r['departure_times'];
                }
            }
        }
        
        // Poner am y pm a los horarios de salida
        foreach ($route['departure_times'] as $time) {
            $d = 'am';
            if($time > 12) {
                $time -= 12;
                $d = 'pm';
            } else if( $time == 12) $d = 'pm';
            $route['departure_times_desc'][] = $time.' '.$d;
        }
        
        $route['isFull'] = true;
        
        return $route;
    }
    
    /**
     * Retorna null si no hay matcheo
     * * Debe decir 'taxi-' delante, debe tener el separador '--', deben existir los slug, etc...
     * @param type $slug
     * @return type
     * @throws NotFoundException
     */
    public static function _routeFromSlug($slug) {
        // Sanity checks
        if($slug == null) return null;
        if(substr($slug, 0, 5) != 'taxi-') return null;
        
        $slug = substr($slug, 5); // Eliminar 'taxi-'
        
        $pos = strpos($slug, '--');
        
        if(!$pos) return null;
        
        // OK
        
        $originSlug = substr($slug, 0, $pos);
        $destSlug = substr($slug, $pos + 2);
        
        $originId = null;
        foreach (self::$localities as $k=>$l) {
            if($l['slug'] == $originSlug) {
                $originId = $k;
                break;
            }
        }
        if($originId === null) return null;
        
        $destId = null;
        foreach (self::$localities as $k=>$l) {
            if($l['slug'] == $destSlug) {
                $destId = $k;
                break;
            }
        }
        if($destId === null) return null;
        
        $route = null;
        foreach (self::$routes as $r) {
            if($r['origin_id'] == $originId && $r['destination_id'] == $destId) {
                $route = $r;
                break;
            }
        }
        
        return $route;
    }
    
    public static $STATE_PENDING = 'P'; // Cuando se crea
    public static $STATE_ACTIVATED = 'A'; //Cuando se activa (se le envian los datos a Andiel para comenzar a gestionar)
    public static $STATE_CONFIRMED = 'C'; // Cuando se confirma que se puede realizar (Andiel confirma)
    public static $STATE_CANCELLED = 'X'; //
    public static $STATE_DONE = 'D'; //
    public static function getStateDesc($state) {
        $desc = array('title'=>__d('shared_travels', 'Pendiente'), 'class'=>'badge badge-secondary', 'description'=>__d('shared_travels', 'No has activado esta solicitud por lo cual no hemos empezado las gestiones. Revisa tu correo y dale click al enlace que te enviamos.'));
        if($state == SharedTravel::$STATE_ACTIVATED) $desc = array('title'=>__d('shared_travels', 'Activada / No confirmada'), 'class'=>'badge badge-info', 'description'=>__d('shared_travels', 'Ya activaste la solicitud y ahora estamos haciendo las gestiones. Te enviaremos un email con la confirmación de la recogida en la fecha y dirección indicada.'));
        else if($state == SharedTravel::$STATE_CONFIRMED) $desc = array('title'=>__d('shared_travels', 'Confirmada'), 'class'=>'badge badge-primary', 'description'=>__d('shared_travels', 'Ya tu viaje se encuentra en nuestra agenda para la fecha, hora y lugar indicado. Un taxi te buscará ese día a tu puerta!'));
        else if($state == SharedTravel::$STATE_CANCELLED) $desc = array('title'=>__d('shared_travels', 'Cancelada'), 'class'=>'badge badge-danger', 'description'=>__d('shared_travels', 'La solicitud fue cancelada por tí o por los administradores. La recogida está suspendida.'));
        
        return $desc;
    }
}
?>