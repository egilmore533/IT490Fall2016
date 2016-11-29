#!/usr/bin/php
<?php
include('move_data_collection.php');


        ///MySQL Connection
        
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "Trainer";	

	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);	

	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM info";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM pokemoves";
		($result2 = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	
	//MySQL Connection
	
	
	while($row = $result->fetch_assoc())
	{
            $tid = $row["trainerid"];
	
            if($row['pokemon1'] != '')
            {
                $moves = get_pokemon_moves($row['pokemon1'], '50');
                $poke = $row['pokemon1'];
                $sqlMoves = "INSERT INTO pokemoves (trainerid, pokename, move1, move2, move3, move4) VALUES ($tid, '$poke', $moves[0], $moves[1], $moves[2], $moves[3])";
                
                    if($conn->query($sqlMoves) === TRUE)
                    {
                        echo "\nTrainer Pokemon Move Updated database\n";
                    }
                    else 
                        echo "Error: " . $sqlMoves . "<br>" . $conn->error;
            
            }
            
            if($row['pokemon2'] != '')
            {
                $moves = get_pokemon_moves($row['pokemon2'], '50');
                $poke = $row['pokemon2'];
                $sqlMoves = "INSERT INTO pokemoves (trainerid, pokename, move1, move2, move3, move4) VALUES ('$tid', '$poke', '$moves[0]', '$moves[1]', '$moves[2]', '$moves[3]')";
                
                if($conn->query($sqlMoves) === TRUE)
                    {
                        echo "\nTrainer Pokemon Move Updated database\n";
                    }
                    else 
                        echo "Error: " . $sqlMoves . "<br>" . $conn->error;
            }
            
            if($row['pokemon3'] != '')
            {
                $moves = get_pokemon_moves($row['pokemon3'], '50');
                $poke = $row['pokemon3'];
                $sqlMoves = "INSERT INTO pokemoves (trainerid, pokename, move1, move2, move3, move4) VALUES ('$tid', '$poke', '$moves[0]', '$moves[1]', '$moves[2]', '$moves[3]')";
                
                if($conn->query($sqlMoves) === TRUE)
                    {
                        echo "\nTrainer Pokemon Move Updated database\n";
                    }
                    else 
                        echo "Error: " . $sqlMoves . "<br>" . $conn->error;
            }
            
            if($row['pokemon4'] != '')
            {
                $moves = get_pokemon_moves($row['pokemon4'], '50');
                $poke = $row['pokemon4'];
                $sqlMoves = "INSERT INTO pokemoves (trainerid, pokename, move1, move2, move3, move4) VALUES ('$tid', '$poke', '$moves[0]', '$moves[1]', '$moves[2]', '$moves[3]')";
                
                if($conn->query($sqlMoves) === TRUE)
                    {
                        echo "\nTrainer Pokemon Move Updated database\n";
                    }
                    else 
                        echo "Error: " . $sqlMoves . "<br>" . $conn->error;
            }
            
            if($row['pokemon5'] != '')
            {
                $moves = get_pokemon_moves($row['pokemon5'], '50');
                $poke = $row['pokemon5'];
                $sqlMoves = "INSERT INTO pokemoves (trainerid, pokename, move1, move2, move3, move4) VALUES ('$tid', '$poke', '$moves[0]', '$moves[1]', '$moves[2]', '$moves[3]')";
                
                if($conn->query($sqlMoves) === TRUE)
                    {
                        echo "\nTrainer Pokemon Move Updated database\n";
                    }
                    else 
                        echo "Error: " . $sqlMoves . "<br>" . $conn->error;
            }
            
            if($row['pokemon6'] != '')
            {
                $moves = get_pokemon_moves($row['pokemon6'], '50');
                $poke = $row['pokemon6'];
                $sqlMoves = "INSERT INTO pokemoves (trainerid, pokename, move1, move2, move3, move4) VALUES ('$tid', '$poke', '$moves[0]', '$moves[1]', '$moves[2]', '$moves[3]')";
                
                if($conn->query($sqlMoves) === TRUE)
                    {
                        echo "\nTrainer Pokemon Move Updated database\n";
                    }
                    else 
                        echo "Error: " . $sqlMoves . "<br>" . $conn->error;
            }
            else
                echo "\nError no pokemon in Trainer\n";
	}

?>