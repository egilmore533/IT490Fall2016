
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="fhstyle.css"/>
    <title>PokeFights</title>

  </head>

  <body id="output">
    <!--- accountbar info --->
    <div id="accountbar" class="accountbar">
        <?php
        require_once('rpc/SessionManager.php.inc');
        SessionManager::sessionStart('PokemonBets');
        if (isset($_SESSION['user'])) { ?>
        <div> Logged in as <?php echo $_SESSION['user']; ?>
        (<a class="logout" href="Logout.php">Logout</a>)
        <a href="myaccount.php" title="Account">My Account</a>
        </div>
        <?php } 
        else { ?>
        <div> Logged in as Anonymous
        <a href="Login.php" title="Account">Sign In</a>
        </div>
        <?php } ?>
    </div>
    <!--- sidenav info --->
    <div id="opennav">
    <a href="javascript:void(0)" class="closebtn" onclick="openNav()"><img border="0" alt="O" src="images/pokeballspin.gif" width="40" height="40"></a>
    </div>
    <div id="sidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="fighthistory.php" title="Fight History">Fight History</a>
        <a href="schedule.php" title="Schedule">Schedule</a>
        <a href="trainerdb.php" title="TrainerDB">Trainer DB</a>
    </div>
    
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
        require_once('rpc/SessionManager.php.inc');
        SessionManager::sessionStart('PokemonBets');
        if (isset($_SESSION['user'])) { ?>
        <div> Balance: $<?php echo $_SESSION['balance']; ?>
        </div>
        <?php } 
        else { ?>
        <div><a href="Login.php" title="Account">Sign in</a> to participate!
        </div>
    <?php } ?>
    
    <div id="footer">
        <a href="aboutus.php" title="About">About</a>
        <a href="contactus.php" title="Contact Us">Contact Us</a>
        Copyright PokéFights &copy; 2016
    </div>
    </div>
    <script language="javascript">
        var request;
        var reqType;
        
        function openNav() {
            document.getElementById("sidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("sidenav").style.width = "0";
        }
    </script>
  </body>
  
</html>

