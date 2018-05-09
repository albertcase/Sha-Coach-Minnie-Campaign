<?php

namespace WechatBundle;

use Core\Controller;
use Lib\UserAPI;

class CoachController extends Controller
{
	public function callbackAction()
	{
		$request = $this->request;
		if ($url = $request->getSourcetUrl()) {
			$fields = array(
				'openid' => array('notnull', '120'),
			);
			$request->validation($fields);
			$userAPI = new UserAPI();
			$openid = $request->query->get('openid');
			$user = $userAPI->userLogin($openid);
			if(!$user) {
				$this->statusPrint('error');
				// $userinfo = new \stdClass();
				// $userinfo->openid = $openid;
				// $userAPI->userRegister($userinfo);
			}
			$this->redirect($url);
		} else {
			$this->statusPrint('error');
		}
	}

	public function receiveUserInfoAction()
	{
		$data = file_get_contents("php://input");
		$data = json_decode($data);
		if($data->code = 200) {
			$userAPI = new UserAPI();
			$userAPI->userSave((Object)$data->data);
			$this->statusPrint('success');
		} else {
			$this->statusPrint('error');
		}
	}

}
