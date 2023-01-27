<?php


define( 'PUB_URL', plugin_dir_url( __FILE__ ) );
// 1 - Load CPT  - from the cpt.php file in the root folder
add_action( 'init', 'cpt_register_publication' );

// 2 -  Load the taxonomies - from the taxonomies.php file in the root folder
add_action( 'init', 'register_publication_tax' );


// 3 - Insert the submenus for the plugins
include('menus_plugins_pub.php');

// 4 - Specific update when one register a publication (eg put commas between authors)
include('register_publications.php');

// 5 - Handle the CSS for the publications plugins (namely the look of the tables)
function add_common_css_for_publication(){
  wp_register_style( 'publications_table', plugin_dir_url(__FILE__).'css/publications_table.css');
  wp_enqueue_style( 'publications_table' );

  wp_register_style( 'common_css_for_publication', plugin_dir_url(__FILE__).'css/common_css_for_publication.css');
  wp_enqueue_style( 'common_css_for_publication' );

  wp_enqueue_script('table_creation',plugin_dir_url(__FILE__).'js/create_table.js');

  wp_enqueue_script('table_data_save', plugin_dir_url(__FILE__).'js/insert_table_in_database.js');
  wp_localize_script( 'table_data_save', 'adminAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
}
add_action('admin_enqueue_scripts','add_common_css_for_publication');
add_action('wp_enqueue_scripts','add_common_css_for_publication');

// 6 Export
if (is_array(get_option("activated_plugins"))){
  if (in_array('ExportPublications',get_option("activated_plugins"))){
    include('export_pub.php');
  }
}


