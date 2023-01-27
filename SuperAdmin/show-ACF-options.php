<?php

/* Handle display of ACF_options for multisite installation. 
We have a bundle of predefined ACF_options and here we can check/uncheck the acf we want to show. 

1- Submenu creation 

3- Hide the options that ar not checked on option pages. 
4- Create the Rb page 
5- Creation of option pages
*/


// 1 - Menu (submenu of RbW plugins)
function add_submenu_for_options() {
  add_submenu_page('RbWeb', //Parent slug
        'HandleACF-option', // page title
        'Site options', // Menu label
        'manage_options', // capability
        'ACF-options',// slug
        'sa_acf_options',//function to call
        );
}
add_action('admin_menu', 'add_submenu_for_options');



// 3 - Hide the options that are not checked. 
function sa_hide_option(){
  //Avoid displaying acf options that are not activated.
  $options=get_option('activated_site_options_list');
  if (is_array($options)){
    $not_activated=array_diff(get_site_options(),$options);
  }else{
    return;
  }
  
  echo'<style type="text/css">';
  foreach($not_activated as $option){
    echo('
  div[data-name='.$option.']{
      display:none;
    }
  ');
  }
    echo'</style>';
}
add_action('admin_enqueue_scripts', 'sa_hide_option');







// 4 - Create the page 
function sa_acf_options(){
  // Update options that are checked. 
  $new_options=array();
  if (isset($_POST['option'])){
    $option=$_POST;
    foreach($option as $key =>$value){
      if ($value=='on'){
        $new_options[]=$key;
      }
    }
    update_option('activated_site_options_list',$new_options);
  }

  echo('<form method="post")>');
    $store = acf_get_field_groups( );
    
    foreach ($store as $sotr){
      if ($sotr['location'][0][0]['param']=='options_page'){
          $fields =acf_get_fields($sotr['key']);
          echo('<h1>'. $sotr['title'].'</h1>');
          foreach ($fields as $key){
            $name=$key['name'];
            ?>
            <input type="checkbox" id="scales" name="<?php echo($name.'"');
            if (get_option('activated_site_options_list') and in_array($key['name'],get_option('activated_site_options_list'),false)) {
              echo('checked >');
            }
            else{
              echo('>');
            }
            print_r($key['label'].' ('.$name.')');
            echo'</br>';
          }
      }
    }
    echo('<input type="submit" name="option" value=Envoyer></form>');
    echo('<button type="button" name="checkall" onclick="check_all()" >checkall</button>');
    echo('<button type="button" name="uncheckall" onclick="uncheck_all()" >uncheckall</button>');
  echo'</form>';



}


// 5 Creation of OPTIONS PAGES


add_action('admin_menu', 'create_option_page');
function create_option_page() {
  if( function_exists('acf_add_options_page') ) {
     acf_add_options_page(array(
          'page_title'    => __('Theme General Settings'),
          'menu_title'    => __('Site settings'),
          'menu_slug'     => 'theme-general-settings',
          'capability'    => 'edit_posts',
          'redirect'      => false,
          'position'      => 2,
      ));

    }
}


