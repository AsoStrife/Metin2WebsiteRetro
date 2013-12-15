<?php 
include('include/config.php');
if(!isset($_SESSION['id'])) header('Location: index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Modifica la password &bull; <?=$config['site_name'];?></title>
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
					$old_password		= mysql_real_escape_string($_POST['old-password']);
					$new_password		= mysql_real_escape_string($_POST['new-password']);
					$confirm_password	= mysql_real_escape_string($_POST['confirm-password']);
					$username 			= $_SESSION['login'];
					$id 				= $_SESSION['id'];	
					
					$error = array();
					
					if($_SESSION['password_no_cript'] != $old_password)
					{
						$error[0] = 'La vecchia password &egrave; sbagliata, riprova.';
					}
					
					if(strlen($new_password)< 5)
					{
						$error[1] = 'La nuova password deve essere di almeno 5 caratteri!';
					}
					
					elseif(strlen($new_password)>9)
					{
						$error[1 ]= 'La nuova password deve essere di massimo 9 caratteri!';
					}
					
					elseif($new_password == $_SESSION['login'])
					{
						$error[1] = 'La password non può essere uguale all\'username.';
					}
					
					if($new_password != $confirm_password)
					{
						$error[2] = 'Le due password non coincidono, riprova';
					}
					
					if(count($error) == 0)
					{
						$sql = "UPDATE account SET password = password('$new_password') WHERE login = '$username' and id = $id ";
						
						if($ris = mysql_query($sql))
						{
							
							echo'<div class="alert alert-success">Password modificata con successo.</div>';
							$_SESSION['password_no_cript'] = $new_password;
							
							$sql_2 = "SELECT password FROM account WHERE login = '$username' and id = $id ";
							
							if($ris_2 = mysql_query($sql_2))
							{
								$array = mysql_fetch_array($ris_2);
								$_SESSION['password_cript']	= $array['password'];
							}
							else 
							{
								echo '<div class="alert alert-error">Non è possibile completare il salvataggio della modifica per problemi interni al sito web.</div>';
							}
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
        	
			<form class="form-horizontal" action='edit-password.php' method='POST'>           
                <fieldset>
                <legend>Modifica password</legend>
                
                <div class="control-group <? if(isset($error[0])) echo 'error';?>">
                    <label class="control-label" for="input01">Vecchia password</label>
                        <div class="controls">
                            <input type="password" class="input-xlarge" name="old-password"  maxlength="9">
                        </div>
                </div>
                
                <div class="control-group <? if(isset($error[1])) echo 'error';?>">
                    <label class="control-label" for="input01">Nuova password</label>
                        <div class="controls">
                            <input type="password" class="input-xlarge" name="new-password" maxlength="9">
                        </div>
                </div>
                
                <div class="control-group <? if(isset($error[2])) echo 'error';?>">
                    <label class="control-label" for="input01">Conferma password</label>
                        <div class="controls">
                            <input type="password" class="input-xlarge" name="confirm-password" maxlength="9">
                        </div>
                </div>
                
				<div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="edit-go"><i class="icon-ok icon-white"></i> Cambia password!</button>
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