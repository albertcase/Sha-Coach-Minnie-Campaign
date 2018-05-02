<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\PDO;
use Lib\userAPI;
use Lib\Helper;
use CampaignBundle\HelpController;

class ApiController extends Controller
{
    private $_pdo;

    public function __construct() 
    {
    	global $user;
        parent::__construct();
        $this->_pdo = PDO::getInstance();
        if(!$user->uid) {
            $this->statusPrint('100', 'access deny!');
        } 
    }

    // 查询预约场次列表
    public function quotaAction()
    {
        $data = [];
        $help = new HelpController();
        $shopQuota = $help->findShopQuota();
        $quota = [];
        if(!empty($shopQuota)) {
            foreach ($shopQuota as $k => $v) {
                $quota[$k]['shop'] = $v['name'];
                $dateQuota = $help->findDateQuota($v['id']);
                $quota[$k]['date'] = $dateQuota;
            }
        }
        $this->dataPrint($quota);
    }

    // 预约提交
    // 1.验证字段
    // 2.验证是否预约
    // 3.验证库存
    // 4.预约
    public function submitAction()
    {
        global $user;
        $help = new HelpController();

        $jsonData = file_get_contents("php://input"); 
        $apiData = json_decode($jsonData);
        if(is_null($apiData)) {
            $this->statusPrint('101', 'API参数不是json格式！');
        }

        if(!$apiData->qid) {
            $this->statusPrint('102', '预约场次不能为空！');
        }

        // 是否已经预约过
        if($help->isSubmit($user->openid)) {
            $this->statusPrint('103', '您已经预约过！');
        }

        // 场次名额是否还有
        if(!$help->hasQuota($apiData->qid)) {
            $this->statusPrint('104', '预约名额已经全部预约完！');
        }

        $apiData->openid = $user->openid;
    	if(!$help->submit($apiData)) {
            $this->statusPrint('105', '预约失败！');
        }

        $this->statusPrint('10', '预约成功！');
    }

    // 模拟登陆
    public function loginAction()
    {
        global $user;
        $userAPI = new UserAPI();
        $user = $userAPI->userLoad();
        if(!$user->uid) {
            $helper = new Helper();
            $user_info = new \stdClass();
            $user_info->openid = $helper->uuidGenerator();
            $userAPI->userRegister($user_info);
        }
        echo "openid: {$user->openid}登陆成功！";
        exit;
    }

}