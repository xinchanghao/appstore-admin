<?php
namespace Admin\Common\Controller;

use Think\Controller;

/**
 * Class LC
 * @package Common\Controller
 * 用户已登录--公共控制器
 */
class LC extends Controller
{
    public function _initialize()
    {
        if ($_SESSION['loginid'] != C('USER_AUTH_KEY')) {
            redirect(U('Public/login'));
        }
        $this->assign('UserID', $_SESSION['UserID']);
        $this->assign('Username', $_SESSION['Username']);
        $this->assign('Name', $_SESSION['Name']);
        $this->assign('isAdmin',$this->isAdmin());
    }
    /*
     * 检查是否管理员
     */
    public function isAdmin(){
        if ($_SESSION['Permission'] == 1){
            return true;
        }else{
            return false;
        }
    }
}