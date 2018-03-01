<html>
	<head>
    	<title>Login | R6API</title>
        <link rel="shortcut icon" href= "../img/favicon.ico">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
      	body{
          font-family: 'Open Sans', sans-serif;
          width:100%; 
          margin: 0; 
          background-image: url("../img/wallpaper-pc.jpg");
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
        if(isset($_REQUEST['uslogin'])){
          session_start();
          $servername = "localhost";
          $username = "mazzolenip@localhost";
          $passwordd = "";
          $dbname = "my_mazzolenip";

          $conn = new mysqli($servername, $username, $passwordd, $dbname);
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }
            
          $email = $_REQUEST['email'];
          $password = $_REQUEST['password'];
            
          $sql = "SELECT * FROM r6api_utenti WHERE email='".$email."'";
          $result = $conn->query($sql);
          if ($result->num_rows == 0) {
            echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
            echo "<br><h1>Utente non presente. <a href=\"./registrazione.html\">Registrati!</a><br><br>Hai sbagliato email? <a href=\"javascript:history.back();\">Torna indietro</a></h1>";
            echo "</div></div></div>";
          } 
            
          else {
            $row = $result->fetch_assoc();
            if($row['password'] == $password){
              $_SESSION['user'] = $email;
              header("location: ../index.php");
            }
			else{
              echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
              echo "<br><h1>Utente trovato - password errata</h1>";
			  echo "<br><br><a href=\"javascript:history.back();\">Torna indietro!</a>";
              echo "</div></div></div>";
            }
          }
        }
        else{
          if(isset($_SESSION['user'])){
          	unset($_SESSION['user']);
          }
          echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
          echo "<form action=\"./log.php\" method=\"post\"><h1>EMAIL</h1>";
          echo "<input type=\"text\" name=\"email\" required><br><br><h1>PASSWORD</h1>";
          echo "<input type=\"password\" name=\"password\" required><br><br>";        
          echo "<br><br><input class=\"button button5\" type=\"submit\" name=\"uslogin\" value=\"LOGIN\"></form></div></div></div>";        
        }
      ?>
    </body>
</html>
