
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="fhstyle.css"/>
    <title>PokeFights</title>

  </head>

  <body>
  
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
    <a href="http://www.pokefights.com"><div id="banner"></div></a>
    <h1 id="header">PokéFights Login</h1>
    <form name="login">
        <div id="output"></div>
        Username<input type="text" id="username" name="username"/>
        <br>
        Password<input type="password" id="password" name="password"/>        
        <input type="button" onclick="sendLoginRequest()" value="Login"/><br>
        Don't have an Account? 
        <input type="button" onclick="sendRegRequest()" value="Register"/>
    
    </form>
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
        
        function sendLoginRequest()
        {
            var name = document.getElementById("username").value;
            var pw = document.getElementById("password").value;
            request = new XMLHttpRequest();
            request.onreadystatechange = handleLoginResponse;
            request.open("POST","rpc/rpc.php",true);
            request.setRequestHeader("Content-type","application/json");
            var data = JSON.stringify({request:"login",username:name,password:pw});
            request.send(data);
        }
        function sendRegRequest()
        {
            var name = document.getElementById("username").value;
            var pw = document.getElementById("password").value;
            request = new XMLHttpRequest();
            request.onreadystatechange = handleRegResponse;
            request.open("POST","rpc/rpc.php",true);
            request.setRequestHeader("Content-type","application/json");
            var data = JSON.stringify({request:"register",username:name,password:pw});
            request.send(data);
        }
        function handleLoginResponse()
        {
            window.location = "myaccount.php";
        }
        function handleRegResponse()
        {
            document.getElementById("output").innerHTML = request.responseText.substring(3, request.responseText.length - 1);
        }
    </script>
  </body>
  
</html>