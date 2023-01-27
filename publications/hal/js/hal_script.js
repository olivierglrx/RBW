jQuery(document).on('keypress',function(e) {
  if(e.which == 13) {
      jQuery('#action-button').click();
  }
});
jQuery(document).ready(function($){
  $('#action-button').click(function() {
    $('#message').text('Click only once, it can take up to 5 seconds');
    $("#myTable > tbody").html("");
    $("#myTable > thead").html("");

    var author = $('#search_input').val();
    const data= new Object();
    authors=author.replace(' ', '+');
    data.author=authors;
    data.action="get_hal_content";


    $.ajax({
      url: adminAjax.ajaxurl,
      method:'POST',
      data,
      dataType: "json",


      error: function() {

              jQuery('#message').text('Sorry... there has been a problem');

      },

      success: function(return_data) {
        var publications=JSON.parse(return_data.data).response.docs;
        publications[0];
        insert_first_line();
        var ID=0
        publications.forEach(function(element){
          // console.log(element);
          var journal =element.journalTitle_s;
          var title = element.title_s[0];
          var doi ='';
          var year = element.publicationDate_s.match(/[0-9]{4}/)[0];

          var abstract ='';
          if (element.abstract_s!=null){
              var abstract = element.abstract_s[0];
          }

          var keywords = ' ';
          var volume = ' ';
          var pages = ' ';
          var type='';
          var publisher='';
          var editor='';
          var booktitle='';
          var extraInfo='';
          var ISBN='';
          var link='';
          if (element.arxivId_s!=null){
            link='https://arxiv.org/pdf/'+element.arxivId_s+'.pdf';
          }
          
          
          author = element.authFullName_s.join(', ')
          insert_table_line([title, author, year, type, journal, doi, ISBN, volume, link, pages, keywords, publisher, editor, booktitle, abstract,extraInfo],ID);
          ID++;

        });



      }

    });
  });
});
