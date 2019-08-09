<?php
$servername = 'localhost';
$username = "root";
$password = "";
$db = "sfvchar";
$KNOCK_DOWN = -100;


//Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
//Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



$csvNamesFile = "csvFiles\\names.csv";

$csvOpen = fopen($csvNamesFile, 'r');

while(($data = fgetcsv($csvOpen)) !== FALSE) {
    openCharFile($data[0]);
}


function openCharFile($name){
    $fileName = "csvFiles\\$name.csv";
    $file = fopen($fileName, 'r');
    
    while (($data = fgetcsv($file)) !== FALSE) {
        //  $row = implode("-",$data);
        //  echo($data[0] . "-" . $data[1] . "-" . $data[5]);
        //  echo("<br><br>");
        insertMoveEntry($data,$name);
    }
    fclose($file);
}

fclose($csvOpen);






function insertMoveEntry($row, $charName)
{

    
    global $conn;
    $nameOfficial = mysqli_real_escape_string($conn,$row[0]);
    $nameCommon = mysqli_real_escape_string($conn,$row[1]);
    $startup = formatEntry($row[2]);
    $onHit = formatOnHit($row[5]);
    $onBlock = formatEntry($row[6]);
    $charID = getCharID($charName);

    $sql = "INSERT INTO `moves` (`move_id`, `character_name`, `character_id`, `move_name`, `move_name_common`, `start_up`, `on_hit`, `on_block`) VALUES (NULL, '$charName', '$charID', '$nameOfficial', '$nameCommon', $startup, $onHit, $onBlock)";
    //echo($sql."<br><br><br>");

    // $test = $row[0] == "Move Name";
    // echo($row[0]. "-". "Move Name");
    // echo "<br>"; 
    // echo($test  ? "true" : "false");
    // echo "<br>"; 
    if ($row[0] != "Move Name") {
        echo ("Attempting to add: " . $row[0] . "<br>");
        if (mysqli_query($conn, $sql)) {
            //echo "new record created<br>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn) . "<br><br>";
        }
    }
}

function getCharID($charName)
{
    global $conn;
    $sql = "SELECT `character_id` FROM `characters` WHERE `character_name` = '$charName'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['character_id'];
}
function printFrame($row)
{
    if ($row[0] == "Move Name") { } else {
        echo "<p>$row[0], $row[1], ", strtok($row[5], '/'), "</p>";
    }
}
// correctly format the data from the csv entries;
function formatEntry($string){
    $string = strtok(strtok(strtok(strtok($string, '/'), '+'),'*'), '(');
    $string = is_numeric($string) ? $string : 'NULL';
    return $string;

}
// format on hit entries
function formatOnHit($string){
    
    if ($string == "KD") {
        global $KNOCK_DOWN;
        return $KNOCK_DOWN;
    }
    else{
        return formatEntry($string);
    }
    
}
