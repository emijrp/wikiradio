<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>wikiradio</title>
    <meta charset="UTF-8"> 
    <link rel="stylesheet" type="text/css" href="wikiradio.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="vector.css" media="screen" />
    <script src="jquery.js"></script>
</head>
<body>

    <div id="mw-page-base"></div>
    <div id="wikiradio" >
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Wikiradio-logo.svg" width="180">
    </div>
    <div id="content" class="mw-body" role="main">
        <div style="float:right">
            <span class="mw-editsection">
            <span class="mw-editsection-bracket">[</span>
            <a title="Edit section: Summary" href="https://meta.wikimedia.org/w/index.php?title=Template:Wikiradio_(tool)/stations&action=edit">edit stations</a>
            <span class="mw-editsection-bracket">]</span>
            </span>
        </div>
        <div id="channels">
           
        </div>
        
        <div id="listening">
            <div style="float:right">
                <span class="mw-editsection">
                <span class="mw-editsection-bracket">[</span>
                <a title="Edit section: Summary" href="https://meta.wikimedia.org/w/index.php?title=Wikiradio_(tool)/playlist/<?php echo isset($_GET['channel'])?($_GET['channel']):(('classic')); ?>&action=edit">edit dayparting</a>
                <span class="mw-editsection-bracket">]</span>
                </span>

                <br /><br />
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/39/High-contrast-audio-volume-high.svg" width="15" />
                <input id="volumeslider" type="range" min="0" max="100" value="100" step="1">
               
            </div>
             <h3 id="youare">Loading <img src="green-LED.gif" width="10"></h3>
             <span id="audioTitle"></span>
             <br />
             <br />
             <div class="container">
                <div class="header">More details >></div>
                <div class="content">
                </div>
            </div>
        </div>
    
        <audio id="audioPlayer">
        Your browser does not support the HTML5 Audio element.
        </audio>
    
        <audio id="audioPlayerAux">
        Your browser does not support the HTML5 Audio element.
        </audio>
        <p id="data"></p>
    </div>
    <div id="author"><a href="https://meta.wikimedia.org/wiki/Wikiradio_(tool)">Project page</a>. <a href="https://github.com/emijrp/wikiradio">Coded</a> by <a href="https://github.com/emijrp/wikiradio/graphs/contributors">contributors</a>. Edit <a href="https://meta.wikimedia.org/wiki/Wikiradio_(tool)#Playlist">channel page</a> to hear your music.</div>
    <script src="wikiradio.js" charset="UTF-8"></script>
 </body>

</html>


