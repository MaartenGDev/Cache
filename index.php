<?php
namespace App;
require_once 'vendor/autoload.php';


function getRoosterEntry(){
    $driver = new LocalDriver();
    $cache = new Cache($driver,5);

    $entry = $cache->has('rooster',function($cache){
        return $cache->get('rooster');
    });

    if($entry){
       return $entry;
    }

    return $cache->store('rooster','Hello World. Ye3a');
}

var_dump(getRoosterEntry());