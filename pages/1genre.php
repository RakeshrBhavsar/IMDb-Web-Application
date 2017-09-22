<!DOCTYPE html>
<html>
   <title>1 Genre </title>
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
            
                <p><font color="#400000"><b><a href="./index.php" class="a-no-deco">Home </a> > 1 Genre</b></font> 
                    <h3 align="center">Genre(s) with max. number of movies</h3>
                </p>
                
               <table id="data-table" class="table table-bordered">
                          
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        
                        <p align="center"><span class="madatory">*are mandatory fields</span></p>
                        <table align="center">
                            <tr>
                                <td align="right"><b><label><span class="madatory">*</span>Click Submit to find genre(s) with max. number of movies  </label> </b></td>
                            </tr>
                            
                            <tr>
                                <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Submit"></td>
                                
                            </tr>
                        </table>
                    </form>                    

                    <?php
if (isset($_POST['submit'])) {
    
    
    //including common db connect code
    include './common.php';
    
    
    //search code
    if ($_REQUEST['submit']) {
        
        $message = '<h4>No match found!</h4>';
        
        //genre(s) with max. number of movies  
        $sele = "SELECT genre, COUNT(*) as maxMovieCount FROM movies_genres GROUP BY genre HAVING COUNT(*) = (SELECT MAX(maxmovie_id) FROM (select count(movie_id) as maxmovie_id,genre from movies_genres group by genre)as t1)";
        
        $stmt = $db->query($sele);
        
        if ($message = $stmt->rowCount() > 0) {
            
            echo '<h2> Search Result</h2>';
            echo '<div class="w3-container"><table align="center" class="w3-table-all">';
            echo '<thead><tr class="w3-grey"> <th>Genre</th><th>Movie Count</th></tr> </thead>';
            
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr><td>' . $row['genre'] . '</td><td>' . $row['maxMovieCount'] . '</td></tr>';
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