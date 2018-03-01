<html>
	<head>
      <?php
      	if(isset($_REQUEST['comp']))
          echo "<title>Compare | R6API</title>";
        else if(isset($_REQUEST['stat'])){
          echo "<title>Stats | R6API</title>";	
        }
        else
          echo "<title>R6API</title>";
      ?>
      <link rel="shortcut icon" href= "./img/favicon.ico">
      <link rel="stylesheet" type="text/css" href="./css/style.css">
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <style>
      	body{
          font-family: 'Open Sans', sans-serif;
          width:100%; 
          margin: 0; 
          background-image: url("./img/wallpaper-pc.jpg");
          background-position: center center;
          background-size: cover;
          background-attachment: fixed;
          background-repeat: no-repeat;
        }
        
        .button {
            font-family: 'Roboto', sans-serif;
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 16px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;
            cursor: pointer;
            width: 25%;
            min-width: 200px;
        }
		
        .button5 {
            background-color: white;
            color: black;
            border: 2px solid #555555;
        }

        .button5:hover {
            background-color: #555555;
            color: white;
        }
      </style>
    </head>
    <script>
      function onfavchange() {
        var x = document.getElementById("fav").value;
        document.getElementById("usr").value = x.split('|')[0];
        if(x.indexOf('uplay')>=0){
        	document.getElementById("ptf").value = "uplay";
        }
        else if(x.indexOf('ps4')>=0){
        	document.getElementById("ptf").value = "ps4";
        }
        else{
        	document.getElementById("ptf").value = "xone";
        }
      }
    </script>
    <body onload="noback();"> 
      <?php
        session_start();
        //USER CHOOSE COMPARE
      	if(isset($_REQUEST['comp'])){
          echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
          echo "<form action=\"./script/compare.php\" method=\"post\"><h1>DASHBOARD</h1>";
          echo "<table align=\"center\"><tr><td><h1 align=\"center\">USER 1</h1></td><td><h1 align=\"center\">USER 2</h1></td></tr>";
          echo "<tr><td align=\"center\"><input type=\"text\" name=\"username1\"></td><td align=\"center\"><input type=\"text\" name=\"username2\"></td></tr>";
          echo "<tr><td align=\"center\"><select name=\"platform1\"><option value=\"uplay\">PC</option><option value=\"ps4\">PS4</option><option value=\"xone\">XBOX ONE</option></select></td><td align=\"center\"><select name=\"platform2\"><option value=\"uplay\">PC</option><option value=\"ps4\">PS4</option><option value=\"xone\">XBOX ONE</option></select></td></tr></table><br>";
          echo "<input class=\"button button5\" type=\"submit\" value=\"  Compare !  \"></form></div></div></div>";
        }
        
        //USER CHOOSE STATS
        else if(isset($_REQUEST['stat'])){
          session_start();	
          echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
          echo "<form action=\"./script/stats.php\" method=\"post\"><h1>DASHBOARD</h1>";
          echo "<input id=\"usr\" type=\"text\" name=\"username\" placeholder=\"Username\" required> ";
          if(isset($_SESSION['user'])){
          
            $servername = "localhost";
            $username = "mazzolenip@localhost";
            $password = "";
            $dbname = "my_mazzolenip";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
           $sql = "SELECT user_fav,platform FROM r6api_preferiti WHERE user_logged = '".$_SESSION['user']."'";
           $result = $conn->query($sql);
           if ($result->num_rows > 0) {
             echo "<select id=\"fav\" onchange=\"onfavchange()\">";
             echo "<option></option>";
             while($row = $result->fetch_assoc()) {
               echo "<option value=\" ".$row['user_fav']."|".$row['platform']." \">".$row['user_fav']." | ".$row['platform']."</option>";
             }
             echo "</select>";
           }
          }
          echo "<br><br><select id=\"ptf\" name=\"platform\">";
          echo "<option value=\"uplay\">PC</option>";
          echo "<option value=\"ps4\">PS4</option>";
          echo "<option value=\"xone\">XBOX ONE</option>";
          echo "</select><br><br><input class=\"button button5\" type=\"submit\" value=\"  Search  \"></form></div></div></div>";
        }
        
        //LOGIN/REGISTER BUTTONS
        else if(isset($_REQUEST['logreg'])){
            echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
            echo "<form action=\"./script/log.php\" method=\"post\">";
            echo "<input class=\"button button5\" type=\"submit\" value=\"LOGIN\" name=\"comp\"></form>";
            echo "<form action=\"./script/reg.php\" method=\"post\">";
            echo "<input class=\"button button5\" type=\"submit\" value=\"REGISTER\" name=\"logreg\"></form></div></div></div>";
        }
        
        //MANAGE FAVOURITES
        else if(isset($_REQUEST['fav']) || isset($_REQUEST['insname_b']) || isset($_REQUEST['delid_b'])){
        	echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
        
            session_start();
            $servername = "localhost";
            $username = "mazzolenip@localhost";
            $password = "";
            $dbname = "my_mazzolenip";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            if(isset($_REQUEST['insname_b']) || isset($_REQUEST['delid_b'])){
            	if(isset($_REQUEST['insname_b'])){
                	$sql = "SELECT * FROM r6api_preferiti WHERE user_logged = '".$_SESSION['user']."' AND id = '".$_REQUEST['delid']."'";
                    $result = $conn->query($sql);
                    if ($result->num_rows == 0) {
                      $sql = "INSERT INTO r6api_preferiti (user_fav,platform,user_logged) VALUES('".$_REQUEST['insname']."','".$_REQUEST['platform']."','".$_SESSION['user']."')";
                      if ($conn->query($sql) === FALSE) {
                          echo "Error deleting record: " . $conn->error;
                      }
                    }
                }
                else{
                	$sql = "SELECT * FROM r6api_preferiti WHERE user_logged = '".$_SESSION['user']."' AND id = '".$_REQUEST['delid']."'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                      $sql = "DELETE FROM r6api_preferiti WHERE user_logged = '".$_SESSION['user']."' AND id = '".$_REQUEST['delid']."'";
                      if ($conn->query($sql) === FALSE) {
                          echo "Error deleting record: " . $conn->error;
                      }
                    }
                }
            }
            
            $sql = "SELECT * FROM r6api_preferiti WHERE user_logged = '".$_SESSION['user']."'";
			$result = $conn->query($sql);
            //view favourites
            if ($result->num_rows > 0) {
              $i = 0;
              echo "<table align = \"center\"><tr bgcolor=\"#262E45\"><th class=\"thead\">ID</th><th class=\"thead\">NAME</th><th class=\"thead\">PLATFORM</th></tr>";
              while($row = $result->fetch_assoc()) {
                  if($i%2==0)
                  	echo "<tr bgcolor=\"#C3C6CC\"><td>".$row['id']."</td><td>".$row['user_fav']."</td><td>".$row['platform']."</td></tr>";
                  else
                  	echo "<tr bgcolor=\"#FFFFFF\"><td>".$row['id']."</td><td>".$row['user_fav']."</td><td>".$row['platform']."</td></tr>";
                  $i++;
              }
              echo "</table>";
            } 
            else {
                echo "<h1>Ancora nessun preferito</h1>";
            }
            
            //menu manage
            echo "<br><br><table align = \"center\">";
            //insert
            echo "<tr><td>";
            	echo "<form method=\"post\" action=\"./index.php\">";
            	echo "<table align=\"center\">";
                echo "<tr bgcolor=\"#262E45\"><th class=\"thead\">INSERT</th></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td><input type=\"text\" placeholder=\"Username\" name=\"insname\"></td></tr>";
                echo "<tr><td align=\"center\"><select name=\"platform\"><option value=\"uplay\">PC</option><option value=\"ps4\">PS4</option><option value=\"xone\">XBOX ONE</option></select></td></tr>";
            	echo "<tr><td><input class=\"button button5\" type=\"submit\" value=\"Insert!\" name=\"insname_b\"></td></tr>";
            	echo "</form>";
            echo "</table>";
            
            //delete
            echo "<td>";
            	echo "<form method=\"post\" action=\"./index.php\">";
            	echo "<table align=\"center\">";
                echo "<tr bgcolor=\"#262E45\"><th class=\"thead\">DELETE</th></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td><input type=\"text\" placeholder=\"ID\" name=\"delid\"></td></tr>";
                echo "<tr><td><input class=\"button button5\" type=\"submit\" value=\"Delete!\" name=\"delid_b\"></td></tr>";
                echo "</form>";
                echo "</table>";
            echo "</td></tr>";
            echo "</table>";
            
            echo "</div></div></div>";
        }
        
        //PRINT MENU
        else{
        	echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
        	if(isset($_REQUEST['logout'])){
              unset($_SESSION['user']);
            }
        	if(isset($_SESSION['user'])){
              echo "<h1>BENVENUTO ".$_SESSION['user']."<h1>";
            }
            echo "<form action=\"./index.php\" method=\"post\">";
            echo "<input class=\"button button5\" type=\"submit\" value=\"STATS\" name=\"stat\"></form>";
            echo "<form action=\"./index.php\" method=\"post\">";
            echo "<input class=\"button button5\" type=\"submit\" value=\"COMPARE 2 PLAYERS\" name=\"comp\"></form>";
            if(isset($_SESSION['user'])){
              echo "<form action=\"./index.php\" method=\"post\">";
              echo "<input class=\"button button5\" type=\"submit\" value=\"MANAGE YOUR FAVOURITES\" name=\"fav\"></form>";
              echo "<form action=\"./index.php\" method=\"post\">";
              echo "<input class=\"button button5\" type=\"submit\" value=\"LOGOUT\" name=\"logout\"></form></div></div></div>";
            }
            else{
              echo "<form action=\"./index.php\" method=\"post\">";
              echo "<input class=\"button button5\" type=\"submit\" value=\"LOGIN/REGISTER\" name=\"logreg\"></form></div></div></div>";
            }
        }
      ?>
    </body>
</html>
