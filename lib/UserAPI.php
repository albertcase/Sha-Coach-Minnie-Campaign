<?php

namespace Lib;

use Core\Response;
use Core\Request;
use Core\Router;

class UserAPI extends Base {

  private $_pdo;

  public function __construct() {
    $this->_pdo = PDO::getInstance();
  }

  public function userLoad($openid = 0){
    if($openid) {
      if($user = $this->findUserByOpenid($openid)) {
        return $user;
      } else {
        return FALSE;
      }
    } else {
      if($_user = $this->isUserLogin()){
        $data = new \stdClass();
        $data->uid = $_user->uid;
        $data->openid = $_user->openid;
        return $data;
      } else {
        return (object) array('uid' => '0', 'openid' => '0');
      }
    }
  }

  public function userLogin($openid){
    $user = $this->findUserByOpenid($openid);
    if($user) {
      return $this->userLoginFinalize($user);
    }
    return FALSE;
  }

  public function isUserLogin() {
    if(USER_STORAGE == 'COOKIE') {
      if(isset($_COOKIE['w_user'])) {
        return $this->decodeUser($_COOKIE['w_user']);
      }
    } else {
      if(isset($_SESSION['w_user'])) {
        return json_decode($_SESSION['w_user']);
      }
    }
    return FALSE;
  }

  public function userRegister($userinfo){
    $user = $this->insertUser($userinfo);
    return $this->userLoginFinalize($user);
  }

  public function userLoginFinalize($user) {
    if(USER_STORAGE == 'COOKIE') {
      $request = new Request();
      $user = $this->userFinalizeDataNormalize($user);
      setcookie('w_user', $this->encodeUser($user), time() + 3600 * 24 * 10, '/', $request->getHost());
    } else {
      $_SESSION['w_user'] = json_encode($user);
    }
    return $user;
  }

  public function userFinalizeDataNormalize($data) {
      $user = new \stdClass();
      $user->uid = $data->uid;
      $user->openid = $data->openid;
      return $user;
  }

  public function oauthAction($redirect_uri) {
    $wechatAPI = new WechatAPI();
    $param['redirect_uri'] = $redirect_uri;
    $router = new Router();
    $callback = $router->generateUrl(CALLBACK, $param, true);
    $url = $wechatAPI->getAuthorizeUrl($callback);
    $response = new Response();
    $response->redirect($url);  
  }

  public function encodeUser($data) {
    $helper = new Helper();
    $data = base64_encode($helper->aes128_cbc_encrypt(ENCRYPT_KEY, json_encode($data), ENCRYPT_IV));
    return $data;
  }

  public function decodeUser($string) {
    $string = base64_decode($string, TRUE);
    $helper = new Helper();
    $data = $helper->aes128_cbc_decrypt(ENCRYPT_KEY, $string, ENCRYPT_IV);
    $user = json_decode($data);
    return $user;
  }

  /**
  * Save user in database
  */ 
  public function userSave($userinfo) {
    $userinfo = $this->userNormailize($userinfo);
    $helper = new Helper();
    $userinfo->created = $userinfo->updated = date('Y-m-d H:i:s');
    $res = $helper->saveTable('user', $userinfo, 'openid');
    if($res) {
      if($res === true)
        return $this->findUserByOpenid($userinfo->openid);
      else
        return $this->findUserByUid($res);
    }
    return false;
  }

  /**
  * Create user in database
  */
  public function insertUser($userinfo){
    $userinfo = $this->userNormailize($userinfo);
    $helper = new Helper();
    $userinfo->created = $userinfo->updated = date('Y-m-d H:i:s');
    $uid = $helper->insertTable('user', $userinfo);
    if($uid) {
      return $this->findUserByUid($uid);
    }
    return null;
  }

  /**
   * Update user in database
   */  
  public function updateUserByOpenid($userinfo) {
    $userinfo = $this->userNormailize($userinfo);
    $helper = new Helper();
    $condition = array(
      array('openid', $userinfo->openid, '='),
      );
    $userinfo->updated = date('Y-m-d H:i:s');
    return $helper->updateTable('user', $userinfo, $condition);
  }

  public function userNormailize($userinfo) {
    $user = new \stdClass();
    if(isset($userinfo->openid)) 
      $user->openid = $userinfo->openid;
    if(isset($userinfo->nickname)) 
      $user->nickname = $userinfo->nickname;
    if(isset($userinfo->sex)) 
      $user->sex = $userinfo->sex; 
    if(isset($userinfo->city)) 
      $user->city = $userinfo->city; 
    if(isset($userinfo->province)) 
      $user->province = $userinfo->province; 
    if(isset($userinfo->country)) 
      $user->country = $userinfo->country; 
    if(isset($userinfo->headimgurl)) 
      $user->headimgurl = $userinfo->headimgurl; 
    if(isset($userinfo->unionid)) 
      $user->unionid = $userinfo->unionid; 
    return $user;
  }

  /**
   * Find user in database
   */
  public function findUserByOpenid($openid){
    $sql = "SELECT `uid`, `openid`, `nickname`, `sex`, `city`, `province`, `headimgurl`, `country` FROM `user` WHERE `openid` = :openid";
    $query = $this->_pdo->prepare($sql);    
    $query->execute(array(':openid' => $openid));
    $row = $query->fetch(\PDO::FETCH_ASSOC);
    if($row) {
      return  (Object) $row;
    }
    return NULL;
  }

  /**
   * Create user in database
   */
  public function findUserByUid($uid){
    $sql = "SELECT `uid`, `openid`, `nickname`, `sex`, `city`, `province`, `headimgurl`, `country` FROM `user` WHERE `uid` = :uid";
    $query = $this->_pdo->prepare($sql);    
    $query->execute(array(':uid' => $uid));
    $row = $query->fetch(\PDO::FETCH_ASSOC);
    if($row) {
      return (Object) $row;
    }
    return NULL;
  }

}