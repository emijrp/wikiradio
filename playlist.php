<?php
header('Content-Type: text/html; charset=utf-8');
//Constants
define("API_URL", "https://meta.wikimedia.org/w/api.php?action=query&");
define("PLAYLIST_PREFIX", "Wikiradio_(tool)/playlist/");

//Get api request
function getAPI($url)
{
  $url = str_replace(' ','_',$url);
  $options = array(
    'http'=>array(
      'method'=>"GET",
      'header'=>"Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                "User-Agent: <wikiradio> by The_Photographer [[es:User:The_Photographer]]" 
    )
  );
  $context = stream_context_create($options);
  return json_decode(file_get_contents($url, false, $context),true);
}

//Get wiki page content
function getWikiPageContent($name)
{
  //API query
  $url = API_URL.'prop=revisions&titles='.$name.'&rvprop=content&formatversion=2&format=json';
  $file = getAPI($url);
  if (!is_null($file))
    return $file['query']['pages'][0]['revisions'][0]['content'];
  
  echo 'Page '.$name.' is null';
  exit;
}

//Get Playlist page content
function getPlaylist($name)
{
  return getWikiPageContent(PLAYLIST_PREFIX.$name);
}

//Get Sound file list
function getFilesArray($content)
{
  preg_match_all('/\[\[\:File\:(.+)\.ogg\]\]/',  $content, $m);
  return $m[1];
}
//Get sound info url and duration
function getFileIfo($filename)
{
  //API query
  $url = API_URL.'prop=revisions&titles='.$filename.'&prop=imageinfo&iiprop=url|dimensions&format=json';
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
    
    return $arrayResult;
  }
  
  echo 'URL is null for '.$filename;
  exit;
}

//Get files link from a page
function getFilesFromPage($pageName)
{
  $url = API_URL.'prop=links&titles='.$pageName.'&plnamespace=6&format=json';
  $file = getAPI($url);
  if (!is_null(reset($file['query']['pages'])['links'][0]))
  {
    return reset($file['query']['pages'])['links'][0];
  }
  echo 'Files not found in '.$pageName;
  exit;
}

function getFileExt($filename)
{
  return substr($filename, -3);
}
//https://commons.wikimedia.org/wiki/Commons:File_types#Sound
// .wav .ogg .flac
function isValidSoundExt($fileext)
{
  $fileext = strtolower($fileext);
  $validext =  array("wav", "ogg", "flac");
  return (in_array($fileext, $validext));
}

function getList($pagename)
{
  $resultList = array();
  $list = getFilesFromPage($pagename);
  //It should be only a request for each 50 files list
  foreach ($list as $e) {
    if (isValidSoundExt($e->title))
    {
      $fileInfo = getFileIfo($e->title);
      $resultList[] = 
        array("title"=>$e->title, 
              "url"=>$fileInfo['url'], 
              "duration"=>$fileInfo['duration']);
    }
  }
  return json_decode($resultList);
}

if (isset($_GET['name']))
  echo getPlaylist($_GET['name']);
if (isset($_GET['getList']))
  echo getList($_GET['getList']);
?>
