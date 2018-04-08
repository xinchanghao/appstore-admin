<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
    /**
     * 注册处理
     */
    public function dealreg(){
        header('Content-Type:text/html; charset=utf-8');
        if (!IS_POST){
            $this->error("您访问的页面不存在");
        }
        $rules = array(
            array('Username','require','帐号不能为空！'),
            array('Username','','帐号名称已经存在！',0,'unique',1),
            array('Password','require','密码不能为空！'),
            array('Email','email','邮箱出错'),
        );
        $Users = M('Users');
        if(!$Users->validate($rules)->create())
        {
            //exit($Users->getError());
            $this->error($Users->getError().'注册失败',U('register'));
        }
        $Users->Permission = 2;     //默认开发者权限   1.管理员 2.开发者
        $Users->RegTime = date('Y-m-d H:i:s',time());       //注册时间
        if($lastInsId = $Users->add()){
            $this->success('注册成功，页面跳转中...',U('login'));
        }else{
            $this->error($Users->getError().'注册失败',U('register'));
        }

    }
    /**
     * 注册
     */
    public function register(){
        header('Content-Type:text/html; charset=utf-8');
        $this->display();

    }
    /**
     * 登录
     */
    public function login(){
        header('Content-Type:text/html; charset=utf-8');
        $this->display('Public/login');
    }

    /**
     * 处理登录
     */
    public function deallogin(){
        if (!IS_POST) {
            $this->error("您访问的页面不存在");
        }
        $Username=I('post.username');
//        $Password=md5(C('PW_Salt').I('post.password','','md5'));
        $Password =I('post.password');
        $condition = array(
            'Username' => $Username,
            'Password'=> $Password
        );
        $user=M("users");
        $result=$user->where($condition)->find();
        if($result){
            $_SESSION['loginid']=C('USER_AUTH_KEY');//记录认证标记，
            $_SESSION['UserID']=$result['UserID'];//用户ID标记；
            $_SESSION['Username']=$result['Name'];//用户登录时间标记
            $_SESSION['Permission'] = $result['Permission'];
//            if($result['Permission']=='on'){
//                cookie('uid',$Userid,30*24*3600);
//                cookie('uname',$Username,30*24*3600);
//            }
            header('Content-type:text/html;Charset=UTF-8');
            $this->success('登录成功',U('Index/index'));
        }else{
            header('Content-type:text/html;Charset=UTF-8');
            $this->error($user->getError().'登录失败',U('Public/login'));
        }
    }

    /**
     * 注销
     */
    public function logout(){
        $_SESSION = array(); //清除SESSION值.
        if(isset($_COOKIE[session_name()])){  //判断客户端的cookie文件是否存在,存在的话将其设置为过期.
            setcookie(session_name(),'',time()-1,'/');
        }
        session_destroy();  //清除服务器的sesion文件
        $this->success('退出成功',U('Index/index'));
    }

    /**
     * 邮箱
     */
    public function email(){
        header('Content-Type:text/html; charset=utf-8');
        $this->display("Index/email");

    }

    /**
     * 帮助
     */
    public function help(){
        header('Content-Type:text/html; charset=utf-8');
        $this->display("Index/help");

    }

}