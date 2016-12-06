#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('MySQLLib.php.inc');

function doLogin($username,$password)
{
    ///MySQL Connection
    $database = "userlogin";
    $database2 = "Accounts";
    $s = "SELECT * FROM userlogin";
    $s2 = "SELECT * FROM info";
    
    $result = MySQLLib::makeDBSelection($s,MySQLLib::makeDBConnection($database));
    $result2 = MySQLLib::makeDBSelection($s2,MySQLLib::makeDBConnection($database2));
    
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
        }
        else 
        {
            echo "Access Denied";
            $checkDB = 0;
        }
    }
    
    if($checkDB == 0)
        return array("success" => '0', 'message'=>"Server received request and processed");
}

function register($username, $password)
{
    
    $checkDB = 1;
    
    $database = "userlogin";
    $database2 = "Accounts";
    $s = "SELECT * FROM userlogin";
    $s2 = "SELECT * FROM info";
    
    $conn = MySQLLib::makeDBConnection($database);
    $conn2 = MySQLLib::makeDBConnection($database2);
    
    $result = MySQLLib::makeDBSelection($s,$conn);
    $result2 = MySQLLib::makeDBSelection($s2,$conn2);
    
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
        
        if($conn->query($reg) === TRUE)
        {	
            echo "New user name created";
            var_dump($username);
            var_dump($password);
        }
        else 
        {	
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
        else 
        {
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

    $database = "Accounts";
    $s = "SELECT * FROM info where username=\"$username\"";
    
    $conn = MySQLLib::makeDBConnection($database);
    $result = MySQLLib::makeDBSelection($s,$conn);

    var_dump($username);
    $f = 0;
    if($add >= 0)
    {
        if($result->num_rows > 0)
        {
            while($a = $result->fetch_assoc())
            {
                $f = $a['funds']; 
                $f = $f+$add;
                $reg = "UPDATE info SET funds='$f' WHERE username='$username'";
            
            
                if($conn->query($reg) === TRUE)
                {
                    echo "\nFunds added to database\n";
                }
                else 
                {
                    echo "Error: " . $reg . "<br>" . $conn2->error;
                }
                
                echo "Funds Added!";
                $conn->close();
                return array("success" => true, 'message'=>$f);

            }
            
        }
        else
        {
            echo "error no username";
            $conn->close();
            return array("success" => '0', 'message'=>"Error with adding funds");
        }
    }
    else
        return array("success" => '0', 'message' => "Can't add negative or zero funds");

}

function withdraw($username, $wd)
{
    $database = "Accounts";
    $s = "SELECT * FROM info where username=\"$username\"";

    $conn = MySQLLib::makeDBConnection($database);
    $result = MySQLLib::makeDBSelection($s,$conn);

    var_dump($username);
    $f = 0;
    if($wd >= 0)
    {
        if($result->num_rows > 0)
        {
            while($a = $result->fetch_assoc())
            {
                $f = $a['funds'];
                $f = $f-$wd;
                
                if($f < 0)
                    return array ("success" => '0', 'message' => "Can't withdraw over your balance.");

                $reg = "UPDATE info SET funds='$f' WHERE username='$username'";
                    
                if($conn->query($reg) === TRUE)
                {
                    echo "\nFunds subtracted from database\n";
                }
                else 
                {
                    echo "Error: " . $reg . "<br>" . $conn->error;
                }
                
                echo "Funds Withdrawn!";
                $conn->close();
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
    $database = "fightHistory";
    $s = "SELECT * FROM history";
    
    $conn = MySQLLib::makeDBConnection($database);
    $result = MySQLLib::makeDBSelection($s,$conn);

    $tablestring = "";
    
    $space = "&nbsp;";
    
    $pokepic = '<img src=pokemon&#47;';
    $pokepic2 = ".png";
    $pokepic3 = " onerror=this.style.display='none' title=";

    if($result->num_rows > 0)
    {	
        $tablestring .= "<table><tr><th>".$pokepic.'Trainer1'.$pokepic2.$pokepic3."Trainer".$space."1><th>".$pokepic.'Trainer2'.$pokepic2.$pokepic3."Trainer".$space."2><th>Payout<th>Winner<th>Odds";
                //output data of each row
        while($row = $result->fetch_assoc())
        {
            //echo "tablestring created\n";
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

    $database = "Accounts";
    $database2 = "betHistory";
    $s = "SELECT * FROM info where username=\"$username\"";
    $s2 = "SELECT * FROM history where username=\"$username\"";
    
    $conn = MySQLLib::makeDBConnection($database);
    $conn2 = MySQLLib::makeDBConnection($database2);
    
    $result = MySQLLib::makeDBSelection($s,$conn);
    $result2 = MySQLLib::makeDBSelection($s2,$conn2);

    $tablestring = "";
    //$tablestring .= "<style>table, th, td{border: 1px solid black; float:center;}</style>";
    $tablestring .= "<table><tr><th>FightID<th>Trainer 1 Bet<th>Trainer 2 Bet<th>Winnings";
    //output data of each row

    if($result2->num_rows > 0)
    {
        while($row = $result2->fetch_assoc())
        {
            echo "\nbet history found\n";
            $tablestring .= "<tr><td>".$row["fightid"]."<td>"."$".$row["trainer1_bet"]."<td>"."$".$row["trainer2_bet"]."<td>"."$".$row["winnings"]."";
            
            echo "bet history gathered and sent" . "\n";
        }
    }
    else
    {
        echo "error no username";
        $conn2->close();
        $conn->close();
        return array("success" => '0', 'message'=>"$username may not have a bet history yet.");
    }
    
    while($row2 = $result->fetch_assoc())
    {
        $funds = $row2['funds'];
    }
    
    $conn->close();
    $conn2->close();
    return array("success" => true, 'message'=>$tablestring, 'funds'=>$funds);

}

function schedule()
{
    $database = "Schedule";
    $database2 = "Trainer";
    $s = "SELECT * FROM schedule";
    
    $conn = MySQLLib::makeDBConnection($database);
    $conn2 = MySQLLib::makeDBConnection($database2);
    
    $result = MySQLLib::makeDBSelection($s,$conn);
	
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
            for($pokemonNum = 1; $pokemonNum < 7; $pokemonNum++)
            {
                $id = $row["trainer1id"];
                $s2 = "select * from info where trainerid=$id";
                $result2 = MySQLLib::makeDBSelection($s2,$conn2);
                $row2=$result2->fetch_assoc();
                
                $pokeid=$row2["pokemon$pokemonNum"."id"];
                
                $s3 = "select * from pokemon where pokemonid=$pokeid";
                $result3 = MySQLLib::makeDBSelection($s3,$conn2);
                $row3=$result3->fetch_assoc();
	       	$pokestring1.=isNidoFamily($row3['name']) . $space;
	    }   
			                          
            for($pokemonNum = 1; $pokemonNum < 7; $pokemonNum++)
            {
               $id = $row["trainer2id"];
                $s2 = "select * from info where trainerid=$id";
                $result2 = MySQLLib::makeDBSelection($s2,$conn2);
                $row2=$result2->fetch_assoc();
                
                $pokeid=$row2["pokemon$pokemonNum"."id"];
                
                $s3 = "select * from pokemon where pokemonid=$pokeid";
                $result3 = MySQLLib::makeDBSelection($s3,$conn2);
                $row3=$result3->fetch_assoc();
	       	$pokestring2.=isNidoFamily($row3['name']) . $space;
            }
 
            $betbutton = "<input id='placebet' type='button' value ='Bet'  onclick="."sendBetRequest(event,"."'"."show"."'".","."'".$row['fightid']."'".","."'".$row['trainer1id']."'".")".">";
            $betbutton2 = "<input id='placebet' type='button' value ='Bet'  onclick="."sendBetRequest(event,"."'"."show"."'".","."'".$row['fightid']."'".","."'".$row['trainer2id']."'".")".">";
            

            //echo "tablestring created\n";
            $tablestring .= "<tr><td><bb title=$pokestring1>".$row["trainer1"].$betbutton."<td><cc title=$pokestring2>".$row["trainer2"].$betbutton2."<td>".$row["odds"]."<td>".$row["time"]."";

            $pokestring1 = "";
            $pokestring2 = "";
        }
        echo "tablestring sent\n";
        return array("success" => true, 'message' =>$tablestring); 
    }
    else 
    {
        $tablestring = "0 results";
        echo "0 results\n";
        return array("success" => '0', 'message'=>$tablestring);
    }

    $conn -> close();
}

function trainers($trainer)
{
    $database = "Trainer";
    $s = "SELECT * FROM info";
    
    $conn = MySQLLib::makeDBConnection($database);
    $result = MySQLLib::makeDBSelection($s,$conn);
    
	
    if($trainer=="")
    {
   	$s = "SELECT * FROM info";
        ($result = mysqli_query($conn, $s)) or die (mysqli_error());
                        
        echo $trainer;
        echo "Connected Successfully";
    }
    else
    {
        $pokesearchresult = array();
        $pokesearch = "SELECT * FROM pokemon where name LIKE \"%$trainer%\"";
        $result = MySQLLib::makeDBSelection($pokesearch,$conn);
        while($row = $result->fetch_assoc())
        {
            $pokesearchresult[] = $row["pokemonid"];
        }
        $list_pokesearch = implode(', ', $pokesearchresult);
        var_dump($list_pokesearch);
        
        if($list_pokesearch == "")
        {
            $list_pokesearch = "-1,-2";
        }
        //search for certain keywords in the trainer db
      	$s = "SELECT * FROM info where info.name LIKE \"%$trainer%\" or 
                                        info.pokemon1id IN ($list_pokesearch) or 
                                        info.pokemon2id IN ($list_pokesearch) or 
                                        info.pokemon3id IN ($list_pokesearch) or 
                                        info.pokemon4id IN ($list_pokesearch) or 
                                        info.pokemon5id IN ($list_pokesearch) or 
                                        info.pokemon6id IN ($list_pokesearch)";
                                        
      	$result = MySQLLib::makeDBSelection($s,$conn);
                	
       	echo "Searching for ".$trainer."\n";
      	echo "Searched Successfully\n";            	

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
            $tablestring.="<tr><td><b>".$row["name"];
            for($pokemonNum = 1; $pokemonNum < 7; $pokemonNum++)
            {
                $id = $row["pokemon$pokemonNum"."id"];
                $s2 = "select * from pokemon where pokemonid=$id";
                $result2 = MySQLLib::makeDBSelection($s2,$conn);
                $row2=$result2->fetch_assoc();
                $tablestring.="<td>".$pokepic.isNidoFamily($row2["name"]).$pokepic2.$pokepic3.$row2["name"].">";
            }

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
    $database = "Schedule";
    $database2 = "betHistory";
    $database3 = "Accounts";
    $s = "SELECT * FROM schedule";
    $s2 = "SELECT * FROM history";
    $s3 = "SELECT * FROM info";
    
    $conn = MySQLLib::makeDBConnection($database);
    $conn2 = MySQLLib::makeDBConnection($database2);
    $conn3 = MySQLLib::makeDBConnection($database3);
    
    $result = MySQLLib::makeDBSelection($s,$conn);
    $result2 = MySQLLib::makeDBSelection($s2,$conn2);
    $result3 = MySQLLib::makeDBSelection($s3,$conn3);
        
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
    else 
    {
        echo "Error: " . $sqlBet . "<br>" . $conn2->error;
        return array("success"=>'0', 'message'=>"Can't Bet Multiple times for one fight");
    }
        
}
function leagues()
{
    $database = "League";
    $s = "SELECT * FROM info";
    
    $conn = MySQLLib::makeDBConnection($database);
    $result = MySQLLib::makeDBSelection($s,$conn);

    $tablestring = "";

    if($result->num_rows > 0)
    {	
        $tablestring .= "<table><tr><th>League<th>Commissioner<th>Entry Fee<th>Slots Open";
                //output data of each row
        while($row = $result->fetch_assoc())
        {
            //echo "tablestring created\n";
            $tablestring .= "<tr><td>".$row["name"]."<td>".$row["owner"]."<td>".$row["entryFee"]."<td>".$row["freeSlots"]."";
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

function createLeague($leaguename, $entryfee, $username)
{
    $database = "League";
    $defaultSalCap = 1000;
    $defaultSlots = 3;
    $defaultPool = $entryfee;
    $addLeague = "INSERT INTO info (name, owner, salaryCap, entryFee, freeSlots, pool) VALUES ('$leaguename','$username','$defaultSalCap','$entryfee','$defaultSlots','$defaultPool')";
    
    $canWD = withdraw($username, $entryfee);
    
    if($canWD["success"] === TRUE)
    {
        $conn = MySQLLib::makeDBConnection($database);
        $result = MySQLLib::makeDBSelection($addLeague,$conn);
        
        $s = "SELECT * FROM info where name='$leaguename'";
        
        $result = MySQLLib::makeDBSelection($s,$conn);
        
        while($row = $result->fetch_assoc())
        {
            $leagueid = $row["leagueid"];
            $salary = $row["salaryCap"];
            $trainer = 0;
            
            $createCommishTeam = "INSERT INTO teams (leagueid, username, trainer1id, trainer2id, trainer3id, trainer4id, trainer5id, trainer6id, personalSalary) VALUES ('$leagueid','$username','$trainer','$trainer','$trainer','$trainer','$trainer','$trainer','$salary')";
            
            $result2 = MySQLLib::makeDBSelection($createCommishTeam,$conn);
        }
        
    }
    else
    {
        echo "No funds to create league.";
        return array("success" => '0', 'message'=>"Unable to create league.");
    }
}
function requestProcessor($request)
{
    echo "received request".PHP_EOL;
    
    if(!isset($request['type']))
    {
        return "ERROR: request type not set";
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
        case "league":
            return leagues();
        case "cl":
            return createLeague($request["leaguename"], $request["entryfee"], $request["username"]);
        default:
            return "ERROR: unsupported message type.";
    }
    return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","pokeServer");
$server->process_requests('requestProcessor');
exit();
?>
