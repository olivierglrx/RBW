// The parsing_bib  function does the principal job.
// It is called when user clik on 'add all' button or when user insert a '.bib'




//  ON CLICK, the table parsing is created.
jQuery( "#bouton" ).on("click", function() {
     var  inputVal_non_trim =document.getElementById('bib').value;
     parsing_bib(inputVal_non_trim);
   }); //end of jquery function







function decapitalize_keyword(bib_text){
  var  inputVal_non_trim =document.getElementById('bib').value;
  inputVal=inputVal_non_trim.trim();
  const regex=/([A-Za-z])+ *\=/g;
  c=inputVal.replace(regex, replacerFunction)
  return(c)
}
function replacerFunction(match){
  return(match.toLowerCase());
}




function parsing_bib(str){

  jQuery("#myTable > tbody").html("");
  jQuery("#myTable > thead").html("");
  var  inputVal_non_trim =str;

  inputVal_d=inputVal_non_trim.trim();
  // putting all text to lower case to avoid parsing error
  // inputVal=inputVal.toLowerCase();
  inputVal=decapitalize_keyword(inputVal_d);

  insert_first_line();

  // split every entry using the @  character
  inputVal_entries=inputVal.split(/[@]/);
  //looping through all entry in the textarea
  id=0
  inputVal_entries.forEach(function(item){

    if (item.length>10){
      id=id+1

      x1='@'+item; // @ needed for parsing
      x=cleaning_the_bib(x1);  //  accentuation problem

      // This is where the parsing really starts. bibtexParse is a function created not by me.
      // It returns a Javascript Object with the following format :
      // label_in_bib : value_in_bib

        parse=bibtexParse.toJSON(x)[0]["entryTags"];

        list_of_data_to_insert=[];
        for (num in list_of_entry){
          entry=list_of_entry[num];

          if (entry=='Type'){
            firstparenthesis=item.indexOf('\{');
            list_of_data_to_insert.push(item.substring(0,firstparenthesis))
          }
          else if(entry=='Authors'){
            list_of_data_to_insert.push(clean_authors_list(parse['author']));
          }

          else if(entry=='Link'){
            var link='';
            if(parse['link']){
              var link = parse['link'];
            }
            if(parse['url']){
              var link = parse['url'];
            }
            if(parse['pmcid']){
              var link= 'https://www.ncbi.nlm.nih.gov/pmc/articles/'+parse['pmcid'];
            }
            list_of_data_to_insert.push(link);

          }
          else if(entry=='Keywords'){
            var keywords='';
            if(parse['keywords']){
              keywords = parse['keywords'];
              keywords=keywords.replaceAll(';',',');
            }
            list_of_data_to_insert.push(keywords);

          }
          else if(entry=='Publisher'){
            var publisher='';
            if(parse['publisher']){
              var publisher = parse['publisher'];
              if(parse['address']){
                publisher = publisher+' ('+parse['address']+')'
              }


            }
            list_of_data_to_insert.push(publisher);
          }
          else{
            entry_min=entry.toLowerCase();
            if (parse[entry_min]){

              list_of_data_to_insert.push(parse[entry_min]);
            }
            else{

              list_of_data_to_insert.push('');
            }

          }

        }
      insert_table_line(list_of_data_to_insert,id)
    } // end of if
  }); //end of forEach

}


