// The parsing_bib  function does the principal job.
// It is called when user clik on 'add all' button or when user insert a '.bib'



let list_of_entry=['Title', 'Authors', 'Year', 'Type', 'Journal','DOI','ISBN', 'Volume', 'Link', 'Pages', 'Keywords', 'Publisher', 'Editor','Booktitle','Abstract','extra-info'];
let list_plus_checkbox=['Checkbox'].concat(list_of_entry);
let max_visible_input=4;

function insert_first_line(){
  // Create the head of the publications table.
  //
  table=document.getElementById('myTable')
  if (table.style.display=='none'){
    document.getElementById('myTable').style.display = "block";
    document.getElementById('button_container').style.display = "flex";

  }
  var theadRef = document.getElementById('myTable').getElementsByTagName('thead')[0];

  var newRow = theadRef.insertRow();
  i=0;
  list_plus_checkbox.forEach(item => {
    if (i<max_visible_input){
      newRow.insertCell().outerHTML = "<th>"+item +"</th>";
    }
    i++;
  });

}

function insert_table_line(Data_list,id){
  // find the index of the  row with the good year. 
  var year =Data_list[2];
  var tbodyRef = document.getElementById('myTable').getElementsByTagName('tbody')[0];

  // choose the good line to insert according to d
  var x=tbodyRef.getElementsByTagName('tr')
  i=0
  if (x[0]!=undefined){
    i=0
    table_year=Number(x[i].getElementsByTagName('td')[3].innerText)
    while (i< x.length && year<table_year ){
      i++;
      if (i< x.length){
        table_year=Number(x[i].getElementsByTagName('td')[3].innerText)
      }  
    }

  }

    // Insert the cells  in the row with parsing value in the list of entry
    // Data_list is the list of parsed value.
    // it has to be ordered with the same order as the list_of_entry.

  // Insert the checkbox
  var year =Data_list[2];
  
  var newRow = tbodyRef.insertRow(i);
  var newCell = newRow.insertCell();
  var check = document.createElement("input");
  check.setAttribute("type", "checkbox");
  check.setAttribute("name", "checkbox");
  check.setAttribute("checked", "checked")
  check.setAttribute("id", id);
  newCell.appendChild(check)

  i=0

  Data_list.forEach(item => {
    
    if (typeof(item)=='undefined'){
      item='';
    }
    var newCell = newRow.insertCell();
    if (typeof(item)!='string'){
      item='';
    }
    item =item.replaceAll('\{','').replaceAll('\}','');
    item =item.replaceAll('\\','');
    item =item.replaceAll('"','');

    // newText = document.createTextNode(item);
    // newCell.appendChild(item);
    
    if (i<max_visible_input-1){
      newCell.setAttribute("class", list_of_entry[i]);
      newCell.setAttribute("id", list_of_entry[i]+id);
    }
    else{
      newCell.setAttribute("class", list_of_entry[i]);
      newCell.setAttribute("style", "display:none");
      newCell.setAttribute("id", list_of_entry[i]+id);
    }
    const entry=document.getElementById(list_of_entry[i]+id);

    entry.innerHTML+=item;

    i=i+1
  });


}


function toggle_all(){
  jQuery(':checkbox').each(function() {
    if(this.checked){
      this.checked = false;
    }else{
      this.checked = true;
    }
  });
}
