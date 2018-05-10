<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\WechatAPI;
use CampaignBundle\HelpLib;

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
		$help = new HelpLib();
		if(!$help->isLaunched()) {
			return $this->render('not_launched', []);
		}
		if($reservation = $help->findReservationByUid($user->uid)) {
			$reservationData = $help->normalizeReservationData($reservation);
			return $this->render('is_apply', ['data' => $reservationData]);
		}		
		$isOld = $help->isOldOpenid($user->openid); 
		if($isOld) {
			return $this->render('old_apply');
		} else {
			return $this->render('apply');
		}
	}

	// 二维码预约结果页面
	public function qrcodeAction() 
	{
		global $user;
		$applyRes = new \stdClass(); //预约结果
		$help = new HelpLib();
		$reservation = $help->findReservationByUid($user->uid);
		if(!$reservation) {
			return $this->render('result', ['status' => 0, 'msg' => '抱歉，你未预约！']);
		}
		if($help->isCheckin($user->uid)) {
			return $this->render('result', ['status' => 1, 'msg' => '您已经核销！']);
		}
		if($reservationData = $help->normalizeReservationData($reservation)) {
			return $this->render('result', ['status' => 200, 'item' => $reservationData]);
		}
	}

	public function clearCookieAction() 
	{
      	$request = $this->Request();
		setcookie('_user', '', time(), '/', $request->getDomain());
		$this->statusPrint('success');
	}
}