//
function cleaning_the_bib(str){
  x=str.replaceAll('\\\'\{o\}','ó').replaceAll('\\\"\{\\i\}\}','ï').replaceAll('\\\'\{E\}','É').replaceAll('\{\\\'e\}', '\u00e9').replaceAll('\\\'e','é').replaceAll('\\^\{\\i\}', 'î').replaceAll('\\\^i', 'î').replaceAll('\\\'\{e\}', 'é').replaceAll('\\\'a','á').replaceAll('\{\\c\{c\}\}','ç')
  .replaceAll('\\beta','ss').replaceAll('\$','').replaceAll('\\\"i','ï').replaceAll('\{\\\~n\}','ñ').replaceAll('\\\'o','ó')
  .replaceAll('\\\`e','è').replaceAll('\{\\\"o\}','ö').replaceAll('\\\"o','ö').replaceAll('\\\'o','ó').replaceAll('\\\"\{a\}','ä').replaceAll('\{\\\"a}','ä').replaceAll('\\\"a','ä')
  .replaceAll('\\\"\{e\}','ë').replaceAll('\\\'E','É').replaceAll('\{H\}','H').replaceAll('\{B\}','B').replaceAll('\{b\}','b')
  .replaceAll('\{c\}','c')
  .replaceAll('\{d\}','d')
  .replaceAll('\{e\}','e')
  .replaceAll('\{f\}','f')
  .replaceAll('\{g\}','g')
  .replaceAll('\{h\}','h')
  .replaceAll('\{i\}','i')
  .replaceAll('\{j\}','j')
  .replaceAll('\{k\}','k')
  .replaceAll('\{l\}','l')
  .replaceAll('\{m\}','m')
  .replaceAll('\{n\}','n')
  .replaceAll('\{o\}','o')
  .replaceAll('\{p\}','p')
  .replaceAll('\{q\}','q')
  .replaceAll('\{r\}','r')
  .replaceAll('\{s\}','s')
  .replaceAll('\{t\}','t')
  .replaceAll('\{u\}','u')
  .replaceAll('\{v\}','v')
  .replaceAll('\{w\}','w')
  .replaceAll('\{x\}','x')
  .replaceAll('\{y\}','y')
  .replaceAll('\{z\}','z')
  .replaceAll('\{A\}','A')
.replaceAll('\{B\}','B')
.replaceAll('\{C\}','C')
.replaceAll('\{D\}','D')
.replaceAll('\{E\}','E')
.replaceAll('\{F\}','F')
.replaceAll('\{G\}','G')
.replaceAll('\{H\}','H')
.replaceAll('\{I\}','I')
.replaceAll('\{J\}','J')
.replaceAll('\{K\}','K')
.replaceAll('\{L\}','L')
.replaceAll('\{M\}','M')
.replaceAll('\{N\}','N')
.replaceAll('\{O\}','O')
.replaceAll('\{P\}','P')
.replaceAll('\{Q\}','Q')
.replaceAll('\{R\}','R')
.replaceAll('\{S\}','S')
.replaceAll('\{T\}','T')
.replaceAll('\{U\}','U')
.replaceAll('\{V\}','V')
.replaceAll('\{W\}','W')
.replaceAll('\{X\}','X')
.replaceAll('\{Y\}','Y')
.replaceAll('\{Z\}','Z')
.replaceAll('\\^\\i','î')
.replaceAll('\{\\\"\\i}','ï')
.replaceAll('\{é\}','é')
.replaceAll('\{\\`\{a\}}','à')
.replaceAll('\{\\\"e\}','ë')
.replaceAll('\{\\\^e\}','ê')
.replaceAll('\{\\i\}','ï')
.replaceAll('\{\\\`a\}','à')
.replaceAll('\{\\\'\\i}','ì')
.replaceAll('\{\\c\{c\}\}','ç')
.replaceAll('\{ó\}','ó');








  return(x);

}


function Capitalize_first_letter(str){
  if (str){
    nameCapitalized = str.charAt(0).toUpperCase() + str.slice(1)
    return (nameCapitalized)
  }
  else{
    return(' ')
  }
}



function capitalize(str){

  if(str){
  x=str.replace(/,/g,' ');

  y=x.replace(/\s\s+/g, ' ');

  List_of_name=y.split(' and ');

  string='';

  List_of_name.forEach(item=>{

      const name=item.split(' ');
      string_name='';


      name.forEach(item=> {
        string_name=string_name+Capitalize_first_letter(item)+' '

      });
      x=string_name.substring(0,string_name.length-1);
      string=string+x+', ' ;

  });

    x=string.substring(0,string.length-2);
    // console.log(x);
  var x1=x.replace(' ,',',');
  x2=x1.replace(/\s\s+/g, ' ');
  // x3=x2.substring(0,x2.length-1);

  return(x2)

}
else{
  return(' ')
}
}




// Jquery for (un-)checking checkbox
jQuery( "#add_all" ).click(function(event){

  jQuery(':checkbox').each(function() {
    if(this.checked){
      this.checked = false;
    }else{
      this.checked = true;
    }

  });
});


// jQuery for styling the drag and drop. It does not do any parsing.
var $fileInput = jQuery('.file-input');
var $droparea = jQuery('.file-drop-area');

// highlight drag area
$fileInput.on('dragenter focus click', function() {
  $droparea.addClass('is-active');
});

// back to normal state
$fileInput.on('dragleave blur drop', function() {
  $droparea.removeClass('is-active');
});

// change inner text
$fileInput.on('change', function() {
  var filesCount = jQuery(this)[0].files.length;
  var $textContainer = jQuery(this).prev();

  if (filesCount === 1) {
    // if single file is selected, show file name
    var fileName = jQuery(this).val().split('\\').pop();
    $textContainer.text(fileName);
  } else {
    // otherwise show number of files
    $textContainer.text(filesCount + ' files selected');
  }
});


function clean_authors_list(authors_str){
  var regex = / and /g;
  if (authors_str.match(regex)!=null){
    aut=authors_str.replaceAll(',', '');
    x=aut.split(' and')
    return(x.join(','));
  }

  var regex = /[a-zA-Z]\, [a-zA-Z]/g;
  if (authors_str.match(regex)!=null){
    aut=authors_str.replaceAll(',', '');
    return(aut);
  }




  return(authors_str);


}
