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
      var pubmed_name=jQuery('#pubmed').val();

      if (pubmed_name.search(/[0-9]{4,}/g)==0){
          insert_first_line();

          inser_pubmed_line_table(pubmed_name);

        }else{

          var term=pubmed_name.replace(' ', '+');
          var pubmed_url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?&retmode=json&RetMax=200&term="+term;



          jQuery.ajax({
            url: pubmed_url,
            // data:{
            //   action:'parse_xml';
            // }
            crossDomain: true,
            dataType:"json",

            error: function() {
                    jQuery('#message').text('Sorry... this ORCID  does not seem to be valid');


            },
            success: function(return_data){

              insert_first_line();

              var idlist=return_data.esearchresult.idlist;

              idlist.forEach((item, id) => {
          
                  insert_pubmed_line_table(item,id);


              });


            }
          });




      }



    });
});









// https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=pubmed&rettype=abstract&id=29155816";
// 29155816
function insert_pubmed_line_table(PMCID,id){
  var pubmed_url_2 ="https://jsonplaceholder.typicode.com/todos/1";

  jQuery.ajax({
    url: adminAjax.ajaxurl,
    method:'POST',
    data:{action:"get_pubmed_informations", id:PMCID

    },

    error: function() {
      jQuery('#message').text('Wait...');
      insert_pubmed_line_table(PMCID,id)


    },
    success: function(data) {

      jQuery('#message').text('Done !');
      var publisher='';
      var editor='';
      var booktitle='';
      var extraInfo='';
      var ISBN='';
      var link='';
      var doi ='';
      var year = ' ';
      var abstract = ' ';
      var keywords = ' ';
      var volume = ' ';
      var pages = ' ';
      var type = 'article';
      var journal ='';
      var author ='';


      var article = data.data.PubmedArticle.MedlineCitation.Article
      
      if(article.ELocationID!=undefined){
        doi=article.ELocationID;
      }

      var title=article.ArticleTitle;
      volume=article.Journal.JournalIssue.Volume;
      if (article.Pagination){
          page= article.Pagination.MedlinePgn;
      }

      journal=article.Journal.Title;
      if (article.Abstract){
          abstract=article.Abstract.AbstractText;
      }

      year = article.Journal.JournalIssue.PubDate.Year;
      var authors= article.AuthorList.Author;
      ISBN =article.Journal.ISSN;

      if (typeof(abstract)==='object'){
        abstract=JSON.stringify(abstract);
      };

      

      key=data.data.PubmedArticle.MedlineCitation.MeshHeadingList;

      if (key){
        keywords=[]

        key.MeshHeading.forEach((item, i) => {
          
          keywords.push(item.DescriptorName)

        });

          keywords=keywords.join(', ');
      }



      auth=[];
      authors.forEach((item, i) => {
        if (item.LastName && item.ForeName){
          auth.push(item.LastName+' '+item.ForeName);
        }



      });


      author=auth.join(', ');
      
      
        insert_table_line([title, author, year, type, journal, doi, ISBN, volume, link, pages, keywords, publisher, editor, booktitle, abstract,extraInfo],id);
    }
  });










}
