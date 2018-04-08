<?php
namespace Admin\Controller;
use Admin\Common\Controller\LC;

class VersionController extends LC {
    /**
     * 增加版本
     */
    public function add(){
        if (!IS_POST){
            header('Content-Type:text/html; charset=utf-8');
            $this->display();
        }
        else{
            if(I('get.AppID') != 0){
                $appinfo = array(
                    array('VersionName','require','版本名不能为空！'),
                    array('Time','require','更新时间不能为空！'),
                    array('Log','require','更新日志不能为空！'),
                );
                $app= M('Versions');
                $VersionID = $app->where(array('AppID'=>I('get.AppID')))->max('VersionID')+1;
                $app->validate($appinfo)->create();
                $app->AppID = I('get.AppID');
                $app->VersionID=$VersionID;
                if($lastInsId = $app->add()){
                    $this->success("添加成功");
                }else{
                    $this->error($app->getError()."添加失败");
                }
            }
        }
    }
    /**
     * 修改版本
     */
    public function modify(){
        if (!IS_POST){
            header('Content-Type:text/html; charset=utf-8');
            $Dao = M("versions");
            $data = array(
                "AppID" => I('get.AppID'),
                "VersionID" => I('get.VersionID'),
            );
            $result = $Dao->where($data)->find();
            if (!$result) {
                $this->error("数据查询出错", U('index'));
            } else {
                $this->assign('data', $result);
                $this->display();
            }
        }
        else {
            $Dao = M("versions");
            $data = array(
                "AppID" => I('get.AppID'),
                "VersionID" => I('get.VersionID'),
            );
            $result = $Dao->create();
            if($lastInsId = $Dao->save()){
                $this->success("修改成功");
            }else{
                $this->error($Dao->getError()."修改失败");
            }
        }
    }

}