<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="fhstyle.css"/>

<title>Pokemon Fight Schedule</title>
</head>
<body onload="schedRequest()"> 

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
    
    <!---page info --->
    <div id="container">
    <div id="header"> <h1>Upcoming PokéFights</h1> </div>

    <div id="contents">
        <div id="search">
            <h3>Search</h3>
            <input id="searchbar" type="text" id="search" name="search"/>
        </div>
    <div id="table">
        <div id="bet">
        <?php
        require_once('SessionManager.php.inc');
        SessionManager::sessionStart('PokemonBets');
        if (isset($_SESSION['balance'])) { ?>
        <h3 id="betbal"> Balance $<?php echo $_SESSION['balance']; ?>
        </h3>
        <input type="number" id="hm" style="display: none;">
        <input type="button" id="confirm" onclick="" value= "Confirm" style ="display: none;"/>
        <?php } 
        else { ?>
        <a href="http://www.pokefights.com/" title="Account">Sign In to view Balance and Place Bets</a>
        <?php } ?>
        </div>
        <p id="sched"></p>
    </div>
    </div>
<script language="javascript">
    
    function openNav() {
        document.getElementById("sidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("sidenav").style.width = "0";
    }

    function schedRequest()
    {
        request = new XMLHttpRequest();
        request.onreadystatechange = handleFHResponse;
        request.open("POST","rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"sched"});
        request.send(data);
    }
    function handleFHResponse()
    { 
        document.getElementById("sched").innerHTML = request.responseText.substring(3, request.responseText.length - 1);
    }
    function sendBetRequest(reqType,fid,tid)
    {
        if(reqType == 'show')
        {
            document.getElementById("hm").style.display = "block";
            document.getElementById("confirm").style.display = "block";
            document.getElementById("confirm").onclick = function(){sendBetRequest("placebet",fid,tid);};
        }
        else{
            var funds = document.getElementById("hm").value;
            
            request = new XMLHttpRequest();
            request.onreadystatechange = handleBetResponse;
            request.open("POST","rpc.php",true);
            request.setRequestHeader("Content-type","application/json");
            var data = JSON.stringify({request:"placebet",fid:fid,tid:tid,funds:funds});
            request.send(data);
        }
    }
    function handleBetResponse()
    {
        document.getElementById("betbal").innerHTML = "Balance: $" + request.responseText;
        document.getElementById("hm").style.display = "none";
        document.getElementById("confirm").style.display = "none";
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