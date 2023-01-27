<?php 

// Menu
// Page
// export functions

// Menu 
add_action('admin_menu', 'add_submenu_for_export');
	function add_submenu_for_export() {
		add_submenu_page('edit.php?post_type=publication', //Parent slug
					'Export', // page title
					'Export', // Menu label
					'manage_options', // capability
					'Export',// slug
					'export_page_setup',//function to call -> /bibtex/export.php

					);
	}

// Page 

function export_page_setup(){
  $args = array(
    'post_type' =>'publication',
    'numberposts'=>-1,
  );
  $posts=get_posts($args);
  $list=array();
  foreach($posts as $post){
   $list[]=get_field();
  }








?>

<?php

 

  $args = array(
      'post_type' =>'publication',
      'numberposts'=>-1,
    );
    $posts=get_posts($args);
    $list='';
    foreach($posts as $post){
      $list.=export_publi_as_bibtex($post->ID);
    }
      
      $file = plugin_dir_path(__FILE__).'export.txt';
      
     
      file_put_contents($file, $list);
      
     ?>
     <a href=<?php echo(plugin_dir_url(__FILE__).'export.txt' ); ?> download>
      <button id='export_button' >Export my Publications </button>
    </a>
    <style type="text/css">
    
    
    
   #export_button {
  background-color: #008CBA; /* Blue */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
} 
  </style>
<?php

}


function export_publi_as_bibtex($ID){
$title=get_field('publication_title',$ID);
$first_word_title=explode(' ', $title)[0];
$authors=get_field('publication_authors',$ID);
$first_author=explode(' ', $authors)[0];
$date=get_field('publication_dop',$ID);
$volume=get_field('publication_volume',$ID);
$journal=get_field('publication_journal',$ID);
$pages=get_field('publication_pages',$ID);
$DOI=get_field('publication_doi',$ID);
$abstract=str_replace('<br>',' ', get_field('publication_abstract',$ID));
$abstract=str_replace('<br />',' ',$abstract);
$abstract=str_replace('<p>',' ',$abstract);
$abstract=str_replace('</p>',' ',$abstract);
$publisher=get_field('publication_publisher',$ID);
$publisher_link=get_field('publication_link',$ID);
$open_link=get_field('publication_arxiv_url',$ID);
$type=get_field('publication_type_select',$ID);

if (!$type){
  $type='article';
}
$bibtexentry='@'.$type.'{';
$bibtexentry.=$first_author.$date.$first_word_title.','."\r\n";
$bibtexentry.='title={'.$title.'},'."\n";
$bibtexentry.='author={'.$authors.'},'."\n";
$bibtexentry.='journal={'.$journal.'},'."\n";
$bibtexentry.='volume={'.$volume.'},'."\n";
$bibtexentry.='pages={'.$pages.'},'."\n";
$bibtexentry.='year={'.$date.'},'."\n";
$bibtexentry.='DOI={'.$DOI.'},'."\n";
$bibtexentry.='abstract={'.$abstract.'},'."\n";
$bibtexentry.='open_link={'.$open_link.'},'."\n";
$bibtexentry.='publisher={'.$publisher.'},'."\n";
$bibtexentry.='}'."\n"."\n";
return($bibtexentry);
}