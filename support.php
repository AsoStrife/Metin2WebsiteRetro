<?php include('include/config.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Supporto &bull; <?=$config['site_name'];?></title>
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
			include('include/validate-email.php');
			
			if(isset($_POST['signup-go']))
			{
						
				$name					= mysql_real_escape_string($_POST['name']);
				$messaggio				= mysql_real_escape_string($_POST['messaggio']);
				$email					= mysql_real_escape_string($_POST['email']);
				
				$error			= array();
				
				
				if(strlen($name) < 2)
				{
					$error[0]= 'Il nome deve essere di almeno 2 caratteri!';
				}
				
				elseif(strlen($name)>16)
				{
					$error[0] = 'Il nome deve essere di massimo 16 caratteri!';
				}
				
				
				if(!validatemail($email))
				{
					$error[1] = 'Inserisci una email valida.';
				}	
					
				elseif(strlen($email)>50)
				{
					$error[1] = 'L\'email deve essere lunga massimo 50 caratteri.';
				}
				
				if(trim($_FILES['file']['name']) != '')
				{
					$upload_error 	= $_FILES["file"]["error"];
					$allowed_types 	= array("image/gif","image/x-png","image/pjpeg","image/jpeg");

					
					if($_FILES['file']['size'] > $config['max_file_size'])
					{
						$error[2] = 'Il file che stai inviando &egrave; troppo grande.';	
					}
										
					if(!in_array($_FILES["file"]["type"],$allowed_types)) 
					{
						$error[3] = 'Il file che hai inviato non &egrave; un file immagine accettato. Accettiamo solo file jpg, jpeg, png o bmp.';
					}
					
					$string 		= 'qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPLKJHGFDSAMNBVCXZ';	//61
					$string_random 	= '';
					
					
					for($i = 1; $i <=40; $i++)
					{
						$string_random.= $string[rand(1,61)];
					}
					$explode 		= explode(".", $_FILES['file']['name']);
					$new_filename	= $string_random.'.'.$explode[1];
	
				}
				if(trim($messaggio) == '')
				{
					$error[4] = 'Non &egrave; possibile inviare una richiesta di supporto senza inserire un messaggio.';
				}
				
				if(count($error) == 0)
				{
					@move_uploaded_file($_FILES["file"]["tmp_name"], $config['upload_folder'].'/'.$new_filename);
					
					$header 	= 	"To:". $config['site_name'] ."<".$config['email_site'].">\n";
					$header 	.= 	"From: $name <$email>\n";
					$header 	.=  "MIME-Version: 1.0\n";
					$header 	.=  "Content-Type: text/html; charset=\"utf-8\" \n";
					$header 	.=  "Content-Transfer-Encoding: 7bit\n\n";
					$oggetto 	= 	"Richiesta supporto da" .$name;
					$text 		= 	'<html><body><p>' .$messaggio  .'</p>';
					if(trim($_FILES['file']['name']) != '') $text .= '<p> <a href="'.$config['base_url'].$config['upload_folder'].'/'.$new_filename.'" >Link immagine</a> </p>';
					$text		.= 	'</body></html>';
					
					if(mail("$email",$oggetto,$text,$header))
					{
						echo '<div class="alert alert-success">Richiesta di supporto inviata correttamente, riceverai risposta entro qualche giorno.</div>';
					}
					else
					{
						echo '<div class="alert alert-error">Richiesta di supporto non inviata per problemi interni al server mail. Riprova più tardi. </div>';	
					}
					
				}
				else
				{
					echo '<div class="alert alert-error">';
					
					foreach($error as $value) : echo '<p>'.$value .'</p>'; endforeach;
					
					if(trim($_FILES['file']['name']) != '')
					{
						if(count($upload_error) != 0) :
						switch($upload_error)
						{
							case 1: 'Il file inviato &egrave; troppo grande. Scegline uno pi&ugrave; piccolo. [server error]'; break;	
							case 2: 'Il file inviato &egrave; troppo grande. Scegline uno pi&ugrave; piccolo. [client error]'; break;
							case 3: 'Il file inviato &egrave; stato caricato parzialmente. Ritenta l\'upload.'; break;
							case 6: 'Mancanza della cartella temporanea. [server error]'; break;
						}
						endif;
					}
					
					echo '</div>';
					
				}
			
				
			}
        ?>
            <form class="form-horizontal" action='support.php' method='POST' enctype="multipart/form-data">
              <fieldset>
                <legend>Servizio di supporto &bull; <?=$config['site_name'];?></legend>
                
                <div class="control-group <? if(isset($error[0])) echo 'error';?>">
                    <label class="control-label" for="input01">Il tuo nome</label>
                        <div class="controls">
                        	<? if(isset($_SESSION['real_name'])): ?>
                            <input type="text" class="input-xlarge" name="name"  maxlength="16" value="<?=$_SESSION['real_name'];?>">
							<? else: ?>	
                            <input type="text" class="input-xlarge" name="name"  maxlength="16" value="<? if(isset($name)) echo $name;?>">
                            <? endif; ?>
                            <p class="help-block">Il tuo nome reale</p>
                        </div>
                </div>
                                                
                <div class="control-group <? if(isset($error[1])) echo 'error';?>">
                    <label class="control-label" for="input01">Email</label>
                        <div class="controls">
                        	<? if(isset($_SESSION['email'])): ?>
                            <input type="text" class="input-xlarge" name="email" maxlength="50" value="<?=$_SESSION['email'];?>">
                            <? else: ?>	
                            <input type="text" class="input-xlarge" name="email" maxlength="50" value="<? if(isset($email)) echo $email;?>">
                            <? endif; ?>
                            <p class="help-block">La tua email servirà per rispondere alla tua domanda</p>
                        </div>
                </div>
                
                <div class="control-group <? if(isset($error[4])) echo 'error';?>">
                    <label class="control-label" for="input01">Messaggio</label>
                        <div class="controls">
                            <textarea class="input-xlarge" name="messaggio" rows="5"><? if(isset($messaggio)) echo $messaggio;?></textarea>
                        </div>
                </div>
                
                <div class="control-group">
                	<label class="control-label" for="fileInput">Allega un immagine</label>
                    <div class="controls">
                    	<input class="input-file" type="file" name="file">
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?=$config['max_file_size'];?>">
                        <p>Per allegare uno screen alla tua richiesta di supporto.</p> 
                    </div>
                </div>
                                                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="signup-go"><i class="icon-ok icon-white"></i> Invia!</button>
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