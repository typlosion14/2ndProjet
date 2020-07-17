function newquestion(id) {
    //Creation d'une nouvelle question
    $.ajax({
        type: "POST",
        url: "../php/ajax.php",
        data: {
            PopupCreator: id
        },
        success: function (data) {
            overlay.style.display='block';
            document.getElementById("popup").innerHTML=data;
        }
    });
}

function deletequestion(id) {
    //Suppression d'une question
    if (confirm("Êtes-vous sur de supprimer cette question ?")) {
        $.ajax({
            type: "POST",
            url: "../php/ajax.php",
            data: {
                removequestion: id
            },
            success: function () {
                location.reload();
            }
        });
    }
}

function modifyquestion(id) {
    //Modification d'une question

    $.ajax({
        type: "POST",
        url: "../php/ajax.php",
        data: {
            PopupEditor: id
        },
        success: function (data) {
            overlay.style.display='block';
            document.getElementById("popup").innerHTML=data;
        }
    });
}

function deletesurv(id) {
    //Suppression du survey
    if (confirm("Êtes-vous sur de supprimer ce survey ?")) {
        $.ajax({
            type: "POST",
            url: "../php/ajax.php",
            data: {
                removesurv: id
            },
            success: function () {
                document.location.href = "../home.php";
            }
        });
    }
}
function addrep(id_q,id_s){
    //Création d'une réponse
    var rep=prompt("Texte de la réponse:");
    if (rep.length > 0) {
        $.ajax({
            type: "POST",
            url: "../php/ajax.php",
            data: {
                createrep: rep,
                id_q:id_q,
                id_s:id_s
            },
            success: function () {
                location.reload();
            }
        });
        }
}
function modifyrep(id,text){
    //Modification d'une réponse
    text=prompt("Texte de la réponse:",text);
    if(text.length>0){
        $.ajax({
            type: "POST",
            url: "../php/ajax.php",
            data: {
                modifyrep: id,
                text:text
            },
            success: function () {
                location.reload();
            }
        });
    }
}
function deleterep(id) {
    //Suppression d'une réponse
    if (confirm("Êtes-vous sur de supprimer cette reponse ?")) {
        $.ajax({
            type: "POST",
            url: "../php/ajax.php",
            data: {
                removerep: id
            },
            success: function () {
                location.reload();
            }
        });
    }
}
function theme(){
    if($("body").css("background-color")==="rgb(0, 0, 0)"){
        $("#menu ul li p").addClass("dayfront");
        $("#menu ul li a").addClass("dayfront");

        $("body").css("background-color","white");
    }else{
        $("#menu ul li p").addClass("dayback");
        $("#menu ul li a").addClass("dayback");

        $("body").css("background-color","black");
    }
}

function sharesurv(id){
    var text = "https://danganronpa-online.games/viewer.php/?id="+id
    prompt("Copier-Coller:",text);
}

function watchsurv(id) {
    //Visionage des resultats d'un survey
    window.location.assign("../analyticsPro.php/?id=" + id)
}
function sendForm(id){
    $.ajax({
        url:'../php/updateQ.php',
        type:'post',
        data:$('#myForm').serialize()+"&id="+id+"&type=Edit",
        success:function(data){
            //Show Error
            if(data.length>4){
                alert("Veuillez Rentrer une question s'il vous plaît.")
            }else{
                location.reload();
            }
        }
    });
}
function sendFormCrea(id){
    $.ajax({
        url:'../php/updateQ.php',
        type:'post',
        data:$('#myForm').serialize()+"&id="+id+"&type=Create",
        success:function(data){
            //Show Error
            if(data.length>4){
                alert("Veuillez Rentrer une question s'il vous plaît.")
            }else{
                location.reload();
            }
        }
    });
}