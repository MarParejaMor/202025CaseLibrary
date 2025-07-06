<?php
include("db_connection.php");
$userId=$_SESSION["account_id"];
$processId=$_SESSION["selected-process"];
$processQuery="SELECT * FROM process WHERE `account_id`='$userId' AND `process_id`='$processId'";
$result = mysqli_query($conn,$processQuery);
$currentProcess=mysqli_fetch_assoc($result);
if(isset($currentProcess))
{
    $_SESSION["process"]=$currentProcess;
}
else
{
    echo("Error de conexion");
}
?>
