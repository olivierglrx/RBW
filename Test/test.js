// jQuery( document ).ready( function($) {


//     function autocomplete(inp, arr) {
    
//       /*the autocomplete function takes two arguments,
//       the text field element and an array of possible autocompleted values:*/
//       var currentFocus;
//       /*execute a function when someone writes in the text field:*/
//       inp.addEventListener("input", function(e) {
    
//           var a, b, i, val = this.value;
//           first='';
//           if (val.indexOf(',') > -1) { list=val.split(',')
//           first = list.slice(0,-1).join(',');
    
//           val=list[list.length-1];
//           val=val.trim();
//            }
//            val=val.trim();
    
    
//           /*close any already open lists of autocompleted values*/
//           closeAllLists();
//           if (!val) { return false;}
//           currentFocus = -1;
//           /*create a DIV element that will contain the items (values):*/
//           a = document.createElement("DIV");
//           a.setAttribute("id", this.id + "autocomplete-list");
//           a.setAttribute("class", "autocomplete-items");
//           /*append the DIV element as a child of the autocomplete container:*/
//           this.parentNode.appendChild(a);
//           /*for each item in the array...*/
    
//           for (i = 0; i < arr.length; i++) {
//             /*check if the item starts with the same letters as the text field value:*/
    
//             if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
    
//               /*create a DIV element for each matching element:*/
//               b = document.createElement("DIV");
    
//               /*make the matching letters bold:*/
//               b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
    
//               b.innerHTML += arr[i].substr(val.length);
//               /*insert a input field that will hold the current array item's value:*/
//               b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
//               /*execute a function when someone clicks on the item value (DIV element):*/
//               b.addEventListener("click", function(e) {
//                   /*insert the value for the autocomplete text field:*/
//                   mot=this.getElementsByTagName("input")[0].value;
//                   if (first=='')
//                     inp.value= mot +', ';
//                   else
//                     inp.value=first+', ' + mot+', ';
//                   /*close the list of autocompleted values,
//                   (or any other open lists of autocompleted values:*/
//                   closeAllLists();
//               });
//               a.appendChild(b);
//             }
//           }
//       });
//       /*execute a function presses a key on the keyboard:*/
//       inp.addEventListener("keydown", function(e) {
    
//           var x = document.getElementById(this.id + "autocomplete-list");
//           if (x) x = x.getElementsByTagName("div");
//           if (e.keyCode == 40) {
//             /*If the arrow DOWN key is pressed,
//             increase the currentFocus variable:*/
//             currentFocus++;
//             /*and and make the current item more visible:*/
//             addActive(x);
//           } else if (e.keyCode == 38) { //up
//             /*If the arrow UP key is pressed,
//             decrease the currentFocus variable:*/
//             currentFocus--;
//             /*and and make the current item more visible:*/
//             addActive(x);
//           } else if (e.keyCode == 13) {
//             /*If the ENTER key is pressed, prevent the form from being submitted,*/
//             e.preventDefault();
//             if (currentFocus > -1) {
//               /*and simulate a click on the "active" item:*/
//               if (x)
    
//               mot=x[currentFocus].getElementsByTagName('input')[0].value;
//               if (first=='')
//                 inp.value= mot +', ';
//               else
//                 inp.value=first+', ' + mot+', ';
    
//               closeAllLists();
    
//             }
//           }
//       });
    
    
//       function addActive(x) {
//         /*a function to classify an item as "active":*/
//         if (!x) return false;
//         /*start by removing the "active" class on all items:*/
//         removeActive(x);
//         if (currentFocus >= x.length) currentFocus = 0;
//         if (currentFocus < 0) currentFocus = (x.length - 1);
//         /*add class "autocomplete-active":*/
//         x[currentFocus].classList.add("autocomplete-active");
//       }
//       function removeActive(x) {
//         /*a function to remove the "active" class from all autocomplete items:*/
//         for (var i = 0; i < x.length; i++) {
//           x[i].classList.remove("autocomplete-active");
//         }
//       }
//       function closeAllLists(elmnt) {
//         /*close all autocomplete lists in the document,
//         except the one passed as an argument:*/
//         var x = document.getElementsByClassName("autocomplete-items");
//         for (var i = 0; i < x.length; i++) {
//           if (elmnt != x[i] && elmnt != inp) {
//             x[i].parentNode.removeChild(x[i]);
//           }
//         }
//       }
//       /*execute a function when someone clicks in the document:*/
//       document.addEventListener("click", function (e) {
//           closeAllLists(e.target);
//       });
//     }
    
