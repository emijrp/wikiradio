<?php
header('Content-Type: text/html; charset=utf-8');
//Constants
define("API_URL", "https://meta.wikimedia.org/w/api.php?action=query&");
define("API_COMMONS_URL", "https://commons.wikimedia.org/w/api.php?action=query&");
define("PLAYLIST_PREFIX", "Wikiradio_(tool)/playlist/");

//Get api request
function getAPI($url)
{
  //$url = str_replace(' ','_',$url);
  $url = urldecode($url);
  //var_dump($url);
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

//Get html page content
function getHtmlPageContent($name)
{
  return getGenericWikiHtmlPageContent(API_URL,$name);
}

//Get html page content
function getGenericWikiHtmlPageContent($API_URL,$name)
{
  //API query
  $url = $API_URL.'prop=revisions&titles='.$name.'&rvprop=content&rvparse=1&redirects=true&format=json';
  
  $file = getAPI($url);
  if (!is_null($file))
    return reset(reset($file['query']['pages'])['revisions'][0]);
  
  echo 'Page '.$name.' is null';
  exit;
}
//Get html page content
function getCommonsHtmlPage($name)
{
  return getGenericWikiHtmlPageContent(API_COMMONS_URL,$name);
}

//Get Playlist page content
function getPlaylist($name)
{
  return getWikiPageContent(PLAYLIST_PREFIX,$name);
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
  $url = API_URL.'prop=links&titles='.$pageName.'&plnamespace=6&format=json&pllimit=100';
  $file = getAPI($url);
  if (!is_null(reset($file['query']['pages'])['links']))
  {
    return reset($file['query']['pages'])['links'];
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
function isValidSoundExt($filename)
{
  //Last 3 chars
  $fileext = strtolower(substr($filename, -3));
  $validext =  array("wav", "ogg", "lac","oga");
  return (in_array($fileext, $validext));
}

function getList($pagename)
{
  $resultList = array();
  $list = getFilesFromPage(PLAYLIST_PREFIX.$pagename);
  //It should be only a request for each 50 files list
  
  foreach ($list as $e) {
    if (isValidSoundExt($e['title']))
    {
      $fileInfo = getFileIfo($e['title']);
      $resultList[] =  
        array("title"=>$e['title'], 
              "url"=>$fileInfo['url'], 
              "duration"=>$fileInfo['duration']);
      
    }
  }
  return json_encode($resultList);
}

if (isset($_GET['getList']))
  echo getList($_GET['getList']);
if (isset($_GET['getHtmlPageContent']))
  echo getHtmlPageContent($_GET['getHtmlPageContent']);
if (isset($_GET['getCommonsHtmlPage']))  
  echo getCommonsHtmlPage($_GET['getCommonsHtmlPage']);
?>
