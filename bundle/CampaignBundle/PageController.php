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
		$isAllowApply = $help->isAllowApply();
		$isOld = $help->isOldOpenid($user->openid); //是否已经导入用户
		$shopQuota = $help->findShopQuota(); //查找店铺
		$quota = []; 
		if(!empty($shopQuota)) {
			foreach ($shopQuota as $sk => $sv) { //通过店铺查找时间段场次
				$quota[$sk]['shop'] = $sv['name'];
				$dateQuota = $help->findDateQuota($sv['id']);
				foreach ($dateQuota as $dk => $dv) { //查找场次的余额
					$dateQuota[$dk]['has_quota'] = $help->hasQuota($dv['id']);
				}
				$quota[$sk]['date'] = $dateQuota;
			}
		}
		$isAplly = $help->isSubmit($user->openid);
		if($isOld) {
			return $this->render('old_apply', ['quota' => $quota, 'isAplly' => $isAplly, 'isAllowApply' => $isAllowApply]);
		} else {
			return $this->render('apply', ['quota' => $quota, 'isAplly' => $isAplly, 'isAllowApply' => $isAllowApply]);
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
