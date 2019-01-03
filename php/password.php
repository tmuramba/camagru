<?php
function checkpassword($password)
{
    $a = 1;
    if(strlen($password) < 8)
    {
        echo "Password must have at least 8 characters!<br/>";
        $a = 0;
    }
    if(!preg_match("#[0-9]#", $password))
    {
        echo "Password must have at least 1 number!<br/>";
        $a = 0;
    }
    if(!preg_match("#[a-z]#", $password))
    {
        echo "Password must have atleast 1 lowercase character!<br/>";
        $a = 0;
    }
    if(!preg_match("#[A-Z]#", $password))
    {
        echo "Password must have at least 1 uppercase character!<br/>";
        $a = 0;
    }
    if($a ==1)
        return(true);
    else
        return(false);
}
?>