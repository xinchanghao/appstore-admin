<?php
namespace Admin\Controller;

use Admin\Common\Controller\LC;

class AjaxController extends LC
{
    public function checkusername($username)
    {
        $condition = array(
            'Username' => $username,
        );
        $user = M('Users')->where($condition)->find();
        if ($user) {
            echo json_encode(array("ret" => 1));
        } else {
            echo json_encode(array("ret" => 0));
        }

    }

    /**
     * 异步判断登录格式
     */
    public function islogin($username)
    {
        $condition = array(
            'Username' => $username,
        );
        $user = M('Users')->where($condition)->find();
        if ($user) {
            echo json_encode(array("ret" => 1));
        } else {
            echo json_encode(array("ret" => 0));
        }

    }
}