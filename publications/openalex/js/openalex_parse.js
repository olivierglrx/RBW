
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
      var orcid_num=jQuery('#orcid').val();

      if (orcid_num.search(/([0-9]{4}\-){3}/)!=0){

        const data= new Object();
        data.action='get_OpenAlex_ID_from_name';
        data.name=orcid_num.replace(' ','+');
        jQuery.ajax({
        url:adminAjax.ajaxurl,
        method : 'POST',
        data,

        error: function() {
           jQuery('#message').text('We are sorry. There has been an error...');
        },
        success: function(data) {
            results=JSON.parse(data.data)['results'];
            institute=results[0]['last_known_institution']['display_name'];
            orcid = results[0]['orcid'];
            OpenAlexID=results[0]['id'].slice(21)
            
            console.log(institute, orcid, OpenAlexID);
            jQuery('#message').text('Are you working in  '+ institute +' ?');
            // confirm('Are you working in  '+ institute +' ?');
            fill_OpenAlex_table(OpenAlexID);
          
        }
      });
      }else{
        



        const data= new Object();
        data.action='get_OpenAlex_ID_from_ORCID';
        data.ORCID=orcid_num.replace(' ','-');
        jQuery.ajax({
            url:adminAjax.ajaxurl,
            method : 'POST',
            data,

            error: function() {
            jQuery('#message').text('We are sorry. There has been an error...');
            },
            success: function(data) {
                results=JSON.parse(data.data)['results'];
                institute=results[0]['last_known_institution'];
                orcid = results[0]['orcid'];
                OpenAlexID=results[0]['id'].slice(21)
                console.log(institute, orcid, OpenAlexID);
                jQuery('#message').text('Are you working in  '+ institute +' ?');
            
                fill_OpenAlex_table(OpenAlexID);
            }
        });
    }
    



    });
   
});


function replacerFunction(match){
  return(match.toLowerCase());
}

function fill_OpenAlex_table(OpenAlexID){
    

    insert_first_line();
    const data= new Object();
    data.action='get_OpenAlex_content';
    data.OpenAlexID=OpenAlexID;
    data.page=1;
    jQuery.ajax({
        url:adminAjax.ajaxurl,
        method: 'POST',
        data,
        dataType: "json",
        error: function() {
                jQuery('#message').text('Sorry... this ORCID  does not seem to be valid');

        },
        success: function(data) {
            
            
            var i=0;
            var publisher='';
            var editor='';
            var booktitle='';
            var extraInfo='';
            var ISBN='';
            var link='';
            var doi ='';
            var year = ' ';
            var abstract = ' ';
            var volume = ' ';
            var pages = ' ';
            var type = 'article';
            var journal ='';
            var title='';

            
            var pubs=JSON.parse(data.data)['results'];
            
            pubs.forEach(function(element, index){
                
                
                title=element.title;
                journal=element.alternate_host_venues[0].display_name
                year = element.publication_year.toString();
                
                doi=element.doi
                doi.replace('https://doi.org/', '');
                volume=element.biblio.volume;
                var authors ='';
                var authors_list=element.authorships;
                
                authors_list.forEach(function(aut,index){
                    if(index==0){
                        authors=aut.author.display_name;
                    }
                    else{
                        authors=authors+', '+aut.author.display_name;
                    }
                });

                var keywords ='';
                var keywords_list=element.concepts;   
                keywords_list.forEach(function(kw,index){
                    if (kw.level>0 && kw.score>0.2){
                        if(keywords.length==0){
                            keywords=kw.display_name;
                        }
                        else{
                            keywords=keywords+', '+kw.display_name;
                        }
                   }       
                });
            insert_table_line([title, authors, year, type, journal, doi, ISBN, volume, link, pages, keywords, publisher, editor, booktitle, abstract,extraInfo],index);
            } )

        }
    });
}