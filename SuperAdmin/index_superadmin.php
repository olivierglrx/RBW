<?php

// Usefull block functions for other files.  
include('functions_superadmin.php');

// Handle the list of plugins and ACF by default.
include('initial_plugin.php');

// Handle which plugins are on. 
include('activated_plugins.php');


// Handle ACF and ACF-options. 
  // 'ACF' submenu - also change ACF-json load point
  include('show-ACF-back.php');
  //'Site options' submenu - also create Options pages.  
  include('show-ACF-options.php'); 


// Include functionalitites. 

  // Role and cleaning_dashboard work together. In role one select what to show for each role
  //  in cleaning_dashboard the filters are applied wrt to what are selected for each role. 
  include('Functionalities/role.php');
  include('Functionalities/cleaning_dashboard.php');

  include('Functionalities/token.php');

  // Modify the wordpress title according to the appropriate ACF .
  include('Functionalities/ACF_to_WP_titles.php');
if (is_array(get_option("activated_plugins"))){
  if (in_array('CustomMenu',get_option("activated_plugins"))){
    include('Functionalities/add_post_to_front_menu.php');
  }
}

// Modifying ACF multi choice field .
include('Functionalities/customisation_acf.php');


  //Add pages for ICR 
  include('special_page.php'); 

  //Add shortcode
  include('short_code.php'); 