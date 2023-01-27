<?php
add_action('admin_menu', 'add_submenu_for_csv');
function add_submenu_for_csv() {
  add_submenu_page('edit.php?post_type=member', //Parent slug
    'Add_by_csv', // page title
    'Add by csv', // Menu label
    'manage_options', // capability
    'Add_by_csv',// slug
    'member_by_csv',//function to call -> /arxiv/index_arxiv.php
    );
} 


function register_member_csv(){
// Loop through checkbox to see if checked
  for ($i = 0; $i <= 100; $i++) {
    $name='checkbox'.strval($i);
    // if checkbox is checked :
    if (isset($_POST[$name])){

      $args = array(
        'post_type' => 'member',
        'post_status' => 'publish',
        'post_title'=>$_POST['LastName'.strval($i)],
      );
      $inserted_post_id = wp_insert_post( $args );

      // ACF FIELD


      update_field('member_first_name', $_POST['FirstName'.strval($i)], $inserted_post_id );
      update_field('member_last_name', $_POST['LastName'.strval($i)], $inserted_post_id);
      update_field('member_email', $_POST['Email'.strval($i)], $inserted_post_id);
      update_field('member_affiliation', $_POST['Affiliation'.strval($i)], $inserted_post_id);
      update_field('member_short_description', $_POST['Bio'.strval($i)], $inserted_post_id);

          // TAXONOMIES
        if(isset($_POST['statut'.strval($i)])){
wp_insert_term( $_POST['statut'.strval($i)], 'member_status_tax');
wp_set_post_terms( $inserted_post_id,$_POST['statut'.strval($i)],  'member_status_tax',  true );
update_field('member_status_tax', $_POST['statut'.strval($i)], $inserted_post_id);
wp_set_object_terms( $inserted_post_id,$_POST['statut'.strval($i)],  'member_status_tax',  true );

        }
        else{

          wp_set_object_terms( $inserted_post_id, '',  'member_status_tax',  true );
        }

// send_email_member($inserted_post_id);

  echo($_POST['LastName'.strval($i)].' have been successfully added to your list of members </br>');
    }

}
$_POST = array();
}







function member_by_csv(){



  echo '<h1>Input a csv </h1>';
  echo' FORMAT  : $$$ last name -- first name -- mail -- statut -- affiliation -- bio';
  echo ' <div class="wrap">';
    csv_form();
  echo '</div>';
  if ( isset($_POST['validate'])){
    register_member_csv();
    $_POST = array();
  }

}


