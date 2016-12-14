<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="fhstyle.css"/>
    <script src="webutils.js"></script>
</head>

<!--- accountbar info --->
<div id="accountbar" class="accountbar">
    <?php
    require_once("rpc/path.inc");
    require_once('SessionManager.php.inc');
    SessionManager::sessionStart('PokemonBets');
    if (isset($_SESSION['user'])) { ?>
    <div> Logged in as <?php echo $_SESSION['user']; ?>
    (<a class="logout" href="Logout.php">Logout</a>)
    <a href="myaccount.php" title="Account">My Account</a>
    </div>
    <?php } 
    else { ?>
    <div> Logged in as Anonymous
    <a href="javascript:void(0)" title="Sign In" onclick="loginOverlay.show();">Sign In</a>
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
    <a href="league.php" title="League">PokéFight League</a>
</div>

<div id="home">
    <a href="http://www.pokefights.com" title="Home"><img src="images/pokehome.png"></img></a>
</div>
<div id="logincontainer" style="display: none;">
    <iframe id="loginframe" src="Login.php" width=100% height=500></iframe>
</div>
