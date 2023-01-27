<?php
// ['Title', 'Authors', 'Year', 'Type', 'Journal','DOI','ISBN', 'Volume', 'Link', 'Pages', 'Keywords', 'Publisher', 'Editor','Booktitle','Abstract','extra-info'];
add_action( 'wp_ajax_register_publications', 'register_publications');
add_action( 'wp_ajax_nopriv_register_publications', 'register_publications');
function register_publications(){

  $posts = get_posts( array(
    'post_type' => 'publication',
    'post_status' => 'publish',
    'numberposts' => -1,
  ) );
  $list_of_doi=[];
  $list_of_title=[];
    foreach($posts as $post){
      $ID=$post->ID;
      $list_of_doi[]=get_field('publication_doi', $ID);
      $list_of_title[]=get_field('publication_title', $ID);
    }
    if (in_array($_POST['DOI'], $list_of_doi) && $_POST['DOI']!='' ){
      wp_send_json_success( array('DOI', $_POST['Title']));
      return;
    }else{
      if (in_array($_POST['Title'], $list_of_title) && $_POST['Title']!='' ){
        wp_send_json_success( array('Title', $_POST['Title']));
        return;
      }else{

        $args = array(
          'post_type' => 'publication',
          'post_status' => 'publish',
          'post_title'=>$_POST['Title'],
        );
        $inserted_post_id = wp_insert_post( $args );

        update_field('publication_title',   $_POST['Title'], $inserted_post_id);
        update_field('publication_authors', $_POST['Authors'], $inserted_post_id);
        update_field('publication_dop'    , $_POST['Year'],    $inserted_post_id);
        update_field('publication_journal', $_POST['Journal'], $inserted_post_id);
        update_field('publication_volume' , $_POST['Volume'],  $inserted_post_id);
        update_field('publication_pages'  , $_POST['Pages'],   $inserted_post_id);
        update_field('publication_doi',     $_POST['DOI'],     $inserted_post_id);
        update_field('publication_isbn',    $_POST['ISBN'],    $inserted_post_id);
        update_field('publication_editor',  $_POST['editor'],  $inserted_post_id);
        update_field('publication_abstract',$_POST['Abstract'], $inserted_post_id);
        update_field('publication_arxiv_url',$_POST['Link'],   $inserted_post_id);
        update_field('publication_publisher', $_POST['Publisher'], $inserted_post_id);


        // Taxonomy
        $list_of_authors=explode(',',$_POST['Authors']);



        foreach ($list_of_authors as $key=>$value){
          wp_set_post_terms( $inserted_post_id,trim($value),  'publication_authors',  true );
          wp_update_term( $inserted_post_id, trim($value),  'publication_authors',  true );
        }

        wp_set_post_terms( $inserted_post_id, $_POST['Year'],  'publication_year',  false );
        wp_update_term( $inserted_post_id, $_POST['Year'],  'publication_year',  false );

        update_field('publication_scientific_tags_text', trim($_POST['Keywords']), $inserted_post_id);
        if ($_POST['Keywords']!=''){
        // update_field('publication_scientific_tags_text', $_POST['Keywords'], $inserted_post_id);
        // $list_of_keywords=explode(',',$_POST['Keywords']);
        $list_of_keywords = preg_split("/,|;/", $_POST['Keywords']);
        foreach ($list_of_keywords as $key=>$value){
          wp_set_post_terms( $inserted_post_id,$value,  'publication_tags',  true );
          wp_update_term( $inserted_post_id, $value,  'publication_tags',  true );
        }
        wp_set_post_tags($inserted_post_id, $list_of_keywords,true);
      }


        wp_set_post_terms( $inserted_post_id, $_POST['Type'],  'publication_statut',  false );
        wp_update_term( $inserted_post_id, $_POST['Type'],  'publication_statut',  false );

        wp_set_post_terms( $inserted_post_id, $_POST['Year'],  'publication_year',  false );
        wp_update_term( $inserted_post_id, $_POST['Year'],  'publication_year',  false );

        $today_year = date("Y");
        $year = get_field('publication_dop', $post_id);
        if (2020<=intval($year) and intval($year)<2025){
          wp_set_post_terms( $inserted_post_id, '2020-'.$today_year,  'publication_year_mod_5',  false );
          wp_update_term( $inserted_post_id, '2020-',  'publication_year_mod_5',  false );
        }

        if (2015<=intval($year) and intval($year)<2020){
          wp_set_post_terms( $inserted_post_id, '2015-2019',  'publication_year_mod_5',  false );
          wp_update_term( $inserted_post_id, '2015-2019',  'publication_year_mod_5',  false );
        }

        if (2010<=intval($year) and intval($year)<2015){
          wp_set_post_terms( $inserted_post_id, '2010-2014',  'publication_year_mod_5',  false );
          wp_update_term( $inserted_post_id, '2010-2014',  'publication_year_mod_5',  false );
        }

        if (2005<=intval($year) and intval($year)<2010){
          wp_set_post_terms( $inserted_post_id, '2005-2009',  'publication_year_mod_5',  false );
          wp_update_term( $inserted_post_id, '2005-2009',  'publication_year_mod_5',  false );
        }
        if (1995<=intval($year) and intval($year)<2005){
          wp_set_post_terms( $inserted_post_id, '1995-2004',  'publication_year_mod_5',  false );
          wp_update_term( $inserted_post_id, '1995-2004',  'publication_year_mod_5',  false );
        }
    // The $_POST variable is set in every plugin through the add_publication ajax call
        if (isset($_POST['member_id'])){
          update_owner($inserted_post_id,$_POST['member_id']);

          }
        else{
          update_owner($inserted_post_id,'PI');

        }
        wp_send_json_success( array('inserted', $_POST['Title']));
        }
      }
}

