<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>PokeFights</title>
</head>
<body id="body" onload="leagueRequest(
                                        <?php 
                                            if(!isset($_GET['lid']))
                                            {
                                                echo "FUCKKKK";
                                                //header("Location: http://www.pokefights.com/", true, 301); 
                                                die ("Access Denied");
                                            }
                                            else
                                            {
                                                echo $_GET['lid'];
                                            }
                                        ?>
                                        );">

    <?php
        include "/var/lib/pokelibs/webutils/layout.php";
    ?>
    
    <!--- page info --->
    <div id="ctcontainer" style="display: none;">
        Please input the ID of the Trainer you want to add
        <input type="number" id="trnid" name="trnid"/> 
        <input type="button" id="ctbutton" onclick="" value= "Add Trainer"/>
    </div>
    <div id="container">
        <?php
            require_once("rpc/path.inc");
            require_once('SessionManager.php.inc');
            SessionManager::sessionStart('PokemonBets');        
            if (!isset($_SESSION['user']))
            {
                echo "FUCKKKK";
                //header("Location: http://www.pokefights.com/", true, 301); 
                die ("Access Denied"); //shouldn't reach this but just in case...
            }
        ?> 
        <div id="header"> <h1><?php echo $_SESSION['leaguename']; ?></h1> </div>
        <div id="contents">
            Hello <?php echo $_SESSION['user']; ?>!
            
            <div id="table">
            <p id="teams"></p>
            <p id="tdb"></p>
            <div id="test"></div>
            </div>
        </div>

        <?php
            include "/var/lib/pokelibs/webutils/footer.php"
        ?>
    </div>
</body>  

<script language="javascript">
    var request;
    var leagueid;
    var number;
    
    function leagueRequest(leagueid)
    {
        request = new XMLHttpRequest();
        request.onreadystatechange = handleLeagueResponse;
        request.open("POST","rpc/rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"leaguehome",leagueid:leagueid});
        request.send(data);
    }
    function handleLeagueResponse()
    { 
        document.getElementById("teams").innerHTML = request.responseText.substring(3, request.responseText.length - 1);
    }
    
</script>
</html>