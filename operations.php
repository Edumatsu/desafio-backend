<?php
if (!defined('SECURITY')) exit('No direct script access allowed');

/**
 * Defines each ticket's score and priority based on 
 * - Client's recurring contact
 * - Complaints present in the message
 * - Delay between date updated and date created
 */
function classify_ticket(&$ticket,&$clients)
{
    $score = 0;

    // Per Client
    client_entry($ticket, $clients);
    $score += client_score_by_interaction($ticket['CustomerID'],$clients);

    foreach($ticket['Interactions'] as $interaction){
        $score += classify_interaction_complaint($interaction);
    }

    $score += classify_ticket_delay($ticket);

    if($score >= 15){
        $ticket['Priority'] = 'High';
    }else{
        $ticket['Priority'] = 'Normal';
    }

    $finalscore = 70 + $score;
    $ticket['Score'] = ($finalscore > 100 ? 100 : ($finalscore < 70 ? 70 : $finalscore));
}

/**
 * Returns score in a specific interaction
 * Max score +20
 */
function classify_interaction_complaint($inter)
{
    $score = 0;

    if($inter['Sender'] == 'Customer'){
        foreach(COMPLAINTS as $complaint => $add){
            if(strpos(strtolower($inter['Message']),$complaint) !== false 
            || strpos(strtolower($inter['Subject']),$complaint) !== false){
                $score += $add;
            }
        }

        foreach (COMPLIMENTS as $compliment => $add) {
            if(strpos(strtolower($inter['Message']),$complaint) !== false 
            || strpos(strtolower($inter['Subject']),$complaint) !== false){
                $score -= $add;
            }
        }

        /**
         * Search for too many '?'s, which implies a bothered client
         * Up to 2 '?'s is fine, but any more '?'s increases score
         */
        $question = sizeof(explode("?",$inter['Message']));
        $score += ($question <= 2 ? 0 : $question - 2);
    }

    return ($score > 15 ? 15 : ($score < 0 ? 0 : $score));
}

/** 
 * Increases priority if case has been lingering for longer than a week
 * Max score +5
 */
function classify_ticket_delay($ticket)
{
    $datecreate = explode(' ',$ticket['DateCreate'])[0];
    $dateupdate = explode(' ',$ticket['DateUpdate'])[0];

    $datecreate = strtotime($datecreate);
    $dateupdate = strtotime($dateupdate);

    $difference = round(abs($dateupdate - $datecreate) / 60 / 60 / 24);
    
    $return = floor($difference / 7);

    return ($return > 5 ? 5 : $return);
}

/**
 * Returns clients array and registers new tickets
 */
function client_entry($ticket,&$clients){
    // New Client, registering
    if(!key_exists($ticket['CustomerID'],$clients)){
        $clients[$ticket['CustomerID']] = [
            'CustomerName' => $ticket['CustomerName'],
            'CustomerEmail' => $ticket['CustomerEmail'],
            'Interactions' => 1
        ];
    // Old Client, registering interaction
    }else{
        $clients[$ticket['CustomerID']]['Interactions']++;
    }
}

/**
 * Returns score based on Client's number of interactions
 * Max score +5
 */
function client_score_by_interaction($id,$clients){
    $client = $clients[$id];
    $score = $client['Interactions'];
    
    return ($score > 5 ? 5 : $score);
}