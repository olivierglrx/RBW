<?php

// Create common-publi, common-news, common-jobs. 



add_action('init','create_common_publi_page');
function create_common_publi_page(){
  $check_page_exist = get_page_by_title('Common publications', 'OBJECT', 'page');
  // Check if the page already exists
  if(empty($check_page_exist)) {
       $page_id = wp_insert_post(
           array(
           'post_status'    => 'publish',
           'post_content'   => 'Content of the page',
           'post_title'     => 'Common publications',
           'post_type'      => 'page',
           'post_name'      => 'common-publications'
           )
       );
    }
}

add_action('init','create_common_job_page');
function create_common_job_page(){
  $check_page_exist = get_page_by_title('Common Jobs', 'OBJECT', 'page');
  // Check if the page already exists
  if(empty($check_page_exist)) {
       $page_id = wp_insert_post(
           array(
           'post_status'    => 'publish',
           'post_content'   => 'Content of the page',
           'post_title'     => 'Common jobs',
           'post_type'      => 'page',
           'post_name'      => 'common-jobs'
           )
       );
    }
}

add_action('init','create_common_news_page');
function create_common_news_page(){
  $check_page_exist = get_page_by_title('Common News', 'OBJECT', 'page');
  // Check if the page already exists
  if(empty($check_page_exist)) {
       $page_id = wp_insert_post(
           array(
           'post_status'    => 'publish',
           'post_content'   => 'Content of the page',
           'post_title'     => 'Common news',
           'post_type'      => 'page',
           'post_name'      => 'common-news'
           )
       );
    }

}

// Load scripts and css
add_action('wp_enqueue_scripts','add_css_for_special_page');
function add_css_for_special_page(){
    session_start();

    $title=get_the_title();
    if ($title=="Common news" || $title=="Common publications" || $title=="Common jobs" ){
      if (check_if_logged()){
        
        add_info_css();
      }
      else{
        wp_register_style( 'add_login_style', plugins_url('css',__FILE__).'/login_page_for_common.css');
        wp_enqueue_style( 'add_login_style' );
       
      }

    }
  

}



//  Login page  - is shown if the $_SESSION variable is not set

function login_page(){ 
  ?>
  <form method='post'>
  <div class="form">
    <div class="title">Welcome</div>
    <div class="subtitle">Access to protected pages</div>
    <div class="input-container ic1">
      <input id="firstname" class="input" name="login" type="text" placeholder=" " />
      <div class="cut"></div>
      <label for="firstname" class="placeholder">Login</label>
    </div>
    <div class="input-container ic2">
      <input id="password" class="input" name="password" type="password" placeholder=" " />
      <div class="cut cut-short"></div>
      <label for="password" class="placeholder">Pass</>
    </div>
    <button type="text" class="submit">submit</button>
  </div>
</form>
<?php
}
function check_if_logged(){
  if  (isset($_SESSION['logged']) && $_SESSION['logged']=='Y'){
    acf_form_head();
    return(TRUE);
  }
  if (isset($_POST['login']) && $_POST['login']=='login'){
    if ($_POST['password']=='coucou'){
        $_SESSION['logged']='Y';
        return(TRUE);
    }
    else{
      $_SESSION['logged']='N';
      return(FALSE);
    }
  } 
}

//  Load content : 
function common_publi($content) { 
  $page = get_page_by_title( 'Common publications' );
  $is_logged=check_if_logged();
  if(is_page($page->ID) ){
    if ($is_logged){
      $content = common_publi_page();
      }
    else{
      $content= login_page();
    }
  }
  return $content;
 }
add_filter('the_content', 'common_publi');
 
function common_jobs($content) {
  $is_logged=check_if_logged();
  $page = get_page_by_title('Common jobs' );
  if (is_page($page->ID)){
    if ($is_logged){
      $content = common_job_page();
    }
    else{
      $content= login_page();
    }
  }
  return $content;
}
add_filter('the_content', 'common_jobs');

function common_news($content) { 
  $is_logged=check_if_logged();
  $page = get_page_by_title('Common news' );
  if (is_page($page->ID) ){
    if ($is_logged){
      $content = common_news_page();
    }
  else{
      $content= login_page();
    }   
  }
  return $content;
 }
 add_filter('the_content', 'common_news');



 

//  Publication content
// Nav bar
// 

