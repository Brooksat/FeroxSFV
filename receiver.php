<?php
$q = $_GET['q'];
$p = $_GET['p'];

$server = 'localhost';
$user = "root";
$pass = "";
$db = "sfvchar";
$conn = mysqli_connect($server, $user, $pass, $db) or die("Unable to connect");

$moveset = getCharacterMoveset($q);

while ($row = mysqli_fetch_assoc($moveset)) {

    if ($p == "1") {
        if (!is_null($row['on_hit'])) {
            echo ("<li class = \"listItem p1List\"><p>{$row['move_name_common']}: </p><p>{$row['start_up']}</p></li>");
        }
    } elseif ($p == "2") {
        if (!is_null($row['on_block'])) {
            echo ("<li class = \"listItem p1List\" onClick=\"setSelectedMove(this)\"><p>{$row['move_name_common']}: </p><p>{$row['on_block']}</p></li>");
        }
    } else {
        echo ("Player was not received");
        break;
    }
}


function getCharacterMoveset($character)
{
    try {
        global $conn;
        $sql = "SELECT * 
        FROM `moves` 
        WHERE `character_name` = '$character'";
        //AND `on_hit` IS NOT NULL
        $result = mysqli_query($conn, $sql);
        return $result;
    } catch (Exception $e) {
        echo "Could not get moveset";
    }
}
mysqli_close($conn);
