<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\WechatAPI;
use CampaignBundle\HelpController;

class PageController extends Controller
{
	public function __construct() 
	{
		parent::__construct();
	}

	public function indexAction() 
	{
		global $user;
		$wechatAPI = new WechatAPI();
		$config = $wechatAPI->jssdkShortConfig($this->request->getUrl(TRUE));
		return $this->render('index', array('config' => $config));
	}

	public function applyAction() 
	{
		global $user;
		$help = new HelpController();
		$isOld = $help->isOldOpenid($user->openid);//
		$quota = $help->findQuota();
		foreach ($quota as $k => $v) {
			$quota[$k]['name'] = $v['shop'] . ":". $v['date'];
			unset($quota[$k]['shop']);
			unset($quota[$k]['date']);
		}
		if($isOld) {
			return $this->render('old_apply', ['quota' => $quota]);
		} else {
			return $this->render('apply', ['quota' => $quota]);
		}
	}

	public function qrcodeAction() 
	{
		echo "二维码页面";exit;
	}

	public function clearCookieAction() 
	{
      	$request = $this->Request();
		setcookie('_user', '', time(), '/', $request->getDomain());
		$this->statusPrint('success');
	}
}
