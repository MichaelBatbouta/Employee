<?php

include 'pubs_dal.php'; 

$result = "UNDEFINED"; 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

	$req = $_POST['request']; 

	switch($req)
	{
	case "get_authors":
		$result = get_all_authors(); 
		break; 

	case "get_au_books":
		$result = get_books_by_author($_POST['author']); 
		break; 

	default: 
		$result = "unknown request: " . $req; 

	}// end switch on request

}else if($_SERVER['REQUEST_METHOD'] == 'GET'){



}

echo $result; 

?>
