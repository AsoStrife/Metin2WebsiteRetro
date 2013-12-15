<?php 
include('include/config.php');
if(!isset($_SESSION['id'])) header('Location: index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Riepilogo dei tuoi dati &bull; <?=$config['site_name'];?></title>
    <? include('include/meta-tags.php');?>
</head>
<body>

<div class="container">
	<div class="row">
    	<div class="span3">
            <? include('include/menu.php');?>
        </div>
  		
        <div class="span9">            
                        
        	<?php				
				
				mysql_select_db('player', $conn);
				
				$sql_player = "SELECT player.id, player.account_id, player.name, player.level, player.exp, player.skill_group, player.playtime, player.gold, player.job
                            	FROM player
                            	WHERE account_id = " .$_SESSION['id']; 
								
				if(!$ris_player = mysql_query($sql_player)) 
				{
					echo '<div class="alert alert-error">Errore recupero dati relativi ai tuoi personaggi[1].</div>';
				}
				
				$sql_player_index = "SELECT empire FROM player_index WHERE id = " .$_SESSION['id']; 
								
				if(!$ris_player_index = mysql_query($sql_player_index)) 
				{
					echo '<div class="alert alert-error">Errore recupero dati relativi ai tuoi personaggi[2].</div>';
				}
				
				$sql_safebox = "SELECT password FROM safebox WHERE account_id = " .$_SESSION['id'];
				if(!$ris_safebox = mysql_query($sql_safebox)) 
				{
					echo '<div class="alert alert-error">Errore recupero dati relativi ai tuoi personaggi[4].</div>';
				}	
				
				if(isset($_POST['delete-account']))
				{
					$delete_player 			= 'DELETE FROM player WHERE account_id = ' .$_SESSION['id'];
					$delete_player_index 	= 'DELETE FROM player_index WHERE id = ' .$_SESSION['id'];
					$delete_safebox 		= 'DELETE FROM safebox WHERE account_id = ' .$_SESSION['id'];
					$delete_account 		= 'DELETE FROM account WHERE id = ' .$_SESSION['id'];	
					
					mysql_select_db('player', $conn);
					
					if($ris_player = mysql_query($delete_player, $conn))
					{
						if($ris_player_index = mysql_query($delete_player_index, $conn))
						{
							if($ris_safebox = mysql_query($delete_safebox, $conn))
							{
								mysql_select_db('account', $conn);
								if($ris_safebox = mysql_query($delete_account, $conn))
								{
									echo '<div class="alert alert-success">Account eliminato con successo. Verrai reindirizzato alla home.</div>';
									session_destroy(); 
									echo '<meta http-equiv="refresh" content="3;url=index.php" />';
								}
								else
								{
									echo '<div class="alert alert-error">Impossibile cancellare l\'account, riprova più tardi. Se il problema persiste contattare l\'amministrazione.</div>';
								}
								
							}
							else
							{
								echo '<div class="alert alert-error">Impossibile cancellare il magazzino, riprova più tardi. Se il problema persiste contattare l\'amministrazione.</div>';
							}
						}
						else
						{
							echo '<div class="alert alert-error">Impossibile cancellare l\'indice dei giocatori, riprova più tardi. Se il problema persiste contattare l\'amministrazione.</div>';
						}
					}
					else
					{
						echo '<div class="alert alert-error">Impossibile cancellare i giocatori, riprova più tardi. Se il problema persiste contattare l\'amministrazione.</div>';
					}
				}
			?>
            
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#account" data-toggle="tab">Account</a></li>
                    <li><a href="#player" data-toggle="tab">Player</a></li>
                    <li><a href="#operazioni" data-toggle="tab">Operazioni</a></li>
                </ul>
                
                <div class="tab-content">
                   
                    <div class="tab-pane active" id="account">
                    	<legend>Il tuo account</legend>
                        
                        <table class="table table-striped">
                        
                            <tbody>
                                <tr>
                                    <td>Nome utente </td>
                                    <td><?=$_SESSION['login'];?></td>
                                </tr>
                                
                                <tr>
                                    <td>Nome reale </td>
                                    <td><?=$_SESSION['real_name'];?></td>
                                </tr>
                                
                                <tr>
                                    <td>Email </td>
                                    <td><?=$_SESSION['email'];?></td>
                                </tr>
                                
                                <tr>
                                    <td>Codice elimina personaggio </td>
                                    <td><?=$_SESSION['social_id'];?></td>
                                </tr>
                                
                                <tr>
                                    <td>Monete del drago </td>
                                    <td><?=$_SESSION['cash'];?></td>
                                </tr>
                                                                  
                            </tbody>
                        
                        </table>
						
						

                    </div>
                    
                    <div class="tab-pane" id="player">
                    	<legend>Il tuoi personaggi</legend>
                        <table class="table">
                        	<tr> 
                            	<td><h6>Regno di appartenenza</h6></td>
                                
                                <td>
									<? 
										$array_player_index = mysql_fetch_array($ris_player_index);			
										if($array_player_index['empire'] == 1 ) $array_player_index['empire'] = '<img src="img/shinsoo.jpg" title="Shinsoo" alt="Shinsoo" />';
			
										if($array_player_index['empire'] == 2 ) $array_player_index['empire'] = '<img src="img/chunjo.jpg" title="Chunjo" alt="Chunjo" />';
			
										if($array_player_index['empire'] == 3 ) $array_player_index['empire'] = '<img src="img/Jinno.jpg" title="Jinno" alt="Jinno" />';
										
										echo $array_player_index['empire'];
                                    ?>
								</td>
                            </tr>
                            
                            <tr> 
                            	<td><h6>Password magazzino</h6></td>
                                
                                <td>
									<? 
                                    	$array_safebox = mysql_fetch_array($ris_safebox);			
                                    	if($array_safebox[0] == NULL) 
										{
											echo '0000000'; 
										}
										else
										{
											echo $array_safebox[0];
										}
										

                                    ?>
								</td>
                            </tr>
                            
						</table>                        
                        
								<? while($array_player 	= mysql_fetch_array($ris_player)):
									if ( $array_player['job'] == 0 and $array_player['skill_group'] == 1 )  $array_player['description'] = "Guerriero Corporale (M)"; 
									elseif ( $array_player['job'] == 0 and $array_player['skill_group'] == 2 )  $array_player['description'] = "Guerriero Mentale (M)"; 
									elseif ( $array_player['job'] == 1 and $array_player['skill_group'] == 1 )  $array_player['description'] = "Ninja Corpo a Corpo (F)"; 
									elseif ( $array_player['job'] == 1 and $array_player['skill_group'] == 2 )  $array_player['description'] = "Ninja Arco (F)"; 
									elseif ( $array_player['job'] == 2 and $array_player['skill_group'] == 1 )  $array_player['description'] = "Sura Magia Nera (M)"; 
									elseif ( $array_player['job'] == 2 and $array_player['skill_group'] == 2 )  $array_player['description'] = "Sura Armi Magiche (M)"; 
									elseif ( $array_player['job'] == 3 and $array_player['skill_group'] == 1 )  $array_player['description'] = "Shamana Cura (F)"; 
									elseif ( $array_player['job'] == 3 and $array_player['skill_group'] == 2 )  $array_player['description'] = "Shamana Drago (F)"; 
									elseif ( $array_player['job'] == 4 and $array_player['skill_group'] == 1 )  $array_player['description'] = "Guerriera Corporale (F)"; 
									elseif ( $array_player['job'] == 4 and $array_player['skill_group'] == 2 )  $array_player['description'] = "Guerriera Mentale (F)"; 
									elseif ( $array_player['job'] == 5 and $array_player['skill_group'] == 1 )  $array_player['description'] = "Ninja Corpo a Corpo (M)"; 
									elseif ( $array_player['job'] == 5 and $array_player['skill_group'] == 2 )  $array_player['description'] = "Ninja Arco (M)"; 
									elseif ( $array_player['job'] == 6 and $array_player['skill_group'] == 1 )  $array_player['description'] = "Sura Magia Nera (F)"; 
									elseif ( $array_player['job'] == 6 and $array_player['skill_group'] == 2 )  $array_player['description'] = "Sura Armi Magiche (F)"; 
									elseif ( $array_player['job'] == 7 and $array_player['skill_group'] == 1 )  $array_player['description'] = "Shamano Cura (M)"; 
									elseif ( $array_player['job'] == 7 and $array_player['skill_group'] == 2 )  $array_player['description'] = "Shamano Drago (M)";
									else $array_player['description'] = "Non &egrave; stato ancora scelto il percorso delle abilità."; 
								?>  
                                	
							<table class="table table-bordered">
                            	<tbody>  
                                    
								    <tr>
                                        <td>Nome giocatore </td>
                                        <td><?=$array_player['name'];?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Livello </td>
                                        <td><?=$array_player['level'];?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Esperienza </td>
                                        <td><?=$array_player['exp'];?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Minuti di gioco </td>
                                        <td><?=$array_player['playtime'];?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Soldi </td>
                                        <td><?=$array_player['gold'];?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Tipo di personaggio </td>
                                        <td><?=$array_player['description'];?></td>
                                    </tr>
                                     
                            </tbody>
                        
                        </table>
                                <? endwhile;?>

                        
                    </div>
                    
                    <div class="tab-pane" id="operazioni">
                   		<legend>Elimina il tuo account</legend>
                        
                        
                        <div class="alert">
                        	<p>Proseguendo con quest'operazione cancellerai il tuo account, i personaggi ad esso associati e tutti i tuoi oggetti in modo permanente.</p>
                        </div>
                        
                        <div id="myModal" class="modal hide fade" style="display: none; ">
                        
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Cancella personaggio</h3>
                            </div>
                            
                            <div class="modal-body">
                            	<p>Sei sicuro di voler eliminare definitivamente il tuo account e tutti i dati ad esso associati tra cui:
                                	<ul>
                                    	<li>Monete del drago</li>
                                        <li>Personaggi associati all'account</li>
                                        <li>Oggetti assocciati ad ogni singolo personaggio</li>
                                        <li>Magazzino associato all'account</li>
                                        <li>Il nickname dei personaggi</li>
                                    </ul>
                                </p>
                                
                            </div>
                            
                            <div class="modal-footer">
                            
                            <form method="POST" action="summary.php">
                            	<button type="submit" name="delete-account" class="btn btn-success"><i class="icon-ok icon-white"></i> Cancella account</button>
                                <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-remove icon-white"></i> Chiudi</a>
                            </form>
                            
                            
                            </div>
                            
						</div> 
                        
						<a data-toggle="modal" href="#myModal" class="btn btn-inverse btn-large" style="width:94%"><i class="icon-share-alt icon-white"></i> Prosegui</a>

                    </div>
                    
                </div>
            </div>
            
       
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