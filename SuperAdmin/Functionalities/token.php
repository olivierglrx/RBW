<?php

  ////  - Token filters /////

  // /// 1 Token filter to trim after 20 words
   function token_trim_words_filter($data) {
  if (str_word_count($data) > 20){
    $wp_url = "<a href=". get_permalink() . ">";
    $data = wp_trim_words( $data, 20 ) . $wp_url . " [More] </a>";
    }
  return $data;
   }

  /// 2 Token filter which include the number of word as a parameter
function tok_trim_words($data , $size , $str) {
  if (str_word_count($data) > $size){
    $wp_url = "<a href=". get_permalink() . ">";
    $data = wp_trim_words( $data, $size ) . $wp_url . ' ' . $str . '</a>';
    }
  return $data;
   }


 /// Highlight PI NAME ///

function highlight($data) {


  $first = get_field('siteinfo_pi_first_name', 'option');
  $last = get_field('siteinfo_pi_last_name', 'option');
  $search_str_lafi = $last .' '. $first;
  $search_str_fila = $first .' '. $last;
  $search_str_laf = $last .' '. $first[0];
  $search_str_fla = $first[0] .' '. $last;
  $search_str_flap = $first[0] .'. '. $last;
  $search_str_lacommafi = $last .', '. $first;
  $search_str_lacommafi2 = $last .', '. $first[0]. '.';
  //



  if (get_field('siteinfo_pi_highlight', 'option') == 'bold'){
    $modifier = '<b>';
    $modifier_close = '</b>';
  }

  if (get_field('siteinfo_pi_highlight', 'option') == 'underline'){
    $modifier = '<span style="text-decoration: underline;">';
    $modifier_close = '</span>';
  }

  if (get_field('siteinfo_pi_highlight', 'option') == 'color'){
    $color = get_field('siteinfo_highlight_color', 'option');
    $modifier = '<span style="color:' . $color . ';">';
    $modifier_close = '</span>';
  }

  //Replace Last First
  $replacement = $modifier. $search_str_lafi. $modifier_close;
  $data = str_replace($search_str_lafi, $replacement, $data);

  //Replace First Last
  $replacement = $modifier. $search_str_fila. $modifier_close;
  $data = str_replace($search_str_fila, $replacement, $data);


 if (!str_contains($data,$modifier)){
  //Replace F. Last
  $replacement = $modifier. $search_str_flap. $modifier_close;
  $data = str_replace($search_str_flap, $replacement, $data);

  //Replace F Last
  $replacement = $modifier. $search_str_fla. $modifier_close;
  $data = str_replace($search_str_fla, $replacement, $data);

  //Replace Last F
  $replacement = $modifier. $search_str_laf. $modifier_close;
  $data = str_replace($search_str_laf, $replacement, $data);

  //Replace Last, F.
  $replacement = $modifier. $search_str_lacommafi2. $modifier_close;
  $data = str_replace($search_str_lacommafi2, $replacement, $data);

  //Replace Last, First
  $replacement = $modifier. $search_str_lacommafi. $modifier_close;
  $data = str_replace($search_str_lacommafi, $replacement, $data);
}


//$dataR = '1';

return $data;
 }


