<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="fhstyle.css"/>
    <title>PokeFights</title>

</head>

<body>
    <!--- Main page info --->
    <div id="clform">
        <audio id="clmusic" src="sound/battle.mp3"></audio>
        <h1 id="header">Create PokéFights League</h1>
        <form name="cl">
            <div id="output"></div>
            Name of League<input type="text" id="name" name="name"/>
            <br>
            Entry Fee<input type="number" id="fee" name="fee"/>        
            <input type="button" onclick="sendCLRequest()" value="Create League"/><br>
        </form>
        <div id="clbanner"></div>
    </div>

</body>    
<script language="javascript">
    var request;

    function sendCLRequest()
    {
        var name = document.getElementById("name").value;
        var fee = document.getElementById("fee").value;
        request = new XMLHttpRequest();
        request.onreadystatechange = handleCLResponse;
        request.open("POST","rpc/rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"cl",name:name,fee:fee});
        request.send(data);
    }
    function handleCLResponse()
    {
        window.top.location.href = "myaccount.php";
    }
</script>
  
</html>