<?php
namespace Admin\Controller;
use Admin\Common\Controller\LC;

class UserController extends LC{
    /**
     * 用户信息页面
     */
    public function index(){
        if(!$this->isAdmin()){
            $this->error("您访问的页面不存在");
        }
        $users = M("users");
        $p=getpage($users,C("PAGE_USER_ROW"));
        $list = $users->select();
        $page=$p->show();
        $this->assign('list', $list);        // 分页赋值
        $this->assign('page', $page);        // 分页赋值
        $this->display();
    }

    /**
     * 修改用户信息页面
     * @param $UserID 管理员可以指导UserID进行修改，用户默认自己的ID
     */
    public function modify($UserID =0){
        if(IS_POST){
            if($UserID == 0 || !$this->isAdmin()) {
                $UserID = $_SESSION['UserID'];
            }
            if(I('post.submit') == 'chpw'){
                $Users = M('Users');
                $password1=I('post.password1');
                $password2=I('post.password2');
                $password3=I('post.password3');
                $Password= $Users->where("UserID=$UserID")->getField('Password');
                if($password1!=$Password||$password3!=$password2||$password2=="")
                {
                    $this->error("修改密码出错(请检查输入内容！！)",U('User/modify'));
                }

                $Users->Password=$password2;
                $Users->where("UserID=$UserID")->save();
                $this->success('密码修改成功');
            }else if(I('post.submit') == 'chpf'){
                $Name=I('post.Name');
                $Email=I('post.Email');
                if($Name==""||$Email=="")
                {
                    $this->error("修改信息出错(请检查输入内容！！)",U('User/modify'));
                }
                $Users = M('Users');
                $Users->Name=$Name;
                $Users->Email=$Email;
                //$Users->create();
                $Users->where("UserID=$UserID")->save();
                $this->success('用户信息修改成功');
            }
            return;
        }

        if($UserID == 0 || !$this->isAdmin()) {
            $UserID = $_SESSION['UserID'];
        }
        $users = M("users");
        $condition['UserID']=$UserID;
        $user = $users->where($condition)->find();
        $this->assign('data',$user);
        $this->display();
    }

    public function info(){
        $users = M("users");
        $condition['UserID']=$_SESSION['UserID'];
        $user = $users->where($condition)->find();
        $this->assign('data',$user);
        $this->display();
    }



}