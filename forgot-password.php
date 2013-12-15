<?php 
include('include/config.php');
if(isset($_SESSION['id'])) header('Location: index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Recupera password &bull; <?=$config['site_name'];?></title>
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
			mysql_select_db('account', $conn);
			
			include('include/validate-email.php');
			
			if(isset($_POST['send-mail-go']))
			{
				$email	= mysql_real_escape_string($_POST['email']);
				
				if(validatemail($email) == TRUE)
				{
				
					$search = "SELECT login, real_name FROM account WHERE email = '$email' and status = 'OK'";
					
					if($ris_1 = mysql_query($search, $conn))
					{
						$count_ris 	= mysql_num_rows($ris_1);
						
						if($count_ris == 1)
						{
							$array		= mysql_fetch_array($ris_1);
							$name		= $array['real_name'];
							$user 		= $array['login'];
							
							$string 		= 'qwertyuiopasdfghjklzxcvbnm1234567890';	//36
							$string_random 	= '';
							
							for($i = 1; $i <=6; $i++)
							{
								$string_random.= $string[rand(1,36)];
							}
							
							$sql = "UPDATE account SET password = password('$string_random') WHERE login = '$user'";
							
							if($ris = mysql_query($sql))
							{
							
								$header 	= 	"To:". $name ."<".$email.">\n";
								$header 	.= 	"From: ".$config['site_name'] ."<".$config['email_site'].">\n";
								$header 	.=  "MIME-Version: 1.0\n";
								$header 	.=  "Content-Type: text/html; charset=\"utf-8\" \n";
								$header 	.=  "Content-Transfer-Encoding: 7bit\n\n";
								$oggetto 	= 	"Conferma registrazione su " .$config['site_name'];
								$messaggio 	= 	'<html><body> 
												<p>'.$name .'<p>La tua nuova password &egrave; : .' .$string_random .'</p>
												</body></html>';
							
					
								if(mail("$email",$oggetto,$messaggio,$header))
								{
									echo '<div class="alert alert-success">La tua password &egrave; stata reimpostata, riceverai un email per conoscere la tua nuova password !</div>';
									echo $string_random;
								}
								else
								{
									echo '<div class="alert alert-error">Non &egrave; stato possibile inviare l\'email per problemi interni del sito. Error n[02] </div>';	
								}
							}
							
							
						}

						else
						{
							echo '<div class="alert alert-error">L\'email inserita non è presente nel nostro database </div>';
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
            <form class="form-horizontal" action='forgot-password.php' method='POST'>
            
              <fieldset>
                <legend>Recupera la password smarrita <?=$config['site_name'];?></legend>
                                
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