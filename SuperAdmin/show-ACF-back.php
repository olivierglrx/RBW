<?php
/* Handle display of ACF_options for multisite installation. 
We have a bundle of predefined ACF_options and here we can check/uncheck the acf we want to show. 

O- Change ACF load point 
1- Submenu creation 

3- Hide ACF that are not checked  on cpt pages. 
4- CSS and JS for show-acf page. 
5- Create the RbW>ACF page. 
*/



//0-  Change ACF-load file end point:
function my_acf_json_load_point( $paths ) {
  // remove original path (optional)
  unset($paths[0]);

  // append path
  $paths[] = MY_PLUGIN_PATH.'acf';
  // return
  return $paths;
}

add_filter('acf/settings/load_json', 'my_acf_json_load_point');


function my_acf_json_save_point( $path ) {
    // update path
  $path = MY_PLUGIN_PATH.'acf';
  return $path;
}
add_filter('acf/settings/save_json', 'my_acf_json_save_point');



// 1- Add submenu
function add_submenu_for_acf() {
  add_submenu_page('RbWeb', //Parent slug
        'HandleACF-back', // page title
        'ACF', // Menu label
        'manage_options', // capability
        'ACF-back',// slug
        'handle_acf',//function to call 
        );

}
add_action('admin_menu', 'add_submenu_for_acf');


// 3 - Hide the acf that are not checked. 
function sa_hide_acf(){
  if (isset($_GET['post_type'])){
    // for new post
    $cpt=$_GET['post_type'];
  }
  elseif (isset($_GET['post'])){
    // for edit post
    $cpt = get_post_type();
  }
  else{
    return;
  }
 
  
  
  if(!key_exists($cpt,get_option('activated_acf_on_back'))) 
    return;

  $all_acf=rb_get_acf($cpt, 'name');
  $selected_acf=get_option('activated_acf_on_back')[$cpt];
  $not_activated=array_diff($all_acf,$selected_acf);
  echo'<style type="text/css">';
  foreach($not_activated as $option){
    echo('
  div[data-name='.$option.']{
      display:none;
    }
  ');
  }
    echo'</style>';
}
add_action('admin_enqueue_scripts', 'sa_hide_acf');









// 4 - CSS and JS for show-acf page. 


function handle_js_ACF(){
  wp_register_script( 'hide_show_acf', plugins_url('js',__FILE__).'/usefullscript.js');
  wp_enqueue_script( 'hide_show_acf' );
}
add_action('admin_enqueue_scripts','handle_js_ACF');


function add_common_css_for_admin_ACF(){
  wp_register_style( 'handle_acf', plugins_url('css',__FILE__).'/handle_ACF.css');
  wp_enqueue_style( 'handle_acf' );

}

if (isset($_GET['page'])){
	if($_GET['page']=='ACF-front' || $_GET['page']=='ACF-back' || $_GET['page']=='ACF-options' || $_GET['page']=="Role"){
		add_action('admin_enqueue_scripts','add_common_css_for_admin_ACF');
	}
}

$member_basic_acf=array('member_first_name', 'member_last_name', 'member_email');
$publication_basic_acf=array('publication_title','publication_authors','publication_dop','publication_journal');







// 5- Create the Rb>show-acf page. 

function activate_acf($cpt){

  $activated_acf=get_option('activated_acf_on_back');
	$activated_acf[$cpt]=[];

	foreach ($_POST as $key=> $value ) {
		if ($value=='on'){
			$activated_acf[$cpt][]=$key;
		}
	}
	update_option('activated_acf_on_back',$activated_acf);

}

function handle_acf(){
  if (isset($_POST['cpt'])){
  activate_acf($_POST['cpt']);

  }

  echo(
  "<div id='rb-nav-bar-acf'>
  <ul>");

  $cpts= get_cpt();
  foreach ($cpts as $cpt) {
    echo('<li><a href="admin.php?page=ACF-back&cpt='.$cpt.'">'.$cpt.'</a></li>');
  }
  echo(
  "</ul>
  </div>");

  echo('<div>');



  if (isset($_GET['cpt'])){

    $cpt=$_GET['cpt'];

    if (!array_key_exists($cpt,get_option('activated_acf_on_back'))){

      $acf_back=get_option('activated_acf_on_back');
      $acf_back[$cpt][]=[];
      update_option('activated_acf_on_back',$acf_back);
    }else{
      $acf_back=get_option('activated_acf_on_back');
    }

    $groups = acf_get_field_groups(array('post_type' => $cpt));
    
    
    
    

    echo('<form method="post"> ');
    $n_groups=count($groups);
    for ($i = 0; $i < $n_groups; $i++) {
      $fields = acf_get_fields($groups[$i]['key']);
      echo '<p>'.$groups[$i]['title'].'</p>';
      foreach ($fields as $key){
        ?>
        <input type="checkbox" id="scales" name=" <?php echo($key['name'].'"');
  
        if (in_array($key['name'],$acf_back[$cpt],false)) {
          echo('checked >');
        }
  
        ?>
        <label for="scales"><?php echo($key['label']); echo('('.$key['name'].')');?></label>
        </br>
         <?php
      }
  
    }
    

    echo('<input type="submit" name="cpt" value='.$cpt.'></form>');
    echo('<button type="button" name="checkall" onclick="check_all()" >checkall</button>');
    echo('<button type="button" name="uncheckall" onclick="uncheck_all()" >uncheckall</button>');
  }
echo('</div>');
};
