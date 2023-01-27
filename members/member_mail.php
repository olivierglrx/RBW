<?php



// Menu 

add_action('admin_menu', 'add_submenu_for_email_sender');
function add_submenu_for_email_sender() {
  add_submenu_page('edit.php?post_type=member', //Parent slug
    'Email', // page title
    'Send email', // Menu label
    'manage_options', // capability
    'send_email',// slug
    'send_email_page',//function to call -> /arxiv/index_arxiv.php
    );
} 

// Page 

function add_common_css_member_table(){
  wp_register_style( 'member_table', plugin_dir_url(__FILE__).'css/table_css.css');
  wp_enqueue_style( 'member_table' );

}



if (isset($_GET['page'])){
	if($_GET['page']=='send_email'){
		add_action('admin_enqueue_scripts','add_common_css_member_table');
	}
}





function send_email_page(){

  $args = array(
    'post_type' =>'member',
    'numberposts'=>-1,
  );
  $posts=get_posts($args);
  ?> <div  id='table_container' >
    <form method='post'>
  <table id="myTable">
    <thead>
      <tr> 
        <th> Name</th> 
        <th> Email</th> 
        <th> Send</th> 
      </tr>
    </thead>

<tbody>
<?php 
foreach($posts as $post){
  echo '<tr>';
  echo '<td>'.get_field("member_first_name", $post->ID).' '.get_field("member_last_name", $post->ID).' </td>';
  echo '<td>'.get_field("member_email", $post->ID).'</td>';
  echo '<td> <input name='.$post->ID.' type="checkbox" id=member'.$post->ID.' checked>  </td>';
  echo '</tr>';
}
?>
</tbody>
</table>

    <div id='button_container' >
		  <button type="button" class='bn36 bn3637' id='add_all' onclick='toggle_all()' >Toggle All</button>
    	<button class='bn36 bn3637' id='send_email' > Send emails </button>
    </div>
</form>


</div>





<?php 

if (isset($_POST)){
foreach($_POST as $id => $on )
{
  $email=get_field("member_email", $id);
  $first=get_field("member_first_name", $id);
  $last=get_field("member_last_name", $id);
  send_email($email,$last,$first,$id);
  echo "email has been send to ". get_field("member_first_name",$id)."</br>";
}

}
}

// Email handler



add_filter('acf/save_post', 'send_email_member',20);
function send_email_member($post_id){

  $post_type = get_post_type($post_id);
  if ($post_type != 'member') {
    return;
  }
  if(!get_field('member_send_email',$post_id)){
    return;
  }

  update_field('member_send_email','',$post_id);
  $email=get_field('member_email',$post_id);
  $first= get_field('member_first_name',$post_id);
  $last= get_field('member_last_name',$post_id);
  send_email($email,$last, $first,$post_id);

}






function send_email($email,$last, $first,$post_id){
  
    $link=get_site_url().'/index.php/add-info/?encrypt='.hash('md2',$post_id.'RbWeb284Thz').'&id='.$post_id ;
    $to      = $email;
    $subject = 'Rubidium information';
    $message = '

    <p>

    Dear '.$first.' '.$last.','.'
    </p>
    <p>
    You have been added to the Rubidium ANR.
    </p>
    <p>
    You can upload your personal information at '.$link.
    '
    </p>

    <p>
     Best regards,
     Rubidium Team
    </p>

        ';

    $headers = 'From: contact@rubidiumweb.fr' . "\r\n" .
    'Reply-To: contact@rubidiumweb.fr' . "\r\n" .
    'MIME-Version: 1.0' . "\r\n".
    'X-Mailer: PHP/' . phpversion();
    $headers  .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    mail($to, $subject, $message, $headers);
    return("ok");
}
