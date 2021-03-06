<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
use App\Util\TimeUtil;

class SharedTravel extends Entity {
    
    //protected $_hidden = ['modified', 'from_ip', 'old_state', 'old_date', 'old_address_origin', 'old_address_destination'];
    
    
    public static $EVENT_TYPE_CREATED = 'N';
    public static $EVENT_TYPE_ACTIVATED = 'A';
    public static $EVENT_TYPE_CONFIRMED = 'C';
    public static $EVENT_TYPE_CANCELLED = 'X';
    public static $EVENT_TYPE_INFO_EDITED = 'E';
    
    public static $localities = array(
        0=>['name'=>'La Habana', 'slug'=>'habana', 'code'=>'HAB', 'short'=>'Hab'],
        2=>['name'=>'Viñales', 'slug'=>'vinales', 'code'=>'VIN', 'short'=>'Viñ'], 
        3=>['name'=>'Varadero', 'slug'=>'varadero', 'code'=>'VAR', 'short'=>'Var'],
        1=>['name'=>'Trinidad', 'slug'=>'trinidad', 'code'=>'TRI', 'short'=>'Tri'],
        4=>['name'=>'Cienfuegos', 'slug'=>'cienfuegos', 'code'=>'CFG', 'short'=>'Cfg'],
        7=>['name'=>'Santa Clara', 'slug'=>'santa-clara', 'code'=>'SCL', 'short'=>'S. Clara', 'use_as_origin'=>false],
        10=>['name'=>'Cayo Santa María', 'slug'=>'cayo-santa-maria', 'code'=>'CSM', 'short'=>'C. Sta Maria'],
        5=>['name'=>'Cayo Coco', 'slug'=>'cayo-coco', 'code'=>'CAC', 'short'=>'C. Coco'],
        6=>['name'=>'Cayo Guillermo', 'slug'=>'cayo-guillermo', 'code'=>'CAG', 'short'=>'C. Guillermo'],
        8=>['name'=>'Playa Larga', 'slug'=>'playa-larga', 'code'=>'PLL', 'short'=>'P. Larga'],
        9=>['name'=>'Playa Girón', 'slug'=>'playa-giron', 'code'=>'PLG', 'short'=>'P. Giron', 'use_as_origin'=>false],
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
            10=>['kms'=>'350', 'hrs'=>'4'],
        ],
        
        1 => [
            2=>['kms'=>'560', 'hrs'=>'6.30'],
            3=>['kms'=>'300', 'hrs'=>'4'],
            4=>['kms'=>'80', 'hrs'=>'1'],
            5=>['kms'=>'250', 'hrs'=>'3.30'],
            6=>['kms'=>'290', 'hrs'=>'4'],
            7=>['kms'=>'120', 'hrs'=>'2'],
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
            10=>['kms'=>'550', 'hrs'=>'6.30'],
        ],
        
        3 => [
            4=>['kms'=>'200', 'hrs'=>'3'],
            5=>['kms'=>'500', 'hrs'=>'6.30'],
            6=>['kms'=>'540', 'hrs'=>'7'],
            7=>['kms'=>'230', 'hrs'=>'3'],
            8=>['kms'=>'130', 'hrs'=>'2'],
            10=>['kms'=>'340', 'hrs'=>'4'],
        ],
        
        4 => [
            5=>['kms'=>'320', 'hrs'=>'4'],
            6=>['kms'=>'360', 'hrs'=>'4.30'],
            7=>['kms'=>'75', 'hrs'=>'1.30'],
            8=>['kms'=>'150', 'hrs'=>'2'],
            9=>['kms'=>'110', 'hrs'=>'1.30'],
            10=>['kms'=>'180', 'hrs'=>'2.30'],
        ],
        
        5 => [
            7=>['kms'=>'200', 'hrs'=>'3'],
            10=>['kms'=>'230', 'hrs'=>'3.30'],
        ],
        
        6 => [
            7=>['kms'=>'290', 'hrs'=>'3.30'],
            10=>['kms'=>'260', 'hrs'=>'4'],
        ],
        
