<?php
$url = 'https://meta.wikimedia.org/w/api.php?action=query&prop=revisions&titles=Wikiradio_(tool)/playlist/'.$_GET['name'].'&rvprop=content&formatversion=2&format=json';

$options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
              "User-Agent: <wikiradio> by The_Photographer [[es:User:The_Photographer]]" // i.e. An iPad 
  )
);

$context = stream_context_create($options);
$file = json_decode(file_get_contents($url, false, $context),true);
echo utf8_decode($file['query']['pages'][0]['revisions'][0]['content']);
?>
