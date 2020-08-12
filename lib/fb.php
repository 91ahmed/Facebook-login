<?php
	
	class Facebook 
	{
		private $fb_app_info = [
			'app_id'        => '{app-id}',
			'app_secret'    => '{app-secret}',
			'app_url' 	    => 'http://www.example.com',
			'graph_version' => 'v2.10',
		];
		
		/** 
		 *	@var string, $fb_login_redirect
		 *	if session is set and login success redirect to this location.
		 */
		private $fb_login_redirect = 'index.php';
		
		/** 
		 *	@var hold facebook instance
		 */
		private $fb;

		/** 
		 *	@var string, facebook login url
		 */
		private $fb_login_url;
		
		public function __construct ()
		{
			$this->fb = new \Facebook\Facebook([
				'app_id'     => $this->fb_app_info['app_id'],
				'app_secret' => $this->fb_app_info['app_secret'],
				'default_graph_version' => $this->fb_app_info['graph_version'],
			]);

			$helper = $this->fb->getRedirectLoginHelper();
			$this->fb_login_url = $helper->getLoginUrl($this->fb_app_info['app_url']);
			
			try {

				$accessToken = $helper->getAccessToken();

				if (isset($accessToken)) {
					
					$_SESSION['facebook_access_token'] = (string) $accessToken;
					
					header('Location:'.$this->fb_login_redirect);
				}

			} catch (\Facebook\Exceptions\FacebookSDKException $e) {

				echo 'Graph returned an error: ' . $e->getMessage();
			}
			
			// Logout
			$this->fb_logout();
		}
		
		private function fb_user_data ($data) 
		{		
			if(isset($_SESSION['facebook_access_token']))
			{
				try {

					$this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
					$response = $this->fb->get('/me?locale=en_US&fields=id,name,last_name,first_name,email,birthday');
					$userInfo = $response->getGraphNode();
					
					return $userInfo->getField($data);

				} catch (Exception $e) {

					echo $e->getTraceAsString();
				}
			}
		}
		
		public function fb_logout ()
		{
			if (isset($_GET['logout']) && isset($_GET['accesstoken'])) 
			{
				$accessToken = $_GET['accesstoken'];
				
				if ($accessToken === $this->getUserAccessToken())
				{
					unset($_SESSION['facebook_access_token']);
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				}
			}
		}
		
		public function getUserData ($data)
		{
			return $this->fb_user_data($data);
		}
		
		public function getUserAccessToken ()
		{
			return $_SESSION['facebook_access_token'];
		}
		
		public function getUserLoginUrl ()
		{
			return $this->fb_login_url;
		}
	}
?>