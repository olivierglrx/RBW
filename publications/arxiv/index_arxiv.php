<?php



function arxiv_scripts(){

	wp_register_style( 'index_arxiv_css', plugins_url( 'css', __FILE__ ).'/index_arxiv.css');
    wp_enqueue_style( 'index_arxiv_css' );

   //  wp_register_script( 'insert_in_data_base_arxiv', plugins_url().'/rbWeb/publications/js/insert_in_data_base_arxiv.js',array('jquery') );
  	// wp_enqueue_script( 'insert_in_data_base_arxiv' );
  	// wp_localize_script( 'insert_in_data_base_arxiv', 'adminAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));



  	wp_register_script( 'parse_arxiv', plugins_url( 'js', __FILE__ ).'/parse_arxiv.js',array('jquery') );
  	wp_enqueue_script( 'parse_arxiv' );
  	wp_localize_script( 'parse_arxiv', 'adminAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));


}

if (isset($_GET['page'])){
	if($_GET['page']=='arxiv'){
		add_action('admin_enqueue_scripts','arxiv_scripts');
	}

}



function arxiv_page_setup(){
	if(isset($_GET['pub']) && isset($_GET['id'])){
		$id=$_GET['id'];
	}
	else{
		$id='';
	}
	?>
	<!-- LOGO -->
	<div class='search_container'>
		<img id='arxiv_logo' src=" <?php echo(plugin_dir_url(__FILE__).'arxiv_logo.png'); ?>">
	</div>
	<!-- Search -->
	<div class='rb-search'>
		<input id="search_input" type="text" name="arxiv_author_search" size="50" placeholder="Search..." >
		<button class='bn36 bn3637' id='action-button' >Search</button>
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
    <div  id='table_container' >
        <table id="myTable"  style="display:none;">
        	<thead>
          	</thead>

			<tbody>
			</tbody>
      </table>
    </div>



    <!-- Buttons -->
    <div id='button_container' style="display:none;">
        <button class='bn36 bn3637' id='toggle_all' onclick='toggle_all()' >Toggle All</button>
        <button class='bn36 bn3637' id='see_more' >See More</button>
        <button class='bn36 bn3637' id='add_all'  onclick=<?php echo 'insert_publication('.$id.')'; ?> >Add to my Publications </button>
    </div>
	<?php

}





add_action( 'wp_ajax_parsing_arxiv', 'parsing_arxiv');
add_action( 'wp_ajax_nopriv_parsing_arxiv', 'parsing_arxiv');

function parsing_arxiv(){
	$authors=$_POST['authors'];

	$query=file_get_contents('http://export.arxiv.org/api/query?search_query='.$authors."&max_results=20&sortBy=relevance");
	$xml= simplexml_load_string($query);

	$list_of_publications=[];
	foreach ($xml->{'entry'} as $entry ) {
		$publication= array();
		$publication['title']     =(string)$entry->{'title'};
		$publication['abstract']  =(string)$entry->{'summary'};
		$publication['url']       =(string)$entry->{'id'};
		$publication['year']      =(string)$entry->{'published'};
		$publication['authors']   =[];
		foreach ($entry->{'author'} as $author) {
			$publication['authors'][]=(string)$author->{'name'};
		}
		$publication['tags']   =[];
		foreach($entry->{'category'} as $category =>$value){
			foreach ($value->attributes() as $key=>$value) {
				if ($key=='term'){
					$publication['tags'][]=(string)$value;
				}
			}

		}
	$list_of_publications[]=$publication;

	}
	wp_send_json_success($list_of_publications);
}







add_action( 'wp_ajax_see_more_arxiv', 'see_more_arxiv_articles');
add_action( 'wp_ajax_nopriv_see_more_arxiv', 'see_more_arxiv_articles');
function see_more_arxiv_articles(){
	$authors=$_POST['authors'];
	$authors=str_replace(' ', "+", $authors);
	$query=file_get_contents('http://export.arxiv.org/api/query?search_query='.$authors.'&start='.$_POST['start'].'&max_results=20&sortBy=relevance');
	$xml= simplexml_load_string($query);

	$list_of_publications=[];
	foreach ($xml->{'entry'} as $entry ) {
		$publication= array();
		$publication['title']     =(string)$entry->{'title'};
		$publication['abstract']  =(string)$entry->{'summary'};
		$publication['url']       =(string)$entry->{'id'};
		$publication['year']      =(string)$entry->{'published'};
		$publication['authors']   =[];
		foreach ($entry->{'author'} as $author) {
			$publication['authors'][]=(string)$author->{'name'};
		}
		$publication['tags']   =[];
		foreach($entry->{'category'} as $category =>$value){
			foreach ($value->attributes() as $key=>$value) {
				if ($key=='term'){
					$publication['tags'][]=(string)$value;
				}
			}

		}
	$list_of_publications[]=$publication;

	}
	wp_send_json_success($list_of_publications);

}
