<?php
include 'commands.php';

$charList = getCharacterList();

?>

<!DOCTYPE html>
<html>

<head>
    <title>SFV Frame Data</title>
    <link rel="stylesheet" type="text/css" href="design.css"> 
    <script src="scripts.js"></script>
</head>

<body>
    
    <div>
        <div id="p1" class="vertical dropDownContainer">
            <p>Player 1</p>
            <p onclick="toggleVisibility('p1CharacterList')" id="p1CurrentCharacter">Current Character</p>
            <ul id="p1CharacterList" class="dropDownList">
                <?php
                    foreach($charList as $char){
                        echo "<li class = \"listItem p1List\" onClick = \"setListHeader(this);getUserMoves(this);\">$char</li>";
                    }
                ?>
            </ul>
        </div>

        <div class="vertical listContainer">
            <p id="p1CurrentCharacter">You can punish with</p>
            <ul id="p1Moves">
                <li class="listItem">A move</li>
            </ul>
        </div>

        <div class="vertical listContainer">
            <p id="p1CurrentCharacter">You blocked</p>
            <ul id="p2Moves">
                <li class="listItem">A move</li>
            </ul>
        </div>

        <div id="p2" class="vertical dropDownContainer">
            <p>Player 2</p>
            <p onclick="toggleVisibility('p2CharacterList')" id="p2CurrentCharacter">Current Character</p>
            <ul id="p2CharacterList" class="dropDownList">
                <?php
                    foreach($charList as $char){
                        echo "<li class = \"listItem p2List\" onClick = \"setListHeader(this);getUserMoves(this);\">$char</li>";
                    }
                ?>
            </ul>
        </div>
    </div>
</body>

</html>
