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

    public function submitAction()
    {
    	echo "预约api";exit;
    }

    public function formAction()
    {

    	global $user;

    	$request = $this->request;
    	$fields = array(
			'name' => array('notnull', '120'),
			'cellphone' => array('cellphone', '121'),
			'address' => array('notnull', '122'),
		);
		$request->validation($fields);
		$DatabaseAPI = new \Lib\DatabaseAPI();
		$data = new \stdClass();
		$data->uid = $user->uid;
		$data->name = $request->request->get('name');
		$data->cellphone = $request->request->get('cellphone');
		$data->address = $request->request->get('address');

		if($DatabaseAPI->insertInfo($data)) {
			$data = array('status' => 1);
			$this->dataPrint($data);
		} else {
			$this->statusPrint('0', 'failed');
		}
    }

}
