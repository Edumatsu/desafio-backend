<?php
if (!defined('SECURITY')) exit('No direct script access allowed');

date_default_timezone_set('America/Sao_Paulo');

define ('ENTRIES_PER_PAGE',5);
define ('DATABASE_FILE','tickets.json');
define ('SAVE_JSON_FILE',FALSE);

const COMPLAINTS = [
    'reclam' => 5,
    'falt' => 1,
    'descontent' => 3,
    'atraso' => 2,
    'contat' => 1,
    'ainda' => 1,
    'quer' => 2,
    'estrag' => 4,
    'providências' => 5,
    'providencias' => 5,
    'soluçao' => 2,
    'solução' => 2,
    'solucao' => 2,
    'cancel' => 6,
    'desist' => 6,
    'dinheiro' => 3,
    'falta respeit' => 5,
    'falta de respeit' => 5,
    'mas'   => 1,
    'porem' => 1,
    'todavia' => 1,
    'entretanto' => 1,
];

const COMPLIMENTS = [
    'elogio' => 1,
    'gost' => 1,
    'ótimo' => 3,
    'otimo' => 3,
    'rapid' => 2,
];