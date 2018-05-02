<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;
use Lib\Redis;

$quota = [
	'店铺1' => [
		'2018年5月2日14时' => 10,
		'2018年5月2日19时' => 20,
	],
	'店铺2' => [
		'2018年5月2日14时' => 20,
		'2018年5月2日19时' => 20,
	]
];

foreach ($quota as $sk => $sv) 
{
	foreach ($sv as $dk => $dv) {
		$res = insertQuota($sk, $dk, $dv);
		if($res) {
			echo "{$sk} {$dk} 场次名额设置成功!\n";
		} else {
			echo "{$sk} {$dk} 场次名额设置失败!\n";
		}
	}
}	

function insertQuota($shop, $date, $quota)
{
	$quotas = new \stdClass();
	$quotas->shop = $shop;
	$quotas->date = $date;
	$quotas->num = $quota;
	$quotas->created = date('Y-m-d H:i:s');
	$quotas->updated = date('Y-m-d H:i:s');
	$helper = new Helper();
	$qid = $helper->insertTable('quota', $quotas);
	if($qid)
		return TRUE;
	return FALSE;
}
