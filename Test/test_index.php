<?php
function testscript() {
	
        wp_register_script( 'testjs', plugin_dir_url(__FILE__).'test.js',array('jquery', 'jquery-ui'));
        wp_enqueue_script( 'testjs' );

        wp_register_style( 'testcss', plugin_dir_url(__FILE__).'test.css');
        wp_enqueue_style( 'testcss' );




}
// add_action( 'admin_enqueue_scripts', 'testscript' );
// add_action( 'wp_enqueue_scripts', 'testscript' );


function test_menu() {
 	add_menu_page('Test', //Menu Name
 				'Test', // Menu label
 				'manage_options', // capability
 				'Test',// slug
 				'test' //function to call -> activated_plugins.php
 				);
}
add_action('admin_menu', 'test_menu');




function test(){
echo ('hello world');


}





