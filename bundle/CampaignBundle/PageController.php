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
		if($help->isSubmit($user->openid)) {
			return $this->render('is_apply', []);
		}		
		$reservationRawList = $help->getReservationList();
		$reservationList = [];
		if(!empty($reservationRawList)) {
			$i = 0;
			$now = date('H:i:s');
			foreach ($reservationRawList as $key => $value) {
				$reservationList[$value['name']][$key]['date'] = $value['date'];
				$reservationList[$value['name']][$key]['time'] = $value['title'];
				$reservationList[$value['name']][$key]['id'] = $value['id'];

				if($now >= $value['start'] && $now < $value['end'] && ($value['quota'] - $value['used']) > 0)
					$reservationList[$value['name']][$key]['has_quota'] =  true;
				else
					$reservationList[$value['name']][$key]['has_quota'] =  false;
			}
		}
		$isOld = $help->isOldOpenid($user->openid); 
		if($isOld) {
			return $this->render('old_apply', ['quota' => $reservationList]);
		} else {
			return $this->render('apply', ['quota' => $reservationList]);
		}
	}

	// 二维码预约结果页面
	public function qrcodeAction() 
	{
		global $user;
		$applyRes = new \stdClass(); //预约结果
		$help = new HelpLib();
		$submit = $help->findSubmitByOpenid($user->openid);
		if(!$submit) {
			return $this->render('qrcode', ['applys' => ['status' => 0, 'msg' => '抱歉，你未预约！']]);
		}
		$dates = $help->findQuotaById($submit->qid);
		$shops =  $help->findQuotaById($dates->fid);
		$applyRes->status = 1;
		$applyRes->name = $submit->name;
		$applyRes->phone = $submit->phone;
		$applyRes->date = $dates->name;
		$applyRes->shop = $shops->name;
		unset($dates, $shops, $submit);
		return $this->render('qrcode', ['applys' => (array) $applyRes]);
	}

	public function clearCookieAction() 
	{
      	$request = $this->Request();
		setcookie('_user', '', time(), '/', $request->getDomain());
		$this->statusPrint('success');
	}
}
