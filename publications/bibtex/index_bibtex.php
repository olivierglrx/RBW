<?php

function bibtex_script(){
    // Specific css for the page
    wp_register_style( 'index_bibtex_css', plugins_url( 'css', __FILE__ ).'/index_bibtex.css');
    wp_enqueue_style( 'index_bibtex_css' );

    // specific js for the page
    wp_register_script( 'bibtex_index', plugins_url( 'js', __FILE__ ).'/bibtex_index.js',array('jquery') );
    wp_enqueue_script( 'bibtex_index' );

    // Parsing bib tex, not mine
    wp_enqueue_script('bib-parser-js', plugins_url( 'js', __FILE__ ).'/bibtexParseJs-master/bibtexParse.js');
    // Display the parsing
    wp_register_script( 'bibtex_entry', plugins_url( 'js', __FILE__ ).'/bibtex_table_and_parser.js',array('jquery'));
    wp_enqueue_script( 'bibtex_entry' );

}

if (isset($_GET['page'])){
	if($_GET['page']=='Bibtex' ){
		add_action('admin_enqueue_scripts','bibtex_script');
	}
}

// add_action('wp_enqueue_scripts','bibtex_script');


function bibtex_page_setup(){

  if(isset($_GET['pub']) && isset($_GET['id'])){
    $id=$_GET['id'];
  }
  else{
    $id='';
  }
	?>
    <!-- LOGO -->
    <div class='rb-img_container'>
        <img id='bibtex_logo' src=" <?php echo(plugin_dir_url(__FILE__).'bibtex_logo.png'); ?>">
    </div>

    <!-- Form -->
    <div class='rb-container'>
        <div class="file-drop-area">
          <span class="fake-btn">Choose file</span>
          <span class="file-msg">Drag and drop file</span>
          <input id='file' class="file-input" type="file" multiple>
        </div>
        <textarea id='bib' name="Text1" cols="50" rows="5" placeholder="Or copy paste a bibtex entry"></textarea>
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
        <button class='bn36 bn3637' id='add_all' onclick='toggle_all()' >Toggle All</button>
        <button class='bn36 bn3637' id='add_all' onclick=<?php echo 'insert_publication('.$id.')'; ?> >Add to my Publications </button>
    </div>
<?php
}
