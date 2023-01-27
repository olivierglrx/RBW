<?php



add_action('acf/save_post', 'member_update_taxonomy_term', 20);


function member_update_taxonomy_term($post_id){
     // // Type

     $other_type= get_field('member_new_statut',$post_id);

     if ($other_type!=''){
       wp_set_post_terms( $post_id, $other_type,  'member_status_tax',  false );
       wp_update_term( $post_id,  $other_type,  'member_status_tax',  false );
       update_field('member_status', $other_type, $post_id);
       // update_field('member_first_name', $other_type, $post_id);

   }
   else{
     $type=get_field('member_status', $post_id);
     wp_set_post_terms( $post_id, $type,  'member_status_tax',  false );
     wp_update_term( $post_id, $type,  'member_status_tax',  false );
  }



     $other_type= get_field('member_new_statut_fr',$post_id);
     if ($other_type!=''){
     // update_field('member_status_fr', $other_type, $post_id);
     wp_set_post_terms( $post_id, $other_type,  'member_status_tax_fr',  false );
     wp_update_term( $post_id,  $other_type,  'member_status_tax_fr',  false );
     update_field('member_status_fr', $other_type, $post_id);
     // update_field('member_new_statut_fr', '', $post_id);
   }
   else{
    $type=get_field('member_status_fr', $post_id);
    wp_set_post_terms( $post_id, $type,  'member_status_tax_fr',  false );
    wp_update_term( $post_id, $type,  'member_status_tax_fr',  false );
  }



}
