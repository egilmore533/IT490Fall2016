
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="fhstyle.css"/>
    <title>PokeFights</title>

  </head>

  <body>
    <!--- Main page info --->
    <div id="loginform">
        <div id="banner"></div>
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
    </div>
    <script language="javascript">
        var request;
        var reqType;
        
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
            window.top.location.href = "http://www.pokefights.com/";
        }
        function handleRegResponse()
        {
            document.getElementById("output").innerHTML = request.responseText.substring(3, request.responseText.length - 1);
        }
    </script>
  </body>
  
</html>