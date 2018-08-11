<?php 
if (!defined('SECURITY')) exit('No direct script access allowed');

# -----------------
# API
# -----------------

/**
 * Sorting method for API
 * @param method can be 'datecreate', 'dateupdate' and 'priority'. Not Case Sensitive
 */
function sort_by($method, $sort_by, &$tickets)
{
    $method = strtolower($method);
    $methods = [
        'datecreate' => 'DateCreate',
        'dateupdate' => 'DateUpdate',
        'priority'   => 'Score'
    ];

    if(key_exists($method,$methods)){
        $method = $methods[$method];

        for ( $i = 0; $i < sizeof($tickets); $i++){
            for ($j = 0; $j < sizeof($tickets); $j++){
                if($sort_by == 'desc'){
                    if($tickets[$i][$method] > $tickets[$j][$method]){
                        $aux = $tickets[$i];
                        $tickets[$i] = $tickets[$j];
                        $tickets[$j] = $aux;
                    }
                }else{
                    if($tickets[$i][$method] < $tickets[$j][$method]){
                        $aux = $tickets[$i];
                        $tickets[$i] = $tickets[$j];
                        $tickets[$j] = $aux;
                    }
                }
            }
        }
    }
}

/**
 * Filter method
 * @param min_date 
 * @param max_date
 * @param priority
 */
function filter_by($min_date,$max_date,$priority,&$tickets)
{
    $array = [];
    $priorities = [
        'high',
        'normal'
    ];
    foreach($tickets as $ticket){

        $filtered = true;

        $datecreate = explode(' ',$ticket['DateCreate'])[0];
        $datecreate = strtotime($datecreate);
        $datecreate = date('Y-m-d',$datecreate);

        if($min_date){
            try{
                $min_date = strtotime($min_date);
                $min_date = date('Y-m-d',$min_date);
                if($datecreate < $min_date){
                    $filtered = false;
                }
            }catch(Exception $e){}
        }
        if($max_date){
            try{
                $max_date = strtotime($max_date);
                $max_date = date('Y-m-d',$max_date);
                if($datecreate > $max_date){
                    $filtered = false;
                }
            }catch(Exception $e){}
        }
        if($priority){
            if(strtolower($priority) != strtolower($ticket['Priority'])){
                $filtered = false;
            }elseif(!in_array(strtolower($priority),$priorities)){
                $filtered = true;
            }
        }

        if($filtered){
            $array[] = $ticket;
        }
    }
    $tickets = $array;
}

/**
 * Pagination method
 * @param page default: 1
 */
function paginate($page,&$tickets)
{   
    $return = [];
    if(!(is_numeric($page) && $page > 0)){
        $page = 1;
    }

    for($i =  (($page - 1) * ENTRIES_PER_PAGE); $i < (ENTRIES_PER_PAGE * $page); $i++){
        $return[] = $tickets[$i];
    }
    $tickets = $return;
}