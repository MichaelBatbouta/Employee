<!DOCTYPE html>
<?php
function connect_to_pubs()
{
	$dsn = 'mysql:host=localhost;port=3306;dbname=pubs'; 
	$user = 'root';
	$password = 'root'; 

	$handle = new PDO($dsn, $user, $password); 
	$handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

	return $handle; 
}
?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title> Pubs Interface </title> 
	<link rel="stylesheet" href="styles.css">
</head> 

<body>

	<header> 
		<h1> Publishers Database </h1>
		<img id="main_img" src="images/blankBook.gif" alt="Blank Book"> 
		<p> Pubs database interface.  This site allows you to view and add books, stores, and puplishers.<br>
                    This Web interface includes HTML 5, CSS, PHP, and JavaScript.  
		</p> 
	</header> 

	<nav id="top_nav"> 
	<ul class="h_list">
	<li class="h_list"><a href="authors.html"> Authors </a></li>
	<li class="h_list"><a> Books </a></li>
	<li class="h_list"><a> Sales </a></li>
	<li class="h_list"><a> Stores </a></li>
	</ul> 

	</nav> 
		<div class="mid_wrapper"> 
	
	<aside id="left_side">
	<ul class="v_list">
	<li class="v_list"><a href="listAuthors.html">List</a></li>
	<li class="v_list"><a href="addAuthor.html">Add</a></li>
	<li class="v_list"><a>Remove</a></li>
	<li class="v_list"><a>Edit</a></li>

	</ul> 
	
	</aside> 
	<form method="post" action="">
	<label>First Name</label>
	<input type="text" name="first_name" />
	<br />
	<label>Last Name</label>
	<input type="text" name="last_name" />
	<br />
<label>Job Description</label> 
 <select label = "Job Descripstion"class="form-dropdown validate[required]" style="width:150px" id="input_43" name="job_id">

           <?php
$servername = "localhost";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_select_db($conn,'pubs'); //set the database name

                   $menu=" ";
                  
                  $sql="SELECT job_desc FROM jobs"; //selection query
                  $rs = mysqli_query($conn, $sql);//odbc_exec($conn,$sql);

                  
                   if (mysqli_num_rows($rs) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($rs)) {
                     $menu .= "<option value=".$row['job_desc'].">" . $row['job_desc']. "</option>";
    }
}

                  echo $menu;
                 
                  mysqli_close($conn);

?>

</select>
<br />
	<label>Job Level</label>
	<input type="number" name ="Job Level" />
	<br />
<label>Publishers</label>
 	<select label = "Publishers"class="form-dropdown validate[required]" style="width:150px" id="input_43" name="pub_id">

           <?php
$servername = "localhost";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_select_db($conn,'pubs'); //set the database name

                   $menu=" ";
                  
                  $sql="SELECT pub_name FROM publishers"; //selection query
                  $rs = mysqli_query($conn, $sql);//odbc_exec($conn,$sql);

                  
                   if (mysqli_num_rows($rs) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($rs)) {
                     $menu .= "<option value=".$row['pub_name'].">" . $row['pub_name']. "</option>";
    }
}

                  echo $menu;
                 
                  mysqli_close($conn);

?>

</select>
	<br />
	<label>Hire Date</label>
	<input type="date" name="hire_date" />
	<br />
	<input type="submit" value="Add Employee">
	</form>
 

<?php

$servername = "localhost";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_select_db($conn,'pubs'); //set the database name

		$first_name=$_POST['first_name'];
		$last_name=$_POST['last_name'];
		$job_name=$_POST['job_id'];
		$job_level=$_POST['Job Level'];
		$pub_name=$_POST['pub_id'];
		$hire_date=$_POST['hire_date'];
$sql = "SELECT $job_id = job_id FROM jobs WHERE job_desc = '$job_name';";
$sql = "SELECT $pub_id = pub_id FROM publishers WHERE pub_name = '$pub_name';";
$sql = "INSERT INTO employee(fname,lname,job_id,job_lvl,pub_id,hire_date)
		        VALUES ('$first_name','$last_name','$job_id','$job_level,$pub_id,$hire_date');";
