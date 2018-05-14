<?php

namespace CampaignBundle;

use Lib\PDO;
use Lib\Helper;

class HelpLib
{	
	private $_pdo;
    public function __construct() 
    {
        $this->_pdo = PDO::getInstance();
    }

    public function isLaunched()
    {
        $launchDate = json_decode(LAUNCH_DATE);
        if(strtotime($launchDate['0']) < strtotime(NOWTIME) && strtotime(NOWTIME) < strtotime($launchDate['1']))
            return true;
        return false;
    }

    public function isCheckin($uid)
    {
        $sql = "SELECT 1 FROM `reservation` WHERE `uid` = :uid and `checkin` = 1";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':uid' => $uid]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        return $row;      
    }

	// 检查是否为预先导入的openid
	public function isOldOpenid($openid)
	{
		$sql = "SELECT `openid`, `name`, `phone` FROM `old_user` WHERE `openid` = :openid";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':openid' => $openid]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
      		return (object) $row;
        }
        return NULL;
	}

    public function getReservationList() 
    {
        $date = date('Y-m-d');
        $sql = "SELECT s.name, i.date, t.title, i.used, i.quota, i.id, t.start, t.end FROM items i 
        LEFT JOIN store s on s.id = i.sid
        LEFT JOIN times t on t.id = i.tid
        WHERE i.date >= :date 
        ORDER BY s.id, i.id ASC";
        $query = $this->_pdo->prepare($sql);
        $query->execute([':date' => $date]);
        $data = $query->fetchAll(\PDO::FETCH_ASSOC);
        if($data) {
            return $data;
        }
        return [];
    }

    public function findItemById($item_id)
    {
        $sql = "SELECT s.name, i.date, t.title FROM items i 
        LEFT JOIN store s on s.id = i.sid
        LEFT JOIN times t on t.id = i.tid
        WHERE i.id = :item_id";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':item_id' => $item_id]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
      		return (object) $row;
        }
        return [];
    }

    public function hasQuota($id) 
    {
        $sql = "SELECT `used`, `quota` FROM `items` WHERE `id` = :id";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':id' => $id]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return $row['quota'] > $row['used'] ? true : false;
        }
        return false;
    }

    public function addUsed($id)
    {
        $sql = "UPDATE `items` SET used = used+1 WHERE `id` = :id";
        $query = $this->_pdo->prepare($sql);    
        return $query->execute([':id' => $id]);
    }

    public function findReservationByUid($uid)
    {
    	$sql = "SELECT `id`, `item_id`, `name`, `phone` FROM `reservation` WHERE `uid` = :uid";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':uid' => $uid]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
      		return (object) $row;
        }
        return NULL;
    }

    public function findReservationByRid($rid)
    {
        $sql = "SELECT `id`, `item_id`, `name`, `phone` FROM `reservation` WHERE `id` = :rid";
        $query = $this->_pdo->prepare($sql);    
        $query->execute([':rid' => $rid]);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return (object) $row;
        }
        return NULL;
    }

    public function getNotificationList($date)
    {
        $sql = "SELECT u.openid, r.id, r.name, r.phone, t.title, i.date FROM reservation r 
                LEFT JOIN items i ON r.item_id = i.id
                LEFT JOIN times t ON i.tid = t.id 
                LEFT JOIN user u ON u.uid = r.uid
                WHERE i.date = :date AND r.send = 0
                ";
        $query = $this->_pdo->prepare($sql);
        $query->execute([':date' => $date]);
        $data = $query->fetchAll(\PDO::FETCH_ASSOC);
        if($data) {
            return $data;
        }
        return [];
    }

    public function updateSendStatus($rid)
    {
        $sql = "UPDATE `reservation` SET send = 1 WHERE `id` = :id";
        $query = $this->_pdo->prepare($sql);    
        return $query->execute([':id' => $rid]);      
    }

    public function normalizeReservationData($reservation)
    {
        $data = new \stdClass();
        $data->name = isset($reservation->name) ? $reservation->name : '';
        $data->phone = isset($reservation->phone) ? $reservation->phone : '';
        $item = $this->findItemById($reservation->item_id);
        $data->date = $item->date.'('.$item->title.')';
        $data->shop = $item->name;
        return $data;
    }

    public function checkin($uid)
    {
        $sql = "UPDATE `reservation` SET checkin = 1, updated = NOW() WHERE `uid` = :uid";
        $query = $this->_pdo->prepare($sql);    
        return $query->execute([':uid' => $uid]);
    }

    // 预约
    public function submit($data) 
    {
        global $user;

    	$submit = new \stdClass();
        $submit->uid = $user->uid;
        $submit->item_id = $data->id;
        if($old = $this->isOldOpenid($user->openid)) {
            $submit->name = $old->name;
            $submit->phone = $old->phone;
        } else {
            $submit->name = $data->name;
            $submit->phone = $data->phone;
        }
		$submit->created = NOWTIME;
		$submit->updated = NOWTIME;
		$helper = new Helper();
		if($rid = $helper->insertTable('reservation', $submit)) {
            $reservation = $this->findReservationByRid($rid);
            $this->addUsed($reservation->item_id);
            $reservationData = $this->normalizeReservationData($reservation);
            if($reservationData) {
                $sendData = new \stdClass();
                $sendData->openid = $user->openid;
                $sendData->name = $reservationData->name;
                if(strpos($reservationData->phone, '****')) {
                    $sendData->phone = $reservationData->phone;
                } else {
                    $sendData->phone = substr_replace($reservationData->phone, '****', 3, 4);
                }
                $sendData->date = $reservationData->date;
                $sendData->shop = $reservationData->shop;
                $this->sendMessage($sendData);
                return $reservationData;
            }
        }
		return FALSE;
	}

    // 预约成功 发送模版消息
    public function sendMessage($sendData) 
    {
        $data = array(
            'touser' => $sendData->openid,
            'template_id' => 'OGosN3rcb0KwyRfBXriyPIJdc4dtf5P5qpGt635_FUU',
            'url' => 'http://minnie.coach.samesamechina.com/qrcode',
            'topcolor' => '#000000',
            'data' => array(
                'first' => array(
                    'value' => "尊敬的贵宾，您已成功预约Coach x Disney嘉年华，我们期待与你共度玩趣时尚的美妙时光。\n",
                    'color' => '#000000'
                ),
                'keyword1' => array(
                    'value' => $sendData->name,
                    'color' => '#000000'
                ),
                'keyword2' => array(
                    'value' => $sendData->phone,
                    'color' => '#000000'
                ),
                'keyword3' => array(
                    'value' => 'Coach x Disney嘉年华',
                    'color' => '#000000'
                ),
                'keyword4' => array(
                    'value' => $sendData->date,
                    'color' => '#000000'
                ),
                'keyword5' => array(
                    'value' => $sendData->shop,
                    'color' => '#000000'
                ),
                'remark' => array(
                    'value' => "敬请点击下方“详情”，查看活动详细信息。",
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
