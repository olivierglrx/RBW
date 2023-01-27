<?php

// create options "activated_plugins", "activated_acf_on_back",
// "activated_site_options_list" and fill them with default values. 


function run_only_once() {
  if ( !get_option('activated_acf_on_back')  ):
    $starting_acf=[];
    $starting_acf['publication'] = array('publication_title','publication_authors','publication_dop','publication_journal');
    $starting_acf['member'] = array('member_first_name', 'member_last_name', 'member_email','member_send_email');
    add_option('activated_acf_on_back', $starting_acf); 
  endif;

  if ( !get_option('activated_plugins') ):
    $starting_plugins=['Publication','BibTex','ORCID','Member','Job','Team','Research'];
    add_option('activated_plugins', []); 
    update_option('activated_plugins', $starting_plugins);
  endif;

  

  if (!get_option('activated_site_options_list')):
    if( !function_exists('acf_get_field_groups')){
      return;
    }
  $options=[];
  $store = acf_get_field_groups( );
  foreach ($store as $sotr){
    if ($sotr['location'][0][0]['param']=='options_page'){
      $fields =acf_get_fields($sotr['key']);
      foreach ($fields as $key){
        $name=$key['name'];
        $options[]=$name;
      }
    }
  }
  if ($options==[]){
    return;
  }
  add_option('activated_site_options_list',$options);
  endif;
}
add_action( 'init', 'run_only_once' );



