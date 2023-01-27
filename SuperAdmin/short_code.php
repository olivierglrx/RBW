<?php

add_action( 'init', 'register_shortcodes');
function register_shortcodes(){
    add_shortcode('recent-posts', 'recent_posts_function');
    add_shortcode('search_teams_member', 'search_teams_member_fct');
 }
function recent_posts_function($atts){
 }






function rbw_short_code(){
   
    // wp_register_script( 'rbw_short_code', plugins_url('js',__FILE__).'/short_codes.js', array( 'jquery',"jquery-ui" ));
    // wp_enqueue_script( 'rbw_short_code' );

 
   
 }
//  add_action('wp_enqueue_scripts','rbw_short_code');
