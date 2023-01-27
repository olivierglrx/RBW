function test(){

  console.log(jQuery(':checkbox').length);
}

function parse_zotero(){
  send_message('Request Send - wait...');
  var zot_id=document.getElementById('zot_id').value;
  var zot_key=document.getElementById('zot_key').value;
  // https://api.zotero.org/users/2516597/items/?key=kqtBWHNqnVledNP7p7yuQ2eD&limit=100

  var firstline=0;
  var start=0;
  var length=100;
  var id=1;
  var compteur=0;

  while (length==100 && compteur<25){
    console.log(start);
    start=start+length;
    compteur++;

    base_url='https://api.zotero.org/users/'+zot_id+'/items/?key='+zot_key+'&limit=100'+'&start='+start;
    jQuery.ajax({
    url : base_url,

        success : function( return_data ) { // en cas de requête réussie
          start=start+length;

          send_message('');
          if (firstline==0){
              insert_first_line();
              firstline=1;
          }




          return_data.forEach(function(element,index){
          if ('creators' in element.data){
            data=element.data;

            var title=data.title
            var authors=''
            data.creators.forEach(function(author){
              authors=authors+ author.firstName +' ' +author.lastName+', '
            })


            var year    =data.date.match(/\d{4}/)[0];
            var type    =data.itemType;
            var journal =data.publicationTitle;
            var DOI     =data.DOI;
            var ISBN    =data.ISSN;
            var volume  =data.volume;
            if (data.url!=''){
              var link  =data.url;
            }else{
              var link  ='https://doi.org/'+data.DOI;
            }
            var pages   = data.pages;
            var keywords='';
            data.tags.forEach(function(tag){
              keywords=keywords+ tag.tag+' ; '
            })

            var publisher='';
            var editor   ='';
            var booktitle='';
            var abstract =data.abstractNote;
            var extra    =data.extra

            insert_table_line([title, authors, year, type, journal,DOI,ISBN, volume, link,
             pages, keywords, publisher, editor, booktitle,abstract,extra],id);
            id++;


          }

         });

        },
        error : function( data ) {
          send_message('There has been an error, are you sure of your ID and key ? ');

        }
       });





  }


}

function send_message(message){
  jQuery('#message').text(message);
}
