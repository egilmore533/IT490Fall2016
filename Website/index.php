
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>PokeFights</title>
</head>

<body id="body">
    <?php
        include "/var/lib/pokelibs/webutils/layout.php"
    ?>
    <!--- Main page info --->
    <div id="maincontainer">
    <!---<div id="banner"></div>--->
    <h1 id="header">PokéFights</h1>
    <script src= "http://player.twitch.tv/js/embed/v1.js"></script>
    <div id="twitch"></div>
    <script type="text/javascript">
            var options = {
                    width: 854,
                    height: 480,
                    channel: "pokefights",
                    //video: "{VIDEO_ID}"
            };
            var player = new Twitch.Player("twitch", options);
            player.setVolume(0.5);
    </script>
    Bet on the stronger trainer...
    <?php
        require_once("rpc/path.inc");
        require_once('SessionManager.php.inc');
        SessionManager::sessionStart('PokemonBets');
        if (isset($_SESSION['user'])) { ?>
        <div> Balance: $<?php echo $_SESSION['balance']; ?>
        </div>
        <?php } 
        else { ?>
        <div><a href="Login.php" title="Account">Sign in</a> to participate!
        </div>
    <?php } ?>
    
    <?php
        include "/var/lib/pokelibs/webutils/footer.php"
    ?>
    </div>
</body>
  
</html>

