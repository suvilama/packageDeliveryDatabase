<?php
$con=mysqli_connect('localhost','root','','package_delivery_company');
if(!$con){
    die(mysqli_error("Error" + $con));
}

?>