<?php 
include('include/config.php');
if(isset($_SESSION['id'])) header('Location: index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Registrazione &bull; <?=$config['site_name'];?></title>
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
            mysql_select_db('account', $conn);
        
            $data_del_Giorno		= date('Y-m-d H:i:s');
            $gold_expire			=(date('Y')+50).date('-m-d H:i:s');
            $silver_expire			=(date('Y')+50).date('-m-d H:i:s');
            $safebox_expire			=(date('Y')+50).date('-m-d H:i:s');
            $autoloot_expire		=(date('Y')+50).date('-m-d H:i:s');
            $fish_mind_expire		=(date('Y')+50).date('-m-d H:i:s');
            $marriage_fast_expire	=(date('Y')+50).date('-m-d H:i:s');
            $money_drop_rate_expire	=(date('Y')+50).date('-m-d H:i:s');
            
            $name					= mysql_real_escape_string($_POST['name']);
            $user					= mysql_real_escape_string($_POST['user']);
            $password				= mysql_real_escape_string($_POST['password']);
            $password_2				= mysql_real_escape_string($_POST['password-2']);
            $email					= mysql_real_escape_string($_POST['email']);
            $delete					= mysql_real_escape_string($_POST['delete']);
            
            $status = $config['email_registration'] ? NULL : 'OK';
                
            $query="INSERT INTO account (id, login, password, real_name, social_id, email, phone1, phone2, address,zipcode, create_time, question1 ,answer1 ,question2 , answer2, is_testor, status, securitycode, newsletter, empire, name_checked, availDt, mileage, cash, gold_expire, silver_expire, safebox_expire, autoloot_expire, fish_mind_expire, marriage_fast_expire, money_drop_rate_expire, ttl_cash, ttl_mileage, channel_company ) 
            
            VALUES(NULL , '$user', PASSWORD('$password'), '$name', '$delete', '$email', NULL , NULL , '".$_SERVER["REMOTE_ADDR"]."', '', '$data_del_Giorno', NULL , NULL , NULL , NULL , '0', '$status', '', '0', '0', '0', '0000-00-00 00:00:00', '0','0' ,'$gold_expire' ,'$silver_expire' ,'$safebox_expire' ,'$autoloot_expire' ,'$fish_mind_expire' ,'$marriage_fast_expire' ,'$money_drop_rate_expire' , '0', '0', '')";
            
            
            $error=array();
            
            if(strlen($name) < 2)
            {
                $error[0 ]= 'Il nome deve essere di almeno 2 caratteri!';
            }
            
            elseif(strlen($name)>16)
            {
                $error[0] = 'Il nome deve essere di massimo 16 caratteri!';
            }
            
            if(strlen($user) < 2)
            {
                $error[1]='Il nome utente deve essere di almeno 2 caratteri!';
            }
            
            elseif(strlen($user)>9)
            {
                $error[1] = 'Il nome utente deve essere di massimo 9 caratteri!';
            }
            
            if(strlen($password)< 5)
            {
                $error[2] = 'La password deve essere di almeno 5 caratteri!';
            }
            
            elseif(strlen($password)>9)
            {
                $error[2 ] = 'La password deve essere di massimo 9 caratteri!';
            }
            elseif($user == $password)
            {
                $error[2] = 'La password non può essere uguale all\'username.';
            }
            
            
            if($password!=$password_2)
            {
                $error[3] = 'Le due passowrd non coincidono.';
            }
            
            if(!validatemail($email))
            {
                $error[4] = 'Inserisci una email valida.';
            }	
                
            elseif(strlen($email)>50)
            {
                $error[4] = 'L\'email deve essere lunga massimo 50 caratteri.';
            }
            
            $ceq 	= "SELECT email FROM account WHERE email = '$email';";
            $rceq	= mysql_query($ceq);
            if($rceq)
            {
                $count_1 = mysql_num_rows($rceq);
                if($count_1 >= 1)
                {
                    $error[5] = 'L\'email è già in uso da un altro utente, se hai dimenticato la password utilizza il nostro recupera password.';
                }
            }
            
            $clq 	= "SELECT login FROM account WHERE login = '$user';";
            $rclq	= mysql_query($clq);
            if($rclq)
            {
                $count_2 = mysql_num_rows($rclq);
                if($count_2 >= 1)
                {
                    $error[6] = 'L\'username è già in uso da un altro utente, scegline un altro.';
                }
            }
            
            
            if(strlen($delete)!=7)
            {
                $error[7] = 'Il codice per cancellare il personaggio deve essere lungo 7 caratteri.';
            }
            elseif($delete == 1234567)
            {
                $error[7] = 'Non puoi utilizzare come codice per cancellare il personaggio 1234567 perché non &egrave; sicuro, scegline un altro.';
            }
			elseif($delete == 0000000)
			{
                $error[7] = 'Non puoi utilizzare come codice per cancellare il personaggio 0000000 perché non &egrave; sicuro, scegline un altro.';
            }
            
            if(count($error) == 0)
            {
                if(mysql_query($query))
                {
                    if($config['email_registration'])
                    {
                        $header 	= 	"To:". $name ."<".$email.">\n";
                        $header 	.= 	"From: ".$config['site_name'] ."<".$config['email_site'].">\n";
                        $header 	.=  "MIME-Version: 1.0\n";
                        $header 	.=  "Content-Type: text/html; charset=\"utf-8\" \n";
                        $header 	.=  "Content-Transfer-Encoding: 7bit\n\n";
                        $oggetto 	= 	"Conferma registrazione su " .$config['site_name'];
                        $messaggio 	= 	'<html><body> 
                                        <p>Benvenuto '.$name .'su '.$config['site_name'].'</p>
                                        <p>Per confermare il tuo account clicca sul seguente link : <a href="'.$config['base_url'].'confirm-account.php?login='.base64_encode($user).'" >Conferma account </a>
                                        </body></html>';
                        
                        if(mail("$email",$oggetto,$messaggio,$header))
                        {
                            echo '<div class="alert alert-success">L\'account &egrave; stato registrato con successo, riceverai a breve un email per confermare il tuo account!</div>';
                        }
                        else
                        {
                            echo '<div class="alert alert-error">L\'account non è stato creato per problemi interni al server mail. Riprova più tardi. </div>';	
                        }
                    }
                
                    else
                    {
                        echo '<div class="alert alert-success">L\'Account &egrave; stato registrato con successo, verrai reindirizzato alla home!</div>';
                        echo '<meta http-equiv="refresh" content="3;url=index.php" />';
                    }
                }
                else
                {
                    echo '<div class="alert alert-error">L\'account non è stato creato per problemi interni al server. Riprova più tardi. </div>';
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
            <form class="form-horizontal" action='registrati.php' method='POST'>
            
              <fieldset>
                <legend>Registrati su <?=$config['site_name'];?></legend>
                
                <div class="control-group <? if(isset($error[0])) echo 'error';?>">
                    <label class="control-label" for="input01">Il tuo nome</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="name"  maxlength="16" value="<? if(isset($name)) echo $name;?>">
                            <p class="help-block">Il tuo nome reale</p>
                        </div>
                </div>
                
                <div class="control-group <? if(isset($error[1]) or isset($error[6])) echo 'error';?>">
                    <label class="control-label" for="input01">Username</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="user"  maxlength="9" value="<? if(isset($user)) echo $user;?>">
                            <p class="help-block">Il nome che utilizzerai per effettuare il login, massimo 9 caratteri</p>
                        </div>
                </div>
                
                <div class="control-group <? if(isset($error[2]) or isset($error[3])) echo 'error';?>">
                    <label class="control-label" for="input01">Password</label>
                        <div class="controls">
                            <input type="password" class="input-xlarge"  name="password" maxlength="9">
                            <p class="help-block">Massimo 9 caratteri</p>
                        </div>
                </div>
                
                <div class="control-group <? if(isset($error[3])) echo 'error';?>">
                    <label class="control-label" for="input01">Conferma password</label>
                        <div class="controls">
                            <input type="password" class="input-xlarge"  name="password-2" maxlength="9">
                            <p class="help-block">Riscrivi per sicurezza la password</p>
                        </div>
                </div>
                
                <div class="control-group <? if(isset($error[4]) or isset($error[5])) echo 'error';?>">
                    <label class="control-label" for="input01">Email</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="email" maxlength="50" value="<? if(isset($email)) echo $email;?>">
                        </div>
                </div>
                
                <div class="control-group <? if(isset($error[7])) echo 'error';?>">
                    <label class="control-label" for="input01">Codice elimina personaggio</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="delete" maxlength="7" value="<? if(isset($delete)) echo $delete;?>">
                            <p class="help-block">Dev'essere lungo 7 caratteri</p>
                        </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="signup-go"><i class="icon-ok icon-white"></i> Registrati!</button>
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