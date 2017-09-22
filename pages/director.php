<!DOCTYPE html>
<html>
   <title>Actor-Directors </title>
   <head>
      <link type="text/css" rel="stylesheet" href="../resources/page.css">
	  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	  
      <script  src="https://code.jquery.com/jquery-2.2.4.min.js" 
			  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous">
		</script>
		
		<script>
			$(function(){
				$('#left-nav').load('left-nav-pane.html');
			});
		</script>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />	
   </head>
   <body>
      <div id="container">
         
		 <div>	 
			<iframe id="header" src="./header.html" name="header" allowTransparency="true" scrolling="no" frameborder="0">
			</iframe>
		</div>
		
         <div class="gap">
         </div>
         <div class="gap">
         </div>
		 
		 <div id="left-nav"></div>
		
         <div style="height:400px;width:.4%;float:left;">
         </div>
         <div id="content">
            <div>
			
				<p><font color="#400000"><b><a href="./index.php" class="a-no-deco">Home </a> > Director</b></font> 
					<h3 align="center">Actors who also directed a movie </h3>
				</p>
				
               <table id="data-table" class="table table-bordered">
                  		
                  		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
						
                        <p align="center"><span class="madatory">*are mandatory fields</span></p>
                        <table align="center">
                            <tr>
                                <td align="right"><b><label><span class="madatory">*</span>Click "find" to get actor(s) who have/are directors.  </label> </b></td>&nbsp;&nbsp
                                <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Find"></td>
                                
                            </tr>
                        </table>
                    </form>					

					<?php
							if(isset($_POST['submit'])){
							/*$servername = "localhost";
							$username = "root";
							$password = "";
							$conn = new PDO("mysql:host=$servername;dbname=ais_project1", $username, $password); */
							
							include './common.php';
							
							//$conn = mysqli_connect("localhost", "root", "", "ais_project1");
							//mysqli_select_db("ais_project1", $conn);
							//search code
								if($_REQUEST['submit']){				
								
									$message = '<h4>No match found!</h4>';
									
									//genre(s) with max. number of movies  
									$sele = "select actors.first_name,actors.last_name 
									from actors
									INNER JOIN directors ON ((actors.first_name=directors.first_name) and (actors.last_name=directors.last_name)) ORDER BY `last_name` ASC";
									//$result = mysqli_query($conn,$sele);
									
									$stmt = $db->query($sele);
									
									if($stmt->rowCount() > 0){
									
									echo '<div class="w3-container div-dt-wrapper"><table align="center" class="w3-table-all" table id="result_data" class="table table-striped table-bordered">';
									echo '<thead><tr class="w3-grey"> <th>First Name</th><th>Last Name </th></tr> </thead>';
									
									while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
									echo '<tr><td>' .$row['first_name'] .'</td><td>' .$row['last_name']. '</td></tr>';
									}
									
									echo '</table></div>';
								}else{
										echo'<h2> Search Result</h2>';
										print ($message);
										}
										
									//mysqli_free_result($result);
									//mysqli_close($conn);
								}
							}
						?>
				   </table>
				</div>
			 </div>
		 
         <div>	 
			<iframe id="footer" src="./footer.html" name="footer" allowTransparency="true" scrolling="no" frameborder="0">
			</iframe>
		</div>
      </div>
   </body>
 </html>
 
 <script>  
	 $(document).ready(function(){  
		  $('#result_data').DataTable({
			"scrollY":        "350px",
			"scrollCollapse": true
    });
	 });
 
 </script>