function csv_form() {
?>
<!-- HTML CONTENT -->
<div class='rb-container'>
    <div class="file-drop-area">
      <span class="fake-btn">Choose file</span>
      <span class="file-msg">Drag and drop file</span>
      <input id='file' class="file-input" type="file" multiple>
    </div>
    <textarea id='bib' name="Text1" cols="50" rows="5" placeholder="Or copy paste a bibtex entry"></textarea>
</div>

<div style='display:flex;'>
<div>
  <label for="file" class="custom-file-upload" style='border: 1px solid black;
  border-radius: 5px;
    display: inline-block;
    padding: 5em 6em;
    font-size: large;
    text-align: center;
    cursor: pointer;'>
      Clik here to upload your file </br>(.txt, .csv)
  </label>
  <!-- <input id="file-upload" type="file" style='display: none;'/> -->


<input type="file"
       id="file" name="avatar" style='display: none;'
       >
</div>
<div>
    <textarea id='bib' name="Text1" cols="60" rows="10" >

      $$$ last name -- first name -- mail -- statut -- affiliation -- bio
    </textarea>

    <button id='bouton'>Parse</button>
  </div>
</div>

<!-- Create the form. Since display:none  it does not show before click on Parse.-->
  <div class='rb-container'>
    <form class=""  method="post">
      <table id="myTable"  style="display:none;">
        <tbody>
        </tbody>
      </table>
      <input id='send_button' type="submit" name="validate" value="Add Members " style="display:none;">
    </form>
    </br>
    <button id='add_all' style="display:none;">Toggle All</button>
  </div>

<!-- SCRIPT PARSER -->
<script>
function insert_first_line_in_table(Data_list){
  var tbodyRef = document.getElementById('myTable').getElementsByTagName('tbody')[0];
  // Insert a row at the end of table
  var newRow = tbodyRef.insertRow();
  // Insert a cell at the end of the row
  Data_list.forEach(item => {
    var newCell = newRow.insertCell();
    // Append a text node to the cell
    var newText = document.createTextNode(item);
    newCell.appendChild(newText);
  });
}




function insert_data_in_table(Data_list,id){
  var tbodyRef = document.getElementById('myTable').getElementsByTagName('tbody')[0];

  // Insert a row at the end of table
  var newRow = tbodyRef.insertRow();

  // Insert the checkbox cell in the row
  var newCell = newRow.insertCell();
  var check = document.createElement("input");
  check.setAttribute("type", "checkbox");
  check.setAttribute("name", "checkbox"+id);
  check.setAttribute("checked", "checked");
  newCell.appendChild(check)

  i=0
    // Insert the cells  in the row with parsing value in the list of entry
    // Data_list is the list of parsed value.
    // it has to be ordered as the list_of_entry.
  list_of_entry=['Last Name', 'First Name', 'Email','statut','Affiliation', 'Bio']
  Data_list.forEach(item => {
var newCell = newRow.insertCell();
var input_value = document.createElement("input");
input_value.setAttribute("type", "text");
input_value.setAttribute("value", item);
str = list_of_entry[i].replace(/\s/g, '');
input_value.setAttribute("name", str+id);
input_value.setAttribute("class", list_of_entry[i]);
if (list_of_entry[i]!='Abstract'){
input_value.setAttribute("style", "border:0px");
}
else{
  input_value.setAttribute("style", "display:none");
}
newCell.appendChild(input_value)
i=i+1
  });


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

window.onload = function(event) {
     document.getElementById('file').addEventListener('change', handleFileSelect, false);
   }

   function handleFileSelect(event) {
     var fileReader = new FileReader();
     fileReader.onload = function(event) {
       console.log(event.target.result.split(/[$$$]/));
       input=event.target.result.split(/[$$$]/);

       insert_in_table(input);
     }
     var file = event.target.files[0];
     fileReader.readAsText(file);
   }




//  ON CLICK, the table parsing is created.
jQuery( "#bouton" ).on("click", function() {

  // delete pre - existing line
  jQuery("#myTable").find("tr:gt(0)").remove();
  // get the content of the textarea
  var  inputVal =document.getElementById('bib').value;
 // putting all text to lower case to avoid parsing error
  inputVal=inputVal.toLowerCase();
  // split every entry using the @  character
  inputVal_entries=inputVal.split(/[$$$]/);

insert_in_table(inputVal_entries);



}); //end of jquery function

function insert_in_table(inputVal){
  //looping through all entry in the textarea
  id=0
  inputVal.forEach(function(item){

    if (item.length>10){

      if(id==0){
        // create and display table first line
        table=document.getElementById('myTable')
        if (table.style.display=='none'){
          document.getElementById('myTable').style.display = "block";
          document.getElementById('send_button').style.display = "block";
          document.getElementById('add_all').style.display = "block";
          // inserting the first row
          insert_first_line_in_table([ 'Check to add','Last name', 'First Name', 'Email','statut','Affiliation', 'Bio'])
        }
      }


      id=id+1

      x1='@'+item.replace('\{\\\'e\}', '\u00e9'); // @ needed for parsing and  accentuation problem
      x=x1.replaceAll('\\\'e','é').replaceAll('\\^\{\\i\}', 'î').replaceAll('\\\^i', 'î').replaceAll('\\\'\{e\}', 'é').replaceAll('\\\'a','á').replaceAll('\{\\c\{c\}\}','ç')
      .replaceAll('\\beta','ss').replaceAll('\$','').replaceAll('\\\"i','ï').replaceAll('\{\\\~n\}','ñ').replaceAll('\\\'o','ó')
      .replaceAll('\\\`e','è').replaceAll('\\\"o','ö');


      L=item.split(/\-\-/);




        var Last_Name = capitalize(L[0].replace(/\{/g, '').replace(/}/g, ''));
        var First_Name =capitalize(L[1]);
        var Email = L[2];
        var Statut = L[3];
        var Affiliation = L[4];
        var Bio =L[5];




      //actually insert the data inside the table
      insert_data_in_table([Last_Name, First_Name, Email,Statut,Affiliation, Bio],id);
    } // end of if
  }); //end of forEach


}



jQuery( "#add_all" ).click(function(event){

        jQuery(':checkbox').each(function() {
          if(this.checked){
            this.checked = false;
          }else{
            this.checked = true;
          }

        });
    });








</script>

<?php
}
