<?php

// 1 - Load CPT  - from the cpt.php file in the root folder
add_action( 'init', 'cpt_register_member');

// include taxonomies - from the taxonomies.php file in the root folder
add_action( 'init', 'register_member_tax' );


// 2 - Include member using a csv file

include('member_csv.php');

include('member_add_info.php');

include('member_mail.php');

include('members_save_post.php');

function add_common_css_for_member(){
  wp_register_style( 'member_style', plugins_url('css',__FILE__).'/index_member.css');
  wp_enqueue_style( 'member_style' );

	wp_register_style( 'popup_style', plugins_url('css',__FILE__).'/popup.css');
  wp_enqueue_style( 'popup_style' );

	wp_register_script( 'member_script', plugins_url('js',__FILE__).'/index_member.js' );
	wp_enqueue_script( 'member_script' );

  wp_register_script( 'member_mail', plugins_url('js',__FILE__).'/send_email_ajax.js' );
  wp_enqueue_script( 'member_mail' );
  if (isset($_GET['id'])){
    wp_localize_script( 'member_mail', 'member_id', array( 'id' => $_GET['id'] ));
  }
  else{
    wp_localize_script( 'member_mail', 'member_id', array( 'id' => '' ));
  }


}


if (isset($_GET['post_type'])){
	if($_GET['post_type']=='member'){
		add_action('admin_enqueue_scripts','add_common_css_for_member');
	}
}




function add_csv_style(){
  	wp_register_script( 'csv_style', plugins_url('css',__FILE__).'/csv.css' );
  	wp_enqueue_script( 'csv_style' );
}


if (isset($_GET['page'])){
	if($_GET['page']=='Add_by_csv'){
		add_action('admin_enqueue_scripts','add_csv_style');
	}
}
