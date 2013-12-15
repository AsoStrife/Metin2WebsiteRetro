<?
function validatemail($email)
{
    $email = trim($email);
    if(!$email) return false;	
    $num_at = count(explode( '@', $email )) - 1;
    if($num_at != 1)return false;
    if(strpos($email,';') || strpos($email,',') || strpos($email,' '))return false;
    if(!preg_match( '/^[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}$/', $email))  return false;
    return true;
}
?>