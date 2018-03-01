<html>
  <head>
    <title>Registration | R6API</title>
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
      if(isset($_REQUEST['usreg'])){
        $email = $_REQUEST['email'];
        $password1 = $_REQUEST['password2'];
        $password2 = $_REQUEST['password1'];

        if($password1 != $password2){
          echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
          echo "<h1>password diverse</h1></div></div></div>";
        }
        else{
          $servername = "localhost";
          $username = "mazzolenip@localhost";
          $passwordd = "";
          $dbname = "my_mazzolenip";

          $conn = new mysqli($servername, $username, $passwordd, $dbname);
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          $sql = "SELECT * FROM r6api_utenti WHERE email='".$email."'";
          $result = $conn->query($sql);
          
          if ($result->num_rows == 0) {
            $sql = "INSERT INTO r6api_utenti (email,password) VALUES ('".$email."','".$password1."')";

            if ($conn->query($sql) === TRUE) {
              echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
              echo "<h1>utente registrato correttamente</h1></div></div></div>";
              mail($email,"R6API - Registration","Welcome in R6API website!\n\nYou registered as:\nemail - ".$email."\npassword - ".$password1."");
            } 
            else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
          } 
          else{
            echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
            echo "<h1>utente già registrato con questa email</h1></div></div></div>";
          }
        }
      }

      else{
        echo "<div class=\"container\"><div class=\"box\"><div class=\"vertical-align\">";
        echo "<form action=\"./reg.php\" method=\"post\"><h1>EMAIL</h1>";
        echo "<input type=\"text\" name=\"email\" required><br><br><h1>PASSWORD</h1>";
        echo "<input type=\"password\" name=\"password1\" required><br><br><h1>CONFIRM PASSWORD</h1>";
        echo "<input type=\"password\" name=\"password2\" required><br><br>";  
        echo "<br><br><input class=\"button button5\" type=\"submit\" name=\"usreg\" value=\"SIGN UP\"></form></div></div></div>";        
      }
    ?>
  </body>
</html>