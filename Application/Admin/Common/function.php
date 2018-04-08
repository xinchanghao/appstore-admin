<?php
/**
 * Created by PhpStorm.
 * User: Xinhao
 * Date: 2016/6/10
 * Time: 19:16
 */


/**
 * 获取分页
 *
 */
    function getpage($m,$pagesize){
        $count = $m->count();
        $p=new Think\Page($count,$pagesize);
        $p->lastSuffix=false;
        $p->setConfig('header','<a class="rows pull-right" style="height: 40px;line-height: 40px;color: #1a1a1a">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</a>');
        $p->setConfig('prev','上一页');
        $p->setConfig('next','下一页');
        $p->setConfig('last','末页');
        $p->setConfig('first','首页');
        $p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p->parameter=I('get.');
        $m->limit($p->firstRow,$p->listRows);
        return $p; // 返回一个数组;
    }

/**
 * 文件上传
 *
 */
        function upload(){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
            // 上传单个文件
            $info   =   $upload->uploadOne($_FILES['photo1']);
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功 获取上传文件信息
                echo $info['savepath'].$info['savename'];
            }
        }