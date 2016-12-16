<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>PokeFight League</title>
</head>
<body id="body" onload="leagueRequest()">  

    <?php
        include "/var/lib/pokelibs/webutils/layout.php"
    ?>
    
    <!---page info --->
    <div id="clcontainer" style="display: none;">
        <iframe id="clframe" src="CreateLeague.php" width=100% height=500></iframe>
    </div>
    <div id="jlcontainer" style="display: none;">
        This league has a fee. Make sure you have enough money to enter.
        <input type="button" id="jlbutton" onclick="" value= "Join League"/>
    </div>
    <div id="container">
        <div id="header"> <h1>PokéFight Leagues</h1> </div>
        <div id="contents">
            <?php
                require_once("rpc/path.inc");
                require_once('SessionManager.php.inc');
                SessionManager::sessionStart('PokemonBets');
                if (isset($_SESSION['user'])) { ?>
                    <input type="button" id="clbutton" onclick="createLeagueOverlay.show()" value= "Create League"/>
                <?php } 
                else { ?>
                    <a href="javascript:void(0)" title="Sign In" onclick="loginOverlay.show();">Sign In to Create or Join a League</a>
                <?php } ?>
            <div id="table">
            <p id="league"></p>
            </div>
        </div>
    <?php
        include "/var/lib/pokelibs/webutils/footer.php"
    ?>
    </div>
</body>

<script language="javascript">

    function leagueRequest()
    {
        request = new XMLHttpRequest();
        request.onreadystatechange = handleLeagueResponse;
        request.open("POST","rpc/rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"league"});
        request.send(data);
    }
    function handleLeagueResponse()
    { 
        document.getElementById("league").innerHTML = request.responseText.substring(3, request.responseText.length - 1);
    }
    
    function sendJLRequest(leagueid)
    {
        var name = document.getElementById("name").value;
        var fee = document.getElementById("fee").value;
        request = new XMLHttpRequest();
        request.onreadystatechange = handleJLResponse;
        request.open("POST","rpc/rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"jl",leagueid:leagueid});
        request.send(data);
    }
    function handleJLResponse()
    {
        window.top.location.href = "myaccount.php";
    }
</script>

</html>