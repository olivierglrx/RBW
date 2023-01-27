<?php

/* 1- Add Menu : 'RbW plugins'
2- Load script and CSS
3- Load ajax  --> update/create 'activated_plugins' option 
4- Create RbW page. 

The options 'activated_plugins' is an array with value the same string as the buttons WITHOUT spaces 

 */


// 1- Add Menu : 'RbW plugins'
function add_menu_for_rbWeb() {
  add_menu_page('RbWeb', //Menu Name
        'RbW plugins', // Menu label
        'manage_options', // capability
        'RbWeb',// slug
        'Handle_all_menus' //function to call -> activated_plugins.php
        );
}
add_action('admin_menu', 'add_menu_for_rbWeb');


// 2- Load script and CSS
function activated_plugin_script_and_style() {
        wp_register_style( 'activated_button_css', plugin_dir_url(__FILE__).'css/activated_button_css.css');
        wp_enqueue_style( 'activated_button_css' );

        wp_register_script( 'activated_button_js', plugin_dir_url(__FILE__).'js/activated_button_js.js',array('jquery'));
        wp_enqueue_script( 'activated_button_js' );
        wp_localize_script( 'activated_button_js', 'adminAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ));
}
if (isset($_GET['page'])){
	if($_GET['page']=='RbWeb'){
		add_action( 'admin_enqueue_scripts', 'activated_plugin_script_and_style' );

	}
}


// 3-Use ajax / the 'envoyer' button is useless, it would be equivalent to reload the page. 
add_action( 'wp_ajax_activated_button', 'activate_plugin_ajax' );

// add_option( 'activated_plugins', [], '', 'yes' );
function activate_plugin_ajax(){
	$activated_plugin=[];
	foreach ($_GET as $key=> $value ) {
		if ($value==1){
			$activated_plugin[]=$key;
		}
	}
	update_option('activated_plugins',$activated_plugin);
	wp_send_json_success( $activated_plugin );
}



//  Create the page. 

function Handle_all_menus(){

	?>

	<div class="container" id='container'>
    <h2> Publication </h2>
    <div  class="rb-container">
		<div>
			<?php on_off_button('Publication');?>
		</div>
		<!-- <div id='publication_child_plugin'> -->
    <?php on_off_button('Arxiv');?>
			<?php on_off_button('BibTex');?>
			<?php on_off_button('Zotero');?>
			<?php on_off_button('ORCID');?>
			<?php on_off_button('HAL');?>
      <?php on_off_button('Pubmed');?>
      <?php on_off_button('OpenAlex');?>
      
    <?php on_off_button('Export Publications');?>

		</div>
    <h2> Member </h2>
    <div  class="rb-container">
		<div>
			<?php on_off_button('Member');?>
		</div>
    <div>
      <?php on_off_button('Member have publi');?>
    </div>
    </div>


	<h2> Others </h2>
    <div  class="rb-container">
    <!-- // 3 Miscellaneous
// 4 Facilities
// 5 Gallery
// 6 Fundings
// 7 outreach
// 8 Collaborator
// 9 Event -->
    <div>
      <?php on_off_button('Facilities');?>
    </div>
    <div>
      <?php on_off_button('Gallery');?>
    </div>
    <div>
      <?php on_off_button('Fundings');?>
    </div>
    <div>
      <?php on_off_button('Outreach');?>
    </div>
    <div>
      <?php on_off_button('Collaborator');?>
    </div>
    <div>
      <?php on_off_button('Event');?>
    </div>
    <div>
      <?php on_off_button('Experiment');?>
    </div>
    <div>
      <?php on_off_button('Research');?>
    </div>
    <div>
      <?php on_off_button('News');?>
    </div>
    <div>
      <?php on_off_button('Jobs');?>
    </div>
    <div>
      <?php on_off_button('Team');?>
    </div>
    <div>
      <?php on_off_button('Talk');?>
    </div>

    <div>
      <?php on_off_button('Miscellaneous');?>
    </div>

    <div>
      <?php on_off_button('PagesTemplate');?>
    </div>
    </div>




	<h2> Functionalities </h2>
  <div  class="rb-container">

    <div>
      <?php on_off_button('Custom Menu');?>
    </div>

    <div>
    <?php on_off_button('Multilingue');?>
  </div>



  <div>
    <?php on_off_button('Disable notices');?>
  </div>



   <!-- <div>
    <?php on_off_button('Block update');?>
  </div> 
  <div>
    <?php on_off_button('Change media name');?>
  </div> -->




</div>


	<form method='post'><input type="submit" name="Valider"></form>
	<?php
}






