<?php

mysql_select_db("account");

$sql_account = mysql_query("SELECT * FROM account");
$count_account = mysql_num_rows($sql_account);

mysql_select_db("player");

$sql_player = mysql_query ("SELECT * FROM player");
$count_player = mysql_num_rows($sql_player);

$sql_gilde = mysql_query ("SELECT * FROM guild");
$count_gilde = mysql_num_rows($sql_gilde);
                     
                     
   
$sql_top_player 	= "SELECT name FROM player WHERE player.level = (SELECT MAX(level) FROM player WHERE player.name NOT LIKE '[GM]%' AND player.name NOT LIKE '[GA]%')";
$query_top_player 	= mysql_query($sql_top_player);
$array_player = mysql_fetch_array($query_top_player);



                                         
$sql_top_gilda= "SELECT MAX(level), name FROM guild ";
$query_top_gilda = mysql_query($sql_top_gilda);
$array_gilda = mysql_fetch_array($query_top_gilda);
       
                               
  
$sql_top_yang= "SELECT name FROM player WHERE player.gold = (SELECT MAX(gold) FROM player WHERE player.name NOT LIKE '[GM]%' AND player.name NOT LIKE '[GA]%')";
$query_top_yang = mysql_query($sql_top_yang);
$array_yang = mysql_fetch_array($query_top_yang);
      
echo '<table class="table table-striped"> <tbody>'; 
echo '<tr><td>Account Totali: </td> <td>'.$count_account.'</td></tr>';
echo '<tr><td>Personaggi Totali: </td> <td>'.$count_player.'</td></tr>';
echo '<tr><td>Top 1 PG: </td> <td>'.$array_player['name'] .'</td></tr>';
echo '<tr><td>Gilde Totali: </td> <td>'. $count_gilde .'</td></tr>';
echo '<tr><td>Top 1 Gilda: </td> <td>'.$array_gilda['name'] .'</td></tr>'; 
echo '<tr><td>Top 1 Yang: </td> <td>'. $array_yang['name'] .'</td></tr>'; 
echo '</tbody></table>';                                  
?>