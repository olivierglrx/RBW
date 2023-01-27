<?php 


function OpenAlex_script(){
	// Specific css for the page
	wp_register_style( 'index_OpenAlex_css', plugins_url( 'css', __FILE__ ).'/index_OpenAlex.css');
    wp_enqueue_style( 'index_OpenAlex_css' );

    // We  transform orcid entry into bibtex, then we parse the bib
    // wp_enqueue_script('bib-parser-js', plugin_dir_path( dirname( __FILE__ ) ).'bibtex/js/bibtexParseJs-master/bibtexParse.js');
    // wp_register_script( 'bibtex_entry',PUB_URL.'js/bibtex_table_and_parser.js',array('jquery') );
    wp_enqueue_script( 'bibtex_entry' );

	// wp_register_script( 'bibtex_parse', PUB_URL.'js/bibtexParse.js',array('jquery') );
    wp_enqueue_script( 'bibtex_parse' );


    
    wp_register_script( 'OpenAlex_script', plugins_url( 'js', __FILE__ ).'/openalex_parse.js');
    wp_enqueue_script( 'OpenAlex_script' );

    wp_localize_script( 'OpenAlex_script', 'adminAjax',
	array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));



}

if (isset($_GET['page'])){
	if($_GET['page']=='OpenAlex'){
		add_action('admin_enqueue_scripts','OpenAlex_script');
	}
}



function OpenAlex_page_setup(){

	if(isset($_GET['pub']) && isset($_GET['id'])){
		$id=$_GET['id'];
	}
	else{
		$id='';
	}

	// get_OpenAlex_content();

	?>
<script src="https://fred-wang.github.io/mathml.css/mspace.js"></script>

	<!-- LOGO -->
	<div class='rb-img_container'>
		<img id='OpenAlex_logo' src=" <?php echo(plugin_dir_url(__FILE__).'OpenAlex_logo.png'); ?>">
	</div>


	<!-- Form -->
	<div class='rb-search'>
 		<input id='orcid' type="text" name="OpenAlex" placeholder="Name or ORCID number..." >
		<button id='action-button'  class='bn36 bn3637' type="submit" name="OpenAlex_button"> Search </button>
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


add_action( 'wp_ajax_get_OpenAlex_ID_from_name', 'get_OpenAlex_ID_from_name');
add_action( 'wp_ajax_nopriv_get_OpenAlex_ID_from_name', 'get_OpenAlex_ID_from_name');
function get_OpenAlex_ID_from_name(){
    $name=$_POST['name'];
	$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    $header = file_get_contents('https://api.openalex.org/authors?filter=display_name.search:'.$name ,false,$context);
	
    wp_send_json_success($header ) ;
}

add_action( 'wp_ajax_get_OpenAlex_ID_from_ORCID', 'get_OpenAlex_ID_from_ORCID');
add_action( 'wp_ajax_nopriv_get_OpenAlex_ID_from_ORCID', 'get_OpenAlex_ID_from_ORCID');
function get_OpenAlex_ID_from_ORCID(){
    $ORCID=$_POST['ORCID'];
	$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    $header = file_get_contents('https://api.openalex.org/authors?filter=orcid:https://orcid.org/'.$ORCID ,false,$context);
    wp_send_json_success($header ) ;
}



https://api.openalex.org/works?filter=author.id:A2479014094
add_action( 'wp_ajax_get_OpenAlex_content', 'get_OpenAlex_content');
add_action( 'wp_ajax_nopriv_get_OpenAlex_content', 'get_OpenAlex_content');

function get_OpenAlex_content(){
    $OpenAlexID=$_POST['OpenAlexID'];
    $page=$_POST['page'];
    
	$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    
    $content=file_get_contents("https://api.openalex.org/works?filter=author.id:".$OpenAlexID.'&per-page=10&page='.$page,false, $context);
	
    // echo ($content);
    wp_send_json_success( $content);
}