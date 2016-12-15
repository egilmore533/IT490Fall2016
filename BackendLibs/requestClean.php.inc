<?php

class ArrayClean
{
	function multidimensionalArrayClean($array,$conn)
	{
		$new_array = array();
		foreach ($array as $key=>$value)
		{
			$new_array[$key]=(is_array($value) ? multidimensionalArrayClean($value,$conn) : mysqli_real_escape_string($conn,$value));
		}
		return $new_array;
	}
}

?>

