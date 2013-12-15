<?php 
include('include/config.php');
if(isset($_SESSION['id'])) header('Location: index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Rinvio email registrazione &bull; <?=$config['site_name'];?></title>
    <? include('include/meta-tags.php');?>
</head>
<body>

<div class="container">
	<div class="row">
    	<div class="span3">
        	<? include('include/menu.php');?>
        </div>
  		
        <div class="span9">
        <?
			include('include/validate-email.php');
			
			mysql_select_db('account', $conn);
			
			if(isset($_POST['send-mail-go']))
			{
				$email	= mysql_real_escape_string($_POST['email']);
				
				if(validatemail($email) == TRUE)
				{
				
					$search = "SELECT login, real_name, status FROM account WHERE email = '$email' and status != 'OK'";
					if($ris_1 = mysql_query($search, $conn))
					{
						$count 	= mysql_num_rows($ris_1);
						$array	= mysql_fetch_array($ris_1);
						$name	= $array['real_name'];
						$user 	= $array['login'];
						if($count == 1)
						{
							$header 	= 	"To:". $name ."<".$email.">\n";
							$header 	.= 	"From: ".$config['site_name'] ."<".$config['email_site'].">\n";
							$header 	.=  "MIME-Version: 1.0\n";
							$header 	.=  "Content-Type: text/html; charset=\"utf-8\" \n";
							$header 	.=  "Content-Transfer-Encoding: 7bit\n\n";
							$oggetto 	= 	"Conferma registrazione su " .$config['site_name'];
							$messaggio 	= 	'<html><body> 
											<p>Benvenuto '.$name .'su '.$config['site_name'].'</p>
											<p>Per confermare il tuo account clicca sul seguente link : <a href="'.$config['base_url'].'confirm-account.php?login='.base64_encode($user).'" >Conferma account </a></p>
											</body></html>';
						
				
							if(mail("$email",$oggetto,$messaggio,$header))
							{
								echo '<div class="alert alert-success">Email di conferma inviata !</div>';
							}
							else
							{
								echo '<div class="alert alert-error">Non &egrave; stato possibile inviare l\'email per problemi interni del sito. </div>';	
							}
						}
						else
						{
							echo '<div class="alert alert-block">Il tuo account non risulta da confermare. Se l\'email che hai inserito &egrave; giusta il tuo account &egrave; gi&agrave; attivo.</div>';
						}
					}
					else
					{
						echo '<div class="alert alert-error">Impossibile inviare l\'email per problemi all\'interno del sito. Error n[01]</div>';
					}
				}
				else
				{
					echo '<div class="alert alert-error">L\'email che hai inserito non &egrave; valida, ricontrolla.</div>';
				}
			}
		?>
            <form class="form-horizontal" action='new-mail.php' method='POST'>
            
              <fieldset>
                <legend>Rinvio dell'email di conferma account <?=$config['site_name'];?></legend>
                                
                <div class="control-group">
                <label class="control-label" for="input01">La tua email</label>
                    <div class="controls">
                    	<input class="input-large"  type="text" maxlength="50" name="email" value="<? if(isset($email)) echo $email;?>">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="send-mail-go"><i class="icon-ok icon-white"></i> Invia!</button>
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