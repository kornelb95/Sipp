// $("#registerForm").submit(function(event){
//     event.preventDefault();
//     var postData = $(this).serializeArray();
//     $.ajax({
//         url: "rejestracja.php",
//         type: "POST",
//         data: postData,
//         success: function(data){
//             if(data){
//                 $("#registerMessage").html(data);
//             }
//         },
//         error: function(){
//             $("#registerMessage").html("<div class='alert alert-danger'>Błąd wywołania AJAX</div>");
//
//         }
//
//     });
//
// });