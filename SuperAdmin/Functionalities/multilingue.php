<?php

// Duplicate taxonomies for multilingue. 
add_action( 'init', 'register_multilingue_tax' );


include 'ml-taxonomy.php';

function ML_script() {
        wp_register_script( 'multilingue', plugin_dir_url(__FILE__).'multilingue.js',array('jquery'));
        wp_enqueue_script( 'multilingue' );
}
add_action( 'admin_enqueue_scripts', 'ML_script' );

add_action('init', 'start_session', 1);
function start_session(){

    if(!session_id()) {
    session_start();
    }
    if(!array_key_exists('ML',$_SESSION)){
      $_SESSION['ML']="FR";
    }
		if(isset($_GET['ML'])){
			if($_GET['ML']=='FR'){
				$_SESSION['ML']='FR';
			}
			if ($_GET['ML']=='EN'){
				$_SESSION['ML']='EN';
			}
		}

}
