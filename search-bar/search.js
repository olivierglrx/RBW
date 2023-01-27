
function show_articles(){
    //  article_cpt_class is the class name given on elementor to the section (article)
    //  good_post_ids is an array of the post with id that we want to keep on display

    if (document.getElementsByClassName('rbw-search').length>0){
    cpt=document.getElementsByClassName('rbw-search')[0].getAttribute('cpt');
    search_bar_id='rbw-search-input-'+cpt;
    input=document.getElementById(search_bar_id)
    input_val=input.value.toLowerCase()
    }
    search_data_name=document.getElementsByClassName('rbw-autocomplete')[0].getAttribute('searching-data');
    good_id=get_satisfying_post_id(input_val,search_data_name);
    // console.log('show_article');
    // console.log('cpt',cpt, 'input', input, 'input_val',input_val )
    // console.log('search_data_name', search_data_name )
    // console.log('good_id',good_id);
    var list = document.getElementsByClassName(cpt);
    // console.log(list);
    for (let item of list) {
        id=item.getAttribute('data-dce-post-id')
        // console.log(id)
        if(good_id.includes(id) ){
            item.style.display="block";
            item.style.position="relative";
        }else{
            item.style.display="none";         
        }
    }
}


jQuery( document ).ready( function($) {
    
    function filter_article(inp,cpt,search_data) {
        inp.addEventListener("input", function(e) {
            var  val = this.value;
            show_articles();
        });
       
        
    };
    
    if ( document.getElementsByClassName('rbw-search').length>0){
       
        cpt=document.getElementsByClassName('rbw-search')[0].getAttribute('cpt');
        
        search_data_name=document.getElementsByClassName('rbw-autocomplete')[0].getAttribute('searching-data');
        search_bar_id='rbw-search-input-'+cpt;
        // console.log(searchdata);
        filter_article(document.getElementById(search_bar_id),cpt,search_data_name); 
    }   
    
});
  
function get_satisfying_post_id(input_val,search_data_name){
    
    data=searchdata[search_data_name];
    // console.log(searchdata);
    // console.log(search_data_name);

    // search_data is a keyword that has to be added in elementor short code eg. [\search_bar searching_data='teams'] 
    // searchdata is an array send by localisation in search.php This part cannot be automatised, one has to decide what 
        // data to search in each case. 
    //  data is of the form {id_of_post:{data_type: array() }}
    good_id=[]
    


    for (var id in data){
        is_good=0
        for (const [data_type, value] of Object.entries(data[id])) {
            for (let v of value){
                if (v){
                    v_min=v.toLowerCase();
                    input_val_min=input_val.toLowerCase();
                    if(v_min.includes(input_val_min)){
                        is_good+=1 
                    }
                }
                
                
            }
        }
        if (is_good>0){
            good_id.push(id);
        }
    }
    
    return(good_id);
}