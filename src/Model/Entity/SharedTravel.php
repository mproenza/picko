<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

class SharedTravel extends Entity {
    public static $localities = array(
        0=>['name'=>'La Habana', 'slug'=>'habana', 'code'=>'HAB'], 
        1=>['name'=>'Trinidad', 'slug'=>'trinidad', 'code'=>'TRI'], 
        2=>['name'=>'Viñales', 'slug'=>'vinales', 'code'=>'VIN'], 
        3=>['name'=>'Varadero', 'slug'=>'varadero', 'code'=>'VAR'],
        4=>['name'=>'Cienfuegos', 'slug'=>'cienfuegos', 'code'=>'CFG'], 
        7=>['name'=>'Santa Clara', 'slug'=>'santa-clara', 'code'=>'SCL'],
        5=>['name'=>'Cayo Coco', 'slug'=>'cayo-coco', 'code'=>'CAC'],
        6=>['name'=>'Cayo Guillermo', 'slug'=>'cayo-guillermo', 'code'=>'CAG'],
        8=>['name'=>'Playa Larga', 'slug'=>'playa-larga', 'code'=>'PLL'],
        9=>['name'=>'Playa Girón', 'slug'=>'playa-giron', 'code'=>'PLG', 'use_as_origin'=>false],
        10=>['name'=>'Cayo Santa María', 'slug'=>'cayo-santa-maria', 'code'=>'CAM', 'use_as_origin'=>false],
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
        ['origin_id'=>5, 'destination_id'=>0, 'price_x_seat'=>50, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>1, 'price_x_seat'=>35, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>3, 'price_x_seat'=>50, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>7, 'price_x_seat'=>45, 'departure_times'=>[14]],
        ['origin_id'=>6, 'destination_id'=>0, 'price_x_seat'=>55, 'departure_times'=>[14]],
        ['origin_id'=>6, 'destination_id'=>1, 'price_x_seat'=>40, 'departure_times'=>[14]],
        ['origin_id'=>6, 'destination_id'=>3, 'price_x_seat'=>55, 'departure_times'=>[14]],
        ['origin_id'=>6, 'destination_id'=>7, 'price_x_seat'=>50, 'departure_times'=>[14]],
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
        $route['destination'] = self::$localities[$route['destination_id']]['name'];
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
    
    /*public static $modalities = array(
        // El origin_id y el destination_id son indicadores unicos de cada lugar que se usan para recomendar transfers
        'HABTRI8'=>array('origin_id'=>0, 'destination_id'=>1, 'origin'=>'La Habana', 'destination'=>'Trinidad', 'time'=>'8 am', 'price'=>35),
        'HABTRI14'=>array('origin_id'=>0, 'destination_id'=>1, 'origin'=>'La Habana', 'destination'=>'Trinidad', 'time'=>'2 pm', 'price'=>35),
        'HABVIN8'=>array('origin_id'=>0, 'destination_id'=>2, 'origin'=>'La Habana', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>25, 'active'=>false),
        'HABVIN12'=>array('origin_id'=>0, 'destination_id'=>2, 'origin'=>'La Habana', 'destination'=>'Viñales', 'time'=>'12 pm', 'price'=>25, 'active'=>false),
        'HABVIN11'=>array('origin_id'=>0, 'destination_id'=>2, 'origin'=>'La Habana', 'destination'=>'Viñales', 'time'=>'11 am', 'price'=>25),
        'HABVAR8'=>array('origin_id'=>0, 'destination_id'=>3, 'origin'=>'La Habana', 'destination'=>'Varadero', 'time'=>'8 am', 'price'=>25, 'active'=>false),
        'HABVAR14'=>array('origin_id'=>0, 'destination_id'=>3, 'origin'=>'La Habana', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>25),
        'HABCFG8'=>array('origin_id'=>0, 'destination_id'=>4, 'origin'=>'La Habana', 'destination'=>'Cienfuegos', 'time'=>'8 am', 'price'=>35),
        'HABCFG14'=>array('origin_id'=>0, 'destination_id'=>4, 'origin'=>'La Habana', 'destination'=>'Cienfuegos', 'time'=>'2 pm', 'price'=>35),
        'HABSCL8'=>array('origin_id'=>0, 'destination_id'=>7, 'origin'=>'La Habana', 'destination'=>'Santa Clara', 'time'=>'8 am', 'price'=>35),
        'HABSCL14'=>array('origin_id'=>0, 'destination_id'=>7, 'origin'=>'La Habana', 'destination'=>'Santa Clara', 'time'=>'2 pm', 'price'=>35),
        'HABPLL8'=>array('origin_id'=>0, 'destination_id'=>8, 'origin'=>'La Habana', 'destination'=>'Playa Larga', 'time'=>'8 am', 'price'=>30),
        'HABPLL14'=>array('origin_id'=>0, 'destination_id'=>8, 'origin'=>'La Habana', 'destination'=>'Playa Larga', 'time'=>'2 pm', 'price'=>30),
        'HABPLG8'=>array('origin_id'=>0, 'destination_id'=>9, 'origin'=>'La Habana', 'destination'=>'Playa Girón', 'time'=>'8 am', 'price'=>30),
        'HABPLG14'=>array('origin_id'=>0, 'destination_id'=>9, 'origin'=>'La Habana', 'destination'=>'Playa Girón', 'time'=>'2 pm', 'price'=>30),
        
        'TRIHAB8'=>array('origin_id'=>1, 'destination_id'=>0, 'origin'=>'Trinidad', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>35),
        'TRIHAB14'=>array('origin_id'=>1, 'destination_id'=>0, 'origin'=>'Trinidad', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>35),
        'TRIVIN8'=>array('origin_id'=>1, 'destination_id'=>2, 'origin'=>'Trinidad', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>50),
        'TRIVAR8'=>array('origin_id'=>1, 'destination_id'=>3, 'origin'=>'Trinidad', 'destination'=>'Varadero', 'time'=>'8 am', 'price'=>35),
        'TRIVAR14'=>array('origin_id'=>1, 'destination_id'=>3,'origin'=>'Trinidad', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>35),
        'TRICAM8'=>array('origin_id'=>1, 'destination_id'=>10, 'origin'=>'Trinidad', 'destination'=>'Cayo Santa María', 'time'=>'8 am', 'price'=>35),
        'TRICAC8'=>array('origin_id'=>1, 'destination_id'=>5, 'origin'=>'Trinidad', 'destination'=>'Cayo Coco', 'time'=>'8 am', 'price'=>35),
        'TRICAG8'=>array('origin_id'=>1, 'destination_id'=>6, 'origin'=>'Trinidad', 'destination'=>'Cayo Guillermo', 'time'=>'8 am', 'price'=>40),
        'TRIPLL8'=>array('origin_id'=>1, 'destination_id'=>8, 'origin'=>'Trinidad', 'destination'=>'Playa Larga', 'time'=>'8 am', 'price'=>30),
        'TRIPLL14'=>array('origin_id'=>1, 'destination_id'=>8, 'origin'=>'Trinidad', 'destination'=>'Playa Larga', 'time'=>'2 pm', 'price'=>30),
        'TRIPLG8'=>array('origin_id'=>1, 'destination_id'=>9, 'origin'=>'Trinidad', 'destination'=>'Playa Girón', 'time'=>'8 am', 'price'=>30),
        'TRIPLG14'=>array('origin_id'=>1, 'destination_id'=>9, 'origin'=>'Trinidad', 'destination'=>'Playa Girón', 'time'=>'2 pm', 'price'=>30),
        
        'VINHAB8'=>array('origin_id'=>2, 'destination_id'=>0, 'origin'=>'Viñales', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>25),
        'VINHAB14'=>array('origin_id'=>2, 'destination_id'=>0, 'origin'=>'Viñales', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>25),        
        'VINVAR8'=>array('origin_id'=>2, 'destination_id'=>3, 'origin'=>'Viñales', 'destination'=>'Varadero', 'time'=>'8 am', 'price'=>45),
        'VINVAR14'=>array('origin_id'=>2, 'destination_id'=>3, 'origin'=>'Viñales', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>45),        
        'VINTRI8'=>array('origin_id'=>2, 'destination_id'=>1, 'origin'=>'Viñales', 'destination'=>'Trinidad', 'time'=>'8 am', 'price'=>50),
        'VINCFG8'=>array('origin_id'=>2, 'destination_id'=>4, 'origin'=>'Viñales', 'destination'=>'Cienfuegos', 'time'=>'8 am', 'price'=>50),
        'VINSCL8'=>array('origin_id'=>2, 'destination_id'=>7, 'origin'=>'Viñales', 'destination'=>'Santa Clara', 'time'=>'8 am', 'price'=>45),
        'VINPLL8'=>array('origin_id'=>2, 'destination_id'=>8, 'origin'=>'Viñales', 'destination'=>'Playa Larga', 'time'=>'8 am', 'price'=>40),
        'VINPLG8'=>array('origin_id'=>2, 'destination_id'=>9, 'origin'=>'Viñales', 'destination'=>'Playa Girón', 'time'=>'8 am', 'price'=>45),
        
        'VARHAB8'=>array('origin_id'=>3, 'destination_id'=>0, 'origin'=>'Varadero', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>30),
        'VARHAB14'=>array('origin_id'=>3, 'destination_id'=>0, 'origin'=>'Varadero', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>30),
        'VARTRI14'=>array('origin_id'=>3, 'destination_id'=>1, 'origin'=>'Varadero', 'destination'=>'Trinidad', 'time'=>'2 pm', 'price'=>35),
        'VARVIN8'=>array('origin_id'=>3, 'destination_id'=>2, 'origin'=>'Varadero', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>50),
        'VARCFG14'=>array('origin_id'=>3, 'destination_id'=>4, 'origin'=>'Varadero', 'destination'=>'Cienfuegos', 'time'=>'2 pm', 'price'=>35),
        
        
        'CFGHAB8'=>array('origin_id'=>4, 'destination_id'=>0, 'origin'=>'Cienfuegos', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>35),
        'CFGHAB14'=>array('origin_id'=>4, 'destination_id'=>0, 'origin'=>'Cienfuegos', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>35),
        'CFGTRI7'=>array('origin_id'=>4, 'destination_id'=>1, 'origin'=>'Cienfuegos', 'destination'=>'Trinidad', 'time'=>'7 am', 'price'=>15),
        'CFGVIN8'=>array('origin_id'=>4, 'destination_id'=>2, 'origin'=>'Cienfuegos', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>50),
        'CFGVAR8'=>array('origin_id'=>4, 'destination_id'=>3, 'origin'=>'Cienfuegos', 'destination'=>'Varadero', 'time'=>'8 am', 'price'=>35),
        'CFGVAR14'=>array('origin_id'=>4, 'destination_id'=>3,'origin'=>'Cienfuegos', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>35),
        'CFGCAC8'=>array('origin_id'=>4, 'destination_id'=>5, 'origin'=>'Cienfuegos', 'destination'=>'Cayo Coco', 'time'=>'8 am', 'price'=>40),
        'CFGCAG8'=>array('origin_id'=>4, 'destination_id'=>6, 'origin'=>'Cienfuegos', 'destination'=>'Cayo Guillermo', 'time'=>'8 am', 'price'=>45),
        'CFGPLL8'=>array('origin_id'=>4, 'destination_id'=>8, 'origin'=>'Cienfuegos', 'destination'=>'Playa Larga', 'time'=>'8 am', 'price'=>30),
        'CFGPLL14'=>array('origin_id'=>4, 'destination_id'=>8, 'origin'=>'Cienfuegos', 'destination'=>'Playa Larga', 'time'=>'2 pm', 'price'=>30),
        'CFGPLG8'=>array('origin_id'=>4, 'destination_id'=>9, 'origin'=>'Cienfuegos', 'destination'=>'Playa Girón', 'time'=>'8 am', 'price'=>30),
        'CFGPLG14'=>array('origin_id'=>4, 'destination_id'=>9, 'origin'=>'Cienfuegos', 'destination'=>'Playa Girón', 'time'=>'2 pm', 'price'=>30),
        
        'CACHAB14'=>array('origin_id'=>5, 'destination_id'=>0, 'origin'=>'Cayo Coco', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>50),
        'CACTRI14'=>array('origin_id'=>5, 'destination_id'=>1, 'origin'=>'Cayo Coco', 'destination'=>'Trinidad', 'time'=>'2 pm', 'price'=>35),
        'CACVAR14'=>array('origin_id'=>5, 'destination_id'=>3, 'origin'=>'Cayo Coco', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>50),
        'CACSCL14'=>array('origin_id'=>5, 'destination_id'=>7, 'origin'=>'Cayo Coco', 'destination'=>'Santa Clara', 'time'=>'2 pm', 'price'=>45),
        
        'CAGHAB14'=>array('origin_id'=>6, 'destination_id'=>0, 'origin'=>'Cayo Guillermo', 'destination'=>'La Habana', 'time'=>'2 pm', 'price'=>55),
        'CAGTRI14'=>array('origin_id'=>6, 'destination_id'=>1, 'origin'=>'Cayo Guillermo', 'destination'=>'Trinidad', 'time'=>'2 pm', 'price'=>40),
        'CAGVAR14'=>array('origin_id'=>6, 'destination_id'=>3, 'origin'=>'Cayo Guillermo', 'destination'=>'Varadero', 'time'=>'2 pm', 'price'=>55),
        'CAGSCL14'=>array('origin_id'=>6, 'destination_id'=>7, 'origin'=>'Cayo Guillermo', 'destination'=>'Santa Clara', 'time'=>'2 pm', 'price'=>50),
        
        'SCLHAB8'=>array('origin_id'=>7, 'destination_id'=>0, 'origin'=>'Santa Clara', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>35),
        'SCLVIN8'=>array('origin_id'=>7, 'destination_id'=>2, 'origin'=>'Santa Clara', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>45),        
        'SCLVAR8'=>array('origin_id'=>7, 'destination_id'=>3, 'origin'=>'Santa Clara', 'destination'=>'Varadero', 'time'=>'8 am', 'price'=>35),        
        'SCLPLL8'=>array('origin_id'=>7, 'destination_id'=>8, 'origin'=>'Santa Clara', 'destination'=>'Playa Larga', 'time'=>'8 am', 'price'=>35),        
        'SCLPLG8'=>array('origin_id'=>7, 'destination_id'=>9, 'origin'=>'Santa Clara', 'destination'=>'Playa Girón', 'time'=>'8 am', 'price'=>35),        
        
        'PLLHAB8'=>array('origin_id'=>8, 'destination_id'=>0, 'origin'=>'Playa Larga', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>30),
        'PLLHAB10'=>array('origin_id'=>8, 'destination_id'=>0, 'origin'=>'Playa Larga', 'destination'=>'La Habana', 'time'=>'10 am', 'price'=>30),
        'PLLVIN8'=>array('origin_id'=>8, 'destination_id'=>2, 'origin'=>'Playa Larga', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>40),
        'PLLVIN10'=>array('origin_id'=>8, 'destination_id'=>2, 'origin'=>'Playa Larga', 'destination'=>'Viñales', 'time'=>'10 am', 'price'=>40),
        'PLLTRI11'=>array('origin_id'=>8, 'destination_id'=>1, 'origin'=>'Playa Larga', 'destination'=>'Trinidad', 'time'=>'11 am', 'price'=>30),
        'PLLTRI16'=>array('origin_id'=>8, 'destination_id'=>1, 'origin'=>'Playa Larga', 'destination'=>'Trinidad', 'time'=>'4 pm', 'price'=>30),
        'PLLCFG11'=>array('origin_id'=>8, 'destination_id'=>4, 'origin'=>'Playa Larga', 'destination'=>'Cienfuegos', 'time'=>'11 am', 'price'=>30),
        'PLLCFG16'=>array('origin_id'=>8, 'destination_id'=>4, 'origin'=>'Playa Larga', 'destination'=>'Cienfuegos', 'time'=>'4 pm', 'price'=>30),        
        
        'PLGHAB8'=>array('origin_id'=>9, 'destination_id'=>0, 'origin'=>'Playa Girón', 'destination'=>'La Habana', 'time'=>'8 am', 'price'=>30),
        'PLGHAB10'=>array('origin_id'=>9, 'destination_id'=>0, 'origin'=>'Playa Girón', 'destination'=>'La Habana', 'time'=>'10 am', 'price'=>30),
        'PLGVIN8'=>array('origin_id'=>9, 'destination_id'=>2, 'origin'=>'Playa Girón', 'destination'=>'Viñales', 'time'=>'8 am', 'price'=>45),
        'PLGVIN10'=>array('origin_id'=>9, 'destination_id'=>2, 'origin'=>'Playa Girón', 'destination'=>'Viñales', 'time'=>'10 am', 'price'=>45),
        'PLGTRI11'=>array('origin_id'=>9, 'destination_id'=>1, 'origin'=>'Playa Girón', 'destination'=>'Trinidad', 'time'=>'11 am', 'price'=>30),
        'PLGTRI16'=>array('origin_id'=>9, 'destination_id'=>1, 'origin'=>'Playa Girón', 'destination'=>'Trinidad', 'time'=>'4 pm', 'price'=>30),
        'PLGCFG11'=>array('origin_id'=>9, 'destination_id'=>4, 'origin'=>'Playa Girón', 'destination'=>'Cienfuegos', 'time'=>'11 am', 'price'=>30),
        'PLGCFG16'=>array('origin_id'=>9, 'destination_id'=>4, 'origin'=>'Playa Girón', 'destination'=>'Cienfuegos', 'time'=>'4 pm', 'price'=>30),
    );*/
    
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