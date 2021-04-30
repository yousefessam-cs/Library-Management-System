<?php 
if(isset($_COOKIE['email']) && isset($_COOKIE['name']))
{
    $_SESSION['name']=$_COOKIE['name'];
    $_SESSION['email']=$_COOKIE['email'];
    $_SESSION['type']=$_COOKIE['type'];
}
else if(!array_key_exists('type',$_SESSION))
{
    header("Location: index.php");
}
