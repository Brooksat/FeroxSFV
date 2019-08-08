<?php
$servername = 'localhost';
$username = "root";
$password = "";
$db = "sfvchar";



//Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
//Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$csvNamesFile = "csvFiles\\names.csv";

$csvNames = fopen($csvNamesFile, 'r');

while (($data = fgetcsv($csvNames)) !== FALSE) {
    //print($data[0]);
    $sql = "INSERT INTO `characters` (`character_name`) VALUES ('$data[0]')";


    echo ("Attempting to add: " . $data[0] . "<br>");
    if (mysqli_query($conn, $sql)) {
        echo "new record created";
    } else {
        echo "Error: " . $sql . "<br><br>" . mysqli_error($conn) . "<br>";
    }
}

fclose($csvNames);
