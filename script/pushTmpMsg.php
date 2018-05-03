<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;
use Lib\Redis;


$pushData = array(
    'id' => $appid,
    'openid' => $openid,
    'name' => $name,
    'date' => $date,
    'addr' => $shopAdr,
    'time' => $shopTime,
);

$send = sendMessage($pushData);

/**
 * 发送模版消息
 * param ["openid":用户标识]
 */
function sendMessage($senddata) {
    $data = array(
        'touser' => $senddata->openid,
        'template_id' => 'WndD3kOmw-_OvtTPg0yfs0qziEWoHirCnsyXF8IiPns',
        'url' => '',
        'topcolor' => '#000000',
        'data' => array(
            'first' => array(
                'value' => "尊敬的客人,\n您预约的COACH母亲节线下活动即将开始。\n",
                'color' => '#000000'
            ),
            'keyword1' => array(
                'value' => $senddata->name,
                'color' => '#000000'
            ),
            'keyword2' => array(
                'value' => $senddata->date,
                'color' => '#000000'
            ),
            'remark' => array(
                'value' => "地址：" . $senddata['addr'] . "\n\n欢迎您在 " . $senddata['time'] . "持此份活动通知，参与活动与COACH一起共享母亲节温馨时刻",
                'color' => '#000000'
            )

        )
    );
    $api_url = "http://coach.samesamechina.com/v2/wx/template/send?access_token=zcBpBLWyAFy6xs3e7HeMPL9zWrd7Xy";
    $rs = postData($api_url, $data);
    return $rs;
}

/**
 * post data
 */
 function postData($api_url, $data) {
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $api_url );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($data) );
    $return = curl_exec ( $ch );
    return $return;
    curl_close ( $ch );
}

/**
 * 记录消息推送日志
 */
function pushLog($db, $data) {
    $loginfo = new \stdClass();
    $loginfo->apply_id = $data['id'];
    $loginfo->openid = $data['openid'];
    $loginfo->name = $data['name'];
    $loginfo->status = 1;
    return $db->insertPushLog($loginfo);
}
