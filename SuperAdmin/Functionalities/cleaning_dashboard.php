<?php
// 1 - Remove separator
// 2 - Remove not necessary in wp_admin_bar
// 3 - Remove not necessary in menu
// 4 - Remove WP update
// 5 - Remove warnings
// 6 - Change the howdy menu
// 7.1- Hide publish meta box
// 7.1- Hide screen option
// 8 - DASHBOARD customisation 
// 9 - change media name
// 10 Create option pages for every CPT


// 1 - Remove separator in admin left menu.
add_action('admin_init', function(){
  global $menu;
  remove_menu_page("separator1");
  remove_menu_page("separator2");
  remove_menu_page("separator-last");
  remove_menu_page("separator-elementor");
});

// 2 - Remove not necessary in wp_admin_bar
add_action( 'wp_before_admin_bar_render', function(){
  global $wp_admin_bar;
  $role=wp_get_current_user()->roles[0];

  // Don't hide anything for administrator
  if ($role=='administrator'){
    return;
  }
  // Don't do anything if role is not setup
  if (!key_exists($role, get_option('hide_show_menu'))){
    return;
  }
  // Hide admin bar items
  $options = get_option('hide_show_menu')[$role];
  foreach($options as $option){
    if (!str_contains($option,'menu-') ){
      $wp_admin_bar->remove_node( $option );
    }
  }
});

// 3 - Remove not necessary in menu
add_action( 'admin_init', function(){
  $role=wp_get_current_user()->roles[0];
  // Don't hide anything for administrator
  if ($role=='administrator'){
    return;
  }
  // Don't do anything if role is not setup
  if (!array_key_exists($role, get_option('hide_show_menu'))){
    return;
  }
  // Hide menu items
  $options = get_option('hide_show_menu')[$role];
  foreach($options as $option){
    if (str_contains($option,'menu-') ){ 
      $menu_name=substr($option,5); //delete the 'menu-' at the beginning. 
      remove_menu_page($menu_name);
    }
    if($option=='profile'){
      remove_menu_page('profile.php');
    }
  }
//remove the my-sites menu
  remove_submenu_page( 'index.php', 'my-sites.php' );
});

function adjust_the_wp_menu() {
  $page = remove_submenu_page( 'index.php', 'my-sites.php' );
}
add_action( 'admin_menu', 'adjust_the_wp_menu');


//4- Remove WP update
function remove_core_updates(){
  global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
  }
add_action('admin_init', function(){
  $role=wp_get_current_user()->roles[0];
  // Don't hide anything for administrator
  if ($role=='administrator'){
    return;
  }

  if (in_array('Disablenotices',get_option("activated_plugins"))){
    add_filter('pre_site_transient_update_core','remove_core_updates'); //hide updates for WordPress itself
    add_filter('pre_site_transient_update_plugins','remove_core_updates'); //hide updates for all plugins
    add_filter('pre_site_transient_update_themes','remove_core_updates'); //hide updates for all themes
}
});

// 5 - Remove warnings
function rb_disable_notice() { ?>
  <style> .notice { display: none;},
   .error.pa-notice-wrap { display: none;},
   .updated { display: none;},
  
   </style>
 <?php }

if(is_array(get_option("activated_plugins"))){
  if (in_array('Disablenotices',get_option("activated_plugins"))){
    add_action('admin_head', 'rb_disable_notice');
  }
}



 // 6 Change the howdy menu
 add_filter( 'admin_bar_menu', 'replace_wordpress_howdy', 25 );
  function replace_wordpress_howdy( $wp_admin_bar ) {
    $my_account = $wp_admin_bar->get_node('edit-profile');
    $newtext = str_replace( 'Edit Profile', 'Change Password', $my_account->title );
    $wp_admin_bar->add_node( array(
    'id' => 'edit-profile',
    'title' => $newtext,
    ) );

    $my_account = $wp_admin_bar->get_node('my-account');
    $newtext = str_replace( 'Howdy,', 'Welcome', $my_account->title );
    $wp_admin_bar->add_node( array(
    'id' => 'my-account',
    'title' => $newtext,
    ) );

    $my_account = $wp_admin_bar->get_node('user-info');
    $wp_admin_bar->add_node( array(
    'id' => 'user-info',
    'title' =>'' ,
    ) );
  }


  //7.1- Hide publish meta box
  function hide_publishing_actions(){
    $role=wp_get_current_user()->roles[0];
    if ($role=='administrator'){
      return;
    }

  echo '
      <style type="text/css">
          #misc-publishing-actions,
          #minor-publishing-actions,
          #ssp-builddiv,
          #single-export
          {
              display:none;
          }

      </style>
  ';
    
}
add_action('admin_head', 'hide_publishing_actions');


