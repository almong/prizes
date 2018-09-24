$(document).ready(function(){
    $("button").click(function(){
        $.ajax({
            type: 'POST',
            url: '/model/prizes.php',
            success: function(data) {
                $("#result").html(data);
            }
        });
});
});
