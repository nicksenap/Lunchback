<?php
    /*$str = "1abc2ab3abd";
    $flag = preg_match('/\b[\d][a-z]+/',$str,$match);
    if (!$flag) {echo 'regex error';}
    else{
    print_r($match);}*/
    $a = "1a1b2a2b3abd";
    if (strpos($a, '1a2a3ab') !== false) {
    echo 'true';
    }


