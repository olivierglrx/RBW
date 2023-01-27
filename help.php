<?php 


function help_menu() {
 	add_menu_page('Tutorial', //Menu Name
 				'Tutorial', // Menu label
 				'manage_options', // capability
 				'Tutorial',// slug
 				'help_setup', //function to call -> activated_plugins.php
				//'getter("https://docs.rubidiumweb.eu/")',
                '',
                99,
 				);
}
add_action('admin_menu', 'help_menu');


function help_setup(){
?>

    <!-- <h1> Add a publication</h1>
    <h2> Manually </h2>


  <h1> Add a member</h1> -->
  <iframe src="https://docs.rubidiumweb.eu/" width="100%" height="1000px"></iframe>
 
<?php
//echo getter('https://docs.rubidiumweb.eu/');
}


function getter($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

// echo getter('https://docs.rubidiumweb.eu/');