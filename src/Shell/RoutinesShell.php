<?php
namespace App\Shell;
use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

class RoutinesShell extends Shell {
    
    public function sendReconfirmationsToCustomers() {
        $STTable = TableRegistry::get('SharedTravels');
        
        $today = date('Y-m-d', strtotime('today'));
        $tomorrow = date('Y-m-d', strtotime("$today + 1 day"));
        
        $bookings = $STTable->findAllConfirmedByDate($tomorrow);
        
        print_r($bookings);
    }
}