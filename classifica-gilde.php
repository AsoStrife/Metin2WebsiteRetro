<?php include('include/config.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Classifica gilde &bull; <?=$config['site_name'];?></title>
	<? include('include/meta-tags.php');?>
</head>
<body>

<div class="container">
	<div class="row">
    	<div class="span3">
            <? include('include/menu.php');?>
        </div>
  		
        <div class="span9">
        	<legend>La classifica gilde di <?=$config['site_name'];?></legend>
            
				<?php 
				if(!isset($_GET['page'])) header('Location: classifica-gilde.php?page=1');			
                
				mysql_select_db("player");
                
                 
                $sql 				= "SELECT * FROM guild ORDER BY ladder_point desc, exp desc LIMIT ". (($_GET['page']*10)-10) .',10';
				$sql_to_count 		= "SELECT * FROM guild ORDER BY ladder_point desc, exp desc";
				
				$ris_count 			= mysql_query($sql_to_count); 
                $count_page 		= mysql_num_rows($ris_count);
				
				$page 				= ceil($count_page/10);
				
				if($_GET['page'] > $page) header('Location: classifica-gilde.php?page=1');
				
                if($_GET['page'] == 1)$countguild = 1; else $countguild = (($_GET['page']*10)-9);
                 
                $ris = mysql_query($sql, $conn);
                if($ris)
				{
					if(mysql_num_rows($ris) <1) echo '<div class="alert alert-info">Al momento non sono presenti gilde all\'interno del nostro server.</div>';
					
					else
					
				   	echo'	<table class="table table-striped">
								<thead>
									<tr>
										<th>Posizione</th>
										<th>Nome</th>
										<th>Livello</th>
										<th>Punti</th>
										<th>Vittorie</th>
										<th>Pareggi</th>
										<th>Sconfitte</th>
										<th>Capo</th>
										<th>Regno</th>
									</tr>
								</thead> 
								
								<tbody>'; 
            
            

					while($array = mysql_fetch_array($ris))
					{
						$idcapo = $array['master'];
					
					 
						$sql_capo 	= mysql_query("SELECT name from player where id = '$idcapo'");
						$array_boss	= mysql_fetch_array($sql_capo);
						
						$sql_regno 	= mysql_query("SELECT empire from player_index where pid1 = '$idcapo' OR pid2 = '$idcapo' OR pid3 = '$idcapo' OR pid4 = '$idcapo'");
						$regno 		= mysql_fetch_array($sql_regno);
						
						$empire 	= $regno['empire'];
						
						if($empire == 1 ) $array['empire'] = '<img src="img/shinsoo.jpg" title="Shinsoo" alt="Shinsoo" />';
		
						if($empire == 2 ) $array['empire'] = '<img src="img/chunjo.jpg" title="Chunjo" alt="Chunjo" />';
		
						if($empire == 3 ) $array['empire'] = '<img src="img/Jinno.jpg" title="Jinno" alt="Jinno" />';
						
						echo '<tr>';
						echo '<td>'.$countguild.'</td>';
						echo '<td>'.$array['name'].'</td>';
						echo '<td>'.$array['level'].'</td>';
						echo '<td>'.$array['ladder_point'].'</td>';
						echo '<td>'.$array['win'].'</td>';
						echo '<td>'.$array['draw'].'</td>';
						echo '<td>'.$array['loss'].'</td>';
						echo '<td>'.$array_boss['name'].'</td>';
						echo '<td>'.$array['empire'].'</td>';
						echo '</tr>';
						$countguild++;
						
					}
				}
                ?>   
				</tbody>
            </table> 
            
            	<?
				if($page > 1)
				{
					echo '<div class="pager">';
					echo '<ul>';
					
					if($_GET['page'] != 1) echo '<li class="previous">  <a href="classifica-gilde.php?page='.($_GET['page']-1) .'">&larr; I precedenti 10 classificati</a></li> ';
												
					if($_GET['page'] != $page)echo'<li class="next"><a href="classifica-gilde.php?page=' .($_GET['page']+1) .'">I prossimi 10 classificati  &rarr;</a></li> ';	 
 
					echo '</ul>';
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