<?php
//php code to save data from each edge using page_id as filename
if(!isset($_POST['page_id'])){ 
	echo "invalid request"; exit;
}

	$page_id = $_POST['page_id'];
	$data = $_POST['data'];
	$edge = $_POST['edge'];
	$fh = file_exists("data/".$page_id.".json");
	if($fh){
		$file = file_get_contents("data/".$page_id.".json",true);
		$contents = json_decode($file,true);
		$contents[$edge]=$data;
	}else{
		fopen("data/".$page_id.".json","w");
		$contents[$edge]=$data;
	}
	
	$fh = fopen("data/".$page_id.'.csv', 'w');
	//fputcsv($file, $data);
	foreach ($contents as $file) {
		$result = [];
		array_walk_recursive($file, function($item) use (&$result) {
			$result[] = $item;
		});
		fputcsv($fh, $result);
	}
	echo file_put_contents("data/".$page_id.".json",json_encode($contents));
	
?>