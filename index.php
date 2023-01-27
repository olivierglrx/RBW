<?php
/*
Plugin Name: Rubidium Web Plugin
Plugin URI: www.rubidiumweb.fr
Description: Rb plugin
Author: Rb83 and Rb87
Version: 1.0.8
Author URI: http://www.rubidiumweb.fr/
*/


// http://localhost:8888/wp-content/plugins/rbw-wp-plugin/
define( 'MY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
//MY_PLUGIN_PATH /Users/olivierglorieux/Documents/Site-Project/wordpress/wp-content/plugins/rbw-wp-plugin/
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

include('Test/test_index.php');
include('cpt.php');
include('taxonomies.php');
include('help.php');
include('multisitequery.php');

include('SuperAdmin/index_superadmin.php');

// Not my plugin.
include('post-types-order/post-types-order.php');

// include('Others/others_index.php');
// include('superAdmin/activated_plugins.php');
// include('superAdmin/menus.php');

include('search-bar/search.php');



if(is_array(get_option("activated_plugins"))):
	if (in_array('Publication',get_option("activated_plugins"))){
		include(plugin_dir_path(__FILE__).'publications/index_publications.php');

		if (in_array('Arxiv',get_option("activated_plugins"))){
			include(plugin_dir_path(__FILE__).'publications/arxiv/index_arxiv.php');
		}
		if (in_array('BibTex',get_option("activated_plugins"))){
			include(plugin_dir_path(__FILE__).'publications/bibtex/index_bibtex.php');
		}
		if (in_array('Zotero',get_option("activated_plugins"))){
			include(plugin_dir_path(__FILE__).'publications/zotero/index_zotero.php');
		}
		if (in_array('ORCID',get_option("activated_plugins"))){
			include(plugin_dir_path(__FILE__).'publications/orcid/index_orcid.php');
		}
		if (in_array('HAL',get_option("activated_plugins"))){
			include(plugin_dir_path(__FILE__).'publications/hal/index_hal.php');
		}
		if (in_array('Pubmed',get_option("activated_plugins"))){
			include(plugin_dir_path(__FILE__).'publications/pubmed/index_pubmed.php');
		}

		include(plugin_dir_path(__FILE__).'publications/openalex/index_openalex.php');
	}


		
	if (in_array('Member',get_option("activated_plugins"))){
		include(plugin_dir_path(__FILE__).'members/index_members.php');
	}
	


	// Load CPT:
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

	if (in_array('Miscellaneous',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_miscellaneous' );
	}
	if (in_array('Facilities',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_facilities' );
	}
	if (in_array('Gallery',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_gallery' );
	}
	if (in_array('Fundings',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_fundings' );
	}
	if (in_array('Outreach',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_outreach' );
	}
	if (in_array('Collaborator',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_collaborator' );
	}
	if (in_array('Event',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_event' );
	}
	if (in_array('Experiment',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_experiment' );
	}
	if (in_array('Research',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_research' );
	}
	if (in_array('News',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_news' );
	}
	if (in_array('Jobs',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_job' );
	}
	if (in_array('Team',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_team' );
	}
	if (in_array('Talk',get_option("activated_plugins"))){
		add_action( 'init', 'cpt_register_talk' );
	}



	




endif;