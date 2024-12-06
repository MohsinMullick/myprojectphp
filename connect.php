<?php
$conn=mysqli_connect('localhost','root','','riderent');
if($conn)
{
    echo"connected";
}
else{
    echo"Not Connected";
}