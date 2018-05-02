<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\PDO;

class HelpController extends Controller
{	
	private $_pdo;
    public function __construct() 
    {
        parent::__construct();
        $this->_pdo = PDO::getInstance();
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

	// 查找场次
    public function findQuota(){
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
