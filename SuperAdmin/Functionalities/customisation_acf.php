<?php

// autocomplete
// loading taxonomie for publication type
// loading taxonomie for member statut



function custom_acf() {
        wp_register_script( 'custom_acf', MY_PLUGIN_URL.'SuperAdmin/js/autocomplete.js',array('jquery'));
        wp_enqueue_script( 'custom_acf' );

        wp_register_style( 'custom_acf_css', MY_PLUGIN_URL.'SuperAdmin/css/autocomplete.css');
        wp_enqueue_style( 'custom_acf_css' );

        if (taxonomy_exists('publication_tags')){
          $x=get_terms('publication_tags');
          $list_of_terms=[];
          foreach($x as $term){
            $list_of_terms[]=$term->name;
          }
          wp_localize_script( 'custom_acf', 'autocompletedata', array(  'pub_tags'=>$list_of_terms,  ) );
        }

}
add_action( 'admin_enqueue_scripts', 'custom_acf' );






function acf_load_publication_type( $field ) {
    // reset choices
    $field['choices'] = array();
    // get the textarea value from options page without any formatting
    $wp_terms=get_terms( array(
    'taxonomy' => 'publication_statut',
    'hide_empty' => false,
  ));
    $choices=[];
    foreach ($wp_terms as $key => $value) {
      $choices[]=$value->name;
    }
    $choices[]='Other';
    // explode the value so that each line is a new array piece

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        foreach( $choices as $choice ) {
            $field['choices'][ $choice ] = $choice;
        }
    }
    // return the field
    return $field;

}

add_filter('acf/load_field/name=publication_type_select', 'acf_load_publication_type');



function acf_load_member_status( $field ) {
    // reset choices
    $field['choices'] = array();
    // get the textarea value from options page without any formatting
    $wp_terms=get_terms( array(
    'taxonomy' => 'member_status_tax',
    'hide_empty' => false,
  ));
    $choices=[];
    $choices[]='-';
    foreach ($wp_terms as $key => $value) {
      $choices[]=$value->name;
    }
    $choices[]='Other';
    // explode the value so that each line is a new array piece

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        foreach( $choices as $choice ) {
            $field['choices'][ $choice ] = $choice;
        }
    }
    // return the field
    return $field;
}
add_filter('acf/load_field/name=member_status', 'acf_load_member_status');


// git@github.com:olivierglrx/rbw-acf-json.git
// /dev4.rubidiumweb.eu/wp-content/plugins/acf-syncing



function acf_load_member_status_fr( $field ) {
    // reset choices
    $field['choices'] = array();
    // get the textarea value from options page without any formatting
    $wp_terms=get_terms( array(
    'taxonomy' => 'member_status_tax_fr',
    'hide_empty' => false,
  ));
    $choices=[];
    $choices[]='-';
    foreach ($wp_terms as $key => $value) {
      $choices[]=$value->name;
    }

    // explode the value so that each line is a new array piece

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        foreach( $choices as $choice ) {
            $field['choices'][ $choice ] = $choice;
        }
    }
    // return the field
    return $field;
}
add_filter('acf/load_field/name=member_status_fr', 'acf_load_member_status_fr');
