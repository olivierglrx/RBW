



jQuery(document).on("input", "#my_publications", function() {
  var input=jQuery('#my_publications').val().toLowerCase();

  jQuery('.rb_acf_form').each(function(index, value){

    var title=jQuery(this).find(jQuery('.acf-input-wrap')).find(jQuery('input')).val().toLowerCase();


    if (title.search(input)==-1){
      jQuery(this).fadeTo(200, 0, function(){
        jQuery(this).hide(200);
        }
      );

    }
    else{
        jQuery(this).animate({opacity:1});
      jQuery(this).fadeIn(200);
    }
  });

})

// jQuery(document).ready( function($) {
//   $('tbody tr').each(function() {
//     var x = $(this).find(".title").html(); 

//     if (x.search('relat')==-1){
//       jQuery(this).fadeTo(200, 0, function(){
//         jQuery(this).hide(200);
//         }
//       );

//     }
//     else{
//       jQuery(this).animate({opacity:1});
//       jQuery(this).fadeIn(200);

//     }
//  });



// });



jQuery(document).on("input", "#my_publications", function($) {
  var input=jQuery('#my_publications').val().toLowerCase();
  console.log(input)
  jQuery('tbody tr').each(function() {
    var title = jQuery(this).find(".title").html().toLowerCase(); 
    var authors = jQuery(this).find(".authors").html().toLowerCase(); 
    var date = jQuery(this).find(".date").html().toLowerCase(); 
    
    if (title.search(input)==-1 && authors.search(input)==-1 && date.search(input)==-1){
      jQuery(this).fadeTo(20, 0, function(){
        jQuery(this).hide(20);
        }
      );

    }
    else{
      jQuery(this).animate({opacity:1});
      jQuery(this).fadeIn(200);

    }
  });

});
