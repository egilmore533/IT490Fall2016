<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Poke Fight Schedule</title>
    <script src="webutils.js" language="javascript"></script>
</head>
<body id="body" onload="schedRequest()"> 

    <?php
        include "/var/lib/pokelibs/webutils/layout.php"
    ?>
    <div id=confirmpanel style="display: none;">
        <input type="number" id="hm" style="display: none;">
        <input type="button" id="confirm" onclick="" value= "Confirm" style ="display: none;"/>
    </div>
    <!---page info --->
    <div id="fightcontainer">
    <div id="header"> <h1>Upcoming PokéFights</h1> </div>

        <div id="contents">
            <div id="table">
                <div id="bet">
                    <?php
                    require_once("rpc/path.inc");
                    require_once('SessionManager.php.inc');
                    SessionManager::sessionStart('PokemonBets');
                    if (isset($_SESSION['user'])) { ?>
                    <h3 id="betbal"> Balance $<?php echo $_SESSION['balance']; ?>
                    </h3>
                    
                    <?php } 
                    else { ?>
                    <a href="javascript:void(0)" title="Sign In" onclick="loginOverlay.show();">Sign In to view Balance and Place Bets</a>
                    <?php } ?>
                </div>
                <p id="sched"></p>
            </div>
        </div>
    <?php
        include "/var/lib/pokelibs/webutils/footer.php"
    ?>
    </div>
</div>
</body>
<script language="javascript">

</script>
</html>