<?php

// add_action( 'wp_ajax_home_search', 'home_search');
// add_action( 'wp_ajax_nopriv_home_search', 'home_search');

function home_search(){
    

    $home_searching_data=array();
    $query = new WP_Query(array(
        'post_type' => 'member', 
        'posts_per_page'=>-1
    ));
    if ($query->have_posts()):
        foreach( $query->posts as $post ):   
            $id=$post->ID; 
            // EVERY ENTRY MUST BE 
            $home_searching_data['Member'][] = array(get_field('member_first_name', $id).' '.get_field('member_last_name', $id),  get_post_permalink($id));
            // $members_autocomplete['Member'][] = get_field('member_last_name', $id).' '.get_field('member_first_name', $id);
    
        endforeach;
    endif;             
    wp_reset_query();
    
    $query = new WP_Query(array(
        'post_type' => 'teams', 
        'posts_per_page'=>-1
    ));
    if ($query->have_posts()):
        foreach( $query->posts as $post ): 
            $id=$post->ID;    
            // EVERY ENTRY MUST BE Array
            $home_searching_data['Teams'][] = array(get_field('team_name', $id),get_post_permalink($id)) ;
            
        endforeach;
    endif;                 
    wp_reset_query();

    return($home_searching_data);


}
