<?php 
include('include/config.php');
if(isset($_SESSION['id'])) header('Location: index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Effettua il login &bull; <?=$config['site_name'];?></title>
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
				if(isset($_POST['login-go']))
				{
					mysql_select_db('account', $conn);
					$user		= mysql_real_escape_string($_POST['username']);
					$password	= mysql_real_escape_string($_POST['password']);
					$sql = "SELECT * FROM account WHERE login = '$user' and password = PASSWORD('$password')";
					
					if($ris = mysql_query($sql))
					{
						if(mysql_num_rows($ris) == 1)
						{
							$array = mysql_fetch_array($ris);
							
							$_SESSION['id'] 				= $array['id'];
							$_SESSION['password_no_cript']	= $password;
							$_SESSION['password_cript']		= $array['password'];
							$_SESSION['login'] 				= $array['login'];
							$_SESSION['real_name'] 			= $array['real_name'];
							$_SESSION['social_id'] 			= $array['social_id'];
							$_SESSION['email'] 				= $array['email'];
							$_SESSION['cash'] 				= $array['cash'];
							
							
							echo'<div class="alert alert-success">Login effettuato con successo, attendi mentre vieni reindirizzato alla home.</div>';
							echo '<meta http-equiv="refresh" content="3;url=index.php" />';
						}
						else
						{
							echo '<div class="alert alert-error">Non hai inserito dati corretti, riprova.</div>';
						}
					}
					else
					{
						echo '<div class="alert alert-error">Non &egrave; stato possibile effettuare l\'accesso per problemi interni al server. Riprova pi&ugrave; tardi. </div>';	
					}
				}
			?>
        	
			<form class="form-horizontal" action='login.php' method='POST'>           
                <fieldset>
                <legend>Effettua il login</legend>
                
                <div class="control-group">
                    <label class="control-label" for="input01">Username</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="username"  maxlength="9" value="<? if(isset($user)) echo $user;?>">
                        </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="input01">Password</label>
                        <div class="controls">
                            <input type="password" class="input-xlarge" name="password" maxlength="9">
                        </div>
                </div>
                
                <div class="control-group">
                	<div class="controls">
                		<p><a href="forgot-password.php" title="Password dimenticata ?">Password dimenticata ? </a></p>
                   	</div>
                </div>
                
				<div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="login-go"><i class="icon-ok icon-white"></i> Login!</button>
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