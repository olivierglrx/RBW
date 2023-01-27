
jQuery( document ).ready( function($) {
  $( '#send_email' ).on( 'click', $('#send_email'), function() {
  const data= new Object();
    data.action='send_email_ajax';
    data.email=$('#email input').val();
    data.first=$('#first input').val();
    data.last=$('#last input').val();
    data.ID=member_id.id;
  // }
  //
    $.ajax({
      url : adminAjax.ajaxurl,
      // method : 'POST', // GET par défaut
      data,

      success : function( return_data ) { // en cas de requête réussie
        console.log(return_data);
        $('#email_acf p').text('Email has been send');
      },
      error : function( data ) { // en cas d'échec
        // Sinon je traite l'erreur
        console.log( 'Erreur…' );
        console.log($('#email_acf p').text('Sorry, there has been an error'));
      }
    });
  });
});
