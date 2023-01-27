<?php

// https://api.zotero.org/users/2516597/items/?key=kqtBWHNqnVledNP7p7yuQ2eD&format=json

function zotero_script(){
  wp_register_style( 'index_zotero_css', plugins_url( 'css', __FILE__ ).'/index_zotero.css');
  wp_enqueue_style( 'index_zotero_css' );

  wp_register_script( 'parse_zotero', plugins_url( 'js', __FILE__ ).'/parse_zotero.js',array('jquery') );
  wp_enqueue_script( 'parse_zotero' );

}

if (isset($_GET['page'])){
  if($_GET['page']=='zotero'){
    add_action('admin_enqueue_scripts','zotero_script');
  }
}





function zotero_page_setup(){
  ?>
  <!-- LOGO -->
  <div class='rb-img_container'>
    <img id='zotero_logo' src=" <?php echo(plugin_dir_url(__FILE__).'zotero_logo.png'); ?>">
  </div>
  <!-- KEY and ID -->
  <div class='rb-search'>
      <!-- value='2516597'-->
      <input id='zot_id' type="text" name="zotero_id" placeholder='Zotero ID'  >
      <!-- value='kqtBWHNqnVledNP7p7yuQ2eD'-->
      <input id='zot_key' type="text" name="zotero_key" placeholder='Zotero key'  >
    <button id="parse" class='bn36 bn3637' type="submit" name=""  onclick="parse_zotero()" >Search</button>
    <!-- <button id="parse" class='bn36 bn3637' type="submit" name=""  onclick="test()" >test</button> -->
  </div>

  <!-- Loading Bar -->
<div  class='rb-message_container'>
<p> Loading...  </p>
</div>

	<div id='load_bar_container' class="progress" style="margin:auto; display:block;">

		<div id ='load' class="color"></div>
	</div>


  <!-- message -->
  <div class='rb-message_container'>
    <div id='message'> </div>
  </div>





<!-- TABLE -->
  <div  id='table_container' >
    <!-- <form class=""  method="post"> -->
      <table id="myTable"  style="display:none;">
        <thead>

        </thead>
        <tbody>
        </tbody>
      </table>
  </div>

  <div id='button_container' style="display:none;">
    <button class='bn36 bn3637' id='add_all' onclick='toggle_all()' >Toggle All</button>
    <button class='bn36 bn3637' id='add_all' onclick='insert_publication()' >Add to my Publications </button>
  </div>




<?php
}
