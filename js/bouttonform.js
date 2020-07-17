function newsurv() {
    //Creation de ToDoList
    var name = prompt("Choissisez le nom du Survey", "");
    if (name !== "" && name!==null) {
        $.ajax({
            type: "POST",
            url: "php/ajax.php",
            data: {
                createsurv: name
            },
            success: function () {
                location.reload();
            }
        });
    }
}

function modifysurv(id) {
    //Modification d'un survey
    window.location.assign("./editor.php/?id=" + id)
}



function theme() {

    if ($("body").css("background-color") === "rgb(0, 0, 0)") {
        $("#menu ul li p").addClass("dayfront");
        $("#menu ul li a").addClass("dayfront");

        $("body").css("background-color", "white");
    } else {
        $("#menu ul li p").addClass("dayback");
        $("#menu ul li a").addClass("dayback");

        $("body").css("background-color", "black");
    }
}