<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\PDO;

class ApiController extends Controller
{
    private $_pdo;

    public function __construct() {

    	global $user;

        parent::__construct();

        $this->_pdo = PDO::getInstance();

        // if(!$user->uid) {
	       //  $this->statusPrint('100', 'access deny!');
        // } 
    }

    public function quotaAction()
    {
        $data = [];
        $quotas = $this->findQuota();
        if($quotas) 
            $data = $quotas;
        $this->dataPrint($data);
    }

    // 预约提交
    // 1.验证字段
    // 2.验证是否预约
    // 3.验证库存
    // 4.预约
    public function submitAction()
    {
        global $user;

        $jsonData = file_get_contents("php://input"); 
        $apiData = json_decode($jsonData);
        if(is_null($apiData)) {
            $this->statusPrint('101', 'api param is not json!');
        }
        if(!$apiData->qid) {
            $this->statusPrint('102', '预约场次不能为空！');
        }

        // 是否已经预约过
        if($this->isSubmit($user->openid)) {
            $this->statusPrint('103', '您已经预约过！');
        }

        // 场次名额是否还有
        if(!$this->hasQuota($apiData->qid)) {
            $this->statusPrint('104', '预约名额已经全部预约完！');
        }

    	if(!$this->submit($apiData, $user->openid)) {
            $this->statusPrint('105', '预约失败！');
        }

        $this->statusPrint('200', '预约成功！');
    }

    // 预约
    private function submit($datadat, $openid) 
    {

    }

    // 验证是否预约过
    private function isSubmit($openid) 
    {
        return 1;
    }

    // 查找是否还有预约名额
    private function hasQuota($qid) 
    {
        return 1;
    }


    // 查找场次
    private function findQuota(){
        $sql = "SELECT `name`, `num` FROM `quota`";
        $query = $this->_pdo->prepare($sql);    
        $query->execute();
        $row = $query->fetchAll(\PDO::FETCH_ASSOC);
        if($row) {
          return $row;
        }
        return NULL;
    }
}
