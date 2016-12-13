#!/usr/bin/php
<?php

function oddsCalculation($trainer1, $trainer2)
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
	
                    $s = "SELECT * FROM info where name = '$trainer1'";
                    ($result = mysqli_query($conn, $s)) or die (mysqli_error());
                    
                    $t = "SELECT * FROM info where name = '$trainer2'";
                    ($result2 = mysqli_query($conn, $t)) or die (mysqli_error());
                    
	}

        $salary1 = 1;
        $salary2 = 1;
///////////////Trainer 1////////////////////////
	if($result->num_rows > 0)
        {

            while($row = $result->fetch_assoc())
            {
                /*Finding Pokemon*/
                $pokemon1id = $row["pokemon1id"];
                $pokemon2id = $row["pokemon2id"];
                $pokemon3id = $row["pokemon3id"];
                $pokemon4id = $row["pokemon4id"];
                $pokemon5id = $row["pokemon5id"];
                $pokemon6id = $row["pokemon6id"];
                $salary1 = $row["salary"];
                
                echo $row["name"] . "\n";
            }

	}
	else
	{
            $tablestring ="0 results";
            echo "0 results\n";
            return array("success"=>'0', 'message'=>$tablestring);
	}
	
//////////////PokemonGroup1////////////////////
        $p1 = "SELECT * FROM pokemon where pokemonid = '$pokemon1id' or
                                            pokemonid = '$pokemon2id' or
                                            pokemonid = '$pokemon3id' or
                                            pokemonid = '$pokemon4id' or
                                            pokemonid = '$pokemon5id' or
                                            pokemonid = '$pokemon6id'";
        ($result3 = mysqli_query($conn, $p1)) or die (mysqli_error());
        
	if($result3->num_rows > 0)
        {
            $pokeTypes = array();
            $pokeNum = array();
            
            while($row3 = $result3->fetch_assoc())
            {
                /*Finding Pokemon*/
                array_push($pokeTypes, $row3["type1"], $row3["type2"]);
                array_push($pokeNum, $row3["name"]);
                
                echo $row3["name"] . "\n";
            }

	}
	else
	{
            $tablestring ="0 results";
            echo "0 results\n";
            return array("success"=>'0', 'message'=>$tablestring);
	}
	
        $arrayUnique = array_unique($pokeTypes);
        $arrayUnique = array_filter($arrayUnique);
        $pokeNum = array_filter($pokeNum);
	$pokeNum = array_values($pokeNum);
	$arrayUnique = array_values($arrayUnique);
	
	$typestring = "";
	
	for($i = 0; $i < sizeof($arrayUnique); $i++)
	{
            $typestring .= $arrayUnique[$i] . " ";
	}
	
        echo $typestring . "\n";
        echo "How many pokemon this trainer has is " . sizeof($pokeNum) . "\n";
	
//////////////Trainer 2////////////////////////
	if($result2->num_rows > 0)
        {

            while($row2 = $result2->fetch_assoc())
            {
                /*Finding Pokemon*/
                $pokemon1id = $row2["pokemon1id"];
                $pokemon2id = $row2["pokemon2id"];
                $pokemon3id = $row2["pokemon3id"];
                $pokemon4id = $row2["pokemon4id"];
                $pokemon5id = $row2["pokemon5id"];
                $pokemon6id = $row2["pokemon6id"];
                $salary2 = $row2["salary"];
                
                echo $row2["name"] . "\n";
            }

	}
	else
	{
            $tablestring ="0 results";
            echo "0 results\n";
            return array("success"=>'0', 'message'=>$tablestring);
	}
	
