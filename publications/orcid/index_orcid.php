<?php



function orcid_script(){
	// Specific css for the page
	wp_register_style( 'index_orcid_css', plugins_url( 'css', __FILE__ ).'/index_orcid.css');
    wp_enqueue_style( 'index_orcid_css' );

    // We  transform orcid entry into bibtex, then we parse the bib
    // wp_enqueue_script('bib-parser-js', plugin_dir_path( dirname( __FILE__ ) ).'bibtex/js/bibtexParseJs-master/bibtexParse.js');
    wp_register_script( 'bibtex_entry', plugins_url( 'js', __FILE__ ).'/bibtex_table_and_parser.js',array('jquery') );
    wp_enqueue_script( 'bibtex_entry' );

	wp_register_script( 'bibtex_parse', plugins_url( 'js', __FILE__ ).'/bibtexParse.js',array('jquery') );
    wp_enqueue_script( 'bibtex_parse' );

wp_enqueue_script('xmltojs', plugins_url( 'js', __FILE__ ).'/xmltojs.js');
    // Specific js, needed to parse and
    wp_enqueue_script('orcid-parser', plugins_url( 'js', __FILE__ ).'/orcid_parse.js');

    wp_localize_script( 'orcid-parser', 'adminAjax',
	array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));



}

if (isset($_GET['page'])){
	if($_GET['page']=='orcid'){
		add_action('admin_enqueue_scripts','orcid_script');
	}
}



function orcid_page_setup(){
	
	if(isset($_GET['pub']) && isset($_GET['id'])){
		$id=$_GET['id'];
	}
	else{
		$id='';
	}


	?>

	<!-- LOGO -->
	<div class='rb-img_container'>
		<img id='orcid_logo' src=" <?php echo(plugin_dir_url(__FILE__).'orcid_logo.png'); ?>">
	</div>


	<!-- Form -->
	<div class='rb-search'>
 		<input id='orcid' type="text" name="orcid" placeholder="Name or ORCID..." >
		<button id='action-button'  class='bn36 bn3637' type="submit" name="orcid_button"> Search </button>
	</div>

	<!-- Loading Bar -->
	<div id='load_bar_container' class="progress" style="margin:auto; display:none;">
		<div id ='load' class="color"></div>
	</div>


	<!-- Messages -->
  	<div  class='rb-message_container' >
    	<div  id='message'> </div>
  	</div>



 	<!-- Table -->
	<div id='table_container'>
    	<table id="myTable"  style="display:none;">
    		<thead>
    		</thead>

      		<tbody>
      		</tbody>
    	</table>
	</div>

	<!-- Buttons -->
   	<div id='button_container' style="display:none;">
		<button class='bn36 bn3637' id='add_all' onclick='toggle_all()' >Toggle All</button>
    	<button class='bn36 bn3637' id='add_all'onclick=<?php echo 'insert_publication('.$id.')'; ?> >Add to my Publications </button>
    </div>
<?php

}

add_action( 'wp_ajax_get_orcid_number_from_name', 'get_orcid_number_from_name');
add_action( 'wp_ajax_nopriv_get_orcid_number_from_name', 'get_orcid_number_from_name');
function get_orcid_number_from_name(){
	$name=$_POST['name'];
	$url='https://pub.orcid.org/v3.0/search/?q='.$name;
	$html = file_get_contents($url);
	echo $html;
}

add_action( 'wp_ajax_get_orcid_informations', 'get_orcid_informations');
add_action( 'wp_ajax_nopriv_get_orcid_informations', 'get_orcid_informations');
function get_orcid_informations(){

$xmlstr=file_get_contents($_POST['urlorcid']);



$xml2 = simplexml_load_string($xmlstr,null, 0, 'common', true);
$xml2->registerXPathNamespace("common", "http://www.orcid.org/ns/common" );

$xml = simplexml_load_string($xmlstr,null, 0, 'work', true);
$xml->registerXPathNamespace("work", "http://www.orcid.org/ns/work" );



 wp_send_json_success(array($xml2,$xml));



}
