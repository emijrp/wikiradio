<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>wikiradio</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="wikiradio.css" media="screen" />
</head>
<body>

    <h1>wikiradio</h1>
    
    <div id="channels">
        <p>By language: 
        <a href="index.php">Main</a> · 
        <a href="index.php?channel=ar">العربية</a> · 
        <a href="index.php?channel=ca">Català</a> · 
        <a href="index.php?channel=de">Deutsch</a> · 
        <a href="index.php?channel=en">English</a> · 
        <a href="index.php?channel=es">Español</a> · 
        <a href="index.php?channel=fr">Français</a> · 
        <a href="index.php?channel=gl">Galego</a> · 
        <a href="index.php?channel=pt">Português</a>
        </p>
        
        <p>By genre:
        <a href="index.php?channel=tango">Tango</a>
        </p>
        
        <p>By topic:</p>
        Birds · 
        Nature
    </div>
    
    <div id="listening">You are listening:<br/><br/><span id="audioDescription"></span></div>

    <audio id="audioPlayer">
    Your browser does not support the HTML5 Audio element.
    </audio>

    <audio id="audioPlayerAux">
    Your browser does not support the HTML5 Audio element.
    </audio>

    <p id="data"></p>
    
    <div id="author"><a href="https://github.com/emijrp/wikiradio">Coded</a> by <a href="https://en.wikipedia.org/wiki/User:Emijrp">emijrp</a></div>

<?php    
    $channels = ["all", "ar", "en", "es", "gl", "pt", "tango"];
    $channel = "all";
    if (isset($_GET["channel"])){
        $temp = $_GET["channel"];
        if (in_array($temp, $channels))
            $channel = $temp;
    }
    if ($channel == "all"){
        echo '<script src="tracks.js"></script>';
    }else{
        echo '<script src="tracks-'.$channel.'.js"></script>';
    }
?>
    <script src="wikiradio.js"></script>
    
</body>

</html>
