<?php
header('Content-Type: text/html; charset=utf-8');
//Constants
define("API_URL", "https://meta.wikimedia.org/w/api.php?action=query&");
define("PLAYLIST_PREFIX", "Wikiradio_(tool)/playlist/");

//Get api request
function getAPI($url)
{
  $options = array(
    'http'=>array(
      'method'=>"GET",
      'header'=>"Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                "User-Agent: <wikiradio> by The_Photographer [[es:User:The_Photographer]]" // i.e. An iPad 
    )
  );
  $context = stream_context_create($options);
  
  return json_decode(file_get_contents($url, false, $context),true);
}

//Get wiki page content
function getWikiPageContent($name)
{
  //API query
  $name = str_replace(' ','_',$name);
  $url = API_URL.'prop=revisions&titles='.$name.'&rvprop=content&formatversion=2&format=json';
  echo $url;
  $file = getAPI($url);
  if (!is_null($file))
    return $file['query']['pages'][0]['revisions'][0]['content'];
  
  return "Page is null";
}

//Get Playlist page content
function getPlaylist($name)
{
  return getWikiPageContent(PLAYLIST_PREFIX.$name);
}

//Get sound info url and duration
function getFileIfo($filename)
{
  //API query
  $url = API_URL.'prop=revisions&titles=File:'.$filename.'&prop=imageinfo&iiprop=url|dimensions&format=json';
  //get page content
  $file = getAPI($url);
  
  //Null validation
  if(!is_null(reset($file['query']['pages'])['imageinfo'][0]['url']))
  {
    $des = reset($file['query']['pages'])['imageinfo'][0];
    $arrayResult = array(
        "url"=>$des['url'], 
        "duration"=>$des['duration']
    ); 
    
    return json_encode($arrayResult);
  }
  
  return "URL is null";
}

if (isset($_GET['name']))
  echo getPlaylist($_GET['name']);
if (isset($_GET['getFileIfo']))
  echo getFileIfo($_GET['getFileIfo']);
?>
