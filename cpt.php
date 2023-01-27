<?php
/* 
 Register all cpt  
-Nomenclature 
 function names : cpt_register_NAME
cpt name : always singular. 
 */

// 1 Publication
// 2 Member
// 3 Miscellaneous
// 4 Facilities
// 5 Gallery
// 6 Fundings
// 7 outreach
// 8 Collaborator
// 9 Event
// 10 Experiment
// 11 Research
// 12 News
// 13 Jobs
// 14 Team
// 15 Talk


// 1 Publication
function cpt_register_publication() {

	/**
	 * Post Type: Publication.
	 */

	$labels = [
		"name" => __( "Publications", "custom-post-type-ui" ),
		"singular_name" => __( "Publication", "custom-post-type-ui" ),
		"menu_name" => __( "Publications", "custom-post-type-ui" ),
		"all_items" => __( "Publications list", "custom-post-type-ui" ),
		"add_new" => __( "Add new publication", "custom-post-type-ui" ),
		"add_new_item" => __( "New Publication", "custom-post-type-ui" ),
		"edit_item" => __( "Edit Publication", "custom-post-type-ui" ),
		"new_item" => __( "New Publication", "custom-post-type-ui" ),
		"view_item" => __( "View Publication", "custom-post-type-ui" ),
		"view_items" => __( "View Publications", "custom-post-type-ui" ),
		"search_items" => __( "Search Publications", "custom-post-type-ui" ),
		"not_found" => __( "No Publications found", "custom-post-type-ui" ),
		"not_found_in_trash" => __( "No Publications found in trash", "custom-post-type-ui" ),
		"parent" => __( "Parent Publication:", "custom-post-type-ui" ),
		"featured_image" => __( "Featured image for this Publication", "custom-post-type-ui" ),
		"set_featured_image" => __( "Set featured image for this Publication", "custom-post-type-ui" ),
		"remove_featured_image" => __( "Remove featured image for this Publication", "custom-post-type-ui" ),
		"use_featured_image" => __( "Use as featured image for this Publication", "custom-post-type-ui" ),
		"archives" => __( "Publication archives", "custom-post-type-ui" ),
		"insert_into_item" => __( "Insert into Publication", "custom-post-type-ui" ),
		"uploaded_to_this_item" => __( "Upload to this Publication", "custom-post-type-ui" ),
		"filter_items_list" => __( "Filter Publications list", "custom-post-type-ui" ),
		"items_list_navigation" => __( "Publications list navigation", "custom-post-type-ui" ),
		"items_list" => __( "Publications list", "custom-post-type-ui" ),
		"attributes" => __( "Publications attributes", "custom-post-type-ui" ),
		"name_admin_bar" => __( "Publication", "custom-post-type-ui" ),
		"item_published" => __( "Publication published", "custom-post-type-ui" ),
		"item_published_privately" => __( "Publication published privately.", "custom-post-type-ui" ),
		"item_reverted_to_draft" => __( "Publication reverted to draft.", "custom-post-type-ui" ),
		"item_scheduled" => __( "Publication scheduled", "custom-post-type-ui" ),
		"item_updated" => __( "Publication updated.", "custom-post-type-ui" ),
		"parent_item_colon" => __( "Parent Publication:", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "publication", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "Scientific publications",
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
  //   'create_posts' => 'do_not_allow', // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
  // ),
		"map_meta_cap" => true,
		"hierarchical" => false,
		// "rewrite" => [ "slug" => "publication", "with_front" => false ],
		"query_var" => true,
		// "menu_position" => 10,
		"menu_icon" => "dashicons-welcome-learn-more",
		"supports" => [ "custom-fields"],
   		"menu_position" => 30
	];
	register_post_type( "publication", $args );
}

// 2 Member
function cpt_register_member() {

	/**
	 * Post Type: member.
	 */

	$labels = [
		"name" => __( "Members", "custom-post-type-ui" ),
		"singular_name" => __( "Member", "custom-post-type-ui" ),
		"menu_name" => __( "Members", "custom-post-type-ui" ),
		"all_items" => __( "Members list", "custom-post-type-ui" ),
		"add_new" => __( "Add new member", "custom-post-type-ui" ),
    "add_new_item" => __( "New Member", "custom-post-type-ui" ),
    "edit_item" => __( "Edit Member", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "member", "custom-post-type-ui" ),
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
   		"menu_icon" => 'dashicons-id-alt',
		"supports" => ["custom-fields"],
		"show_in_graphql" => false,
    	"menu_position" => 10
	];

	register_post_type( "member", $args );
}

// 3 Miscellaneous
function cpt_register_miscellaneous() {

	/**
	 * Post Type: Miscellaneous.
	 */

	$labels = [
		"name" => __( "Miscellaneous", "custom-post-type-ui" ),
		"singular_name" => __( "Miscellaneous", "custom-post-type-ui" ),
		"all_items" => __( "Miscellaneous list", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Miscellaneous", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "miscellaneous", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "miscellaneous", $args );
}

// 4 Facilities
function cpt_register_facilities() {

	/**
	 * Post Type: Facilities.
	 */

	$labels = [
		"name" => __( "Facilities", "custom-post-type-ui" ),
		"singular_name" => __( "Facilities", "custom-post-type-ui" ),
		"all_items" => __( "Facilities list", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Facilities", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		//"capability_type" => "post",
		// "map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "facilities", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "custom-fields" ],
		"show_in_graphql" => false,
		// 'capability_type' => array('facility','facilities'), //custom capability type
		'map_meta_cap'    => true, //map_meta_cap must be true
	];

	register_post_type( "facilities", $args );
}

// 5 Gallery
function cpt_register_gallery() {

	/**
	 * Post Type: Gallery.
	 */

	$labels = [
		"name" => __( "Gallery", "custom-post-type-ui" ),
		"singular_name" => __( "Gallery", "custom-post-type-ui" ),
		"all_items" => __( "Gallery list", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Gallery", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "gallery", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-format-gallery",
		"supports" => [ "custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "gallery", $args );
}

// 6 Fundings
function cpt_register_fundings() {

	/**
	 * Post Type: Fundings.
	 */

	$labels = [
		"name" => __( "Fundings", "custom-post-type-ui" ),
		"singular_name" => __( "Funding", "custom-post-type-ui" ),
		"all_items" => __( "Fundings list", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Fundings", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "fundings", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-editor-contract",
		"supports" => [ "thumbnail", "custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "fundings", $args );
}

// 7 outreach
function cpt_register_outreach() {

	/**
	 * Post Type: outreach.
	 */

	$labels = [
		"name" => __( "Outreach", "custom-post-type-ui" ),
		"singular_name" => __( "Outreach", "custom-post-type-ui" ),
		"all_items" => __( "Outreach list", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Outreaches", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "outreach", "with_front" => true ],
		"query_var" => true,
		// "menu_icon" => "dashicons-editor-contract",
		"supports" => [ "thumbnail", "custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "outreach", $args );
}

// 8 Collaborator
function cpt_register_collaborator() {

	/**
	 * Post Type: collaborator.
	 */

	$labels = [
		"name" => __( "Collaborator", "custom-post-type-ui" ),
		"singular_name" => __( "Collaborator", "custom-post-type-ui" ),
		"all_items" => __( "Collaborators list", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Collaborators", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "collaborators", "with_front" => true ],
		"query_var" => true,
		// "menu_icon" => "dashicons-editor-contract",
		"supports" => [ "thumbnail", "custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "collaborator", $args );
}

// 9 Event
function cpt_register_event() {

	/**
	 * Post Type: event.
	 */

	$labels = [
		"name" => __( "Event", "custom-post-type-ui" ),
		"singular_name" => __( "Event", "custom-post-type-ui" ),
		"all_items" => __( "Events list", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Events", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "event", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-calendar",
		"supports" => [ "thumbnail", "custom-fields" ],
		"show_in_graphql" => false,
		"menu_position" => 15,
	];

	register_post_type( "event", $args );
}

// 10 Experiment
function cpt_register_experiment() {

	/**
	 * Post Type: experiment.
	 */

	$labels = [
		"name" => __( "Experiment", "custom-post-type-ui" ),
		"singular_name" => __( "Experiment", "custom-post-type-ui" ),
		"all_items" => __( "Experiments list", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Experiments", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "experiment", "with_front" => true ],
		"query_var" => true,
		// "menu_icon" => "dashicons-editor-contract",
		"supports" => [ "thumbnail", "custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "experiment", $args );
}

// 11 Research
function cpt_register_research() {

	/**
	 * Post Type: research.
	 */

	$labels = [
		"name" => __( "Research", "custom-post-type-ui" ),
		"singular_name" => __( "Research", "custom-post-type-ui" ),
    "add_new" => __( "Add new topic", "custom-post-type-ui" ),
    "all_items" => __( "Research topics list", "custom-post-type-ui" ),
    "add_new_item" => __( "New Research Paragraph", "custom-post-type-ui" ),
    "edit_item" => __( "Edit Research Paragraph", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "research", "custom-post-type-ui" ),
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
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "research", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => 'dashicons-editor-customchar',
		"supports" => [ "custom-fields"],
		"show_in_graphql" => false,
    "menu_position" => 19
	];

	register_post_type( "research", $args );
}

// 12 News
function cpt_register_news() {

	/**
	 * Post Type: News.
	 */

	$labels = [
		"name" => __( "News", "custom-post-type-ui" ),
		"menu_name" => __( "News", "custom-post-type-ui" ),
		"singular_name" => __( "News", "custom-post-type-ui" ),
    "all_items" => __( "News list", "custom-post-type-ui" ),
    "add_new" => __( "Add News", "custom-post-type-ui" ),
    "add_new_item" => __( "Add News", "custom-post-type-ui" ),
    "edit_item" => __( "Edit News", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "news", "custom-post-type-ui" ),
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
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "news", "with_front" => false ],
		"query_var" => true,
		"supports" => [ "custom-fields" ],
		"show_in_graphql" => false,
		"menu_icon" => 'dashicons-megaphone',
		"menu_position" => 12
	];

	register_post_type( "news", $args );
}


// 13 Jobs
function cpt_register_job() {

	/**
	 * Post Type: job.
	 */

	$labels = [
		"name" => __( "Jobs", "custom-post-type-ui" ),
		"singular_name" => __( "Job", "custom-post-type-ui" ),
		"menu_name" => __( "Jobs", "custom-post-type-ui" ),
		"all_items" => __( "Jobs list", "custom-post-type-ui" ),
		"add_new" => __( "Add new job", "custom-post-type-ui" ),
    "add_new_item" => __( "New Job", "custom-post-type-ui" ),
    "edit_item" => __( "Edit Job", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Job", "custom-post-type-ui" ),
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
    	"menu_icon" => 'dashicons-edit',
		"supports" => ["custom-fields"],
		"show_in_graphql" => false,
    	"menu_position" => 18
	];

	register_post_type( "job", $args );
}
// 14 Team
function cpt_register_team() {

	/**
	 * Post Type: Team.
	 */

	$labels = [
		"name" => __( "Teams", "custom-post-type-ui" ),
		"singular_name" => __( "Team", "custom-post-type-ui" ),
		"menu_name" => __( "Teams", "custom-post-type-ui" ),
		"all_items" => __( "Teams list", "custom-post-type-ui" ),
		"add_new" => __( "Add new team", "custom-post-type-ui" ),
    "add_new_item" => __( "New Team", "custom-post-type-ui" ),
    "edit_item" => __( "Edit Team", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "team", "custom-post-type-ui" ),
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
		"map_meta_cap" => true,
		"hierarchical" => false,
		"query_var" => true,
    // "menu_icon" => 'dashicons-admin-users',
		"supports" => ["custom-fields"],
		"show_in_graphql" => false,
    "menu_position" => 17
	];

	register_post_type( "team", $args );
}


// 15 Talk
function cpt_register_talk() {

	/**
	 * Post Type: Talk.
	 */

	$labels = [
		"name" => __( "Talk", "custom-post-type-ui" ),
		"singular_name" => __( "talk", "custom-post-type-ui" ),
		"menu_name" => __( "talks", "custom-post-type-ui" ),
		"all_items" => __( "Talks list", "custom-post-type-ui" ),
		"add_new" => __( "Add new talk", "custom-post-type-ui" ),
    "add_new_item" => __( "New talk", "custom-post-type-ui" ),
    "edit_item" => __( "Edit talk", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "team", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"query_var" => true,
    // "menu_icon" => 'dashicons-admin-users',
		"supports" => ["custom-fields"],
		"show_in_graphql" => false,
    	"menu_position" => 27
	];

	register_post_type( "talk", $args );
}
