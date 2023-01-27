<?php

include('home-search.php');


add_action( 'init', 'rb_register_shortcodes');
function rb_register_shortcodes(){
    add_shortcode('search_bar', 'rb_search_shortcode');
 }

function rb_search_shortcode($atts){
    // $atts : array
    // usage add-shortcode in elementor
    // [search_bar cpt='member'  searching_data='members' placeholder='Search a member']
    //  cpt is class given in elemntor to the section/article
    // searching_data is loaded inside search.php file. It has to be done by hand every time
    //  For each post one decides what to look at. 
    $a = shortcode_atts( array(
        'cpt'=> '',
        'placeholder'=>'Search...',
        'size'=>'90%',
        'searching_data'=>'',
    ), $atts );

        $return_string='
        <div class="rbw-autocomplete" searching-data='.$a['searching_data'].' >
          <div class="rbw-search" cpt="'.$a['cpt'].'">
          <input id="rbw-search-input-'.$a['cpt'].'" type="text"  style="width:'.$a['size'].'" placeholder="'.$a['placeholder'].'">
         </div>
        </div>
        ';

        
         return $return_string;

}




add_action( 'wp_enqueue_scripts', 'search_script' );
function search_script() {
    wp_register_script('jquery-ui', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), '1.8.6');
    wp_enqueue_script('jquery-ui');
    
    wp_register_script( 'search_script', plugin_dir_url(__FILE__).'search.js',array('jquery', 'jquery-ui'));
    wp_enqueue_script( 'search_script' );

    wp_register_script( 'autocomplete_script', plugin_dir_url(__FILE__).'autocomplete.js',array('search_script', 'jquery', 'jquery-ui'));
    wp_enqueue_script( 'autocomplete_script' );

    wp_register_style( 'search_style', plugin_dir_url(__FILE__).'search.css');
    wp_enqueue_style( 'search_style' );


    wp_register_script( 'home-search', plugin_dir_url(__FILE__).'home-search.js',array('jquery', 'jquery-ui'));
    wp_enqueue_script( 'home-search' );


    // Datas send with localisation - each search bar has its own data
    $members=array();
        $query = new WP_Query(array(
            'post_type' => 'member', 
            'posts_per_page'=>-1
        ));
        if ($query->have_posts()):
            foreach( $query->posts as $post ):
                
                $id=$post->ID;
                // EVERY ENTRY MUST BE ARRAY
                $members[$id]['Identity'] =  array(
                    get_field('member_first_name', $id), 
                    get_field('member_last_name', $id),
                    get_field('member_first_name', $id).' '.get_field('member_last_name', $id),
                    get_field('member_last_name', $id).' '.get_field('member_first_name', $id),
                );
                $labs=get_field('member_rel_lab', $id);
                if($labs){
                    foreach($labs as $lab){
                        $members[$id]['Labs'][]=$lab->post_title;
                    }
                }
                

                $teams=get_field('member_team', $id);
                if($teams){
                    foreach($teams as $team){
                        $members[$id]['Team'][]=$team->post_title;
                    }
                }
                
                $Publications=get_field('member_rel_publication', $id);
                if($Publications){
                    foreach($Publications as $Publication){
                        $members[$id]['Publications'][]=$Publication->post_title;
                    }
                }

                $members[$id]['Description']=array(get_field('member_description', $id));

                $members[$id]['Status']=array(get_field('member_status', $id));
                
            endforeach;
        endif; 
        wp_reset_query();



    $members_autocomplete=array();
        $query = new WP_Query(array(
            'post_type' => 'member', 
            'posts_per_page'=>-1
        ));
        if ($query->have_posts()):
            foreach( $query->posts as $post ):   
                $id=$post->ID; 
                // EVERY ENTRY MUST BE STRING
                $members_autocomplete['Member'][] = get_field('member_first_name', $id).' '.get_field('member_last_name', $id);
                // $members_autocomplete['Member'][] = get_field('member_last_name', $id).' '.get_field('member_first_name', $id);
        
            endforeach;
        endif;             
        wp_reset_query();
        
        $query = new WP_Query(array(
            'post_type' => 'teams', 
            'posts_per_page'=>-1
        ));
        if ($query->have_posts()):
            foreach( $query->posts as $post ): 
                $id=$post->ID;    
                // EVERY ENTRY MUST BE STRING
                $members_autocomplete['Teams'][] = get_field('team_name', $id);
                $members_autocomplete['Teams'][] = get_field('team_accronym', $id);
            endforeach;
        endif;                 
        wp_reset_query();

    $teams=array();
        $query = new WP_Query(array(
            'post_type' => 'teams', 
            'posts_per_page'=>-1
        ));
        
        if ($query->have_posts()):
            foreach( $query->posts as $post ):
                
                $id=$post->ID;
                // EVERY ENTRY MUST BE ARRAY
                $teams[$id]['Identity'] =  array(
                    get_field('team_name', $id), 
                    get_field('team_acronym', $id),
                    
                );

                $teams[$id]['Summary']=array(
                    get_field('team_summary', $id),
                    get_field('team_description', $id)
                );

                

                $labs=get_field('team_labs', $id);
                if($labs){
                    foreach($labs as $lab){
                        $teams[$id]['Lab'][]=$lab->post_title;
                    }
                }

                $leaders= get_field('team_group_leader', $id);
                if($leaders){
                    foreach($leaders as $leader){
                        $teams[$id]['Group leader'][]=$leader->post_title;
                    }
                }

                $members_team= get_field('team_members', $id);
                if($members_team){
                    foreach($members_team as $member){                
                        $id_member=$member->ID;
                        $teams[$id]['Members'][]=  get_field('member_first_name', $id_member);
                        $teams[$id]['Members'][]= get_field('member_last_name', $id_member);
                        $teams[$id]['Members'][]=  get_field('member_first_name', $id_member).' '.get_field('member_last_name', $id_member);
                        $teams[$id]['Members'][]= get_field('member_last_name', $id_member).' '.get_field('member_first_name', $id_member);
                    }
                }

                
                
            endforeach;
        endif; 

        wp_localize_script( 'search_script', 'adminAjax',array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
  

    $home_search=home_search();
    wp_localize_script( 'search_script', 'searchdata', 
        array(
            'members'=>$members,
            'members_autocomplete'=>$members_autocomplete,
            'teams'=>$teams,
            'teams_autocomplete'=>$members_autocomplete,
            'home_search'=>$home_search,

        ) );

}