if (!$mysqli->multi_query($sql)) {
    echo "Multi query failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

do {
    if ($res = $mysqli->store_result()) {
        var_dump($res->fetch_all(MYSQLI_ASSOC));
        $res->free();
    }
} while ($mysqli->more_results() && $mysqli->next_result());

 

mysql_close($conn)

?>
	
<!--
	<section id="section_center"> hello
	</section>

	-->
	</div> 

	<footer id="bottom_footer">
	<p>&copy; Copyright 2016 Kenneth Gitlitz. </p>
	</footer> 

	<script>


		window.onload = function() { req_authors() }; // load authors when page loads
		var request; 
		function req_authors(){

			// form data objects found at: 
			// https://developer.mozilla.org/en-US/docs/Web/API/FormData/Using_FormData_Objects

			document.getElementById("section_center").innerHTML = "loading authors......"; 

			request = new XMLHttpRequest(); // message sent to server 

			var fd = new FormData(); 
			fd.append("request", "get_authors"); 

			request.onreadystatechange = authors_arrived; // setup callback (Asynchronous)
			request.open("POST", "process_req.php"); // prepare POST message
			request.send(fd); 

		}// end req_authors



		function authors_arrived(){ // called when the server responds to message 

			if(request.readyState !== XMLHttpRequest.DONE) { return; } 
			if(request.status !== 200){ return; } // check for HTTP OK 

			var json_arr; 
			var json; 

			try{ 
				json_arr = JSON.parse(request.responseText); 
			}catch(ex){
				alert(ex.message);  
			}

			var i; 
			var tbl_data = "<table id='id_tbl'>"; 
			
			tbl_data += "<colgroup>"; 


			for(i = 0; i < 6; i++)
			{
				tbl_data += "<col></col>"; 

			}

			tbl_data += "</colgroup>"; 


			for(i = 0; i < json_arr.length; i++)
			{
				var row = json_arr[i]; 

				tbl_data += "<tr id=" + row.au_id + ">";
				tbl_data += "<td onClick='click_author(this)' style='font-size: 20px'>+</td>"
				tbl_data += "<td >"; 
				tbl_data += row.au_fname; 
				tbl_data += " "; 
				tbl_data += row.au_lname; 
				tbl_data += "</td>"; 
				tbl_data += "<td >"; 
				tbl_data += row.address; 
				tbl_data += "</td>"; 
				tbl_data += "<td >"; 
				tbl_data += row.city; 
				tbl_data += "</td>"; 
				tbl_data += "<td >"; 
				tbl_data += row.state; 
				tbl_data += "</td>"; 
				tbl_data += "<td >"; 
				tbl_data += row.zip; 
				tbl_data += "</td>"; 
				tbl_data += "</tr>"; // end item
				
			}

			tbl_data += "</table>"; 

			document.getElementById("section_center").innerHTML = "<div class='scrollable'>" + tbl_data + "</div>"; // display table 
		}

		 

		function click_author(col)
		{

			var au_id = col.parentNode.id; 
			var row_idx = col.parentNode.rowIndex; 
			var child_idx = row_idx + 1; 
			var symbol = col.innerHTML.trim(); 
			var table = document.getElementById('id_tbl'); 

			if(symbol == '+')
			{
				var row = table.insertRow(child_idx); 
				var col_minMax = row.insertCell(0); // empty
				var col_books = row.insertCell(1); 

				col_books.colSpan = 6; // cover all columns except + or -
				col_books.innerHTML = "Loading..."; 

				col.innerHTML = "-"; // expanded

				var req = new XMLHttpRequest(); // var gets us a new one every time 

				var fd = new FormData(); 
				fd.append("request", "get_au_books"); 
				fd.append("author", au_id); 

				req.onreadystatechange = function()
				{
					if(req.readyState !== XMLHttpRequest.DONE) { return; } 
					if(req.status !== 200){ return; } // check for HTTP OK 

					if(col.innerHTML == "+")
					{
						return; 
					}

					var json_arr;  

					try{ 
						json_arr = JSON.parse(req.responseText); 
					}catch(ex){
						col_books.innerHTML = "JSON error: " + ex.message;  
						return; 
					}

					var output = ""; 
					var i;  

					for(i = 0; i < json_arr.length; i++)
					{
						var row = json_arr[i]; 

						output += row.title + "<br>"; 
					}

					output = "Books: " + i + "<br>" + output; 

					col_books.innerHTML = output; 
					
				}// end new function 
			
				req.open("POST", "process_req.php"); // prepare POST message
				req.send(fd); 

			}else{ // close book information

				table.deleteRow(row_idx + 1);
				col.innerHTML = "+"; // not expanded
			}
		}


	</script> 

</body> 

</html>
