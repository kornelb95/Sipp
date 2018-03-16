$(document).ready(function () {
    $("#registerform").submit(function(event){
        //prevent default php processing
        event.preventDefault();
        //collect user inputs
        var datatopost = $(this).serializeArray();
   console.log(datatopost);
        //send them to signup.php using AJAX
        $.ajax({
            type: "POST",
            data: datatopost,
            success: function(data){
                if(data){
                    $("#registerMessage").html(data);
                }
            },
            error: function(){
                $("#registerMessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");

            }

        });
    });
});