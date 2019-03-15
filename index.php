<?php

    function mySQLsha($p)
    {
        $p = sha1($p,true);
        $p = sha1($p);
        return $p;
    }
	//The hash value
	$secert_org = "85176ab687ad4e06adb8542af91ced85deca807a";
	//dictionary.txt contain all the english word
	$all_word = fopen("dictionary.txt","r");
	//ascii.txt conatin all ascii char
	$ascii = fopen("ascii.txt","r");
	//int.txt conatin all integer
	$int = fopen("int.txt","r");

	//get ascii to an array
	$ascii_array=[];
    while(! feof($ascii))
    {
        $ascii_array[] = rtrim(fgets($ascii));
   
    }
    //get int into array
	$int_array=[];
	while(! feof($int))
    {
        $int_array[] = rtrim(fgets($int));
   
    }
	
	//get all 8 characters word into array
	$all_word_array = [];
	while(! feof ($all_word))
	{
		$temp = rtrim(fgets($all_word));
		if(strlen($temp) == 8){
			$all_word_array[] = $temp;
		}
	}
	
	$max_word = sizeof($all_word_array);
	fclose($all_word);
	fclose($ascii);
	fclose($int);
	
	$dict_array=[];
	$counter= 0;
	$found = false;
	
	while($found == false){
		
		for($i=$counter; $i<$max_word; $i++){
			// Get 5 word into memory at one loop to reduce overload
			if($i % 5 == 0 && $i!= 0)
			{
				$counter++;
				break;
			}else{
				$dict_array[] = $all_word_array[$i];
				$counter++;
			}
		}
			
		
		$max_dict = sizeof($dict_array);
		$max_ascii = sizeof($ascii_array);
		$max_dict = sizeof($dict_array);
		$max_int = sizeof($int_array);
		$dict_word = "imposter";
		$wordTohash =[];
		//replace ascii and put the result into an array
		for( $x = 0; $x < $max_dict ; $x++ )
		{
			for( $j = 0; $j <8 ; $j++ )
			{
				for( $i = 0; $i < $max_ascii; $i++ )
				{
					$temp = $dict_array[$x];
					$dict_array[$x][$j] = $ascii_array[$i];
					$wordTohash[] = $dict_array[$x];
					$dict_array[$x] = $temp;
				}
			}
		}
		
		//take the result array and replace integer
		$max_wordTohash = sizeof($wordTohash);
		
		$wordTohash_check =[];

		for( $x = 0; $x < $max_wordTohash ;$x++)
		{
			for( $j = 0; $j <8 ; $j++ )
			{
				for( $i = 0; $i < $max_int; $i++ )
				{
					$temp = $wordTohash[$x];
					$wordTohash[$x][$j] = $int_array[$i];
					$wordTohash_check[] = $wordTohash[$x];
					$wordTohash[$x] = $temp;
					
				}
			}
		}

		//hash and compare
		$max_wordTohash_check = sizeof($wordTohash_check);
		for( $i = 0; $i < $max_wordTohash_check; $i++)
		{
			$temp = mySQLsha($wordTohash_check[$i]);
			if($temp == $secert_org)
			{
				echo $wordTohash_check[$i];
				$found = true;
				break;
			}
		}
		//clean the array to free memory
		$dict_array = [];
	}
?>