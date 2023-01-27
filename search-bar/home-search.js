jQuery( document ).ready( function($) {



    val= `<div id="search-page" style="position: absolute; transform :translate(-150%); z-index:100;">
            <div id="closingX"  style="border: 10px solid transparent; display: inline-block; position: absolute; height: 30px; top: 1em; ">
                <p style="border: 2px solid black; display: inline-block; position: absolute; height: 30px;  transform: rotate(45deg);">  </p>
                <p style="border: 2px solid black; display: inline-block; position: absolute; height: 30px; transform: rotate(-45deg);">  </p>
            </div>
            <input id="home-search-input" type="text" name="home-search" style="margin-top: 2em;margin-left: 2em; width: 50%; top: 1em; height: 100px; font-size:44px;" placeholder="Search..."  />
            <div id='searching-results'>
            </div>
        </div>
    </div>
    <style type="text/css">
        #search-page{
        display: block;
        background-color: white;
        height: 100%;
        transition: transform 0.7s;
        }
    </style>
    `




section=document.getElementsByTagName('body');

sec=section[0];

sec.insertAdjacentHTML("afterbegin",val)


if (document.getElementById("rb-search")!=null){
    document.getElementById("rb-search").addEventListener("click", function() {
        lateral_bar=document.querySelectorAll('[data-id="58f4e74b"]');
        lat_bar=lateral_bar[0];
        w_lat_bar=lat_bar.offsetWidth;
        console.log('largeur lat bar', w_lat_bar)
        document.getElementById("search-page").style.transform = "translate("+w_lat_bar+"px)"
    
            width=sec.offsetWidth;
            console.log('largeur body', width)

            document.getElementById("search-page").style.width=width-w_lat_bar+'px';
            width2=width-w_lat_bar-50
            document.getElementById("closingX").style.left=width2+'px';

    })
    document.getElementById("closingX").addEventListener("click", function() {
    document.getElementById("search-page").style.transform = "translate(-150%)";
    // document.getElementById("search-page").style.zIndex = "0"
    })

}  


});






jQuery( document ).ready( function($) {
    
   

    function searching(inp, search_data) {
        
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            closeAllLists();
            var a, b,c, i, val = this.value.toLowerCase();
            /*close any already open lists of autocompleted values*/
          
            if (!val) { return false;}
            currentFocus = -1;
            
            res_div=document.getElementById('searching-results');
            
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "rbw-autocomplete-list");
            a.setAttribute("class", "rbw-autocomplete-items");
            
            /*append the DIV element as a child of the autocomplete container:*/
            
            
            // this.parentNode.appendChild(a);
            /*for each item in the array...*/
            // res_div.appendChild(res_div);
           

            console.log('search data', search_data);
            const data= new Object();
            data.action='home_search';
            data.search_value=val;
            console.log(adminAjax.ajaxurl);
            jQuery.ajax({
                url:adminAjax.ajaxurl,
                 method : 'POST',
                  data,

             error: function() {
                jQuery('#message').text('We are sorry. There has been an error...');
             },
             success: function(data) {
                
                console.log('ajaxcall',data.data);

        }
      });
    
    




      console.log('search-data home_search by php ', searchdata.home_search);
      search_data_php=searchdata.home_search;
      for (type in search_data_php) {
          console.log(type);
          
          c=document.createElement("p");
          c.setAttribute("class", "rbw-search-results");
          quantity=0
          
          for(let post of search_data_php[type]){
             search_field=post[0]
         
          
            /*check if the item starts with the same letters as the text field value:*/
            if (search_field && search_field.toLowerCase().includes(val)) {
              if(quantity==0){
                  c.innerHTML='<strong style="margin:3px; padding:3px;">'+type.charAt(0).toUpperCase()+type.slice(1)+'</strong>';
                  a.appendChild(c);
                  quantity=1;
              }
              index=search_field.toLowerCase().indexOf(val);
              console.log(post);
              /*create a DIV element for each matching element:*/
              b = document.createElement("a");
              /*make the matching letters bold:*/
              b.setAttribute('href', post[1]);
              b.innerHTML+='<br>';
              b.innerHTML+= search_field.substr(0,index);
              b.innerHTML += "<strong>" + search_field.substr(index,val.length) + "</strong>";
              b.innerHTML += search_field.substr(index+val.length);
              b.innerHTML += "<input  type='hidden' value='" + search_field + "'>";
              /*insert a input field that will hold the current array item's value:*/
              ;
              /*execute a function when someone clicks on the item value (DIV element):*/
                  b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  inp.value = this.getElementsByTagName("input")[0].value;
                  /*close the list of autocompleted values,
                  (or any other open lists of autocompleted values:*/
                
              });
              res_div.appendChild(b);
              c.appendChild(b);
              res_div.appendChild(c);
              
            }
          }
        }



































           
           
           
           
           
           
           
           
            // for (type in search_data) {
            //     console.log(type);
                
            //     c=document.createElement("p");
            //     c.setAttribute("class", "rbw-search-results");
            //     quantity=0
                
            //     for(let post of search_data[type]){
               
                
            //       /*check if the item starts with the same letters as the text field value:*/
            //       if (post && post.toLowerCase().includes(val)) {
            //         if(quantity==0){
            //             c.innerHTML='<strong style="margin:3px; padding:3px;">'+type.charAt(0).toUpperCase()+type.slice(1)+'</strong>';
            //             a.appendChild(c);
            //             quantity=1;
            //         }
            //         index=post.toLowerCase().indexOf(val);
            //         console.log(post);
            //         /*create a DIV element for each matching element:*/
            //         b = document.createElement("DIV");
            //         /*make the matching letters bold:*/
                    
            //         b.innerHTML+= post.substr(0,index);
            //         b.innerHTML += "<strong style='z-index:110'>" + post.substr(index,val.length) + "</strong>";
            //         b.innerHTML += post.substr(index+val.length);
            //         b.innerHTML += "<input  type='hidden' value='" + post + "'>";
            //         /*insert a input field that will hold the current array item's value:*/
                    
            //         /*execute a function when someone clicks on the item value (DIV element):*/
            //             b.addEventListener("click", function(e) {
            //             /*insert the value for the autocomplete text field:*/
            //             inp.value = this.getElementsByTagName("input")[0].value;
            //             /*close the list of autocompleted values,
            //             (or any other open lists of autocompleted values:*/
                      
            //         });
            //         res_div.appendChild(b);
            //         c.appendChild(b);
            //         res_div.appendChild(c);
                    
            //       }
            //     }
            //   }
        });


        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
          
        
        });

 
    }
    
    search_data=searchdata['members_autocomplete'];
    
    search_data=searchdata['teams_autocomplete'];
    search_data.teams=['tet'];
    console.log(search_data)
    searching(document.getElementById('home-search-input'),search_data);





    
    function closeAllLists() {
        jQuery("#searching-results").empty();
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("rbw-search-results");
        
        for (var i = 0; i < x.length; i++) {
         
          x[i].parentNode.removeChild(x[i]);
        
      }
    }


});




