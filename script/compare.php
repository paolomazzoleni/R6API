<html>
	<head>
      <title>Compare | R6API</title>
      <link rel="shortcut icon" href= "../img/favicon.ico">
	  <link rel="stylesheet" type="text/css" href="../css/style_script.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <style>
      	table{
          	width:40%;
          }
      </style>
    </head>
    <body>
      <?php
        	//THIS PART IS DONE TO GET THE PLAYERS ID THAT WILL BE USED AFTER TO GET DETAILED STATS
        	//URL parts
            $host = "https://api.r6stats.com/api/v1/players/";
            $usr1 = $_POST['username1'];
            $ptf1 = $_POST['platform1'];
            $usr2 = $_POST['username2'];
            $ptf2 = $_POST['platform2'];
            
            //compose URL1
              $url1 = $host.$usr1."/?platform=".$ptf1;
              //OVERVIEW cURL request
              $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url1);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-App-Id:R6API"));
                $result = curl_exec($ch);
              curl_close($ch);
              //decode received json
              $content1 = json_decode($result,true);
            
            //compose URL2
              $url2 = $host.$usr2."/?platform=".$ptf2;
              //OVERVIEW cURL request
              $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url2);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-App-Id:R6API"));
                $result = curl_exec($ch);
              curl_close($ch);
              //decode received json
              $content2 = json_decode($result,true);
            
            //if users not found
            if(empty($content1['player']['username'])||empty($content2['player']['username'])){
            	if(empty($content1['player']['username'])){
                	echo "<h1 align=\"center\">Utente 1 (".$usr1.") non trovato.</h1>";
                }
                else if(empty($content2['player']['username'])){
                	echo "<h1 align=\"center\">Utente 2 (".$usr2.") non trovato.</h1>";
                }
                else{
                	echo "<h1 align=\"center\">Utente 1 (".$usr1.") e Utente 2 (".$usr2.") non trovati.</h1>";
                }
            }
            //else if users found
            else{
              //casual time USER 1
                $seconds = $content1['player']['stats']['casual']['playtime'];
                $hours = floor($seconds/3600);
                $seconds -= $hours * 3600;
                $minutes = floor($seconds / 60);
                $seconds -= $minutes * 60;
                $time_cas1 = "$hours:$minutes:$seconds";
              //ranked time
                $seconds = $content['player']['stats']['ranked']['playtime'];
                $hours = floor($seconds/3600);
                $seconds -= $hours * 3600;
                $minutes = floor($seconds / 60);
                $seconds -= $minutes * 60;
                $time_ran1 = "$hours:$minutes:$seconds";
              
              //casual time USER 2
                $seconds = $content2['player']['stats']['casual']['playtime'];
                $hours = floor($seconds/3600);
                $seconds -= $hours * 3600;
                $minutes = floor($seconds / 60);
                $seconds -= $minutes * 60;
                $time_cas2 = "$hours:$minutes:$seconds";
              //ranked time
                $seconds = $content['player']['stats']['ranked']['playtime'];
                $hours = floor($seconds/3600);
                $seconds -= $hours * 3600;
                $minutes = floor($seconds / 60);
                $seconds -= $minutes * 60;
                $time_ran2 = "$hours:$minutes:$seconds";
              
             //USERS OVERVIEW
                echo "<table align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
                  echo "<tr><th colspan=\"3\" align=\"center\">USER OVERVIEW</th></tr>";
                  echo "<tr><th colspan=\"1\"></th><th>".$content1['player']['username']."</th><th>".$content2['player']['username']."</th></tr>";
                  echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">LEVEL</td><td>".$content1['player']['stats']['progression']['level']."</td><td>".$content2['player']['stats']['progression']['level']."</td></tr>";
                  echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">CREATED AT</td><td>".substr($content1['player']['indexed_at'],0,10)." -- ".substr($content1['player']['indexed_at'],11,8)."</td><td>".substr($content2['player']['indexed_at'],0,10)." -- ".substr($content2['player']['indexed_at'],11,8)."</td></tr>";
                  echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">UPDATED AT</td><td>".substr($content1['player']['updated_at'],0,10)." -- ".substr($content1['player']['updated_at'],11,8)."</td><td>".substr($content2['player']['updated_at'],0,10)." -- ".substr($content2['player']['updated_at'],11,8)."</td></tr>";
                echo "</table>";   
              
            //CASUAL MATCHES
              $played1 = $content1['player']['stats']['casual']['wins'] + $content1['player']['stats']['casual']['losses'];
              $played2 = $content2['player']['stats']['casual']['wins'] + $content2['player']['stats']['casual']['losses'];
              echo "<br><table align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
                echo "<tr><th colspan=\"3\" align=\"center\">CASUAL MATCHES</th></tr>";
                echo "<tr><th colspan=\"1\"></th><th>".$content1['player']['username']."</th><th>".$content2['player']['username']."</th></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">PLAYED</td><td>".$played1."</td><td>".$played2."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">WON</td><td>".$content1['player']['stats']['casual']['wins']."</td><td>".$content2['player']['stats']['casual']['wins']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">LOST</td><td>".$content1['player']['stats']['casual']['losses']."</td><td>".$content2['player']['stats']['casual']['losses']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">W/L</td><td>".$content1['player']['stats']['casual']['wlr']."</td><td>".$content2['player']['stats']['casual']['wlr']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">KILLS</td><td>".$content1['player']['stats']['casual']['kills']."</td><td>".$content2['player']['stats']['casual']['kills']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">DEATHS</td><td>".$content1['player']['stats']['casual']['deaths']."</td><td>".$content2['player']['stats']['casual']['deaths']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">K/D</td><td>".$content1['player']['stats']['casual']['kd']."</td><td>".$content2['player']['stats']['casual']['kd']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">PLAYTIME</td><td>".$time_cas1."</td><td>".$time_cas2."</td></tr>";
              echo "</table>";
              
            //RANKED MATCHES  
              $played1 = $content1['player']['stats']['ranked']['wins'] + $content1['player']['stats']['ranked']['losses'];
              $played2 = $content2['player']['stats']['ranked']['wins'] + $content2['player']['stats']['ranked']['losses'];
              echo "<br><table align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
                echo "<tr><th colspan=\"3\" align=\"center\">RANKED MATCHES</th></tr>";
                echo "<tr><th colspan=\"1\"></th><th>".$content1['player']['username']."</th><th>".$content2['player']['username']."</th></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">PLAYED</td><td>".$played1."</td><td>".$played2."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">WON</td><td>".$content1['player']['stats']['ranked']['wins']."</td><td>".$content2['player']['stats']['ranked']['wins']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">LOST</td><td>".$content1['player']['stats']['ranked']['losses']."</td><td>".$content2['player']['stats']['ranked']['losses']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">W/L</td><td>".$content1['player']['stats']['ranked']['wlr']."</td><td>".$content2['player']['stats']['ranked']['wlr']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">KILLS</td><td>".$content1['player']['stats']['ranked']['kills']."</td><td>".$content2['player']['stats']['ranked']['kills']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">DEATHS</td><td>".$content1['player']['stats']['ranked']['deaths']."</td><td>".$content2['player']['stats']['ranked']['deaths']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">K/D</td><td>".$content1['player']['stats']['ranked']['kd']."</td><td>".$content2['player']['stats']['ranked']['kd']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">PLAYTIME</td><td>".$time_ran1."</td><td>".$time_ran2."</td></tr>";
              echo "</table>";
            
            //OTHER STATS
              echo "<br><table align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
                echo "<tr><th colspan=\"3\" align=\"center\">OTHER STATS</th></tr>";
                echo "<tr><th colspan=\"1\"></th><th>".$content1['player']['username']."</th><th>".$content2['player']['username']."</th></tr>";
			    echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">ASSIST</td><td>".$content1['player']['stats']['overall']['assists']."</td><td>".$content2['player']['stats']['overall']['assists']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">BULLETS FIRED</td><td>".$content1['player']['stats']['overall']['bullets_fired']."</td><td>".$content2['player']['stats']['overall']['bullets_fired']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">BULLETS HIT</td><td>".$content1['player']['stats']['overall']['bullets_hit']."</td><td>".$content2['player']['stats']['overall']['bullets_hit']."</td></tr>"; 
                  $fh1 = ($content1['player']['stats']['overall']['bullets_hit']/$content1['player']['stats']['overall']['bullets_fired'])*100;
                  $fh2 = ($content2['player']['stats']['overall']['bullets_hit']/$content2['player']['stats']['overall']['bullets_fired'])*100;
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">ACCURACY (BH/BF)</td><td>".number_format((float)$fh1,2,'.','')."%</td><td>".number_format((float)$fh2,2,'.','')."%</td></tr>";  
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">HEADSHOT</td><td>".$content1['player']['stats']['overall']['headshots']."</td><td>".$content2['player']['stats']['overall']['headshots']."</td></tr>";
                  $kt1 = $content1['player']['stats']['casual']['kills'] + $content1['player']['stats']['ranked']['kills'];
                  $kt2 = $content2['player']['stats']['casual']['kills'] + $content1['player']['stats']['ranked']['kills'];
                  $dt1 = $content1['player']['stats']['casual']['deaths'] + $content1['player']['stats']['ranked']['deaths'];
                  $dt2 = $content2['player']['stats']['casual']['deaths'] + $content2['player']['stats']['ranked']['deaths'];
                  $kdt1 = $kt1 / $dt1;
                  $kdt2 = $kt2 / $dt2;
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">KILLS (TOTAL)</td><td>".$kt1."</td><td>".$kt2."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">DEATHS (TOTAL)</td><td>".$dt2."</td><td>".$dt2."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">K/D (TOTAL)</td><td>".number_format((float)$kdt1,3,'.','')."</td><td>".number_format((float)$kdt2,3,'.','')."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">MELEE KILLS</td><td>".$content1['player']['stats']['overall']['melee_kills']."</td><td>".$content2['player']['stats']['overall']['melee_kills']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">REVIVES</td><td>".$content1['player']['stats']['overall']['revives']."</td><td>".$content2['player']['stats']['overall']['revives']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">SUICIDES</td><td>".$content1['player']['stats']['overall']['suicides']."</td><td>".$content2['player']['stats']['overall']['suicides']."</td></tr>";
                  $wt1 = $content1['player']['stats']['casual']['wins'] + $content1['player']['stats']['ranked']['wins'];
                  $wt2 = $content2['player']['stats']['casual']['wins'] + $content2['player']['stats']['ranked']['wins'];
                  $lt1 = $content1['player']['stats']['casual']['losses'] + $content1['player']['stats']['ranked']['losses'];
                  $lt2 = $content2['player']['stats']['casual']['losses'] + $content2['player']['stats']['ranked']['losses'];
                  $wlt1 = $wt1 / $lt1;
                  $wlt2 = $wt2 / $lt2;
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">WON (TOTAL)</td><td>".$wt1."</td><td>".$wt2."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">LOST (TOTAL)</td><td>".$lt1."</td><td>".$lt2."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">K/D (TOTAL)</td><td>".number_format((float)$wlt1,3,'.','')."</td><td>".number_format((float)$wlt2,3,'.','')."</td></tr>";
              echo "</table><br>";
            }
        ?>
    </body>
</html>