        7 => [
            8=>['kms'=>'160', 'hrs'=>'2'],
            9=>['kms'=>'200', 'hrs'=>'2.30'],
            10=>['kms'=>'100', 'hrs'=>'1.30'],
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
    
    public static $combos = [
        // HABANA
        'habana-cayo-coco-via-trinidad' => [
            'route1'=>['origin_id'=>0, 'destination_id'=>1],
            'route2'=>['origin_id'=>1, 'destination_id'=>5],
            'private_taxi_price'=>250,
            'picko_private_taxi_price'=>250,
            'viazul'=>[
                'destination'=>'Ciego de Ávila', 
                'price_x_seat'=>27,
                'earlier_arrival_time'=>'2 pm',
                'private_taxi_price_to_final_destination'=>70,
                'private_taxi_ride_time'=>'2 hrs']
        ],
        'habana-cayo-coco-via-cienfuegos' => [
            'route1'=>['origin_id'=>0, 'destination_id'=>4],
            'route2'=>['origin_id'=>4, 'destination_id'=>5],
            'private_taxi_price'=>250,
            'viazul'=>[
                'destination'=>'Ciego de Ávila', 
                'price_x_seat'=>27,
                'earlier_arrival_time'=>'2 pm',
                'private_taxi_price_to_final_destination'=>70,
                'private_taxi_ride_time'=>'2 hrs']
        ],
        'habana-cayo-guillermo-via-trinidad' => [
            'route1'=>['origin_id'=>0, 'destination_id'=>1],
            'route2'=>['origin_id'=>1, 'destination_id'=>6],
            'private_taxi_price'=>250,
            'viazul'=>[
                'destination'=>'Ciego de Ávila', 
                'price_x_seat'=>27,
                'earlier_arrival_time'=>'2 pm',
                'private_taxi_price_to_final_destination'=>90,
                'private_taxi_ride_time'=>'2 hrs']
                
        ],
        'habana-cayo-guillermo-via-cienfuegos' => [
            'route1'=>['origin_id'=>0, 'destination_id'=>4],
            'route2'=>['origin_id'=>4, 'destination_id'=>6],
            'private_taxi_price'=>250,
            'viazul'=>[
                'destination'=>'Ciego de Ávila', 
                'price_x_seat'=>27,
                'earlier_arrival_time'=>'2 pm',
                'private_taxi_price_to_final_destination'=>90,
                'private_taxi_ride_time'=>'2 hrs']
        ],
        
        // VARADERO
        'varadero-cayo-coco-via-trinidad' => [
            'route1'=>['origin_id'=>3, 'destination_id'=>1],
            'route2'=>['origin_id'=>1, 'destination_id'=>5],
            'private_taxi_price'=>250,
            'viazul'=>[
                'destination'=>'Ciego de Ávila',
                'price_x_seat'=>19,
                'earlier_arrival_time'=>'3:20 am',
                'private_taxi_price_to_final_destination'=>70,
                'private_taxi_ride_time'=>'2 hrs']
        ],
        'varadero-cayo-coco-via-cienfuegos' => [
            'route1'=>['origin_id'=>3, 'destination_id'=>4],
            'route2'=>['origin_id'=>4, 'destination_id'=>5],
            'private_taxi_price'=>250,
            'viazul'=>[
                'destination'=>'Ciego de Ávila', 
                'price_x_seat'=>19,
                'earlier_arrival_time'=>'3:20 am',
                'private_taxi_price_to_final_destination'=>70,
                'private_taxi_ride_time'=>'2 hrs']
        ],
        'varadero-cayo-guillermo-via-trinidad' => [
            'route1'=>['origin_id'=>3, 'destination_id'=>1],
            'route2'=>['origin_id'=>1, 'destination_id'=>6],
            'private_taxi_price'=>250,
            'viazul'=>[
                'destination'=>'Ciego de Ávila', 
                'price_x_seat'=>19,
                'earlier_arrival_time'=>'3:20 am',
                'private_taxi_price_to_final_destination'=>90,
                'private_taxi_ride_time'=>'2 hrs']
                
        ],
        'varadero-cayo-guillermo-via-cienfuegos' => [
            'route1'=>['origin_id'=>3, 'destination_id'=>4],
            'route2'=>['origin_id'=>4, 'destination_id'=>6],
            'private_taxi_price'=>250,
            'viazul'=>[
                'destination'=>'Ciego de Ávila', 
                'price_x_seat'=>19,
                'earlier_arrival_time'=>'3:20 am',
                'private_taxi_price_to_final_destination'=>90,
                'private_taxi_ride_time'=>'2 hrs']
        ],
    ];
    
    public static function getCombosStartingAt($originId) {
        $combos = [];
        foreach (self::$combos as $key=>$c) {
            if($c['route1']['origin_id'] == $originId) $combos[] = [$key=>$c];
        }
        
        return $combos;
    }
    
    /*
        0=>['name'=>'La Habana', 'slug'=>'habana', 'code'=>'HAB', 'short'=>'Hab'],
        2=>['name'=>'Viñales', 'slug'=>'vinales', 'code'=>'VIN', 'short'=>'Viñ'], 
        3=>['name'=>'Varadero', 'slug'=>'varadero', 'code'=>'VAR', 'short'=>'Var'],
        1=>['name'=>'Trinidad', 'slug'=>'trinidad', 'code'=>'TRI', 'short'=>'Tri'],
        4=>['name'=>'Cienfuegos', 'slug'=>'cienfuegos', 'code'=>'CFG', 'short'=>'Cfg'],
        7=>['name'=>'Santa Clara', 'slug'=>'santa-clara', 'code'=>'SCL', 'short'=>'S. Clara'],
        10=>['name'=>'Cayo Santa María', 'slug'=>'cayo-santa-maria', 'code'=>'CSM', 'short'=>'C. Sta Maria'],
        5=>['name'=>'Cayo Coco', 'slug'=>'cayo-coco', 'code'=>'CAC', 'short'=>'C. Coco'],
        6=>['name'=>'Cayo Guillermo', 'slug'=>'cayo-guillermo', 'code'=>'CAG', 'short'=>'C. Guillermo'],
        8=>['name'=>'Playa Larga', 'slug'=>'playa-larga', 'code'=>'PLL', 'short'=>'P. Larga'],
        9=>['name'=>'Playa Girón', 'slug'=>'playa-giron', 'code'=>'PLG', 'short'=>'P. Giron', 'use_as_origin'=>false],
     * 
     */
    
    public static $routes = [
        ['origin_id'=>0, 'destination_id'=>2, 'price_x_seat'=>30, 'departure_times'=>[11]],
        ['origin_id'=>0, 'destination_id'=>3, 'price_x_seat'=>30, 'departure_times'=>[8, 14]],
        ['origin_id'=>0, 'destination_id'=>1, 'price_x_seat'=>40, 'departure_times'=>[8, 14]],
        ['origin_id'=>0, 'destination_id'=>4, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>0, 'destination_id'=>8, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>0, 'destination_id'=>9, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>0, 'destination_id'=>7, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>0, 'destination_id'=>10, 'price_x_seat'=>60, 'departure_times'=>[8, 14]],
        
        ['origin_id'=>1, 'destination_id'=>0, 'price_x_seat'=>40, 'departure_times'=>[8, 14]],
        ['origin_id'=>1, 'destination_id'=>3, 'price_x_seat'=>40, 'departure_times'=>[8, 14]],
        ['origin_id'=>1, 'destination_id'=>2, 'price_x_seat'=>60, 'departure_times'=>[8]],
        ['origin_id'=>1, 'destination_id'=>7, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>1, 'destination_id'=>10, 'price_x_seat'=>40, 'departure_times'=>[8]],
        ['origin_id'=>1, 'destination_id'=>5, 'price_x_seat'=>40, 'departure_times'=>[8]],
        ['origin_id'=>1, 'destination_id'=>6, 'price_x_seat'=>40, 'departure_times'=>[8]],
        ['origin_id'=>1, 'destination_id'=>8, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        ['origin_id'=>1, 'destination_id'=>9, 'price_x_seat'=>35, 'departure_times'=>[8, 14]],
        
        ['origin_id'=>2, 'destination_id'=>0, 'price_x_seat'=>30, 'departure_times'=>[8, 14]],
        ['origin_id'=>2, 'destination_id'=>3, 'price_x_seat'=>50, 'departure_times'=>[8, 14]],
        ['origin_id'=>2, 'destination_id'=>1, 'price_x_seat'=>60, 'departure_times'=>[8]],
        ['origin_id'=>2, 'destination_id'=>4, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>2, 'destination_id'=>7, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>2, 'destination_id'=>8, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>2, 'destination_id'=>9, 'price_x_seat'=>50, 'departure_times'=>[8]],
        
        ['origin_id'=>3, 'destination_id'=>0, 'price_x_seat'=>30, 'departure_times'=>[8, 11, 14, 18]],
        ['origin_id'=>3, 'destination_id'=>2, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>3, 'destination_id'=>1, 'price_x_seat'=>40, 'departure_times'=>[14]],
        ['origin_id'=>3, 'destination_id'=>4, 'price_x_seat'=>35, 'departure_times'=>[14]],
        ['origin_id'=>3, 'destination_id'=>7, 'price_x_seat'=>35, 'departure_times'=>[14]],
        ['origin_id'=>3, 'destination_id'=>10, 'price_x_seat'=>60, 'departure_times'=>[14]],
        
        ['origin_id'=>4, 'destination_id'=>0, 'price_x_seat'=>35, 'departure_times'=>[9, 15]],
        ['origin_id'=>4, 'destination_id'=>2, 'price_x_seat'=>50, 'departure_times'=>[9]],
        ['origin_id'=>4, 'destination_id'=>3, 'price_x_seat'=>35, 'departure_times'=>[9, 15]],
        ['origin_id'=>4, 'destination_id'=>1, 'price_x_seat'=>20, 'departure_times'=>[7, 17]],  
        ['origin_id'=>4, 'destination_id'=>7, 'price_x_seat'=>35, 'departure_times'=>[7]],
        ['origin_id'=>4, 'destination_id'=>10, 'price_x_seat'=>40, 'departure_times'=>[7]],
        ['origin_id'=>4, 'destination_id'=>5, 'price_x_seat'=>50, 'departure_times'=>[7]],
        ['origin_id'=>4, 'destination_id'=>6, 'price_x_seat'=>55, 'departure_times'=>[7]],
        ['origin_id'=>4, 'destination_id'=>8, 'price_x_seat'=>35, 'departure_times'=>[9, 15]],
        ['origin_id'=>4, 'destination_id'=>9, 'price_x_seat'=>35, 'departure_times'=>[9, 15]],
        
        ['origin_id'=>5, 'destination_id'=>0, 'price_x_seat'=>70, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>3, 'price_x_seat'=>70, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>1, 'price_x_seat'=>50, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>4, 'price_x_seat'=>50, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>7, 'price_x_seat'=>50, 'departure_times'=>[14]],
        ['origin_id'=>5, 'destination_id'=>10, 'price_x_seat'=>50, 'departure_times'=>[14]],
        
        ['origin_id'=>6, 'destination_id'=>0, 'price_x_seat'=>70, 'departure_times'=>[13]],
        ['origin_id'=>6, 'destination_id'=>3, 'price_x_seat'=>70, 'departure_times'=>[13]],
        ['origin_id'=>6, 'destination_id'=>1, 'price_x_seat'=>50, 'departure_times'=>[13]],
        ['origin_id'=>6, 'destination_id'=>4, 'price_x_seat'=>50, 'departure_times'=>[13]],
        ['origin_id'=>6, 'destination_id'=>7, 'price_x_seat'=>50, 'departure_times'=>[13]],
        ['origin_id'=>6, 'destination_id'=>10, 'price_x_seat'=>50, 'departure_times'=>[13]],
        
        ['origin_id'=>7, 'destination_id'=>0, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>7, 'destination_id'=>2, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>7, 'destination_id'=>3, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>7, 'destination_id'=>8, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>7, 'destination_id'=>9, 'price_x_seat'=>35, 'departure_times'=>[8]],
        
        ['origin_id'=>8, 'destination_id'=>0, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>8, 'destination_id'=>3, 'price_x_seat'=>35, 'departure_times'=>[8]],
        ['origin_id'=>8, 'destination_id'=>2, 'price_x_seat'=>50, 'departure_times'=>[8]],
        ['origin_id'=>8, 'destination_id'=>1, 'price_x_seat'=>35, 'departure_times'=>[10, 16]],
        ['origin_id'=>8, 'destination_id'=>4, 'price_x_seat'=>30, 'departure_times'=>[10, 16]],
        
        ['origin_id'=>9, 'destination_id'=>0, 'price_x_seat'=>35, 'departure_times'=>[11]],
        ['origin_id'=>9, 'destination_id'=>2, 'price_x_seat'=>50, 'departure_times'=>[11]],
        ['origin_id'=>9, 'destination_id'=>1, 'price_x_seat'=>35, 'departure_times'=>[11, 16]],
        ['origin_id'=>9, 'destination_id'=>4, 'price_x_seat'=>35, 'departure_times'=>[11, 16]],
        
        ['origin_id'=>10, 'destination_id'=>0, 'price_x_seat'=>60, 'departure_times'=>[14]],
        ['origin_id'=>10, 'destination_id'=>3, 'price_x_seat'=>60, 'departure_times'=>[14]],
        //['origin_id'=>10, 'destination_id'=>2, 'price_x_seat'=>75, 'departure_times'=>[14]],
        ['origin_id'=>10, 'destination_id'=>1, 'price_x_seat'=>40, 'departure_times'=>[14]],
        ['origin_id'=>10, 'destination_id'=>4, 'price_x_seat'=>40, 'departure_times'=>[14]],
        ['origin_id'=>10, 'destination_id'=>7, 'price_x_seat'=>35, 'departure_times'=>[14]],
    ];
    public static function _routeFull($route) {
        // Evitar ponerle los datos extra a las rutas si ya se hizo (esto es porque se pudiera llamar a _routeFull() varias veces en una ejecucion)
        if(isset($route['isFull']) && $route['isFull']) return $route;
        
        $route['origin'] = __(self::$localities[$route['origin_id']]['name']);
        $route['origin_short'] = self::$localities[$route['origin_id']]['short'];
        $route['destination'] = __(self::$localities[$route['destination_id']]['name']);
        $route['destination_short'] = self::$localities[$route['destination_id']]['short'];
        $route['code'] = self::$localities[$route['origin_id']]['code'].self::$localities[$route['destination_id']]['code'];
        $route['slug'] = 'taxi-'.self::$localities[$route['origin_id']]['slug'].'--'.self::$localities[$route['destination_id']]['slug'];
        
        // Poner am y pm a la hora de salida
        if(isset($route['departure_time'])) {
            $route['departure_time_desc'] = TimeUtil::getTimeAmPM($route['departure_time']);
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
            $route['departure_times_desc'][] = TimeUtil::getTimeAmPM($time);
        }
        $route['departure_times_desc_string'] = implode(' | ', $route['departure_times_desc']);
        
        $route['isFull'] = true;
        
        return $route;
    }
    public static function addRouteInfo($sharedTravel) {
        // Evitar ponerle los datos extra a las rutas si ya se hizo (esto es porque se pudiera llamar a _routeFull() varias veces en una ejecucion)
        if(isset($sharedTravel->routeInfoAdded) && $sharedTravel->routeInfoAdded) return $sharedTravel;
        
        // Adicionar campos a la solicitud
        $sharedTravel->origin = self::$localities[$sharedTravel->origin_id]['name'];
        $sharedTravel->origin_short = self::$localities[$sharedTravel->origin_id]['short'];
        $sharedTravel->destination = self::$localities[$sharedTravel->destination_id]['name'];
        $sharedTravel->destination_short = self::$localities[$sharedTravel->destination_id]['short'];
        $sharedTravel->code = self::$localities[$sharedTravel->origin_id]['code'].self::$localities[$sharedTravel->destination_id]['code'];
        $sharedTravel->slug = 'taxi-'.self::$localities[$sharedTravel->origin_id]['slug'].'--'.self::$localities[$sharedTravel->destination_id]['slug'];
        
        // Poner am y pm a la hora de salida
        if(isset($sharedTravel->departure_time)) {
            $sharedTravel->departure_time_desc = TimeUtil::getTimeAmPM($sharedTravel->departure_time);
        }
        
        if(!isset($sharedTravel->departure_times)) {
            foreach (self::$routes as $r) { // Poner los departure_times si le faltan
                if($r['origin_id'] == $sharedTravel->origin_id && $r['destination_id'] == $sharedTravel->destination_id) {
                    $sharedTravel->departure_times = $r['departure_times'];
                }
            }
        }
        
        // Poner am y pm a los horarios de salida
        foreach ($sharedTravel->departure_times as $time) {
            $sharedTravel->departure_times_desc[] = TimeUtil::getTimeAmPM($time);
        }
        
        $sharedTravel->routeInfoAdded = true;
        
        return $sharedTravel;
    }
    
    public static function getTotalPrice($request) {
        return $request['people_count']*$request['price_x_seat'] - $request['discount_total'] + $request['fee_total'];
    }
    
    public function getOriginId() {
        if(is_array($this->origin_id)) return $this->origin_id['id'];
        return $this->origin_id;
    }
    public function getDestinationId() {
        if(is_array($this->destination_id)) return $this->destination_id['id'];
        return $this->destination_id;
    }
    
    public function getOriginName() {
        return self::$localities[$this->getOriginId()]['name'];
    }
    public function getOriginAbbr() {
        return self::$localities[$this->getOriginId()]['short'];
    }
    public function getDestinationName() {
        return self::$localities[$this->getDestinationId()]['name'];
    }
    public function getDestinationAbbr() {
        return self::$localities[$this->getDestinationId()]['short'];
    }
    public function getRouteCode() {
        return self::$localities[$this->getOriginId()]['code'].self::$localities[$this->getDestinationId()]['code'];        
    }
    public function getRouteSlug() {
        return 'taxi-'.self::$localities[$this->getOriginId()]['slug'].'--'.self::$localities[$this->getDestinationId()]['slug'];
    }
    public function getRouteDepartureTimes() {
        foreach (self::$routes as $r) { // Poner los departure_times si le faltan
            if($r['origin_id'] == $this->getOriginId() && $r['destination_id'] == $this->getDestinationId()) {
                return $r['departure_times'];
            }
        }
    }
    public function getDepartureTimeDesc() {
        // Poner am y pm a la hora de salida
        $dt = null;
        
        if(isset($this->departure_time)) {
            $dt = TimeUtil::getTimeAmPM($this->departure_time);
        }
        
        return $dt;
    }
    public function getRouteDepartureTimesDesc() {
        $departureTimes = $this->getRouteDepartureTimes();
        
        $dts = null;
        // Poner am y pm a los horarios de salida
        foreach ($departureTimes as $time) {
            $dts[] = TimeUtil::getTimeAmPM($time);
        }
        
        return $dts;
    }
    public function getRouteDepartureTimesDescString() {
        $departureTimes = $this->getRouteDepartureTimesDesc();
        
        return implode(' | ', $departureTimes);
    }
    
    /**
     * Retorna null si no hay matcheo
     * * Debe decir 'taxi-' delante, debe tener el separador '--', deben existir los slug, etc...
     * @param slug
     * @return type
     * @throws NotFoundException
     */
    public static function _routeFromSlug($slug) {
        // Sanity checks
        if($slug == null) return null;
        if(substr($slug, 0, 5) != 'taxi-') return null;
        
        $slug = substr($slug, 5); // Eliminar 'taxi-'
        
        // Buscar si tiene '--' que es lo que delimita los slug del origen y el destino
        $pos = strpos($slug, '--');
        
        if(!$pos) return null;
        
        // OK
        
        // Obtener el slug del origen y el destino
        $originSlug = substr($slug, 0, $pos);
        $destSlug = substr($slug, $pos + 2);
        
        // Convertir los slugs a ids
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
        
        
        return self::_routeFromOriginDestination($originId, $destId);
        
        /*// Buscar la ruta que coincida con los id del origen y el destino
        $route = null;
        foreach (self::$routes as $r) {
            if($r['origin_id'] == $originId && $r['destination_id'] == $destId) {
                $route = $r;
                break;
            }
        }
        
        return $route;*/
    }
    public static function _routeFromOriginDestination($originId, $destinationId) {
        // Buscar la ruta que coincida con los id del origen y el destino
        $route = null;
        foreach (self::$routes as $r) {
            if($r['origin_id'] == $originId && $r['destination_id'] == $destinationId) {
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
    
    
    public static $finalStates = ['D' => 'Realizado', 'XT' => 'Taxi no llegó', 'XC'=>'Cliente no apareció', '-'=>'Sin definir'];
    
    
    public function updateField($fields, $options = []) {
        
        $_defaults = ['keep_old_value'=>true];
        $options = $options + $_defaults;
        
        // Actualizar todos los campos
        foreach ($fields as $key => $value) {
            // Salvar el valor anterior
            if($options['keep_old_value']) {
                $oldFieldName = 'old_'.$key;
                $this->$oldFieldName = $this->$key;
            }

            $this->$key = $value;
        }
    }
    
    
    // ************ API *****************
    
    public static function preprocessForApi($entity) {
        unset($entity->old_date);
        unset($entity->old_state);
        unset($entity->old_address_origin);
        unset($entity->old_final_state);
        unset($entity->modified);
        unset($entity->fee_total);
        unset($entity->discount_total);

        $entity->origin_id = ['id'=>$entity->origin_id];
        $entity->destination_id = ['id'=>$entity->destination_id];
        
        return $entity;
    }
    
    public static function getRoutesForApi() {
        $routes = self::$routes;
        
        //
        foreach ($routes as &$r) {
            $info = self::_routeInfo($r['origin_id'], $r['destination_id']);
            
            $r['origin_id'] = ['id' => $r['origin_id']];
            $r['destination_id'] = ['id' => $r['destination_id']];
            
            $r['info'] = $info;
        }
        
        return $routes;
    }
    
    public static function getLocalitiesForApi() {
        $localities = [];
        
        //
        foreach (self::$localities as $id=>$l) {
            $l['id'] = $id;
            
            //unset($l['code']);
            //unset($l['slug']);
            //unset($l['new']);
            
            $localities[] = $l;
        }
        
        return $localities;
    }
    
    
}