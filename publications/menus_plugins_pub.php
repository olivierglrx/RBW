<?php
// Insert submenu of publication plugins according to there presence in the option "activated_plugins"


// 1 - Arxiv
// 2 - Pubmed
// 3 - Bibtex
// 4 - Zotero
// 5 - ORCID
// 6 - HAL

// 1 - Arxiv
if (in_array('Arxiv',get_option("activated_plugins"))){
	add_action('admin_menu', 'add_submenu_for_arxiv');
	function add_submenu_for_arxiv() {
	  add_submenu_page('edit.php?post_type=publication', //Parent slug
			'Arxiv', // page title
			'Arxiv', // Menu label
			'manage_options', // capability
			'arxiv',// slug
			'arxiv_page_setup',//function to call -> /arxiv/index_arxiv.php
			);
	} 
}

// 2 - Pubmed
if (in_array('Pubmed',get_option("activated_plugins"))){
	add_action('admin_menu', 'add_submenu_for_pubmed');
	function add_submenu_for_pubmed() {
		add_submenu_page('edit.php?post_type=publication', //Parent slug
			'Pubmed', // page title
			'Pubmed', // Menu label
			'manage_options', // capability
			'pubmed',// slug
			'pubmed_page_setup',//function to call -> /arxiv/index_arxiv.php

			);

	}
}

// 3 - Bibtex
if (in_array('BibTex',get_option("activated_plugins"))){
	add_action('admin_menu', 'add_submenu_for_Bibtex');
	function add_submenu_for_Bibtex() {
		add_submenu_page('edit.php?post_type=publication', //Parent slug
					'Bibtex', // page title
					'Bibtex', // Menu label
					'manage_options', // capability
					'Bibtex',// slug
					'Bibtex_page_setup',//function to call -> /bibtex/index_bibtex.php

					);
	}

	
}

// 4 - Zotero
if (in_array('Zotero',get_option("activated_plugins"))){
	add_action('admin_menu', 'add_submenu_for_zotero');
	function add_submenu_for_zotero() {
		add_submenu_page('edit.php?post_type=publication', //Parent slug
					'Zotero', // page title
					'Zotero', // Menu label
					'manage_options', // capability
					'zotero',// slug
					'Zotero_page_setup',//function to call -> /zotero/index_zotero.php

					);
	}
}

// 5 - ORCID
if (in_array('ORCID',get_option("activated_plugins"))){
	add_action('admin_menu', 'add_submenu_for_orcid');
	function add_submenu_for_orcid() {
		add_submenu_page('edit.php?post_type=publication', //Parent slug
					'ORCID', // page title
					'ORCID', // Menu label
					'manage_options', // capability
					'orcid',// slug
					'orcid_page_setup',//function to call -> /orcid/index_orcid.php

					);
	}
}

// 6 - HAL
if (in_array('HAL',get_option("activated_plugins"))){
	add_action('admin_menu', 'add_submenu_for_hal');
	function add_submenu_for_hal() {
		add_submenu_page('edit.php?post_type=publication', //Parent slug
					'HAL', // page title
					'HAL', // Menu label
					'manage_options', // capability
					'hal',// slug
					'hal_page_setup',//function to call -> /hal/index_hal.php

					);
	}
}


if (in_array('OpenAlex',get_option("activated_plugins"))){
	add_action('admin_menu', 'add_submenu_for_openalex');
	function add_submenu_for_openalex() {
		add_submenu_page('edit.php?post_type=publication', //Parent slug
					'OpenAlex', // page title
					'OpenAlex', // Menu label
					'manage_options', // capability
					'OpenAlex',// slug
					'OpenAlex_page_setup',//function to call -> /hal/index_hal.php

					);
	}
}




  