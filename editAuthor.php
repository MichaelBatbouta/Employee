<!DOCTYPE html>
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
	<li class="v_list"><a href="addAuthor.php">Add</a></li>
	<li class="v_list"><a>Remove</a></li>
	<li class="v_list"><a href="editAuthor.php">Edit</a></li>

	</ul> 

	</aside> 

	<section id="section_center"> hello
	</section>
	
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

				tbl_data += "<tr id=" + row.emp_id + ">";
				tbl_data += "<td onClick='click_author(this)' style='font-size: 20px'>+</td>"
				tbl_data += "<td >"; 
				tbl_data += row.fname; 
				tbl_data += " "; 
				tbl_data += row.lname; 
				tbl_data += "</td>"; 
				tbl_data += "<td >"; 
				tbl_data += row.job_desc; 
				tbl_data += "</td>"; 
				tbl_data += "<td >"; 
				tbl_data += row.job_lvl; 
				tbl_data += "</td>"; 
				tbl_data += "<td >"; 
				tbl_data += row.pub_name; 
				tbl_data += "</td>"; 
				tbl_data += "<td >"; 
				tbl_data += row.hire_date; 
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

				col_books.colSpan = 7; // cover all columns except + or -
				col_books.innerHTML = "Loading..."; 

				col.innerHTML = "-"; // expanded

				var req = new XMLHttpRequest(); // var gets us a new one every time 

				var fd = new FormData(); 
				fd.append("request", "get_au_books"); 
				fd.append("author", emp_id); 

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
			var tbl2_data = "<table id='id2_tbl'>"; 
			
 


			for(i = 0; i < 6; i++)
			{
				tbl2_data += "<col></col>"; 

			}




				tbl2_data += "<tr id=" + emp_id + ">";
				tbl2_data += "<td >"; 
				tbl2_data += row.fname; 
				tbl2_data += " "; 
				tbl2_data += row.lname; 
				tbl2_data += "</td>"; 
				tbl2_data += "<td >"; 
				tbl2_data += row.job_desc; 
				tbl2_data += "</td>"; 
				tbl2_data += "<td >"; 
				tbl2_data += row.job_lvl; 
				tbl2_data += "</td>"; 
				tbl2_data += "<td >"; 
				tbl2_data += row.pub_name; 
				tbl2_data += "</td>"; 
				tbl2_data += "<td >"; 
				tbl2_data += row.hire_date; 
				tbl2_data += "</td>"; 
				tbl_data += "</tr>"; // end item
				
			

			tbl2_data += "</table>"; 

			document.innerHTML = "<div>" + tbl2_data + "</div>"; // display table 
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
