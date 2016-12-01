#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
	
	///MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "userlogin";
	$database2 = "Accounts";
	
	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	$conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);
	
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM userlogin";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	if($conn2->connect_error){
		die("Connection failed: " . $conn2->connect_error);
	}
	else
	{
		$s = "SELECT * FROM info";
		($result2 = mysqli_query($conn2, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	//MySQL Connection
	
	$checkDB = 0;
	
	// 	lookup username and password in database
	while($r=mysqli_fetch_array($result))
	{
		$usernameDB = $r["username"];
		$passwordDB = $r["password"];
		
		var_dump($username);
		var_dump($password);
		
		if($username == $usernameDB && $password == $passwordDB)
			{
			$sd = sha1(strval(date(DATE_ATOM)));
			echo "\n\n" . $sd . "\n\n";
			echo "Access Granted";
			$checkDB = 1;
			while($a=mysqli_fetch_array($result2))
			{
				if($username == $a["username"])
				{
					$balance = $a["funds"];
					$wins = $a["wincount"];
					echo "\nbalance and wins stored";
				}
				else
				{
					echo "\nusername not found!?";
				}
			
			}
			echo "\nbalance and wins sent\n";
			return array("success" => true, 'message'=>"Server received request and processed", 'balance'=>$balance, 'wins'=>$wins);
			//return false if not valid
					break;
		}
		else 
			{
			echo "Access Denied";
			$checkDB = 0;
			//return array("success" => false, 'message'=>"Server received request and processed");
			//return false if not valid
		}
	}
	
	$conn->close();
	
	if($checkDB == 0)
	        return array("success" => '0', 'message'=>"Server received request and processed");
	//return false if not valid
	
}

function register($username, $password)
{
	
	$checkDB = 1;
	
	//MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "userlogin";
	$database2 = "Accounts";
	
	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	$conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);
	
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM userlogin";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	if($conn2->connect_error){
		die("Connection failed: " . $conn2->connect_error);
	}
	else
	{
		$s = "SELECT * FROM info";
		($result2 = mysqli_query($conn2, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	//MySQL Connection
	
	// 	lookup username and password in database
	while($r=mysqli_fetch_array($result))
	{
		
		if($username == $r['username']){
			$checkDB = 0;
			break;
		}
		else
				$checkDB = 1;
		
	}
	
	if($checkDB == 1)
	{
		
		$sp = $password;
		$reg = "INSERT INTO userlogin (username, password) VALUES('$username','$sp' )";
		
		//N		on-Sha password insert
			//$		reg = "INSERT INTO userlogin (username, password) VALUES('$username', '$password')";
		
		if($conn->query($reg) === TRUE)
                {
			
			echo "New user name created";
			var_dump($username);
			var_dump($password);
			
		}
		else {
			
			echo "Error: " . $reg . "<br>" . $conn->error;
			var_dump($username);
			var_dump($password);
		}
		
		$date = date("Y/m/d H:i:s");
		$regAcc = "INSERT INTO info (username, funds, wincount, avg_odds, flagged, dateReg) VALUES('$username','1000.0', '0', '0.0', '0', '$date')";
		
		if($conn2->query($regAcc) === TRUE)
                {
			
			echo "New user info created";
			
		}
		else {
			
			echo "Error: " . $regAcc . "<br>" . $conn2->error;
		}
	}
	else
		echo "Username Taken.";
	
	
	$conn->close();
	
	if($checkDB == 1)
		return array("success" => true, 'message'=>"Server received request and processed");
	else
		return array("success" => '0', 'message'=>"Server received request and processed");
	
}

function addfunds($username, $add)
{
	//MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database2 = "Accounts";
	
	//Create Connection
	$conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);
	
	//Check Connection
	if($conn2->connect_error){
		die("Connection failed: " . $conn2->connect_error);
	}
	else
	{
		$s = "SELECT * FROM info where username=\"$username\"";
		($result2 = mysqli_query($conn2, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	//MySQL Connection

	var_dump($username);
	$f = 0;
	if($add >= 0)
	{
            if($result2->num_rows > 0)
            {
                while($a = $result2->fetch_assoc())
                {
                    $f = $a['funds']; 
                    $f = $f+$add;
                    $reg = "UPDATE info SET funds='$f' WHERE username='$username'";
                
                
                    if($conn2->query($reg) === TRUE)
                    {
                            echo "\nFunds added to database\n";
                    }
                    else {
                            
                            echo "Error: " . $reg . "<br>" . $conn2->error;
                    }
                    
                    echo "Funds Added!";
                    $conn2->close();
                    return array("success" => true, 'message'=>$f);

                }
                
            }
            else
            {
                echo "error no username";
                $conn2->close();
                return array("success" => '0', 'message'=>"Error with adding funds");
            }
	}
	else
		return array("success" => '0', 'message' => "Can't add negative or zero funds");

}

function withdraw($username, $wd)
{
        //MySQL Connection
        $servername = "localhost";
        $DBuser = "it490";
        $DBpass = "whoGivesaFuck!490";
        $database2 = "Accounts";

        //Create Connection
        $conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);

        //Check Connection
        if($conn2->connect_error){
                die("Connection failed: " . $conn2->connect_error);
        }
        else
        {
                $s = "SELECT * FROM info where username=\"$username\"";
                ($result2 = mysqli_query($conn2, $s)) or die (mysqli_error());
                echo "Connected Successfully";
        }
        //MySQL Connection

        var_dump($username);
        $f = 0;
        if($wd >= 0)
        {
            if($result2->num_rows > 0)
            {
                while($a = $result2->fetch_assoc())
                {
                    $f = $a['funds'];
                    $f = $f-$wd;
                    
                    if($f < 0)
                        return array ("success" => '0', 'message' => "Can't withdraw over your balance.");

                    $reg = "UPDATE info SET funds='$f' WHERE username='$username'";
                        
                    if($conn2->query($reg) === TRUE)
                    {
                        echo "\nFunds subtracted from database\n";
                    }
                    else 
                    {
                        echo "Error: " . $reg . "<br>" . $conn2->error;
                    }
                    
                    echo "Funds Withdrawn!";
                    $conn2->close();
                    return array("success" => true, 'message'=>$f);
                }
            }
            else
            {
                echo "error no username";
                $conn2->close();
                return array("success" => '0', 'message'=>"Error with adding funds");
            }
        }
        else
                return array("success" => '0', 'message' => "Can't withdraw negative or zero funds");

}


function fightHistory()
{
	$servername = "localhost";
	$username = "it490";
	$password = "whoGivesaFuck!490";
	$dbname = "fightHistory";

	//Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//Check connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT * FROM history";
	$result = $conn->query($sql);
	$tablestring = "";
	
	$space = "&nbsp;";
	
	$pokepic = '<img src=pokemon&#47;';
        $pokepic2 = ".png";
        $pokepic3 = " onerror=this.style.display='none' title=";

	if($result->num_rows > 0)
	{	
		//$tablestring .= "<style>table, th, td{border: 1px solid black; float:center;}</style>";
		$tablestring .= "<table><tr><th>".$pokepic.'Trainer1'.$pokepic2.$pokepic3."Trainer".$space."1><th>".$pokepic.'Trainer2'.$pokepic2.$pokepic3."Trainer".$space."2><th>Payout<th>Winner<th>Odds";
			//output data of each row
		while($row = $result->fetch_assoc())
		{
			echo "tablestring created\n";
			$tablestring .= "<tr><td>".$row["trainer1"]."<td>".$row["trainer2"]."<td>".$row["payout"]."<td>".$row["winner"]."<td>".$row["odds"]."";
		}
			echo "tablestring sent\n";
			return array("success" => true, 'message'=>$tablestring);	
	}
	else 
	{
		$tablestring = "0 results";
		echo "no data to create table\n";
		return array("success" => '0', 'message'=>$tablestring);
	}

	$conn -> close();
}

function betHistory($username)
{

	//MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "betHistory";
	$database2 = "Accounts";

        //Create Connection
        $conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);

        //Check Connection
        if($conn2->connect_error){
                die("Connection failed: " . $conn2->connect_error);
        }
        else
        {
                $s = "SELECT * FROM info where username=\"$username\"";
                ($result2 = mysqli_query($conn2, $s)) or die (mysqli_error());
                echo "Connected Successfully";
        }
	
	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM history where username=\"$username\"";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	//MySQL Connection

	$tablestring = "";
	//$tablestring .= "<style>table, th, td{border: 1px solid black; float:center;}</style>";
	$tablestring .= "<table><tr><th>FightID<th>Trainer 1 Bet<th>Trainer 2 Bet<th>Winnings";
	//output data of each row

	if($result->num_rows > 0)
	{
            while($row = $result->fetch_assoc())
            {
                    echo "\nbet history found\n";
                    $tablestring .= "<tr><td>".$row["fightid"]."<td>"."$".$row["trainer1_bet"]."<td>"."$".$row["trainer2_bet"]."<td>"."$".$row["winnings"]."";
                    

                    echo "bet history gathered and sent" . "\n";

            }
	}
	else
	{
            echo "error no username";
            $conn->close();
            return array("success" => '0', 'message'=>"$username may not have a bet history yet.");
        }
        
            while($row2 = $result2->fetch_assoc())
            {
                $funds = $row2['funds'];
            }
	
        $conn->close();
                return array("success" => true, 'message'=>$tablestring, 'funds'=>$funds);

}

function schedule()
{
	//MySQL Connection
        $servername = "localhost";
        $DBuser = "it490";
        $DBpass = "whoGivesaFuck!490";
        $database = "Schedule";
	$database2 = "Trainer";

        //Create Connection
        $conn = new mysqli($servername, $DBuser, $DBpass, $database);
	$conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);

        //Check Connection
        if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }
        else
        {
                $s = "SELECT * FROM schedule";
                ($result = mysqli_query($conn, $s)) or die (mysqli_error());
                echo "Connected Successfully";
        }
	//Check Connection
        if($conn2->connect_error){
                die("Connection failed: " . $conn2->connect_error);
        }
        else
        {
                $i = "SELECT * FROM info"; 
                ($result2 = mysqli_query($conn2, $i)) or die (mysqli_error());
                echo "Connected Successfully";
        }

        //MySQL Connection
	
	$tablestring = "";
	$pokestring1 = "";
	$pokestring2 = "";
	$space = "&nbsp;";
	
	$pokepic = '<img src=pokemon&#47;';
        $pokepic2 = ".png";
        $pokepic3 = " onerror=this.style.display='none' title=";

	if($result->num_rows > 0)
	{
	//$tablestring .= "<style>table, th, td{border: 1px solid black; float:center;}</style>";
        $tablestring .= "<table id=poketable><tr><th>".$pokepic.'Trainer1'.$pokepic2.$pokepic3."Trainer".$space."1><th>".$pokepic.'Trainer2'.$pokepic2.$pokepic3."Trainer".$space."2><th>Odds<th>Date";
       
	 //output data of each row
        while($row = $result->fetch_assoc())
	{
		while($row2 = $result2->fetch_assoc())
                {
                        if($row["trainer1id"] == $row2["trainerid"])
                        {                                
                                $pokestring1 = isNidoFamily($row2["pokemon1"]) . $space . isNidoFamily($row2["pokemon2"]) . $space .            isNidoFamily($row2["pokemon3"]) . $space . isNidoFamily($row2["pokemon4"]) . $space . isNidoFamily($row2["pokemon5"]) . $space . isNidoFamily($row2["pokemon6"]);           
                        }
                        if($row["trainer2id"] == $row2["trainerid"])
                        {
                                $pokestring2 = isNidoFamily($row2["pokemon1"]) . $space . isNidoFamily($row2["pokemon2"]) . $space .            isNidoFamily($row2["pokemon3"]) . $space . isNidoFamily($row2["pokemon4"]) . $space . isNidoFamily($row2["pokemon5"]) . $space . isNidoFamily($row2["pokemon6"]);
                        }
                }
		$betbutton = "<input id='placebet' type='button' value ='Bet'  onclick="."sendBetRequest(event,"."'"."show"."'".","."'".$row['fightid']."'".","."'".$row['trainer1id']."'".")".">";
		$betbutton2 = "<input id='placebet' type='button' value ='Bet'  onclick="."sendBetRequest(event,"."'"."show"."'".","."'".$row['fightid']."'".","."'".$row['trainer2id']."'".")".">";
		

		//echo "tablestring created\n";
        	$tablestring .= "<tr><td><bb title=$pokestring1>".$row["trainer1"].$betbutton."<td><cc title=$pokestring2>".$row["trainer2"].$betbutton2."<td>".$row["odds"]."<td>".$row["time"]."";

		$pokestring1 = "";
                $pokestring2 = "";
                $result2 = $conn2->query($i);
	}
        	echo "tablestring sent\n";
		return array("success" => true, 'message' =>$tablestring); 
	}else {
		$tablestring = "0 results";
        	echo "0 results\n";
		return array("success" => '0', 'message'=>$tablestring);
	}

	$conn -> close();
	

}

function trainers($trainer)
{
	$servername = "localhost";
        $username = "it490";
        $password = "whoGivesaFuck!490";
        $dbname = "Trainer";

        //Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        //Check connection
        if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }
	else
	{
	
		if($trainer=="")
		{
			$s = "SELECT * FROM info";
                        ($result = mysqli_query($conn, $s)) or die (mysqli_error());
                        
                        echo $trainer;
                        echo "Connected Successfully";
		}
		else
		{
		       	$s = "SELECT * FROM info where name LIKE \"%$trainer%\" or
                                                        pokemon1 LIKE \"%$trainer%\" or
                                                        pokemon2 LIKE \"%$trainer%\" or
                                                        pokemon3 LIKE \"%$trainer%\" or
                                                        pokemon4 LIKE \"%$trainer%\" or
                                                        pokemon5 LIKE \"%$trainer%\" or
                                                        pokemon6 LIKE \"%$trainer%\"";
                	($result = mysqli_query($conn, $s)) or die (mysqli_error());
                	
                	echo "Searching for ".$trainer."\n";
                	echo "Searched Successfully\n";
                	
                	

		}
	}
	
	$tablestring = "";
        $pokestring = "";
        
        $pokepic = '<img src=pokemon&#47;';
        $pokepic2 = ".png";
        $pokepic3 = " onerror=this.style.display='none' title=";
        $trainers = $pokepic."Trainer1".$pokepic2.$pokepic3."Trainers>".$pokepic.'a'.$pokepic2.$pokepic3."Trainers>"
        .$pokepic.'b'.$pokepic2.$pokepic3."Trainers>".$pokepic.'c'.$pokepic2.$pokepic3."Trainers>"
        .$pokepic.'d'.$pokepic2.$pokepic3."Trainers>".$pokepic.'e'.$pokepic2.$pokepic3."Trainers>"
        .$pokepic.'f'.$pokepic2.$pokepic3."Trainers>".$pokepic.'g'.$pokepic2.$pokepic3."Trainers>";
        
        if($result->num_rows > 0)
        {
            $tablestring .= "<table><tr><th>".$trainers."<th><img title=Slot1 src=images&#47;pokeball.png><th><img title=Slot2 src=images&#47;pokeball.png><th><img title=Slot3 src=images&#47;pokeball.png><th><img title=Slot4 src=images&#47;pokeball.png><th><img title=Slot5 src=images&#47;pokeball.png><th><img title=Slot6 src=images&#47;pokeball.png>";
            while($row = $result->fetch_assoc())
            {
                //echo "tablestring created\n";
                $tablestring.="<tr><td><b>".$row["name"]."<td>".
                $pokepic.isNidoFamily($row["pokemon1"]).$pokepic2.$pokepic3.$row["pokemon1"].">"."<td>".$pokepic.isNidoFamily($row["pokemon2"]).$pokepic2.$pokepic3.$row["pokemon2"].">"."<td>".$pokepic.isNidoFamily($row["pokemon3"]).$pokepic2.$pokepic3.$row["pokemon3"].">"."<td>".$pokepic.isNidoFamily($row["pokemon4"]).$pokepic2.$pokepic3.$row["pokemon4"].">"."<td>".$pokepic.isNidoFamily($row["pokemon5"]).$pokepic2.$pokepic3.$row["pokemon5"].">"."<td>".$pokepic.isNidoFamily($row["pokemon6"]).$pokepic2.$pokepic3.$row["pokemon6"].">"."";
            }
            echo "tablestring sent\n";
            return array("success"=>true, 'message'=>$tablestring);
	}
	else
	{
            $tablestring ="0 results";
            echo "0 results\n";
            return array("success"=>'0', 'message'=>$tablestring);
	}

	$conn->close();

}
function isNidoFamily($pokemon)
{
    if($pokemon == "Nidoran-M (M)")
        return "NidoranM";
    else if($pokemon == "Nidoran-F (F)")
        return "NidoranF";
    else if($pokemon == "Nidorino (M)")
        return "Nidorino";
    else if($pokemon == "Nidorina (F)")
        return "Nidorina";
    else if($pokemon == "Nidoking (M)")
        return "Nidoking";
    else if($pokemon == "Nidoqueen (F)")
        return "Nidoqueen";
    else if($pokemon == "Mr. Mime")
        return "MrMime";
    else
        return $pokemon;
}
function placebet($username, $fightid, $trainerid, $funds)
{
    //MySQL Connection
        $servername = "localhost";
        $DBuser = "it490";
        $DBpass = "whoGivesaFuck!490";
        $database = "Schedule";
	$database2 = "betHistory";
        $database3 = "Accounts";
        
        //Create Connection
        $conn = new mysqli($servername, $DBuser, $DBpass, $database);
	$conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);
	$conn3 = new mysqli($servername, $DBuser, $DBpass, $database3);

        //Check Connection
        if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }
        else
        {
                $s = "SELECT * FROM schedule";
                ($result = mysqli_query($conn, $s)) or die (mysqli_error());
                echo "Connected Successfully";
        }
	//Check Connection
        if($conn2->connect_error){
                die("Connection failed: " . $conn2->connect_error);
        }
        else
        {
                $i = "SELECT * FROM history"; 
                ($result2 = mysqli_query($conn2, $i)) or die (mysqli_error());
                echo "Connected Successfully";
        }
        //Check Connection
        if($conn3->connect_error){
                die("Connection failed: " . $conn3->connect_error);
        }
        else
        {
                $s = "SELECT * FROM info";
                ($result3 = mysqli_query($conn3, $s)) or die (mysqli_error());
                echo "Connected Successfully";
        }
        //MySQL Connection
        
        while($row = $result->fetch_assoc())
	{
            if($row['fightid'] == $fightid)
            {
                if($row['trainer1id'] == $trainerid)
                {
                    $trainer1funds = $funds;
                    $trainer2funds = 0;
                }
                else
                {
                    $trainer1funds = 0;
                    $trainer2funds = $funds;
                }
                
            }
                    
            
	}
	
	
	$winnings = 0;
	
        $sqlBet = "INSERT INTO history (fightid, username, trainer1_bet, trainer2_bet, winnings) VALUES ('$fightid', '$username', '$trainer1funds', '$trainer2funds', '$winnings')";
        
        if($conn2->query($sqlBet) === TRUE)
        {
                echo "\nBet History Updated database\n";
                    return withdraw($username, $funds);
        }
        else {

            echo "Error: " . $sqlBet . "<br>" . $conn2->error;
                    return array("success"=>'0', 'message'=>"Can't Bet Multiple times for one fight");
        }
        
}

function requestProcessor($request)
{
	echo "received request".PHP_EOL;
	
	if(!isset($request['type']))
	  {
		return "ERROR: unsupported message type";
	}
	switch ($request['type'])
	  {
		case "login":
		      return doLogin($request['username'],$request['password']);
		case "register":
		      return register($request['username'],$request['password']);
		case "addfunds":
			  return addfunds($request['username'], $request['funds']);
		case "validate_session":
		      return doValidate($request['sessionId']);
		case "fh":
		      return fightHistory();
		case "bh":
		      return betHistory($request['user']);
		case "sched":
		      return schedule();
		case "tdb":
		      return trainers($request['trainer']);
		case "wdfunds":
		      return withdraw($request['username'], $request['funds']);
                case "placebet":
                      return placebet($request['username'], $request['fid'], $request['tid'], $request['funds']);
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","pokeServer");
$server->process_requests('requestProcessor');
exit();
?>
