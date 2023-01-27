<?php



function pubmed_script(){
	// Specific css for the page
	wp_register_style( 'index_pubmed_css', plugins_url( 'css', __FILE__ ).'/index_pubmed.css');
    wp_enqueue_style( 'index_pubmed_css' );

    // We  transform orcid entry into bibtex, then we parse the bib
	wp_register_script( 'bibtex_entry', plugins_url( 'js', __FILE__ ).'/bibtex_table_and_parser.js',array('jquery') );
    wp_enqueue_script( 'bibtex_entry' );

	wp_register_script( 'bibtex_parse', plugins_url( 'js', __FILE__ ).'/bibtexParse.js',array('jquery') );
    wp_enqueue_script( 'bibtex_parse' );

    // Specific js, needed to parse and
    wp_enqueue_script('pubmed-parser', plugins_url( 'js', __FILE__ ).'/pubmed_parse.js');
    wp_localize_script( 'pubmed-parser', 'adminAjax',
	array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));



}

if (isset($_GET['page'])){
	if($_GET['page']=='pubmed'){
		add_action('admin_enqueue_scripts','pubmed_script');
	}
}


function pubmed_page_setup(){
	if(isset($_GET['pub']) && isset($_GET['id'])){
		$id=$_GET['id'];
	}
	else{
		$id='';
	}


	?>

	<!-- LOGO -->
	<div class='rb-img_container'>
		<img id='pubmed_logo' src=" <?php echo(plugin_dir_url(__FILE__).'pubmed_logo.png'); ?>">
	</div>


	<!-- Form -->
	<div class='rb-search'>
 		<input id='pubmed' type="text" name="pubmed" placeholder="Name..." >
		<button id='action-button'  class='bn36 bn3637' type="submit" name="pubmed_button"> Search </button>
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
    	<button class='bn36 bn3637' id='add_all' onclick=<?php echo 'insert_publication('.$id.')'; ?> >Add to my Publications </button>
    </div>
<?php

}





add_action( 'wp_ajax_get_pubmed_informations', 'get_pubmed_informations');
add_action( 'wp_ajax_nopriv_get_pubmed_informations', 'get_pubmed_informations');
function get_pubmed_informations(){
$url="https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=pubmed&rettype=abstract&id=".$_POST['id'];
$xmlstr=file_get_contents($url);

$xml = new SimpleXMLElement($xmlstr);

 wp_send_json_success($xml);



}
