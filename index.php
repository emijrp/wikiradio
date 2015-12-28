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
        <div id="channels">
            <p><b>Languages:</b> 
            <a href="index.php?channel=ar">العربية</a> · 
            Català · 
            Deutsch · 
            <a href="index.php?channel=en">English</a> · 
            <a href="index.php?channel=es">Español</a> · 
            <a href="index.php?channel=fr">Français</a> · 
            <a href="index.php?channel=gl">Galego</a> · 
            <a href="index.php?channel=pt">Português</a> · 
            <a href="index.php?channel=ru">Русский</a> · 
            
            </p>
            
            <p><b>Music:</b> 
            <a href="index.php?channel=classic">Classic</a> · 
            <a href="index.php?channel=india">India</a> · 
            <a href="index.php?channel=tango">Tango</a> · 
            
            </p>
            
            <p><b>Topics:</b> 
            <a href="index.php?channel=anthems">Anthems</a> · 
            <a href="index.php?channel=birds">Birds</a> · 
            Nature · 
            
            </p>
        </div>
        
        <div id="listening">
            <div style="float:right">
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/39/High-contrast-audio-volume-high.svg" width="15" />
                <input id="volumeslider" type="range" min="0" max="100" value="100" step="1">
            </div>
             <h3>You are listening</h3><small><a href="https://meta.wikimedia.org/w/index.php?title=Wikiradio_%28tool%29/playlist/<?php echo (isset($_GET['channel])?($_GET['channel]):('classic'); ?>'&action=edit">[Edit dayparting]</a></small>
             <span id="audioTitle"></span>
             <br />
             <br />
             <div class="container">
                <div class="header">More details >></div>
                <div class="content">

                    <div class="hproduct commons-file-information-table">
                    <table cellpadding="4" style="width: 100%; direction: ltr;" class="fileinfotpl-type-information toccolours vevent mw-content-ltr">
                    <tbody><tr style="vertical-align: top">
                    <td lang="en" class="fileinfo-paramfield" id="fileinfotpl_desc">Description</td>
                    <td class="description">
                    <span id="audioDescription"></span>
                    </td>
                    </tr>
                    <tr style="vertical-align: top">
                    <td lang="en" class="fileinfo-paramfield" id="fileinfotpl_aut">Author</td>
                    <td>
                        <span id="audioAuthor"></span>
                    </td>
                    </tr>
                    <tr style="vertical-align: top">
                    <td lang="en" class="fileinfo-paramfield" id="fileinfotpl_aut">License</td>
                    <td>
                        <span id="audioLicense"></span>
                    </td>
                    </tr>
                    </tbody></table>
                    </div>  
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


