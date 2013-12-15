<?php include('include/config.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Classifica player &bull; <?=$config['site_name'];?></title>
    <? include('include/meta-tags.php');?>
</head>
<body>

<div class="container">
	<div class="row">
    	<div class="span3">
            <? include('include/menu.php');?>
        </div>
  		
        <div class="span9">
       		<legend>La classifica player di <?=$config['site_name'];?></legend>
				<?
					if(!isset($_GET['page'])) header('Location: classifica-player.php?page=1');

					mysql_select_db('player', $conn);
					   
					
                    $sql = "SELECT player.id, player.name, player.level, player.exp, player.skill_group, player.playtime, player.gold, player_index.id, player_index.pid1, player_index.pid2, player_index.pid3, player_index.pid4, player_index.empire
                            FROM player, player_index
                            WHERE player.name NOT LIKE '[GM]%' and player.name NOT LIKE '[GA]%' and player.id = player_index.pid1 or player.id = player_index.pid2 or player.id = player_index.pid3 or player.id = player_index.pid4
							ORDER BY player.level desc, player.exp desc
							LIMIT ". (($_GET['page']*10)-10) .',10';
                    
					
                    if($ris = mysql_query($sql))
                    {
						if(mysql_num_rows($ris) <1) echo '<div class="alert alert-info">Al momento non sono presenti giocatori all\'interno del nostro server.</div>';
					
						else
                        $sql_to_count = "SELECT player.id
                           		FROM player, player_index
                            	WHERE player.name NOT LIKE '[GM]%' and player.name NOT LIKE '[GA]%' and player.id = player_index.pid1 or player.id = player_index.pid2 or player.id = player_index.pid3 or player.id = player_index.pid4";
								
                        $ris_count 	= mysql_query($sql_to_count); 
                        $count_page = mysql_num_rows($ris_count);
					   	$page = ceil($count_page/10);
						
						if($_GET['page'] > $page) header('Location: classifica-gilde.php?page=1');
						if($_GET['page'] == 1)$countpg = 1; else $countpg = (($_GET['page']*10)-9);
						
						echo '	<table class="table table-striped">
									<thead>
										<tr>
											<th>Posizione</th>
											<th>Nome personaggio</th>
											<th>Livello</th>
											<th>Esperienza</th>
											<th>Regno</th>
											<th>Tempo di gioco</th>
											<th>Soldi</th>
										</tr>
									</thead> 
								
									<tbody>';
						
						while($array = mysql_fetch_array($ris))
                        {			
							
							if($array['empire'] == 1 ) $array['empire'] = '<img src="img/shinsoo.jpg" title="Shinsoo" alt="Shinsoo" />';

							if($array['empire'] == 2 ) $array['empire'] = '<img src="img/chunjo.jpg" title="Chunjo" alt="Chunjo" />';

							if($array['empire'] == 3 ) $array['empire'] = '<img src="img/Jinno.jpg" title="Jinno" alt="Jinno" />';

							echo '<tr>';
							echo '<td>'.$countpg.'</td>';
							echo '<td>'.$array['name'].'</td>';
							echo '<td>'.$array['level'].'</td>';
							echo '<td>'.$array['exp'].'</td>';
							echo '<td>'.$array['empire'].'</td>';
							echo '<td>'.$array['playtime'].'</td>';
							echo '<td>'.$array['gold'].'</td>';
							echo '</tr>';
							$countpg++;
                        }
						
                    }
                    else
                    {
                        echo '<div class="alert alert-error">Sono presenti errori all\'interno del server, riprova più tardi.</div>';	
                    }
                ?>
                
                
                    
                </tbody>
            </table>   
            
			<?
				if($page > 1)
				{
					echo '<div class="pager">';
					echo '<ul>';
					
					if($_GET['page'] != 1) echo '<li class="previous">  <a href="classifica-player.php?page='.($_GET['page']-1) .'">&larr; I precedenti 10 classificati</a></li> ';
												
					if($_GET['page'] != $page)echo'<li class="next"><a href="classifica-player.php?page=' .($_GET['page']+1) .'">I prossimi 10 classificati  &rarr;</a></li> ';	 
					
					echo '</div>';
				}
			?>   
         
		</div>
    </div>
    
    <div class="row">
    	<div class="span12" style="margin-top:20px; text-align:center;">
        	<p><?=base64_decode($config['activaction_key']);?></p>
        </div>
    </div>
    
</div>    

</body>
</html>