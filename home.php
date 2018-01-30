<!DOCTYPE html>
<html>

<head>
    <title>Facebook bot detection</title>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
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

            <div id="all-forms">
                <form class="ui form" id="crawler-form">
                    <div class="fields ">


                       <!-- <div class="two wide field">
                            <label>Tracking Id</label>
                            <div class="ui label tracking-id" style="font-size: 1.22rem"></div>
                            <input class="hidden-tracking-id-input" type="hidden" name="tracking_id" value=""/>
                        </div>-->


                        <div class="six wide field main-fields">
                            <label>&nbsp;Facebook Page URL</label>
                            <input type="text" name="crawl_url" id="crawl_url" required placeholder="Enter URL here">
                        </div>



                        <div class="three wide field main-fields">
                            <label>&nbsp;Maximum number of posts</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="pages">
                                <i class="dropdown icon"></i>
                                <div class="default text">Select page limit</div>
                                <div class="menu">
                                    <div class="item" data-value="1">Current page only</div>
                                    <div class="item" data-value="10">Upto 10 feeds</div>
                                    <div class="item" data-value="25">Upto 25 feeds</div>
                                    <div class="item" data-value="50">Upto 50 feeds</div>
                                    <div class="item" data-value="100">Upto 100 feeds</div>
                                    <div class="item" data-value="no">No limit</div>
                                </div>
                            </div>
                        </div>

                        <div style="text-align: center"  class="two wide field main-fields">
                            <label>&nbsp;</label>
                            <button class="ui blue button" type="submit" id="submit"  style="margin-left:16%">Fetch</button>

                        </div>







                        <!--<div style="display:none" class="twelve wide field progress-bar">
                            <div class="ui blue progress" data-value="20" data-total="100" style="padding:3px">
                                <div class="bar"></div>
                                <div class="label percentage">0%</div>
                            </div>
                            <div class="three wide field">
                                <button class="ui red button pauseButton" type="button">Remove</button>
                            </div>
                        </div>-->


                    </div>

                </form>
            </div>
			<div id="page-name"></div>
			<div class="twelve wide field main-fields">
							<ul id="lists">

							</ul>

            </div>

        </div>

    </div>
    <!--content end-->

</div>
<!--wrapper end-->

</body>

<script>
//
//'https://graph.facebook.com/'.$facebookPageId.'/posts?&access_token='.$facebookAppId.'|'.$facebookAppSecret;
function CrawlIt(){
var temp = "https://www.facebook.com/Starryville-School-127398697380356/";
var ur = $("#crawl_url").val();
ur = ur.split("-");
var id = ur[ur.length-1];
id = id.replace(/^\/|\/$/g, '');//substring(0,id.length-1);
if(isNaN(id)){
	$("#lists").html("<center>Invalid Page Url</center>");
	return false;//
}
$("#lists").html("<center><img src='preloader.gif' /></center>");
	$.ajax({
		    url: 'http://localhost/FacebookBot/test.php',
			method:'GET',
			success: function(response){
				//if(){
				var accessToken = response;
				console.log(response);
				if(response.indexOf("http")>-1){
					location.href=response;
					return false;
				}
				var page_id=id;//'127398697380356';
				var feedQuery = 'https://graph.facebook.com/'+id+'/feed';
				var feedURL = feedQuery +'?access_token='+ accessToken +'';


				$.ajax({
						url: 'https://graph.facebook.com/'+id+'?access_token='+ accessToken+'&fields=id,about,app_links,artists_we_like,best_page,can_checkin,can_post,category,category_list,checkins,company_overview,contact_address,country_page_likes,cover,current_location,description,display_subtext,displayed_message_response_time,emails,general_info,is_community_page,is_eligible_for_branded_content,is_published,is_unclaimed,link,location,members,name,new_like_count,parent_page,personal_info,personal_interests,username,verification_status,website',
						method:'GET',
						success: function(data){
							console.log(data);
							$("#page-name").html("<h2>"+data.name+" Page</h2>");
						},
						error:function(e){
							$("#lists").html("");
						}
				});


				$.ajax({
						url: feedQuery +'?access_token='+ accessToken +'',
						method:'GET',
						success: function(data){
							console.log(data);
							//$("#main-box").html(response);
								$("#lists").html("");
								var d = data.data; for( i=0; i < d.length; i++) {
									d[i].message ? $("#lists").append('<li>'+ d[i].message +'&nbsp;<span style="color:blue"><i>'+ d[i].created_time+'</i></span><br/><br/></li>') : ''; // lots of other stuff, you got it
								}

						},
						error:function(e){
								$("#lists").html("<center>Page not found</center>");
						}
				});


		    }
    });



}

$('#crawler-form').submit( function(e) {
console.log("clicked");
	CrawlIt();
	return false;
});

</script>


</html>
