<?php


// function arxiv_page(){
// 	?> 
// 	<h1> Research articles on ArXiv</h1>
// 	<form class='form_arxiv' method="post">
// 		<ol> Select author last name</ol>
// 			<input type="text" name="arxiv_author_name" size="50" value="" >
// 		<ol>Select title words :</ol>
// 			<input type="text" name="title_search" size="50" value="" />

// 		<ol>Select number of articles to show :</ol>
// 			<input type="text" name="max_results" size="10" value= 30>
// 			<input type="submit" name="submit" value="Search"/>
// 	</form>
// 	<style type="text/css">
// 		.form_arxiv{
// 			background-color: rgb(176, 196, 222,0.4);
// 			padding: 10px;
// 			width: 50%;
// 			margin:10px;
// 			border-radius: 10px;

// 	}
// 		ol{
// 			font-family:Roboto;
// 			font-size: 18px;

// 		}

// 	</style>
// <?php
// if (!empty($_POST['arxiv_author_name'])){
// 	$List_of_publication=arxiv($_POST['arxiv_author_name'], 30);
	
// 	create_table($List_of_publication);
// }
// }

// function create_table($list_of_publication){
// 	?>
//  <div class='rb-container' style='margin-left: -1em;'>
//     <form class=""  method="post">
//       <table id="myTable" >
//         <tbody>
//         	<?php insert_in_table($list_of_publication);?>
//         </tbody>
//       </table>
//       <input id='send_button' type="submit" name="validate" value="Add to my Publications " >
//     </form>
//     </br>
//     <button id='add_all' >Toggle All</button>
//   </div>
//   <style type="text/css">
  	
  	
//   </style>
// 	<?php

// }

// function insert_in_table($list_of_publication){
// 	echo(' <tr>
// 	<th>Check To add</th>
//     <th>Title</th>
//     <th>Authors</th> 
//   </tr>'
// 	);	
// 	$i=0;
// 	foreach ($list_of_publication as $publication) {
// 		$i++;
// 		echo('<tr>
// 			<td> <input type="checkbox" id="'.$i.'"
//          checked>
//     		<td>'.$publication->title.'</td>
//    			 <td>'.implode(', ',$publication->author).'</td> 
//   		</tr>'
//   		);
// 	}
// }



// function arxiv($authors,$number_of_results){
// 	$authors=str_replace(' ', "au:", $authors);
// 	$query=file_get_contents('http://export.arxiv.org/api/query?search_query='.$authors."&max_results=".$number_of_results);
// 	$xml= simplexml_load_string($query);
// 	$list_of_publications=[];
// 	foreach ($xml->{'entry'} as $entry ) {
// 		$publication= new Publication();
// 		$publication->title     =(string)$entry->{'title'};

// 		$publication->abstract  =(string)$entry->{'summary'};
// 		$publication->url       =(string)$entry->{'id'};
// 		$publication->status    =(string)'preprint';

// 		foreach ($entry->{'author'} as $author) {
// 			$publication->author[]=(string)$author->{'name'};
// 		}
// 	$list_of_publications[]=$publication;
	
// 	}
// 	return($list_of_publications);
// }



// function rb_get_hal(){
// 	$queryplus='glorieux';
// 	$results_of_search=	'abstract_s,'.
// 						'authFullName_s,keyword_s'.
// 						'arxivId_s'.
//   						'files_s,'.
//   						'journalDate_s,'.
//   						'publicationDate_s,'.
//   						'journalTitle_s,'.
//   						'keyword_s,'.
//   						'title_s';
//   	$base_url = 'https://api.archives-ouvertes.fr/search/?fl='.$results_of_search.'&q='.$queryplus;
//   	$json = file_get_contents($base_url);
//   	$data = json_decode($json,true);
//   	$results=$data['response']['docs'];
//   	foreach ($results as $item ) {
// 		echo(implode(', ',$item['authFullName_s']));
// 		echo(implode(', ',$item['keyword_s']));
//    	}
// }
//  -->