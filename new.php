<?php
$url = 'https://lottohub.co/results?date=2022-06-29';
$data = file_get_contents($url);

preg_match('/<title>([^<]+)<\/title>/i', $data, $titles);
$title = $titles[1];

preg_match_all('/<td>([^<]+)<\/td>/i', $data, $tdtags);
$td = $tdtags;

preg_match_all('/height="20">([^<]+)<\/a>/i', $data, $trtags);
$tr = $trtags;


echo $url;
echo "<br>\n";
echo $title;
echo "<br>\n";

echo '<pre>';
var_dump($tr);
echo "<br>\n";
echo '</pre>';

echo '<pre>';
var_dump($td);
echo "<br>\n";
echo '</pre>';



?>