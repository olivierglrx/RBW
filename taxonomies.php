<?php



function register_publication_tax() {

	/**
	 * Taxonomy: Publication Year Tax.
	 */



	$labels = [
		"name" => __( "Publication Year Tax", "custom-post-type-ui" ),
		"singular_name" => __( "Publication Year Tax", "custom-post-type-ui" ),
	];


	$args = [
		"label" => __( "Publication Year Tax", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => false,
		"show_in_menu" => false,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'publication_year', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "publication_year",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "publication_year", [ "publication" ], $args );


	/**
	 * Taxonomy: Publication Tags Tax.
	 */

	$labels = [
		"name" => __( "Publication Tags Tax", "custom-post-type-ui" ),
		"singular_name" => __( "Publication Tag Tax", "custom-post-type-ui" ),
	];


	$args = [
		"label" => __( "Publication Tags Tax", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => false,
		"show_in_menu" => false,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'publication_tags', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "publication_tags",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "publication_tags", [ "publication" ], $args );



	/**
	 * Taxonomy: Publication Statuts Tax.
	 */

  $show=false;
  $user=wp_get_current_user();
  if($user->exist()){
    $role=$user->roles[0];
    if ($role=='administrator'){
      $show=true;
    }
  }
  
 

	$labels = [
		"name" => __( "Publication Statut Tax", "custom-post-type-ui" ),
		"singular_name" => __( "Publication Statut Tax", "custom-post-type-ui" ),
	];


	$args = [
		"label" => __( "Publication Statut Tax", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => $show,
		"show_in_menu" => $show,
		"show_in_nav_menus" => $show,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'publication_statut', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "publication_statut",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
		"show_in_graphql" => false,
	];


  /**
	 * Taxonomy: Publication Year mod 5 Tax
	 */

	register_taxonomy( "publication_statut", [ "publication" ], $args );

			$labels = [
				"name" => __( "Publication Year mod 5 Tax", "custom-post-type-ui" ),
				"singular_name" => __( "Publication Year mod 5 Tax", "custom-post-type-ui" ),
			];


			$args = [
				"label" => __( "Publication Year mod 5 Tax", "custom-post-type-ui" ),
				"labels" => $labels,
				"public" => true,
				"publicly_queryable" => true,
				"hierarchical" => false,
				"show_ui" => false,
				"show_in_menu" => false,
				"show_in_nav_menus" => false,
				"query_var" => true,
				"rewrite" => [ 'slug' => 'publication_year_mod_5', 'with_front' => true, ],
				"show_admin_column" => false,
				"show_in_rest" => false,
				"rest_base" => "publication_year_mod_5",
				"rest_controller_class" => "WP_REST_Terms_Controller",
				"show_in_quick_edit" => false,
				"show_in_graphql" => false,
			];
			register_taxonomy( "publication_year_mod_5", [ "publication" ], $args );


			register_taxonomy('publication_authors', 'publication', array(
			    'hierarchical' => false,
			    'label' => "Publication authors",
			    'singular_name' => "Publication author",
			    // 'rewrite' => true,
			    'query_var' => true,
          "show_ui" => false,
			    )
			);

	}


// MEMBER tax
function register_member_tax() {

        /**
         * Taxonomy: member_status.
         */
        
        $show=false;
        $user=wp_get_current_user();
        if($user->exist()){
          $role=$user->roles[0];
          if ($role=='administrator'){
            $show=true;
          }
        }
       
        $labels = [
          "name" => __( "Statut (EN)", "custom-post-type-ui" ),
          "singular_name" => __( "Member status", "custom-post-type-ui" ),
        ];
       
       
        $args = [
          "label" => __( "Member status tax label", "custom-post-type-ui" ),
          "labels" => $labels,
          "public" => true,
          "publicly_queryable" => true,
          "hierarchical" => false,
          "show_ui" => $show,
          "show_in_menu" => true,
          "show_in_nav_menus" => true,
          "query_var" => true,
          "rewrite" => [ 'slug' => 'member_status_tax', 'with_front' => true, ],
          "show_admin_column" => true,
          "show_in_rest" => false,
          "rest_base" => "member_status_tax",
          "rest_controller_class" => "WP_REST_Terms_Controller",
          "show_in_quick_edit" => false,
          "show_in_graphql" => false,
        ];
        register_taxonomy( "member_status_tax", [ "member" ], $args );
         wp_insert_term( 'PhD student' , 'member_status_tax');
         wp_insert_term( 'Professor' , 'member_status_tax');
         wp_insert_term( 'Associate Professor' , 'member_status_tax');
         wp_insert_term( 'PI' , 'member_status_tax');
         wp_insert_term( 'Post-Doc' , 'member_status_tax');
         wp_insert_term( 'Master student' , 'member_status_tax');
         // wp_insert_term( 'Alumni' , 'member_status_tax');
       
        /**
         * Taxonomy: member_keywords
         */
       
        $labels = [
          "name" => __( "Keywords", "custom-post-type-ui" ),
          "singular_name" => __( "Member keywords", "custom-post-type-ui" ),
        ];
        $args = [
          "label" => __( "Member keywords", "custom-post-type-ui" ),
          "labels" => $labels,
          "public" => true,
          "publicly_queryable" => true,
          "hierarchical" => false,
          "show_ui" => false,
          "show_in_menu" => true,
          "show_in_nav_menus" => true,
          "query_var" => true,
          "rewrite" => [ 'slug' => 'member_keywords', 'with_front' => true, ],
          "show_admin_column" => true,
          "show_in_rest" => false,
          "rest_base" => "member_keywords",
          "rest_controller_class" => "WP_REST_Terms_Controller",
          "show_in_quick_edit" => false,
          "show_in_graphql" => false,
        ];
        register_taxonomy( "member_keywords", [ "member" ], $args );
       }

// Duplicate tax for multilingue
function register_multilingue_tax() {

        /**
         * Taxonomy: member_status.
         */
       
        $labels = [
          "name" => __( "Statut (FR)", "custom-post-type-ui" ),
          "singular_name" => __( "Member status (FR)", "custom-post-type-ui" ),
        ];
       
       
        $args = [
          "label" => __( "Member status  FR", "custom-post-type-ui" ),
          "labels" => $labels,
          "public" => true,
          "publicly_queryable" => true,
          "hierarchical" => false,
          "show_ui" => false,
          "show_in_menu" => true,
          "show_in_nav_menus" => true,
          "query_var" => true,
          "rewrite" => [ 'slug' => 'member_status_tax_fr', 'with_front' => true, ],
          "show_admin_column" => true,
          "show_in_rest" => false,
          "rest_base" => "member_status_tax",
          "rest_controller_class" => "WP_REST_Terms_Controller",
          "show_in_quick_edit" => false,
          "show_in_graphql" => false,
        ];
        register_taxonomy( "member_status_tax_fr", [ "member" ], $args );
         wp_insert_term( 'Doctorant' , 'member_status_tax_fr');
         wp_insert_term( 'Professeur' , 'member_status_tax_fr');
         wp_insert_term( 'Maitre de Conférence' , 'member_status_tax_fr');
         wp_insert_term( 'Post-doctorant' , 'member_status_tax_fr');
         wp_insert_term( 'Chef de département' , 'member_status_tax_fr');
         wp_insert_term( 'Professeur hémérite' , 'member_status_tax_fr');
         wp_insert_term( 'Etudiant Master' , 'member_status_tax_fr');
         // wp_insert_term( 'Alumni' , 'member_status_tax');
       
        /**
         * Taxonomy: member_keywords
         */
       
        $labels = [
          "name" => __( "Mot-clé ", "custom-post-type-ui" ),
          "singular_name" => __( "Member mot-clé", "custom-post-type-ui" ),
        ];
        $args = [
          "label" => __( "Member mot-clés", "custom-post-type-ui" ),
          "labels" => $labels,
          "public" => true,
          "publicly_queryable" => true,
          "hierarchical" => false,
          "show_ui" => false,
          "show_in_menu" => true,
          "show_in_nav_menus" => true,
          "query_var" => true,
          "rewrite" => [ 'slug' => 'member_keywords_fr', 'with_front' => true, ],
          "show_admin_column" => true,
          "show_in_rest" => false,
          "rest_base" => "member_keywords_fr",
          "rest_controller_class" => "WP_REST_Terms_Controller",
          "show_in_quick_edit" => false,
          "show_in_graphql" => false,
        ];
        register_taxonomy( "member_keywords_fr", [ "member" ], $args );
       }
       
       