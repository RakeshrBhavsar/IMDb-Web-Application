<!DOCTYPE html>
<html>
   <title>2 Degree </title>
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
            
                <p class="p-decoration"><font color="#400000"><b><a href="./index.php" class="a-no-deco">Home </a> > 2 Degree</b></font> 
                    <h3 align="center">Two degrees of separation from Kevin Bacon</h3>
                </p>
                
               <table id="data-table" class="table table-bordered">
                          
                          <form action="<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>" method="POST">
                        
                        <p align="center"><span class="madatory">*are mandatory fields</span></p>
                        <table align="center">
                            <tr>
                                <td align="right"><b><label><span class="madatory">*</span>First Name</label> :</b></td>
                                <td align="left"><input type="text" name="firstName" required></td>
                            </tr>
                            <tr>
                                <td align="right"><b><label><span class="madatory">*</span>Last Name</label> :</b></td>
                                <td align="left"><input type="text" name="lastName" required></td>
                            </tr>
                            <tr>
                                <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Search"></td>
                                <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Reset"></td>
                            </tr>
                        </table>
                    </form>                    

                    <?php
if (isset($_POST['submit'])) {
    
    // Connect to Database 
    include './common.php';
    
    
    //search code
    if ($_REQUEST['submit']) {
        
        $FirstName = $_POST['firstName'];
        $LastName  = $_POST['lastName'];
        $message   = '<h4 align="center">No match found!</h4>';
        
        $sele = "select *  from actors where last_name='$LastName' AND first_name in (select first_name from actors where first_name like '$FirstName' or first_name like '$FirstName (%') ORDER BY film_count DESC , id ASC LIMIT 1";
        
        $stmt = $db->query($sele);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $user_actorID = $row['id'];
        
        //print ($user_actorID);
        
        //check if result is null and execute if null
        
        if (!empty($user_actorID)) {
            
            //checking if the actor already worked with Kevin Bacon
            $query1 = "SELECT name,year FROM movies WHERE id IN(SELECT movie_id FROM roles WHERE actor_id='$user_actorID' AND movie_id IN(SELECT movie_id FROM `roles` WHERE actor_id=22591))";
            $stmt2  = $db->query($query1);
            
            if ($message = $stmt2->rowCount() > 0) {
                
                echo "<h4> The actor $FirstName $LastName has already worked with Kevin Bacon the following movies.</h4><br><br>";
                echo '<div class="w3-container div-dt-wrapper"><table align="center" table id="result_data" class="table table-striped table-bordered">';
                echo '<thead><tr class="w3-grey"> <th>Movie Name</th><th>Movie Year</th></tr> </thead>';
                
                while ($row1 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr><td>' . $row1['name'] . '</td><td>' . $row1['year'] . '</td></tr>';
                } // end of while 
                echo '</table>';
            } //if
            else {
                
                
                $query = "SELECT first_name,last_name,gender FROM actors WHERE id IN(

                                                SELECT DISTINCT TempTable2.actor_id
                                                FROM
                                                ((
                                                SELECT * FROM roles WHERE actor_id  = '$user_actorID'
                                                ) AS TempTable1

                                                INNER JOIN
                                                (
                                                SELECT * FROM roles WHERE actor_id IN (SELECT actor_id FROM roles WHERE movie_id IN(SELECT movie_id FROM roles WHERE actor_id = 22591) AND actor_id <>22591)
                                                ) AS TempTable2
                                                ON TempTable1.movie_id = TempTable2.movie_id))";
                
                
                $stmt1 = $db->query($query);
                
                if ($message = $stmt1->rowCount() > 0) {
                    //echo'<h4 id="result"> Search Result</h4>';
                    echo '<div class="w3-container div-dt-wrapper"><table align="center" table id="result_data" class="table table-striped table-bordered">';
                    echo '<thead><tr class="w3-grey"> <th>First Name</th><th>Last Name </th>
                                                    <th>Gender</th></tr></thead>';
                    
                    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr><td>' . $row1['first_name'] . '</td><td>' . $row1['last_name'] . '</td><td>' . $row1['gender'] . '</td></tr>';
                    } // end of while
                    echo '</table> </div>';
                } //if
                
            } //else
        } //if
        else {
            echo '<h4 align="center"> Search Result</h4>';
            print($message);
        }
    } //if
    
    
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