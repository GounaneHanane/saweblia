$(document).ready(function(){
   
});
function SubmitFormData() {

    var Quartier = $('#ville').val();
        var Service = $('#service').val();
        var fname=$('#your-name').val();
        var phone=$('#your-phone').val();
        var email=$('#your-email').val();
        var address=$('#ville').val();
        var service=$('#service').val();
        
     if(Quartier!="" && Service!="" && fname!="" && phone!="" && email!="" && address!="" && service!=""){
        $.ajax({
            method: "POST",
            url: "apisendmail.php",
            data: { Quartier: Quartier, Service:Service, fname:fname, phone:phone, email:email, address:address, service:service}
          })
            .done(function( msg ) {
              alert("Votre demande est bien transmis");
            });
     }
     else alert("Merci d'entrer tous les champs");
       
}
function ContactUsData() {
    var Quartier = $('#city').val();
        var Service = $('#need').val();
        var fname=$('#name').val();
        var phone=$('#phone').val();
        var email=$('#email').val();
        var address=$('#city').val();
        var service=$('#service').val();
        
        if(Quartier!="" && Service!="" && fname!="" && phone!="" && email!="" && address!="" && service!=""){
     
        $.ajax({
            method: "POST",
            url: "apisendmail.php",
            data: { Quartier: Quartier, Service:Service, fname:fname, phone:phone, email:email, address:address, service:service}
          })
            .done(function( msg ) {
              alert("Votre demande est bien transmis");
            });  }
            else alert("Merci d'entrer tous les champs");
           
}