//7.2- Hide screen option
function hide_screen_options(){
  echo ' 
      <style type="text/css">
      #screen-meta-links{ display: none;} 
      </style>
  ';
    
}
// add_action('admin_head', 'hide_screen_options');







//    //// 8 -- DASHBOARD customisation/////

add_action( 'admin_menu', 'control_menu_items_shown' );
function control_menu_items_shown() {
    remove_submenu_page( 'index.php', 'update-core.php' );
}
// 8.1 // Remove WordPress Dashboard Widgets
function rb_remove_dashboard_widgets() {
  remove_meta_box( 'e-dashboard-overview','dashboard','normal' ); // Elementor
  remove_meta_box( 'welcome-panel','dashboard','normal' ); // Elementor dwe-panel-content"
  remove_meta_box( 'dashboard_site_health','dashboard','normal' ); // Site Health
  remove_meta_box( 'dashboard_primary','dashboard','side' ); // WordPress.com Blog
  remove_meta_box( 'dashboard_plugins','dashboard','normal' ); // Plugins
  remove_meta_box( 'dashboard_right_now','dashboard', 'normal' ); // Right Now
  remove_action( 'welcome_panel','wp_welcome_panel' ); // Welcome Panel
  remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel'); // Try Gutenberg
  remove_meta_box('dashboard_quick_press','dashboard','side'); // Quick Press widget
  remove_meta_box('dashboard_recent_drafts','dashboard','side'); // Recent Drafts
  remove_meta_box('dashboard_secondary','dashboard','side'); // Other WordPress News
  remove_meta_box('dashboard_incoming_links','dashboard','normal'); //Incoming Links
  remove_meta_box('rg_forms_dashboard','dashboard','normal'); // Gravity Forms
  remove_meta_box('dashboard_recent_comments','dashboard','normal'); // Recent Comments
  remove_meta_box('icl_dashboard_widget','dashboard','normal'); // Multi Language Plugin
  remove_meta_box('dashboard_activity','dashboard', 'normal'); // Activity
  remove_meta_box('dce-dashboard-overview','dashboard', 'normal'); // Activity
  remove_meta_box('tinypng_dashboard_widget','dashboard', 'normal'); // TinyPNG


  }
  add_action( 'wp_dashboard_setup', 'rb_remove_dashboard_widgets' );
  
  // 4.2  // Rb dashboard Widgets [if Dashboard Welcome Elementor not activated]
function rb_dashboard_setup_function() {
    add_meta_box( 'my_dashboard_widget1', 'Contact Us', 'rb_dashboard_widget_tutorial', 'dashboard', 'normal', 'low' );
    add_meta_box( 'my_dashboard_widget2', 'Welcome !', 'rb_dashboard_widget_welcome', 'dashboard', 'normal', 'low' );
    add_meta_box( 'my_dashboard_widget3', 'Export', 'rb_dashboard_widget_export', 'dashboard', 'normal', 'low' );
}
add_action( 'wp_dashboard_setup', 'rb_dashboard_setup_function' );
  