/////////////PokemonGroup2/////////////////////
        $p2 = "SELECT * FROM pokemon where pokemonid = '$pokemon1id' or
                                            pokemonid = '$pokemon2id' or
                                            pokemonid = '$pokemon3id' or
                                            pokemonid = '$pokemon4id' or
                                            pokemonid = '$pokemon5id' or
                                            pokemonid = '$pokemon6id'";
                                                    
        ($result4 = mysqli_query($conn, $p2)) or die (mysqli_error());
                
        if($result4->num_rows > 0)
        {
            $pokeTypes2 = array();
            $pokeNum2 = array();
            
            while($row4 = $result4->fetch_assoc())
            {
                /*Finding Pokemon*/
                array_push($pokeTypes2, $row4["type1"], $row4["type2"]);
                array_push($pokeNum2, $row4["name"]);

                echo $row4["name"] . "\n";
            }

	}
	else
	{
            $tablestring ="0 results";
            echo "0 results\n";
            return array("success"=>'0', 'message'=>$tablestring);
	}

        $arrayUnique2 = array_unique($pokeTypes2);
        $arrayUnique2 = array_filter($arrayUnique2);
        $pokeNum2 = array_filter($pokeNum2);
        $pokeNum2 = array_values($pokeNum2);
        $arrayUnique2 = array_values($arrayUnique2);
	
	$typestring = "";
	
	for($i = 0; $i < sizeof($arrayUnique2); $i++)
	{
            $typestring .= $arrayUnique2[$i] . " ";
	}
	
        echo $typestring . "\n";
	echo "How many pokemon this trainer has is " . sizeof($pokeNum2) . "\n";
	
	$odds1 = 1.0;
	$odds2 = 1.0;
	
	$odds1 += (intval(oddsCalc($arrayUnique, $arrayUnique2)) + intval($pokeNum)) / (intval(oddsCalc($arrayUnique2, $arrayUnique)) + intval($pokeNum2));
        $odds2 += (intval(oddsCalc($arrayUnique2, $arrayUnique)) + intval($pokeNum2)) / (intval(oddsCalc($arrayUnique, $arrayUnique2)) + intval($pokeNum));
	
	echo "Odds payout for " . $trainer1 . " are " . $odds1 . " and the odds payout for " . $trainer2 . " are " . $odds2 . "\n";
	
	if($odds1 == $odds2)
	{
            
            if(sizeof($pokeNum2) < sizeof($pokeNum))
            {
                $odds1 = 1 + (sizeof($pokeNum2)/sizeof($pokeNum));
                $odds2 = 1 + (sizeof($pokeNum)/sizeof($pokeNum2));
            }
            else
            {
                $odds2 = 1 + (sizeof($pokeNum2)/sizeof($pokeNum));
                $odds1 = 1 + (sizeof($pokeNum)/sizeof($pokeNum2));
            }
	}
	
        if($odds1 == $odds2)
	{
            if($salary1 > $salary2)
            {
                $odds1 = 1 + ($salary1/$salary2);
                $odds2 = 1 + ($salary2/$salary1);
            }
            else
            {
                $odds2 = 1 + ($salary1/$salary2);
                $odds1 = 1 + ($salary2/$salary1);
            }
	}
	
	$oddspayout[0] = $odds1;
	$oddspayout[1] = $odds2;
	
	$conn->close();
        
        return ($oddspayout);
}

function oddsCalc($array1, $array2)
{
    $oddsNum = 1;
    
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
    
/////////////////////Strong Against//////////////////////////
	for($i = 0; $i < sizeof($array1); $i++)
	{
            if($array1[$i] != '')
            {
                $s = "SELECT SA FROM " . $array1[$i] . "";
                ($result = mysqli_query($conn, $s)) or die (mysqli_error($conn));
            }
            
            if($result->num_rows > 0)
            {
            
                while($row = $result->fetch_assoc())
                {   
                    for($j = 0; $j < sizeof($array2); $j++)
                    {
                        if($array2[$j] == $row["SA"] && $row["SA"] != NULL)
                        {
                            $oddsNum += 2;
                            //echo $array1[$i] . " this is super effective against " . $array2[$j] . "\n";
                        }
                        else
                        {
                            //echo "No Match for " . $array2[$j] . "\n";
                        }
                    }

                }

            }
            else
            {  
                echo "Table Empty\n";
            }
         }           
         
////////////////////Weakness Check///////////////////////
        for($i = 0; $i < sizeof($array1); $i++)
	{
            if($array1[$i] != '')
            {
                $s = "SELECT WA FROM " . $array1[$i] . "";
                ($result = mysqli_query($conn, $s)) or die (mysqli_error());
            }
             
            if($result->num_rows > 0)
            {
            
                while($row = $result->fetch_assoc())
                {   
                    for($j = 0; $j < sizeof($array2); $j++)
                    {
                        if($array2[$j] == $row["WA"] && $row["WA"] != NULL)
                        {
                            $oddsNum += 5;
                            //echo $array1[$i] . " this is not very effective against " . $array2[$j] . "\n";
                        }
                        else
                        {
                            //echo "No Match for " . $array2[$j] . "\n";
                        }
                    }

                }

            }
            else
            {  
                echo "Table Empty\n";
            }
         }           
    }

    $conn->close();
    
    return $oddsNum;
}
	
?>
