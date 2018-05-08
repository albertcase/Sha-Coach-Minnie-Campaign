<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\PDO;
use Lib\Helper;

class HelpLib
{	
	private $_pdo;
    public function __construct() 
    {
        $this->_pdo = PDO::getInstance();
    }

    public function isAllowApply()
    {
        $allowDate = json_decode(ALLOW_APPLY_DATE);
        if(strtotime($allowDate['0']) < strtotime(NOWTIME) && strtotime(NOWTIME) < strtotime($allowDate['1']))
            return true;
        return false;
    }

	// 检查是否为预先导入的openid
	public function isOldOpenid($openid)
	{
		$sql = "SELECT `id`, `openid` FROM `old_user` WHERE `openid` = :openid";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':openid' => $openid]);
        $row = $query->fetchAll(\PDO::FETCH_ASSOC);
        if($row) {
      		return $row;
        }
        return NULL;
	}

	// 查找店铺
    public function findShopQuota()
    {
        $sql = "SELECT `id`, `name` FROM `quota` WHERE fid=0";
        $query = $this->_pdo->prepare($sql);    
        $query->execute();
        $row = $query->fetchAll(\PDO::FETCH_ASSOC);
        if($row) {
      		return $row;
        }
        return [];
    }

    // 查找店铺
    public function findQuotaById($id)
    {
        $sql = "SELECT `id`, `name`, `fid` FROM `quota` WHERE id = :id";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':id' => $id]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
      		return (object) $row;
        }
        return [];
    }

    // 查找时间段
    public function findDateQuota($fid)
    {
        $sql = "SELECT `id`, `name`, `num` FROM `quota` WHERE fid=:fid";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':fid' => $fid]);
        $row = $query->fetchAll(\PDO::FETCH_ASSOC);
        if($row) {
      		return $row;
        }
        return [];
    }

    // 查找场次
    public function findQuotaByQid($qid)
    {
        $sql = "SELECT `id`, `name`, `num` FROM `quota` WHERE `id` = :id";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':id' => $qid]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
      		return (object) $row;
        }
        return NULL;
    }

    // 查找场次
    public function findSubmitByQid($qid)
    {
        $sql = "SELECT COUNT(`id`) AS `sum` FROM `submit` WHERE `qid` = :qid";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':qid' => $qid]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
      		return (object) $row;
        }
        return NULL;
    }

    // 查找是否还有预约名额
    public function hasQuota($qid) 
    {
        $quota = $this->findQuotaByQid($qid); //总库存
        $submit = $this->findSubmitByQid($qid); //现在占用的库存
        if($submit->sum < $quota->num) {
        	return TRUE;
        } else {
        	return FALSE;
        }
    }

    // 验证是否预约过 一个人只能预约一次
    public function isSubmit($openid) 
    {
        $sql = "SELECT `id`, `qid` FROM `submit` WHERE `openid` = :openid";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':openid' => $openid]);
        $row = $query->fetchAll(\PDO::FETCH_ASSOC);
        if($row) {
      		return 1;
        }
        return 0;
    }

    public function findSubmitByOpenid($openid)
    {
    	$sql = "SELECT `id`, `qid`, `name`, `phone` FROM `submit` WHERE `openid` = :openid";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':openid' => $openid]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
      		return (object) $row;
        }
        return NULL;
    }

    // 预约
    public function submit($data) 
    {
    	$submit = new \stdClass();
    	$submit->openid = $data->openid;
    	$submit->qid = $data->qid;
        if(!$this->isOldOpenid($data->openid)) {
            $submit->name = $data->name;
            $submit->phone = $data->phone;
        }
		$submit->created = date('Y-m-d H:i:s');
		$submit->updated = date('Y-m-d H:i:s');
		$helper = new Helper();
		$rs = $helper->insertTable('submit', $submit);
		if($rs) {
            $senData = new \stdClass();
            $senData->openid = 'oKCDxjnSxj8QpmCvrjD0V8lb-JyE';
            $senData->name = 'test';
            $senData->date = date('Y-m-d H:i:s');
            $this->sendMessage($senData);
			return TRUE;
        }
		return FALSE;
	}

    // 预约成功 发送模版消息
    public function sendMessage($senddata) 
    {
        $data = array(
            'touser' => $senddata->openid,
            'template_id' => 'WndD3kOmw-_OvtTPg0yfs0qziEWoHirCnsyXF8IiPns',
            'url' => '',
            'topcolor' => '#000000',
            'data' => array(
                'first' => array(
                    'value' => "ceshi 预约成功。\n",
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
                    'value' => "预约开始",
                    'color' => '#000000'
                )
            )
        );
        $api_url = "http://coach.samesamechina.com/v2/wx/template/send?access_token=zcBpBLWyAFy6xs3e7HeMPL9zWrd7Xy";
        $rs = $this->postData($api_url, $data);
        return $rs;
    }

    public function postData($api_url, $data) {
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
}
