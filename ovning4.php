<?php


$ch = curl_init("http://www.ehandel.se/");
$fp = fopen("Ehandel.se.html", "w");
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);
$words = [
    'Ehandelsnytt' => 0,
    'hemleverans' => 0
];
$lines = file_get_contents('Ehandel.se.html');
$lines = strip_tags($lines);
$lines = explode(" ", $lines);
foreach ($words as $word => $amount) {
    foreach($lines as $line) {
        if(strpos($line, $word) !== false) {
            $words[$word] = $words[$word] + 1;
        }
    }
}
var_dump($words);