<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Poke Fight Schedule</title>
</head>
<body id="body" onload="schedRequest()"> 

    <?php
        include "/var/lib/webutils/layout.php"
    ?>
    
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
                if (isset($_SESSION['balance'])) { ?>
                <h3 id="betbal"> Balance $<?php echo $_SESSION['balance']; ?>
                </h3>
                <div id=confirmpanel style="display: none;">
                    <input type="number" id="hm" style="display: none;">
                    <input type="button" id="confirm" onclick="" value= "Confirm" style ="display: none;"/>
                </div>
                <?php } 
                else { ?>
                <a href="Login.php" title="Account">Sign In to view Balance and Place Bets</a>
                <?php } ?>
            </div>
            <p id="sched"></p>
        </div>
    </div>

<script language="javascript">
    
    function schedRequest()
    {
        
        request = new XMLHttpRequest();
        request.onreadystatechange = handleFHResponse;
        request.open("POST","rpc/rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"sched"});
        request.send(data);
    }
    function handleFHResponse()
    { 
        document.getElementById("sched").innerHTML = request.responseText.substring(3, request.responseText.length - 1);
    }
    function sendBetRequest(event,reqType,fid,tid)
    {
        if(reqType == 'show')
        {
            var d = document.getElementById("confirmpanel");
        
            d.style.position = "absolute";
            d.style.left = event.clientX+'px';
            d.style.top = event.clientY+'px';
            document.getElementById("confirmpanel").style.display = "block";
            document.getElementById("hm").style.display = "block";
            document.getElementById("confirm").style.display = "block";
            document.getElementById("confirm").onclick = function(){sendBetRequest("placebet",fid,tid);};
        }
        else{
            var funds = document.getElementById("hm").value;
            
            request = new XMLHttpRequest();
            request.onreadystatechange = handleBetResponse;
            request.open("POST","rpc/rpc.php",true);
            request.setRequestHeader("Content-type","application/json");
            var data = JSON.stringify({request:"placebet",fid:fid,tid:tid,funds:funds});
            request.send(data);
        }
    }
    function handleBetResponse()
    {
        document.getElementById("betbal").innerHTML = "Balance: $" + request.responseText;
        document.getElementById("confirmpanel").style.display = "none";
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