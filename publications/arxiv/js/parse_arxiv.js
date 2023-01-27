
jQuery(document).on('keypress',function(e) {
    if(e.which == 13) {
        jQuery('#action-button').click();
    }
});

jQuery(document).ready(function($){
  jQuery('#action-button').click(function() {
    jQuery('#message').text('Click only once, it can take up to 5 seconds');
    jQuery("#myTable > tbody").html("");
    jQuery("#myTable > thead").html("");
    
    var arxiv_author=jQuery('#search_input').val();
    authors=arxiv_author.replace(' ', '+');

    var data = new Object()
    data.action='parsing_arxiv';
    data.authors=authors;
        jQuery.ajax({
            url:adminAjax.ajaxurl,
            method : 'POST', 
            data,
            dataType: "json",       
            error: function() {
             jQuery('#message').text('We are sorry. There has been an error...');
        },
            success: function(return_data) {
                insert_first_line();
                
                var journal ='';
                var title = '';
                var doi ='';
                var year = ' ';
                var abstract = ' ';
                var keywords = ' ';
                var volume = ' ';
                var pages = ' ';
                var type='preprint';
                var publisher='';
                var editor='';
                var booktitle='';
                var extraInfo='';
                var ISBN='';
                var link='';
                
                var pubs=return_data.data
                pubs.forEach(function(element, index){
                    
                    title=element.title;
                    abstract=element.abstract;
                    link=element.url;
                    year=element.year.match(/[0-9]{4}/)[0];
                    
                    authors = element.authors.join(', ')
                insert_table_line([title, authors, year, type, journal, doi, ISBN, volume, link, pages, keywords, publisher, editor, booktitle, abstract,extraInfo],index);
                } )
                
                
            }
        });
    });
});




jQuery(document).ready(function($){
  jQuery('#see_more').click(function() {
    jQuery('#message').text('We search more articles. Please wait...');
    var arxiv_author=jQuery('#search_input').val();
    authors=arxiv_author.replace(' ', '+');

    var data = new Object()
    data.action='see_more_arxiv';
    data.authors=authors;
    start=jQuery('#myTable tr').length;
    // console.log(start);
    data.start=start;
        jQuery.ajax({
            url:adminAjax.ajaxurl,
            method : 'POST', 
            data,
            dataType: "json",       
            error: function() {
             jQuery('#message').text('We are sorry. There has been an error...');
        },
            success: function(return_data) {
                // console.log(start);
                // console.log(return_data);
                
                var journal ='';
                var title = '';
                var doi ='';
                var year = ' ';
                var abstract = ' ';
                var keywords = ' ';
                var volume = ' ';
                var pages = ' ';
                var type='preprint';
                var publisher='';
                var editor='';
                var booktitle='';
                var extraInfo='';
                var ISBN='';
                var link='';

                var pubs=return_data.data
                pubs.forEach(function(element, index){
                    title=element.title;
                    abstract=element.abstract;
                    link=element.url;
                    year=element.year.match(/[0-9]{4}/)[0];
                    
                    
                    authors = element.authors.join(', ')
                insert_table_line([title, authors, year, type, journal, doi, ISBN, volume, link, pages, keywords, publisher, editor, booktitle, abstract,extraInfo],start+index);
                
                } )
                
                
            }
        });
    });
});




