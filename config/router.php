<?php

$routers = array();
//System
$routers['/wechat/callback'] = array('WechatBundle\Wechat', 'callback');
$routers['/wechat/coach/callback'] = array('WechatBundle\Coach', 'callback');
$routers['/wechat/coach/receive'] = array('WechatBundle\Coach', 'receiveUserInfo');
$routers['/wechat/jssdk/config/js'] = array('WechatBundle\Wechat', 'jssdkConfigJs');
$routers['/simulation/login'] = array('WechatBundle\Wechat', 'simulationLogin');
$routers['/clear'] = array('CampaignBundle\Page', 'clearCookie');
//System end

//Campaign
$routers['/'] = array('CampaignBundle\Page', 'index');
$routers['/apply'] = array('CampaignBundle\Page', 'apply'); //预约页面
$routers['/qrcode'] = array('CampaignBundle\Page', 'qrcode'); //二维码页面

//API
$routers['/api/quota'] = array('CampaignBundle\Api', 'quota'); //预约数量
$routers['/api/submit'] = array('CampaignBundle\Api', 'submit'); //预约
$routers['/api/checkin'] = array('CampaignBundle\Api', 'checkin'); //预约