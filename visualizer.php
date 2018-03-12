<?php

include 'src/lotsofcode/TagCloud/TagCloud.php';

?>

<!DOCTYPE html>
<html>

<head>
    <title>Facebook bot detection</title>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
		  <link rel="stylesheet" href="css/tagcloud.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"
            integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-serialize-object/2.5.0/jquery.serialize-object.min.js"></script>

	
</head>

<body>
<!--wrapper-->
<div class="">

    <!--content-->
    <div class="ui padded segment">

        <!--header-->
        <h3 class="ui block header">
        </h3>
        <i class="settings icon"></i> Facebook bot

        <!--crawler block-->
        <div class="ui padded segment" id="crawler_block">
		<form class="ui form" id="crawler-form" method="post" action="">
                    <div class="fields ">


                       <!-- <div class="two wide field">
                            <label>Tracking Id</label>
                            <div class="ui label tracking-id" style="font-size: 1.22rem"></div>
                            <input class="hidden-tracking-id-input" type="hidden" name="tracking_id" value=""/>
                        </div>-->


                        

                        <div class="six wide field main-fields">
                            <label>&nbsp;Select Page</label>
                            
                                
                                <select name="page_id" class="menu">
								<?php
								$dir = "data/";

									// Open a directory, and read its contents
									if (is_dir($dir)){
									  if ($dh = opendir($dir)){
										while (($file = readdir($dh)) !== false){
											//var_dump(strpos($file,".json"));
											if(strpos($file,".json")!==false){
												$data = file_get_contents($dir."/".$file);
												$data = json_decode($data,true);
												//var_dump($data); exit;
												echo '<option class="item" value="'.$data['detail']['id'].'">'.$data['detail']['name'].'</option>';
											}
										  //echo "filename:" . $file . "<br>";
										}
										closedir($dh);
									  }
									}
									?>
                                    
                                </select>
                               
                           
                        </div>

                        <div style="text-align: center"  class="two wide field main-fields">
                            <label>&nbsp;</label>
                            <button class="ui blue button" type="submit" id="submit" name="submit" style="margin-left:16%">Visualize</button>

                        </div>


                    </div>

                </form>
		<?php
		
		$cloud = new TagCloud();
			
		$dir = "data/";
		if(isset($_POST['page_id'])){
			// Open a directory, and read its contents
			$id = $_POST['page_id'];
			if(file_exists($dir."".$id.".json")){
				$data = file_get_contents($dir."".$id.".json");
				$data = json_decode($data,true);
				$data = $data['posts']['data'];
				//var_dump($data);
				foreach($data as $d){
					if(isset($d['message'])){
					 $cloud->addString($d['message']);
					}
				}
				echo $cloud->render();
			}else{
				
				echo "Page not found";
			}
			
		}  
		?>


        </div>

    </div>
    <!--content end-->

</div>
<!--wrapper end-->

</body>



</html>
