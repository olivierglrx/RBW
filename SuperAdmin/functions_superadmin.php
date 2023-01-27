<?php

// 1 get_cpt : get all cpts that are not builtin (page/post) and that are not from elementor. Be careu
// full if others plugins register cpt.
// 
// 2 get_site_option : get all ACF-options.
// 3 rb_get_acf($cpt,$key), return a list of acf for a given cpt. $key is how to represent the acf : 'name' or 'key'
// 4 echo on/off button for RbW plugin.
// 5 - Export functions

// 1
function get_cpt(){
  $args = array(
       'public'   => true,
       '_builtin' => false,
    );
  $cpt= get_post_types( $args);

  $my_cpt=array();
  foreach($cpt as $key){
    if ($key!='e-landing-page' and $key!='elementor_library' and $key!='custom_menu'){
      $my_cpt[$key]=$key;
    }
  }
  return($my_cpt);
}

// 2
function get_site_options(){
  if(!function_exists('acf_get_field_groups'))
    return;
  $list_of_all_options=[];
  $store = acf_get_field_groups( );
  foreach ($store as $sotr){
    if ($sotr['location'][0][0]['param']=='options_page'){
      $fields =acf_get_fields($sotr['key']);
      foreach ($fields as $key){
        $name=$key['name'];
        $list_of_all_options[$name]=$name;
      }
      }
    }
    return($list_of_all_options);
}

// 3 - rb_get_acf.
function rb_get_acf($cpt,$key){

  // Get all loaded acf fields for a given $cpt. It will return the list of all $key 
  // $key should be (name or  key )
  $group=acf_get_field_groups(array('post_type' => $cpt));
  $fields = acf_get_fields($group[0]['key']);
  $list=array();
  foreach($fields as $field ){
    $list[]=$field[$key];
  }
  return( $list);

}

// 4 - On/off button 
function on_off_button($name){
  $id=$name;
  $id = str_replace(' ', '', $name);
	echo(
		' <div class="switch-holder">
            <div class="switch-label">
                <i class=""></i><span>'.$name.'</span>
            </div>
            <div class="switch-toggle">
                <input id='.$id.'  class="input" name="'.$id.'" type="checkbox"'); if(in_array($id,get_option("activated_plugins"))){echo('checked ' );} echo('id="'.$id.'">
                <label for="'.$id.'"></label>
            </div>
        </div>
        '
	);
}



// 5 - Export functions

function export_publi_as_bibtex_dash($ID){
  $title=get_field('publication_title',$ID);
  $first_word_title=explode(' ', $title)[0];
  $authors=get_field('publication_authors',$ID);
  $first_author=explode(' ', $authors)[0];
  $date=get_field('publication_dop',$ID);
  $volume=get_field('publication_volume',$ID);
  $journal=get_field('publication_journal',$ID);
  $pages=get_field('publication_pages',$ID);
  $DOI=get_field('publication_doi',$ID);
  $abstract=str_replace('<br>',' ', get_field('publication_abstract',$ID));
  $abstract=str_replace('<br />',' ',$abstract);
  $abstract=str_replace('<p>',' ',$abstract);
  $abstract=str_replace('</p>',' ',$abstract);
  $publisher=get_field('publication_publisher',$ID);
  $publisher_link=get_field('publication_link',$ID);
  $open_link=get_field('publication_arxiv_url',$ID);
  $type=get_field('publication_type_select',$ID);
  
  if (!$type){
    $type='article';
  }
  $bibtexentry='@'.$type.'{';
  $bibtexentry.=$first_author.$date.$first_word_title.','."\r\n";
  $bibtexentry.='title={'.$title.'},'."\n";
  $bibtexentry.='author={'.$authors.'},'."\n";
  $bibtexentry.='journal={'.$journal.'},'."\n";
  $bibtexentry.='volume={'.$volume.'},'."\n";
  $bibtexentry.='pages={'.$pages.'},'."\n";
  $bibtexentry.='year={'.$date.'},'."\n";
  $bibtexentry.='DOI={'.$DOI.'},'."\n";
  $bibtexentry.='abstract={'.$abstract.'},'."\n";
  $bibtexentry.='open_link={'.$open_link.'},'."\n";
  $bibtexentry.='publisher={'.$publisher.'},'."\n";
  $bibtexentry.='}'."\n"."\n";
  return($bibtexentry);
  }


  function export_member_dash($ID){
    $lname=get_field('member_last_name',$ID);
    $fname=get_field('member_first_name',$ID);
    $email=get_field('member_email',$ID);
    $entry =$lname.' '.$fname.', '.$email;
    return($entry);
    }
  