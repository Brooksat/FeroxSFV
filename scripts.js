/* eslint-env browser */
var p2Moves = document.getElementById("p2Moves");

p2Moves.addEventListener("click", selectItem);

function selectItem(e) {

    if (e.target.nodeName == "LI") {
        console.log("li element click");
        for (var i = 0; i < e.target.parentNode.children.length; i++) {
            e.target.parentNode.children[i].classList.remove("selected");
        }

        e.target.classList.add("selected");
    }
}

function toggleVisibility(elementID) {
    var x = document.getElementById(elementID);
    if (x.style.display === "none") {
        x.style.display = "flex";
        x.style.flexDirection = "column";
    } else {
        x.style.display = "none";

    }
}

function setListHeader(element) {
    var x = "Muh";

    if (element.classList.contains("p1List")) {
        x = document.getElementById("p1CurrentCharacter");
        x.innerHTML = element.innerHTML;

        toggleVisibility("p1CharacterList");
    } else if (element.classList.contains("p2List")) {
        x = document.getElementById("p2CurrentCharacter");
        x.innerHTML = element.innerHTML;

        toggleVisibility("p2CharacterList");
    }
    //    console.log(x);
}


//gets the list of moves after a character has been chosen
function getUserMoves(el) {
    var x = "";
    var player = 0;
    if (el.classList.contains("p1List")) {
        x = "p1Moves";
        player = 1;
    } else if (el.classList.contains("p2List")) {
        x = "p2Moves";
        player = 2;
    }
    if (el.innerHTML == "") {
        document.getElementById(x).innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            var xmlhttp = new XMLHttpRequest();
        } else {
            //
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(x).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "receiver.php?q=" + (el.innerHTML) + "&p=" + player.toString(), true);
        xmlhttp.send();
        console.log("Request sent");
    }
}

////sets the selected element of a list
//function setSelectedMove(el) {
//    el.classList.add("selected");
//    var frameData = el.getElementsByTagName("p")[1];
//    updateP1Moves(frameData.innerHTML);
//}
// update p1 list of moves to show what you can punish with
function updateP1Moves(onBlock) {
    if (!isNaN(onBlock)) {


        console.log(onBlock);
        var moveList = document.getElementById("p1Moves");
        var moves = moveList.getElementsByTagName("li");
        for (var i = 0; i < moves.length; ++i) {
            var start_up = moves[i].getElementsByTagName("p")[1].innerHTML;
            if (!isEmptyOrSpaces(onBlock) && start_up <= (onBlock * -1) && onBlock < 0) {
                moves[i].classList.add("canPunishWith");
                moves[i].classList.remove("cannotPunishWith");
            } else {
                moves[i].classList.remove("canPunishWith");
                moves[i].classList.add("cannotPunishWith");
            }
        }


    } else {
        console.log("Frame data is not a number")
    }
}

function isEmptyOrSpaces(str) {
    return str === null || str.match(/^ *$/) !== null;
}
