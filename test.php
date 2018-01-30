<?php
session_start();
$redirect_url = 'http://localhost/FacebookBot/test.php';
require_once __DIR__ . '/vendor/autoload.php';

	if(isset($_GET['reset'])){
		session_destroy();
	}

	define("APP_ID", '253776274791852');
	define("APP_SECRET",'36689be189970bdbcb7db0190f9edbab');
	//define("PAGE_ID",'elnuevodia');

	$fb = new \Facebook\Facebook([
		  'app_id' => APP_ID,
		  'app_secret' => APP_SECRET,
		  'default_graph_version' => 'v2.10',
		  //'default_access_token' => '{access-token}', // optional
	]);

	$helper = $fb->getRedirectLoginHelper();

	if(!isset($_SESSION['fb_access_token'])){
			$_SESSION['request'] = "true";
			$loginUrl=$helper->getLoginUrl($redirect_url);
			//header('Location: ' .$loginUrl);
			if(!isset($_GET['code'])){
				echo $loginUrl;
				exit;
			}
	}


	if(isset($_SESSION['fb_access_token'])){
		echo($_SESSION['fb_access_token']); exit;
	}


	$accessToken="";
	try {
			$accessToken = $helper->getAccessToken();

		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			$_SESSION['error']= array('error'=>true,'message'=>$e->getMessage());
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
			$_SESSION['error']= array('error'=>true,'message'=>$e->getMessage());
		}

		/*
		if (! isset($accessToken)) {
			if ($helper->getError()) {
				header('HTTP/1.0 401 Unauthorized');
				$_SESSION['error']= array('error'=>true,'message'=>$helper->getErrorDescription());
			} else {
			header('HTTP/1.0 400 Bad Request');
			echo 'could not connect to facebook';
			}
		}
		*/
		try{
				// The OAuth 2.0 client handler helps us manage access tokens
				$oAuth2Client = $fb->getOAuth2Client();

				// Get the access token metadata from /debug_token
				$tokenMetadata = $oAuth2Client->debugToken($accessToken);

				// Validation (these will throw FacebookSDKException's when they fail)
				$tokenMetadata->validateAppId(APP_ID); // Replace {app-id} with your app id
				// If you know the user ID this access token belongs to, you can validate it here
				$tokenMetadata->validateExpiration();

				if (! $accessToken->isLongLived()) {
				// Exchanges a short-lived access token for a long-lived one
					try {
						$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
					} catch (Facebook\Exceptions\FacebookSDKException $e) {
						$_SESSION['error']= array('error'=>true,'message'=>$helper->getMessage());
					}
				}

			$_SESSION['fb_access_token'] = (string) $accessToken;
			header('Location: http://localhost/FacebookBot/home.php/');
			exit;
			//echo ($_SESSION['fb_access_token']); exit;
		}catch(Exception $e){
			echo "error"; exit;
		}

?>
