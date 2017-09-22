<!DOCTYPE html>
<html>
   <title>2 Genre </title>
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
            <div class="container">

                <p><font color="#400000"><b><a href="./index.php" class="a-no-deco">Home </a> > 2 Genre</b></font> 
                    <h3 align="center">Actors with max. number of movies of a user-given genre </h3>
                </p>
                
               <table id="data-table" class="table table-bordered">
                          
                      <form action="<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>" method="POST">
                        
                        <p align="center"><span class="madatory">*are mandatory fields</span></p>
                        <table align="center">
                            <tr>
                                <td align="right"><b><label><span class="madatory">*</span>Enter Genre</label> :</b></td>
                                <td align="left"><input type="text" name="genreName" required></td>
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
    
    // the page showing actors with max. number of movies of a user-given genre
    
    //search code
    if ($_REQUEST['submit']) {
        $genreName = $_POST['genreName'];
        $countMax  = 0;
        //print ($genreName);
        if (empty($genreName)) {
            $message = '<h4>No match found!</h4>';
        } else {
            $message = '<h4>No match found!</h4>';
            
            $sele = "select max(c1) as maxCount from ( select actorsInMovieGenre as a_id, COUNT(DISTINCT givenMovieGenreId) as c1 from ( select actor_id as actorsInMovieGenre,movie_id as givenMovieGenreId from roles where roles.movie_id in (SELECT movie_id FROM `movies_genres` WHERE genre='$genreName')) as t1 GROUP by actorsInMovieGenre  ORDER BY COUNT(DISTINCT givenMovieGenreId)  DESC ) as t2";
            
            $result = $db->query($sele);
            
            if ( $result->rowCount() > 0) {
                
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    
                    $countMax = $row['maxCount'];
                    //print ($countMax);
                    
                    
                    $selectQuery = "SELECT actorsInMovieGenre AS a_id, COUNT(givenMovieGenreId) AS c1 FROM (SELECT actor_id AS actorsInMovieGenre, movie_id AS givenMovieGenreId FROM ROLES WHERE roles.movie_id IN (SELECT movie_id FROM `movies_genres` WHERE genre='$genreName' ) ) AS t1 GROUP BY actorsInMovieGenre HAVING c1 = '$countMax' ORDER BY `c1` DESC";
                    
                    $result1 = $db->query($selectQuery);
                    
                    echo '<h2> Search Result</h2>';
                    
                    if ($result1->rowCount() > 0){
                    
                    echo '<div class="w3-container"><table align="center" class="w3-table-all">';
                    echo '<thead><tr class="w3-grey"> <th>First Name</th><th>Last Name </th> ';
                    echo ' <th>Gender</th><th>Movie Count</th> </tr> </thead>';
                    
                    
                    while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
                        
                        $actorIdentifier = $row['a_id'];
                        
                        $selectQuery2 = "SELECT * FROM actors WHERE id='$actorIdentifier'";
                        $result2      = $db->query($selectQuery2);
                        
                        while ($row1 = $result2->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr><td>' . $row1['first_name'] . '</td><td>' . $row1['last_name'] . '</td>';
                            echo '<td>' . $row1['gender'] . '</td><td>' . $countMax . '</td></tr>';
                        }
                    }
                    
                    echo '</table></div>';
                    
                    } else {
                    	
                		print($message);
                    }
                    
                }
                
                
            } else {
                echo '<h2> Search Result</h2>';
                print($message);
            }
            
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