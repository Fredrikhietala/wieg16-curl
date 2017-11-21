<?php

function curl($url) {

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function count_words($text, array $words) {
    $text = strip_tags($text);
    $text = explode(" ", $text);

    foreach ($words as $word => $amount) {
        foreach ($text as $line) {
            if (strpos($line, $word) !== false) {
                $words[$word] = $words[$word] + 1;
            }
        }
    }
    return $words;
}

$page = curl("http://www.example.com/");
$counter = count_words($page, ['example']);