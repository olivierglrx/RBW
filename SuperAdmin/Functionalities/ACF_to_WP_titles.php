<?php 
// Modify the wordpress title according to the appropriate ACF .

add_action('acf/save_post', 'change_title',20); // fires after ACF
function change_title($post_id) {
  $post_type = get_post_type($post_id);
  if ($post_type == 'member') {
    $last_name = get_field('member_last_name', $post_id);
    $first_name = get_field('member_first_name', $post_id);
    $post_title=$last_name.' '.$first_name;
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title
    );
    wp_update_post($post);
    }


    $post_type = get_post_type($post_id);

  if ($post_type == 'facilities') {
    $post_title = get_field('facilities_title', $post_id);
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title
    );
    wp_update_post($post);
  }

  if ($post_type == 'gallery') {
    $post_title = get_field('gallery_title', $post_id);
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title
    );
    wp_update_post($post);
  }


  if ($post_type == 'fundings') {
    $post_title = get_field('funding_name', $post_id);
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title
    );
    wp_update_post($post);
  }


  if ($post_type == 'outreach') {
    $post_title = get_field('outreach_title', $post_id);
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title
    );
    wp_update_post($post);
  }

  if ($post_type == 'collaborator') {
    $post_title = get_field('collaborator_name', $post_id);
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title
    );
    wp_update_post($post);
  }

  if ($post_type == 'event') {
    $post_title = get_field('event_title', $post_id);
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title
    );
    wp_update_post($post);
  }

  if ($post_type == 'experiment') {
    $post_title = get_field('experiment_title', $post_id);
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title
    );
    wp_update_post($post);
  }

  if ($post_type == 'research') {
    $post_title = get_field('research_title', $post_id);
    $post_name = sanitize_title($post_title);
    $post = array(
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title
    );
    wp_update_post($post);
  }


      if ($post_type == 'news') {
        $post_title = get_field('news_title', $post_id);
        $post_name = sanitize_title($post_title);
        $post = array(
          'ID' => $post_id,
          'post_name' => $post_name,
          'post_title' => $post_title
        );
        wp_update_post($post);
      }



      if ($post_type == 'job') {
        $post_title = get_field('job_title', $post_id);
        $post_name = sanitize_title($post_title);
        $post = array(
          'ID' => $post_id,
          'post_name' => $post_name,
          'post_title' => $post_title
        );
        wp_update_post($post);
      }

    if ($post_type == 'team') {
      $post_title = get_field('team_name', $post_id);
      $post_name = sanitize_title($post_title);
      $post = array(
        'ID' => $post_id,
        'post_name' => $post_name,
        'post_title' => $post_title
      );
      wp_update_post($post);
    }
    if ($post_type == 'publication') {
      $post_title = get_field('publication_title', $post_id);
      $post_name = sanitize_title($post_title);
      $post = array(
        'ID' => $post_id,
        'post_name' => $post_name,
        'post_title' => $post_title
      );
      wp_update_post($post);
    }

    if ($post_type == 'member') {
      $first = get_field('member_first_name', $post_id);
      $last= get_field('member_last_name', $post_id);
      $post_title=$last.' '.$first;
      $post_name = sanitize_title($post_title);
      $post = array(
        'ID' => $post_id,
        'post_name' => $post_name,
        'post_title' => $post_title
      );
      wp_update_post($post);
    }




    // if ($post_type == 'miscellaneous') {
    //   $post_title = get_field('job_title', $post_id);
    //   $post_name = sanitize_title($post_title);
    //   $post = array(
    //     'ID' => $post_id,
    //     'post_name' => $post_name,
    //     'post_title' => $post_title
    //   );
    // }

// wp_update_post($post);
}
