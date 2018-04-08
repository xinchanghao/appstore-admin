<?php
namespace Admin\Controller;
use Admin\Common\Controller\LC;
class AppController extends LC {
    /**
     * app列表
     */
    public function index(){
        $app=M("apps");
        $p=getpage($app,C("PAGE_APP_ROW"));
        $UserID=$_SESSION['UserID'];
        $condition['UserID']=$UserID;
        $list = $app->where($condition)->select();
        $page=$p->show();
        $this->assign('list', $list);        // 分页赋值
        $this->assign('page', $page);        // 分页赋值
        $this->display("App/index");
    }
    public function all(){
        //ok
        $app=M("apps");
        $users = M("users");
        $p=getpage($app,C("PAGE_APP_ROW"));
        $list = $app->select();
        for($i=0;$i<count($list);$i++){
            $user = $users->where(array('UserID'=>$list[$i]['UserID']))->find();
            if($user!=null){
                $list[$i]['Username'] = $user['Username'];
            }

        }
        $page=$p->show();
        $this->assign('list', $list);        // 分页赋值
        $this->assign('page', $page);        // 分页赋值
        $this->display("App/index");
    }

    /**
     * 增加app
     */
    public function add(){
        if (!IS_POST){
            header('Content-Type:text/html; charset=utf-8');
            $this->display('App/add');
        }
        else{
            $appinfo = array(
                array('AppName','require','应用名不能为空！'),
                array('SymbolName','require','内部名不能为空！'),
                array('SymbolName','','应用内部名已经存在！',0,'unique',1),
                array('AppStatus','require','状态不能为空！'),
                array('CategoryID','require','类目不能为空！'),
                array('AppDetail','require','应用详情不能为空！'),
            );
            $app= M('apps');
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =       './Public/Uploads/'; // 设置附件上传根目录
            $info   =   $upload->uploadOne($_FILES['Pic']);
            if(!$info) {
                $this->error($upload->getError());
            }else{// 上传成功 获取上传文件信息

                if(!$app->validate($appinfo)->create()){
                    $this->error($app->getError()."添加失败");
                }
                $app->UserID = $_SESSION['UserID'];
                $app->Time = NOW_TIME;
                $app->Pic=$info['savepath'].$info['savename'];
//                echo $app->getLastSql();
//                die();
                if($lastInsId = $app->add()){
                    $this->success("添加成功");
                }else{
                    $this->error($app->getError()."添加失败");
                }
            }
        }
    }
    /**
     * app详情
     */
    public function detail(){
        $data=array(
            "AppID"  => I('path.3')
        );
        $Dao=M("apps");
        $condition['AppID']=$data['AppID'];
        $result = $Dao->where($condition)->find();
        $Dao1=M("versions");
        $result1 = $Dao1->where($condition)->select();
        if(!$result && !$result1){
            $this->error("数据查询出错",U('index'));
        }
        else{
            $this->assign('data',$result);
            $this->assign('vdata',$result1);
            $this->display("App/detail");
        }
    }
    /**
     * 修改app
     */
    public function modify(){
        $data=array(
            "AppID"  => I('path.3')
        );
        $Dao=M("apps");
        $condition['AppID']=$data['AppID'];
        $result = $Dao->where($condition)->find();
        if(!$result){
            $this->error("数据查询出错",U('index'));
        }
        else{
            $this->assign('data',$result);
            $this->display("App/modify");
        }
    }

    /**
     * 删除app
     */
    public function delete(){
        $data=array(
            "AppID"  => I('get.AppID')
        );
        $Dao=M("apps");
        $condition['AppID']=$data['AppID'];
        $result = $Dao->where($condition)->delete();
        if(!$result){
            $this->error("数据删除出错",U('all'));
        }
        else{
            $this->error("App删除成功",U('all'));
        }
    }
    /**
     * 提交修改文件
     */

    public function modifyok(){
        $condition['AppID']=I('AppID');
        $appinfo = array(
            array('AppID','require','应用ID不能为空！'),
            array('AppID','','应用ID已经存在！',0,'unique',1),
            array('AppName','require','应用名不能为空！'),
            array('UserID','require','用户ID不能为空！'),
            array('SymbolName','require','内部名不能为空！'),
            array('SymbolName','','应用内部名已经存在！',0,'unique',1),
            array('AppStatus','require','状态不能为空！'),
            array('CategoryID','require','类目不能为空！'),
            array('AppDetail','require','应用详情不能为空！'),
        );
        $app= M('apps');
            $app->validate($appinfo)->create();
            if ($lastInsId = $app->save()) {
                $this->success("修改成功");
            } else {
                $this->error($app->getError() . "修改失败");
            }
    }
    /**
     * app审核
     */
    public function review($page = 1){
        if(!$this->isAdmin()){
            $this->error("您访问的页面不存在");
        }
        $app = M("apps");
        $p=getpage($app,C("PAGE_REVIEW_ROW"));
        $list = $app->select();
        $page=$p->show();
        $this->assign('list', $list);        // 分页赋值
        $this->assign('page', $page);        // 分页赋值
        $this->display("App/review");
    }

    /**
     * app处理审核
     */
    public function reviewok(){
        $data=array(
            "AppID"  => I('path.3')
        );

        $Dao=M("apps");
        $condition['AppID']=$data['AppID'];
        $data['AppStatus']=1;
        $result = $Dao->where($condition)->save($data);
//        var_dump($result)
//            ;die();
        if(!$result){
            $this->error("数据审核出错");
        }
        else{
            $this->error("App审核成功");
        }

    }


    /**
     * app搜索
     */
    public function search(){
        $appid=I('post.search');
        $Dao = M("apps");
        if($appid){
            $condition['AppName|AppID']=array('like',"%$appid%");
            $result = $Dao->where($condition)->select();
            if(!$result){
                $this->error("您查询的App不存在!",U('index'));
            }
            else{
                $this->assign('list',$result);
                $this->display("App/index");
            }
        }
        else{
            $this->error("您查询操作失败!",U('Admin/searchcourse'));
            return;
        }
    }

}