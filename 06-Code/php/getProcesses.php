<?php
    session_start();
    include("../php/db_connection.php");
    $userId=$_SESSION["account_id"];
    $profileQuery="SELECT * FROM process WHERE `account_id`='$userId'";
    $result = mysqli_query($conn,$profileQuery);
    $processes = [];

while ($process = mysqli_fetch_assoc($result)) {
    $processes[] = [
        'title' => $process['title'],
        'description' => $process['description']
    ];
}

    echo(json_encode($processes));
    
?>