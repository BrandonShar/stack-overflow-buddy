<?php

require_once 'vendor/autoload.php';

use brandonshar\StackOverflowBuddy;

if (strpos($_SERVER['REQUEST_URI'], '/manual-testing') === 0) {
    var_dump( StackOverflowBuddy::substringBetweenTwoStrings('platypus', 'pl', 'us'));
    var_dump( StackOverflowBuddy::giveThanksFor('substringBetweenTwoStrings'));
}

// Test Endpoints

if (strpos($_SERVER['REQUEST_URI'], '/search') === 0 && $_GET == [
    'order'     => 'desc', 
    'sort'      => 'votes', 
    'tagged'    => 'php', 
    'site'      => 'stackoverflow', 
    'intitle'   => urlencode('merge sort'),
]) {
    echo file_get_contents('tests/data/questions.json');
} 

elseif (strpos($_SERVER['REQUEST_URI'], '/questions/9401019;1975520;3296203;11827451;17459468;17501545;17503294;18880844;43169004/answers') === 0 && $_GET == [
    'order'     => 'desc',
    'sort'      => 'votes',
    'site'      => 'stackoverflow',
    'filter'    => '!0WyEumH)CFikxBBVsfnDZQar5'
]) {
    echo file_get_contents('tests/data/answers.json');
}

elseif (strpos($_SERVER['REQUEST_URI'], '/empty') === 0) {
    echo json_encode(['items' => []]);  
}

elseif (strpos($_SERVER['REQUEST_URI'], '/bad') === 0) {
    echo file_get_contents('tests/badAnswers.json');  
} 

elseif (strpos($_SERVER['REQUEST_URI'], '/extracode/search') === 0) {
    echo file_get_contents('tests/data/questions.json');
}

elseif (strpos($_SERVER['REQUEST_URI'], '/extracode/questions') === 0) {
    echo file_get_contents('tests/data/answers2.json');
}

elseif (strpos($_SERVER['REQUEST_URI'], '/rate-limiting') === 0) {
    echo json_encode([]);
}





