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
		$isOld = $help->isOldOpenid($user->openid); //是否已经导入用户
		$shopQuota = $help->findShopQuota(); //查找店铺
		$quota = []; 
		if(!empty($shopQuota)) {
			foreach ($shopQuota as $k => $v) { //通过店铺查找时间段场次
				$quota[$k]['shop'] = $v['name'];
				$dateQuota = $help->findDateQuota($v['id']);
				$quota[$k]['date'] = $dateQuota;
			}
		}

		$isAplly = $help->isSubmit($user->openid);
		if($isOld) {
			return $this->render('old_apply', ['quota' => $quota, 'isAplly' => $isAplly]);
		} else {
			return $this->render('apply', ['quota' => $quota, 'isAplly' => $isAplly]);
		}
	}

	// 二维码预约结果页面
	public function qrcodeAction() 
	{
		global $user;
		$applyRes = new \stdClass(); //预约结果
		$help = new HelpController();
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
