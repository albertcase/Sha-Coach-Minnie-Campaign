<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;
use Lib\Redis;

$quota = [
	'2018-05-01' => 20,
	'2018-05-02' => 10
];

foreach ($quota as $k => $v) 
{
	$res = insertQuota($k, $v);
	if($res) {
		echo "{$k} 场次名额设置成功!\n";
	} else {
		echo "{$k} 场次名额设置失败!\n";
	}
}	

function insertQuota($name, $quota)
{
	$quotas = new \stdClass();
	$quotas->name = $name;
	$quotas->num = $quota;
	$quotas->created = date('Y-m-d H:i:s');
	$quotas->updated = date('Y-m-d H:i:s');
	$helper = new Helper();
	$qid = $helper->insertTable('quota', $quotas);
	if($qid)
		return TRUE;
	return FALSE;
}
