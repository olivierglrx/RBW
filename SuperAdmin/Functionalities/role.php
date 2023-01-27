<?php


// 1 - Role Menu
// 2 - initiliaze the hide_show_menu option and  Create the page.  
// 3 - Update the hide_show_menu option
// 4 - Create roles.


// 1 - Role Menu
function role_menu() {
  add_submenu_page('RbWeb', //Parent slug
  'Role', // page title
  'Roles', // Menu label
  'manage_options', // capability
  'Role',// slug
  'page_role',//function to call 
  );
}
add_action('admin_menu', 'role_menu');

// 2 - Create the page. 
add_option('hide_show_menu',array());
function page_role(){
  print_r(get_option('hide_show_menu'));
  // Nav bar of the Role page, with the differents roles (except administrator, which 
  // we don't want to change)
  $roles=get_editable_roles();
  echo(
    "<div id='rb-nav-bar-acf'>
    <ul>");
    foreach ($roles as $key => $value) {  
      if ($value['name']!='Administrator')   
      echo('<li><a href="admin.php?page=Role&role='.$key.'">'.$value['name'].'</a></li>');
    }
    echo(
    "</ul>
    </div>");
  echo('<div>');


  // If send post update the option. 
  if (isset($_POST["role"])){
      update_list_of_menu();
  } 

  // Show the page depending on the role obtained in the GET variable. 
  if (isset($_GET['role'])){
    $role=$_GET['role'];
    // if the option has never been created for the role, it is created as an empty list
    if (!array_key_exists($role,get_option('hide_show_menu'))){
      $menus=get_option('hide_show_menu');
      $menus[$role][]=[];
      update_option('hide_show_menu',$menus);
    }
    // get the list of menus shown for the role. 
    $menus=get_option('hide_show_menu');
    echo '<p style="text-decoration: underline;" > Select to  HIDE </p>';
    // Form with the different menus of the dashboard. 
    echo '<form method="post">';    
        //  Menu on the left
        echo '<h2> Admin Menu</h2>';
        $groups =$menus[$role];     
        global $menu; // This variable gives all menu items on the left
        $menu[]=array('profile','profile','profile');
        foreach($menu as $key){
            echo '<input type="checkbox" id="scales" name="menu-'.$key[2].'"';
            if (in_array('menu-'.$key[2],get_option('hide_show_menu')[$role])) {
                echo('checked');
            }
            echo'>';
            echo $key[0];  
            echo '</br>';
        }
        // Admin bar on top. 
        echo '<h2> Admin bar</h2>';
        $bar=array('wp-logo','themes','widgets','menus','updates','comments','new-content','my-account','my-sites','vaa','customize');
        foreach($bar as $key){
            $key_ns=strtok($key, " ");
            if ($key_ns!='my-account'){
              echo '<input type="checkbox" name="'.$key_ns.'"';
              if (in_array($key_ns,get_option('hide_show_menu')[$role])) {
                  echo('checked');
              }
              echo '>';
              echo $key;
              echo '</br>';
          }
        }
        $args = array(
        'public'   => true,
        );
        $cpt= get_post_types( $args);
        $cpt[]='media';
        $cpt[]='user';
        foreach($cpt as $key){
          $key_ns=strtok($key, " ");
          echo '<input type="checkbox" name="new-'.$key_ns.'"';
          if (in_array('new-'.$key_ns,get_option('hide_show_menu')[$role])) {
            echo('checked');
          }
          echo '>';
          echo 'new-'.$key;
          echo '</br>';
        }
    
    // Send buttonsx. 
    echo('<input type="submit" name="role" value='.$role.'></form>');
    echo('<button type="button" name="checkall" onclick="check_all()" >checkall</button>');
    echo('<button type="button" name="uncheckall" onclick="uncheck_all()" >uncheckall</button>');
  }

  
}

// 3 Update the hide_show_menu option
function update_list_of_menu(){
    $role=$_GET['role'];
    $activated_menu_for_role=get_option('hide_show_menu')[$role];
  	$activated_menu_for_role=[];
  	foreach ($_POST as $key=> $value ) {
  		if ($value=='on'){
  			$activated_menu_for_role[]=str_replace('_php','.php',$key);
  		}
  	}

    $menus=get_option('hide_show_menu');
    $menus[$role]=$activated_menu_for_role;

    update_option('hide_show_menu',$menus);

}


// 4  Remove/ Create User Role ///
// remove_role( 'editor' );
// remove_role( 'contributor' );
// remove_role( 'subscriber' );
// remove_role('author');


remove_role( 'rb_PI' );
add_role( 'rb_PI', 'PI', get_role( 'administrator' )->capabilities );
$role = get_role( 'rb_PI' );
$role->remove_cap( 'manage_sites' );

remove_role( 'rb_admin' );
add_role( 'rb_admin', 'Scientific Admin', get_role( 'administrator' )->capabilities );
$role = get_role( 'rb_admin' );
$role->remove_cap( 'manage_sites' );

remove_role( 'rb_member' );
add_role( 'rb_member', 'Member', get_role( 'administrator' )->capabilities );

remove_role( 'rb_team_leader' );
add_role( 'rb_team_leader', 'Team Leader', get_role( 'administrator' )->capabilities );




// This cannot be undone! The role, in it's current state, is removed and recreated with it's default values.
// reset_role_wpse_82378( 'editor' );
// This cannot be undone! The role, in it's current state, is removed and recreated with it's default values.

/*
 * example usage: $results = reset_role_wpse_82378( 'subscriber' );
 * per add_role() (WordPress Codex):
 * $results "Returns a WP_Role object on success, null if that role already exists."
 *
 * possible $role values:
 * 'administrator'
 * 'editor'
 * 'author'
 * 'contributor'
 * 'subscriber'
 */
function reset_role_wpse_82378( $role ) {
    $default_roles = array(
        'administrator' => array(
            'switch_themes' => 1,
            'edit_themes' => 1,
            'activate_plugins' => 1,
            'edit_plugins' => 1,
            'edit_users' => 1,
            'edit_files' => 1,
            'manage_options' => 1,
            'moderate_comments' => 1,
            'manage_categories' => 1,
            'manage_links' => 1,
            'upload_files' => 1,
            'import' => 1,
            'unfiltered_html' => 1,
            'edit_posts' => 1,
            'edit_others_posts' => 1,
            'edit_published_posts' => 1,
            'publish_posts' => 1,
            'edit_pages' => 1,
            'read' => 1,
            'level_10' => 1,
            'level_9' => 1,
            'level_8' => 1,
            'level_7' => 1,
            'level_6' => 1,
            'level_5' => 1,
            'level_4' => 1,
            'level_3' => 1,
            'level_2' => 1,
            'level_1' => 1,
            'level_0' => 1,
            'edit_others_pages' => 1,
            'edit_published_pages' => 1,
            'publish_pages' => 1,
            'delete_pages' => 1,
            'delete_others_pages' => 1,
            'delete_published_pages' => 1,
            'delete_posts' => 1,
            'delete_others_posts' => 1,
            'delete_published_posts' => 1,
            'delete_private_posts' => 1,
            'edit_private_posts' => 1,
            'read_private_posts' => 1,
            'delete_private_pages' => 1,
            'edit_private_pages' => 1,
            'read_private_pages' => 1,
            'delete_users' => 1,
            'create_users' => 1,
            'unfiltered_upload' => 1,
            'edit_dashboard' => 1,
            'update_plugins' => 1,
            'delete_plugins' => 1,
            'install_plugins' => 1,
            'update_themes' => 1,
            'install_themes' => 1,
            'update_core' => 1,
            'list_users' => 1,
            'remove_users' => 1,
            'add_users' => 1,
            'promote_users' => 1,
            'edit_theme_options' => 1,
            'delete_themes' => 1,
            'export' => 1,
        ),
        'editor' => array(
            'moderate_comments' => 1,
            'manage_categories' => 1,
            'manage_links' => 1,
            'upload_files' => 1,
            'unfiltered_html' => 1,
            'edit_posts' => 1,
            'edit_others_posts' => 1,
            'edit_published_posts' => 1,
            'publish_posts' => 1,
            'edit_pages' => 1,
            'read' => 1,
            'level_7' => 1,
            'level_6' => 1,
            'level_5' => 1,
            'level_4' => 1,
            'level_3' => 1,
            'level_2' => 1,
            'level_1' => 1,
            'level_0' => 1,
            'edit_others_pages' => 1,
            'edit_published_pages' => 1,
            'publish_pages' => 1,
            'delete_pages' => 1,
            'delete_others_pages' => 1,
            'delete_published_pages' => 1,
            'delete_posts' => 1,
            'delete_others_posts' => 1,
            'delete_published_posts' => 1,
            'delete_private_posts' => 1,
            'edit_private_posts' => 1,
            'read_private_posts' => 1,
            'delete_private_pages' => 1,
            'edit_private_pages' => 1,
            'read_private_pages' => 1,
        ),
        'author' => array(
            'upload_files' => 1,
            'edit_posts' => 1,
            'edit_published_posts' => 1,
            'publish_posts' => 1,
            'read' => 1,
            'level_2' => 1,
            'level_1' => 1,
            'level_0' => 1,
            'delete_posts' => 1,
            'delete_published_posts' => 1,
        ),
        'contributor' => array(
            'edit_posts' => 1,
            'read' => 1,
            'level_1' => 1,
            'level_0' => 1,
            'delete_posts' => 1,
        ),
        'subscriber' => array(
            'read' => 1,
            'level_0' => 1,
        ),
        'display_name' => array(
            'administrator' => 'Administrator',
            'editor'        => 'Editor',
            'author'        => 'Author',
            'contributor'   => 'Contributor',
            'subscriber'    => 'Subscriber',
        ),
    );
    $role = strtolower( $role );
    remove_role( $role );
    return add_role( $role, $default_roles['display_name'][$role], $default_roles[$role] );
} // function reset_role_wpse_82378