// Update owner
// add_action('acf/save_post', 'publication_owners', 20);
function publication_owners($id){
  $post_type = get_post_type($id);
  if ($post_type == 'publication') {
   if (isset($_GET['id'])){
     update_owner($id,$_GET['id']);

   }
   else{
     update_post_meta($id,'owner','PI');
     $name=get_field('siteinfo_pi_first_name','option').' '.get_field('siteinfo_pi_last_name','option');
     update_field('publication_owner', $name, $id);


   }
 }
}

function update_owner($pub_id,$owner){
  $post_type = get_post_type($pub_id);
  if ($post_type == 'publication') {
    if(is_numeric($owner)){
      update_post_meta($pub_id,'owner',$owner);
      $name=get_field('member_first_name',$owner).' '.get_field('member_last_name',$owner);
      update_field('publication_owner', $name, $pub_id);
    }
    else{
      update_post_meta($pub_id,'owner','PI');
      $name=get_field('siteinfo_pi_first_name','option').' '.get_field('siteinfo_pi_last_name','option');
      update_field('publication_owner', $name, $pub_id);
    }
  }

}


// Update title

add_action('acf/save_post', 'publication_save_post_type_post',21); // fires after ACF
function publication_save_post_type_post($post_id) {
  $post_type = get_post_type($post_id);
  if ($post_type == 'publication') {
    $post_title = get_field('publication_title', $post_id);
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title
    );
    wp_update_post($post);
}
}


// Update taxonomies
function publication_update_taxonomy_term($post_id){

     // YEAR
     $year=get_field('publication_dop', $post_id);
     wp_set_object_terms( $post_id, $year,  'publication_year',  false );
     // wp_update_term( $post_id, 'year',  'publication_year',  false );
     if (2020<=intval($year) and intval($year)<2025){
       wp_set_post_terms( $post_id, '2020 et plus',  'publication_year_mod_5',  false );
     }

     if (2015<=intval($year) and intval($year)<2020){
       wp_set_post_terms( $post_id, '2015-2019',  'publication_year_mod_5',  false );
     }

     if (2010<=intval($year) and intval($year)<2015){
       wp_set_post_terms( $post_id, '2010-2014',  'publication_year_mod_5',  false );
     }

     if (2005<=intval($year) and intval($year)<2010){
       wp_set_post_terms( $post_id, '2005-2009',  'publication_year_mod_5',  false );
     }
     if (2000<=intval($year) and intval($year)<2005){
       wp_set_post_terms( $post_id, '2005-2009',  'publication_year_mod_5',  false );
     }

     // tags
     wp_set_post_terms( $post_id,'',  'publication_tags',  false );
     wp_update_term( $post_id, '',  'publication_tags',  false );
     $keywords=get_field('publication_scientific_tags_text',$post_id);
     $list_of_keywords=explode(',',$keywords);
     foreach ($list_of_keywords as $key=>$value){
       wp_set_post_terms( $post_id,$value,  'publication_tags',  true );
       wp_update_term( $post_id, $value,  'publication_tags',  true );
     }
     wp_set_post_tags($post_id, $list_of_keywords,true);


     // Authors
     wp_set_post_terms( $post_id,'',  'publication_authors',  false );
     wp_update_term( $post_id, '',  'publication_authors',  false );
     $authors= get_field('publication_authors',$post_id);
     $list_of_authors=explode(',',$authors);
     foreach ($list_of_authors as $key=>$value){
       wp_set_post_terms( $post_id,trim($value),  'publication_authors',  true );
       wp_update_term( $post_id, trim($value),  'publication_authors',  true );
     }




     // // Type

     $other_type= get_field('publication_other_type',$post_id);
     if ($other_type!=''){
     wp_set_post_terms( $post_id, $other_type,  'publication_statut',  false );
     wp_update_term( $post_id,  $other_type,  'publication_statut',  false );
     update_field('publication_type_select', $other_type, $post_id);
     update_field('publication_other_type', '', $post_id);
   }
   else{

    $type=get_field('publication_type_select', $post_id);
    wp_set_post_terms( $post_id, $type,  'publication_statut',  false );
    wp_update_term( $post_id, $type,  'publication_statut',  false );
  }
}
