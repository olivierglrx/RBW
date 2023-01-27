// AJAX call for saving which plugin are on. 



jQuery( document ).ready( function($) {
 
  $( document ).on( 'click', $('.input'), function() {
  container = document.getElementById('container');
  inputs = container.getElementsByTagName('input');
  const data= new Object();
  for (index = 0; index < inputs.length; ++index) {
    if(inputs[index].checked){
      x=inputs[index].id;
      data[x]=1;
    }
    else{
       x=inputs[index].id;
      data[x]=0;
    }
    data.action='activated_button'  // this action is load by the hook 'wp_ajax_activated_button' in 'activated_plugins.php'
  }
   
    $.ajax({
      url : adminAjax.ajaxurl,
      // method : 'POST', // GET par défaut
      data,
      
      success : function( return_data ) { // en cas de requête réussie
        // console.log(return_data);
      },
      error : function( data ) { // en cas d'échec
        // Sinon je traite l'erreur
        console.log( 'Erreur…' );
      }
    });
  });
});
