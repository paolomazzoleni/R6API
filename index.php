<html>
	<?php
		/*$servername = "localhost";
        $username = "mazzolenip@localhost";
        $password = "";
        $dbname = "my_mazzolenip";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "INSERT INTO r6api_utenti (email,password) VALUES ('john@example.com','prova')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();*/       
    ?>
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
    <body> 
      <?php
      	if(isset($_REQUEST['comp'])){
          echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
          echo "<form action=\"./script/compare.php\" method=\"post\"><h1>DASHBOARD</h1>";
          echo "<table align=\"center\"><tr><td><h1 align=\"center\">USER 1</h1></td><td><h1 align=\"center\">USER 2</h1></td></tr>";
          echo "<tr><td align=\"center\"><input type=\"text\" name=\"username1\"></td><td align=\"center\"><input type=\"text\" name=\"username2\"></td></tr>";
          echo "<tr><td align=\"center\"><select name=\"platform1\"><option value=\"uplay\">PC</option><option value=\"ps4\">PS4</option><option value=\"xone\">XBOX ONE</option></select></td><td align=\"center\"><select name=\"platform2\"><option value=\"uplay\">PC</option><option value=\"ps4\">PS4</option><option value=\"xone\">XBOX ONE</option></select></td></tr></table><br>";
          echo "<input class=\"button button5\" type=\"submit\" value=\"  Compare !  \"></form></div></div></div>";
        }
        
        else if(isset($_REQUEST['stat'])){
          echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
          echo "<form action=\"./script/stats.php\" method=\"post\"><h1>DASHBOARD</h1>";
          echo "<input type=\"text\" name=\"username\" required><br><br>";
          echo "<select name=\"platform\">";
          echo "<option value=\"uplay\">PC</option>";
          echo "<option value=\"ps4\">PS4</option>";
          echo "<option value=\"xone\">XBOX ONE</option>";
          echo "</select><br><br><input class=\"button button5\" type=\"submit\" value=\"  Search  \"></form></div></div></div>";
        }
        else{
        	echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
            echo "<form action=\"./index.php\" method=\"post\">";
            echo "<input class=\"button button5\" type=\"submit\" value=\"STATS\" name=\"stat\"></form>";
            echo "<form action=\"./index.php\" method=\"post\">";
            echo "<input class=\"button button5\" type=\"submit\" value=\"COMPARE 2 PLAYERS\" name=\"comp\"></form></div></div></div>";
        }
      ?>
    </body>
</html>