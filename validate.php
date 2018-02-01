<?php
$arg = "https://www.facebook.com/nnewomen/";//$_REQUEST['arg'];
$access="EAACEdEose0cBACTVGSXDXHmGmYUSLDGD4kt6uw0zgXNww27fkIfI3pZCuiOv6Ey4zoxwxDtJVm81ekYWLJVvNjlG4CTn71UipUL0WyveQ4jxCe3MHxm81SYqWf5LNhLxY7M6k6WVNZBsc6M7HLSI3XlbnWDhwtEMzgG44IIWYL32Sj8im1uJXNnZB52mf0ZD";
if ($arg != ''){

        $arg = str_replace(
                array('http://','https://','www.','facebook.com/','/'),
                '',
                $arg
        );

        $elseID = file_get_contents('https://graph.facebook.com/?ids='.$arg.'&access_token='.$access.'&fields=id');
        $elseID = json_decode($elseID,true);
        $elseID = $elseID[$arg]['id'];
		var_dump($elseID);
}