<html>
	<head>
		<title>Overview | R6API</title>
        <script src="../js/sorttable.js"></script>
    	<link rel="shortcut icon" href= "../img/favicon.ico">
		<link rel="stylesheet" type="text/css" href="../css/style_script.css">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
        	table{
            	width:40%;
            }
        </style>
    </head>
    <body><br>
    	<?php
            session_start();
        	//THIS PART IS DONE TO GET THE PLAYER ID THAT WILL BE USED AFTER TO GET DETAILED STATS
        	//URL parts
        	$host = "https://api.r6stats.com/api/v1/players/";
            $usr = $_POST['username'];
            $ptf = $_POST['platform'];
            //compose URL
            $url = $host.$usr."/?platform=".$ptf;
            //OVERVIEW cURL request
            $ch = curl_init();
              curl_setopt($ch,CURLOPT_URL,$url);
              curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-App-Id:R6API"));
              $result = curl_exec($ch);
            curl_close($ch);
            //decode received json
            $content = json_decode($result,true);

            //if user not found
            if(empty($content['player']['username'])){
            	echo "<h1 align=\"center\">Utente non trovato</h1>";
            }
            //else user found
            else{
              //casual time
                $seconds = $content['player']['stats']['casual']['playtime'];
                $hours = floor($seconds/3600);
                $seconds -= $hours * 3600;
                $minutes = floor($seconds / 60);
                $seconds -= $minutes * 60;
                $time_cas = "$hours:$minutes:$seconds";
              //ranked time
                $seconds = $content['player']['stats']['ranked']['playtime'];
                $hours = floor($seconds/3600);
                $seconds -= $hours * 3600;
                $minutes = floor($seconds / 60);
                $seconds -= $minutes * 60;
                $time_ran = "$hours:$minutes:$seconds";
            
              //USER OVERVIEW 
              	echo "<table align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
                  echo "<tr><th colspan=\"3\" align=\"center\">USER OVERVIEW</th></tr>";
                  echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">USERNAME</td><td>".$content['player']['username']."</td></tr>";
                  echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">LEVEL</td><td>".$content['player']['stats']['progression']['level']."</td></tr>";
                  echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">CREATED AT</td><td>".substr($content['player']['indexed_at'],0,10)." -- ".substr($content['player']['indexed_at'],11,8)."</td></tr>";
                  echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">UPDATED AT</td><td>".substr($content['player']['updated_at'],0,10)." -- ".substr($content['player']['updated_at'],11,8)."</td></tr>";
                echo "</table>";
                            
              //CASUAL STATS
              $played = $content['player']['stats']['casual']['wins'] + $content['player']['stats']['casual']['losses'];
              echo "<br><table align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
                echo "<tr><th colspan=\"3\" align=\"center\">CASUAL MATCHES</th></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">PLAYED</td><td>".$played."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">WON</td><td>".$content['player']['stats']['casual']['wins']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">LOST</td><td>".$content['player']['stats']['casual']['losses']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">W/L</td><td>".$content['player']['stats']['casual']['wlr']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">KILLS</td><td>".$content['player']['stats']['casual']['kills']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">DEATHS</td><td>".$content['player']['stats']['casual']['deaths']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">K/D</td><td>".$content['player']['stats']['casual']['kd']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">PLAYTIME</td><td>".$time_cas."</td></tr>";
              echo "</table>";
                
              //RANKED STATS
              $played = $content['player']['stats']['ranked']['wins'] + $content['player']['stats']['ranked']['losses'];
              echo "<br><table align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
                echo "<tr><th colspan=\"3\" align=\"center\">RANKED MATCHES</th></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">PLAYED</td><td>".$played."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">WON</td><td>".$content['player']['stats']['ranked']['wins']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">LOST</td><td>".$content['player']['stats']['ranked']['losses']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">W/L</td><td>".$content['player']['stats']['ranked']['wlr']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">KILLS</td><td>".$content['player']['stats']['ranked']['kills']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">DEATHS</td><td>".$content['player']['stats']['ranked']['deaths']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">K/D</td><td>".$content['player']['stats']['ranked']['kd']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">PLAYTIME</td><td>".$time_ran."</td></tr>";
              echo "</table>";
              
              //OTHER STATS
              echo "<br><table align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
                echo "<tr><th colspan=\"3\" align=\"center\">OTHER STATS</th></tr>";
			    echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">ASSIST</td><td>".$content['player']['stats']['overall']['assists']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">BULLETS FIRED</td><td>".$content['player']['stats']['overall']['bullets_fired']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">BULLETS HIT</td><td>".$content['player']['stats']['overall']['bullets_hit']."</td></tr>"; 
                  $fh = ($content['player']['stats']['overall']['bullets_hit']/$content['player']['stats']['overall']['bullets_fired'])*100;
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">ACCURACY (BH/BF)</td><td>".number_format((float)$fh,2,'.','')."%</td></tr>";  
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">HEADSHOT</td><td>".$content['player']['stats']['overall']['headshots']."</td></tr>";
                  $kt = $content['player']['stats']['casual']['kills'] + $content['player']['stats']['ranked']['kills'];
                  $dt = $content['player']['stats']['casual']['deaths'] + $content['player']['stats']['ranked']['deaths'];
                  $kdt = $kt / $dt;
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">KILLS (TOTAL)</td><td>".$kt."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">DEATHS (TOTAL)</td><td>".$dt."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">K/D (TOTAL)</td><td>".number_format((float)$kdt,3,'.','')."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">MELEE KILLS</td><td>".$content['player']['stats']['overall']['melee_kills']."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">REVIVES</td><td>".$content['player']['stats']['overall']['revives']."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">SUICIDES</td><td>".$content['player']['stats']['overall']['suicides']."</td></tr>";
                  $wt = $content['player']['stats']['casual']['wins'] + $content['player']['stats']['ranked']['wins'];
                  $lt = $content['player']['stats']['casual']['losses'] + $content['player']['stats']['ranked']['losses'];
                  $wlt = $wt / $lt;
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">WON (TOTAL)</td><td>".$wt."</td></tr>";
                echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">LOST (TOTAL)</td><td>".$lt."</td></tr>";
                echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">K/D (TOTAL)</td><td>".number_format((float)$wlt,3,'.','')."</td></tr>";
              echo "</table><br>";
              
              //SEASONS STATS
              $url = $host.$usr."/seasons?platform=".$ptf;
              $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-App-Id:R6API"));
                $result = curl_exec($ch);
              curl_close($ch);
              //decode received json
              $content = json_decode($result,true);
              $i = 0;
              echo "<table class=\"sortable\" align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
              echo "<tr><th style=\"cursor: pointer;\">SEASON</th><th style=\"cursor: pointer;\">POINTS</th><th style=\"cursor: pointer;\">PLACEMENT (/20)</th><th style=\"cursor: pointer;\">PLAYED</th><th style=\"cursor: pointer;\">WINS</th style=\"cursor: pointer;\"><th style=\"cursor: pointer;\">LOSSES</th><th style=\"cursor: pointer;\">W/L</th></tr>";
                foreach($content['seasons'] as $opr){
                  $played = $opr['emea']['wins'] + $opr['emea']['losses'];
                  $wl = $opr['emea']['wins'] / $opr['emea']['losses'];
                  if($i%2 == 0){
                    echo "<tr bgcolor=\"#C3C6CC\"><td align=\"center\">".$opr['emea']['season']."</td><td align=\"center\">".$opr['emea']['ranking']['rating']."</td><td align=\"center\">".$opr['emea']['ranking']['rank']."</td><td align=\"center\">".$played."</td><td align=\"center\">".$opr['emea']['wins']."</td><td align=\"center\">".$opr['emea']['losses']."</td><td align=\"center\">".number_format((float)$wl,3,'.','')."</td></tr>";
                  }
                  else{
                    echo "<tr bgcolor=\"#FFFFFF\"><td align=\"center\">".$opr['emea']['season']."</td><td align=\"center\">".$opr['emea']['ranking']['rating']."</td><td align=\"center\">".$opr['emea']['ranking']['rank']."</td><td align=\"center\">".$played."</td><td align=\"center\">".$opr['emea']['wins']."</td><td align=\"center\">".$opr['emea']['losses']."</td><td align=\"center\">".number_format((float)$wl,3,'.','')."</td></tr>";
                  }
                  $i++;
                }
              echo "</table><br>";
              
              //operators STATS
              $host = "https://api.r6stats.com/api/v1/players/";
              $url = $host.$usr."/operators?platform=".$ptf;
              $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-App-Id:R6API"));
                $result = curl_exec($ch);
              curl_close($ch);
              //decode received json
              $content = json_decode($result,true);
              $i = 0;
              echo "<table class=\"sortable\" align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
              echo "<tr><th>IMAGE</th><th style=\"cursor: pointer;\">NAME</th><th style=\"cursor: pointer;\">PLAYED</th><th style=\"cursor: pointer;\">WINS</th><th style=\"cursor: pointer;\">LOSSES</th><th style=\"cursor: pointer;\">W/L</th style=\"cursor: pointer;\"><th style=\"cursor: pointer;\">KILLS</th><th style=\"cursor: pointer;\">DEATHS</th><th style=\"cursor: pointer;\">K/D</th><th style=\"cursor: pointer;\">PLAYTIME (HH.MM)</th></tr>";
                foreach($content['operator_records'] as $opr){
                  $wl = $opr['stats']['wins']/$opr['stats']['losses'];
                  $kd = $opr['stats']['kills']/$opr['stats']['deaths'];
                  $seconds = $opr['stats']['playtime'];
                  $hours = floor($seconds/3600);
                  $seconds -= $hours * 3600;
                  $minutes = floor($seconds / 60);
                  $seconds -= $minutes * 60;
                  $playtime = "$hours.$minutes";
                  if($i%2 == 0){
                    echo "<tr bgcolor=\"#C3C6CC\"><td><img src=\"".$opr['operator']['images']['badge']."\" style=\"width:50px; height:50px;\"></td><td align=\"center\">".$opr['operator']['name']."</td><td align=\"center\">".$opr['stats']['played']."</td><td align=\"center\">".$opr['stats']['wins']."</td><td align=\"center\">".$opr['stats']['losses']."</td><td align=\"center\">".number_format((float)$wl,3,'.','')."</td><td align=\"center\">".$opr['stats']['kills']."</td><td align=\"center\">".$opr['stats']['deaths']."</td><td align=\"center\">".number_format((float)$kd,3,'.','')."</td><td align=\"center\">".$playtime."</td></tr>";
                  }
                  else{
                    echo "<tr bgcolor=\"#FFFFFF\"><td><img src=\"".$opr['operator']['images']['badge']."\" style=\"width:50px; height:50px;\"></td><td align=\"center\">".$opr['operator']['name']."</td><td align=\"center\">".$opr['stats']['played']."</td><td align=\"center\">".$opr['stats']['wins']."</td><td align=\"center\">".$opr['stats']['losses']."</td><td align=\"center\">".number_format((float)$wl,3,'.','')."</td><td align=\"center\">".$opr['stats']['kills']."</td><td align=\"center\">".$opr['stats']['deaths']."</td><td align=\"center\">".number_format((float)$kd,3,'.','')."</td><td align=\"center\">".$playtime."</td></tr>";
                  }
                  $i++;
                }
              echo "</table><br>";
              
              $i = 0;
              echo "<table align=\"center\" style=\"font-size:110%;\" bgcolor=\"#FFFFFF\">";
              echo "<tr><th>IMAGE</th><th style=\"cursor: pointer;\">NAME</th><th style=\"cursor: pointer;\">DESCRIPTION</th><th style=\"cursor: pointer;\">VALUE</th></tr>";
                foreach($content['operator_records'] as $opr){
                  switch($opr['operator']['name']){
                    case "Valkyrie":{
                        $ability = $opr['stats']['specials']['operatorpvp_valkyrie_camdeployed'];
                        $description = "Cam deployed";}break;
                    case "Dokkaebi":{
                        $ability = $opr['stats']['specials']['operatorpvp_phoneshacked'];
                        $description = "Phone sacked";}break;
                    case "Caveira":{
                        $ability = $opr['stats']['specials']['operatorpvp_caveira_interrogations'];
                        $description = "Interrogations";}break;
                    case "Blackbeard":{
                        $ability = $opr['stats']['specials']['operatorpvp_blackbeard_gunshieldblockdamage'];
                        $description = "GunShield block damage";}break;
                    case "Zofia":{
                        $ability = $opr['stats']['specials']['operatorpvp_concussiongrenade_detonate'];
                        $description = "Grenade detonated";}break;
                    case "Vigil":{
                        $ability = $opr['stats']['specials']['operatorpvp_attackerdrone_diminishedrealitymode'];
                        $description = "Diminished reality mode";}break;
                    case "Fuze":{
                        $ability = $opr['stats']['specials']['operatorpvp_fuze_clusterchargekill'];
                        $description = "Cluster charge kill";}break;
                    case "Hibana":{
                        $ability = $opr['stats']['specials']['operatorpvp_hibana_detonate_projectile'];
                        $description = "Projectile detonated";}break;
                    case "Pulse":{
                        $ability = $opr['stats']['specials']['operatorpvp_pulse_heartbeatspot'];
                        $description = "Heartbeat spot";}break;    
                    case "Jackal":{
                        $ability = $opr['stats']['specials']['operatorpvp_cazador_assist_kill'];
                        $description = "Cazador assist";}break;
                    case "Ela":{
                        $ability = $opr['stats']['specials']['operatorpvp_concussionmine_detonate'];
                        $description = "Concussion mine detonated";}break;
                    case "Ash":{
                        $ability = $opr['stats']['specials']['operatorpvp_ash_bonfirewallbreached'];
                        $description = "Bonfire wall breached";}break;
                    case "Frost":{
                        $ability = $opr['stats']['specials']['operatorpvp_frost_dbno'];
                        $description = "Trap hit";}break;
                    case "Jäger":{
                        $ability = $opr['stats']['specials']['operatorpvp_jager_gadgetdestroybycatcher'];
                        $description = "Gadget destroyed";}break;
                    case "Ying":{
                        $ability = $opr['stats']['specials']['operatorpvp_dazzler_gadget_detonate'];
                        $description = "Dazzler gadget detonated";}break;
                    case "Lesion":{
                        $ability = $opr['stats']['specials']['operatorpvp_caltrop_enemy_affected'];
                        $description = "Caltrop enemy affected";}break;
                    case "Echo":{
                        $ability = $opr['stats']['specials']['operatorpvp_echo_enemy_sonicburst_affected'];
                        $description = "Sonicburst enemy affected";}break;
                    case "Smoke":{
                        $ability = $opr['stats']['specials']['operatorpvp_smoke_poisongaskill'];
                        $description = "Poison gas kill";}break;
                    case "Rook":{
                        $ability = $opr['stats']['specials']['operatorpvp_rook_armortakenourself']+$opr['stats']['specials']['operatorpvp_rook_armortakenteammate'];
                        $description = "Given armor";}break;
                    case "Mira":{
                        $ability = $opr['stats']['specials']['operatorpvp_black_mirror_gadget_deployed'];
                        $description = "Mirror gadget deployed";}break;
                    case "Sledge":{
                        $ability = $opr['stats']['specials']['operatorpvp_sledge_hammerkill'];
                        $description = "Hammer kills";}break;
                    case "Tachanka":{
                        $ability = $opr['stats']['specials']['operatorpvp_tachanka_turretkill'];
                        $description = "Turret kill";}break;
                    case "Mute":{
                        $ability = $opr['stats']['specials']['operatorpvp_mute_gadgetjammed'];
                        $description = "Gadget jammed";}break;
                    case "Kapkan":{
                        $ability = $opr['stats']['specials']['operatorpvp_kapkan_boobytrapkill'];
                        $description = "Booby trap kill";}break;
                    case "Glaz":{
                        $ability = $opr['stats']['specials']['operatorpvp_glaz_sniperkill'];
                        $description = "Sniper kill";}break;
                    case "Buck":{
                        $ability = $opr['stats']['specials']['operatorpvp_buck_kill'];
                        $description = "Buck shotgun kill";}break;
                    case "Blitz":{
                        $ability = $opr['stats']['specials']['operatorpvp_blitz_flashedenemy'];
                        $description = "Flashed enemy (Killed - ".$opr['stats']['specials']['operatorpvp_blitz_flashfollowupkills'].")";}break;
                    case "Capitão":{
                        $ability = $opr['stats']['specials']['operatorpvp_capitao_lethaldartkills'];
                        $description = "Lethal dart kill";}break;
                    case "Bandit":{
                        $ability = $opr['stats']['specials']['operatorpvp_bandit_batterykill'];
                        $description = "Battery kill";}break;
                    case "Twitch":{
                        $ability = $opr['stats']['specials']['operatorpvp_twitch_shockdronekill'];
                        $description = "Shock drone kill";}break;
                    case "Castle":{
                        $ability = $opr['stats']['specials']['operatorpvp_castle_kevlarbarricadedeployed'];
                        $description = "Kevlar barricade deployed";}break;
                    case "Montagne":{
                        $ability = $opr['stats']['specials']['operatorpvp_montagne_shieldblockdamage'];
                        $description = "Bullets stopped";}break;
                    case "Thermite":{
                        $ability = $opr['stats']['specials']['operatorpvp_thermite_chargekill'];
                        $description = "Charge kill";}break;
                    case "IQ":{
                        $ability = $opr['stats']['specials']['operatorpvp_iq_gadgetspotbyef'];
                        $description = "Gadget spotted";}break;
                    case "Doc":{
                        $ability = $opr['stats']['specials']['operatorpvp_doc_selfrevive']+$opr['stats']['specials']['operatorpvp_doc_teammaterevive'];
                        $description = "Revives (self + mates)";}break;
                    case "Thatcher":{
                        $ability = $opr['stats']['specials']['operatorpvp_thatcher_gadgetdestroywithemp'];
                        $description = "Gadget destroyed by EMP";}break;
                  }
                  if($i%2 == 0){
                    echo "<tr bgcolor=\"#C3C6CC\"><td><img src=\"".$opr['operator']['images']['badge']."\" style=\"width:50px; height:50px;\"></td><td align=\"center\">".$opr['operator']['name']."</td><td align=\"center\">".$description."</td><td align=\"center\">".$ability."</td></tr>";
                  }
                  else{
                   echo "<tr bgcolor=\"#FFFFFF\"><td><img src=\"".$opr['operator']['images']['badge']."\" style=\"width:50px; height:50px;\"></td><td align=\"center\">".$opr['operator']['name']."</td><td align=\"center\">".$description."</td><td align=\"center\">".$ability."</td></tr>";
                  }
                  $i++;
                }
              echo "</table><br>";
            }
        ?>
    </body>
</html>
