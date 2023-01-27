// change inner text
jQuery( document ).ready(function($) {
  var $fileInput = $('.file-input');
  var $droparea = $('.file-drop-area');
  $fileInput.on('change', function() {
    var filesCount = $(this)[0].files.length;
    var $textContainer = $(this).prev();

    if (filesCount === 1) {
    ;
    // if single file is selected, show file name
    var fileName = $(this).val().split('\\').pop();
    $textContainer.text(fileName);
    } else {
    // otherwise show number of files
    $textContainer.text(filesCount + ' files selected');
    }
  });   
  
});





jQuery(document).ready(function($){
  $('#bib').bind('input propertychange', function() {
    x=document.getElementById("bib").value;
    parsing_bib(x);
  });
})




//  Parsing using the drag and drop action.
window.onload = function(event) {
     document.getElementById('file').addEventListener('change', handleFileSelect, false);
   }
   function handleFileSelect(event) {
     var fileReader = new FileReader();

     fileReader.onload = function(event) {
       // it takes out all text before the first @ inside the bib.
       firsta=event.target.result.indexOf('@');
       x=event.target.result.substring(firsta);
       // Write the content of the bib in the textarea
       document.getElementById("bib").value=x;
       // and parse it.
       parsing_bib(x);
     }
     var file = event.target.files[0];
     fileReader.readAsText(file);
   }



