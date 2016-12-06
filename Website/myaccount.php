<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>PokeFights</title>
</head>
<body id="output" onload="bhRequest()">

    <?php
        include "/var/lib/pokelibs/webutils/layout.php"
    ?>
    
    <!--- page info --->
    <div id="accountcontainer">
        <?php
            require_once("rpc/path.inc");
            require_once('SessionManager.php.inc');
            SessionManager::sessionStart('PokemonBets');        
            if (!isset($_SESSION['user']))
            {
                header("Location: http://www.pokefights.com/", true, 301); 
                die ("Access Denied"); //shouldn't reach this but just in case...
            }
        ?> 
        <h2 id="header">
            <div id="wins">Wins: <?php echo $_SESSION['wins']; ?>
            Losses: <?php echo "0";?></div>
            <img id="profilepic" src="pokemon/<?php echo substr($_SESSION['user'], -1,1);?>.png"></img>PokéBetter <?php echo $_SESSION['user']; ?>
        </h2>
        
        <p><div id="bal">Balance: $<?php echo $_SESSION['balance']; ?> </div>
        <input id="addfunds" type="button" onclick="sendBalRequest('show')" value="Add Funds"/>
        <input id="withdrawfunds" type="button" onclick="sendBalRequest('show2')" value="Withdraw"/>
        <input type="number" id="howmuch" style="display: none;"/>
        <input type="button" id="confirmbutton" onclick="sendBalRequest('addFunds')" value= "Confirm" style ="display: none;"/>
        
        <p id="bh"></p>

        <?php
            include "/var/lib/pokelibs/webutils/footer.php"
        ?>
    </div>
</body>  

<script language="javascript">
    var request;
    var reqType;
    
    function sendBalRequest(reqType)
    {
        if(reqType == 'show')
        {
            document.getElementById("howmuch").style.display = "block";
            document.getElementById("confirmbutton").style.display = "block";
            document.getElementById("confirmbutton").onclick = function(){sendBalRequest('addFunds');};
        }
        else if(reqType == 'show2')
        {
            document.getElementById("howmuch").style.display = "block";
            document.getElementById("confirmbutton").style.display = "block";
            document.getElementById("confirmbutton").onclick = function(){sendBalRequest('wdFunds');};
        }
        else
        {
            var funds = document.getElementById("howmuch").value;
            
            request = new XMLHttpRequest();
            request.onreadystatechange = handleResponse;
            request.open("POST","rpc/rpc.php",true);
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
        request.open("POST","rpc/rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"bh"});
        request.send(data);
    }
    function handleBHResponse()
    { 
        document.getElementById("bh").innerHTML = request.responseText.substring(3, request.responseText.length - 1);
    }
</script>
</html>
