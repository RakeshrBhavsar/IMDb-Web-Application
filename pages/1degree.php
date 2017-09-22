<!DOCTYPE html>
<html>
   <title>1 Degree </title>
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
            
                <p><font color="#400000"><b><a href="./index.php" class="a-no-deco">Home </a> > 1 Degree</b></font> 
                    <h3 align="center">Film(s) with the given actor and Kevin Bacon</h3>
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
    
    
    // get Database Connection Details
    include './common.php';
    
    if ($_REQUEST['submit']) {
        
        // retrieve First and Last name typed by user in Input Fields
        $FirstName = $_POST['firstName'];
        $LastName  = $_POST['lastName'];
        $message   = '<h4>No match found!</h4>';
        
        
        $sele = "select *  from actors where last_name='$LastName' AND first_name in (select first_name from actors where first_name like '$FirstName' or first_name like '$FirstName (%') ORDER BY film_count DESC , id ASC LIMIT 1";
        
        $stmt = $db->query($sele);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $user_actorID = $row['id'];
        
        //echo $user_actorID;
        // SQL Query that search results for all films with the given actor and Kevin Bacon
        $sele1 = "SELECT * FROM movies WHERE movies.id IN (SELECT A.movie_id FROM roles A, roles B WHERE A.actor_id='$user_actorID' AND B.actor_id=22591 AND A.movie_id = B.movie_id) ";
        
        $result1 = $db->query($sele1);
        
        
        if ( $stmt->rowCount() > 0) {
            
            echo '<h2> Search Result</h2>';
            echo '<div class="w3-container"><table align="center" class="w3-table-all">';
            echo '<thead><tr class="w3-grey"> <th>First Name</th><th>Last Name</th></tr> </thead>';
            
            
            while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr><td>' . $row['name'] . '</td><td>' . $row['year'] . '</td></tr>';
            }
            
            echo '</table></div>';
            
            
        } else {
            echo '<h2> Search Result</h2>';
            print($message);
        }
        
        
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