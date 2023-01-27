function check_all(){
  jQuery(':checkbox').each(function() {
      this.checked = true;
  });

}

function uncheck_all(){
  jQuery(':checkbox').each(function() {
      this.checked = false;
  });
}








// jQuery( document ).ready( function($) {
// $("input[id=acf-field_62018b55a4b21]").val('');
// $('input[name=acf[field_62018b55a4b21]]').val('newVal');
// $('input[name=field_62018b55a4b21]').val('newVal');
// document.getElementById("acf-field_62018b55a4b21").value = "tinkumaster";
// $("#acf-field_62018b55a4b21").val('');
// $("#acf-field_6288e365be005").val('');
// })
