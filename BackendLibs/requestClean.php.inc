<?php

class ArrayClean
{
	function multidimensionalArrayClean($array)
	{
		$new_array = array();
		foreach ($array as $key=>$value)
		{
			$new_array[$key]=(is_array($value) ? multidimensionalArrayClean($value) : mysqli_real_escape_string($value));
		}
		return $new_array;
	}
}

?>

