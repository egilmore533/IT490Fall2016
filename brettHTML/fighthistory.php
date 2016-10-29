<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="fhstyle.css"/>

<title>Poke Fight History</title>
</head>
<body onload="fhRequest()">  

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
    <div id="header"> <h1>Poké Fight History</h1> </div>

    <div id="contents">
        <div id="search">
            <h3>Search</h3>
            <input id="searchbar" type="text" id="search" name="search"/>
        </div>
    <div id="table">
        <p id="fh"></p>
    </div>
    </div>
<script language="javascript">
    
    function openNav() {
        document.getElementById("sidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("sidenav").style.width = "0";
    }

    function fhRequest()
    {
        request = new XMLHttpRequest();
        request.onreadystatechange = handleFHResponse;
        request.open("POST","rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"fh"});
        request.send(data);
    }
    function handleFHResponse()
    { 
        document.getElementById("fh").innerHTML = request.responseText.substring(3, request.responseText.length - 1);
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