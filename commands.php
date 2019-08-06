<?php


$server = 'localhost';
$user = "root";
$pass = "";
$db = "sfvchar";
$conn = connectToDB($server, $user, $pass, $db);

$dropDownItem = "dropdownItem";


function connectToDB($server, $user, $pass, $db)
{
    $conn = mysqli_connect($server, $user, $pass, $db) or die("Unable to connect");
    return $conn;
}

function getCharacterList()
{
    global $conn;
    $sql = "SELECT * from `characters`";
    $charArr = array();
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        array_push($charArr, $row['character_name']);
    }
    return $charArr;
}

function getCharacterMoveset($character)
{
    global $conn;
    $sql = "SELECT * from `moves` WHERE `character_name` = '$character'";
    $result = mysqli_query($conn, $sql);
}

//prints all characters in character DB
function printCharacterName()
{
    $moveList = getCharacterList();
    if (getCharacterList()) { } else {
        echo "Thing is messed";
    }
    while ($row = mysqli_fetch_assoc($moveList)) {
        echo ("<ul>{$row['character_name']}</ul>");
    }
}

function nameToListItem($character)
{
   // return  "<li class=\"dropdownItem\">{$row['character_name']}</li>);
}

function printCharacterMoveset($character)
{
    $moveList = getCharacterMoveset($character);

    while ($row = mysqli_fetch_assoc($moveList)) {
        echo ("<p>{$row['move_name']}</p>");
    }
}

?>