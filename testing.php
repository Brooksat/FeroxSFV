<?php

// correctly format the data from the csv entries;
function formatEntry($string){
    $string = strtok(strtok(strtok(strtok($string, '/'), '+'),'*'), '(');
    $string = is_numeric($string) ? $string : 'NULL';
    return $string;

}
echo "Uhhm";
echo(formatEntry("5(2)"));
?>