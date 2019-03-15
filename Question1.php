<?php
	//The hash value of allen password
	$word = "ebad2aeecafe43461ae95a98497fd22957d0ab4f";
	function mySQLsha($p)
	{
		$p = sha1($p,true);
		$p = sha1($p);
		return $p;
	}

	//dictionary.txt contain all the english word
	$file = fopen("dictionary.txt","r");
	while(!feof($file))
	{
		$string = rtrim(fgets($file));
		//check hash value
		if(mySQLsha($string) == $word ){
			echo "The password is:<br>".$string;
			break;
		}
	}
	fclose($file);
?>