function rb_dashboard_widget_export(){
  $args = array(
      'post_type' =>'publication',
      'numberposts'=>-1,
    );
    $posts=get_posts($args);
    $list='';
    foreach($posts as $post){
      $list.=export_publi_as_bibtex_dash($post->ID);
    }
      
      $file = plugin_dir_path(__FILE__).'export.txt';
      
      
      file_put_contents($file, $list);
      
      ?>
      <a href=<?php echo(plugin_dir_url(__FILE__).'export.txt' ); ?> download>
      <button id='export_button' >Export Publications (bibtex) </button>
    </a>
  </br>

    <?php 
    $args = array(
      'post_type' =>'member',
      'numberposts'=>-1,
    );
    $posts=get_posts($args);
    $list='';
    foreach($posts as $post){
      $list.=export_member_dash($post->ID);
    }
      $file = plugin_dir_path(__FILE__).'members.txt';
      file_put_contents($file, $list);
      
      ?>
      <a href=<?php echo(plugin_dir_url(__FILE__).'members.txt' ); ?> download>
      <button id='export_button' >Export Members </button>
    </a>

    <style type="text/css">
    
    
    
    #export_button {
      background: none;
  border: solid 2px #474544;
  color: #474544;
  cursor: pointer;
  display: inline-block;
  font-family: 'Helvetica', Arial, sans-serif;
  font-size: 0.875em;
  font-weight: bold;
  outline: none;
  padding: 20px 35px;
  margin:10px;
  text-transform: uppercase;
  -webkit-transition: all 0.3s;
	-moz-transition: all 0.3s;
	-ms-transition: all 0.3s;
	-o-transition: all 0.3s;
	transition: all 0.3s;
}

#export_button:hover {
  background: #474544;
  color: #F2F3EB;
}
  </style>
<?php
}





function rb_dashboard_widget_welcome(){
  $n_pub=wp_count_posts('publication')->publish;
  $cpts=get_cpt();
  
  ?>
    <p> Your  website contains: </p>
    <ul>
        <?php foreach($cpts as $cpt){
          echo wp_count_posts($cpt)->publish; echo' '.$cpt; echo '</br>';
        }
        ?>
    </ul>
  

  <?php

}


      function rb_dashboard_widget_tutorial() {
       ?>
       
          <h1> Contact Us !</h1>
          <form action="#" method="post" id="contact_form">
      
    <div class="subject">
      <label for="subject"></label>
      <select placeholder="Subject line" name="subject" id="subject_input" required>
        <option disabled hidden selected>Subject</option>
        <option>How to add/edit Publications</option>
        <option>How to add/edit Members </option>
        <option>Frontend display </option>
        <option>Bugs </option>
        <option>Others </option>
      </select>
    </div>
    <div class="message">
      <label for="message"></label>
      <textarea name="message" placeholder="I'd like to chat about" id="message_input" cols="30" rows="5" required></textarea>
    </div>
    <div class="submit">
      <input type="submit" value="Send Message" id="form_button" />
    </div>
  </form><!-- // End form -->
  <?php $url=site_url();
      if (isset($_POST['message'])){

    $link=get_site_url();
    $to      = "contact@rubidiumweb.fr";
    $subject='Probleme Client '.$link;
    if (isset($_POST['subject'])) {
      $subject =$subject.' '.$_POST['subject'];
    }

    $message = $_POST['message'];

    $headers = 'From: contact@rubidiumweb.fr' . "\r\n" .
    'Reply-To: contact@rubidiumweb.fr' . "\r\n" .
    'MIME-Version: 1.0' . "\r\n".
    'X-Mailer: PHP/' . phpversion();
    $headers  .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    mail($to, $subject, $message, $headers);
    print("Your message has been sent. We get back to you as soon as possible");


      }

  ?>
<style>
  html {
  font-family: 'Montserrat', Arial, sans-serif;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%; 
  }

  body {
    background: #F2F3EB;
  }

  button {
    overflow: visible;
  }

  button, select {
    text-transform: none;
  }

  button, input, select, textarea {
    color: #5A5A5A;
    font: inherit;
    margin: 0;
  }

  input {
    line-height: normal;
  }

  textarea {
    overflow: auto;
  }

  #container {
    border: solid 3px #474544;
    max-width: 768px;
    margin: 60px auto;
    position: relative;
  }

  form {
    padding: 37.5px;
    margin: 50px 0;
  }





  h1 {
    color: #474544;
    /* font-size: 32px; */
    font-weight: 700;
    /* letter-spacing: 7px; */
    text-align: center;
    /* text-transform: uppercase; */
  }

  .underline {
    border-bottom: solid 2px #474544;
    margin: -0.512em auto;
    width: 80px;
  }

  .icon_wrapper {
    margin: 50px auto 0;
    width: 100%;
  }

  .icon {
    display: block;
    fill: #474544;
    height: 50px;
    margin: 0 auto;
    width: 50px;
  }

  .email {
    float: right;
    width: 45%;
  }

  input[type='text'], [type='email'], select, textarea {
    background: none;
    border: none;
    border-bottom: solid 2px #474544;
    color: #474544;
    font-size: 1.000em;
    font-weight: 400;
    letter-spacing: 1px;
    margin: 0em 0 1.875em 0;
    padding: 0 0 0.875em 0;
    /* text-transform: uppercase; */
    width: 100%;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -ms-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
  }

  input[type='text']:focus, [type='email']:focus, textarea:focus {
    outline: none;
    padding: 0 0 0.875em 0;
  }

  .message {
    float: none;
  }

  .name {
    float: left;
    width: 45%;
  }

  select {
    background: url('https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-32.png') no-repeat right;
    outline: none;
    -moz-appearance: none;
    -webkit-appearance: none;
  }

  select::-ms-expand {
    display: none;
  }

  .subject {
    width: 100%;
  }

  .telephone {
    width: 100%;
  }

  textarea {
    line-height: 150%;
    height: 150px;
    resize: none;
    width: 100%;
  }

  ::-webkit-input-placeholder {
    color: #474544;
  }

  :-moz-placeholder { 
    color: #474544;
    opacity: 1;
  }

  ::-moz-placeholder {
    color: #474544;
    opacity: 1;
  }

  :-ms-input-placeholder {
    color: #474544;
  }

  #form_button {
    background: none;
    border: solid 2px #474544;
    color: #474544;
    cursor: pointer;
    display: inline-block;
    font-family: 'Helvetica', Arial, sans-serif;
    font-size: 0.875em;
    font-weight: bold;
    outline: none;
    padding: 20px 35px;
    text-transform: uppercase;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -ms-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
  }

  #form_button:hover {
    background: #474544;
    color: #F2F3EB;
  }

