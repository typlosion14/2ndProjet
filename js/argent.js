$("#Perso").click(function() {
    $.ajax({
        type: "POST",
        url: "php/ajax.php",
        data: {
            argent: 1
        },
        success: function (data) {
            if(data.length>5){
                alert(data);
            }else{
                document.location.href = "thanks_achat.html";
            }

        }
    });
});
$("#Pro").click(function() {
    $.ajax({
        type: "POST",
        url: "php/ajax.php",
        data: {
            argent: 2
        },
        success: function (data) {
            if(data.length>5){
                alert(data);
            }else{
                document.location.href = "thanks_achat.html";
            }
        }
    });
});
