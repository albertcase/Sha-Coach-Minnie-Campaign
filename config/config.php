<?php

define("BASE_URL", '');
define("TEMPLATE_ROOT", dirname(__FILE__) . '/../template');
define("VENDOR_ROOT", dirname(__FILE__) . '/../vendor');

//ENV
define("ENV", 'dev');

//User
define("USER_STORAGE", 'COOKIE');

//
define("WECHAT_CAMPAIGN", true);

//Wechat Vendor
define("WECHAT_VENDOR", 'coach'); // default | coach

//Wechat config info
define("TOKEN", 'xxx');
define("APPID", '#');
define("APPSECRET", '#');
define("NOWTIME", date('Y-m-d H:i:s'));
// define("NOWTIME", '2018-05-18 15:10:00');
define("AHEADTIME", '1000');

define("NONCESTR", '?????');
define("COACH_AUTH_URL", 'http://coach.samesamechina.com/api/wechat/oauth/auth/4ad2a818-06c7-4e4b-a85b-5784e0e15a91'); 

//Redis config info
define("REDIS_HOST", '127.0.0.1');
define("REDIS_DBNAME", 1);
define("REDIS_PORT", '6379');

//Database config info
define("DBHOST", '127.0.0.1');
define("DBUSER", 'root');
define("DBPASS", '');
define("DBNAME", 'coach_minnie_campaign');

//Wechat Authorize
define("CALLBACK", 'wechat/callback');
define("SCOPE", 'snsapi_base');

//Wechat Authorize Page
define("AUTHORIZE_URL", '[
	"/apply",
	"/qrcode"
]');

//Account Access
define("OAUTH_ACCESS", '{
	"xxxx": "samesamechina.com" 
}');
define("JSSDK_ACCESS", '{
	"xxxx": "samesamechina.com",
	"dev": "127.0.0.1"
}');

define("ENCRYPT_KEY", '29FB77CB8E94B358');
define("ENCRYPT_IV", '6E4CAB2EAAF32E90');

define("WECHAT_TOKEN_PREFIX", 'wechat:token:');

define("LAUNCH_DATE", '[
	"2018-05-01 00:00:00",
	"2018-05-12 23:59:59"
]');

define("CHECKIN_CODE", '520');
