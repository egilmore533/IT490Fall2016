<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="fhstyle.css"/>
    <title>PokeFights</title>
    
  </head>
  <body id="output" onload="bhRequest()">

    <!--- accountbar info --->
    <div id="accountbar" class="accountbar">
        <?php
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
        <a href="http://www.pokefights.com/" title="Account">Sign In</a>
        </div>
        <?php } ?>
    </div>
    
    <!--- sidenav info --->
    <div id="opennav">
    <a href="javascript:void(0)" class="closebtn" onclick="openNav()"><img border="0" alt="Navigation" src="pokeballspin.gif" width="40" height="40"></a>
    </div>
    <div id="sidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="fighthistory.php" title="Fight History">Fight History</a>
        <a href="schedule.php" title="Schedule">Schedule</a>
        <a href="trainerdb.php" title="TrainerDB">Trainer DB</a>
    </div>
    
    <!--- page info --->
    <div id="container">
    <?php
        require_once('SessionManager.php.inc');
        SessionManager::sessionStart('PokemonBets');        
        if (!isset($_SESSION['user']))
        {
            header("Location: http://www.pokefights.com/", true, 301); 
            die ("Access Denied"); //shouldn't reach this but just in case...
        }
    ?> 
    <h2 id="header">PokéBetter <?php echo $_SESSION['user']; ?></h2>
    <p><div id="bal">Balance: $<?php echo $_SESSION['balance']; ?> </div>
    <input id="addfunds" type="button" onclick="sendRequestTwo('show')" value="Add Funds"/>
    <input type="number" id="howmuch" style="display: none;"/>
    <input type="button" id="confirmbutton" onclick="sendRequestTwo('addFunds')" value= "Confirm" style ="display: none;"/>
    <div id="wins">Wins: <?php echo $_SESSION['wins']; ?>
    Losses: <?php echo "1";?></div>
    <p id="bh"></p>
    
  <script language="javascript">
    var request;
    var reqType;
        
    function openNav() {
        document.getElementById("sidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("sidenav").style.width = "0";
    }
    function sendRequestTwo(reqType)
    {
        if(reqType == 'show')
        {
            document.getElementById("howmuch").style.display = "block";
            document.getElementById("confirmbutton").style.display = "block";
        }
        else
        {
            var funds = document.getElementById("howmuch").value;
            
            request = new XMLHttpRequest();
            request.onreadystatechange = handleResponse;
            request.open("POST","rpc.php",true);
            request.setRequestHeader("Content-type","application/json");
            var data = JSON.stringify({request:reqType,funds:funds});
            request.send(data);
        }
    }
    function handleResponse()
    {
        document.getElementById("bal").innerHTML = "Balance: $" + request.responseText;
        document.getElementById("howmuch").style.display = "none";
        document.getElementById("confirmbutton").style.display = "none";
    }
    function bhRequest()
    {
        request = new XMLHttpRequest();
        request.onreadystatechange = handleBHResponse;
        request.open("POST","rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"bh"});
        request.send(data);
    }
    function handleBHResponse()
    { 
        document.getElementById("bh").innerHTML = request.responseText.substring(3, request.responseText.length - 1);
    }
  </script>
<div id="footer">
    <a href="aboutus.php" title="About">About</a>
    <a href="contactus.php" title="Contact Us">Contact Us</a>
    Copyright PokéFights &copy; 2016
</div>
</div>
</body>
</html>
