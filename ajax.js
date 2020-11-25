$(document).ready(function(){
   
});
function SubmitFormData() {

  $(".ajax-l").find( ".btn" ).remove();
    var Quartier = $('#ville').val();
        var Service = $('#service').val();
        var fname=$('#your-name').val();
        var phone=$('#your-phone').val();
        var email=$('#your-email').val();
        var address=$('#ville').val();
        var service=$('#service').val();
       
     if(Quartier!="" && Service!="" && fname!="" && phone!="" && email!="" && address!="" && service!=""){
        $(".ajax-loader").append('<a style="margin-top:1%" class="btn btn-warning">Nous sommes entrain de traiter votre demande</a>');
        setTimeout(function(){
          $(".ajax-loader").find( ".btn" ).remove();
          $('#myModal').modal('show');
        }, 5000);
        setTimeout(function(){
         fname=$('#your-name').val("");
         phone=$('#your-phone').val("");
         email=$('#your-email').val("");
       
      }, 5000);
      $.ajax({
            method: "POST",
            url: "apisendmail.php",
            data: { Quartier: Quartier, Service:Service, fname:fname, phone:phone, email:email, address:address, service:service}
          })
            .done(function( msg ) {
            
            });
     }
     else $(".ajax-loader").append('<a style="margin-top:1%" class="btn btn-danger">Merci de renseigner tous les champs</a>');
       
}
function ContactUsData() {
  $(".ajax-l").find( ".btn" ).remove();
    var Quartier = $('#city').val();
        var Service = $('#need').val();
        var fname=$('#name').val();
        var phone=$('#phone').val();
        var email=$('#email').val();
        var address=$('#city').val();
        var service=$('#service').val();
         setTimeout(function(){
          $(".ajax-l").find( ".btn" ).remove();
        }, 5000);
        if(Quartier!="" && Service!="" && fname!="" && phone!="" && email!="" && address!="" && service!=""){
          $(".ajax-l").append('<a style="margin-top:1%" class="btn btn-warning">Nous sommes entrain de traiter votre demande</a>');
       
         setTimeout(function(){
            $(".ajax-l").find( ".btn" ).remove();
            $('#myModall').modal('show');
          }, 5000);
          setTimeout(function(){
           fname=$('#name').val("");
           phone=$('#phone').val("");
           email=$('#email').val("");
         
        }, 5000);
        
        $.ajax({
            method: "POST",
            url: "apisendmail.php",
            data: { Quartier: Quartier, Service:Service, fname:fname, phone:phone, email:email, address:address, service:service}
          })
            .done(function( msg ) {
            }); }
            else $(".ajax-l").append('<a style="margin-top:1%" class="btn btn-danger">Merci de renseigner tous les champs</a>');
         
           
}