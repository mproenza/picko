<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

class SharedTravelEvent extends Entity {
    
    public static $TYPE_CREATED = 'P';
    public static $TYPE_ACTIVATED = 'A';
    public static $TYPE_CONFIRMED = 'C';
    public static $TYPE_CANCELLED = 'X';
    public static $TYPE_DATE_CHANGED = 'D';
    
}