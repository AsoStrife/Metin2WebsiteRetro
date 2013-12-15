<?php include('include/config.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Home page &bull; <?=$config['site_name'];?></title>
    <? include('include/meta-tags.php');?>
</head>
<body>

<div class="container">
	<div class="row">
    	<div class="span3">
            <? include('include/menu.php');?>
        </div>
  		
        <div class="span9">
		<legend>Benventi su <?=$config['site_name'];?></legend>
		
        <? 	if(isset($_SESSION['id'])) :
				echo '<pre>'; 
				print_r($_SESSION); 
				echo '</pre>';
			endif;
		?>
        
        <? include('include/home-page.php'); ?>
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