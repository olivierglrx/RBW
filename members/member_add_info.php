<?php

function add_info_css(){
  wp_register_style( 'add_info_style', plugins_url('css',__FILE__).'/add_info.css');
  wp_enqueue_style( 'add_info_style' );

  wp_register_script( 'search_front', plugins_url('js',__FILE__).'/search_front.js',array( 'jquery' ));
  wp_enqueue_script( 'search_front' );

}
if ( isset($_GET['encrypt']) && isset($_GET['id'])) {
		add_action('wp_enqueue_scripts','add_info_css');
}


if ( isset($_GET['em']) ) {
		add_action('wp_enqueue_scripts','add_info_css');
}



add_action('init','create_add_info_page');
function create_add_info_page(){
  // acf_form_head();
  // Create the front page for member to modify their personal informations
  $check_page_exist = get_page_by_title('Add info', 'OBJECT', 'page');
  // Check if the page already exists
  if(empty($check_page_exist)) {
       $page_id = wp_insert_post(
           array(
           'post_author'    => 2,
           'post_status'    => 'publish',
           'post_content'   => 'Content of the page',
           'post_title'     => 'Add info',
           'post_type'      => 'page',
           'post_name'      => 'add-info'
           )
       );
    }

}


function my_content($content) {

      $page = get_page_by_title( 'Add info' );
      if ( is_page($page->ID) ){
        if (function_exists('add_info'))
          $content = add_info();

      }


      return $content;
  }
add_filter('the_content', 'my_content');



// Publication pages for members
if (isset($_GET['pub'])){
  if($_GET['pub']=='arxiv'){
  	add_action('wp_enqueue_scripts','arxiv_scripts');
  }
  if($_GET['pub']=='bibtex'){
  	add_action('wp_enqueue_scripts','bibtex_script');
  }
  if($_GET['pub']=='pubmed'){
    add_action('wp_enqueue_scripts','pubmed_script');
  }
  if($_GET['pub']=='orcid'){
    add_action('wp_enqueue_scripts','orcid_script');
  }
}

function add_info(){

  if (isset($_GET['encrypt']) && isset($_GET['id']) ){
    $post_id=$_GET['id'];
    $code_name=hash('md2',$post_id.'RbWeb284Thz');
    if ($_GET['encrypt']==$code_name ){

      if (!isset($_GET['pub'])){

        print_nav_bar($post_id,$code_name);

        print_add_info_acf_form($post_id);

      }else{
          print_nav_bar($post_id,$code_name);
        switch ($_GET['pub']) {
          case 'home':
              print_my_publications($post_id,$code_name);
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
          case 'team':
          echo "<div style='border:1px solid black; margin : 10px; padding:10px'>";

            $new_speaker=acf_form(array(
              'post_id'       => $post_id,
            'submit_value'  => 'Upload your details',
            'fields'=>array('member_publication'),
            'updated_message' => __("Your publications have been updated", 'acf'),
            )
            );
            echo "</div>";
            echo '<style type="text/css">
            .choices ul{height:500px !important;}
            </style>';
              break;

            }
          }
        }
      }
}
function print_nav_bar($id,$code_name){

  ?>
  <ul id="nav_add_info">
    <li><a  <?php echo('href="?encrypt='.$code_name.'&id='.$id.'"');?>>Home</a></li>

    <?php       $plugins=get_option('activated_plugins');

      if (in_array('publi_member', $plugins)){
      ?>  <li><a  <?php echo('href="?encrypt='.$code_name.'&id='.$id.'&pub=home"');?>>Publications</a><?php
    }
      ?>

    <ul>
      <?php
      if (in_array('publi_member', $plugins)){
      ?>  <li><a  <?php echo('href="?encrypt='.$code_name.'&id='.$id.'&pub=team"');?>>From the team</a><?php
    }

      if (in_array('arxiv', $plugins)){
      ?> <li><a  <?php echo('href="?encrypt='.$code_name.'&id='.$id.'&pub=arxiv"');?>>Arxiv</a></li> <?php
      }

      if (in_array('pubmed', $plugins)){
      ?> <li><a  <?php echo('href="?encrypt='.$code_name.'&id='.$id.'&pub=pubmed"');?>>Pubmed</a></li> <?php
      }

      if (in_array('orcid', $plugins)){
      ?> <li><a  <?php echo('href="?encrypt='.$code_name.'&id='.$id.'&pub=orcid"');?>>ORCID</a></li> <?php
      }

      if (in_array('bibtex', $plugins)){
      ?> <li><a  <?php echo('href="?encrypt='.$code_name.'&id='.$id.'&pub=bibtex"');?>>Bibtex</a></li> <?php
      }
      ?>


    </ul>
  </ul>
  <?php
}
function print_add_info_acf_form($post_id){

  echo('<p> Dear '.get_field('member_last_name',$post_id).' '.get_field('member_first_name',$post_id).

      ', please udate and upload your personal information.</p>');
  echo "<div style='border:1px solid black; margin : 10px; padding:10px'>";
  $acf_for_member=get_option('activated_acf_on_back')['member'];
  if (($key = array_search("member_send_email", $acf_for_member)) !== false) {
    unset($acf_for_member[$key]);
}

    $new_speaker=acf_form(array(
    'post_id'       => $post_id,
    'submit_value'  => 'Upload your details',
    'fields'=>$acf_for_member,
    'updated_message' => __("Your details have been updated", 'acf'),
    )
    );
    echo "</div>";
}

function print_my_publications($id,$code_name){
  

  ?>
  <label for="search">Search:</label>
  <input type="text" id="my_publications" name="search" size="10"  style="width:200px;">
		<?php
      $args = array(
            'post_type'=> 'publication',
            'posts_per_page' => '100',
            'meta_query' => array(
              array(
              'key'       => 'owner',
              'value'     => $id,


            )
          )
        );
      $loop = new WP_Query( $args);

      while ( $loop->have_posts() ):
        echo "<div class='rb_acf_form' style='border:1px solid black; margin : 10px; padding:10px'>";
        $loop->the_post();
				$id=get_the_id();

				?>
						<?php


						acf_form(array(
								'post_id'       => $id,
								'submit_value'  => __('Update publication'),
                'updated_message' =>false,
                  'fields'        =>get_option('activated_acf_on_back')['publication']
						));

            ?>

		<?php

  echo "</div>";
		endwhile; wp_reset_query();

}








add_filter('acf/save_post', 'possibly_delete_post',20);
function possibly_delete_post($post_id) {
  $post_type = get_post_type($post_id);
  // $member_id=get_post_meta($post_id,'owner')[0];
  // change to post type you want them to be able to delete
  if ($post_type != 'publication') {
    return;
  }
  if (get_field('publication_delete', $post_id)) {
    $force_delete = true; // move to trash
    // change above to true to permanently delete

    wp_delete_post($post_id, $force_delete);
    // redirect them somewhere since the post will no longer exist
    // see https://developer.wordpress.org/reference/functions/wp_redirect/


    $code_name=hash('md2',$post_id.'RbWeb284Thz');

    wp_redirect(site_url().'/add-info?encrypt='.$code_name.'&id='.$member_id.'&pub=home');
    exit;
  }
}