</style>


  
       <?php };

    
// 9 change media name

function rb_admin_menu_rename() {
  global $menu; // Global to get menu array
  $menu[10][0] = 'Images & Files'; // Change name of media to Documents
  //$menu[5][0] = 'News (WP)'; // Change name of posts to News
}
add_action( 'admin_menu', 'rb_admin_menu_rename' );


// 10 Create option pages for every CPT
add_action('admin_menu', 'my_acf_op_init');
function my_acf_op_init() {
  
    // Check function exists.
    if( function_exists('acf_add_options_page') ) {
      $cpts=get_cpt();
      foreach($cpts as $cpt){
        acf_add_options_page(array(
          'page_title'    => ucfirst($cpt).' Appearance',
          'menu_title'    => 'Appearance',
          'menu_slug'     => $cpt.'-appearance',
          'parent_slug'   => 'edit.php?post_type='.$cpt,
          'capability'    => 'edit_posts',
          
      ));
      }
       
    }
} 



// Change menu order
function rbw_custom_menu_order( $menu_ord ) {
  if ( !$menu_ord ) return true;

  return array(
      'index.php', // Dashboard
      "theme-general-settings",
      "edit.php?post_type=publication", // Publications
      
      "edit.php?post_type=research", // Publications
      "edit.php?post_type=job", // Publications
      "edit.php?post_type=member", // Publications  
      "edit.php?post_type=team", // Publications
      "edit.php?post_type=news", // Publications
      "edit.php?post_type=event", // Publications
      "edit.php?post_type=institute", // Publications
      "edit.php?post_type=facilities", // Publications
      "edit.php?post_type=funding", // Publications
      "edit.php?post_type=collaborator", // Publications
      "edit.php?post_type=institute", // Publications
      'upload.php' // media and files

  );
}
add_filter( 'custom_menu_order', 'rbw_custom_menu_order', 10, 1 );
add_filter( 'menu_order', 'rbw_custom_menu_order', 10, 1 );