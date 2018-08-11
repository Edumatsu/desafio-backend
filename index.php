<?php
/**
 * Desafio Programador Back end
 * Victor Monteiro Cunha
 */

// Security flag for prohibited access to other files
define('SECURITY',TRUE);

// Includes auxilliary files
require_once 'operations.php';
require_once 'constants.php';
require_once 'API.php';

//Defining husk variables, reading json
$clients = $return = [];
$tickets = json_decode(file_get_contents(DATABASE_FILE), true);

// Defining priorities and saving to tickets.json file (If flag is true)
foreach ($tickets as $ticket) {
    classify_ticket($ticket, $clients);
    $aux[] = $ticket;
}
$return = $aux;

if(SAVE_JSON_FILE){
    $json = fopen(DATABASE_FILE,'w');
    fwrite($json,json_encode($return));
    fclose($json);
}

// API operations
extract($_GET);

sort_by($order_by,$sort_by,$return);
filter_by($min_date,$max_date,$priority,$return);
paginate($page,$return);

// Returning json
echo json_encode($return);