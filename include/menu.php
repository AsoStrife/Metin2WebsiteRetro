<? $filename = basename($_SERVER['PHP_SELF']); ?>

<div class="well" style="padding: 8px 0;">
    <ul class="nav nav-list">
        <li class="nav-header"><?=$config['site_name'];?></li>
        
        <li<? if($filename == 'index.php') echo ' class="active"';?>>
        	<a href="index.php"><i class="icon-home <? if($filename == 'index.php') echo ' icon-white"';?>"></i> Home</a>
        </li>
        
		<? if(isset($_SESSION['id'])): ?>
            
            <li <? if($filename == 'edit-password.php') echo ' class="active"';?>>
            	<a href="edit-password.php"><i class="icon-lock <? if($filename == 'edit-password.php') echo ' icon-white"';?>"></i> Modifica password</a>
            </li>
                    	
            <li <? if($filename == 'edit-social-id.php') echo ' class="active"';?>>
            	<a href="edit-social-id.php"><i class="icon-flag <? if($filename == 'edit-social-id.php') echo ' icon-white"';?>"></i> Codice elimina personaggio</a>
            </li>
            
            <li <? if($filename == 'summary.php') echo ' class="active"';?>>
            	<a href="summary.php"><i class="icon-user <? if($filename == 'summary.php') echo ' icon-white"';?>"></i> Riepilogo dati</a>
            </li>
        	
            <li><a href="logout.php"><i class="icon-share-alt"></i> Logout</a></li>
            
        <? else: ?> 
            <li<? if($filename == 'login.php') echo ' class="active"';?>>
                <a href="login.php"><i class="icon-share-alt <? if($filename == 'login.php') echo ' icon-white"';?>"></i> Login</a>
            </li>   
            
            <li<? if($filename == 'registrati.php') echo ' class="active"';?>>
                <a href="registrati.php"><i class="icon-pencil <? if($filename == 'registrati.php') echo ' icon-white"';?>"></i> Registrati</a>
            </li>
            
            <li<? if($filename == 'forgot-password.php') echo ' class="active"';?>>
                <a href="forgot-password.php"><i class="icon-refresh <? if($filename == 'forgot-password.php') echo ' icon-white"';?>"></i> Recupera password</a>
            </li>
            
            <li<? if($filename == 'new-mail.php') echo ' class="active"';?>>
            	<a href="new-mail.php"><i class="icon-share <? if($filename == 'new-mail.php') echo ' icon-white"';?>"></i> Riinvia email di conferma</a>
            </li>

        <? endif;?>
        
        <li class="divider"></li>
        <li class="nav-header">Link utili</li>
        
        <li<? if($filename == 'classifica-player.php') echo ' class="active"';?>>
        	<a href="classifica-player.php"><i class="icon-list <? if($filename == 'classifica-player.php') echo ' icon-white"';?>"></i> Classifica player</a>
        </li>
        
        <li<? if($filename == 'classifica-gilde.php') echo ' class="active"';?>>
        	<a href="classifica-gilde.php"><i class="icon-list <? if($filename == 'classifica-gilde.php') echo ' icon-white"';?>"></i> Classifica gilde</a>
		</li>
        
        <li class="divider"></li>
        
        <li <? if($filename == 'support.php') echo ' class="active"';?>>
        	<a href="support.php"><i class="icon-tasks  <? if($filename == 'support.php') echo ' icon-white"';?>"></i> Supporto</a>
       	</li>
    </ul>
    
    
</div>

	<? include('include/statistiche.php');?>