//     /*An array containing all the country names in the world:*/
    
//     var publication_tags = test_localise.pub_tags;
//     // console.log(publication_tags);
//     /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
//     if(document.getElementById("acf-field_620035f37484f"))
//     autocomplete(document.getElementById("acf-field_620035f37484f"), publication_tags);
//     if(document.getElementById("rbw_search_input"))
//     autocomplete(document.getElementById("rbw_search_input"), publication_tags);
//     // autocomplete(document.getElementById("myInput"), countries);
//     if(document.getElementById("myInput"))
//     autocomplete(document.getElementById("myInput"), publication_tags);
//     });
    



 







function is_member_in_team(search){
  val=search.trim().toLowerCase();
  var teams = test_localise.team_array;
  list_of_good_teams=[]
  for(team in teams) {
    members=teams[team]
    for (let member of members){
      member=member.toLowerCase();
      if (member.includes(search))
      list_of_good_teams.push(team)     
    }
  }
  
  return(list_of_good_teams)
};

jQuery( document ).ready( function($) {
  function select_team_by_member(inp) {
    inp.addEventListener("input", function(e) {
      var  val = this.value;
      list_of_good_teams=is_member_in_team(val);
      var list = document.getElementsByClassName("teams");
      for (let item of list) {
        team_name=item.getElementsByClassName("team_name")[0].textContent.trim();
        console.log(team_name)
        if(list_of_good_teams.includes(team_name)){
                  item.style.display="block";
                  item.style.position="relative";
          }else{
              item.style.display="none";       
          }
      } 
  });
  };
  if (!(document.getElementById('rbw_search_team_input')==null)){
    select_team_by_member(document.getElementById('rbw_search_team_input'));
}
  
});


















jQuery( document ).ready( function($) {


  function autocomplete_2(inp, arr) {
      /*the autocomplete function takes two arguments,
      the text field element and an array of possible autocompleted values:*/
      var currentFocus;
      /*execute a function when someone writes in the text field:*/
      inp.addEventListener("input", function(e) {
          var a, b, c, i, val = this.value.toLowerCase();
          /*close any already open lists of autocompleted values*/
          closeAllLists();
          if (!val) { return false;}
          currentFocus = -1;
          /*create a DIV element that will contain the items (values):*/
          a = document.createElement("DIV");
          a.setAttribute("id", this.id + "autocomplete-list");
          a.setAttribute("class", "autocomplete-items");
          /*append the DIV element as a child of the autocomplete container:*/
          this.parentNode.appendChild(a);
          /*for each item in the array...*/
          for (type in arr) {
            c=document.createElement("p");
            c.innerHTML='<strong style="margin:3px; padding:3px;">'+type.charAt(0).toUpperCase()+type.slice(1)+'</strong>';
            a.appendChild(c);
            for(let post of arr[type].slice(0,10)){
            
              /*check if the item starts with the same letters as the text field value:*/
              if (post.toLowerCase().includes(val)) {
                index=post.toLowerCase().indexOf(val);
                
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                
                b.innerHTML+= post.substr(0,index);
                b.innerHTML += "<strong>" + post.substr(index,val.length) + "</strong>";
                b.innerHTML += post.substr(index+val.length);
                b.innerHTML += "<input type='hidden' value='" + post + "'>";
                /*insert a input field that will hold the current array item's value:*/
                
                /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                c.appendChild(b);
                
              }
            }
          }
      });


      /*execute a function presses a key on the keyboard:*/
      inp.addEventListener("keydown", function(e) {
        
          var x = document.getElementById(this.id + "autocomplete-list");
          if (x) x = x.getElementsByTagName("div");
          if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
          } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
          } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            // e.preventDefault();
            if (currentFocus > -1) {
              /*and simulate a click on the "active" item:*/
              if (x) x[currentFocus].click();
              hide_member();
            }
          }
      });
      function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
      }
      function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
          x[i].classList.remove("autocomplete-active");
        }
      }
      function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
          if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
        hide_member();
        
    });
    }

  
if (document.getElementById("rbw_search_input")){
autocomplete_2(document.getElementById("rbw_search_input"), test_localise.list_of_posts_titles);
console.log('autcomplete_2', test_localise.list_of_posts_titles);
}





});