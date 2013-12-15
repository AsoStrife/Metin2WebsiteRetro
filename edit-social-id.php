<?php 
include('include/config.php');
if(!isset($_SESSION['id'])) header('Location: index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Modifica il codice cancella personaggio &bull; <?=$config['site_name'];?></title>
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
				if(isset($_POST['edit-go']))
				{
					mysql_select_db('account', $conn);
					$socialid			= mysql_real_escape_string($_POST['socialid']);
					$username 			= $_SESSION['login'];
					$id 				= $_SESSION['id'];	
					
					$error = array();
					
					if(strlen($socialid)!=7)
					{
						$error[0] = 'Il codice per cancellare il personaggio deve essere lungo 7 caratteri.';
					}
					
					if($socialid == 1234567)
					{
						$error[1] = 'Non puoi utilizzare come codice per cancellare il personaggio 1234567 perché non &egrave; sicuro, scegline un altro.';
					}
					elseif($socialid == '0000000')
					{
						$error[1] = 'Non puoi utilizzare come codice per cancellare il personaggio 0000000 perché non &egrave; sicuro, scegline un altro.';
					}	
									
					if(count($error) == 0)
					{
						$sql = "UPDATE account SET social_id = '$socialid' WHERE login = '$username' and id = $id ";
						
						if($ris = mysql_query($sql))
						{
							
							echo'<div class="alert alert-success">Codice elimina personaggio modificato con successo.</div>';
							
							$_SESSION['social_id'] = $socialid;
							
						}
						else
						{
							echo '<div class="alert alert-error">Non è possibile effettuare la modifica per problemi interni al sito web.</div>';
						}
					}
					else
					{
						echo '<div class="alert alert-error">';
		
						foreach($error as $value) : echo '<p>'.$value .'</p>'; endforeach;
		
						echo '</div>';
					}
				}
			?>
        	
			<form class="form-horizontal" action='edit-social-id.php' method='POST'>           
                <fieldset>
                <legend>Codice cancella personaggio</legend>
                
                <div class="control-group <? if(isset($error[0])) echo 'error';?>">
                    <label class="control-label" for="input01">Codice elimina personaggio</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="socialid"  maxlength="7" value="<?=$_SESSION['social_id'];?>">
                        </div>
                </div>
                
				<div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="edit-go"><i class="icon-ok icon-white"></i> Cambia </button>
                    <button type="reset" class="btn"><i class="icon-remove"></i> Cancella</button>
                </div>
                                
              </fieldset>
            </form>
       
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