
function insert_publication(member_id){
  jQuery('.bn').hide();
  var advance=0
  var total=0;
  jQuery('#myTable :checkbox').each(function() {
    if(this.checked){
      id=this.id;
      total++;
      
    }
   
  }
  
  );
  

  jQuery('#myTable :checkbox').each(function() {
    if(this.checked){
      id=this.id;
      const data= new Object();

      list_of_entry.forEach(function(element){
        // console.log(element+id);

        data[element]= document.getElementById(element+id).textContent;

      });
    data['action']='register_publications';

    data["member_id"]=member_id;
    jQuery('#message').text('');


    jQuery.ajax({
      url : adminAjax.ajaxurl,
      method : 'POST', // GET par défaut
      data,

      success : function( return_data ) { // en cas de requête réussie
        advance++;
        document.getElementById('load_bar_container').style.display='block';

        document.getElementById('load').style.width=advance*100/total+'%';


        table=document.getElementById('table_container');
        table.style['display']='none';
        button=document.getElementById('button_container');
        button.style['display']='none';
        // console.log(return_data.data);

        if(return_data.data[0]=='DOI'){
          jQuery('#message').prepend( '<p style="color :orange; ">'+ return_data.data[1] + ' is already in Database </p>');
        }else{
        if(return_data.data[0]=='Title'){
          jQuery('#message').prepend( '<p style="color :orange; ">'+ return_data.data[1] + ' is already in Database </p>');
        }
        else{
          jQuery('#message').append( '<p>'+ return_data.data[1] + ' has been registered</p>');
        }
      }


      if (advance==total){
        jQuery('#message').prepend( '<p style="color :black; "> We are done ! </p>');
      }

      },
      error : function( data ) { // en cas d'échec

        jQuery('#message').text('Sorry, there has been an error...');
      }
     });

    }
  });
}
