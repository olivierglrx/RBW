<?php

// 1 - Filter menu
// 2 - ACF choices 
// 2.1 Load menus
// 2.2 Load ACF
// 2.3 Load CPT
// 2.4 change the title of the post
// 3 - CPT register
// 4 - ACF


// 1 - Filter menu
add_filter( 'wp_get_nav_menu_items', 'cpt_automatic_menu', 10, 3);
function cpt_automatic_menu( $items, $menu, $other ) {
  $i=0;
      $args_q = array(
            'post_type' => 'custom_menu',
            'numberposts' => -1,
          );
      $custom_menu=get_posts( $args_q);
      $child_items =$items;// here, we will add all items for the single posts


      foreach ( $custom_menu as $key=>$value ) {
        $id=$value->ID;
        $rb_menu_subitem=intval(substr(strrchr(get_post($id)->post_title,'ID:'),3));
        $menu_name=get_field('custom_menu_name',$id);
        $cpt=get_field('custom_menu_cpt_to_add',$id);
        $args = array(
                      'post_type' =>$cpt,
                      'order'     => 'ASC',
                      'numberposts'=>-1,
                    );
        $posts=get_posts($args);
        // echo($menu->name);
        $acf_to_add=get_field('custom_menu_acf_to_add',$id);
        $i=$i+count($items);
        if ($menu->name==$menu_name ){
            $menu_order = $i; // this is required, to make sure it doesn't push out other menu items
            $i++;
            $parent_item_id = $rb_menu_subitem; // we will use this variable to identify the parent menu item

            // $i=100000;
            foreach ( $posts as $post ) {
              // $i+=100;

                  $post->menu_item_parent = $parent_item_id;
                  $post->post_type = 'nav_menu_item';
                  $post->object = 'custom';


                  $post->type = 'custom';
                  $post->menu_order = ++$menu_order;
                  $post->post_title =get_field($acf_to_add, $post->ID);
                  $post->title = $post->post_title;
                  $post->label = get_field($acf_to_add,$post->ID) ;
                  $post->url = get_permalink( $post->ID );

                  $child_items[]=$post;
                }
            }
      }
      return $child_items;
}


// 2 - ACF choices 
// The acf for the custom menu CPT have to be dynamically generated depending on the existing CPT/menu / ACF

// 2.1 list of Menus 
function acf_load_menu_name( $field ) {
    // reset choices
    $field['choices'] = array();
    // get the textarea value from options page without any formatting
    $choices=[];
    $menu = wp_get_nav_menus();
    foreach ($menu as $key => $value) {
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
add_filter('acf/load_field/name=custom_menu_name', 'acf_load_menu_name');




// 2.1 list of ACF to include
function custom_menu_load_acf( $field ) {
    // // reset choices
    $field['choices'] = array();
    $acf=[];
    $acf_back=get_option('activated_acf_on_back');

    foreach( $acf_back as $cpt){
    foreach ($cpt as $key){
      $acf[]=$key;
    }
    }

    if( is_array($acf) ) {
        foreach( $acf as $choice ) {
          if (!is_array($choice)){
            $field['choices'][ $choice ] = $choice;
          }

        }
    }
    return $field;

}

add_filter('acf/load_field/name=custom_menu_acf_to_add', 'custom_menu_load_acf');






function acf_load_menu_item( $field ) {
    // reset choices
    $field['choices'] = array();
    // get the textarea value from options page without any formatting
    $choices=[];
    $menu =wp_get_nav_menus();

    foreach ($menu as $key => $value) {
      $slug=$value->slug;
      $subitem=wp_get_nav_menu_items($slug);
        foreach ($subitem as $key2 => $value2) {
          $choices[]=$value2->title.' ID:'.$value2->ID;
      }
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

add_filter('acf/load_field/name=custom_menu_item', 'acf_load_menu_item');

// 2.3 list of CPT. 
function acf_load_menu_cpt_to_add( $field ) {
    $field['choices'] = get_cpt();
    return $field;
}
add_filter('acf/load_field/name=custom_menu_cpt_to_add', 'acf_load_menu_cpt_to_add');


// 2.4 change the title of the post
add_action('acf/save_post', 'custom_menu_save_post',20); // fires after ACF
function custom_menu_save_post($post_id) {
  $post_type = get_post_type($post_id);
  if ($post_type == 'custom_menu') {
    $post_title = 'Menu :'.get_field('custom_menu_item', $post_id).' adding  '.get_field('custom_menu_cpt_to_add', $post_id);
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title,
    );
    wp_update_post($post);
}

}


// 3 - CPT.
function cptui_register_nav_menu_custom() {

	/**
	 * Post Type: custom menu.
	 */

	$labels = [
		"name" => __( "Custom Menu", "custom-post-type-ui" ),
		"singular_name" => __( "Custom Menu", "custom-post-type-ui" ),
		"menu_name" => __( "Rb Custom Menu", "custom-post-type-ui" ),
		"all_items" => __( "Custom Menu list", "custom-post-type-ui" ),
		"add_new" => __( "Add new Custom Menu", "custom-post-type-ui" ),
    "add_new_item" => __( "New Custom Menu", "custom-post-type-ui" ),
    "edit_item" => __( "Edit Custom Menu", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Custom Menu", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
    // 'capabilities' => array(
    //                   'create_posts' => 'do_not_allow', // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
    //                 ),
		"map_meta_cap" => true,
		"hierarchical" => false,
		// "rewrite" => [ "slug" => "member", "with_front" => true ],
		"query_var" => true,
    "menu_icon" => 'dashicons-admin-users',
		"supports" => ["custom-fields"],
		"show_in_graphql" => false,
    "menu_position" => 150
	];

	register_post_type( "custom_menu", $args );
}

add_action( 'init', 'cptui_register_nav_menu_custom' );