function print_nav_bar_common_pub(){
  ?>
  <ul id="nav_add_info">

  <?php       $plugins=get_option('activated_plugins');


  ?>  
  <li><a  <?php echo('href="?pub=home"');?>>Publications list</a>
  <li><a  <?php echo('href="?pub=manual"');?>>Add Manually</a></li>
  <li><a >Plugins</a>
  <?php $plugins=get_option('activated_plugins');?>
    <ul>
      <?php
      if (in_array('Arxiv', $plugins)){
      ?> <li><a  <?php echo('href="?pub=arxiv"');?>>Arxiv</a></li> <?php
      }

      if (in_array('Pubmed', $plugins)){
      ?> <li><a  <?php echo('href="?pub=pubmed"');?>>Pubmed</a></li> <?php
      }

      if (in_array('ORCID', $plugins)){
      ?> <li><a  <?php echo('href="?pub=orcid"');?>>ORCID</a></li> <?php
      }

      if (in_array('BibTex', $plugins)){
      ?> <li><a  <?php echo('href="?pub=bibtex"');?>>Bibtex</a></li> <?php
      }

      if (in_array('HAL', $plugins)){
        ?> <li><a  <?php echo('href="?pub=hal"');?>>HAL</a></li> <?php
        }
      ?>
    </ul>
  </ul>
  <?php
}


function common_publi_page(){
        print_nav_bar_common_pub();

        if (isset($_GET['pub'])){
        switch ($_GET['pub']) {
          case 'home':
            print_the_publications();
              break;
          case 'manual':
            manual_adding_page();
            break;
          case 'arxiv':
              arxiv_page_setup();
              break;
          case 'bibtex':
              bibtex_page_setup();
              break;
          case 'orcid':
              orcid_page_setup();
              break;
          case 'pubmed':
              pubmed_page_setup();
              break;
          case 'hal':
              hal_page_setup();
              break;
            }
          }
        else{
            print_the_publications();
        }
}


function print_the_publications(){  
    ?>
    <label for="search">Search:</label>
    <input type="text" id="my_publications" name="search" size="10"  style="width:200px;">
          <?php
        $args = array(
              'post_type'=> 'publication',
              'posts_per_page' => '100',
              'meta_key'			=> 'publication_dop',
              'orderby'			=> 'meta_value',
              'order'				=> 'DESC'
            
          );
        $loop = new WP_Query( $args);
        
        ?>
        <div  id='table_container' >
            <table id="myTable" >
        	<thead>
                <tr>
                    <td> Title</td>
                    <td> Authors</td>
                    <td> Date</td>
                </tr>
          	</thead>
              <tbody>
            <?php
                while ( $loop->have_posts() ):
                    
                    $loop->the_post();
                    $id=get_the_id();
                    
                    ?>
                    <tr>
                        <td class='title'> <?php print(get_field('publication_title',$id));  ?> </td>
                        <td class='authors'> <?php print(get_field('publication_authors',$id));  ?></td>
                        <td class='date'> <?php print(get_field('publication_dop',$id));  ?></td>
                    </tr>

                    <?php
                    
                    endwhile; wp_reset_query();
                    ?>
            </tbody>
        </table>
    </div>
<?php
}



//  
function manual_adding_page(){   
  echo "<div class='rb_acf_form' style='border:1px solid black; margin : 10px; padding:10px'>";
  acf_form(array(
    'post_id'		=> 'new_post',
    'new_post'		=> array(
      'post_type'		=> 'publication',
  ),
    'post_status'    => 'draft',
    'submit_value'  => __('Add Publication'),
    'updated_message' =>'Your publication has been added',
    
    'fields'        =>get_option('activated_acf_on_back')['publication']
  ));
  echo '</div>';
}

 function common_job_page(){
  echo "<div class='rb_acf_form' style='border:1px solid black; margin : 10px; padding:10px'>";
  acf_form(array(
  'post_id'		=> 'new_post',
  'new_post'		=> array(
      'post_type'		=> 'job',
  ),
  'post_status'	=> 'draft',
  'submit_value'  => __('Add Job'),
  'updated_message' =>'The job has been added',
  'fields'        =>get_option('activated_acf_on_back')['job']
  ));
  echo '</div>';
}
function common_news_page(){
  echo "<div class='rb_acf_form' style='border:1px solid black; margin : 10px; padding:10px'>";
  acf_form(array(
  'post_id'		=> 'new_post',
  'new_post'		=> array(
  'post_type'		=> 'news',
    ),
    'post_status'	=> 'draft',
    'updated_message' =>'The News has been added',
    'submit_value'  => __('Add News'),
    'updated_message' =>false,
  ));
  echo '</div>';
}



